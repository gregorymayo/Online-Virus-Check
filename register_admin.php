<?php
	function checkUsername($string){
		if($string==""){
			echo "<br>You should put a username<br>";
			return false;
		} else if (strlen($string) < 6){
			echo "<br>Username length should be more than 6<br>";
			return false;
		} else if (!preg_match("/[a-z]/", $string) || !preg_match("/[A-Z]/", $string)){
			echo "<br>Username require 1 each of a to z or A to Z<br>";
			return false;
		} else 
			return true;
	}

	function checkPassword($string){
		if($string==""){
			echo "<br>You should put a password<br>";
			return false;
		} else if (strlen($string) < 6){
			echo "<br>Password length should be more than 6<br>";
			return false;
		} else if (!preg_match("/[a-z]/", $string) || !preg_match("/[A-Z]/", $string) ||!preg_match("/[0-9]/", $string)){
			echo "<br>Password require 1 each of a to z or A to Z or 0 to 9<br>";
			return false;
		} else
			return true;
	}

	function registerAdmin($conn,$username,$password){
		if(checkUsername($username)&&checkPassword($password)){
			$salt1 = "Ku9U=n";
			$salt2 = "N`2Tu5";
			$token = hash('ripemd128', "$salt1$password$salt2");
			add_user($conn,$username,$token,$salt1,$salt2);
		}		
	}
	function add_user($conn,$username,$token,$salt1,$salt2){
		$query = "INSERT INTO adminTable (ID, username, password, Salt1, Salt2) VALUES (NULL,'$username','$token','$salt1','$salt2')";
		mysqli_query($conn,$query);
	}
?>