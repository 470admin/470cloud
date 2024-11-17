<?php
/*
 * These Script remove a file.
*/

//Check Login
define("PATH", "../../../");

require "../../../assets/admin.php";
$session = new loginManager();
if (!$session->checkLogin()) {
	die('{"status":500, "error":"Bitte lade die Seite neu."}');
}

//Ckeck File
if (isset($_GET["name"])) {
    $name = $_GET["name"];
	if (!is_file("../" . $name)) {
		die('{"status":500, "error":"Die Datei ' . basename($name) . ' exestiert nicht."}');
	}
	
	//Remove File
    if (unlink("../" . $name)) {
		echo '{"status":200}';
	}else{
		echo '{"status":500, "error":"Fehler beim löschen der Datei."}';
	}
}else{
    echo '{"status":400, "error": "Fehler beim übertragen der Datei ID."}';
}
?>
