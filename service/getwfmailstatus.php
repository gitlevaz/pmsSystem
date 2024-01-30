	<?php 
   // $connection = include_once('../connection/previewconnection.php');
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
		
	
	
	
	
	$_SelectQuery = "SELECT MailStatus FROM tbl_workflowmailstatus WHERE `EmpId`= '$LogUserCode ' AND `Date`= '$today_date'";
    $_ResultSet = mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));

		while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
			$Status	=	$_myrowRes["MailStatus"];
		}

	
	
	
    echo $Status;
		
	?>