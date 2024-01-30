<?php
/*
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
*/
function encode5t3($str)
{
    for($i=0; $i<5;$i++)
    {
        $str=strrev(base64_encode($str)); //apply base64 first and then reverse the string
    }
    return $str;
}

//  Password Decryption

function decode5t3($str)
{
    for($i=0; $i<5;$i++)
    {
        $str=base64_decode(strrev($str)); //apply base64 first and then reverse the string}
    }
    return $str;
}

#   TO MAKE SERIAL
function get_SerialUsers($str_dbconnect,$str_Serial, $str_Description) {

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

#	Function to Create Agent Details to the database Server .........
	function createSYSUSER($str_dbconnect,$_UserName, $_UserPsw, $_EmpCode, $_PswdExp, $_ExpInDays, $_UserGroup, $_UserStat) {
		
		$_CreateDate	= date("Y/m/d") ;
		$_UpdateDate	= date("Y/m/d") ;

                $_CompCode      =   $_SESSION["CompCode"];
                $_UserCode      =   get_SerialUsers($str_dbconnect,"1004", "USER CODE");
                $_User          =   "USR/".$_UserCode;

		$_UserPsw	= 	encode5t3($_UserPsw);

		$_SelectQuery 	= 	"INSERT INTO tbl_sysusers (`Id`, `User_name`, `User_password`, `EmpCode`, `PswdExp`, `ExpInDays`, `UserGroup`, `CreateDate`, `UpdateDate`, `UserStat`) VALUES ('$_User', '$_UserName', '$_UserPsw', '$_EmpCode', '$_PswdExp', '$_ExpInDays', '$_UserGroup', '$_CreateDate', '$_UpdateDate', '$_UserStat')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
	}


	function createSYSUSERWIthCreatedBy($str_dbconnect,$_UserName, $_UserPsw, $_EmpCode, $_PswdExp, $_ExpInDays, $_UserGroup, $_UserStat, $created_by) {
   
		$_CreateDate	= date("Y/m/d") ;
		$_UpdateDate	= date("Y/m/d") ;

                $_CompCode      =   $_SESSION["CompCode"];
                $_UserCode      =   get_SerialUsers($str_dbconnect,"1004", "USER CODE");
                $_User          =   "USR/".$_UserCode;

		$_UserPsw	= 	encode5t3($_UserPsw);

		$_SelectQuery 	= 	"INSERT INTO tbl_sysusers (`Id`, `User_name`, `User_password`, `EmpCode`, `PswdExp`, `ExpInDays`, `UserGroup`, `CreateDate`, `UpdateDate`, `UserStat`, `created_by`) VALUES ('$_User', '$_UserName', '$_UserPsw', '$_EmpCode', '$_PswdExp', '$_ExpInDays', '$_UserGroup', '$_CreateDate', '$_UpdateDate', '$_UserStat', '$created_by')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
	}

	#	Function to Update Agent Details to the database Server .........
	function updateSYSUSER($str_dbconnect,$_UserCode,$_UserName, $_UserPsw, $_EmpCode, $_PswdExp, $_ExpInDays, $_UserGroup, $_UserStat) {

		$_UpdateDate	= date("Y/m/d") ;

		$_UserPsw	= 	encode5t3($_UserPsw);

		$_SelectQuery 	= 	"UPDATE tbl_sysusers SET `User_name` = '$_UserName', `User_password` = '$_UserPsw', `EmpCode` = '$_EmpCode', `PswdExp` = '$_PswdExp', `ExpInDays` = '$_ExpInDays', `UserGroup` = '$_UserGroup', `UpdateDate` = '$_UpdateDate', `UserStat` = '$_UserStat' WHERE `Id` = '$_UserCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

    function updateSYSUSERWithoutPW($str_dbconnect,$_UserCode,$_UserName, $_EmpCode, $_PswdExp, $_ExpInDays, $_UserGroup, $_UserStat) {

		$_UpdateDate	= date("Y/m/d") ;

		$_SelectQuery 	= 	"UPDATE tbl_sysusers SET `User_name` = '$_UserName', `EmpCode` = '$_EmpCode', `PswdExp` = '$_PswdExp', `ExpInDays` = '$_ExpInDays', `UserGroup` = '$_UserGroup', `UpdateDate` = '$_UpdateDate', `UserStat` = '$_UserStat' WHERE `Id` = '$_UserCode'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}
    
	#	Function to get All Agent Details ..........................
	function getSYSUSERDETAILS($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_sysusers WHERE UserStat = 'A'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

	#	Function to get All Agent Details ..........................
	function getALLSYSUSERDETAILS($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_sysusers" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

	#	Function to get selected Agent ..........................
	function getSELECTEDSYSUSER($str_dbconnect,$strUsers) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_sysusers WHERE `Id` = '$strUsers'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}

	#	Function to Delete Agent Details from the database Server .........
	function deleteSYSUSER($str_dbconnect,$strUsers) {

		$_SelectQuery 	= 	"UPDATE tbl_sysusers SET `UserStat` = 'I' WHERE `Id` = '$strUsers'" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	}

#	Function to get selected Agent ..........................
	function getSELECTEDSYSUSERNAME($str_dbconnect,$strUsers) {

        $_UserName   =   "";
		$_SelectQuery 	= 	"SELECT * FROM tbl_sysusers WHERE `Id` = '$strUsers'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_UserName    =	$_myrowRes['User_name'];
        }

		return $_UserName ;

	}


?>