<?php

 /*  header("Access-Control-Allow-Origin: *"); */
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("class/accesscontrole.php");
  
 // $Username=$_POST['UserName'];
 // $Password=$_POST['Password'];
  $intRESULT = getUSER_ACCESS($str_dbconnect,$conn,$_GET["UserName"], $_GET["Password"]);
 // return $intRESULT;
   echo json_encode($intRESULT);
 
   //echo ' <br/>Password :   '.$Password;
  /*$query="SELECT * FROM tbl_sysusers WHERE User_name ='".$Username."' AND User_password='".$Password."' ";
  
  $Result=mysqli_query($str_dbconnect, $conn,$query) or die('Error: ' .mysqli_error($str_dbconnect $conn));
  
  
  
  $row=mysqli_fetch_assoc($Result);
  $totalRows=mysqli_num_rows($Result);
   
  if($totalRows>0)
  {
	 
   echo "true";
  }
  else
  {
    echo "false";
  }
*/
?>
