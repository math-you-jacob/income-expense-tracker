<?php
error_reporting(0); 
session_start();
if(!isset($_SESSION['loginSuccess']))
{
  header('Location:index.php');
  exit;
}
    include_once("dbconnection.php");
    class USER
    {
		
		function USER()
    	{
    		$this->dbconn=new dbconn();
        }
        function getBranches()
        {
            $sql="SELECT * FROM branches";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function checkNullRowDay()
        {
            $branchnos=$this->branchnos;
            $date=date("Y-m-d", strtotime($this->date));
            $sql="SELECT income FROM accounts WHERE branchno IN(" . implode(',', $branchnos) . ") AND date='$date'";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function checkNullRowMonth()
        {
            $branchnos=$this->branchnos;
            $date=date("Y-m-d", strtotime($this->date));
            $startdate=date('Y-m-01', strtotime($date));
            $lastdate=date('Y-m-t', strtotime($date));
            $sql="SELECT income FROM accounts WHERE branchno IN(" . implode(',', $branchnos) . ") AND (date>='$startdate' AND date<='$lastdate')";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function checkNullRowYear()
        {
            $branchnos=$this->branchnos;
            $date=date("Y-m-d", strtotime($this->date));
            $startdate="January 1st, {$date}";
            $lastdate= "December 31st, {$date}";
            $startdate=date('Y-m-d',strtotime($startdate));
            $lastdate=date('Y-m-d',strtotime($lastdate));
            $sql="SELECT income FROM accounts WHERE branchno IN(" . implode(',', $branchnos) . ") AND (date>='$startdate' AND date<='$lastdate')";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function getBranchNames()
        {
            $branchnos=$this->branchnos;
            $sql="SELECT branchname FROM branches WHERE branchno IN(" . implode(',', $branchnos) . ")";
            $result=$this->dbconn->query($sql);
            return $result;
     
        }
        function getAccounts()
        {
            
            $sql="SELECT * FROM accounts WHERE branchno='$this->branchno' AND date='$this->date'";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function getMinDate()
        {
            $branchnos=$this->branchnos;
            $sql="SELECT MIN(date)AS mindate FROM accounts WHERE branchno IN(" . implode(',', $branchnos) . ")";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function getAccountsByDay()
        {
            $date=date("Y-m-d", strtotime($this->date));
            $sql="SELECT income,expense FROM accounts WHERE branchno='$this->branchno' AND date='$date'";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function getAccountsByMonth()
        {

            
            $date=date("Y-m-d", strtotime($this->date));
            $startdate=date('Y-m-01', strtotime($date));
            $lastdate=date('Y-m-t', strtotime($date));
            $sql="SELECT SUM(income) as income,SUM(expense) as expense FROM accounts WHERE branchno='$this->branchno' AND (date>='$startdate' AND date<='$lastdate')";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function getAccountsByYear()
        {
            $date=date("Y-m-d", strtotime($this->date));
            $startdate="January 1st, {$date}";
            $lastdate= "December 31st, {$date}";
            $startdate=date('Y-m-d',strtotime($startdate));
            $lastdate=date('Y-m-d',strtotime($lastdate));
            $sql="SELECT SUM(income) as income,SUM(expense) as expense FROM accounts WHERE branchno='$this->branchno' AND (date>='$startdate' AND date<='$lastdate')";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function addAccounts()
        {
            $sql="INSERT INTO accounts(branchno,date,income,expense) VALUES('$this->branchno','$this->date','$this->income','$this->expense')";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function editAccounts()
        {
            $sql="UPDATE accounts SET income='$this->income' , expense='$this->expense' WHERE (branchno='$this->branchno' AND date='$this->date')";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function addBranch()
        {
            $sql="INSERT INTO branches(branchname,branchaddress) VALUES('$this->newbranchname','$this->newbranchaddress')";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function editBranch()
        {
            $sql="UPDATE branches SET branchname='$this->branchname',branchaddress='$this->branchaddress' WHERE branchno='$this->branchno'";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function deleteBranch()
        {
            $sql="DELETE FROM accounts WHERE branchno='$this->branchno'";
            $result=$this->dbconn->query($sql);
            $sql="DELETE FROM branches WHERE branchno='$this->branchno'";
            $result=$this->dbconn->query($sql);
            return $result;
        }
        function changePassword()
    	{
			$sql="UPDATE admin SET password='$this->pass'";
    		$result=$this->dbconn->query($sql);
    		return $result;
		}
    }
?>