<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../../../assets/admin.php";
$session = new loginManager();
if (!$session->checkLogin()) {
	die('{"status":500, "error":"Du bist nicht angemeldet. <br>Bitte lade die Seite neu."}');
}

if (isset($_GET["name"])) {
	require "../../../assets/db.php";
	
	$name = $_GET["name"];
	$user = $session->getUserName();
	
	if (isset($_GET["folder"])) {
		$sql = "INSERT INTO files (
	}
	
	$stmt->close();
	$conn->close();
}
?>