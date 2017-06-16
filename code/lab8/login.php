
<html>
	<h1>Login</h1>
<?php
	//some code here
	echo "Current time: " . date("Y-m-d h:i:sa");
?>
		<form action="index.php" method="POST" class="form login">
			Username:<input type="text" required pattern = "\w+" name="username" /> <br>
			Password: <input type="password" required pattern="(?=.*[A-Z]).{6,}" name="password" /> <br>
			<button class="button" type="submit">
				Login
			</button>
		</form>
</html>
