<?php
	$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
	include ("../class/accesscontrole.php");
	
	$WFList = $_GET["workflowList"];
	
	if($WFList==null)
	{
		echo "No Data Passed";
	}
	else
	{
		$today_date  = date("Y-m-d");
		
		$wfArrayList = explode(",",$WFList);
		
		$wfIdListToApprove = "";
		$wfIdListToRedo = "";
		
		$count = 0;
				
		for($x = 0; $x < count($wfArrayList); $x++)
		{
			$wfItemDetails = explode("-",$wfArrayList[$x]);
			
			if($wfItemDetails[1]=="Approved")
			{
				$wfIdListToApprove = $wfIdListToApprove . "'" . $wfItemDetails[0] . "',";
			}
			else if($wfItemDetails[1]=="Redo")
			{
				$wfIdListToRedo = $wfIdListToRedo . "'" . $wfItemDetails[0] . "',";
			}

			$count = $count + 1;
		}
		

		$wfIdListToApprove = substr($wfIdListToApprove,0,-1);
		
		$wfIdListToRedo = substr($wfIdListToRedo,0,-1);
		
		echo $wfIdListToApprove;
		echo nl2br("\n");
		echo $wfIdListToRedo;
		
		echo $count;
		
		//$updateApproveQuery = "UPDATE `tbl_workflowupdate` SET `SupervisoryStatus` = 'Approved' WHERE `wk_id` in ("$wfIdListToApprove") AND `crt_date` = '"$today_date'"";
		
		//$updateRedoQuery = "UPDATE `tbl_workflowupdate` SET `SupervisoryStatus` = 'Redo' WHERE `wk_id` in ('"$wfIdListToRedo"') AND `crt_date` = '"$today_date'"";
		
		
		
		/* "INSERT INTO tbl_notifications (`Wk_id`, `Notification`, `toUser`, `fromUser`, `crt_date`, `crt_time`, `Status`, `WFDate` )
                                    VALUES ('$wk_id', '$wk_Note', '$ToUserCode', '$LogUserCode', '$today_date', '10:50', 'A', '$WFDate')" */
		
		
		
	}
	

  
  
  
?>