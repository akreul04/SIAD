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
	<li><a href="newpostform.php">New Post</a></li>
	<li><a href="newuserform.php">Add User</a></li>
	<li><a href="changepasswordform.php">Change Password</a></li>
	<li><a href="logout.php">Logout</a></li>
      </ul><br>
    </div>
    <div class="col-sm-9">
      <h4><small>ADMIN</small></h4>


<?php
	require "authentication.php";

	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	$_SESSION["nocsrf"] = $rand;
	
	
	

	$sql = "SELECT postid, title, content FROM posts INNER JOIN users ON posts.userid=users.userid WHERE username=" . "'" . $_SESSION["username"] . "'";
	$stmt = $mysqli->stmt_init();
	if(!$stmt->prepare($sql)){
		echo "Prepare failed";
	}
	if(!$stmt->execute()){
		echo "Execute failed";
	}
	$stmt->bind_result($postid, $title, $content);
	$num_rows = 0;
		while($stmt ->fetch()){
			$num_rows++;
			echo "<h3>Post " .$num_rows. "-" .htmlentities($title). "</h3><br>";
			echo htmlentities($content)."<br>";
			echo "<a href='editpostform.php?postid=$postid'>Edit</a>";
			echo "<br>";
			echo "<a href='deletepostform.php?postid=$postid'>Delete</a>";
		}
	
	if($num_rows == 0)
		echo "No posts yet!";
	

?>




	

	

</html>
