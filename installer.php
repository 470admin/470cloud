<?php
/* 470Cloud Installer
* Authors:
* Marc Goering
*/

//Select Version
define("VERSION", "latest");

//Install
if (isset($_GET["install"])) {
	$url = "https://470cloud.com/downloads/cloud/" . VERSION . ".zip";
	
	file_put_contents("package.zip", fopen($url, "r"));
	
	//Unzip
	$zip = new ZipArchive;
	if ($zip->open("package.zip") === TRUE) {
    	$zip->extractTo(__DIR__);
    	$zip->close();
    	header ("https://" . $_SERVER["HTTP_HOST"]);
		exit;
	}else{
		$error = "Fehler beim öffnen der ZIP Datei.";
	}
	
	//Remove
	unlink("package.zip");	
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>470Cloud Installer</title>
    <style>
        body {
            background-image: url("https://470cloud.marc-goering.de/background.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #000000;
            margin: 0;
            padding: 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);
            width: 100%;
            height: 100%;
            z-index: 10;
            padding: 0;
            margin: 0;
        }

        .content {
            width: auto;
            height: auto;
            position: relative;
            z-index: 20;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            margin: 20px;
            border-radius: 10px; 
        }

        #header, 
        #info, 
        #install-button {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="content">
        <div id="header">
            <h1>470Cloud Installer</h1>
            <p>Willkommen bei 470Cloud!</p>
        </div>
        <div id="info">
            <span>
                Pfad: <?php echo __DIR__; ?><br>
                Version: <?php echo VERSION; ?><br>
            </span>
        </div>
        <div id="install-button">
            <a href="?install=true">
                <button>Installieren</button>
            </a>
        </div>
    </div>
</body>
</html>