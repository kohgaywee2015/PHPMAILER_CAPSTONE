<?php
ob_start();
?>
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
	<div class="row">
		</br></br><img class="img-responsive" src="images\googleadverts.jpg" style="display:block;margin-left:auto;margin-right:auto;"></img>
<h2 style="font-family:\'Comic Sans MS\';text-align:center;">
User Login<br>
<form action="" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="text" name="password"><br>
<input name="login_submit" type="hidden" value="1" />
<input type="submit">
</form>
</h2>

<?php
	include_once 'classes/user_manager.php';
	if(isset($_POST["login_submit"]))
	{
		if($_POST["login_submit"] == 1)
		{
			$username=$_POST["username"];
			$password=$_POST["password"];
			
			echo "User name: ".$username."</br>";
			echo "Password: ".$password."</br>";
			
			$bool_user=UserManager::authenticateuserfororduser($username,$password);
			$bool_admin=UserManager::authenticateuserforadmin($username,$password);
			echo "The user bool is ".var_dump($bool_user)."</br>";
			if ($bool_user)
			{
				UserManager::usersetsession($username,$password);
				header("Location: users/home.php");
				exit();
			}
			else if ($bool_admin)
			{
				UserManager::usersetsession($username,$password);
				header("Location: admin/home.php");
				exit();
			}
			else
			{
				echo "invalid user and password";
			}
		}
	}

?>

</div>
</div>

</body>
</html>