<?php

    /*session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("../class/accesscontrole.php"); //  sql commands for the access controles
    include ("../class/sql_empdetails.php"); //  connection file to the mysql database
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    
    require_once("../class/class.phpmailer.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database
    
    include ("../class/sql_wkflow.php");            //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	
	$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = 'EMP/27' AND wk_id IN ('WK/3040','WK/3041','WK/3042','WK/3043','WK/3044','WK/3045','WK/3046','WK/3047','WK/3048','WK/3049','WK/3050','WK/3051','WK/3052','WK/3053','WK/3054','WK/3055','WK/3056','WK/3057','WK/3058','WK/3059','WK/3060','WK/3061','WK/3062','WK/3063','WK/3064','WK/3065','WK/3066','WK/3067','WK/3068','WK/3069','WK/3070','WK/3071','WK/3072','WK/3073','WK/3074')";
    
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
	    $wk_id     = $_myrowRes['wk_id'];
	    
		$wk_Owner   = 'EMP/24';
	    //$wk_name   = $_myrowRes['wk_name'];
	    $start_time = $_myrowRes['start_time'];
	    //$end_time = $_myrowRes['end_time'];
	    //$catcode = $_myrowRes['catcode'];
		
		$wk_name		= $_myrowRes['wk_name'];
		//$wk_Owner		= $_myrowRes['wk_Owner'];
		$schedule		= $_myrowRes['schedule'];
		$sched_time		= $_myrowRes['sched_time'];
		$start_time		= $_myrowRes['start_time'];
		$end_time		= $_myrowRes['end_time'];
		$report_owner	= $_myrowRes['report_owner'];
		$report_div		= $_myrowRes['report_div'];
		$report_Dept	= $_myrowRes['report_Dept'];
		//$crt_date		= $_myrowRes['schedule'];
		$crt_by			= $_myrowRes['crt_by'];
		//$FacCode		= $_myrowRes['schedule'];
		$wfcategory		= $_myrowRes['catcode'];
	    
	    $crt_date  = date("Y-m-d");            
	    
	    
			
		$_Serial_Val    =   -1;
        $_CompCode      =   "CIS";

        $_SelectQuery1   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'" or die(mysqli_error($str_dbconnect));
        $_ResultSet1     =  mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));

        while($_myrowRes1 = mysqli_fetch_array($_ResultSet1)) {
            $_Serial_Val =   $_myrowRes1['Serial'];
        }

        $_Serial_Val = $_Serial_Val + 1;

        $_SelectQuery101   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery101) or die(mysqli_error($str_dbconnect)); 

        $Str_WKID = "WK/" . $_Serial_Val;
        //$Str_UPLCode = $_SESSION["NewUPLCode"];              

        $wk_id = $Str_WKID;
		$FacCode = $_myrowRes['wk_id'];
        
		//createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory);
		
		$_SelectQuery102 	=   "INSERT INTO tbl_workflow (`wk_id`, `wk_name`, `wk_Owner`, `schedule`, `sched_time`, `start_time`, `end_time`, `report_owner`, `report_div`, `report_Dept`, `crt_date`, `status`, `crt_by`, `catcode`)
                             VALUES ('$wk_id', '$wk_name', '$wk_Owner', '$schedule', '$sched_time', '$start_time', '$end_time', '$report_owner', '$report_div', '$report_Dept', '$crt_date', 'A', '$crt_by', '$wfcategory')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery102) or die(mysqli_error($str_dbconnect));
        
        
        $_SelectQuery3 = "SELECT * FROM tbl_wfalert WHERE `FacCode` = '$FacCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet3 = mysqli_query($str_dbconnect,$_SelectQuery3) or die(mysqli_error($str_dbconnect));

        while($_myrowRes3 = mysqli_fetch_array($_ResultSet3)) {                
            $_EmpCode     =	$_myrowRes3['EmpCode'];
            
            $_SelectQuery150 =   "INSERT INTO tbl_wfalert (`FacCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$wk_id', '$_EmpCode', '', 'A')" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery150) or die(mysqli_error($str_dbconnect));
			
			echo "*******".$wk_id." - ".$_EmpCode."****</br>";
        }
		
		
		echo $_myrowRes['wk_id'].":".$wk_id." - ".$wk_Owner." - ".$wk_name." - ".$start_time."</br>";
        
	}*/
	
	    
?>