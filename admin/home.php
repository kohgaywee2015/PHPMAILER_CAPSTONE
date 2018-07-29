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
include 'hyperlinks.php'
?>

<div class="container-fluid" style="background-color:#80dfff;height:1000px;">
	<div class="row">
		</br></br><img class="img-responsive" src="images\googleadverts.jpg" style="display:block;margin-left:auto;margin-right:auto;"></img>
	<h1>Welcome to the system,<?php echo $_SESSION["username"]?></h1>
</div>
</div>

</body>
</html>