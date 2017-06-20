<html>
<?php
	require "authentication.php";
	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}
	echo "Welcome to the Admin page" ;
	

	$sql = "SELECT postid, title FROM posts INNER JOIN users ON posts.userid=users.userid WHERE username=" . "'" . $_SESSION["username"] . "'";
	//echo "sql = $sql";
	$result = $mysqli->query($sql);
	if($result->num_rows > 0){
		//output data of each row
		while($row = $result->fetch_assoc()){
			$postid = $row["postid"];
			echo "<h3>Post " .$postid. "-" .$row["title"]. "</h3><br>";
			echo $row["content"]."<br>";
			echo "<a href='editpostform.php?postid=$postid'>Edit</a>";
			?>
			<html> <br> </html>
			<?php 
			echo "<a href='deletepost.php?postid=$postid'>Delete</a>";
		}
	}else{
		echo "You haven't posted yet!";
	}

?>

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
