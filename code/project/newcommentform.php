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
    <div class="col-sm-9">
      <h4><small>COMMENTS</small></h4>
<?php
	session_start();
	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}
	$postid = htmlentities($_GET['postid']);
	$sql = "SELECT username, content FROM comments INNER JOIN users on comments.userid = users.userid where postid = " . $postid;
	$stmt = $mysqli->stmt_init();
	if(!$stmt->prepare($sql)){
		echo "Prepare failed";
	}
	if(!$stmt->execute()){
		echo "Execute failed";
	}
	$stmt->bind_result($username, $content);
	$num_rows = 0;
		while($stmt->fetch()){
			$num_rows++;
			echo "<h3>Comment " .$num_rows. "-" . "</h3><br>";
			echo htmlentities($content) . "<br>";
			echo "<br>";
			echo "Posted by " . htmlentities($username);
			echo "<br>";
			
			
		}
	
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	
	$_SESSION["nocsrf"] = $rand;
	
?>
		<h3>Add a new comment</h3>
		<form action="newcomment.php" method="POST" class="form comment">
			<input type="hidden" name="secrettoken" value="<?php echo $rand;?>"/>
			<input type ="hidden" name="postid" value="<?php echo $_GET['postid'];?>" />
			Comment: <input type="text" name="post_comment" /> <br>
			<button class="button" type="submit">
				Add Comment
			</button>
		</form>

</body>
</html>
