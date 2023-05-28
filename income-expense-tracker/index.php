<!DOCTYPE html>
<?php
  session_start();
?>
<html>
<head>
<title>Income and Expense Tracker</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css"/>
<style>

.center {
  margin: auto;
  width: 25%;
  border: 10px solid grey;
  padding: 10px;
  text-align: center;
  color:white;
}
</style>
</head>
<body background="images/3.jpeg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
<br><br><br><br><br><br><br><br>
  <div  class=' center' style="background:rgba(0,136,136,0.8);">
    <form action=""  method="post">
      <div class="form-group">
        <label for="pass">Administrator Password</label>
        <input type="password" class="form-control" placeholder="Enter password" name="pass">
      </div>
      <button type="submit" class="btn btn-danger" name="login">Log In</button>
    </form><br>
    </div>
  <?php
if(isset($_POST['login']))
{

    include("dbconnection.php");  
    $pass=$_POST['pass'];
    $sql="SELECT * FROM admin WHERE password='$pass'";
    $db=new dbconn;
    $result=$db->query($sql);
    $row_cnt=$result->num_rows;
    $row = mysqli_fetch_assoc($result);
    if($row_cnt!=0)
    {
      $_SESSION['loginSuccess']="";
      header('Location:mainPage.php');
      exit;
    }
    else
    {
      $_SESSION['loginFailed']="";
      header('Location:index.php');
      exit;
    }
}
?>
  <?php
  echo '<div class="container">';
  echo '<br><br>';
  if(isset($_SESSION['loginFailed']))
  {
      echo '<div class="alert alert-danger">';  
      echo '<br>Login Failed,Try Again.';
      echo '</div>';
  }
  echo "</div>";
  session_destroy();//to destroy all session variables like userid.IMP:else userHome can be accesed without login because of userid.
?>
</body>
</html>

