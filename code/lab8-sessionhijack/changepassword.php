<?php
	require "authentication.php";

	function changepasswd($username, $password){
		$sql = "UPDATE users SET password =  password('$password') WHERE username = '$username';";
		//just debug
		echo "sql = $sql";
		global $mysqli;
		$result = $mysqli->query($sql);


		if($result == TRUE){
			echo "Password for '$username' has been updated";
		}else
		{
			echo "Failed to change for the password for '$username' Error: " .$mysqli->error;
		}

		
	}


	$username = $_SESSION["username"];
	$password = $_REQUEST["newpassword"];
	echo "debug> NewUsername= $username; Newpassword=$password <br>";
	if(isset($username) and isset($password)){
		changepasswd($username, $password);
	}
		
?>
