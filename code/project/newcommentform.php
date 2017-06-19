
<html>
	<h1>Add a new comment</h1>
<?php
	session_start();
	//some code here
	//require "authentication.php";
	//echo "Current time: " . date("Y-m-d h:i:sa");
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
