<!-- Shereen Hasan
1001437130 -->
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <title>Message Board</title></head>
<body>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');



if (!isset($_SESSION['user'])) {
  header('location:login.php');
}



  $User = $_SESSION['user'];
  try {
    $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $dbh->beginTransaction();
      ?><br/>
      <h1> <center>Hello <?php echo $User; ?></center></h1><br/>

      <form action="board.php" method="POST"><center>
      <textarea name="msg" rows="10" cols="100"></textarea><br/><br/>
      <input type="submit" name="post" value="NEWPOST">
     <input type="submit" name="Logout" value="Logout">
      
       <?php

       if(isset($_POST["Logout"])){
        session_unset();
        session_destroy();
        header('location:login.php');
       }
       if (isset($_POST['reply'])) {
       $rsltid = $_GET['reply'];
        
       }


      if (isset($_POST["post"])){
      $Msg = $_POST["msg"];
      $dbh->exec('insert into posts values("'.uniqid().'",null,"'.$_SESSION['user'].'",now(),"'.$Msg.'")');
      $dbh->commit(); 
       }
       if (isset($_POST["reply"])){
       $dbh->exec('insert into posts values("'.uniqid().'","'.$rsltid.'","'.$_SESSION['user'].'",now(),"'.$_POST['msg'].'")');
      $dbh->commit(); 

      }  
       $stmt = $dbh->prepare('select * from posts as p,users as u where p.postedby=u.username order by datetime desc; ');
       $stmt->execute();
       
       ?>
  
       <table class="table table-bordered table-hover" width="80%">
        <tr class="table-dark">
          <th>Message id</th>
          <th>Username</th>
          <th>Full name</th>
          <th>Time</th>
          <th>ID</th>
          <th>Text</th>
          <th></th>
        </tr>
      
        <?php
        $rslt = $stmt->fetchall();
        foreach( $rslt as $row ) 
       {
        ?>
        <tr>
          <td><?php echo $row['id']; ?> </td> 
          <td><?php echo $row['username']?> </td>
          <td><?php echo $row['fullname']; ?> </td>
          <td><?php echo $row['datetime']; ?> </td>
          <td><?php echo $row['replyto']; ?> </td>
          <td><?php echo $row['message']; ?> </td>
          <td><input type="submit" name ="reply" value="Reply" formaction="board.php?reply=<?php echo $row['id']; ?>"></td>
         
        </tr>
        <br>
        <?php } 
       ?>
      </table>
     
<?php
  $sth = null;
       $dbh = null;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
 
  ?>
  </center>
  </form>

  </body>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </html>
