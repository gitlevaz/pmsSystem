<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
	include ("../class/accesscontrole.php");
	
	$LoggedUser = $_GET["loggedUser"];
	$WFList = $_GET["workflowList"];
	
	if($WFList == null || $LoggedUser == null)
	{
		echo "No Data Passed";
	}
	else
	{
		
		$errorCount = 0;
		
		$today_date  = date("Y-m-d");
		
		$wfArrayList = explode(",",$WFList);
		$listLength = sizeof($wfArrayList);
		
		
		//Test 1
		/*
		echo "All Workflow Data ---------------->>>";
		echo nl2br("\n");
		
		for($a=0;$a<listLenght;$a++)
		{
			echo $wfArrayList[$a];
			echo nl2br("\n");
		}
		
		echo nl2br("\n");
		*/
		
		
		$wfIdListToApprove = "";
		$wfIdListToRedo = "";
						
		for($x = 0; $x < count($wfArrayList); $x++)
		{
			$wfItemDetails = explode("*",$wfArrayList[$x]);
			
			//Test 2
			/*
			$wkNumber = $x+1;
			echo "Workflow Item : ".$wkNumber." ---------------->>>";
			echo nl2br("\n");
			echo $wfItemDetails[0];
			echo nl2br("\n");
			echo $wfItemDetails[1];
			echo nl2br("\n");
			echo $wfItemDetails[2];
			echo nl2br("\n");
			echo $wfItemDetails[3];
			echo nl2br("\n");
			
			echo nl2br("\n");
			*/
			
			
			//Get relevent Workflow Details from WorkflowUpdate Table.
				
			$getWfDetailsQuery = "SELECT wk_id, wk_owner, wk_name, start_time, end_time, wk_update, crt_date, status, crt_by, auto_id, EqType, Mtype, catcode, TimeType, TimeTaken, StartTime, Wf_Desc, WFUser_cat, SupervisoryStatus FROM tbl_workflowupdate WHERE wk_id='$wfItemDetails[0]' AND crt_date='$today_date' limit 1";
			
			$WFDetailsResults 	=   mysqli_query($link, $getWfDetailsQuery) or die(mysqli_error($str_dbconnect$connection));
	
			$resultsFound = 0;

			while($_myrowRes = mysqli_fetch_assoc($WFDetailsResults)) {
				
				$resultsFound = 1;
							
				$wk_Owner   = $_myrowRes['wk_owner'];
				$wk_name  = $_myrowRes['wk_name'];
				$start_time = $_myrowRes['start_time'];
				$end_time = $_myrowRes['end_time'];
				$wk_update = $_myrowRes['wk_update'];
				$crt_date = $_myrowRes['crt_date'];
				$status = $_myrowRes['status'];
				$crt_by = $_myrowRes['crt_by'];
				$auto_id = $_myrowRes['auto_id'];
				$EqType = $_myrowRes['EqType'];
				$Mtype = $_myrowRes['Mtype'];
				$catcode = $_myrowRes['catcode'];
				$TimeType = $_myrowRes['TimeType'];
				$TimeTaken = $_myrowRes['TimeTaken'];
				$StartTime = $_myrowRes['StartTime'];
				$Wf_Desc = $_myrowRes['Wf_Desc'];
				$WFUser_cat = $_myrowRes['WFUser_cat'];
				$SupervisoryStatus = $_myrowRes['SupervisoryStatus'];
				
			}
			
			//Test 3
			/*
			echo $wfItemDetails[0].", ".$wk_Owner.", ".$wk_name.", ".$start_time.", ".$end_time.", ".$wk_update.", ".$crt_date.", ".$status.", ".$crt_by.", ".$auto_id.", ".$EqType.", ".$Mtype.", ".$catcode.", ".$TimeType.", ".$TimeTaken.", ".$StartTime.", ".$Wf_Desc.", ".$WFUser_cat.", ".$SupervisoryStatus;
			echo nl2br("\n");
			echo nl2br("\n");
			echo nl2br("\n");
			*/
			
			if($wfItemDetails[1]=="Approved")
			{
				$wfIdListToApprove = $wfIdListToApprove . "'" . $wfItemDetails[0] . "', ";
			}
			else if($wfItemDetails[1]=="Redo")
			{
				$wfIdListToRedo = $wfIdListToRedo . "'" . $wfItemDetails[0] . "', ";
				
				$redoWfId = "RE".$wfItemDetails[0];
				
				//Insert new record to the WorkflowUpdate table as a Redo Item
				
				if($resultsFound == 1)
				{
					$insertRedoWfQuery = "INSERT INTO tbl_workflowupdate (wk_id, wk_owner, wk_name, start_time, end_time, wk_update, crt_date, status, crt_by, EqType, Mtype, catcode, TimeType, TimeTaken, StartTime, Wf_Desc, WFUser_cat) VALUES ('$redoWfId', '$wk_Owner', '$wk_name', '$start_time', '$end_time', '$wk_update', '$wfItemDetails[3]', 'No', '$crt_by', '$EqType', '$Mtype', '$catcode', '$TimeType', '$TimeTaken', '$StartTime', '$Wf_Desc', '$WFUser_cat')";
					
					$insertWFStatus = mysqli_query($link, $insertRedoWfQuery) or die(mysqli_error($str_dbconnect$connection));
					
					if($insertWFStatus==1)
					{
						//echo 'Inserted';
					}
					else
					{
						$errorCount = $errorCount + 1;
					}
				}
				else
				{
					$errorCount = $errorCount + 1;
				}
				
			}
			
			
			

			//Insert new record to the Notification table
			
			if($resultsFound==1)
			{
				$insertNotificationQuery = "INSERT INTO tbl_notifications (`Wk_id`, `Notification`, `toUser`, `fromUser`, `crt_date`, `crt_time`, `Status`, `WFDate` ) VALUES ('$wfItemDetails[0]', '$wfItemDetails[2]', '$wk_Owner', '$LoggedUser', '$today_date', '10:50', 'A', '$today_date')";
			
				$insertNotificationStatus = mysqli_query($link, $insertNotificationQuery) or die(mysqli_error($str_dbconnect$connection));
						
				if($insertNotificationStatus==1)
				{
					//echo 'Inserted';
				}
				else
				{
					$errorCount = $errorCount + 1;
				}
			}
			else
			{
				$errorCount = $errorCount + 1;
			}
			
			
		}
		
		
		$wfIdListToApprove = substr($wfIdListToApprove,0,-2);
		
		$wfIdListToRedo = substr($wfIdListToRedo,0,-2);
		
		//Test 4
		/*
		echo "Approve List ---> ".$wfIdListToApprove;
		echo nl2br("\n");
		echo "Redo List ---> ".$wfIdListToRedo;
		echo nl2br("\n");
		echo nl2br("\n");
		echo nl2br("\n");
		*/
		
		//Updating the SupervisoryStatus as Approved in WorkflowUpdate table
		
		if($wfIdListToApprove!=null)
		{
			$updateApproveQuery = "UPDATE `tbl_workflowupdate` SET `SupervisoryStatus` = 'Approved' WHERE `wk_id` in ($wfIdListToApprove) AND `crt_date` = '$today_date'";
				
			$updateApproveStatus = mysqli_query($link, $updateApproveQuery) or die(mysqli_error($str_dbconnect$connection));
			
			if($updateApproveStatus==1)
			{
				//echo 'Updated';
			}
			else
			{
				$errorCount = $errorCount + 1;
			}
		}
		

		//Updating the SupervisoryStatus as Redo in WorkflowUpdate table
		
		if($wfIdListToRedo!=null)
		{
			$updateRedoQuery = "UPDATE `tbl_workflowupdate` SET `SupervisoryStatus` = 'Redo' WHERE `wk_id` in ($wfIdListToRedo) AND `crt_date` = '$today_date'";
		
			$updateRedoStatus = mysqli_query($link, $updateRedoQuery) or die(mysqli_error($str_dbconnect$connection));
			
			if($updateRedoStatus==1)
			{
				//echo 'Updated';
			}
			else
			{
				$errorCount = $errorCount + 1;
			}
		}
	
		
		//All status
		
		if($errorCount > 0)
		{
			echo "Error ('.$errorCount.' errors occured)";
		}
		else
		{
			echo "Success";
		}
		
		//echo nl2br("\n");
		
	}
	

  
?>