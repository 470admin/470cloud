<?php
require "../../../assets/admin.php";

if (isset($_GET["id"])) {
	require "../../../assets/db.php";
	
	$id = intval($_GET["id"]);
	
	$sql = "SELECT * FROM reminders WHERE user = ? AND id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("si", $_COOKIE["username"], $id);
	$stmt->execute();
	
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	
	if ($result->num_rows <= 0) {
		echo '{"status":500}';
	}else{
		$info["name"] = $row["name"];
		$info["date"] = $row["date"];
		$info["id"] = $row["id"];
		echo json_encode($info);
	}
	
	$stmt->close();
	$conn->close();
}
?>