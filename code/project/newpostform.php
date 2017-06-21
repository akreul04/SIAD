
<html>
	<h1>Add a new post</h1>
<?php
	require "authentication.php";
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	$_SESSION["nocsrf"] = $rand;
?>
		<form action="newpost.php" method="POST" class="form post">
			<input type="hidden" name="secrettoken" value="<?php echo $rand;?>"/>
			Title:<input type="text" name="post_title" /> <br>
			Content: <input type="text" name="content" /> <br>
			<button class="button" type="submit">
				Add Post
			</button>
		</form>

<br>
<br>
<a href='index.php'>Home</a>
</html>
