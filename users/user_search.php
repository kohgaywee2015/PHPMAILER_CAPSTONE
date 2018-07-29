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
include "hyperlinks.php";
?>
<div class="container-fluid" style="background-color:#80dfff;height:1000px;">
<h3 style="font-family:\'Comic Sans MS\';text-align:left;">
<form action="" method="post">
Username: <input type="text" name="username">
Full Name: <input type="text" name="password">
Email: <input type="text" name="email"><br>
<input name="submitted" type="hidden" value="1" /> 
<input type="submit" value="Search">
</form>

<?php
include_once "../classes/user_manager.php";
	if(isset($_POST["submitted"]))
	{
		if($_POST["submitted"] == 1)
		{
			$username=$_POST['username'];
			$fullname=$_POST['password'];
			$email=$_POST['email'];
			
			echo "the first name is ".$username."</br>";
			echo "the last name is ".$fullname."</br>";
			echo "the email is ".$email."</br>";
		
			if(!empty($username) && empty($fullname)&& empty($email))
			{
				echo "search by username</br>";
				UserManager::usersearchbyusername($username);
			}
			else if(empty($username) && !empty($fullname) && empty($email))
			{
				echo "search by fullrname</br>";
				UserManager::usersearchbyfullname($fullname);
			}
			else if(empty($username) && empty($fullname) && !empty($email))
			{
				echo "search by email</br>";
				UserManager::usersearchbyemail($email);
			}
			else
			{
				echo "invalid search</br>";
			}
		}
	}

?>
</h3>
</div>
</body>
</html>