<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "../../../assets/admin.php";

if (isset($_GET["id"])) {
	require "../../../assets/db.php";
	$id = intval($_GET["id"]);
	
	$sql = "SELECT user FROM reminders WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	
	if (!$row["user"] == $_COOKIE["username"]) {
		$stmt->close();
		$conn->close();
		die('{"status":500}');
	}else{
		$sql = "UPDATE reminders SET trash = 1 WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $id);
		
		if (!$stmt->execute() === TRUE) {
			$stmt->close();
			$conn->close();
			die('{"status":500}');
		}else{
			$stmt->close();
			$conn->close();
			die('{"status":200}');
		}
	}
}
?>