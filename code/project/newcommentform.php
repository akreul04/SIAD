
<html>
	<h1>Add a new comment</h1>
<?php
	session_start();
	//some code here
	//require "authentication.php";
	//echo "Current time: " . date("Y-m-d h:i:sa");
	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}
	$sql = "SELECT * FROM comments where postid = " . $_GET['postid'];
	$result = $mysqli->query($sql);
	echo "sql = $sql";
	if($result->num_rows > 0){
		//output data of each row
		while($row = $result->fetch_assoc()){
			$commentid = $row["commentid"];
			echo "<h3>Comment " .$commentid. "-" . "</h3><br>";
			echo $row["content"]."<br>";
			//echo "<a href='newcommentform.php?postid=$postid'>;";
			//$sql = "SELECT * FROM comments WHERE postid=$postid;";
			//$comments = $mysqli->query($sql);
			//if($comments->num_rows>0){
			//	echo $comments->num_rows. "comments </a>";
			//}else{
			//	echo "Post your first comment </a>";
			//}
		}
	}
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	//echo "\$rand = $rand";
	$_SESSION["nocsrf"] = $rand;
	echo "nocsrf: " . $_SESSION["nocsrf"];
?>
		<form action="newcomment.php" method="POST" class="form comment">
			<input type="text" name="secrettoken" value="<?php echo $rand;?>"/>
			<input type ="hidden" name="postid" value="<?php echo $_GET['postid'];?>" />
			Comment: <input type="text" name="post_comment" /> <br>
			<button class="button" type="submit">
				Add Comment
			</button>
		</form>
</html>