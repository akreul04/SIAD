<?php
	require "authentication.php";
	$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"]) ){
		echo "Cross site request forgery is detected.";
		die();
	}
	function addpost($title, $content){
		$title = mysql_real_escape_string($title);
		$content = mysql_real_escape_string($content);
		$sql = "INSERT INTO posts VALUES (0, 2, '$title', '$content', NOW());";
		//just debug
		echo "sql = $sql";
		global $mysqli;
		$result = $mysqli->query($sql);


		if($result == TRUE){
			echo "New post '$title' has been added";
		}else
		{
			echo "Failed to add the post '$title' Error: " .$mysqli->error;
		}

		
	}


	$title = $_POST["post_title"];
	$content = $_POST["content"];
	echo "debug> New post name= $title; content=$content <br>";
	if(isset($title) and isset($content)){
		addpost($title, $content);
	}
		
?>
