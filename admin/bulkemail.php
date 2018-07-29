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
?>
<div class="container-fluid" style="background-color:#80dfff;height:10000px;">
<h2 style="font-family:\'Comic Sans MS\';text-align:left;">

<form action="" method="post">
Mail Title: <input type="text" name="mailtitle"><br>
Mail Message: <br>
<textarea  type="text" name="mailmessage" style="width:500px; height:600px"></textarea><br>
<input name="bulk_email_submit" type="hidden" value="1" />
<input type="submit" value="Send Bulk Email">
</form>
<?php
include '../classes/user_manager.php';
if(isset($_POST["bulk_email_submit"]))
{
	if($_POST["bulk_email_submit"] == 1)
	{
		UserManager::bulk_email();
	}
}
?>

</h2>
</div>



</body>
</html>
