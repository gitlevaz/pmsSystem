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
				
		for($x = 0; $x < count($wfArrayList); $x++)
		{
			
			$wfItemDetails = explode("-",$wfArrayList[$x]);

			for($y = 0; $y < count($wfItemDetails); $y++)
			{
				
				if($wfItemDetails[1]=="Approved")
				{
					$wfIdListToApprove = $wfIdListToApprove + "'" + $wfItemDetails[0] + "',";
				}
				else if($wfItemDetails[1]=="Redo")
				{
					$wfIdListToRedo = $wfIdListToRedo + "'" + $wfItemDetails[0] + "',";
				}
				
				
				
			}
			
		}
		
		$updateApproveQuery = "UPDATE `tbl_workflowupdate` SET `SupervisoryStatus` = 'Approved' WHERE `wk_id` in ("$wfIdListToApprove") AND `crt_date` = '"$today_date'"";
		
		$updateRedoQuery = "UPDATE `tbl_workflowupdate` SET `SupervisoryStatus` = 'Redo' WHERE `wk_id` in ('"$wfIdListToRedo"') AND `crt_date` = '"$today_date'"";
		
		
		
		/* "INSERT INTO tbl_notifications (`Wk_id`, `Notification`, `toUser`, `fromUser`, `crt_date`, `crt_time`, `Status`, `WFDate` )
                                    VALUES ('$wk_id', '$wk_Note', '$ToUserCode', '$LogUserCode', '$today_date', '10:50', 'A', '$WFDate')" */
		
		
		
	}
	
	
	/*
	
	function Get_DailyWorkFlow($link)
	{
		global $LogUserCode,$crt_date,$today_date,$connection;
		
        $_SelectQuery 	= "SELECT * FROM tbl_workflow WHERE `schedule` = 'Daily' AND `wk_Owner` = '$LogUserCode'  AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";        
        $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            
            $wk_id    =	$_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
			$wk_name  = $_myrowRes['wk_name'];
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc =$_myrowRes['WF_Desc'];
			$WFUser_cat = $_myrowRes['WFUser_cat'];
			
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')";
            
            $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
			
            
        } 
        
    }

    
	function updateSummary($link)
	{
		global $LogUserCode,$crt_date,$today_date,$connection;
        $_SelectQuery 	=   "INSERT INTO tbl_wkSummary (`emp_code`, `update_date`, `status`)
                                    VALUES ('$LogUserCode', '$today_date', 'A')" or die(mysqli_error($link));
            
         $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
		
    }
 
    Get_DailyWorkFlow($link);
    Get_WeeklyWorkFlow($link);
    Get_MonthlyWorkFlow($link);
    Get_DailyEQFlow($link);					
	updateSummary($link);
	
    $_SelectQuery = "SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND `EMPCODE` = '$LogUserCode' OR EMPCode IN (SELECT DISTINCT `wk_Owner` FROM `tbl_workflow` WHERE `report_owner` = '$LogUserCode')";
	$executingQuery=mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));

	$Result1 = mysqli_num_rows($executingQuery);
	
	if($Result1 != 0)
	{
		$rows1 = array();
		
		while($r = mysqli_fetch_assoc($executingQuery)) 
		{
			
			$wk_id    	=	$r['EmpCode'];
            $wk_Owner  	= 	$LogUserCode;
            $wk_name  	= 	"Review W/Fs";
            $start_time = 	"18:00";
            $end_time 	= 	"19:00";
            $catcode 	= 	"1";
            $Wf_Desc 	= 	"Review Work Flow of ".$r['FirstName']." ".$r['LastName']."";
			$WFUser_cat = 	"0";
            $crt_date   = date("Y-m-d");
			
			$HasData = "No";
			
			$_SelectQuery56 	=   "SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode' AND `wk_id` = '$wk_id'";        
	        $_ResultSet56 	=   mysqli_query($link,$_SelectQuery56) or die(mysqli_error($link));
	
	
	        while($_myrowRes56 = mysqli_fetch_assoc($_ResultSet56)) 
			{			                
				$HasData = "Yes";		
			}
			
			if($HasData == "No" && strcasecmp($wk_id,$wk_Owner) != 0 ) 
			{
				
				$InsertQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`)
	                                VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc')";
			
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
				echo "No Insertion Occured";
			}
		}
		
	   
	}
	else 
	{
		echo "No Employee Data";
	}
  
	
	
  
  */
  
  
  
  
  
?>