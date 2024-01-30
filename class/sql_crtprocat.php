<?php
$_SESSION["UserCode"]="";

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sql_crtgroups
 *
 * @author Prajapriya
 */

#   TO MAKE SERIAL
function get_DPTSerial($str_dbconnect,$str_Serial, $str_Description) {

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


function gettemporySerial($str_dbconnect) {
	
    $_CompCode      =   $_SESSION["CompCode"];
    $_CrtBy         =	$_SESSION["UserCode"];
    $Dte_CrtDate    = 	date("Y/m/d") ;

    $Str_ProCode    = 	get_DPTSerial($str_dbconnect,"1006", "PROJECT CATEGORY TEMPORY");
    $Str_ProCode    = 	"DPT@".$Str_ProCode;

    return $Str_ProCode;
}

    function createGROUP($str_dbconnect,$strGrpCode, $strGroup, $strTask) {

        $_CompCode      =   $_SESSION["CompCode"];
        $_CrtBy         =	$_SESSION["UserCode"];
        $Dte_CrtDate    = 	date("Y/m/d") ;

        $Str_ProCode    = 	get_DPTSerial($str_dbconnect,"1007", "PROJECT CATEGORY ORIGINAL");
        $Str_ProCode    = 	"DPT/".$Str_ProCode;

		$_SelectQuery 	= 	"INSERT INTO tbl_projectgroups (`GrpCode`, `Group`, `Country`, `GrpStat`) VALUES ('$Str_ProCode ', '$strGroup', '$strTask', 'A')" or die(mysqli_error($str_dbconnect));
		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery   = 	"UPDATE tbl_promails SET `proCode` = '$Str_ProCode' WHERE `proCode` = '$strGrpCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        Return $Str_ProCode ;
	}

	#	Function to get All Designations ..........................
	function getGROUP($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpStat = 'A'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;
	}

	#	Function to get selected Designations ..........................
	function getSELECTEDGROUP($str_dbconnect,$strGrpCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode' AND GrpStat = 'A'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;
	}

	#	Function to Update Designations to the database Server .........
	function updateGROUP($str_dbconnect,$strGrpCode, $strGroup, $strTask) {

		$_SelectQuery 	= 	"UPDATE tbl_projectgroups SET `Group` = '$strGroup', `Country` = '$strTask' WHERE `GrpCode` = '$strGrpCode'" or die(mysqli_error($str_dbconnect));
		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

	}

	#	Function to Delete Designations from the database Server .........
	function deleteGROUP($str_dbconnect,$strGrpCode) {

		$_SelectQuery 	= 	"UPDATE tbl_projectgroups SET `GrpStat` = 'D' WHERE `GrpCode` = '$strGrpCode'" or die(mysqli_error($str_dbconnect));
		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	#	Function to get User Group and Return Group Decription ..........................
	function getGROUPNAME($str_dbconnect,$strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}

    #	Function to get selected Designations ..........................
	function getSELECTEDDepartments($str_dbconnect,$strGrpCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE Country  = '$strGrpCode' AND GrpStat = 'A'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;
	}


 #	Function to get All Designations - By Thilina Rasanjana on 2014-07-14 ..........................
	function getAllDepartments($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpStat = 'A'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;
	}
?>
