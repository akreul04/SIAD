<?php
	require "authentication.php";
	$secrettoken = $_POST["secrettoken"];
	//echo "debug> \$secrettoken = $secrettoken <br> \$_SESSION[\"fucsrf\"]=" . $_SESSION["fucsrf"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["fucsrf"]) ){
		echo "Cross site request forgery is detected.";
		die();
	}
	function adduser($username, $password){
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
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


	$username = $_POST["newusername"];
	$password = $_POST["newpassword"];
	echo "debug> NewUsername= $username; Newpassword=$password <br>";
	if(isset($username) and isset($password)){
		adduser($username, $password);
	}
		
?>
