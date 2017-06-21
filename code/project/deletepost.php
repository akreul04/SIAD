<?php
	require "authentication.php";

	/*$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"])){
		echo "Cross site request forgery is detected.";
		die();
	}*/

	function deletepost($postid){
		
		$sql = "DELETE FROM posts WHERE postid = $postid;";
		//just debug
		echo "sql = $sql";
		global $mysqli;
		$result = $mysqli->query($sql);


		if($result == TRUE){
			echo "Post deleted";
		}else
		{
			echo "Failed to delete the post for postid '$postid' Error: " .$mysqli->error;
		}

		
	}


	$postid = $_GET['postid'];
	echo "postid = $postid";
	if(isset($postid)){
		deletepost($postid);
	}
		
?>

<br>
<br>
<a href='index.php'>Home</a>
