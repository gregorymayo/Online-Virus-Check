<?php 	// login.php
	$hn = 'localhost';
	$un = 'gregory';
	$pw = 'v:8htN%S@;KU#:f&';
	$db = 'midterm2';

	//For sanitizing the input from the user
	function sanitize($connection, $var){
		$var = $connection->real_escape_string($var);
		return $var;
	}
?>
