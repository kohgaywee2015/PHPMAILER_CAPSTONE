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
<?php
include '../classes/user_manager.php';
	UserManager::update_mail_subscriber();
?>

</h2>
</div>



</body>
</html>