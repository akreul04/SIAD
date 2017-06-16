
<html>
	<h1>Add a new user</h1>
<?php
	//some code here
	require "authentication.php";
	echo "Current time: " . date("Y-m-d h:i:sa");
?>
		<form action="newuser.php" method="POST" class="form login">
			Username:<input type="text" required pattern = "\w+" name="newusername" /> <br>
			Password: <input type="password" required pattern="(?=.*[A-Z]).{6,}" name="newpassword" onchange="form.newpassword2.pattern = this.value" /> <br>
			Confirm Password: <input title = "Please enter the same password as above" type="password" required pattern="(?=.*[A-Z]).{6,}" name="newpassword2" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); " /> <br>
			<button class="button" type="submit">
				Add User
			</button>
		</form>
</html>
