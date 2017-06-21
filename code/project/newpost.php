<?php
	require "authentication.php";
	$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"]) ){
		echo "Cross site request forgery is detected.";
		die();
	}

	function addpost($title, $content){
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

		$title = mysql_real_escape_string($title);
		$content = mysql_real_escape_string($content);
		$sql2 = "INSERT INTO posts VALUES (0, ?, ?, ?, NOW());";
		$stmt2 = $mysqli->stmt_init();
		if(!$stmt2->prepare($sql2))   echo "Prepare failed";
		$stmt2->bind_param("iss", $userid, $title, $content);
		if(!$stmt2->execute()) echo "Execute failed ";


		if($stmt2 == TRUE){
			echo "New post '$title' has been added";
		}else
		{
			echo "Failed to add the post '$title' Error: " .$mysqli->error;
		}

		
	}


	$title = $_POST["post_title"];
	$content = $_POST["content"];
	if(isset($title) and isset($content)){
		addpost($title, $content);
	}
		
?>

<br>
<br>
<a href='index.php'>Home</a>
