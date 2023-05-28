<?php
session_start();
if(!isset($_SESSION['loginSuccess']))
{
  header('Location:index.php');
  exit;
}
if(isset($_POST['addBranch']))
{ 
        include_once("functions.php");
        $user=new USER();  
        $user->newbranchname=$_POST['newbranchname'];
        $user->newbranchaddress=$_POST['newbranchaddress'];
        $result=$user->addBranch();
        if($result)
        {header("Location:manageBranches.php");
          exit;
        }
        else{
          echo '<div class="center alert transparentred"> ';
          echo "Some Error Occured,Contact Developer";
          echo '</div>';
        }
        
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Income and Expense Tracker</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<meta charset="utf-8">
<style>
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: rgba(212, 17, 33,0.8);
  border: none;
  color: #e6edec;
  text-align: center;
  text-color: #e6edec;
  font-size: 28px;
  padding: 5px;
  width: 150px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00ab';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}


.navbar-custom {
    background-color: #ff5500;
}

/* change the brand and text color */
.navbar-custom .navbar-brand,
.navbar-custom .navbar-text {
    color: rgba(255,255,255,.8);
}

/* change the link color */
.navbar-custom .navbar-nav .nav-link {
    color: white;
}



/* for dropdown only - change the color of droodown */
.navbar-custom .dropdown-menu {
    background-color: #ff5500;
}
.navbar-custom .dropdown-item {
    color: #ffffff;
}






.card {  
    background-color: rgba(0, 0, 0,0.9);
}
.teal{
  background-color: rgba(0,136,136,0.6);
}
.transparent {
  background-color: rgba(136,136,136,0.9);
}
.transparentgrey{
  background-color: rgba(136,136,136,0.9);
}
.transparentred {
  background-color: rgba(255, 0,0,0.6);
  color:white;
}
.semitransparent {
  background-color: rgba(3,252,6,0.79);
}
.transparentbutton {
  background-color: rgba(0,90,0,0.5);
  color: white;
}
.overlaydiv{
z-index: 9;
height: 100%;
width: 100%;
position: fixed;
top: 0;
left: 0;
opacity: 0.93;
text-align: center;
}
.center {
  margin: auto;
  width: 25%;
  border: 2px solid green;
  padding: 10px;
  text-align: center;
  color:white;
}

#myBtn {
  display: none;
  position: fixed;
  bottom: 50px;
  right: 20px;
  z-index: 99;
  font-size: 15px;
  border: none;
  outline: none;
  background-color:rgba(0,136,136,0.9) ;
  color: white;
  cursor: pointer;
  padding: 10px 20px;
  border-radius: 20px;
}

#myBtn:hover {
  background-color: teal;
}

</style>
<head>
<body background="images/3.jpeg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
<a  href="mainpage.php" class="button btn btn-danger  transparentgrey"  style="vertical-align:middle;float:left;"><span>Home</span></a><br><br><br> 
<button onclick="topFunction()" id="myBtn" title="Go to top" style='font-size:25px;'><B>^</B></button>
<div class="d-flex p-2 justify-content-center">
  <br>
  <div class="alert alert-success transparentgrey"  style="width: 1400px;color:white" >
      <h4 style='color:white;text-align: center;'>Manage Branches</h4><br>
      <div class="row">
      <div class="col-sm">
        <button class="btn btn-success form-control  btn-block teal" onclick="showBranchesTab()">Your Branches</button></div>
      <div class="col-sm">
        <button class="btn btn-success form-control btn-block teal" onclick="addBranchTab()">Add New Branch</button></div>
      </div> 

      <div id="addBranchDiv" style='display:none'>
            
            <form action="" method="post">
            <div class="form-group"><br>
                <label for="newbranchname">Branch Name</label>
                <input type="text" class="form-control"  name="newbranchname" id="newbranchname" required>
            </div>
            <div class="form-group">
                <label for="newbranchaddress">Branch Address</label>
                <input type="text" class="form-control"  name="newbranchaddress" id="newbranchaddress" required>
            </div>
            <br>
            <button type="submit" class="btn btn-success form-control btn-block transparentbutton" name='addBranch' onclick="return alertBranchAdded();">Add Branch</button>
            </form>
      </div>
  
  <div id="showBranchesDiv" style="display:block">
        <table class="table table-striped">                     
                   <?php 

                      include_once("functions.php");
                      $user=new USER();
                      $result=$user->getBranches();
                      if ($result->num_rows > 0) {
                      $serialNo=0;
                      echo "<div class='table responsive'>
                      <thead>
                          <tr>
                          <th></th>
                          <th>Branch Name</th>
                          <th>Branch Address</th>
                          </tr>
                      </thead>
                      <tbody>";
                      while($row = $result->fetch_assoc()) {
                      $editBranchAddress='manageBranches.php?fn=editBranch&branchno='.$row['branchno'].
                      '&branchname='.$row['branchname'].'&branchaddress='.$row['branchaddress'];
                      $deleteBranchAddress='manageBranches.php?fn=deleteBranch&branchno='.$row['branchno'].
                      '&branchname='.$row['branchname'].'&branchaddress='.$row['branchaddress'];
                      $serialNo++;
                          echo "<tr>
                                  <td scope='row'>".$serialNo."</td>
                                  <td style='word-break: break-all;'>" . $row['branchname']. "</td>
                                  <td style='word-break: break-all;'>" . $row['branchaddress']. "</td>
                                  <td> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
                                  <a class='btn btn-success form-control btn-block teal' href='$editBranchAddress' >Edit Branch</a>
                                  <a class='btn btn-danger form-control btn-block transparentred ' href='$deleteBranchAddress' >Delete Branch</a></td>
                                  </tr>";
                                  }
                              } else {
                                echo '<br><div class="center transparentred"> ';
                                echo "No Branches Added";
                                echo '</div>';
                              } 
                    ?>
                 </tbody> 
              </div>
            </table>
      </div>
      


      
</div>
</div>
<div id='editBranchDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="post">
        <div class="form-group">
            <label for="branchname">Branch Name</label>
            <input type="text"  name="branchname" id="branchname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="branchaddress">Branch Address</label><br>
            <input type="text"  name="branchaddress" id="branchaddress" class="form-control" required>
        </div><br><br>
        <button type="submit" class="btn btn-success form-control btn-block teal" name='editBranch'>Done</button>
        <a class='btn btn-success form-control btn-block teal'  href='manageBranches.php'>Exit</a>
      </form>
      </div>
      <?php
        if(isset($_POST['editBranch']))
        {
          include_once("functions.php");
          $user=new USER();
          $user->branchno=$_GET['branchno'];
          $user->branchname=$_POST['branchname'];
          $user->branchaddress=$_POST['branchaddress'];
          $result=$user->editBranch();
          if($result){
            $_GET['branchname']=$_POST['branchname'];
            $_GET['branchaddress']=$_POST['branchaddress'];
            echo '<div class="center transparent"> ';
          echo "Branch Details Updated";
          echo '</div>';
            }
          else{
          echo '<div class="center transparent"> ';
          echo "Some Error Occured";
          echo '</div>';
          }
        }
        ?>

</div>


<div id='deleteBranchDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br>
    <div class="center" style="border:1px solid white;background:rgba(255,195,0,0.7);"> 
      <h1>WARNING !</h1>
      <h6>Branch Name:</h6>
      <text style='word-break: break-all;'><?php echo $_GET['branchname']?></text><br><br>
      <h6>Branch Address:</h6>
      <text style='word-break: break-all;'><?php echo $_GET['branchaddress']?></text><br><br>
      <h5>Deleting a branch is irreversible.</h5>
      <h5>All associated records will be deleted.</h5><br>
      <form action="" method="post">
        <button type="submit" class="btn btn-danger form-control btn-block" name='deleteBranch'>Delete Branch</button>
        <a class='btn btn-success form-control btn-block teal'  href='manageBranches.php'>Exit</a>
      </form>
      </div>
      <?php
        if(isset($_POST['deleteBranch']))
        {
          include_once("functions.php");
          $user=new USER();
          $user->branchno=$_GET['branchno'];
          $result=$user->deleteBranch();
          if($result){
            echo '<div class="center transparent"> ';
          echo "Branch Deleted";
          echo '</div>';
            }
          else{
          echo '<div class="center transparent"> ';
          echo "Some Error Occured";
          echo '</div>';
          }
        }
        ?>

</div>


<script type='text/javascript'>
    function showBranchesTab()
    {
      var x = document.getElementById("showBranchesDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("addBranchDiv").style.display = "none";
      } 
    }
    function editBranchTab()
    {

      var x=document.getElementById("editBranchDiv");
      if(x.style.display === "none")
      {
        x.style.display = "block";
      }
    }
    function deleteBranchTab()
    {
      var x=document.getElementById("deleteBranchDiv");
      if(x.style.display === "none")
      {
        x.style.display = "block";
      }
    }
    function addBranchTab()
    {
      var x = document.getElementById("addBranchDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("showBranchesDiv").style.display = "none";
      } 
    }
    function alertBranchAdded()
    {
      alert("New Branch Added");
      return true;
    }
//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>

<?php
if(isset($_GET['fn']))
{
	if($_GET['fn']=="editBranch")
    {
      echo "<script  type='text/javascript'>
              editBranchTab();
              document.getElementById('branchname').setAttribute('value','".$_GET['branchname']."');
              document.getElementById('branchaddress').setAttribute('value','".$_GET['branchaddress']."');
             </script>";  
  }
  if($_GET['fn']=="deleteBranch")
    {
      echo "<script  type='text/javascript'>
              deleteBranchTab();
             </script>";  
  }
}
?>
</body>
</HTML>