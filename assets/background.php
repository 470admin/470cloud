<?php
define("PATH", "../");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "admin.php";
$session = new loginManager();
if (!$session->checkLogin()) {
	exit;
}

require "db.php";

if (isset($_GET["user"])) {
    $user = $_GET["user"];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    
    if ($result) {
        $bg = json_decode($result["bg"], true);
        header('Content-Type: ' . $bg["content-type"]);
        readfile('../data/backgrounds/' . $bg["name"]);
    } else {
        header('HTTP/1.0 404 Not Found');
        echo "User not found.";
    }
    
    $stmt->close();
    $conn->close();
} else {
    header('HTTP/1.0 400 Bad Request');
    echo "User parameter is missing.";
}
?>