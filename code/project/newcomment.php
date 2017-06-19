<?php
	//require "authentication.php";
	session_start();
	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}
	$secrettoken = $_POST["secrettoken"];
	echo "nocsrf: " . $_SESSION["nocsrf"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"])){
		echo "Cross site request forgery is detected.";
		die();
	}
	function addcomment($postid, $comment){
		$comment = mysql_real_escape_string($comment);
		$postid = mysql_real_escape_string($postid);
		$sql = "INSERT INTO comments VALUES (0, $postid, 2, '$comment', NOW());";
		//just debug
		echo "sql = $sql";
		global $mysqli;
		$result = $mysqli->query($sql);


		if($result == TRUE){
			echo "New comment '$comment' has been added";
		}else
		{
			echo "Failed to add the comment '$comment' Error: " .$mysqli->error;
		}

		
	}


	
	$comment = $_POST["post_comment"];
	$postid = $_POST["postid"];
	echo "comment = $comment <br>";
	echo "postid: =  $postid";
	if(isset($postid, $comment)){
		addcomment($postid, $comment);
	}
		
?>
