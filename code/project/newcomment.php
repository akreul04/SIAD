<?php
	session_start();

	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}

	$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"])){
		echo "Cross site request forgery is detected.";
		die();
	}

	function addcomment($postid, $comment){
		$username = $_SESSION["username"];
		$sql = "SELECT userid FROM users WHERE username=?";
		global $mysqli;
		$stmt = $mysqli->stmt_init();
		if(!$stmt->prepare($sql))   echo "Prepare failed";
		$stmt->bind_param('s', $username);
		if(!$stmt->execute()) echo "Execute failed ";
		$stmt->bind_result($userid);
		while ($stmt->fetch()){
             
        	}
		$comment = mysql_real_escape_string($comment);
		$postid = mysql_real_escape_string($postid);
		$sql2 = "INSERT INTO comments VALUES (0, ?, ?, ?, NOW());";
		$stmt2 = $mysqli->stmt_init();
		if(!$stmt2->prepare($sql2))   echo "Prepare failed";
		$stmt2->bind_param("iis", $postid, $userid, $comment);
		if(!$stmt2->execute()) echo "Execute failed ";


		if($stmt2 == TRUE){
			echo "New comment '$comment' has been added";
		}else
		{
			echo "Failed to add the comment '$comment' Error: " .$mysqli->error;
		}

		
	}


	
	$comment = $_POST["post_comment"];
	$postid = $_POST["postid"];
	if(isset($postid, $comment)){
		addcomment($postid, $comment);
	}
		
?>

<br>
<br>
<a href='index.php'>Home</a>
