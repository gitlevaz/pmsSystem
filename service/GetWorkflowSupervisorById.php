<?php
//echo  'LogUserCode';
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');

  
  $LogUserCode = $_GET["LogUserCode"];
  $WorkflowTaskId = $_GET["WorkflowTaskId"];
   
   $array = array();
	
  if($LogUserCode != null && $WorkflowTaskId != null)
  {	
	
		$SelectWorkflowQuery = "SELECT report_owner FROM tbl_workflow WHERE wk_id='$WorkflowTaskId' AND wk_owner='$LogUserCode' limit 1";
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
  else
  {
	  echo 'No Data';
  } 
?>