
<html>
	<h1>Edit post</h1>
<?php
	//some code here
	require "authentication.php";
	$titlesql = "SELECT title FROM posts where postid = " . $_GET['postid'];
	$contentsql = "SELECT content FROM posts where postid = " . $_GET['postid'];
	$titleresult = $mysqli->query($titlesql);
	$contentresult = $mysqli->query($contentsql);
	while($row = $titleresult->fetch_assoc()){
		$title = $row["title"];
	}
	while($row = $contentresult->fetch_assoc()){
		$content = $row["content"];
	}
	
?>
		<form action="editpost.php" method="POST" class="form login">
			<input type ="hidden" name="postid" value="<?php echo $_GET['postid'];?>"/>
			Title: <input type="text" name="title" value="<?php echo $title;?>"/> <br>
			Content: <input type="text" name="content" value="<?php echo $content;?>"  /> <br>
			<button class="button" type="submit">
				Update
			</button>
		</form>
</html>
