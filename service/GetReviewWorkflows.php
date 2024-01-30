	<?php 
	//$connection = include_once('../connection/sqlconnection.php');
	//$connection = include_once('../connection/previewconnection.php');
	$connection = include_once('../connection/mobilesqlconnection.php');
	include ("../class/accesscontrole.php");
	
	$ReviewUserCode = $_GET["EmpCode"];
	//ReviewUser
	//$LogUserCode = $_GET["LogUserCode"];
	$Country = $_GET["Country"];
	/* $array = array(); */
	$WFUser_cat = "0"; 		
	
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
		
	       
	date_default_timezone_set($timezone);		
	$crt_date  = date("Y-m-d");
    $today_date  = date("Y-m-d");
	
	function Get_DailyWorkFlow($link)
	{
		global $ReviewUserCode,$crt_date,$today_date,$connection;
		
        $_SelectQuery 	= "SELECT * FROM tbl_workflow WHERE `schedule` = 'Daily' AND `wk_Owner` = '$ReviewUserCode'  AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$ReviewUserCode')";        
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
	
	function Get_WeeklyWorkFlow($link)
	{
	    global $ReviewUserCode,$crt_date,$today_date,$connection;
        $today_date  = date("l");
        
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Weekly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$ReviewUserCode'   AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$ReviewUserCode')";        
        $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            
            $wk_id     = $_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name   = $_myrowRes['wk_name'];
            $start_time = $_myrowRes['start_time'];
            $end_time = $_myrowRes['end_time'];
            $catcode = $_myrowRes['catcode'];
            $Wf_Desc = $_myrowRes['WF_Desc'];
            $WFUser_cat = $_myrowRes['WFUser_cat'];
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `WF_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($link));
            
             $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
			
            
        }
        
    }
  
	function Get_MonthlyWorkFlow($link)
	{
	global $ReviewUserCode,$crt_date,$today_date,$connection;
		
        $today_date  = date("j");
		
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `schedule` = 'Monthly' AND `sched_time` = '$today_date' AND `wk_Owner` = '$ReviewUserCode' AND `wk_name` NOT IN (SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$ReviewUserCode')";        
        $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            
            $wk_id    	=	$_myrowRes['wk_id'];
            $wk_Owner   = $_myrowRes['wk_Owner'];
            $wk_name  	= $_myrowRes['wk_name'];
            $start_time = $_myrowRes['start_time'];
            $end_time 	= $_myrowRes['end_time'];
            
            $catcode 	= $_myrowRes['catcode'];
            $Wf_Desc 	= $_myrowRes['WF_Desc'];
			$WFUser_cat = $_myrowRes['WFUser_cat'];
            
            
            $_SelectQuery 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc', '$WFUser_cat')" or die(mysqli_error($link));
            
             $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
			
            
        }
        
    }
  
    function Get_DailyEQFlow($link)
	{
		global $ReviewUserCode,$crt_date,$today_date,$connection;
        $Equipment = "";
        $EqMaint = "";
        
        
        $_SelectQuery 	=   "SELECT * FROM tbl_wkequip WHERE `wf_date` = '".$crt_date."' AND `wf_emp` = '$ReviewUserCode' AND `eq_ser` NOT IN (SELECT `wk_id` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$ReviewUserCode')";        
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
			
            
        }
        
    }
	
	/* Get_DailyWorkFlow($link);
			
    Get_WeeklyWorkFlow($link);
			
    Get_MonthlyWorkFlow($link);
			
    Get_DailyEQFlow($link); */
	
	$LogUserCode=str_replace("-", '/',$LogUserCode);
	//$_SelectQuery ="SELECT * FROM tbl_workflowupdate wku left JOIN tbl_workflow wk on wku.wk_id=wk.wk_id WHERE  wk.report_owner='$LogUserCode' and
	//wku.crt_date = '$crt_date' AND wku.wk_owner = '$ReviewUserCode'  order by wku.start_time";
    $_SelectQuery =	"SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_owner` = '$ReviewUserCode'  order by `start_time";	
    mysqli_set_charset($connection, "utf8");	
    $Result=mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));    
	
	if($Result!=null)
	{
		$rows = array();
		while($r = mysqli_fetch_assoc($Result))
		{
			$r['wk_name'] = iconv('UTF-8', 'UTF-8//IGNORE', $r['wk_name']);
			$r['Wf_Desc'] = iconv('UTF-8', 'UTF-8//IGNORE', $r['Wf_Desc']);				
			$rows[] = $r;
		}
		echo json_encode($rows);
	}	
	
	        
			
			
			
			
			
			
			
	?>