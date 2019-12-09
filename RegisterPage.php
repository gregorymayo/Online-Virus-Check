<!DOCTYPE html>
<html>
<body>
	<form method="POST" action="" >	
		<label>Register For An Admin<br><br></label>
		Username: <input type="text" name="usernameAdmin"><br><br>
		Password: <input type="password" name="passwordAdmin"><br><br>
		Confirm Password: <input type="password" name="passwordConfirmAdmin"><br><br>
		<button name="RegisterAdmin">Register Admin</button><br><br>
	</form>
	<button onclick="window.location.href='Midterm2Run.php'">Back To Main Page</button><br><br>
</body>
</html>

<?php
	
	require_once 'login.php';
	require_once 'register_admin.php';
	require_once 'authenticate_admin.php';

	global $conn;
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_errno) 
		echo "<br>The Connection Is Error<br>";

	//Register Button For Admin
	if(isset($_POST['RegisterAdmin'])){
		//For username and password
		$usernames = $_POST['usernameAdmin'];
		$passwords = $_POST['passwordAdmin'];
		$passwordss = $_POST['passwordConfirmAdmin'];
		$usernames = sanitize($conn,$usernames);
		$passwords = sanitize($conn,$passwords);
		$passwordss = sanitize($conn,$passwordss);
		if(strcmp($passwords,$passwordss)==0){
			//Calling a registerAdmin function from register_admin.php
			registerAdmin($conn,$usernames,$passwords);
		} else {
			echo "The password is not the same";
		}
	}
?>