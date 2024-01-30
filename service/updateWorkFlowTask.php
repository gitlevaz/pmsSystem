<?php
 // $connection = include_once('../connection/connection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php");
  
  
  $UserReview = $_GET["UserReview"];
  $Status = $_GET["Status"];
  $LogUserCode = $_GET["LogUserCode"];
  $TimeCat = $_GET["TimeCat"];
  $TimeSpent = $_GET["TimeSpent"];//EndTime
  $TimeStart = $_GET["TimeStart"];//StartTime
  $WorkflowTaskId = $_GET["WorkflowTaskId"];
  $previousDate = $_GET["selectedDate"];
  
  
  
  if($UserReview!=null && $Status!=null && $LogUserCode!=null && $TimeCat!=null && $TimeSpent!=null && $TimeStart!=null && $WorkflowTaskId!=null)
  {
	  
	//$today_date  = date("Y-m-d");
	//$TimeCat = "Approx. Time Needed";
	
	if($previousDate != "")	
	{
		
        $today_date  = $previousDate;
	}
	else{
		$today_date  = date("Y-m-d");
		
	}
	
	$SelectQuery = "SELECT COUNT(*) FROM tbl_workflowupdate WHERE wk_id = '$WorkflowTaskId' AND crt_date = '$today_date'";
	$executingQuery = mysqli_query($link, $SelectQuery) or die(mysqli_error($str_dbconnect$connection));
	$toRow = mysqli_fetch_assoc($executingQuery);
	
	$resultCount = $toRow["COUNT(*)"];
		
	if($resultCount == 0)
	{
		$SelectFromWF = "SELECT * FROM tbl_workflow WHERE wk_id = '$WorkflowTaskId' LIMIT 1";
		$WFResults 	=   mysqli_query($link, $SelectFromWF) or die(mysqli_error($str_dbconnect$connection));
		
		$resultsFound = 0;

        while($_myrowRes = mysqli_fetch_assoc($WFResults)) {
			
			$resultsFound = 1;
			            
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name  = $_myrowRes['wk_name'];
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc = $_myrowRes['WF_Desc'];
			$WFUser_cat = $_myrowRes['WFUser_cat'];
        }
				
		if($resultsFound == 1)
		{
			$InsertQuery 	=   "INSERT INTO tbl_workflowupdate (wk_id, wk_owner, wk_name, start_time, end_time, wk_update, crt_date, status, crt_by, catcode, TimeType, TimeTaken, StartTime, Wf_Desc, WFUser_cat) 
			VALUES ('$WorkflowTaskId', '$wk_Owner', '$wk_name', '$start_time', '$end_time', '$UserReview', '$today_date', '$Status', '$LogUserCode', '$catcode', '$TimeCat', '$TimeSpent', '$TimeStart', '$Wf_Desc', '$WFUser_cat')";
			
			$insertStatus = mysqli_query($link, $InsertQuery) or die(mysqli_error($str_dbconnect$connection));
			
			if($insertStatus==1)
			{
				InsertApplicationLog($link,'workflow' , $WorkflowTaskId , $LogUserCode );
				echo 'Inserted';
				
			}
			else
			{
				echo 'Not Inserted';
			}
		}
		else
		{
			echo 'No Workflow Found';
		}
		
	}
	else if($resultCount==1)
	{
		$UpdateQuery 	=   "UPDATE tbl_workflowupdate SET `wk_update` = '$UserReview' , `status` = '$Status', crt_by = '$LogUserCode', `TimeType` = '$TimeCat', TimeTaken = '$TimeSpent', StartTime = '$TimeStart' WHERE  wk_id = '$WorkflowTaskId' AND crt_date = '$today_date'";
	
		$updateStatus = mysqli_query($link, $UpdateQuery) or die(mysqli_error($str_dbconnect$connection));
		
		if($updateStatus==1)
		{
			InsertApplicationLog($link,'workflow' , $WorkflowTaskId , $LogUserCode );
			echo 'Updated';
		}
		else
		{
			echo 'Not Updated';
		}	
	}
	else
	{
		echo 'Duplicated Records for Single Day';
	}
		
  }
  else
  {
	echo 'Error';
  }
  
?>