<?php
	require "authentication.php";

	$secrettoken = $_POST["secrettoken"];
	//echo "nocsrf: " . $_SESSION["nocsrf"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"])){
		echo "Cross site request forgery is detected.";
		die();
	}

	function updatepost($postid, $title, $content){
		$sql = "UPDATE posts SET title =  '$title', content = '$content' WHERE postid = $postid;";
		//just debug
		echo "sql = $sql";
		global $mysqli;
		$result = $mysqli->query($sql);


		if($result == TRUE){
			echo "Post '$title' has been updated";
		}else
		{
			echo "Failed to update post '$title' Error: " .$mysqli->error;
		}

		
	}


	$postid = $_POST['postid'];
	$title = $_POST["title"];
	$content = $_POST["content"];
	if(isset($postid) and isset($title) and isset($content)){
		updatepost($postid, $title, $content);
	}
		
?>
