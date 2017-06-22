<!DOCTYPE html>
<html lang="en">
<head>
  <title>Adam's SIAD Blog</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>

<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Adam's SIAD Blog</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="index.php">Home</a></li>
      </ul><br>
    </div>


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
		if(isset($_SESSION["logged"])){
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
			}else{
				echo "Failed to add the comment '$comment' Error: " .$mysqli->error;
			}
		}else{
			$username = "guest";
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
			}else{
				echo "Failed to add the comment '$comment' Error: " .$mysqli->error;
			}
		}
		
	}


	
	$comment = htmlspecialchars($_POST["post_comment"]);
	$postid = htmlspecialchars($_POST["postid"]);
	if(isset($postid, $comment)){
		addcomment($postid, $comment);
	}
		
?>

</body>
</html>
