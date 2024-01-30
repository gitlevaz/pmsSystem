<?php 
/*   include('../connection/sqlconnection.php');
  include('../class/accesscontrole.php');
  
 // $Username=$_POST['UserName'];
 // $Password=$_POST['Password'];
  $intRESULT = getUSER_ACCESS($str_dbconnect,$_GET['UserName'], $_GET['Password']);
if ($intRESULT > 0)
{
echo json_encode($intRESULT);
}
else
{
echo 'false';
} */
   /*  header("Access-Control-Allow-Origin: *"); */
 // $conn = include_once('../connection/connection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php");
  
 // $Username=$_POST['UserName'];
 // $Password=$_POST['Password'];
  $intRESULT = getUSER_ACCESS($str_dbconnect,$conn,$_GET["UserName"], $_GET["Password"]);
 // return $intRESULT;
   echo json_encode($intRESULT);
//echo '$intRESULT';

?>
