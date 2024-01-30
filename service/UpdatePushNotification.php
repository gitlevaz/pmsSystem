<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php"); 
 
  $value = $_GET["value"];
  $DeviceId = $_GET["DeviceId"];
  $EmpCode = $_GET["EmpCode"];
  echo $EmpCode; 
  $UpdateQuerry = "UPDATE tbl_pushnotificationdevice SET Active='$value' WHERE DeviceId='$DeviceId' and EmployeeId='$EmpCode'";               
  $result=mysqli_query($link,$UpdateQuerry) or die(mysqli_error($link));
  
  echo $result;	  
?>

