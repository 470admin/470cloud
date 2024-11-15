<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("PATH", "../../../");

require "../../../assets/admin.php";
$session = new loginManager();
if (!$session->checkLogin()) {
	header("Location: ../../../login.php");
	exit;
}else{
	$session->createNewSession();
}

if (isset($_GET["name"])) {
    $name = $_GET["name"];
    
    unlink("../" . $name);
} else {
    echo '{"status":400, "error": "ID not set"}';
}
?>