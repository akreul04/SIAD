<?php
	require "authentication.php";
	
	$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"])){
		echo "Cross site request forgery is detected.";
		die();
	}

	function changepasswd($username, $password){
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$sql = "UPDATE users SET password =  password(?) WHERE username = ?;";
		
		
		global $mysqli;
		if(!($stmt = $mysqli->prepare($sql))) echo "Prepare failed";
		$stmt->bind_param("ss",$password, $username);
		if(!$stmt->execute()) echo "Execute failed";
		if(!$stmt->store_result()) echo "Get result failed";
		


		if($stmt == TRUE){
			echo "Password for '$username' has been updated";
		}else
		{
			echo "Failed to change for the password for '$username' Error: " .$mysqli->error;
		}

		
	}


	$username = $_SESSION["username"];
	$password = $_POST["newpassword"];
	if(isset($username) and isset($password)){
		changepasswd($username, $password);
	}
		
?>

<br>
<br>
<a href='index.php'>Home</a>
