<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap\bootstrap.css">
  <script src="module5project\users\jquery.js"></script>
  <script src="bootstrap\bootstrap.js"></script>
</head>
<body>
<?php
include 'hyperlinks.php';
?>
<div class="container-fluid" style="background-color:#80dfff;height:1000px;">
<h2 style="font-family:\'Comic Sans MS\';text-align:left;">



<?php
$usernamemsg="";
$passwordmsg="";
$emailmsg="";
$contactnomsg="";
?>


<?php
include_once 'classes/user_manager.php';
	if(isset($_POST["register_submit"]))
	{
		if($_POST["register_submit"] == 1)
		{
			$username=$_POST["username"];
			$password=$_POST["password"];
			$fullname=$_POST["fullname"];
			$email=$_POST["email"];
			$contactno=$_POST["contactno"];
						
			$bool_has_user=UserManager::identifyuser($username);
			
			$user_valid=false;
			$password_valid=false;
			$email_valid=false;
			$contact_no_valid=false;
			
			
			if(empty($username))
			{
				$usernamemsg="You need a username";
			}
			else{
				$usernamemsg="OK!";
				$user_valid=true;
			}
			
			if(empty($password))
			{
				$passwordmsg="You need a password";
			}
			else{
				$passwordmsg="OK!";
				$password_valid=true;
			}
						
			if(!empty($email))
			{
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  $emailmsg="$email is a valid email address";
				  $email_valid=true;
				} else {
				  $emailmsg="$email is not a valid email address";
				}
			}
			
			if(!empty($contactno))
			{
				if (filter_var($contactno, FILTER_VALIDATE_INT)) {
					$contactnomsg="Contact number is valid";
					$contact_no_valid=true;
				} else {
					$contactnomsg="Contact number is invalid";
				}
			}
			
			$valid_input_bool=false;
			
			if($user_valid && $password_valid && $email_valid && $contact_no_valid)
			{
				$valid_input_bool=true;
			}
			if($valid_input_bool)
			{
				if($bool_has_user)
				{
					echo "username exists</br>";
				}
				else
				{
					echo "can be inserted</br>";
					UserManager::insertorduser($username,$password,$fullname,$email,$contactno);
					echo "insertion finished</br>";
				}
			}
		}
	}

?>

User Register</br>
<form action="" method="post"> 
Username: <input type="text" name="username"><?php echo " $usernamemsg"; ?><br>
Password: <input type="text" name="password"><?php echo " $passwordmsg"; ?><br>
Full Name: <input type="text" name="fullname"><br>
Email: <input type="text" name="email"><?php echo " $emailmsg"; ?><br>
Contact No: <input type="text" name="contactno"><?php echo " $contactnomsg"; ?><br>
<input name="register_submit" type="hidden" value="1" />
<input type="submit">
</form>

</h2>
</div>
</body>
</html>