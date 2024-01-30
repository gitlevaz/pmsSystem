<?php
	//$connection = include_once('../connection/previewconnection.php');
	$connection = include_once('../connection/mobilesqlconnection.php');
	include ("../class/accesscontrole.php");
	$LogUserCode = $_GET["LogUserCode"];
	$Country = $_GET["Country"];
	$previousDate = $_GET["selectedDate"];
	
    if($Country == "SL")
	{
			$timezone = "Asia/Colombo";	
		}
		
	if($Country == "US")
	{
			$timezone = "America/Los_Angeles";
		}
		
	if($Country == "TI")
	{
			$timezone = "Asia/Bangkok";
	}      
	date_default_timezone_set($timezone);
   
	if($previousDate != "")	
	{
		
       $today_date  = $previousDate;
	}
	else{
		 $today_date  = date("Y-m-d");
		
	}
	
    $_SelectQuery = "SELECT count(*) FROM `tbl_workflowmailstatus` WHERE `EmpId`='$LogUserCode' and `Date`='$today_date'";
	$executingQuery=mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
    while($_myrowRes = mysqli_fetch_assoc($executingQuery)) 
		{
            $Result    =	$_myrowRes['count(*)'];
            
			
            
        }
	$Result1 = mysqli_num_rows($executingQuery);
	echo $Result;
	if($Result == 0)
	{
				$InsertQuery 	= "INSERT INTO tbl_workflowmailstatus (`EmpId`,`Date`) VALUES ('$LogUserCode', '$today_date')";
			
			    $insertStatus = mysqli_query($link, $InsertQuery) or die(mysqli_error($str_dbconnect$connection));
			
					if($insertStatus==1)
					{
						echo 'Inserted';
					}
					else
					{
						echo 'Not Inserted';
					}
				
			
    }
	else 
	{
		echo "Already Inserted";
	}
  
	
	
  
  
  
  
  
  
  
?>