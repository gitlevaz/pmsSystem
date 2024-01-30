<?php
//echo  'LogUserCode';
 //$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
  
  $LogUserCode = $_GET["LogUserCode"];
  $WorkflowTaskId = $_GET["WorkflowTaskId"];
  $previousDate = $_GET["selectedDate"];
   
   $array = array();
	
  if($LogUserCode != null && $WorkflowTaskId != null)
  {	
	
	if($previousDate != "")	
	{
		
        $today  = $previousDate;
	}
	else{
		$today  = date("Y-m-d");
		
	}
	
	$SelectWorkflowUpdateQuery = "SELECT Wf_Desc, start_time, end_time, wk_update, StartTime, TimeTaken, status FROM tbl_workflowupdate WHERE wk_id='$WorkflowTaskId' AND wk_owner='$LogUserCode' AND crt_Date='$today' limit 1";
	$executingQuery=mysqli_query($link,$SelectWorkflowUpdateQuery) or die(mysqli_error($link));

	$Result1 = mysqli_num_rows($executingQuery);
	
	if($Result1 != 0)
	{
		$rows1 = array();
		
		while($r = mysqli_fetch_assoc($executingQuery)) 
		{
			$rows1[] = $r;
		}
		
	   echo json_encode($rows1);
	}
	else
	{
		$SelectWorkflowQuery = "SELECT Wf_Desc, start_time, end_time FROM tbl_workflow WHERE wk_id='$WorkflowTaskId' AND wk_owner='$LogUserCode' limit 1";
		$Result2=mysqli_query($link,$SelectWorkflowQuery) or die(mysqli_error($link));
		
		if($Result2!=null)
		{
			$rows2 = array();
			while($r = mysqli_fetch_assoc($Result2)) 
			{
				$rows2[] = $r;
			}
			echo json_encode($rows2);
		}
		else
		{
			echo 'No Data';
		}
	}
  }
  else
  {
	  echo 'No Data';
  } 
?>