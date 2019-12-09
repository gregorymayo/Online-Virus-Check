<?php
	require_once 'login.php';
	require_once 'regular_function.php';

	$connection = new mysqli($hn, $un, $pw, $db);
	if ($connection->connect_errno) 
		echo "<br>The Connection Is Error<br>";

	function checkAdmin($connection,$username,$password){
		$sql_username =  mysql_entities_fix_string($connection, $username);
		$sql_password =  mysql_entities_fix_string($connection, $password);
		$sql = "SELECT * FROM adminTable WHERE username = '$sql_username'";
		$result = $connection->query($sql);
		if (!$result) 
			echo "<br>Connection Error!<br>";
		else if ($result->num_rows) {
			$row = $result->fetch_array(MYSQLI_NUM);
			$salt1 = $row[3];
			$salt2 = $row[4];
			$token = hash('ripemd128', "$salt1$sql_password$salt2");
			if($token == $row[2]) {
				header("location: uploadMalware.php");
				return true;
			} else {
				echo "Invalid username/password";
				return false;
			}
		} else {
			echo "Invalid username/password";
			return false;
		}
	}
?>

