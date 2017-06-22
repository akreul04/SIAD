
<html>
	<h1>Delete post</h1>
<?php

	require "authentication.php";
	$postid = htmlentities($_GET['postid']);
	$sql = "SELECT title, content FROM posts where postid = ?";
	$stmt = $mysqli->stmt_init();
	if(!$stmt->prepare($sql))   echo "Prepare failed";
	$stmt->bind_param('i', $postid);
	if(!$stmt->execute()) echo "Execute failed ";
	$stmt->bind_result($title, $content);
	while($stmt->fetch()){
		
	}

	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	$_SESSION["nocsrf"] = $rand;
	
?>
		<form action="deletepost.php" method="POST" class="form login">
			<input type="hidden" name="secrettoken" value="<?php echo $rand;?>"/>
			<input type ="hidden" name="postid" value="<?php echo $_GET['postid'];?>"/>
			Title: <input type="text" name="title" disabled value="<?php echo $title;?>"/> <br>
			Content: <input type="text" name="content" disabled value="<?php echo $content;?>"  /> <br>
			<button class="button" type="submit">
				Delete
			</button>
		</form>

<br>
<br>
<a href='index.php'>Home</a>
</html>


