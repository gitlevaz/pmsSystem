
<?php 

$conn = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php");

 $intRESULT = USER_Login($str_dbconnect,$conn,$_GET["UserName"], $_GET["Password"]);
 if($intRESULT != "-")
 {	 	 
	InsertApplicationLog($str_dbconnect,$conn,'login' , null , $intRESULT);
	
 }
   echo $intRESULT;
 

?>