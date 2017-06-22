<?php
	require "authentication.php";

	$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"])){
		echo "Cross site request forgery is detected.";
		die();
	}

	function deletepost($postid){
		$postid = mysql_real_escape_string($postid);
		
		$sql = "DELETE FROM posts WHERE postid = ?;";
		//just debug
		//echo "sql = $sql";
		global $mysqli;
		if(!($stmt = $mysqli->prepare($sql))) echo "Prepare failed";
		$stmt->bind_param("i",$postid);
		if(!$stmt->execute()) echo "Execute failed";
		//$result = $mysqli->query($sql);


		if($stmt == TRUE){
			echo "Post deleted";
		}else
		{
			echo "Failed to delete the post for postid '$postid' Error: " .$mysqli->error;
		}

		
	}


	$postid = htmlspecialchars($_POST['postid']);
	if(isset($postid)){
		deletepost($postid);
	}
		
?>

<br>
<br>
<a href='index.php'>Home</a>
