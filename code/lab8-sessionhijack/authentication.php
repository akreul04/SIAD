
<?php
	session_set_cookie_params(1200);
	session_start();
	$mysqli = new mysqli('localhost', 'SIAD_lab7', 'secretpass', 'SIAD_lab7');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}

	function checklogin($username, $password){
		$sql = "SELECT * FROM users WHERE username = '$username' AND password = password('$password');";
		//just debug
		echo "sql = $sql";
		global $mysqli;
		$result = $mysqli->query($sql);


		if($result ->num_rows == 1){
			return TRUE;
		}
		return FALSE;
	}

//move this to new index.php, add require authenticiation.php

	echo "Index page<br>\n";
	//store a login session in $_SESSION["logged"]

		//header("refresh: 1; url = login.php");
		//echo "You have not logged in<br>";  
		//echo "debug> Username = $username; password=$password";
	if(isset($_REQUEST["username"]) and isset($_REQUEST["username"])){
			$username = mysql_real_escape_string($_REQUEST["username"]);
			$password = mysql_real_escape_string($_REQUEST["password"]);
		
		if(checklogin($username, $password)){
			echo "Valid username and password! Welcome! <br>";
			$_SESSION["logged"] = TRUE;
			$_SESSION["username"] = $username;
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
			$_SESSION["browser2"] = $_SERVER["REMOTE_ADDR"];
			$_SESSION["browser3"] = $_SERVER["HTTP_ACCEPT"];
			//echo "DEBUG \$_SESSION[\"browser\"] = " . $_SESSION["browser"];
		}else{
			header("refresh: 1; url = login.php");
			echo "Invalid username or password";
			session_destroy();
		}
	}
	
	if(!isset($_SESSION["logged"])){
		header("refresh: 1; url = login.php");
		echo "You have not logged in <br>";
		session_destroy();
		
	}

	if ( $_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
		echo "Session hijacking is detected";
		die();
	}

	if ( $_SESSION["browser2"] != $_SERVER["REMOTE_ADDR"]){
		echo "Session hijacking is detected";
		die();
	}

	if ( $_SESSION["browser3"] != $_SERVER["HTTP_ACCEPT"]){
		echo "Session hijacking is detected";
		die();
	}
?>


