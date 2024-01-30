<?php




    function get_TempSerial($str_dbconnect,$str_Serial, $str_Description) {

        $_CompCode      =	"CIS";
        $_Serial_Val    =	-1;

        $_SelectQuery   = 	"SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '$str_Serial'" or die(mysqli_error($str_dbconnect));
        $_ResultSet     = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_Serial_Val	=   $_myrowRes['Serial'];
        }

        if($_Serial_Val == -1)
        {
            $_SelectQuery 	=   "INSERT INTO tbl_serials (`CompCode`, `Code`, `Serial`, `Desription`) VALUES ('$_CompCode', '$str_Serial', '0', '$str_Description')" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            $_SelectQuery 	=   "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '$str_Serial'" or die(mysqli_error($str_dbconnect));
            $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Serial_Val    =	$_myrowRes['Serial'];
            }

        }

        $_Serial_Val = $_Serial_Val + 1;

        $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '$str_Serial'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        return $_Serial_Val;

    }
	
	function createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc) {
        
		$_SelectQuery 	=   "INSERT INTO tbl_workflow (`wk_id`, `wk_name`, `wk_Owner`, `schedule`, `sched_time`, `start_time`, `end_time`, `report_owner`, `report_div`, `report_Dept`, `crt_date`, `status`, `crt_by`, `catcode`, `WF_Desc`)
                             VALUES ('$wk_id', '$wk_name', '$wk_Owner', '$schedule', '$sched_time','$start_time','$end_time', '$report_owner', '$report_div', '$report_Dept', '$crt_date', 'A', '$crt_by', '$wfcategory', '$WF_Desc')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		$_SelectQuery12 	=   "SELECT * FROM tbl_workflow WHERE `wk_id` = '$wk_id' ";
        
        $_ResultSet12 	=   mysqli_query($str_dbconnect,$_SelectQuery12) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet12)) {
            
            $wwk_id    =	$_myrowRes['wk_id'];
            $wwk_Owner   = $_myrowRes['wk_Owner'];
            $wwk_name  = mysqli_real_escape_string($str_dbconnect,$_myrowRes['wk_name']);
            $wstart_time = $_myrowRes['start_time'];
            $wend_time = $_myrowRes['end_time'];
            $wcatcode = $_myrowRes['catcode'];
            $wWf_Desc = mysqli_real_escape_string($str_dbconnect,$_myrowRes['WF_Desc']);
			$wWFUser_cat = $_myrowRes['WFUser_cat'];
            
            
            $_SelectQuery34 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wwk_id', '$wwk_Owner', '$wwk_name', '$crt_date', '$wstart_time', '$wend_time',  'No', '$wcatcode', '$wWf_Desc', '$wWFUser_cat')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery34) or die(mysqli_error($str_dbconnect));
            
        }
        
        if($schedule == "Weekly"){
            $_SelectQuery = "SELECT * FROM tbl_wfalert WHERE `FacCode` = '$FacCode'" or die(mysqli_error($str_dbconnect));
            $_ResultSet = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {                
                $_EmpCode     =	$_myrowRes['EmpCode'];
                
                $_SelectQuery =   "INSERT INTO tbl_wfalert (`FacCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$wk_id', '$_EmpCode', '', 'A')" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            }
        }else{
            $_SelectQuery = "UPDATE tbl_wfalert SET FacCode = '$wk_id' WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        }
    }

	function isWorkflowNotDuplicate($str_dbconnect,$wk_name, $wk_Owner, $schedule, $sched_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $wfcategory, $WF_Desc)
	{
		$_SelectQuery = "SELECT * FROM tbl_workflow WHERE `wk_name`='$wk_name' AND `wk_Owner`='$wk_Owner' AND `schedule`='$schedule' AND `sched_time`='$sched_time' AND `report_owner`='$report_owner' AND `report_div`='$report_div' AND `report_Dept`='$report_Dept' AND `crt_date`='$crt_date' AND `status`='A' AND `crt_by`='$crt_by' AND `catcode`='$wfcategory' AND `WF_Desc`='$WF_Desc'" or die(mysqli_error($str_dbconnect));
        $_ResultSet = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		if(mysqli_num_rows($_ResultSet)>0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
    function createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid) {
		$_SelectQuery 	=   "INSERT INTO tbl_workflow (`wk_id`, `wk_name`, `wk_Owner`, `schedule`, `sched_time`, `start_time`, `end_time`, `report_owner`, `report_div`, `report_Dept`, `crt_date`, `status`, `crt_by`, `catcode`, `WF_Desc`,`kjrid`,`kpiid`,`activityid`)
                             VALUES ('$wk_id', '$wk_name', '$wk_Owner', '$schedule', '$sched_time', '$start_time','$end_time', '$report_owner', '$report_div', '$report_Dept', '$crt_date', 'A', '$crt_by', '$wfcategory', '$WF_Desc','$kjrid','$kpiid','$activityid')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        if($schedule == "Weekly"){
            $_SelectQuery = "SELECT * FROM tbl_wfalert WHERE `FacCode` = '$FacCode'" or die(mysqli_error($str_dbconnect));
            $_ResultSet = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {                
                $_EmpCode     =	$_myrowRes['EmpCode'];
 
                /* $_SelectQuery =   "INSERT INTO tbl_wfalert (`FacCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$wk_id', '$_EmpCode', '', 'A')" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); */
			$_SelectQuery = "UPDATE tbl_wfalert SET FacCode = '$wk_id' WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
			mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			
			$_SelectQuery = "UPDATE tbl_wfcoveringperson SET FacCode = '$wk_id' WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            }
			
        }else{
            $_SelectQuery = "UPDATE tbl_wfalert SET FacCode = '$wk_id' WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
			mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			
			$_SelectQuery = "UPDATE tbl_wfcoveringperson SET FacCode = '$wk_id' WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        }
    }
	
	function DeleteWorkFlowDetails($str_dbconnect,$WKID){		
		$_SelectQuery 	=   "DELETE FROM tbl_workflow WHERE wk_id = '$WKID'";
        mysqli_query($str_dbconnect,$_SelectQuery);	
			
		$_delete_w = "UPDATE tbl_workflowupdate  SET active_status = 'No' WHERE wk_id = '$WKID'" ;
		mysqli_query($str_dbconnect,$_delete_w) or die(mysqli_error($str_dbconnect));
		 updateStatus($WKID);
		
	}

	#lev
	function getALLSYSUSERDETAILSBycmbOwner($str_dbconnect, $wk_Owner) {
	
		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpCode = '$wk_Owner'" or die(mysqli_error($str_dbconnect));
	
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}

	function updateStatus($WKID){
		       
		
		echo "<script>console.log('9');</script>";
		echo "<script>console.log('9');</script>";
	}
    
    function Get_DailyWorkFlow($str_dbconnect,$LogUserCode, $Country){
		
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		$crt_date  = date("Y-m-d");
		
		$WFUser_cat = "0";
        
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Daily' AND `wk_Owner` = '$LogUserCode'  AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";
		
		$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows = mysqli_num_rows($_ResultSet);
		// echo "</br>".$crt_date."</br>";
		// echo "Daily Wkflow count ".$num_rows."</br>";
		echo '<script>console.log("Daily Workflow count'.$num_rows.'")</script>';
		
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $wk_id    =	$_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name  = mysqli_real_escape_string($str_dbconnect,$_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc = mysqli_real_escape_string($str_dbconnect,$_myrowRes['WF_Desc']);
			$WFUser_cat = $_myrowRes['WFUser_cat'];
            
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($str_dbconnect));
            
			mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			echo '<script>console.log("Done")</script>';
            
        }
        
    }
    
    function Get_WeeklyWorkFlow($str_dbconnect,$LogUserCode, $Country){
	
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		$WFUser_cat = "0";
        
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		
		$crt_date  = date("Y-m-d");
		
		$today_date  = date("l");
		// echo "<script>console.log('.$crt_date.');</script>";
		
        // echo "<script>console.log('.$today_date.');</script>";
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Weekly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$LogUserCode'   AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";
        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows = mysqli_num_rows($_ResultSet) ;
		echo '<script>console.log("Weekly Workflow count'.$num_rows.'")</script>';

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            echo '<script>console.log("Done")</script>';
            $wk_id     = $_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name   = mysqli_real_escape_string($str_dbconnect,$_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc = mysqli_real_escape_string($str_dbconnect,$_myrowRes['WF_Desc']);
            $WFUser_cat = $_myrowRes['WFUser_cat'];
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `WF_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        
    }
    
    function Get_MonthlyWorkFlow($str_dbconnect,$LogUserCode, $Country){
	
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
        if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		
        $today_date  = date("j");
		
		$crt_date  = date("Y-m-d");
        
        // $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Monthly' AND `sched_time` = '$today_date'  AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date') and `wk_Owner` in(SELECT `tbl_employee`.EmpCode FROM `tbl_employee` INNER JOIN `tbl_sysusers` ON `tbl_employee`.EmpCode = `tbl_sysusers`.EmpCode WHERE `tbl_employee`.City='$Country' and `tbl_sysusers`.UserStat='A')";
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Monthly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$LogUserCode' AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";
		
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		// $num_rows = mysqli_num_rows($_ResultSet);
		// echo "</br>".$crt_date."-".$today_date."</br>";
		// echo "Mothly Wkflow count ".$num_rows."</br>";
		$WFUser_cat = "0";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $wk_id    	=	$_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name  	= mysqli_real_escape_string($str_dbconnect,$_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time 	= $_myrowRes['end_time'];
            
            $catcode 	= $_myrowRes['catcode'];
            $Wf_Desc 	= mysqli_real_escape_string($str_dbconnect,$_myrowRes['WF_Desc']);
			$WFUser_cat = $_myrowRes['WFUser_cat'];
            
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date','$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        
    }
	
    
    function getEQMListDetails($str_dbconnect,$id, $mID){
        
        $MLIST = "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_eqMList WHERE `status` = 'A' AND eq_id = '$id' AND mt_id = '$mID'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $id     = $_myrowRes['mt_id'];
            $data   = $_myrowRes['mt_type'];            
        }  
        
        return $data;
    }
    
    function getEQMList($str_dbconnect,$id, $mID){
        
        $MLIST = "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_eqMList WHERE `status` = 'A' AND eq_id = '$id' AND mt_id = '$mID'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $id     = $_myrowRes['mt_id'];
            $MLIST   = $_myrowRes['mt_type'];            
        }  
              
        
        return $MLIST;
    }
    
    function getEQList($str_dbconnect,$id){
        $data = "";
        $MLIST = "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_equipments WHERE `status` = 'A' AND eq_code = '$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $id     = $_myrowRes['eq_code'];
            $data   = $_myrowRes['eq_name'];            
        }  
        
        return $data;
    }
    
    function getAllEquipments($str_dbconnect){
        $_SelectQuery 	=   "SELECT * FROM tbl_Equipments WHERE `status` = 'A'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
    }
    
    function getALLMList($str_dbconnect,$id){
        
        $MLIST = "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_eqMList WHERE `status` = 'A' AND eq_id = '$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));        
        
        return $_ResultSet;
    }
	
	function getEQUpdateStatus($str_dbconnect,$EqID, $EmpCode, $Date){
	
		$WF_Status	=	"";
		
		$_SelectQuery 	=   "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$Date' AND `wk_Owner` = '$EmpCode' AND `wk_id` = '$EqID'";        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $WF_Status    =	$_myrowRes['status'];            
        }	
		
		return $WF_Status;
		
	}
	
	function getEQUpdateList($str_dbconnect,$EqID, $EmpCode, $Date){
		
		$_SelectQuery 	=   "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$Date' AND `wk_Owner` = '$EmpCode' AND `wk_id` = '$EqID'";        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		return $_ResultSet;
		
	}
    
    function Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country){
	
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		
        $crt_date  = date("Y-m-d");        
		
        $Equipment = "";
        $EqMaint = "";
        
        
        $_SelectQuery 	=   "SELECT * FROM tbl_wkequip WHERE `wf_date` = '".$crt_date."' AND `wf_emp` = '$LogUserCode' AND `eq_ser` NOT IN (SELECT `wk_id` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode')";
		
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
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
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$EquipmentID', '$EqMaintID', '7')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        
    }
    
	
	/* **************************** LOAD USER W/F LIST ******************************************************* */
	
	function User_browseTaskWFH($str_dbconnect,$LogUserCode, $sortby, $sortby2, $User_date){
 
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
		$today_date  = $User_date;
        $_SelectQuery = "";
		$day = (int)date('d', strtotime($User_date));
		$weekdayName = date('l', strtotime($User_date));

      /*  if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
        }else if($sortby == "WFN"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
        }else if($sortby == "EMO"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";
        }else{
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby'  order by `start_time`";
        }  */    

		if ($sortby == "NRM"){
       /* }else if($sortby == "WFN"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
        }else if($sortby == "3"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
			if($sortby2 == "CAT"){
				/*$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";	*/
			
			// $_SelectQuery = "SELECT TWF.wk_id, TWF.wk_owner, TWF.wk_name, TWF.start_time, TWF.end_time, TWF.wk_update, TWF.crt_date, TWF.status,
			// 	 TWF.crt_by, TWF.auto_id, TWF.EqType, TWF.Mtype, TWF.catcode, TWF.TimeType, TWF.TimeTaken, WFCT.category FROM tbl_workflowupdate TWF 
			// 	 INNER JOIN wfcategory WFCT ON WFCT.CATCODE = TWF.catcode 
			// 	  WHERE (TWF.crt_date = '$today_date' AND TWF.wk_owner = '$LogUserCode') 
			// 	 OR (TWF.crt_date = '$today_date' AND TWF.wk_id IN  (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode' ))
			// 	  order by WFCT.category, TWF.wk_name";    

				//new
				$_SelectQuery = "SELECT TWF.wk_id, TWF.wk_owner, TWF.wk_name, TWF.start_time, TWF.end_time, TWF.wk_update, TWF.crt_date, TWF.status,
				TWF.crt_by, TWF.auto_id, TWF.EqType, TWF.Mtype, TWF.catcode, TWF.TimeType, TWF.TimeTaken, WFCT.category FROM tbl_workflowupdate TWF 
				INNER JOIN wfcategory WFCT ON WFCT.CATCODE = TWF.catcode 
				WHERE (TWF.crt_date = '$today_date' AND TWF.sched_time = '$day' AND TWF.wk_owner = '$LogUserCode'
				OR (TWF.crt_date = '$today_date' AND TWF.sched_time = '$day' AND TWF.wk_id IN  (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode' )
				) 
				order by WFCT.category, TWF.wk_name"; 
			}else{
				
				// $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE (`crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode') OR ( `crt_date` = '$today_date' AND `wk_id` IN  (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode' )) order by `start_time`, wk_name ";	

				//new
				$_SelectQuery = "SELECT *, wfu.status FROM tbl_workflowupdate wfu
					JOIN tbl_workflow wfl ON wfu.wk_id = wfl.wk_id
					WHERE (
						( wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.sched_time = '$day' )
						OR
						(wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.sched_time = '$weekdayName' )
						OR
						(wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.schedule = 'Daily' )
					)
					
					ORDER BY wfu.start_time, wfu.wk_name ;";

			}
        }else{
            /*$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby'  order by `start_time`";*/
			if($sortby2 == "CAT"){
				// $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE (`crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' 
				// AND `catcode` = '$sortby') 
				// OR (`crt_date` = '$today_date' AND  `catcode` = '$sortby' AND `wk_id` IN  
				// (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode'))  order by `catcode`, wk_name";	
			
				//new
				$_SelectQuery = "SELECT *, wfu.status FROM tbl_workflowupdate wfu
				JOIN tbl_workflow wfl ON wfu.wk_id = wfl.wk_id
				WHERE (
					(wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.sched_time = '$day' AND wfu.catcode = '$sortby')
					OR
					(wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.sched_time = '$weekdayName' AND wfu.catcode = '$sortby')
					OR
					(wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.schedule = 'Daily' )
				)
				
				ORDER BY wfu.start_time, wfu.wk_name ;";

			}else{
				
				// $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE (`crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' 
				//  AND `catcode` = '$sortby') OR (`crt_date` = '$today_date' AND  `catcode` = '$sortby' AND `wk_id` IN  
				//  (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode')) order by `start_time`, wk_name ";	

				//new
				$_SelectQuery = "SELECT *, wfu.status FROM tbl_workflowupdate wfu
				JOIN tbl_workflow wfl ON wfu.wk_id = wfl.wk_id
				WHERE (
					(wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.sched_time = '$day' AND wfu.catcode = '$sortby')
					OR
					(wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.sched_time = '$weekdayName' AND wfu.catcode = '$sortby')
					OR
					( wfu.crt_date = '$today_date' AND wfu.wk_owner = '$LogUserCode' AND wfl.schedule = 'Daily' AND wfu.catcode = '$sortby' )
				)
				
				ORDER BY wfu.start_time, wfu.wk_name ;";

			}
        }  

        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
        return $_ResultSet;
        
	}
	
	function User_browseTaskWFH2($str_dbconnect,$LogUserCode, $sortby, $sortby2, $User_date){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
		$today_date  = $User_date;
        $_SelectQuery = "";
        
      /*  if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
        }else if($sortby == "WFN"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
        }else if($sortby == "EMO"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";
        }else{
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby'  order by `start_time`";
        }  */    
		
		if ($sortby == "NRM"){
            
       /* }else if($sortby == "WFN"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
        }else if($sortby == "3"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
			if($sortby2 == "CAT"){
				/*$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";	*/
				$_SelectQuery = "SELECT TWF.wk_id, TWF.wk_owner, TWF.wk_name, TWF.start_time, TWF.end_time, TWF.wk_update, TWF.crt_date, TWF.status, TWF.crt_by, TWF.auto_id, TWF.EqType, TWF.Mtype, TWF.catcode, TWF.TimeType, TWF.TimeTaken, WFCT.category FROM tbl_workflowupdate TWF INNER JOIN wfcategory WFCT ON WFCT.CATCODE = TWF.catcode  WHERE TWF.crt_date = '$today_date' AND TWF.wk_owner = '$LogUserCode' order by WFCT.category, TWF.wk_name";    
			}else{
				$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`, wk_name";	
			}
        }else{
            /*$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby'  order by `start_time`";*/
			if($sortby2 == "CAT"){
				/*$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";	*/
				/*$_SelectQuery = "SELECT TWF.wk_id, TWF.wk_owner, TWF.wk_name, TWF.start_time, TWF.end_time, TWF.wk_update, TWF.crt_date, TWF.status, TWF.crt_by, TWF.auto_id, TWF.EqType, TWF.Mtype, TWF.catcode, TWF.TimeType, TWF.TimeTaken, WFCT.category FROM tbl_workflowupdate TWF INNER JOIN wfcategory WFCT ON WFCT.CATCODE = TWF.catcode  WHERE TWF.crt_date = '$today_date' AND TWF.wk_owner = '$LogUserCode' AND `TWF.catcode` = '$sortby' order by WFCT.category";    */
				$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby' order by `catcode`, wk_name";	
			}else{
				$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby' order by `start_time`, wk_name";	
			}
        }   
        
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
    }
	
	function User_Get_DailyWorkFlow($str_dbconnect,$LogUserCode, $Country, $User_date){
		
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		
        $WFUser_cat = "0";
		
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Daily' AND `wk_Owner` = '$LogUserCode' AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$User_date' AND `wk_Owner` = '$LogUserCode')";
        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $wk_id    	=	$_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name  	= mysqli_real_escape_string($str_dbconnect,$_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time 	= $_myrowRes['end_time'];
            $catcode 	= $_myrowRes['catcode'];
            $Wf_Desc 	= mysqli_real_escape_string($str_dbconnect,$_myrowRes['WF_Desc']);
            $crt_date  	= $User_date;
			$WFUser_cat = $_myrowRes['WFUser_cat'];
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        
    }
    
    function User_Get_WeeklyWorkFlow($str_dbconnect,$LogUserCode, $Country, $User_date){
	
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
        if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		$timestamp = strtotime($User_date); 
        $today_date  = date("l",$timestamp);
		
		$WFUser_cat = "0";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Weekly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$LogUserCode' AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$User_date' AND `wk_Owner` = '$LogUserCode')";
        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $wk_id     	= $_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name   	= mysqli_real_escape_string($str_dbconnect,$_myrowRes['wk_name']);
            $start_time = $_myrowRes['start_time'];
            $end_time 	= $_myrowRes['end_time'];
            $catcode 	= $_myrowRes['catcode'];
            
			$Wf_Desc 	= mysqli_real_escape_string($str_dbconnect,$_myrowRes['WF_Desc']);
			$WFUser_cat = $_myrowRes['WFUser_cat'];
			
            $crt_date  	= $User_date;
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        
    }
    
    function User_Get_MonthlyWorkFlow($str_dbconnect,$LogUserCode, $Country, $User_date){
	
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
        if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		
		$timestamp = strtotime($User_date); 
        $today_date  = date("j",$timestamp);
		
		$WFUser_cat = "0";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Monthly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$LogUserCode' AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$User_date' AND `wk_Owner` = '$LogUserCode')";
        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $wk_id    	=	$_myrowRes['wk_id'];
            $wk_Owner   =	$_myrowRes['wk_Owner'];
            $wk_name  	= 	mysqli_real_escape_string($str_dbconnect,$_myrowRes['wk_name']);
            $start_time = 	$_myrowRes['start_time'];
            $end_time 	= 	$_myrowRes['end_time'];
            
            $catcode 	= 	$_myrowRes['catcode'];
            
            $crt_date  	= 	$User_date;
			
			$Wf_Desc 	= 	mysqli_real_escape_string($str_dbconnect,$_myrowRes['WF_Desc']);
			$WFUser_cat = 	$_myrowRes['WFUser_cat'];
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date','$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        
    }
	
	function User_Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country, $User_date){

		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		
        //$crt_date  = date("Y-m-d");        
		$crt_date  = $User_date;        
		
        $Equipment = "";
        $EqMaint = "";
        
        
        $_SelectQuery 	=   "SELECT * FROM tbl_wkequip WHERE `wf_date` = '".$User_date."' AND `wf_emp` = '$LogUserCode' AND `eq_ser` NOT IN (SELECT `wk_id` FROM tbl_workflowupdate WHERE `crt_date` = '$User_date' AND `wk_Owner` = '$LogUserCode')";

        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $wk_id        =	$_myrowRes['eq_ser'];
            $wk_Owner     = $_myrowRes['wf_emp'];
            $EquipmentID  = $_myrowRes['eq_id'];
            $EqMaintID    = $_myrowRes['eq_type'];
            
            
            $Equipment  = getEQList($str_dbconnect,$_myrowRes['eq_id']);
            $EqMaint    = getEQMList($str_dbconnect,$_myrowRes['eq_id'], $_myrowRes['eq_type']);
                    
            $wk_name  = $Equipment . " : " . $EqMaint;
            
            
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc = $_myrowRes['WF_Desc'];
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `EqType`, `Mtype`, `catcode`, `Wf_Desc`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$EquipmentID', '$EqMaintID', '7', '$Wf_Desc')" or die(mysqli_error($str_dbconnect));
            
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        
    }
	
	/* *************************** END ****************************************************************************/
    
    
    
    function validateLoading($str_dbconnect,$LogUserCode){
        
        $today_date  = date("Y-m-d");
        
        $_SelectQuery 	=   "SELECT * FROM tbl_wkSummary WHERE `update_date` = '$today_date' AND `emp_code` = '$LogUserCode'";        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $num_rows = mysqli_num_rows($_ResultSet);
        
        return  $num_rows;
    }
    
    function updateSummary($str_dbconnect,$LogUserCode){
        
        $today_date  = date("Y-m-d");
        
        $_SelectQuery 	=   "INSERT INTO tbl_wkSummary (`emp_code`, `update_date`, `status`)
                                    VALUES ('$LogUserCode', '$today_date', 'A')" or die(mysqli_error($str_dbconnect));
            
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }
	
	function browseTaskforMail($str_dbconnect,$LogUserCode, $UserTypeID){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
        $_SelectQuery = "";        
        
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like '$UserTypeID%' order by `start_time`";
                    
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
    }
	
	function browseTaskforMailTwo($str_dbconnect,$LogUserCode){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
        $_SelectQuery = "";        
        
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND (`WFUser_cat` = '' OR `WFUser_cat` = '0') order by `start_time`";
                    
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
    }
    
    function browseTask($str_dbconnect,$LogUserCode){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
        $_SelectQuery = "";        
        
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
                    
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
    }
	
	function browseTaskViewUser($str_dbconnect,$LogUserCode, $DateLoad){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);		
        $today_date  = date("Y-m-d");
        $_SelectQuery = "";        
        
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$DateLoad' AND `wk_owner` = '$LogUserCode' order by `start_time`";
                    
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
    }
	
	
    
    function browseTaskWFH($str_dbconnect,$LogUserCode, $sortby, $sortby2, $WfType){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	

		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		

		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
        $_SelectQuery = "";
	
		if($WfType == "USRWF"){
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'EMP%' order by `start_time`";
	       /* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby' AND `wk_id` like 'EMP%'  order by `start_time`";
	        }    	
		}else if($WfType == "REDO"){
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'RE%' order by `start_time`";
	       /* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby' AND `wk_id` like 'RE%'  order by `start_time`";
	        }    	
		}else if($WfType == "CWK"){
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'CWK%' order by `start_time`";
	       /* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby' AND `wk_id` like 'CWK%'  order by `start_time`";
	        }    	
		}else{
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` not like 'EMP%' AND `wk_id` not like 'RD%' AND `wk_id` not like 'CWK%' order by `start_time`";
	/* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby' AND `wk_id` not like 'EMP%' AND `wk_id` not like 'RD%'  AND `wk_id` not like 'CWK%' order by `start_time`";
	        }    
		}
        
          
        
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
	}
	
	function browseTaskCoveringWFH($str_dbconnect,$LogUserCode, $sortby, $sortby2, $WfType){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		

		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
        $_SelectQuery = "";
		// SELECT * FROM `tbl_workflowupdate` WHERE `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='EMP/287') and `wk_id` like 'WK%'
		if($WfType == "USRWF"){
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `wk_id` like 'EMP%' order by `start_time`";
	       /* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = 'LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `catcode` = '$sortby' AND `wk_id` like 'EMP%'  order by `start_time`";
	        }    	
		}else if($WfType == "REDO"){
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `wk_id` like 'RE%' order by `start_time`";
	       /* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `catcode` = '$sortby' AND `wk_id` like 'RE%'  order by `start_time`";
	        }    	
		}else if($WfType == "CWK"){
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `wk_id` like 'CWK%' order by `start_time`";
	       /* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `catcode` = '$sortby' AND `wk_id` like 'CWK%'  order by `start_time`";
	        }    	
		}else{
			if ($sortby == "NRM"){
            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `wk_id` not like 'EMP%' AND `wk_id` not like 'RD%' AND `wk_id` not like 'CWK%' order by `start_time`";
	       /* }else if($sortby == "WFN"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
	        }else if($sortby == "3"){
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";*/
	        }else{
	            $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_id` IN (SELECT `FacCode` FROM `tbl_wfcoveringperson` WHERE `EmpCode`='$LogUserCode') AND `catcode` = '$sortby' AND `wk_id` not like 'EMP%' AND `wk_id` not like 'RD%'  AND `wk_id` not like 'CWK%' order by `start_time`";
	        }    
		}
        
          
        
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
    }
	
	function insertRedo($str_dbconnect,$workflowid,$redodate){        
		
		$_SelectQuery 	=   "SELECT * FROM tbl_workflowupdate WHERE `wk_id` = '$workflowid' group by wk_id";		
		$_RedoSet = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
		while($_myrowRes = mysqli_fetch_array($_RedoSet)) {
            		$wid 		 = $_myrowRes['wk_id'];
					$wowner 	 = $_myrowRes['wk_owner'];
					$wname 		 = $_myrowRes['wk_name'];
					$sttime 	 = $_myrowRes['start_time'];
					$endtime 	 = $_myrowRes['end_time'];
					$crtdate     = $_myrowRes['crt_date'];
					$status      = $_myrowRes['status'];
					$crtby       = $_myrowRes['crt_by'];
					$catcode     = $_myrowRes['catcode'];
					$timetype 	 = $_myrowRes['TimeType'];
					$timetaken   = $_myrowRes['TimeTaken'];
					$starttime   = $_myrowRes['StartTime'];				
					$wdes        = $_myrowRes['Wf_Desc'];
					$wcat        = $_myrowRes['WFUser_cat'];           
          
        }      
		$workflowid = "RE".$workflowid;
		$_SelectQuery 	= "INSERT INTO tbl_workflowupdate (`wk_id`,`wk_owner`,`wk_name`,`start_time`,`end_time`,`crt_date`,`status`,`crt_by`,`catcode`,`TimeType`,`TimeTaken`,`StartTime`,`WF_Desc`,`WFUser_cat`) VALUES ('$workflowid','$wowner','$wname','$sttime','$endtime','$redodate','$status','$crtby','$catcode','$timetype','$timetaken','$starttime','$wdes','$wcat')" or die(mysqli_error($str_dbconnect));
				mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));  
		
        
    }
	
	
	
	function get_UserNotifications($str_dbconnect,$LogUserCode){        
		
        $_SelectQuery = "";
        
    
        $_SelectQuery = "SELECT * FROM tbl_notifications WHERE `Status` = 'A' AND `toUser` = '$LogUserCode' order by `id`";
       
        
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
        
    }
	
	function get_UserNotificationsWFV($str_dbconnect,$LogUserCode, $dateof, $Wk_id){        
		
        $_SelectQuery = "";
        $_Note = "";
    
        $_SelectQuery = "SELECT * FROM tbl_notifications WHERE `toUser` = '$LogUserCode' AND `WFDate` = '$dateof' AND `Wk_id` = '$Wk_id' order by `id`";   
        
        $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_Note    =   $_myrowRes['Notification'];           
        }
		
        
        return $_Note;
        
    }
	
	
	function get_WFName($str_dbconnect,$id){
        
        $MLIST = "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_workflowupdate WHERE wk_id = '$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $data   = $_myrowRes['wk_name'];            
        }  
        
        return $data;
    }
    
    function updateWorkFlow($str_dbconnect,$LogUserCode, $wk_id, $wk_update , $Status, $TimeCat, $TimeSpent, $TimeStart){
     
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
        
        $_SelectQuery 	=   "UPDATE tbl_workflowupdate SET `wk_update` = '$wk_update' , `status` = '$Status', crt_by = '$LogUserCode', `TimeType` = '$TimeCat', TimeTaken = '$TimeSpent', StartTime = '$TimeStart' WHERE  wk_id = '$wk_id' AND wk_owner='$LogUserCode' AND crt_date = '$today_date'" or die(mysqli_error($str_dbconnect));            

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    }
	
	function NotificationReadUpdate($str_dbconnect,$wk_id){
        
        $_SelectQuery 	=   "UPDATE tbl_notifications SET `status` = 'D' WHERE  id = '$wk_id'" or die(mysqli_error($str_dbconnect));            
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
    }
	
	function updateWorkFlowNotification($str_dbconnect,$LogUserCode, $wk_id, $wk_Note , $ToUserCode, $WFDate ){
        
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
        
		$_SelectQuery 	=   "INSERT INTO tbl_notifications (`Wk_id`, `Notification`, `toUser`, `fromUser`, `crt_date`, `crt_time`, `Status`, `WFDate` )
                                    VALUES ('$wk_id', '$wk_Note', '$ToUserCode', '$LogUserCode', '$today_date', '10:50', 'A', '$WFDate')" or die(mysqli_error($str_dbconnect));
									
        /*$_SelectQuery 	=   "UPDATE tbl_workflowupdate SET `wk_update` = '$wk_update' , `status` = '$Status', crt_by = '$LogUserCode', `TimeType` = '$TimeCat', TimeTaken = '$TimeSpent', StartTime = '$TimeStart' WHERE  wk_id = '$wk_id' AND crt_date = '$today_date'" or die(mysqli_error($str_dbconnect));            */
        $_SelectQuery 	=   "UPDATE tbl_workflowupdate SET `wk_update` = '$wk_update' , `status` = '$Status', crt_by = '$LogUserCode', `TimeType` = '$TimeCat', TimeTaken = '$TimeSpent', StartTime = '$TimeStart' WHERE  wk_id = '$wk_id' AND crt_date = $WFDate" or die(mysqli_error($str_dbconnect));            
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
    }
    
    function create_FileName($str_dbconnect){

        $Str_UPLCode    = 	get_TempSerial($str_dbconnect,"1020", "PROJECT TEMPORARY CODE UPLOAD");
        $Str_UPLCode    = 	"UPL-".$Str_UPLCode;

        return $Str_UPLCode;
    }
	
	function ConvertMinutes2Hours($Minutes)
	{
	    if ($Minutes < 0)
	    {
	        $Min = Abs($Minutes);
	    }
	    else
	    {
	        $Min = $Minutes;
	    }
	    $iHours = Floor($Min / 60);
	    $Minutes = ($Min - ($iHours * 60)) / 100;
	    $tHours = $iHours + $Minutes;
	    if ($Minutes < 0)
	    {
	        $tHours = $tHours * (-1);
	    }
	    $aHours = explode(".", $tHours);
	    $iHours = $aHours[0];
	    if (empty($aHours[1]))
	    {
	        $aHours[1] = "00";
	    }
	    $Minutes = $aHours[1];
	    if (strlen($Minutes) < 2)
	    {
	        $Minutes = $Minutes ."0";
	    }
	    $tHours = $iHours .":". $Minutes;
	    return $tHours;
	}
	
	
     function getWFUPDATEMAILReason($str_dbconnect,$LogUserCode,$checkBoxre,$reason){
        
        $HTML = "";
        $today_date  = date("m-d-Y");
        
        $_EmpName    =   "";
        $_DesCode    =   "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$LogUserCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_MailAdd   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName    =   $_myrowRes['FirstName']. " " . $_myrowRes['LastName'];
            $_DesCode    =   $_myrowRes['DesCode'];
        }
		   
        $HTML .= "<html>";
        $HTML .= "<head>";
        $HTML .= "<style type=\"text/css\">
            body{
                font-family:sans serif;
                font-size:12px;
                color:#000066;
            }            
            table{
                border-collapse:collapse;
                border:1px solid black;
                border-color: #000066;
            }
            th{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
            td{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
        </style>";
        
        $HTML .= "</head>";
        $HTML .= "<body>";
        
        $HTML .= "<center><h1><b>Daily Work Flow : </b>".$today_date."</h1></center></br>";
        $HTML .= "<center><h2><b>W/F User : </b>".$_EmpName ."</h2></center></br>";
        $HTML .= "</br></br>" ;
		$HTML .= "<table cellpadding=\"5px\" cellspacing=\"0\" width=\"1200px\" border=\"1px\">";
        $HTML .= "<thead>";
        $HTML .= "<tr>";                    
	        $HTML .= "<th rowspan='2'>WorkFlow Id</th>";
	        $HTML .= "<th rowspan='2'>WorkFlow Name</th>";
			$HTML .= "<th rowspan='2'>Reason</th>";                                   
        $HTML .= "</tr>";
		 $HTML .= "</thead>";
        $HTML .= "<tbody>";
		
								
	    $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_id` = '$checkBoxre' and wk_Owner='$LogUserCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>";				
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_id'];
					$HTML .= "</td>";
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_name'];
					$HTML .= "</td>";	
					$HTML .= "<td>";
						$HTML .= $reason;
					$HTML .= "</td>";					
				$HTML .= "</tr>";			
				
	        } 
				    			              
        $HTML .= "</tbody>";
        $HTML .= "</table>";  
        $HTML .= "</body>";
        $HTML .= "</html>";  
        
        return $HTML ;
		
		
		
	 }
    function getWFUPDATEMAIL($str_dbconnect,$LogUserCode){
        
        $HTML = "";
        $today_date  = date("m-d-Y");
        
        $_EmpName    =   "";
        $_DesCode    =   "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$LogUserCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_MailAdd   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName    =   $_myrowRes['FirstName']. " " . $_myrowRes['LastName'];
            $_DesCode    =   $_myrowRes['DesCode'];
        }
		
		$TotalMin_Allocated = 0;
		$TotalMin_Utilized = 0;
        
        $HTML .= "<html>";
        $HTML .= "<head>";
        $HTML .= "<style type=\"text/css\">
            body{
                font-family:sans serif;
                font-size:12px;
                color:#000066;
            }            
            table{
                border-collapse:collapse;
                border:1px solid black;
                border-color: #000066;
            }
            th{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
            td{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
        </style>";
        
        $HTML .= "</head>";
        $HTML .= "<body>";
        
        $HTML .= "<center><h1><b>Daily Work Flow : </b>".$today_date."</h1></center></br>";
        $HTML .= "<center><h2><b>W/F User : </b>".$_EmpName ."</h2></center></br>";
        $HTML .= "</br></br>" ;
		
		$HTML .= "<left>";
		$HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" border=\"1px\">"; 			
			$HTML .= "<tr>";
				$HTML .= "<td style='background-color:#daffca' align='center'>";
					$HTML .= "COMPLETED";
				$HTML .= "</td>";
				$HTML .= "<td style='background-color:#ffcaca' align='center'>";
					$HTML .= "NOT COMPLETED";
				$HTML .= "</td>";
				$HTML .= "<td style='background-color:#cae8ff' align='center'>";
					$HTML .= "NOT APPLICABLE";
				$HTML .= "</td>";
			$HTML .= "</tr>";
		$HTML .= "</table>";
		$HTML .= "</left>";
       
		$HTML .= "</br>" ;
		
        $HTML .= "<table cellpadding=\"5px\" cellspacing=\"0\" width=\"1200px\" border=\"1px\">";
        $HTML .= "<thead>";
        $HTML .= "<tr>";                    
	        $HTML .= "<th rowspan='2' width='500px'>Task Name</th>";
	        $HTML .= "<th rowspan='2' width='100px'>Scheduled Time</th>";
			$HTML .= "<th rowspan='2' width='100px'>Time Allocated</th>";
			$HTML .= "<th rowspan='2' width='100px'>Actual Task Completion Time</th>";	
			$HTML .= "<th rowspan='2' width='100px'>Time Spent</th>";
			/*$HTML .= "<th rowspan='2'>Time Spent</th>";	
			$HTML .= "<th rowspan='2'>Approx. Time Spent</th>";		*/	
			$HTML .= "<th colspan='3'>Task Status</th>";
	        $HTML .= "<th rowspan='2'>Notes & Attachments</th>";                                                
        $HTML .= "</tr>";
		$HTML .= "<tr>";
			$HTML .= "<th rowspan='2'>Done</th>";
	        $HTML .= "<th rowspan='2'>In Complete</th>";
			$HTML .= "<th rowspan='2'>N/A</th>";
		$HTML .= "</tr>";
        $HTML .= "</thead>";
        $HTML .= "<tbody>";
        
		$CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0;
		
			$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='9' align='center' style='font-size:+16px'><b>"." Daily W/F Tasks"."</b></td>";		        
			$HTML .= "</tr>";
			
			$_UserTypeID ="WK";			
	        $_ResultSet = browseTaskforMail($str_dbconnect,$LogUserCode, $_UserTypeID);
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
						$hours = 0;
						$minutes = 0;
						
						$datetime1 = new DateTime($_myrowRes['start_time']);
						$datetime2 = new DateTime($_myrowRes['end_time']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						$TotalMin_Allocated = $TotalMin_Allocated + (($hours * 60) + $minutes );
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";
				$HTML .= "</tr>";			
				
	        } 
		 
				
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
		if($TotalTask != 0){
			$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";		

		}		
		
		
		/*$query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`TimeTaken`))) As total FROM `tbl_workflowupdate` WHERE `TimeType` = 'Time Taken' AND `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
		$result1 = mysqli_query($str_dbconnect,$query1);
		$row = mysqli_fetch_assoc($result1);
		$TimeSpent = $row['total'];*/
		
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
			$HTML .= "</td>";
		$HTML .= "</tr>";
		
		/*$query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`TimeTaken`))) As total FROM `tbl_workflowupdate` WHERE `TimeType` = 'Approx. Time Needed' AND `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
		$result1 = mysqli_query($str_dbconnect,$query1);
		$row = mysqli_fetch_assoc($result1);
		$TimeAprox = $row['total'];*/
		
		/*$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Approximate Time Spent</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= $TimeAprox;
			$HTML .= "</td>";
		$HTML .= "</tr>";*/	
		
		/*$query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`TimeTaken`))) As total FROM `tbl_workflowupdate` WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
		$result1 = mysqli_query($str_dbconnect,$query1);
		$row = mysqli_fetch_assoc($result1);
		$TotalTimeCal = $row['total'];*/
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
		$HTML .= "</tr>";
		/* $CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0;	 */
		$HTML .= "<tr height='16px'>";	
		$HTML .= "</tr>";
		$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='9' align='center' style='font-size:+16px'><b>"."W/F Tasks of Staff Report"."</b></td>";		        
			$HTML .= "</tr>";
			
			$_UserTypeID ="EMP";			
	        $_ResultSet = browseTaskforMail($str_dbconnect,$LogUserCode, $_UserTypeID);
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
						$hours = 0;
						$minutes = 0;
						
						$datetime1 = new DateTime($_myrowRes['start_time']);
						$datetime2 = new DateTime($_myrowRes['end_time']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						$TotalMin_Allocated = $TotalMin_Allocated + (($hours * 60) + $minutes );
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";
				$HTML .= "</tr>";			
				
	        }			
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
		if($TotalTask!=0){
			$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";
		}	
		

		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
			$HTML .= "</td>";
		$HTML .= "</tr>";
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
		$HTML .= "</tr>";
		/* $CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0; */
		$HTML .= "<tr height='16px'>";	
		$HTML .= "</tr>";
		$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='9' align='center' style='font-size:+16px'><b>"."W/F Tasks to Revisit"."</b></td>";		        
			$HTML .= "</tr>";
			
			$_UserTypeID ="RE";			
	        $_ResultSet = browseTaskforMail($str_dbconnect,$LogUserCode, $_UserTypeID);
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
						$hours = 0;
						$minutes = 0;
						
						$datetime1 = new DateTime($_myrowRes['start_time']);
						$datetime2 = new DateTime($_myrowRes['end_time']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						$TotalMin_Allocated = $TotalMin_Allocated + (($hours * 60) + $minutes );
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";
				$HTML .= "</tr>";			
				
	        }			
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
			if($TotalTask!=0){
				$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";

			}		
		
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
			$HTML .= "</td>";
		$HTML .= "</tr>";
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
		$HTML .= "</tr>";
		/* $CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0;	 */
		$HTML .= "<tr height='16px'>";	
		$HTML .= "</tr>";
		$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='9' align='center' style='font-size:+16px'><b>"."Non Scheduled Tasks for the Day"."</b></td>";		        
			$HTML .= "</tr>";
			
			$_UserTypeID ="CWK";			
	        $_ResultSet = browseTaskforMail($str_dbconnect,$LogUserCode, $_UserTypeID);
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
						$hours = 0;
						$minutes = 0;
						
						$datetime1 = new DateTime($_myrowRes['start_time']);
						$datetime2 = new DateTime($_myrowRes['end_time']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						$TotalMin_Allocated = $TotalMin_Allocated + (($hours * 60) + $minutes );
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";
				$HTML .= "</tr>";			
				
	        }			
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
		if($TotalTask!=0){
			$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";
		}			
		
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
			$HTML .= "</td>";
		$HTML .= "</tr>";
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
		$HTML .= "</tr>";			    			              
        $HTML .= "</tbody>";
        $HTML .= "</table>";  
        $HTML .= "</body>";
        $HTML .= "</html>";  
        
        return $HTML ;
    }
    
    function create_equipment($str_dbconnect,$eq_code, $eq_name ){
        
        $_SelectQuery 	=   "INSERT INTO tbl_Equipments (`eq_code` , `eq_name` , `status` )
                                            VALUES ('$eq_code','$eq_name','A')";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));        
        
    }
    
    function get_eqtypes($str_dbconnect){
        $_SelectQuery 	=   "SELECT * FROM tbl_Equipments WHERE `status` = 'A'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
    }
    
    
    function getwfcategory($str_dbconnect) {
        $_SelectQuery 	=   "SELECT * FROM wfcategory WHERE `status` = 'A'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
    }
	function getwfcategoryId($str_dbconnect) {
        $_SelectQuery 	=   "SELECT * FROM wfcategory WHERE `status` = 'A'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
    }
	
	function getwfUsercategory($str_dbconnect,$_EmpCode) {
        $_SelectQuery 	=   "SELECT * FROM tbl_wfusertypes WHERE `catstatus` = 'A' AND Wf_User = '$_EmpCode'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
    }
	
	function GetStationwiseTask($str_dbconnect,$StationID) {
	
        $_SelectQuery 	=   "SELECT * FROM tbl_StationTask WHERE StationID = '$StationID'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        return $_ResultSet;
    }
	

	function getwfcatogorybyName($str_dbconnect,$id){
        
        $data = "";
        
        $_SelectQuery 	=   "SELECT * FROM wfcategory WHERE catcode = '$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $data   = $_myrowRes['category'];            
        }  
        
        return $data;
    }
	
    
    function getwfcoveringpersonbyName($str_dbconnect,$id){
        
        $data = "";
        
        $_SelectQuery 	=   "SELECT * FROM `tbl_wfcoveringperson` WHERE `FacCode`='$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $data   = $_myrowRes['UserName'] . ',' .$data;            
        }  
        
        return $data;
	}

	function getwfcoveringpersonsbyid($str_dbconnect,$id){
        
        $data = "";
        
        $_SelectQuery 	=   "SELECT * FROM wfcategory WHERE catcode = '$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $data   = $_myrowRes['category'];            
        }  
        
        return $data;
	}
	

	function getwfownerbyId($str_dbconnect,$id){
        
        $data = "";
        
        $_SelectQuery 	=   "SELECT * FROM `tbl_employee` WHERE `EmpCode`='$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {            
            $data   = $_myrowRes['FirstName'] .' '. $_myrowRes['LastName'];            
        }  
        // .' '. $_myrowRes['`LastName`']
        return $data;
    }
	
	function getGROUPNAMEDIV($str_dbconnect,$strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}
	
	function getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$_EmpCode) {

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_EmpName   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName   =   $_myrowRes['FirstName']. " " .$_myrowRes['LastName'];
        }

        return $_EmpName ;

    }
	
	function getSELECTEDEMPLOYEFIRSTNAMEWFONLY($str_dbconnect,$_EmpCode) {

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_EmpName   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName   =   $_myrowRes['FirstName'];
        }

        return $_EmpName ;

    }
	
	
	function getSELECTEDDESIGNATIONNAMEWF($str_dbconnect,$strDesCode) {

        $Designation    =   "";

		$_SelectQuery 	= 	"SELECT * FROM tbl_designation WHERE DesCode = '$strDesCode'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $Designation   =   $_myrowRes['Designation'];
        }

		return $Designation ;

	}	
	
	function getSELECTEDEMPLOYEFIRSTNAMEWFONLYDESIGNATION($str_dbconnect,$_EmpCode) {

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_DesCode   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_DesCode   =   $_myrowRes['DesCode'];
        }

        return getSELECTEDDESIGNATIONNAMEWF($str_dbconnect,$_DesCode) ;

    }
	
	
	function Get_Supervior($str_dbconnect,$LogUserCode, $Country){   
	
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
		if($Country == "UK"){
			$timezone = "Europe/London";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
		
        $crt_date  = date("Y-m-d");
		
		$MailFirstPart	=	"";
		$wk_Owner		= 	"";
		$wk_Div			= 	"";
		$wk_Dpt			= 	"";
		
		$Daily			=	"";
		$Weekly			=	"";
		$Monthly		=	"";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' limit 1";        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {           
            $wk_Owner   = $_myrowRes['report_owner'];
			$wk_Div		= $_myrowRes['report_div'];
			$wk_Dpt		= $_myrowRes['report_Dept'];            
        }
		
		$num_rows = 0;
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' AND `schedule` = 'Daily'";        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows 		= mysqli_num_rows($_ResultSet);
	
		if ( $num_rows > 0 ) {
			$Daily = "Daily /";	
		}
		
		$num_rows = 0;
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' AND `schedule` = 'Weekly'";        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows 		= mysqli_num_rows($_ResultSet);
	
		if ( $num_rows > 0 ) {
			$Weekly = "Weekly /";	
		}
		
		$num_rows = 0;
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' AND `schedule` = 'Monthly'";        
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows 		= mysqli_num_rows($_ResultSet);
	
		if ( $num_rows > 0 ) {
			$Monthly = "Monthly /";	
		}
		

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {           
            $wk_Owner   = $_myrowRes['report_owner'];
			$wk_Div		= $_myrowRes['report_div'];
			$wk_Dpt		= $_myrowRes['report_Dept'];            
        }
		
		
		$MailFirstPart = getSELECTEDEMPLOYEFIRSTNAMEWFONLY($str_dbconnect,$wk_Owner)." - W/F - ".$wk_Div." (".getGROUPNAMEDIV($str_dbconnect,$wk_Dpt).") ".getSELECTEDEMPLOYEFIRSTNAMEWFONLY($str_dbconnect,$LogUserCode)." (".getSELECTEDEMPLOYEFIRSTNAMEWFONLYDESIGNATION($str_dbconnect,$LogUserCode).") - ".$Daily." ".$Weekly." ".$Monthly." ";
        
		return $MailFirstPart;
    }
	
	function getWFUPDATEMAILSUMMARY($str_dbconnect){
        
        $HTML = "";
        $today_date  = date("d-m-Y");
        
        $_EmpName    =   "";
        $_DesCode    =   "";
		
		$_SelectQuery 	=   "SELECT * FROM tbl_projectgroups ORDER BY Country" or die(mysqli_error($str_dbconnect));
        $_DeptSet 		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		$HTML .= "<html>";
        $HTML .= "<head>";
        $HTML .= "<style type=\"text/css\">
            body{
                font-family:sans serif;
                font-size:12px;
                color:#000066;
            }            
            table{
                border-collapse:collapse;
                border:1px solid black;
                border-color: #000066;
            }
            th{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
            td{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
        </style>";
        
        $HTML .= "</head>";
        $HTML .= "<body>";
		
		$HTML .= "<center><h1><b>Daily Work Flow : </b>".$today_date."</h1></center></br>";
        $HTML .= "<center><h2><b>W/F User : </b>".$_EmpName ."</h2></center></br>";
        $HTML .= "</br></br>" ;
		
		$HTML .= "</br>".$_DptRes['Country']. "-" . $_DptRes['GrpCode'] ."</br>" ;
			        
        $HTML .= "<table cellpadding=\"5px\" cellspacing=\"0\" width=\"100%\" border=\"1px\">";
        $HTML .= "<thead style=\"background-color: #FFE7A1\">";
        $HTML .= "<tr>";                    
	        $HTML .= "<th rowspan='2'>Task Name</th>";
	        $HTML .= "<th rowspan='2'>Start Time</th>";
			$HTML .= "<th rowspan='2'>End Time</th>";
			$HTML .= "<th colspan='3'>Task Status</th>";
	        $HTML .= "<th rowspan='2'>Notes & Attachments</th>";                                                
        $HTML .= "</tr>";
		$HTML .= "<tr>";
			$HTML .= "<th rowspan='2'>Done</th>";
	        $HTML .= "<th rowspan='2'>In Complete</th>";
			$HTML .= "<th rowspan='2'>N/A</th>";
		$HTML .= "</tr>";
        $HTML .= "</thead>";
        $HTML .= "<tbody>";
		
		while($_DptRes = mysqli_fetch_array($_DeptSet)) {
        
	        /*$_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$LogUserCode'" or die(mysqli_error($str_dbconnect));
	        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	        $_MailAdd   =   "";
	
	        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
	            $_EmpName    =   $_myrowRes['FirstName']. " " . $_myrowRes['LastName'];
	            $_DesCode    =   $_myrowRes['DesCode'];
	        }*/
	        
	        
	        
			$CYes 	= 0;
			$CNo	= 0;
	        $CNA	= 0;
			
			$Country 	 = "";
			$Department	 = "";
			$Employee	 = "";
			
			$Country 	 	= 	$_DptRes['Country'];
			$Department		=	$_DptRes['GrpCode'];
			$DepartmentN	= 	getGROUPNAMEDIV($str_dbconnect,$_DptRes['GrpCode']);
			
			$OLDCountry		=	"";
			$OLDDeprtment	=	"";
			$OLDEmployee	=	"";
			
			$_SelectQuery 	=   "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '".$today_date."' AND 
								wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$Country."' AND `report_Dept` = '".$Department."') ORDER BY `wk_owner`" or die(mysqli_error($str_dbconnect));
	        $_ResultSet		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			
			/*$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' order by `start_time`";
                    
       	 $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
	       
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				
				echo $Employee;
				
				$Employee = $_myrowRes['wk_owner'];
				
				$EMPNAME = getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$Employee);
				
				if(($OLDCountry != $Country && $OLDCountry == "") or ($OLDDeprtment != $Department && $OLDDeprtment == "") or ($OLDEmployee != $Employee && $OLDEmployee == "")){
					$HTML .= "<tr>";
						$HTML .= "<td colspan='7' style=\"background-color: #FFE7A1\">";
							$HTML .= "Divsion : ".$Country. " | Department : ".$DepartmentN . " | Employee : ".$EMPNAME ;
						$HTML .= "</td>";	
					$HTML .= "</tr>";
				}
				
				/*if($OLDDeprtment != $Department && $OLDDeprtment == ""){
					$HTML .= "<tr>";
						$HTML .= "<td colspan='7' style=\"background-color: #FFE7A1\">";
							$HTML .= "Divsion : ".$Country. " | Department ".$Department ;
						$HTML .= "</td>";	
					$HTML .= "</tr>";
				}*/
				
				$OLDCountry 	= $Country;
				$OLDDeprtment 	= $Department;
				$OLDEmployee 	= $Employee;
				
				$HTML .= "<tr>"; 
					$HTML .= "<td>";
						$HTML .= "[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'];
					$HTML .= "</td>";
					$HTML .= "<td>";
						$HTML .= $_myrowRes['start_time'];
					$HTML .= "</td>";
					$HTML .= "<td>";
						$HTML .= $_myrowRes['end_time'];
					$HTML .= "</td>";
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "There are no Attachments to Download";
	                    }
					$HTML .= "</td>";
				$HTML .= "</tr>";	
				
	        } 
			
			if($CYes != 0 || $CNo != 0 || $CNA != 0 ){
			
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='3'>";
							$HTML .= "<b><font color='Red'><h2>Summary Total For Daily Task</b></font></h2>";
						$HTML .= "</td>";
						$HTML .= "<td>";
							$HTML .= $CYes;
						$HTML .= "</td>";
						$HTML .= "<td>";
							$HTML .= $CNo;
						$HTML .= "</td>";
						$HTML .= "<td>";
							$HTML .= $CNA;
						$HTML .= "</td>";
						$HTML .= "<td>";
							$HTML .= "";
						$HTML .= "</td>";
				$HTML .= "</tr>";		
			}
		}              
        $HTML .= "</tbody>";
        $HTML .= "</table>";  
        $HTML .= "</body>";
        $HTML .= "</html>";  
        
        return $HTML ;
		
    }
    
?>
