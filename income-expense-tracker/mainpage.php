<?php
error_reporting(0); 
session_start();
if(!isset($_SESSION['date']))
{
  $_SESSION['date']='today';
}
if(isset($_GET['fn'])&&$_GET['fn']=='previousDate')
{
  $_SESSION['date'] = date('Y-m-d', strtotime($_SESSION['date'] . " - 1 day"));
  header('Location:?viewmode=today');
  exit;
}
if(isset($_GET['fn'])&&$_GET['fn']=='nextDate')
{
  $_SESSION['date'] = date('Y-m-d', strtotime($_SESSION['date'] . " + 1 day"));
  header('Location:?viewmode=today');
  exit;
}
if(!isset($_SESSION['loginSuccess']))
{
  header('Location:index.php');
  exit;
}
date_default_timezone_set("Asia/Kolkata");
if(!isset($_SESSION['firstpageload']))
{
  $_SESSION['firstpageload']="true";
  header('Location:?viewmode=today');
  exit;
}
if(!isset($_SESSION['brancheslist']))
{
  include_once('functions.php');
  $us0=new USER();
  $res0=$us0->getBranches();
  $list = (array) null; 
  if ($res0->num_rows > 0) 
  { while($row0 = mysqli_fetch_array($res0))
    {
      array_push($list,$row0[0]);
    }
    $_SESSION['brancheslist']=$list;
  }
}

if(isset($_GET['branchesSelected']))
{
  $_SESSION['brancheslist']=$_GET['brancheslist']; 
  header('Location:?viewmode='.$_SESSION['previousviewmode']);
  exit;
}

if(isset($_GET['periodselected']))
{
  $_SESSION['from']=$_GET['from'];
  $_SESSION['to']=$_GET['to'];
  $_SESSION['period']=date('d/m/Y',strtotime($_SESSION['from']))."&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp".date('d/m/Y',strtotime($_SESSION['to'])); 
  header('Location:?viewmode='.$_SESSION['previousviewmode']);
  exit;
}
if(isset($_GET['monthsselected']))
{
  $_SESSION['from']=$_GET['monthfrom'];
  $_SESSION['to']=$_GET['monthto'];
  $_SESSION['period']=date('F Y',strtotime($_SESSION['from']))."&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp".date('F Y',strtotime($_SESSION['to'])); 
  header('Location:?viewmode='.$_SESSION['previousviewmode']);
  exit;
}
if(isset($_GET['yearsselected']))
{
  $_SESSION['from']=$_GET['yearfrom'];
  $_SESSION['to']=$_GET['yearto'];
  $_SESSION['period']=$_SESSION['from']."&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp".$_SESSION['to']; 
  header('Location:?viewmode='.$_SESSION['previousviewmode']);
  exit;
}
if(!isset($_SESSION['period']))
{
  $_SESSION['period']="All Time";
}
if(isset($_GET['periodalltime']))
{
  $_SESSION['period']="All Time";
  header('Location:?viewmode='.$_SESSION['previousviewmode']);
  exit;
}
if(isset($_GET['todaysdate']))
{
  $_SESSION['date']='today';
  header('Location:?viewmode='.$_SESSION['previousviewmode']);
  exit;
}
if(isset($_GET['dateselected']))
{
  $_SESSION['date']=$_GET['date'];
  header('Location:?viewmode='.$_SESSION['previousviewmode']);
  exit;
}

  
if(isset($_POST['editAccounts']))
{
  include_once("functions.php");
  $newuser=new USER();
  $newuser->branchno=$_GET['branchno'];
  if($_SESSION['date']=='today'){
    $newuser->date=date('Y-m-d');
  }
  else{
    $newuser->date=date('Y-m-d',strtotime($_SESSION['date']));
  }
  $newuser->income=$_POST['income'];
  $newuser->expense=$_POST['expense'];   
  $result=$newuser->editAccounts();
  
  if($result)
  {
    header("Location:mainpage.php");
    exit;     
  }
  else{
  echo '<div class="center transparentred"> ';
  echo "Some Error Occured";
  echo '</div>';
  }
}
if(isset($_POST['saveAccounts']))
{
      include_once("functions.php");
      $u=new USER();
      $u->branchno=$_POST['saveAccounts'];
      $u->income=$_POST['income'];
      $u->expense=$_POST['expense'];
      if($_SESSION['date']=='today'){
        $u->date=date('Y-m-d');
      }
      else{
        $u->date=date('Y-m-d',strtotime($_SESSION['date']));
      }
      $result=$u->addAccounts();
      if($result)
      {
        header('Location:mainpage.php');
        exit;
      }
      else
      {
        echo '<div class="center transparentred"> ';
        echo "Some Error Occured.Contact Developer";
        echo '</div>';
      }
}
function contains($a,$b)
{
  return strpos($b,$a) !== false;#check if a exists in b
}
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Income and Expense Tracker</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<meta charset="utf-8">


<style>
select{
  color:red;
 }
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: rgba(136,136,136,0.5);

  border: none;
  color: white;
  text-align: center;
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
  content: '\00bb';
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






/* change the link color */
.navbar-custom .navbar-nav .nav-link {
    color: white;
}



/* for dropdown only - change the color of droodown */
.navbar-custom .dropdown-menu {
    background-color:#a9b0a5;
}
.navbar-custom .dropdown-item {
    color: red ;
}
.navbar-custom {
    background-color: #ff5500;
}





.transparent {
  background-color: rgba(136,136,136,0.9);
}
.teal{
  background-color: rgba(0,136,136,0.6);
}
.transparentred {
  background-color: rgba(255, 20,0,0.6);
  color:white;
}
.semitransparent {
  background-color: rgba(3,252,6,0.79);
}
.transparentgrey{
  background-color: rgba(136,136,136,0.7);
}
.transparentgrey2{
  background-color: rgba(136,136,136,0.9);
}
.transparentbutton {
  background-color: rgba(0,90,0,0.5);
  color: white;
}
.tablegreen{
  background-color: rgba(0,90,0,0.5);
}
.tablered{
  background-color: rgba(255, 20,0,0.6);
}
.tableblue{
  background-color: rgba(20, 20,200,0.6);
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
  border: 10px solid grey;
  padding: 10px;
  text-align: center;
  color:white;
}
body {
  font-family: Arial, Helvetica, sans-serif;
}
th{
  background-color:rgba(0,156,160,0.5);
  height:30px;
  text-align: center ;
  font-weight: 700;
}
td{
  height: 80px;
  
}
p {
   margin-top:0px;
   margin-bottom:0px
}




.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 35px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color:rgba(255, 20,0,0.6);
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
  background-color:rgba(0,90,0,0.5);
}

.slider.round:before {
  border-radius: 50%;
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
.scrollme {
    overflow-x: auto;
}
option {
    background-color: white !important;
}



</style>
<head>
<body background="images/3.jpeg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
  <button onclick="topFunction()" id="myBtn" title="Go to top" style='font-size:25px;'><B>^</B></button>
  <nav class="navbar  navbar-expand-sm navbar-custom  transparentgrey" style='height: 70px;'>
  
    <h1 style="color:white;">Company Name</h1>
    <ul class="navbar-nav mx-auto">
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><b>Options</b></a>
      <div class="dropdown-menu">
      <a class="dropdown-item" href="manageBranches.php">Manage Branches</a>
      <a class="dropdown-item" href="?fn=changePass">Change Administrator Password</a>
      </div>
      </li>
   </ul>

   <a  href="logout.php" class="button btn btn-danger  transparentgrey"  style="vertical-align:middle;float:right;"><span>log out</span></a><br><br><br>
  </nav>





  <div class="d-flex p-2 justify-content-center">
  <br>
  <div class="alert alert-success transparentgrey"  style="width:1400px;" >
    <div class="alert alert-success" style="background-color:rgba(0,136,136,0.5);color:white;height: 55px;text-align:center">
    <a class='btn btn-success transparentbutton' style='font-size:17px;float:left;padding:5px 7px;' href='?viewmode=today'>Daily Entries</a>
    <a class='btn btn-success transparentbutton' style='font-size:17px;padding:6px 10px;' href='?fn=previousDate' id='previousdate'><</a>       
    <?php
    if(isset($_SESSION['date']))
    {
      if($_SESSION['date']=='today')
      {
        echo "<a class='btn btn-success transparentbutton' style='font-size:25px;padding:0px 7px;' id='datetoday' href='?fn=selectDate'>".date('d/m/Y,l')."</a>"; 
      }
      else{
        echo "<a class='btn btn-success transparentbutton' style='font-size:25px;padding:0px 7px;' id='datetoday' href='?fn=selectDate'>".date('d/m/Y,l',strtotime($_SESSION['date']))."</a>";
      }
    }
    else{
      echo "<a class='btn btn-success transparentbutton' style='font-size:25px;padding:0px 7px;' id='datetoday' href='?fn=selectDate'>".date('d/m/Y,l')."</a>"; 
    }
     ?>
     <a class='btn btn-success transparentbutton' style='font-size:17px;padding:6px 10px;' href='?fn=nextDate' id='nextdate'>></a> 
       <a class='btn btn-success transparentbutton' style='font-size:17px;float:right;padding:5px 7px;display:none;' href='?fn=selectBranches' id='branchselect'>Select Branches</a>
       <button type="button" class="btn btn-success transparentbutton dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style='font-size:17px;padding:5px 7px;float:right;'>
        Show Report in
      </button>
      <div class="dropdown-menu" style='background-color:rgba(0,136,136,0.9);'>
        <a class="dropdown-item" href="?viewmode=day">Days</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="?viewmode=month">Months</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="?viewmode=year">Years</a>
      </div>
      
      <?php if(isset($_GET['viewmode'])){
         $_SESSION['previousviewmode']=$_GET['viewmode'];
       }?>

    </div>
    <?php 
    if(isset($_GET['viewmode'])&&$_GET['viewmode']=='day'){echo"
    <a  class='btn btn-success transparentbutton' style='font-size:20px;float:left;' id='period' href='?fn=selectPeriod'><p style='font-size:10px;color:white'>Select Date Range</p><p style='font-size:18px;'>".$_SESSION['period']."</p></a>.
    <form action='' method='post'><button type='submit'  class='btn btn-success transparentbutton' name='create_pdf' style='font-size:18px;float:right;' >Generate PDF</button></form><br><br>";
    }
    if(isset($_GET['viewmode'])&&$_GET['viewmode']=='month'){echo"
      <a  class='btn btn-success transparentbutton' style='font-size:20px;float:left;' id='period' href='?fn=selectMonths'><p style='font-size:10px;color:white'>Select Month Range</p><p style='font-size:18px;'>".$_SESSION['period']."</p></a>.
      <form action='' method='post'><button type='submit'  class='btn btn-success transparentbutton' name='create_pdf' style='font-size:18px;float:right;' >Generate PDF</button></form><br><br>";
    }
    if(isset($_GET['viewmode'])&&$_GET['viewmode']=='year'){echo"
        <a  class='btn btn-success transparentbutton' style='font-size:20px;float:left;' id='period' href='?fn=selectYears'><p style='font-size:10px;color:white'>Select Year Range </p><p style='font-size:18px;'>".$_SESSION['period']."</p></a>.
        <form action='' method='post'><button type='submit'  class='btn btn-success transparentbutton' name='create_pdf' style='font-size:18px;float:right;' >Generate PDF</button></form><br><br>";
    }
    ?>
    <div style="text-align:center;height: 25px;">
    <span  class="alert" style="background-color:green;color:white;">
      <span style="font-size:10px;">Gross Income:&nbsp<text id='grossincome' style="font-size:20px;"></text></span>
    </span>&nbsp
    <span  class="alert" style="background-color:red;color:white;">
      <span style="font-size:10px;">Gross Expense:&nbsp<text id='grossexpense' style="font-size:20px;"></text></span>
    </span>&nbsp
    <span  class="alert" style="background-color:blue;color:white;">
      <span style="font-size:10px;">Gross Profit:&nbsp<text id='grossprofit' style="font-size:20px;"></text></span>
  
    </span>
    </div>

      <br><div id='branchcards' style='display:block;'>
      <?php     
                $totalincome=0;
                $totalexpense=0;
                $totalprofit=0;
                include_once('functions.php');
                $user=new USER();
                $result=$user->getBranches();
                if ($result->num_rows > 0) {
                    echo "<div class='row'>";
                    while($branch=mysqli_fetch_array($result)) 
                        {
                          $us=new USER();
                          $us->branchno=$branch['branchno'];
                          if($_SESSION['date']=='today'){
                            $us->date=date('Y-m-d');
                          }
                          else{
                            $us->date=date('Y-m-d',strtotime($_SESSION['date']));
                          }
                          $res=$us->getAccounts();
                          if($res->num_rows > 0){
                            $accounts=mysqli_fetch_array($res);
                            $profit=$accounts['income']-$accounts['expense'];
                            $editAccountsAddress="mainpage.php?fn=editAccounts&income=".$accounts['income'].
                                  "&expense=".$accounts['expense']."&branchno=".$accounts['branchno'].
                                  "&date=".$accounts['date'];
                            $totalincome+=$accounts['income'];
                            $totalexpense+=$accounts['expense'];
                            $totalprofit+=$profit;
                          
                            echo "
                            <div class='col-sm-6 col-lg-4'>
                              <div id='branchcard' class='card  mb-3 transparentbutton' style='max-width: 15rem;color:white;border:4px solid darkgreen'>
                                <div class='card-header'><h5>".$branch['branchname']."</h5></div>
                              <div class='card-body' id='cardbody' style='text-align:center;' >
                                    <div  style='background-color:rgba(3,252,6,0.5);color:white;'>&nbspIncome Today:&nbsp" 
                                    .$accounts['income']."</div><br>
                                    <div  style='background-color:rgba(255, 20,0,0.6);color:white'>
                                    &nbspExpense Today:&nbsp".$accounts['expense']."</div><br>
                                    <div  style='background-color:rgba(20, 20,200,0.6);color:white'>
                                    &nbspProfit Today:&nbsp".$profit."</div><br>
                                    <a class='btn btn-danger btn-block teal' href='$editAccountsAddress' style='border:1px solid teal'>Edit</a></td>
                              </div>
                              </div>
                            </div>";
                          }
                          else{
                            echo "
                            <div class='col-sm-6 col-lg-4'>
                              <div id='branchcard' class='card  mb-3' style='max-width: 15rem;background-color:rgba(0,136,136,0.5);color:white;border:4px solid teal'>
                                <div class='card-header'><h5>".$branch['branchname']."</h5></div>
                              <div class='card-body' id='cardbody' style='text-align:center;'>
                                <form action='' method='post'>
                                <div class='form-group mb-3 form-group-sm'>
                                  <label for='income'>Income</label><br>
                                  <input type='number' onkeypress='return event.charCode >= 48' min='0' name='income' required'>
                                </div>
                                <div class='form-group mb-3 form-group-sm' >
                                  <label for='expense'>Expense</label><br>
                                  <input type='number' onkeypress='return event.charCode >= 48' min='0' name='expense' required >
                                </div>              
                                <button type='submit' class='btn btn-success form-control btn-block transparentgrey' name='saveAccounts' value='".$branch['branchno']."' >Save</button></td>
                                </form>
                              </div>
                              </div>                  
                            </div>";
                            
                            }
                            
                        }  
                  echo "</div>"; 
                      }else{
                                echo '<div class="center transparentred"> ';
                                echo "No Branches Added";
                                echo '</div>';
                      }

                      //going to set todays total income,expense and profit
                      echo"<script> 
                      grossincome.textContent=".$totalincome."
                      grossexpense.textContent=".$totalexpense."
                      grossprofit.textContent=".$totalprofit." 
                      </script>";
                    ?>
          </div>
 


    <?php if((isset($_GET['viewmode']) && $_GET['viewmode']=='day')||(isset($_SESSION['previousviewmode']) && $_SESSION['previousviewmode']=='day'))
    {              
      if(contains('/',$_SESSION['period'])==false)
      {
        $_SESSION['period']="All Time";//to avoid problems with different time ranges while switching viewmodes
        echo "<script>
        document.getElementById('period').innerHTML='<h6>Select Date Range</h6>'+'<p>All Time<p>'</script>";
      }
      include_once('functions.php');
      $userd=new USER();
      $userd->branchnos=$_SESSION['brancheslist'];
      $resultd=$userd->getBranchNames();
      echo"       <script>$('#branchselect').show();$('#datetoday').hide();$('#previousdate').hide();$('#nextdate').hide();</script>
                  <div id='daytable' class='scrollme'>
                  <table class='table table-striped table-bordered' style='color:white;text-align:center;'>";                   
                      echo "<div>
                      <thead>
                          <tr>
                          <th rowspan='2'>Date</th>";
                          while($rowd = $resultd->fetch_assoc()) 
                          {
                            echo"<th colspan='3' style='border-right: 3px solid black;'>".$rowd['branchname']."</th>";              
                          }
                          echo "</tr><tr>";
                          $size=0;
                          for($i=0;$i<count($userd->branchnos);$i++)
                          {
                            $size++;//for creating total arrays
                            echo"<th style='background-color:green'>Income</th>
                            <th style='background-color:red'>Expense</th><th style='background-color:blue;border-right: 3px solid black;'>Profit</th>";              
                          }echo"</tr>                                     
                     </thead>
                     <tbody>";
                      $totalincome = array_fill(0, $size,0);//for creating total arrays
                      $totalexpense = array_fill(0, $size,0);
                      $totalprofit = array_fill(0, $size,0);
                      $userd->branchnos=$_SESSION['brancheslist'];
                      if($_SESSION['period']=='All Time')
                      {
                        $resultd=$userd->getMinDate();
                        $rowd = $resultd->fetch_assoc();
                        $maxdate=date('d-m-Y');
                        $mindate=date("d-m-Y", strtotime($rowd['mindate']));
                      }
                      else{
                        $maxdate=date('d-m-Y',strtotime($_SESSION['to']));
                        $mindate=date('d-m-Y',strtotime($_SESSION['from']));
                      }
                      $d1=new DateTime($maxdate); 
                      $d2=new DateTime($mindate);                                 
                      $interval = $d2->diff($d1); 
                      $noOfDays=$interval->days+1;
                      for($i=0;$i<$noOfDays;$i++)
                      {     

                              $userd->date=$mindate;
                              $res=$userd->checkNullRowDay();
                              if($res->num_rows==0)
                              {
                              $mindate = date('d-m-Y', strtotime($mindate .' +1 day'));
                              continue;
                              }
                          
                          echo"<tr><td style='background-color:rgba(136,136,136,0.9);'><b>".$mindate."</b></td>";
                          $userd->date=$mindate;
                          $brcounter=0;
                          while($brcounter<count($userd->branchnos))
                          {
                              $userd->branchno=$userd->branchnos[$brcounter];
                              $resultd=$userd->getAccountsByDay();
                              if($resultd->num_rows > 0)
                              {
                                $rowd = $resultd->fetch_assoc();
                                $profit=$rowd['income']-$rowd['expense'];
                                $totalincome[$brcounter]+=$rowd['income'];
                                $totalexpense[$brcounter]+=$rowd['expense'];
                                $totalprofit[$brcounter]+=$profit;
                                echo"<td class='tablegreen'>".$rowd['income']."</td><td class='tablered'>".$rowd['expense'].
                                    "</td><td style='border-right: 3px solid black;' class='tableblue'>".$profit."</td>";
                              }
                              else
                              {
                                echo"<td>0</td><td>0</td><td style='border-right: 3px solid black;'>0</td>"; 
                              }
                              $brcounter+=1;
                          }
                          echo"</tr>";
                          $mindate = date('d-m-Y', strtotime($mindate .' +1 day'));
                      }echo"<tr><th style='background-color:transparentbutton'>Total</th>";
                      for($i=0;$i<count($userd->branchnos);$i++)
                      {
                        echo"<th style='color:green;background-color:rgba(136,136,136,1);'>".$totalincome[$i]."</th><th style='color:red;background-color:rgba(136,136,136,0.9);'>".$totalexpense[$i].
                              "</th><th style='color:blue;background-color:rgba(136,136,136,0.9);border-right: 3px solid black;'>".$totalprofit[$i]."</th>";
                      }
                      echo"
                      
                      </tr>
                    </tbody> 
            </table>
            </div>
            <script> 
            window.onload = function(){
            document.getElementById('branchcards').style.display='none';
            grossincome.textContent=".array_sum($totalincome)."
            grossexpense.textContent=".array_sum($totalexpense)."
            grossprofit.textContent=".array_sum($totalprofit)." 
            };
            </script>";
     
      }
      ?>
    <?php if((isset($_GET['viewmode']) && $_GET['viewmode']=='month')||(isset($_SESSION['previousviewmode']) && $_SESSION['previousviewmode']=='month'))
    {
      if(ctype_alpha(explode(" ",$_SESSION['period'])[0])==false)
      {
        $_SESSION['period']="All Time";//to avoid problems with different time ranges while switching viewmodes
        echo "<script>
        document.getElementById('period').innerHTML='<h6>Select Month Range</h6>'+'<p>All Time<p>'</script>";
      }
      include_once('functions.php');
      $userd=new USER();
      $userd->branchnos=$_SESSION['brancheslist'];
      $resultd=$userd->getBranchNames();
      echo"   <script>$('#branchselect').show();$('#datetoday').hide();$('#previousdate').hide();$('#nextdate').hide();</script>
              <div id='monthtable' class='scrollme'>
              <table class='table table-striped table-bordered' style='color:white;text-align:center'>";                   
                      echo "<div>
                      <thead>
                          <tr>
                          <th rowspan='2'>Date</th>";
                          while($rowd = $resultd->fetch_assoc()) 
                          {
                            echo"<th colspan='3' style='border-right: 3px solid black;'>".$rowd['branchname']."</th>";              
                          }
                          echo "</tr><tr>";
                          $size=0;
                          for($i=0;$i<count($userd->branchnos);$i++)
                          {
                            $size++;//for creating total arrays
                            echo"<th style='background-color:green'>Income</th>
                            <th style='background-color:red'>Expense</th><th style='background-color:blue;border-right: 3px solid black;'>Profit</th>";              
                          }echo"</tr>                                     
                     </thead>
                     <tbody>";
                      $totalincome = array_fill(0, $size,0);//for creating total arrays
                      $totalexpense = array_fill(0, $size,0);
                      $totalprofit = array_fill(0, $size,0);
                      $userd->branchnos=$_SESSION['brancheslist'];
                      if($_SESSION['period']=='All Time')
                      {
                        $resultd=$userd->getMinDate();
                        $rowd = $resultd->fetch_assoc();
                        $maxdate=date('d-m-Y');
                        $mindate=date("d-m-Y", strtotime($rowd['mindate']));
                      }
                      else{
                        if(date('d',strtotime($_SESSION['from']))=='1')
                        {
                          $mindate=$_SESSION['from'];
                        }
                        else{
                          $mindate=new dateTime($_SESSION['from']);
                          $mindate=$mindate->modify('first day of next month');
                          $mindate=$mindate->format('d-m-Y');
                        }
                        if(date("t", strtotime($_SESSION['to']))==date('d',strtotime($_SESSION['to'])))
                        {
                         $maxdate=$_SESSION['to'];
                        }
                        else{
                          $maxdate=new dateTime($_SESSION['to']);
                          $maxdate=$maxdate->modify('last day of previous month');
                          $maxdate=$maxdate->format('d-m-Y');
                        }
                    
                      }
                      $d1=new DateTime($maxdate); 
                      $d2=new DateTime($mindate); 
                      //echo $mindate."/".$maxdate;                                 
                      $interval = $d2->diff($d1); 
                      $noOfMonths = (($interval->y) * 12) + ($interval->m)+2;
                      for($i=0;$i<$noOfMonths;$i++)
                      {
                        $userd->date=$mindate;
                        $res=$userd->checkNullRowMonth();
                        if($res->num_rows==0)
                        {
                        $mindate = date('d-m-Y', strtotime($mindate .' +1 month'));
                        continue;
                        }

                          echo"<tr><td style='background-color:rgba(136,136,136,0.9);'><b>".date('F Y',strtotime($mindate))."</b></td>";
                          $userd->date=$mindate;
                          $brcounter=0;
                          while($brcounter<count($userd->branchnos))
                          {
                              $userd->branchno=$userd->branchnos[$brcounter];
                              $resultd=$userd->getAccountsByMonth();
                              if($resultd->num_rows > 0)
                              {
                                $rowd = $resultd->fetch_assoc();
                                $profit=$rowd['income']-$rowd['expense'];
                                $totalincome[$brcounter]+=$rowd['income'];
                                $totalexpense[$brcounter]+=$rowd['expense'];
                                $totalprofit[$brcounter]+=$profit;
                                echo"<td class='tablegreen'>".$rowd['income']."</td><td class='tablered'>".$rowd['expense'].
                                    "</td><td style='border-right: 3px solid black;' class='tableblue'>".$profit."</td>";
                              }
                              else
                              {
                                echo"<td>0</td><td>0</td><td style='border-right: 3px solid black;'>0</td>"; 
                              }
                              $brcounter+=1;
                          }
                          echo"</tr>";
                          $mindate = date('d-m-Y', strtotime($mindate .' +1 month'));
                      }echo"<tr><th style='background-color:transparentbutton'>Total</th>";
                      for($i=0;$i<count($userd->branchnos);$i++)
                      {
                        echo"<th style='color:green;background-color:rgba(136,136,136,1);'>".$totalincome[$i]."</th><th style='color:red;background-color:rgba(136,136,136,0.9);'>".$totalexpense[$i].
                              "</th><th style='color:blue;background-color:rgba(136,136,136,0.9);border-right: 3px solid black;'>".$totalprofit[$i]."</th>";
                      }
                      echo"
                      
                      </tr>
                    </tbody> 
            </table>
            </div>
            <script> 
            window.onload = function(){
            document.getElementById('branchcards').style.display='none';
            grossincome.textContent=".array_sum($totalincome)."
            grossexpense.textContent=".array_sum($totalexpense)."
            grossprofit.textContent=".array_sum($totalprofit)." 
            };
            </script>";
    }
    ?>
    <?php if((isset($_GET['viewmode']) && $_GET['viewmode']=='year')||(isset($_SESSION['previousviewmode']) && $_SESSION['previousviewmode']=='year'))
    {
      if((ctype_alpha(explode(" ",$_SESSION['period'])[0])==true) || contains('/',$_SESSION['period']))
      {
        $_SESSION['period']="All Time";//to avoid problems with different time ranges while switching viewmodes
        echo "<script>
        document.getElementById('period').innerHTML='<h6>Select Year Range</h6>'+'<p>All Time<p>'</script>";
      }
      include_once('functions.php');
      $userd=new USER();
      $userd->branchnos=$_SESSION['brancheslist'];
      $resultd=$userd->getBranchNames();
      echo"   <script>$('#branchselect').show();$('#datetoday').hide();$('#previousdate').hide();$('#nextdate').hide();</script>
      <div id='yeartable' class='scrollme'>
              <table class='table table-striped table-bordered' style='color:white;text-align:center'>";                   
                      echo "<div>
                      <thead>
                          <tr>
                          <th rowspan='2'>Date</th>";
                          while($rowd = $resultd->fetch_assoc()) 
                          {
                            echo"<th colspan='3' style='border-right: 3px solid black;'>".$rowd['branchname']."</th>";              
                          }
                          echo "</tr><tr>";
                          $size=0;
                          for($i=0;$i<count($userd->branchnos);$i++)
                          {
                            $size++;//for creating total arrays
                            echo"<th style='background-color:green'>Income</th>
                            <th style='background-color:red'>Expense</th><th style='background-color:blue;border-right: 3px solid black;'>Profit</th>";              
                          }echo"</tr>                                     
                     </thead>
                     <tbody>";
                      $totalincome = array_fill(0, $size,0);//for creating total arrays
                      $totalexpense = array_fill(0, $size,0);
                      $totalprofit = array_fill(0, $size,0);
                      $userd->branchnos=$_SESSION['brancheslist'];
                      if($_SESSION['period']=='All Time')
                      {
                        $resultd=$userd->getMinDate();
                        $rowd = $resultd->fetch_assoc();
                        $maxdate=date('d-m-Y');
                        $mindate=date("d-m-Y", strtotime($rowd['mindate']));
                        $d1=new DateTime($maxdate); 
                        $d2=new DateTime($mindate);                            
                        $interval = $d2->diff($d1); 
                        $noOfYears = $interval->y;
                        $noOfYears=$noOfYears;
                      }
                      else
                      {
                        $mindate=date('d-m-Y',strtotime($_SESSION['from']."/01/01"));
                        $maxdate=date('d-m-Y',strtotime($_SESSION['to']."/01/01"));
                        $noOfYears=$_SESSION['to']-$_SESSION['from'];
                      }          
                      for($i=0;$i<=$noOfYears;$i++)
                      {
                        $userd->date=$mindate;
                        $res=$userd->checkNullRowYear();
                        if($res->num_rows==0)
                        {
                        $mindate = date('d-m-Y', strtotime($mindate .' +1 year'));
                        continue;
                        }

                          echo"<tr><td style='background-color:rgba(136,136,136,0.9);'><b>".date('Y',strtotime($mindate))."</b></td>";
                          $userd->date=$mindate;
                          $brcounter=0;
                          while($brcounter<count($userd->branchnos))
                          {
                              $userd->branchno=$userd->branchnos[$brcounter];
                              $resultd=$userd->getAccountsByYear();
                              if($resultd->num_rows > 0)
                              {
                                $rowd = $resultd->fetch_assoc();
                                $profit=$rowd['income']-$rowd['expense'];
                                $totalincome[$brcounter]+=$rowd['income'];
                                $totalexpense[$brcounter]+=$rowd['expense'];
                                $totalprofit[$brcounter]+=$profit;
                                echo"<td class='tablegreen'>".$rowd['income']."</td><td class='tablered'>".$rowd['expense'].
                                    "</td><td style='border-right: 3px solid black;' class='tableblue'>".$profit."</td>";
                              }
                              else
                              {
                                echo"<td>0</td><td>0</td><td style='border-right: 3px solid black;'>0</td>"; 
                              }
                              $brcounter+=1;
                          }
                          echo"</tr>";
                          $mindate = date('d-m-Y', strtotime($mindate .' +1 year'));
                      }echo"<tr><th style='background-color:transparentbutton'>Total</th>";
                      for($i=0;$i<count($userd->branchnos);$i++)
                      {
                        echo"<th style='color:green;background-color:rgba(136,136,136,1);'>".$totalincome[$i]."</th><th style='color:red;background-color:rgba(136,136,136,0.9);'>".$totalexpense[$i].
                              "</th><th style='color:blue;background-color:rgba(136,136,136,0.9);border-right: 3px solid black;'>".$totalprofit[$i]."</th>";
                      }
                      echo"
                      
                      </tr>
                    </tbody> 
            </table>
            </div>
            <script> 
            window.onload = function(){
            document.getElementById('branchcards').style.display='none';
            grossincome.textContent=".array_sum($totalincome)."
            grossexpense.textContent=".array_sum($totalexpense)."
            grossprofit.textContent=".array_sum($totalprofit)." 
            };
            </script>";
    }
  ?>


 
    
</div>
</div>
  


<div id='editAccountsDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="post">
        <div class="form-group">
            <label for="income">Income</label>
            <input type="number"  name="income" id="income" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="expense">Expense</label><br>
            <input type="number"  name="expense" id="expense" class="form-control" required>
        </div><br><br>
        <button type="submit" class="btn btn-success form-control btn-block" name='editAccounts' >Done</button>
        <a class='btn btn-success form-control btn-block '  href='mainpage.php'>Exit</a>
      </form>
      </div>
</div>
<div id='changePassDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="post">
        <div class="form-group">
            <label for="newpass1">New Administrator Password</label>
            <input type="password"  name="newpass1" id="newpass1" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="newpass2">Confirm new Administrator Password</label>
            <input type="password"  name="newpass2" id="newpass2" class="form-control" required>
        </div>
        <br><br>
        <button type="submit" class="btn btn-success form-control btn-block" name='changePass' >Done</button>
        <a class='btn btn-success form-control btn-block '  href='mainpage.php'>Exit</a>
      </form>
      </div>
      <?php
        if(isset($_POST['changePass']))
        {
            
                if($_POST['newpass1']==$_POST['newpass2'])
                  {
                      include_once("functions.php");
                      $user=new USER(); 
                      $user->pass=$_POST['newpass1'];
                      $result=$user->ChangePassword();
                      if($result)
                      {
                          echo '<div class="alert alert-success"> ';
                          echo "<br>Password Successfully Updated :)";
                          echo '</div>';
                      }
                  }
                  else{
                          echo '<div class="alert alert-danger"> ';
                          echo "<br>Passwords are not matching :(";
                          echo '</div>';
                  }
                
        }
        ?>
</div>

<div id='selectBranchesDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="get">
      <?php           
                      include_once('functions.php');
                      $us1=new USER();
                      $res1=$us1->getBranches();
                      $options="";
                      if ($res1->num_rows > 0) 
                      { while($row1 = mysqli_fetch_array($res1))
                        {
                              if(isset($_SESSION['brancheslist']))
                              {
                                if ( in_array($row1[0], $_SESSION['brancheslist']))
                                {
                                  $options = $options."<option value=$row1[0] selected>$row1[1]</option>";
                                }
                                else
                                {
                                  $options = $options."<option value=$row1[0]>$row1[1]</option>";
                                }
                              }
                              else{
                                $options = $options."<option value=$row1[0]>$row1[1]</option>";
                              }
                           
                        }echo"
                        <select name='brancheslist[]' id='selectbox' multiple >".$options;?>
                        </select><br><br>
                        <button type='submit' class='btn btn-success form-control' name='branchesSelected' style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>Done</button>
                        </form>
                        </div><?php
                      }
                      else
                      {
                        echo '<br><div class="center transparentred"> ';
                        echo "No Branches Added";
                        echo '</div>';
                      }
        ?>
</div>
<div id='selectPeriodDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="get">
                        <BR>
                        <?php
                        if(isset($_SESSION['from'])){
                        echo"
                        <label for='from'></label>
                        <input type='date' id='from' name='from' value=".$_SESSION['from'].">
                        <BR>To<BR>
                        <label for='to'></label>
                        <input type='date' id='to' name='to' value=".$_SESSION['to'].">
                        ";}
                        else{
                          echo"
                        <label for='from'></label>
                        <input type='date' id='from' name='from'>
                        <BR>To<BR>
                        <label for='to'></label>
                        <input type='date' id='to' name='to'>
                        ";
                        }?>
                        <BR><BR>
                        <button type='submit' class='btn btn-success form-control ' name='periodalltime'  style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>All Time</button><br><br>
                        <button type='submit' class='btn btn-success form-control' name='periodselected' onclick='return checkDateRange()' style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>Done</button>
                        </form>
                        </div>
                        
</div>
<div id='selectYearsDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="get">
                        <BR>
                        <?php
                          echo"
                        <label for='monthfrom'></label>
                        <input type='number' id='yearfrom' name='yearfrom'>
                        <BR>To<BR>
                        <label for='yearto'></label>
                        <input type='number' id='yearto' name='yearto'>
                        ";
                        ?>
                        <BR><BR>
                        <button type='submit' class='btn btn-success form-control ' name='periodalltime'  style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>All Time</button><br><br>
                        <button type='submit' class='btn btn-success form-control' name='yearsselected' onclick='return checkYearRange()' style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>Done</button>
                        </form>
                        </div>
                        
</div>
<div id='selectMonthsDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.4);">
    <br><br><br><br><br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="get">
                        <BR>
                        <?php
                          echo"
                        <label for='monthfrom'></label>
                        <input type='month' id='monthfrom' name='monthfrom'>
                        <BR>To<BR>
                        <label for='monthto'></label>
                        <input type='month' id='monthto' name='monthto'>
                        ";
                        ?>
                        <BR><BR>
                        <button type='submit' class='btn btn-success form-control ' name='periodalltime'  style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>All Time</button><br><br>
                        <button type='submit' class='btn btn-success form-control' name='monthsselected' onclick='return checkMonthRange()' style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>Done</button>
                        </form>
                        </div>
                        
</div>
<div id='selectDateDiv' class='overlaydiv' style="display:none;background:rgba(0,136,136,0.8);">
    <br><br><br><br><br><br><br><br><br><br><br>
    <div class="center transparent" style="border:1px solid white;"> 
      <form action="" method="get">
                        <BR>
                        <?php
                        if(isset($_SESSION['date'])&& $_SESSION['date']!='today'){
                        echo"
                        <label for='date'></label>
                        <input type='date' id='date' name='date' value=".$_SESSION['date'].">
                        ";}
                        else{
                          echo"
                        <label for='date'></label>
                        <input type='date' id='date' name='date' value=".date('Y-m-d').">
                        ";
                        }?>
                        <BR><BR>
                        <button type='submit' class='btn btn-success form-control ' name='todaysdate'  style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>Today</button><br><br>
                        <button type='submit' class='btn btn-success form-control' name='dateselected'  style='width:25%;text-align:center;background-color:rgba(0,136,136,0.9);'>Done</button>
                        </form>
                        </div>
                        
</div>
</body>
</HTML>
<script>

function checkDateRange()
{
   var f = $("#from").val();
   var t= $("#to").val();
  if(f>t || f==t){
  alert('Invalid Date Range');
  return false;
  }
  return true;
}
function checkMonthRange()
{
   var f = $("#monthfrom").val();
   var t= $("#monthto").val();
  if(f>t || f==t){
  alert('Invalid Date Range');
  return false;
  }
  return true;
}
function checkYearRange()
{
   var f = $("#yearfrom").val();
   var t= $("#yearto").val();
  if(f>t || f==t){
  alert('Invalid Date Range');
  return false;
  }
  return true;
}
function changePassTab()
{
  var x=document.getElementById("changePassDiv");
  if(x.style.display === "none")
  {
    x.style.display = "block";
  }
}
function editAccountsTab()
{
  var x=document.getElementById("editAccountsDiv");
  if(x.style.display === "none")
  {
    x.style.display = "block";
  }
}
function selectPeriodTab()
{
  var x=document.getElementById("selectPeriodDiv");
  if(x.style.display === "none")
  {
    x.style.display = "block";
  }
}
function selectMonthsTab()
{
  var x=document.getElementById("selectMonthsDiv");
  if(x.style.display === "none")
  {
    x.style.display = "block";
  }
}
function selectYearsTab()
{
  var x=document.getElementById("selectYearsDiv");
  if(x.style.display === "none")
  {
    x.style.display = "block";
  }
}
function selectDate()
{
  var x=document.getElementById("selectDateDiv");
  if(x.style.display === "none")
  {
    x.style.display = "block";
  }
}
function selectBranchesTab()
{
  var x=document.getElementById("selectBranchesDiv");
  if(x.style.display === "none")
  {
    x.style.display = "block";
  }
}

window.onmousedown = function (e) 
{
    var el = e.target;
    if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
        e.preventDefault();

        // toggle selection
        if (el.hasAttribute('selected')) el.removeAttribute('selected');
        else el.setAttribute('selected', '');

        // hack to correct buggy behavior
        var select = el.parentNode.cloneNode(true);
        el.parentNode.parentNode.replaceChild(select, el.parentNode);
    }
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
	if($_GET['fn']=="editAccounts")
    {
      echo "<script  type='text/javascript'>
              editAccountsTab();
              document.getElementById('income').setAttribute('value','".$_GET['income']."');
              document.getElementById('expense').setAttribute('value','".$_GET['expense']."');
             </script>";
      
  } 
  if($_GET['fn']=="changePass")
    {
      echo "<script  type='text/javascript'>   
      changePassTab();
              
       </script>";
      
  }   

  if($_GET['fn']=='selectPeriod')
  {
    echo"<script>
    selectPeriodTab();
    </script>";

  }
  if($_GET['fn']=='selectMonths')
  {
    echo"<script>
    selectMonthsTab();
    </script>";

  }
  if($_GET['fn']=='selectYears')
  {
    echo"<script>
    selectYearsTab();
    document.getElementByID('from').setAttribute('value','".$_SESSION['from']."');
    document.getElementByID('to').setAttribute('value','".$_SESSION['to']."');
    </script>";

  }
  if($_GET['fn']=='selectDate')
  {
    echo"<script>
    selectDate();
    </script>";
  }
  

  if($_GET['fn']=='selectBranches')
  {
    echo"<script> 
    selectBranchesTab();
    </script>";         
  }
} 
if(isset($_GET['viewmode'])&& $_GET['viewmode']=='today')
{
  echo"<script>
  window.onload = function(){
    document.getElementById('branchcards').style.display='block';  
    };</script>";
}
if(isset($_POST['create_pdf']))
{
  if($_GET['viewmode']=="day"){
   echo"<script>var sTable = document.getElementById('daytable').innerHTML;</script>";}
  else if($_GET['viewmode']=="month"){
  echo"<script>var sTable = document.getElementById('mothtable').innerHTML;</script>";}
  else if($_GET['viewmode']=="year"){
  echo"<script>var sTable = document.getElementById('yeartable').innerHTML;</script>";}
  
  echo"<script>
  var style = '<style>';
  style = style + 'table {width: 100%;font: 17px Calibri;}';
  style = style + 'table, th, td,tr {border: solid 1px black; border-collapse: collapse;color:black;width:25%;';
  style = style + 'padding: 2px 3px;text-align: center;}';
  style = style + '</style>';

  // CREATE A WINDOW OBJECT.
  var win = window.open('', '', 'height=700,width=700');

  win.document.write('<html><head>');
  win.document.write('<title>Company Name</title>');   // <title> FOR PDF HEADER.
  win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
  win.document.write('</head>');
  win.document.write('<body>');
  win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
  win.document.write('</body></html>');

  win.document.close(); 	// CLOSE THE CURRENT WINDOW.

  win.print();  
  </script>";

}
?>

