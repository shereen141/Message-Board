<!-- Shereen Hasan
1001437130 -->
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
	<?php
	session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');

if ((isset($_POST["user"])) && (isset($_POST["password"])))
{
    $User = $_POST["user"];
    $Pass = $_POST["password"];
   

try {
  $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  print_r($dbh);
  $dbh->beginTransaction();
 
  $Pass=md5($Pass);
  $stmt = $dbh->prepare('select * from users where username="'.$User.'"and password="'.$Pass.'"');
   $stmt->execute();
   $row = $stmt->fetch();
   if (isset($row["username"])) {

   		$_SESSION['user']=$row["username"];

    	header('location:board.php');
    }

} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
}
?>


 <form action="login.php" method="POST">
 	<h3>
 	  Username:<input type="text" name="user">
 	  Password:<input type="password" name="password">
 	   <input type="submit" value="Submit">
 	</h3>
 </form>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</html>