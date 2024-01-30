<?php

    function get_SerialEMP($str_dbconnect,$str_Serial, $str_Description) {

    $_CompCode      =	$_SESSION["CompCode"];
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

function getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_EmpCode) {

    $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_MailAdd   =   "";
    
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_MailAdd    =   $_myrowRes['EMail'];
    }

    return $_MailAdd ;

}

/*.................................. Thilina 07-01-2014 - Create a method to return employee email address who's Employee Status is ACTIVE .........................  */

function getSELECTEDACTIVEEMPLOYEEMAIL($str_dbconnect,$_EmpCode) {

    $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode' AND EmpSts = 'A'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_MailAdd   =   "";
    
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_MailAdd    =   $_myrowRes['EMail'];
    }

    return $_MailAdd ;

}

/* ......................................................................................................................................................................*/


function getSELECTEDEMPLOYENAME($str_dbconnect,$_EmpCode) {

    $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_EmpName   =   "";

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_EmpName   =   $_myrowRes['FirstName']." ". $_myrowRes['LastName'];
    }

    return $_EmpName ;

}

    #	Function to Create Employee Details to the database Server .........
	function createEMPLOYEEByReported($str_dbconnect,$_EPF, $_Address1, $_Street, $_City, $_Title, $_FirstName, $_LastName, $_ContactL, $_ContactM, $_FaxNo, $_EMail , $_DesCode, $_DeptCode, $_Division, $reportedOwner) {


        $_EmpCode       = 	get_SerialEMP($str_dbconnect,"1003", "EMPLOYEE CODE");
        $_Employee      = 	"EMP/".$_EmpCode;

		$_SelectQuery 	= 	"INSERT INTO tbl_employee (`EmpCode`, `EmpNIC`, `Address1`, `Street`, `City`, `Title`, `FirstName`, `LastName`, `ContactL`, `ContactM`, `FaxNo`, `EMail`, `DesCode` , `EmpSts`, `DeptCode`, `Division`, `report_owner`) VALUES ('$_Employee', '$_EPF', '$_Address1', '$_Street', '$_City', '$_Title', '$_FirstName', '$_LastName', '$_ContactL', '$_ContactM', '$_FaxNo', '$_EMail', '$_DesCode' , 'A', '$_DeptCode', '$_Division', '$reportedOwner')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                Return $_Employee ;
		
	}

    #	Function to Create Employee Details to the database Server .........
	function createEMPLOYEE($str_dbconnect,$_EPF, $_Address1, $_Street, $_City, $_Title, $_FirstName, $_LastName, $_ContactL, $_ContactM, $_FaxNo, $_EMail , $_DesCode, $_DeptCode, $_Division) {


        $_EmpCode       = 	get_SerialEMP($str_dbconnect,"1003", "EMPLOYEE CODE");
        $_Employee      = 	"EMP/".$_EmpCode;

		$_SelectQuery 	= 	"INSERT INTO tbl_employee (`EmpCode`, `EmpNIC`, `Address1`, `Street`, `City`, `Title`, `FirstName`, `LastName`, `ContactL`, `ContactM`, `FaxNo`, `EMail`, `DesCode` , `EmpSts`, `DeptCode`, `Division`) VALUES ('$_Employee', '$_EPF', '$_Address1', '$_Street', '$_City', '$_Title', '$_FirstName', '$_LastName', '$_ContactL', '$_ContactM', '$_FaxNo', '$_EMail', '$_DesCode' , 'A', '$_DeptCode', '$_Division')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                Return $_Employee ;
		
	}

	#	Function to Update Employee Details to the database Server .........https://pms.tkse.lk/Employee.php?&empcode=EMP/1015
	function updateEMPLOYEEByReported($str_dbconnect,$_EmpCode, $_EPF, $_Address1, $_Street, $_City, $_Title, $_FirstName, $_LastName, $_ContactL, $_ContactM, $_FaxNo, $_EMail, $_DesCode, $_DeptCode, $_Division , $_report_owner) {

		$_SelectQuery 	= 	"UPDATE tbl_employee SET `EmpNIC` = '$_EPF', `Address1` = '$_Address1', `Street` = '$_Street', `City` = '$_City', `Title` = '$_Title', `FirstName` = '$_FirstName', `LastName` = '$_LastName', `ContactL` = '$_ContactL', `ContactM` = '$_ContactM', `FaxNo` = '$_FaxNo', `EMail` = '$_EMail'  , `DesCode` = '$_DesCode' , `DeptCode` = '$_DeptCode', `Division` = '$_Division', `report_owner` = '$_report_owner' WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

		
	#	Function to Update Employee Details to the database Server .........
	function updateEMPLOYEE($str_dbconnect,$_EmpCode, $_EPF, $_Address1, $_Street, $_City, $_Title, $_FirstName, $_LastName, $_ContactL, $_ContactM, $_FaxNo, $_EMail, $_DesCode, $_DeptCode, $_Division) {

		$_SelectQuery 	= 	"UPDATE tbl_employee SET `EmpNIC` = '$_EPF', `Address1` = '$_Address1', `Street` = '$_Street', `City` = '$_City', `Title` = '$_Title', `FirstName` = '$_FirstName', `LastName` = '$_LastName', `ContactL` = '$_ContactL', `ContactM` = '$_ContactM', `FaxNo` = '$_FaxNo', `EMail` = '$_EMail'  , `DesCode` = '$_DesCode' , `DeptCode` = '$_DeptCode', `Division` = '$_Division' WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	#	Function to get All Employee Details ..........................
	function getEMPLOYEEDETAILS($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' order by FirstName" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}	
	
	function getEMPLOYEEDETAILSName($str_dbconnect,$empid) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' and EmpCode='$empid' order by FirstName" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}	
	
	function getEMPLOYEEDETAILSWFSupervisor($str_dbconnect,$LogUserCode) {

	$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND `EMPCODE` = '$LogUserCode' OR EMPCode IN (SELECT DISTINCT `wk_Owner` FROM `tbl_workflow` WHERE `report_owner` = '$LogUserCode')" or die(mysqli_error($str_dbconnect));

	$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


	return $_ResultSet ;

	}

	#	Function to get selected Employee ..........................
	function getSELECTEDEMPLOYEE($str_dbconnect,$_EmpCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

	#	Function to Delete Employee Details from the database Server .........
	function deleteEMPLOYEE($str_dbconnect,$_EmpCode) {

		$_SelectQuery 	= 	"UPDATE tbl_employee SET `EmpSts` = 'D' WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

        #	Function to Insert Designations to the database Server .........
	function createDESIGNATION($str_dbconnect,$strDesCode, $strDesignation, $strTask) {

		$_SelectQuery 	= 	"INSERT INTO tbl_designation (`DesCode`, `Designation`, `Task`, `DesStat`) VALUES ('$strDesCode', '$strDesignation', '$strTask', 'A')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	#	Function to get All Designations ..........................
	function getDESIGNATION($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_designation WHERE DesStat = 'A'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

	#	Function to get selected Designations ..........................
	function getSELECTEDDESIGNATION($str_dbconnect,$strDesCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_designation WHERE DesCode = '$strDesCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

    function getSELECTEDDESIGNATIONNAME($str_dbconnect,$strDesCode) {

        $Designation    =   "";

		$_SelectQuery 	= 	"SELECT * FROM tbl_designation WHERE DesCode = '$strDesCode'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $Designation   =   $_myrowRes['Designation'];
        }

		return $Designation ;

	}

	#	Function to Update Designations to the database Server .........
	function updateDESIGNATION($str_dbconnect,$strDesCode, $strDesignation, $strTask) {

		$_SelectQuery 	= 	"UPDATE tbl_designation SET `Designation` = '$strDesignation', `Task` = '$strTask' WHERE `DesCode` = '$strDesCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	#	Function to Delete Designations from the database Server .........
	function deleteDESIGNATION($str_dbconnect,$strDesCode) {

		$_SelectQuery 	= 	"UPDATE tbl_designation SET `DesStat` = 'D' WHERE `DesCode` = '$strDesCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

    function getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_EmpCode) {

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_EmpName   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName   =   $_myrowRes['FirstName']. " " .$_myrowRes['LastName'];
        }

        return $_EmpName ;

    }

    function getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$_EmpCode) {

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_EmpName   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName   =   $_myrowRes['FirstName'];
        }

        return $_EmpName ;

    }

    function getUSER_Name($str_dbconnect,$User_ID) {

		$UserName		=	"";

		$_SelectQuery 	= 	"SELECT * FROM tbl_sysusers WHERE Id = '$User_ID'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$UserName	=	$_myrowRes['User_name'];
		}

		return $UserName ;

	}

	function getUSERFACILITIES($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_facusers WHERE FacCode = '$_FacCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}

	function getUSERSBYFAC($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpCode NOT IN (SELECT EmpCode FROM tbl_facusers WHERE FacCode = '$_FacCode')" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}

	function createFacility($str_dbconnect,$FacCode, $Id ) {

        $_UserName	=getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$Id);

		$_SelectQuery 	= 	"INSERT INTO tbl_facusers (`FacCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$FacCode', '$Id', '$_UserName', 'A')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	function deleteFacility($str_dbconnect,$FacCode, $Id ) {

		$_SelectQuery 	= 	"DELETE FROM tbl_facusers WHERE FacCode = '$FacCode' AND  EmpCode = '$Id' " or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

    function getTEAMEMPLOYEEDETAILS($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND EmpCode IN (SELECT EmpCode FROM tbl_facusers WHERE FacCode = '$_FacCode')" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

    /* ***********************************************************************         */

    function getMailUSERFACILITIES($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_promails WHERE proCode = '$_FacCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}

	function getMailUSERSBYFAC($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpCode NOT IN (SELECT EmpCode FROM tbl_promails WHERE proCode = '$_FacCode')" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}

	function createMailFacility($str_dbconnect,$FacCode, $Id ) {

        $_UserName	= getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$Id);

		$_SelectQuery 	= 	"INSERT INTO tbl_promails (`proCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$FacCode', '$Id', '$_UserName', 'A')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	function deleteMailFacility($str_dbconnect,$FacCode, $Id ) {

		$_SelectQuery 	= 	"DELETE FROM tbl_promails WHERE proCode = '$FacCode' AND  EmpCode = '$Id' " or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

    function getMailTEAMEMPLOYEEDETAILS($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND EmpCode IN (SELECT EmpCode FROM tbl_promails WHERE proCode = '$_FacCode')" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

    /* ------------------- TASK OWNER UPDATING PART ------------------------------- */

    function getTASKUSERFACILITIES($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_taskowners WHERE TaskCode = '$_FacCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}


	function getTASKUSERSBYFAC($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpCode NOT IN (SELECT EmpCode FROM tbl_taskowners WHERE TaskCode = '$_FacCode') order by FirstName" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}

	function createTASKFacility($str_dbconnect,$FacCode, $Id ) {

        $_UserName	= getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$Id);
		$date = date("Y/m/d");
		$_SelectQuery 	= 	"INSERT INTO tbl_taskowners (`TaskCode`, `EmpCode`, `UserName`, `GrpCode`, `CreatedDate`) VALUES ('$FacCode', '$Id', '$_UserName', 'A', '$date')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	function deleteTASKFacility($str_dbconnect,$FacCode, $Id ) {

		$_SelectQuery 	= 	"DELETE FROM tbl_taskowners WHERE TaskCode = '$FacCode' AND  EmpCode = '$Id' " or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

    function getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND EmpCode IN (SELECT EmpCode FROM tbl_taskowners WHERE TaskCode = '$_FacCode')" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

    function UpdateTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_FacCode, $TaskCode) {

		$_SelectQuery 	= 	"UPDATE tbl_taskowners  SET TaskCode = '$TaskCode' WHERE TaskCode = '$_FacCode'" or die(mysqli_error($str_dbconnect));
		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

	}


    function getEMPMAILviaUSerCode($str_dbconnect,$strUsers) {

        $_EmpCode       =   "";
		$_SelectQuery 	= 	"SELECT * FROM tbl_sysusers WHERE `Id` = '$strUsers'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpCode    =	$_myrowRes['EmpCode'];
        }

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_MailAdd   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_MailAdd    =   $_myrowRes['EMail'];
        }

        return $_MailAdd ;

	}


    /* ------------------------------ END ------------------------------- */
	
	
	
	/*.................................. Thilina 10-03-2014 - Createthis for designation functions .........................  */

function getSelectedDesignationDetails($str_dbconnect,$_DesignationCode) {

    $_SelectQuery 	=   "SELECT * FROM tbl_designation WHERE `DesId` = '$_DesignationCode' AND DesStat = 'A'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
    return $_ResultSet ;

}

function getAllDesignationDetails($str_dbconnect) {

    $_SelectQuery 	=   "SELECT * FROM tbl_designation WHERE DesStat = 'A' ORDER BY DesId " or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
    return $_ResultSet ;

}

function AddDesignationDetails($str_dbconnect,$Descode, $Designation, $Description) {

    $_SelectQuery 	=   "INSERT INTO tbl_designation (`DesCode`, `Designation`, `Task`, `DesStat`) VALUES ('$Descode', '$Designation', '$Description', 'A')" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
    return $_ResultSet ;

}

function UpdateDesignationDetails($str_dbconnect,$Descode, $Designation, $Description) {

    $_SelectQuery 	=  "UPDATE tbl_designation SET `Designation` = '$Designation', `Task` = '$Description' WHERE `DesCode` = '$Descode'"  or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
    return $_ResultSet ;

}

function DeleteDesignationDetails($str_dbconnect,$Descode) {
	
    $_SelectQuery 	=  "UPDATE tbl_designation SET `DesStat` = 'I' WHERE `DesCode` = '$Descode'"  or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
    return $_ResultSet ;

}

function getNextDesignationCode($str_dbconnect) {

    $_SelectQuery 	=   "SELECT MAX(DesId) AS MaxDesId FROM tbl_designation " or die(mysqli_error($str_dbconnect));
    $_ResultSet_Max 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
	$maxDesId="";
	
	while($_myrowRes1 = mysqli_fetch_array($_ResultSet_Max)) {
		$maxDesId    =   $_myrowRes1['MaxDesId'];				
	}
	
	$_SelectQuery 	=   "SELECT * FROM tbl_designation WHERE DesId = '$maxDesId' " or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
	$DesCode="";
	$NewDesCode="";
	
	while($_myrowRes2 = mysqli_fetch_array($_ResultSet)) {
		$DesCode    =   $_myrowRes2['DesCode'];				
	}
		
	$NewDesCode = substr($DesCode,3);
	$NewDesCode = $NewDesCode+1;
	$NewDesCode = "DES".$NewDesCode;
    return $NewDesCode ;

}


/* ......................................................................................................................................................................*/





/*......................................  Getting Email Addreses to send all reports .............Done by thilina on 2014-06-24 As per the Change request.............. */
function get_AllReportRecipients($str_dbconnect) {
 
    $_SelectQuery   =   "";    
   
            $_SelectQuery   = 	"SELECT Email_Address FROM all_report_recipient" or die(mysqli_error($str_dbconnect));
			    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    return $_ResultSet;
} 


/*...................................... End of  Getting Email Addreses to send all reports ............................................................................ */




	
?>