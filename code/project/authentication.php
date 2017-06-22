
<?php
	session_set_cookie_params(1200);
	session_start();
	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}

	function checklogin($username, $password){
		$sql = "SELECT * FROM users WHERE username = ? AND password = password(?);";
		global $mysqli;
		if(!($stmt = $mysqli->prepare($sql))) echo "Prepare failed";
		$stmt->bind_param("ss",$username,$password);
		if(!$stmt->execute())   echo "Execute failed";
		if(!$stmt->store_result()) echo "Get result failed";

		if($stmt->num_rows == 1 ){
                        return TRUE;
                }
                return FALSE;
	}

	if(isset($_POST["username"]) and isset($_POST["username"])){
			$username = mysql_real_escape_string($_POST["username"]);
			$password = mysql_real_escape_string($_POST["password"]);
		
		if(checklogin($username, $password)){
			echo "Valid username and password! Welcome! <br>";
			$_SESSION["logged"] = TRUE;
			$_SESSION["username"] = $username;
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
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
		die();
	}

?>


