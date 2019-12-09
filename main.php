<!DOCTYPE html>
<html>
<body>
	<form method="POST" action="" >	
		<label>For An Admin<br><br></label>
		Username: <input type="text" name="usernameAdminLog"><br><br>
		Password: <input type="password" name="passwordAdminLog"><br><br>
		<button name="LoginAdmin">Log In Admin</button><br><br>
	</form>
	<button onclick="window.location.href='RegisterPage.php'">Register Admin</button>
	<br></br>
	<form method="POST" action="" >	
		<label>For Regular User<br><br></label>
		File: <input type="file" name="regularFile"><br><br>
		<button name="UploadButtonRegular">Upload</button><br><br>
	</form>
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

	//Login Button For Admin
	if(isset($_POST['LoginAdmin'])){
		$usernamesLog = $_POST['usernameAdminLog'];
		$passwordsLog = $_POST['passwordAdminLog'];
		$usernamesLog = sanitize($conn,$usernamesLog);
		$passwordsLog = sanitize($conn,$passwordsLog);
		//Calling a checkAdmin function from authenticate_admin.php
		checkAdmin($conn,$usernamesLog,$passwordsLog);
	}

	//Find The Malware Using For Loop
	function findMalware($input,$database){
		$check = false;
		$lengthInput = strlen($input);
		$lengthDatabase = strlen($database);
		if($lengthInput < $lengthDatabase)
			return false;
		$arrInput = str_split($input);
		$arrDatabase = str_split($database);
		$j = 0;	
		for($i = 0; $i < $lengthInput; $i++){			
			if($arrInput[$i]==$arrDatabase[$j]){
				if($j==$lengthDatabase-1){
					return true;
					break;
				} else {
					$j++;
				}
			} else {
				$j=0;
			}
		}
		return false;
	}

	//Read File From Regular User
	function readFileUser($file){
		$value = 0;
		global $conn;
		if(!file_exists($file)) 
			echo "<br>The file does not exist please choose a valid file";
		$fout = fopen($file, "r");
		while(!feof($fout)){
			$string = fread($fout,filesize($file));
			$query = "SELECT ID, Name, Content FROM table1";
			$result = mysqli_query($conn, $query);
			$rows = $result->num_rows;
			for ($j = 0 ; $j < $rows ; ++$j) {
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_NUM);
				if (findMalware($string,$row[2])!== false){
					echo "<br>The Following Malware is detected in Admin's file : $row[1]<br>";
					$value=1;
				}
			} 
		}
		if($value != 1)
			echo "<br>No Malware Detected.";
	}

	//Upload Button For Regular User
	if(isset($_POST['UploadButtonRegular'])){
		$fileUploadUser = $_POST['regularFile'];
		//The file does not exist
		if(!file_exists($fileUploadUser)) {
			echo "The file does not exist";
		}
		//Get the extention of the file
		$extension = pathinfo($fileUploadUser,PATHINFO_EXTENSION);
		//Open the file
		$fileOutputUser = fopen($fileUploadUser, "r");
		$contentUser = fread($fileOutputUser , filesize($fileUploadUser));
		//Sanitizing the inputs
		$contentUser = sanitize($conn, $contentUser);
		//Check if the file is in txt
		if($extension == 'txt'){
			$sql = "INSERT INTO table2 (ID, Content) VALUES (NULL, '$contentUser')";
			mysqli_query($conn,$sql);
			//getContentUser();
			readFileUser($fileUploadUser);
			//close the file
			fclose($fileOutputUser);
		} else {
			echo "The file is not in .txt format";
		}
	}

?>