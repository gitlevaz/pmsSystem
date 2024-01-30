<?php 
//$connection = include_once('../connection/sqlconnection.php');
 //$connection = include_once('../connection/previewconnection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
	include ("../class/accesscontrole.php");
	$LogUserCode = $_GET["EmpCode"];
	$worfflowId = $_GET["workflowId"];
	$_MailCcAdd   =   "";
	
	
	if($LogUserCode != null && $worfflowId != null)
	{
		
		$_SelectQuery2	=   "SELECT * FROM tbl_workflow WHERE wk_id='$worfflowId' and wk_Owner='$LogUserCode'";
					$_ResultSet2 	= mysqli_query($str_dbconnect,$connection , $_SelectQuery2) or die(mysqli_error($link));
					
					while($_myrowRes2 = mysqli_fetch_assoc($_ResultSet2))
					{
						$rpowner = $_myrowRes2['report_owner'];
						$rpmail = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$rpowner);
						$_MailCcAdd    =   $_MailCcAdd.$rpmail.",";
						
						$crtby   		=   $_myrowRes2['crt_by'];
						$crtbymail = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$crtby);
						$_MailCcAdd    =   $_MailCcAdd.$crtbymail.",";
						
						
						$wowner  		=   $_myrowRes2['wk_Owner'];
						$wownermail = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$wowner);
						$_MailCcAdd    =   $_MailCcAdd.$wownermail.",";
												
					} 
					
	}
	
	
				

function getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_EmpCode) {

	global $connection;
    $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($link));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$connection , $_SelectQuery) or die(mysqli_error($link));

    $_MailAdd   =   "";
    
    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) {
        $_MailAdd    =   $_myrowRes['EMail'];
    }

    return $_MailAdd ;

}


 $_MailCcAdd = substr( $_MailCcAdd,0,-1);
     
	 $array = "[{";
	$array =$array.'"EmailCc":"'  . $_MailCcAdd.'"}]';
	echo $array;
	 
    return $array;






	



?>