	<?php 
    //$connection = include_once('../connection/mobilesqlconnection.php');
	include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    
//$connection = include_once('../connection/previewconnection.php');
	include ("../class/accesscontrole.php");
	
    $LogUserCode = $_GET["LogUserCode"];
	$Country = $_GET["Country"];
	$timezone = "Asia/Colombo";	
	$String="";
	$_SelectQuery = "";  
	//$array = array();
	
	
	mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

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
    $today_date  = date("Y-m-d");
    
	function getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpCode) 
	{
	global $connection;
	$_MailAdd   =   "";
	
    $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$EmpCode'";
    $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error(str_dbconnect));
    $Result1 = mysqli_num_rows($_ResultSet);
    
    
    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
	{
		
        $_MailAdd    =   $_myrowRes['EMail'];
		
    }
     
    return $_MailAdd ;

   }
	
	$String=$String.getSELECTEDEMPLOYEEMAIL($str_dbconnect,$LogUserCode).",";
	
	
	
	 $Query 	= "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
	$_Result= mysqli_query($str_dbconnect,$Query) or die(mysqli_error(str_dbconnect));
    $Result1 = mysqli_num_rows($_Result);
	
    while($_myrow = mysqli_fetch_assoc($_Result)) 
	{
		$wk_id = $_myrow['wk_id'];
        $_SelectQuery 	=   "SELECT * FROM tbl_wfalert WHERE FacCode = '$wk_id'";
        $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error(str_dbconnect)); 
				
			while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
	        {
		            $EmpDpt =   $_myrowRes['EmpCode'];
					
                    $String = $String.getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt).",";
            		
		    }		 
            
    } 
	$array = "[{";
	$array =$array.'"Email":"'  . $String.'"}]';
	echo $array;
	// $array =$array.',"Impediment":"'  . implode('|',$row).'"}]';
 // array_push($array, $String);
 //echo json_encode($array);	
  // echo json_encode($String);
  
	
    		
		
	?>