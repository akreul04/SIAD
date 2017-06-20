
<html>
	<h1>Add a new user</h1>
<?php
	//some code here
	require "authentication.php";
	echo "Current time: " . date("Y-m-d h:i:sa");
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	//echo "\$rand = $rand";
	$_SESSION["nocsrf"] = $rand;
?>
		<form action="newuser.php" method="POST" class="form login">
			<input type="hidden" name="secrettoken" value="<?php echo $rand;?>"/>
			Username:<input type="text" required pattern = "\w+" name="newusername" /> <br>
			Password: <input type="password" required pattern="(?=.*[A-Z]).{6,}" name="newpassword" onchange="form.newpassword2.pattern = this.value" /> <br>
			Confirm Password: <input title = "Please enter the same password as above" type="password" required pattern="(?=.*[A-Z]).{6,}" name="newpassword2" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); " /> <br>
			<button class="button" type="submit">
				Add User
			</button>
		</form>
</html>
