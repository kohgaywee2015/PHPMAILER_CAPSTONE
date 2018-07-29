<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["username"]) && empty($_SESSION["username"])) {
		echo "Cookie named 'username' is not set!</br>";
		header("Location: ..\user_login.php");
		exit();
} else {
     echo "Cookie named 'username' is set!</br>";
     echo "Value is: " . $_SESSION["username"];
	 
}

?>