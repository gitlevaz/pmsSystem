<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   SQL Commands for Access Controle
 * Last Update      :   19-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */


//  Password Encryption

function encode5t($str)
{
    for($i=0; $i<5;$i++)
    {
        $str=strrev(base64_encode($str)); //apply base64 first and then reverse the string
    }
    return $str;
}

//  Password Decryption

function decode5t($str)
{
    for($i=0; $i<5;$i++)
    {
        $str=base64_decode(strrev($str)); //apply base64 first and then reverse the string}
    }
    return $str;
}

//  User Login Authontications
function getUSER_ACCESS($str_dbconnect,$str_UserName, $str_Password) {
                
    $str_EncodedPassword    =	encode5t($str_Password) ;
    $str_Authonticate       =	"-";

    $str_SelectQuery        = 	"SELECT * FROM tbl_sysusers WHERE User_name = '$str_UserName' AND User_password = '$str_EncodedPassword'" or die(mysqli_error($str_dbconnect));
    $str_ResultSet          =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {
        $str_Authonticate   =	$_myrowRes['Id'];;
    }    
    return $str_Authonticate  ;

}

function getUSER_ACCESSByCode($str_dbconnect,$str_UserName) {
                
    //$str_EncodedPassword    =	encode5t($str_Password) ;
    $str_Authonticate       =	"-";

    $str_SelectQuery        = 	"SELECT * FROM tbl_sysusers WHERE WMF_Code = '$str_UserName'" or die(mysqli_error($str_dbconnect));
    $str_ResultSet          =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {
        $str_Authonticate   =	$_myrowRes['Id'];;
    }    
    return $str_Authonticate  ;

}

function getUSER_DETAILS($str_dbconnect) {

    $str_SelectQuery        = 	"SELECT * FROM tbl_sysusers" or die(mysqli_error($str_dbconnect));
    $str_ResultSet          =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $str_ResultSet  ;

}

function getSELECTEDDETAILS($str_dbconnect,$Str_UserCode) {    
     
    $str_SelectQuery        = 	"SELECT * FROM tbl_sysusers WHERE id = '$Str_UserCode'" or die(mysqli_error($str_dbconnect));
    $str_ResultSet          =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $str_ResultSet  ;

}

function GetAccessSetting($str_dbconnect,$GrpCode, $AccCode ) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_accesssettings WHERE `GrpCode` = '$GrpCode' AND `AccPoint` = '$AccCode'" or die(mysqli_error($str_dbconnect));

		$result = mysqli_query($str_dbconnect,$_SelectQuery)or die(mysqli_error($str_dbconnect));
		$num_rows = mysqli_num_rows($result) ;

		return $num_rows ;

	}

function createAccess($str_dbconnect,$GrpCode, $AccCode ) {

		$Description	=	getACCESSPOINTNAME($str_dbconnect,$AccCode) ;

		$_SelectQuery 	= 	"INSERT INTO tbl_accesssettings (`GrpCode`, `AccPoint`, `Description`) VALUES ('$GrpCode', '$AccCode', '$Description')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	function deleteAccess($str_dbconnect,$GrpCode, $AccCode) {

		$_SelectQuery 	= 	"DELETE FROM tbl_accesssettings WHERE GrpCode = '$GrpCode' AND  AccPoint = '$AccCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

function getUSERACCESSPOINTS($str_dbconnect,$_GrpCode, $_AccCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_accesssettings WHERE GrpCode = '$_GrpCode' AND AccPoint = '$_AccCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return mysqli_num_rows($_ResultSet) ;

	}

	function getACCESSBYGROUP($str_dbconnect,$_GrpCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_accesspoint WHERE Acccode NOT IN (SELECT AccPoint FROM tbl_accesssettings WHERE GrpCode = '$_GrpCode')" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}

	function getACCESSPOINTNAME($str_dbconnect,$AccCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_accesspoint WHERE Acccode = '$AccCode'" or die(mysqli_error($str_dbconnect));

		$_TaskSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		while($_TaskRows = mysqli_fetch_array($_TaskSet)) {

			$Description	=	$_TaskRows["Description"] ;

		}

		return $Description ;

	}


function getACCESSPOINTS($str_dbconnect,$_GrpCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_accesssettings WHERE GrpCode = '$_GrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}
	
	
	
	/*Added by thilina for PMS Email Bcc group on 2014-07-16*/
	
	function getAllEmployeesforEmailBcc($str_dbconnect,$_GrpCode,$_Category) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpCode NOT IN (SELECT EmpCode FROM tbl_employee WHERE EmpCode='$_GrpCode' AND EmpSts='A') AND EmpCode NOT IN (SELECT BccEmpCode FROM tbl_emailbccgroup WHERE OwnerEmpCode='$_GrpCode' AND Category='$_Category' AND EmailBccStatus='A') AND EmpSts='A' ORDER BY FirstName " or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		return $_ResultSet ;
	}
	
	
	function getBccEmployees($str_dbconnect,$_GrpCode,$_Category) {
		
		$_SelectQuery 	= 	"SELECT e.EmpCode,e.FirstName,e.LastName FROM tbl_emailbccgroup ebg JOIN tbl_employee e ON ebg.BccEmpCode=e.EmpCode WHERE Category ='$_Category' AND OwnerEmpCode='$_GrpCode' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		return $_ResultSet ;

	}
	
	function createEmailBcc($str_dbconnect,$GrpCode, $AccCode,$_Category,$_LoggedEmpCode) {
		$Dte_CrtDate    = 	date("Y/m/d") ; 
		$Dte_UpdDate    = 	date("Y/m/d") ; 
		$_SelectQuery 	= 	"INSERT INTO tbl_emailbccgroup (`Category`, `OwnerEmpCode`, `BccEmpCode`,`CreatedDate`,`CreatedBy`,`UpdatedDate`,`DeletedBy`,`EmailBccStatus`) VALUES ('$_Category', '$GrpCode', '$AccCode','$Dte_CrtDate','$_LoggedEmpCode','$Dte_UpdDate' ,'','A')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	function deleteEmailBcc($str_dbconnect,$GrpCode, $AccCode,$_Category,$_LoggedEmpCode) {
		$Dte_CrtDate    = 	date("Y/m/d") ; 
		$_SelectQuery 	= 	"UPDATE tbl_emailbccgroup SET  UpdatedDate='$Dte_CrtDate', DeletedBy='$_LoggedEmpCode', EmailBccStatus='I'  WHERE OwnerEmpCode = '$GrpCode' AND  BccEmpCode = '$AccCode' AND Category='$_Category'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}
	
	function USER_Login($str_dbconnect,$conn,$str_UserName, $str_Password) {
                
    $str_EncodedPassword    =	encode5t($str_Password) ;
    $str_Authonticate       =	"-";

    $str_SelectQuery        = 	"SELECT * FROM tbl_sysusers WHERE User_name = '$str_UserName' AND User_password = '$str_EncodedPassword'" or die(mysqli_error($str_dbconnect));
    $str_ResultSet          =   mysqli_query($str_dbconnect,$conn,$str_SelectQuery) or die(mysqli_error($conn));

    while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {
        $str_Authonticate   =	$_myrowRes['EmpCode'];;
    }    
    return $str_Authonticate  ;

}
	
	
	/*End of Added by thilina for PMS Email Bcc group on 2014-07-16*/

function InsertApplicationLog($str_dbconnect,$connection,$type,$code,$loggedUser){
	
  date_default_timezone_set("Asia/Colombo");	
  $today_date  = date("Y-m-d H:i:sa");
 
  $str_SelectQuery  = "INSERT INTO `tbl_applicationlog` (`LogType`,`Code`,`LoggedUser`,`DateTime`) VALUES ('$type', '$code', '$loggedUser', '$today_date')";
  
  mysqli_query($str_dbconnect,$connection, $str_SelectQuery) or die(mysqli_error($connection));
  
}

?>
