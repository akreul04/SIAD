<html>
<?php
	session_start();
	$mysqli = new mysqli('localhost', 'SIAD_project', 'secretpass', 'SIAD_project');
	if($mysqli->connect_error){
		die('Connection to the database terminated with error: ' . $mysqli->connect_error);
	}
	
	$sql = "SELECT * FROM posts";
	

	$result = $mysqli->query($sql);
	$num_rows = 0;
	if($result->num_rows > 0){
		//output data of each row
		while($row = $result->fetch_assoc()){
			$num_rows++;
			$postid = $row["postid"];
			echo "<h3>Post " .$num_rows. "-" .$row["title"]. "</h3><br>";
			echo $row["content"]."<br>";
			echo "<a href='newcommentform.php?postid=$postid'>";
			$sql = "SELECT * FROM comments WHERE postid=$postid;";
			$comments = $mysqli->query($sql);
			if($comments->num_rows>0){
				echo $comments->num_rows. " comments </a>";
			}else{
				echo "Post your first comment </a>";
			}
		}
	}else{
		echo "No post in this blog yet";
	}

?>

<br>
<br>
<a href='admin.php'>Admin Login</a>	

	

</html>
