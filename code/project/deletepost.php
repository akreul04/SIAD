<?php
	require "authentication.php";

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
