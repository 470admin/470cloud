<?php
require "../../../assets/admin.php";

if (isset($_GET["id"]) && isset($_GET["name"])) {
	$name = $_GET["name"];
	$id = intval($_GET["id"]);
	$user = $_COOKIE["username"];
	
	require "../../../assets/db.php";
	
	$sql = "UPDATE files SET name = ? WHERE id = ? AND user = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sis", $name, $id, $user);
	
	if ($stmt->execute()) {
		echo '{"status":200}';
	}else{
		echo '{"status":500}';
	}
	
	$stmt->close();
	$conn->close();
}
?>