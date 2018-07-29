
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
<?php
include 'hyperlinks.php'
?>

<div class="container-fluid" style="background-color:#80dfff;height:1000px;">
	<div class="row">
		</br></br><img class="img-responsive" src="images\googleadverts.jpg" style="display:block;margin-left:auto;margin-right:auto;"></img>
<h2 style="font-family:\'Comic Sans MS\';text-align:center;">

<form action="" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="text" name="password"><br>
Password: <input type="text" name="password"><br>
<input name="pwd_reset_submit" type="hidden" value="1" />
<input type="submit">
</form>
</h2>

<?php
	include_once 'classes/user_manager.php';
	if(isset($_POST["pwd_reset_submit"]))
	{
		if($_POST["pwd_reset_submit"] == 1)
		{
			$username=$_POST["username"];
			$password=$_POST["password"];
			
			echo "User name: ".$username."</br>";
			echo "Password: ".$password."</br>";
			
			$bool_has_user=UserManager::identifyuser($username);
			if($bool_has_user)
			{
				echo "username exists</br>";
				UserManager::changepassword($username,$password);
			}
			else
			{
				echo "invlid user</br>";
			}
		}
	}

?>

</div>
</div>

</body>
</html>