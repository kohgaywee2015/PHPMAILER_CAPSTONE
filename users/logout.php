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
UserManager::userdestroysession();
header("Location: ..\user_login.php");
?>
<div class="container-fluid" style="background-color:#80dfff;height:1000px;">
</div>