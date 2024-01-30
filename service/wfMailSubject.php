	<?php 
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    
//$connection = include_once('../connection/previewconnection.php');
	include ("../class/accesscontrole.php");
	
    $LogUserCode = $_GET["EmpCode"];
	$Country = $_GET["Country"];
	$today_date  = date("Y-m-d");
	
	mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	 function getSELECTEDDESIGNATIONNAMEWF($str_dbconnect,$strDesCode) 
	{
	    global $connection; 
        $Designation    =   "";
        
		$_SelectQuery 	= 	"SELECT * FROM tbl_designation WHERE DesCode = '$strDesCode'";
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            $Designation   =   $_myrowRes['Designation'];
        }

		return $Designation ;

	} 	
	
	
	 function getSELECTEDEMPLOYEFIRSTNAMEWFONLYDESIGNATION($str_dbconnect,$_EmpCode) 
	{
		global $connection;

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'";
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $_DesCode   =   "";

        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            $_DesCode   =   $_myrowRes['DesCode'];
        }

        return getSELECTEDDESIGNATIONNAMEWF($str_dbconnect,$_DesCode) ;

    }
	
	
	
	
	
	
	function getGROUPNAMEDIV($str_dbconnect,$strGrpCode) 
	{
		global $connection;

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'";

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}
	
	function getSELECTEDEMPLOYEFIRSTNAMEWFONLY($str_dbconnect,$_EmpCode) 
	{
		global $connection;
      
        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'";
        $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_EmpName   =   "";

        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            $_EmpName   =   $_myrowRes['FirstName'];
        }

        return $_EmpName ;

    }
	 
	
	function Get_Supervior($str_dbconnect)
	{   
	global $LogUserCode,$Country,$connection;
	
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
		
        $crt_date  = date("Y-m-d");
		
		$MailFirstPart	=	"";
		$wk_Owner		= 	"";
		$wk_Div			= 	"";
		$wk_Dpt			= 	"";
		
		$Daily			=	"";
		$Weekly			=	"";
		$Monthly		=	"";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' limit 1";        
        $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{           
            $wk_Owner   = $_myrowRes['report_owner'];
			$wk_Div		= $_myrowRes['report_div'];
			$wk_Dpt		= $_myrowRes['report_Dept'];            
        }
		
		
		$num_rows = 0;
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' AND `schedule` = 'Daily'";        
        $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows 		= mysqli_num_rows($_ResultSet);
	
		if ( $num_rows > 0 ) 
		{
			$Daily = "Daily /";	
		}
		
		 $num_rows = 0;
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' AND `schedule` = 'Weekly'";        
        $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows 		= mysqli_num_rows($_ResultSet);
	
		if ( $num_rows > 0 ) {
			$Weekly = "Weekly /";	
		}
		
		
		$num_rows = 0;
		$_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$LogUserCode' AND `schedule` = 'Monthly'";        
        $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$num_rows 		= mysqli_num_rows($_ResultSet);
	
		if ( $num_rows > 0 ) {
			$Monthly = "Monthly /";	
		}
		

        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) {           
            $wk_Owner   = $_myrowRes['report_owner'];
			$wk_Div		= $_myrowRes['report_div'];
			$wk_Dpt		= $_myrowRes['report_Dept'];            
        }
		
		
		$MailFirstPart = getSELECTEDEMPLOYEFIRSTNAMEWFONLY($str_dbconnect,$wk_Owner) ." - W/F - ".$wk_Div."(".getGROUPNAMEDIV($str_dbconnect,$wk_Dpt).")".getSELECTEDEMPLOYEFIRSTNAMEWFONLY($str_dbconnect,$LogUserCode)."(".getSELECTEDEMPLOYEFIRSTNAMEWFONLYDESIGNATION($str_dbconnect,$LogUserCode).") - ".$Daily." ".$Weekly." ".$Monthly." "; 
        
		return $MailFirstPart; 
    }
	
	$WKOwner = Get_Supervior($str_dbconnect);				
				
	$timestamp = strtotime($today_date);
    $TodayDay = date("l", $timestamp);
				
	$MailTitile = $WKOwner." - ".$TodayDay." Date : ".$today_date."";
   // echo $MailTitile;
		$array = "[{";
	$array =$array.'"EmailSubject":"'  . $MailTitile.'"}]';
	echo $array;
	?>