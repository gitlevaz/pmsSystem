<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sql_crtgroups
 *
 * @author Prajapriya
 */

function createGROUP($str_dbconnect,$strGrpCode, $strGroup, $strTask) {

		$_SelectQuery 	= 	"INSERT INTO tbl_accessgroups (`GrpCode`, `Group`, `Task`, `GrpStat`) VALUES ('$strGrpCode', '$strGroup', '$strTask', 'A')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	#	Function to get All Designations ..........................
	function getGROUP($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_accessgroups WHERE GrpStat = 'A'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

	#	Function to get selected Designations ..........................
	function getSELECTEDGROUP($str_dbconnect,$strGrpCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_accessgroups WHERE GrpCode = '$strGrpCode' AND GrpStat = 'A'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

	#	Function to Update Designations to the database Server .........
	function updateGROUP($str_dbconnect,$strGrpCode, $strGroup, $strTask) {

		$_SelectQuery 	= 	"UPDATE tbl_accessgroups SET `Group` = '$strGroup', `Task` = '$strTask' WHERE `GrpCode` = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	#	Function to Delete Designations from the database Server .........
	function deleteGROUP($str_dbconnect,$strGrpCode) {

		$_SelectQuery 	= 	"UPDATE tbl_accessgroups SET `GrpStat` = 'D' WHERE `GrpCode` = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

	#	Function to get User Group and Return Group Decription ..........................
	function getGROUPNAME($str_dbconnect,$strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_accessgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}



?>
