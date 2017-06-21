
<html>
	<h1>Comments</h1>
<?php
	session_start();
	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}
	$sql = "SELECT username, content FROM comments INNER JOIN users on comments.userid = users.userid where postid = " . $_GET['postid'];
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

<br>
<br>
<a href='index.php'>Home</a>
</html>
