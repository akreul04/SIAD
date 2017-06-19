
<html>
	<h1>Add a new post</h1>
<?php
	//some code here
	require "authentication.php";
	//echo "Current time: " . date("Y-m-d h:i:sa");
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	//echo "\$rand = $rand";
	$_SESSION["fucsrf"] = $rand;
?>
		<form action="newpost.php" method="POST" class="form post">
			<input type="hidden" name="secrettoken" value="<?php echo $rand;?>"/>
			Title:<input type="text" name="post_title" /> <br>
			Content: <input type="text" name="content" /> <br>
			<button class="button" type="submit">
				Add Post
			</button>
		</form>
</html>
