<?php
	require "authentication.php";

	$secrettoken = $_POST["secrettoken"];
	if ( !isset($secrettoken) or ($secrettoken !=  $_SESSION["nocsrf"])){
		echo "Cross site request forgery is detected.";
		die();
	}

	function updatepost($postid, $title, $content){
		$postid = mysql_real_escape_string($postid);
		$title = mysql_real_escape_string($title);
		$content = mysql_real_escape_string($content);
		$sql = "UPDATE posts SET title =  ?, content = ? WHERE postid = ?;";
		global $mysqli;
		if(!($stmt = $mysqli->prepare($sql))) echo "Prepare failed";
		$stmt->bind_param("ssi",$title,$content,$postid);
		if(!$stmt->execute())   echo "Execute failed";
		//$result = $mysqli->query($sql);


		if($stmt == TRUE){
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

<br>
<br>
<a href='index.php'>Home</a>
