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
//include 'security.php';
include 'hyperlinks.php';
?>
<div class="container-fluid" style="background-color:#80dfff;height:1000px;">
<h2 style="font-family:\'Comic Sans MS\';text-align:left;">
<?php
include_once '../classes/user_manager.php';
$input_id=$_GET["input_id"];

$selecteduser=UserManager::viewselectedprofile($input_id);

$input_username=$selecteduser->returnusername();
$input_fullname=$selecteduser->returnfullname();
$input_email=$selecteduser->returnemail();
$input_contact_no=$selecteduser->returncontactno();
?>

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