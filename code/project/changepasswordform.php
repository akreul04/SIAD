
<html>
	<h1>Change password</h1>
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

<br>
<br>
<a href='index.php'>Home</a>
</html>
