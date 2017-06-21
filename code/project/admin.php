<html>

<?php
	require "authentication.php";

	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	$_SESSION["nocsrf"] = $rand;
	
	
	echo "Welcome to the Admin page" ;
	

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
			?>
			<html> <br> </html>
			<?php 
			echo "<a href='deletepost.php?postid=$postid'>Delete</a>";
		}
	
	if($num_rows == 0)
		echo "No posts yet!";
	

?>
<form action="deletepost.php" method="POST" class="form login">
	<input type="text" name="secrettoken" value="<?php echo $rand;?>"/>
</form>

<br>
<br>
<a href='index.php'>Home</a>
<br>
<a href='newpostform.php'>New Post</a>
<br>
<a href='newuserform.php'>Add User</a>
<br>
<a href='changepasswordform.php'>Change Password</a>
<br>
<a href='logout.php'>Logout</a>


	

	

</html>
