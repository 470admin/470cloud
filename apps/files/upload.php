<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../../assets/admin.php";

if (isset($_POST["submit"])) {
    require "../../assets/db.php";

    if (isset($_FILES["data"]) && $_FILES["data"]["error"] === UPLOAD_ERR_OK) {
        $name = $_FILES["data"]["name"];
        $tmp_name = $_FILES["data"]["tmp_name"];

        if (!empty($tmp_name)) {
            $content_type = mime_content_type($tmp_name);
        } else {
            die("Fehler: Temporärer Dateiname ist leer.");
        }

        $user = $_COOKIE["username"];
        $folder = isset($_POST["folder"]) ? $_POST["folder"] : "";

        if (!empty($folder)) {
            $root = $folder . "/" . $name;
            $path = "../../data/users/" . $user . "/files/root/" . $root;
        } else {
            $root = $name;
            $path = "../../data/users/" . $user . "/files/root/" . $root;
        }

        $dir = dirname($path);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                die("Fehler: Konnte Verzeichnis nicht erstellen.");
            }
        }

        if (move_uploaded_file($tmp_name, $path)) {
            $sql = "INSERT INTO files (name, type, content_type, user, root) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Fehler: Konnte SQL-Abfrage nicht vorbereiten.");
            }
			$type = "file";
            $stmt->bind_param("sssss", $name, $type, $content_type, $user, $root);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $conn->close();
                header("Location: ../files/?error=false");
                exit;
            } else {
                $stmt->close();
                $conn->close();
                header("Location: ../files/?error=true");
                exit;
            }
        } else {
            $error_message = 'Fehler beim Verschieben der Datei. ';
            if (!is_writable($dir)) {
                $error_message .= 'Das Verzeichnis ist nicht beschreibbar.';
            } else {
                $error_message .= 'Überprüfen Sie den Pfad: ' . $path;
            }
            error_log($error_message);
            $conn->close();
            header("Location: ../files/?error=true");
            exit;
        }
    } else {
        $error_message = 'Fehler beim Hochladen der Datei. ';
        switch ($_FILES["data"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
                $error_message .= "Die hochgeladene Datei überschreitet die upload_max_filesize Direktive in php.ini.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $error_message .= "Die hochgeladene Datei überschreitet die MAX_FILE_SIZE Direktive, die im HTML-Formular angegeben wurde.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_message .= "Die Datei wurde nur teilweise hochgeladen.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_message .= "Es wurde keine Datei hochgeladen.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $error_message .= "Fehlendes temporäres Verzeichnis.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $error_message .= "Fehler beim Schreiben der Datei auf die Festplatte.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $error_message .= "Eine PHP-Erweiterung hat den Datei-Upload gestoppt.";
                break;
            default:
                $error_message .= "Unbekannter Fehler.";
                break;
        }
        error_log($error_message);
        header("Location: ../files/?error=true");
        exit;
    }
}
?>