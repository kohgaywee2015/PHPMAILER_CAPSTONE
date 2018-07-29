<?php
include 'security.php';
?>
<?php
include_once '../classes/user_manager.php';

if(!isset($_SESSION["username"]) && empty($_SESSION["username"])) 
{
    $input_username="invalid";
	$input_fullname="invalid";
	$input_email="invalid";
	$input_contact_no="invalid";
} 
else 
{	
	$selecteduser=UserManager::viewprofile($_SESSION["username"]);
	$input_username=$selecteduser->returnusername();
	$input_fullname=$selecteduser->returnfullname();
	$input_email=$selecteduser->returnemail();
	$input_contact_no=$selecteduser->returncontactno();
}


?>

<!DOCTYPE HTML>
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap/bootstrap.css">
  <script src="boot../bootstrap/strap.js"></script>
</head>
<body>

<?php

include 'hyperlinks.php';
?>
<div class="container-fluid" style="background-color:#80dfff;height:1000px;">
<h2 style="font-family:\'Comic Sans MS\';text-align:left;">
<form action="" method="post">
Username: <input type="text" name="username" value=<?php echo $input_username ?>  disabled><br>
Full Name: <input type="text" name="fullname" value=<?php echo $input_fullname?>  disabled><br>
Email: <input type="text" name="email" value=<?php echo $input_email?>  disabled><br>
Contact No: <input type="text" name="conatct_no" value=<?php echo $input_contact_no?>  disabled><br>
<input type="submit">
</form>
</h2>
</div>
</body>
</html>