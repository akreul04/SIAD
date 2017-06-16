<?php
	require "authentication.php";

	function adduser($username, $password){
		$sql = "INSERT INTO users VALUES ('$username', password('$password'));";
		//just debug
		echo "sql = $sql";
		global $mysqli;
		$result = $mysqli->query($sql);


		if($result == TRUE){
			echo "New username '$username' has been added";
		}else
		{
			echo "Failed to add the user '$username' Error: " .$mysqli->error;
		}

		
	}


	$username = $_REQUEST["newusername"];
	$password = $_REQUEST["newpassword"];
	echo "debug> NewUsername= $username; Newpassword=$password <br>";
	if(isset($username) and isset($password)){
		adduser($username, $password);
	}
		
?>
