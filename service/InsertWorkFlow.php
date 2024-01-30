<?php
	//$connection = include_once('../connection/previewconnection.php');
	$connection = include_once('../connection/mobilesqlconnection.php');
	include ("../class/accesscontrole.php");
	$LogUserCode = $_GET["EmpCode"];
	$Country = $_GET["Country"];
	$previousDate = $_GET["prvDate"];
	
	$wk_update  =   "";
    $status     =   "";
    $Message    =   "";
	
   
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
		
	if($previousDate != "")	
	{
		$crt_date  = $previousDate;
        $today_date  = $previousDate;
	}
	else{
		$crt_date  = date("Y-m-d");
		$today_date  = date("Y-m-d");
	}
	
	$WFUser_cat = "0";        
	date_default_timezone_set($timezone);		
	
	
	
	echo $today_date;
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
			$wk_name  = mysqli_real_escape_string($link, $_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc = mysqli_real_escape_string($link, $_myrowRes['WF_Desc']);
			$WFUser_cat = $_myrowRes['WFUser_cat'];
			echo $wk_id;
			
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')";
            
            $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
			
			
			/* echo $insertStatus;
			if($insertStatus==1)
					{
						echo 'DAILY WF Inserted';
					}
					else
					{
						echo 'DAILY WF Not Inserted';
					} */
			
            
        } 
        
    }
	
	function Get_WeeklyWorkFlow($link)
	{
	    global $LogUserCode,$crt_date,$connection;
        $today_date  = date("l");
       
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Weekly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$LogUserCode'   AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";        
        $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            
            $wk_id     = $_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name   = mysqli_real_escape_string($link, $_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc = mysqli_real_escape_string($link, $_myrowRes['WF_Desc']);
            $WFUser_cat = $_myrowRes['WFUser_cat'];
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `WF_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($link));
            
             $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
			 
			 /* if($insertStatus==1)
					{
						echo 'WEEKLY WF Inserted';
					}
					else
					{
						echo 'WEEKLY WF Not Inserted';
					} */
			
            
        }
        
    }
  
	function Get_MonthlyWorkFlow($link)
	{
	global $LogUserCode,$crt_date,$today_date,$connection;
		
        $today_date  = date("j");
		
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Monthly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$LogUserCode' AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";        
        $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            
            $wk_id    	= $_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name  	= mysqli_real_escape_string($link, $_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time 	= $_myrowRes['end_time'];            
            $catcode 	= $_myrowRes['catcode'];
            $Wf_Desc 	= mysqli_real_escape_string($link, $_myrowRes['WF_Desc']);
			$WFUser_cat = $_myrowRes['WFUser_cat'];
            
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($link));
            
             $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
			 
			/*  if($insertStatus==1)
					{
						echo 'MONTHLY WF Inserted';
					}
					else
					{
						echo 'MONTHLY WF Not Inserted';
					} */
			
            
        }
        
    }
  
    function Get_DailyEQFlow($link)
	{
		global $LogUserCode,$crt_date,$today_date,$connection;
        $Equipment = "";
        $EqMaint = "";
        
        
        $_SelectQuery 	=   "SELECT * FROM tbl_wkequip WHERE `wf_date` = '$crt_date' AND `wf_emp` = '$LogUserCode' AND `eq_ser` NOT IN (SELECT `wk_id` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";        
       $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            
            $wk_id    =	$_myrowRes['eq_ser'];
            $wk_Owner   = $_myrowRes['wf_emp'];
            
            $EquipmentID  = $_myrowRes['eq_id'];
            $EqMaintID = $_myrowRes['eq_type'];
            
            
            $Equipment  = getEQList($str_dbconnect,$_myrowRes['eq_id']);
            $EqMaint    = getEQMList($str_dbconnect,$_myrowRes['eq_id'], $_myrowRes['eq_type']);
                    
            $wk_name  = $Equipment . " : " . $EqMaint;
            
            
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `EqType`, `Mtype`, `catcode`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$EquipmentID', '$EqMaintID', '7')" or die(mysqli_error($link));
            
             $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
			 
			 /* if($insertStatus==1)
					{
						echo 'DAILY EQ WF Inserted';
					}
					else
					{
						echo 'DAILY EQ WF Not Inserted';
					} */
			
            
        }
        
    }
    
	function updateSummary($link)
	{
		global $LogUserCode,$crt_date,$today_date,$connection;
        $_SelectQuery 	=   "INSERT INTO tbl_wkSummary (`emp_code`, `update_date`, `status`)
                                    VALUES ('$LogUserCode', '$today_date', 'A')" or die(mysqli_error($link));
            
         $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
		/*  echo $insertStatus;
		 if($insertStatus==1)
					{
						echo 'US Inserted';
					}
					else
					{
						echo 'US Not Inserted';
					} */
		
    }
 
    Get_DailyWorkFlow($link);
    Get_WeeklyWorkFlow($link);
     Get_MonthlyWorkFlow($link);
    Get_DailyEQFlow($link);					
	updateSummary($link); 
	//echo $LogUserCode;
    $_SelectQuery = "SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND `EMPCODE` = '$LogUserCode' OR EMPCode IN (SELECT DISTINCT `wk_Owner` FROM `tbl_workflow` WHERE `report_owner` = '$LogUserCode')";
	$executingQuery=mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));

	$Result1 = mysqli_num_rows($executingQuery);
	
	if($Result1 != 0)
	{
		$rows1 = array();
		
		while($r = mysqli_fetch_assoc($executingQuery)) 
		{
			//echo $wk_id;
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
				//echo $wk_id;
				//echo $wk_Owner;
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
  
	
	
  
  
  
  
  
  
  
?>