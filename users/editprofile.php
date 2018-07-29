<?php
include 'security.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap/bootstrap.css">
  <script src="../bootstrap/bootstrap.js"></script>
</head>
<body>
<?php
include 'hyperlinks.php';
include_once '../classes/user_manager.php';

$emailmsg="";
$contactnomsg="";
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
	$input_is_blocked=$selecteduser->returnisblocked();
}
?>
<?php
if($input_is_blocked)
{
	echo "<div class=\"container-fluid\" style=\"background-color:#80dfff;height:1000px;\">";
	echo "<h1 style=\"font-family:\'Comic Sans MS\';text-align:left;\">";
	echo "<br><br>You are blocked<br>";
	echo "</h2>";
	echo "</div>";
}
else
{
	if(isset($_POST["update_profile_submit"]))
	{
		if($_POST["update_profile_submit"] == 1)
		{
			$username=$_SESSION["username"];
			$fullname=$_POST["fullname"];
			$email=$_POST["email"];
			$contactno=$_POST["contact_no"];
			echo "Username: ".$username."</br>";
			echo "Full Name: ".$fullname."</br>";
			echo "Email: ".$email."</br>";
			echo "Contact No: ".$contactno."</br>";
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $emailmsg="$email is a valid email address";
			} else {
			  $emailmsg="$email is not a valid email address";
			}
			
			if (filter_var($contactno, FILTER_VALIDATE_INT)) {
				$contactnomsg="Contact number is valid";
			} else {
				$contactnomsg="Contact number is invalid";
			}
			
			$email_valid=filter_var($email, FILTER_VALIDATE_EMAIL);
			$contactno_valid=filter_var($contactno, FILTER_VALIDATE_INT);
			
			$check_valid_input=false;
			
			if ($email_valid && $contactno_valid)
			{
				$check_valid_input=true;
			}

			if($check_valid_input)
			{
				UserManager::updateuser($username,$fullname,$email,$contactno);
			}
		}
	}
	
	
	
	
	echo
			"<div class=\"container-fluid\" style=\"background-color:#80dfff;height:1000px;\">
			<h2 style=\"font-family:\'Comic Sans MS\';text-align:left;\">
			<form action=\"\" method=\"post\">
			Username: <input type=\"text\" name=\"username\" value=$input_username disabled><br>
			Full Name: <input type=\"text\" name=\"fullname\" value=\"$input_fullname\" ><br>
			Email: <input type=\"text\" name=\"email\" value=$input_email > ".$emailmsg." <br>
			Contact No: <input type=\"text\" name=\"contact_no\" value=$input_contact_no > ". $contactnomsg." <br>
			<input name=\"update_profile_submit\" type=\"hidden\" value=\"1\" />
			<input type=\"submit\" value=\"Update Profile\">
			</form>
			</h2>
			</div>";

}
?>

</body>
</html>