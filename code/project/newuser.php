<?php
	require "authentication.php";
	$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"]) ){
		echo "Cross site request forgery is detected.";
		die();
	}
	function adduser($username, $password){
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$sql = "INSERT INTO users VALUES (0, ?, password(?));";
		global $mysqli;
		$stmt = $mysqli->stmt_init();
		if(!$stmt->prepare($sql))   echo "Prepare failed";
		$stmt->bind_param("ss", $username, $password);
		if(!$stmt->execute()) echo "Execute failed ";


		if($stmt == TRUE){
			echo "New username '$username' has been added";
		}else
		{
			echo "Failed to add the user '$username' Error: " .$mysqli->error;
		}

		
	}


	$username = $_POST["newusername"];
	$password = $_POST["newpassword"];
	if(isset($username) and isset($password)){
		adduser($username, $password);
	}
		
?>

<br>
<br>
<a href='index.php'>Home</a>
