
<html>
	<h1>Adam's Fancy Blog - Login</h1>
<?php
	//some code here
	echo "Current time: " . date("Y-m-d h:i:sa");
?>
		<form action="admin.php" method="POST" class="form admin">
			Username:<input type="text" required pattern = "\w+" name="username" /> <br>
			Password: <input type="password" required pattern="(?=.*[A-Z]).{6,}" name="password" /> <br>
			<button class="button" type="submit">
				Login
			</button>
		</form>

<br>
<br>
<a href='index.php'>Home</a>
</html>
