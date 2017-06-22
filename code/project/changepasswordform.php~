<!DOCTYPE html>
<html lang="en">
<head>
  <title>Adam's Fancy SIAD Blog</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>

<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Adam's Fancy SIAD Blog</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="index.php">Home</a></li>
      </ul><br>
    </div>
    <div class="col-sm-9">
      <h4><small>CHANGE PASSWORD</small></h4>
<?php
	
	require "authentication.php";
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	$_SESSION["nocsrf"] = $rand;
?>
		<form action="changepassword.php" method="POST" class="form login">
			<input type="hidden" name="secrettoken" value="<?php echo $rand;?>"/>
			Change password for <?php echo $_SESSION["username"]; ?> <br>
			New Password: <input type="password" required pattern="(?=.*[A-Z]).{6,}" name="newpassword" onchange="form.newpassword2.pattern = this.value;" /> <br>
			Confirm Password: <input title = "Please enter the same password as above" type="password" required pattern="(?=.*[A-Z]).{6,}" name="newpassword2" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title: ''); " /> <br>
			<button class="button" type="submit">
				Change password
			</button>
		</form>

</body>
</html>
