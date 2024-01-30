<?php

//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');


function get_TempSerial($str_dbconnect,$str_Serial, $str_Description) 
{
    global $connection;
        $_CompCode      =	"CIS";
        $_Serial_Val    =	-1;

        $_SelectQuery   = "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '$str_Serial'";
        $_ResultSet     = mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            $_Serial_Val	=   $_myrowRes['Serial'];
        }

        if($_Serial_Val == -1)
        {
            $_SelectQuery 	=   "INSERT INTO tbl_serials (`CompCode`, `Code`, `Serial`, `Desription`) VALUES ('$_CompCode', '$str_Serial', '0', '$str_Description')";
            $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

            $_SelectQuery 	= "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '$str_Serial'";
            $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
            $Result1 = mysqli_num_rows($_ResultSet);
		
            while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		    {
                $_Serial_Val    =	$_myrowRes['Serial'];
            }

        }

        $_Serial_Val = $_Serial_Val + 1;

        $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '$str_Serial'";
        $udateStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

        return $_Serial_Val;

    }

function create_FileName($link)
{

        $Str_UPLCode    = 	get_TempSerial($str_dbconnect,"1020", "PROJECT TEMPORARY CODE UPLOAD");
        $Str_UPLCode    = 	"UPL-".$Str_UPLCode;

        return $Str_UPLCode;
}

    $_Serial_Val    =   -1;
    $_CompCode      =   "CIS";
                
     $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1050'";
     $_ResultSet     = mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
     $Result1 = mysqli_num_rows($_ResultSet);
		
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            $_Serial_Val	=   $_myrowRes['Serial'];
        }
                
        $_Serial_Val = $_Serial_Val + 1;

        $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1050'";
        $udateStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection)); 
                
        $Str_WKID = "TWK/" . $_Serial_Val;
                
        $NewFileCode = create_FileName($link);
        
            
        
	$array = $_Serial_Val.','. $NewFileCode;
	echo $array; 

 

?>