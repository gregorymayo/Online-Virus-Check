<?php
	function mysql_entities_fix_string($conn, $string){
		return htmlentities(mysql_fix_string($conn, $string));
	}

	function mysql_fix_string($conn, $string){
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $conn->real_escape_string($string);
	}

	function sanitizeString($var) {
		$var = stripslashes($var);$var = strip_tags($var);$var = htmlentities($var);return $var;
	}

	function sanitizeMySQL($connection, $var) {
		$var = $connection->real_escape_string($var);$var = sanitizeString($var);return $var;
	}
?>