<?php

//$connection = include_once('../connection/connection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');

$empId = $_GET["EmpId"];
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

if($empId != null )
{

	 $updatequery2 = "UPDATE tbl_workflowmailstatus SET `MailStatus`='true' WHERE `EmpId`= '$empId ' AND `Date`= '$today_date'";

	$result =  mysqli_query($link, $updatequery2) or die (mysqli_error($str_dbconnect$connection));
		
 echo $result;
}



 

?>