<?php
if (!isset($_GET["file"])) {
	exit;
}
?>
<!DOCKTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8">
		<title>470Cloud // Dateien // Editor</title>
		<link rel="stylesheet" type="text/css" href="../../assets/css/editor.css">
		<style>
			#content {
				width: 90%;
				height: 500px;
				text-align: left;
				padding: 10px;
				vertical-align: top;
			}
		</style>
	</head>
	<body>
		<div class="msg-box">
			<div id="error"></div>
		</div>
		<div id="js-tmp" style="display: none;"><?php echo $_GET["file"]; ?></div>
		<div class="header">
			<h1><?php echo $_GET["file"]; ?></h1>
		</div>
		<hr>
		<div class="content">
			<?php
			ini_set("display_errors", 1);
			ini_set("display_startup_errors", 1);
			error_reporting(E_ALL);

			define("PATH", "../../");

			require "../../assets/admin.php";
			$session = new loginManager();

			if (!$session->checkLogin()) {
				header("Location: ../../login.php");
				exit;
			}
	

			$file = $_GET["file"];

			$array = [
    			"text/plain",
    			"text/html",
    			"text/css",
    			"text/javascript",
    			"text/xml",
    			"text/csv",
    			"application/javascript",
    			"application/json",
    			"application/xml",
    			"application/x-php",
    			"application/sql",
   				"application/x-sh",
   	 			"application/x-python",
    			"application/x-markdown",
				"application/x-empty"
			];

			$type = mime_content_type("../../data/users/" . $session->getUserName() . "/files/root/" . $file);
			echo $type;
			

			if (in_array($type, $array)) {
				
				echo '
				<script src="text.js"></script>
				<div class="editor">
					<input type="text" id="content" value="' . file_get_contents("../../data/users/" . $session->getUserName() . "/files/root/" . $file) . '">
				</div>';
			}else{
				echo 'hallo';
			}
			echo "../../data/users/" . $session->getUserName() . "/files/root" . $file;
			?>
		</div>
		<div class="buttons">
			<button onclick="save()">Speichern</button>
			<a href="../files">
				<button>Abbrechen</button>
			</a>
		</div>
	</body>
</html>