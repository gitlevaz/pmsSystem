<?php
//$connection = include_once('../connection/sqlconnection.php');
 //$connection = include_once('../connection/previewconnection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php"); 
 
   $EmpCode = $_GET["EmpCode"];
   $DeviceId=$_GET["DeviceId"];
  
   
       $DeteleTaskAlert="DELETE FROM tbl_pushnotificationdevice WHERE DeviceId='$DeviceId' and EmployeeId='$EmpCode'";
	   $values=mysqli_query($link,$DeteleTaskAlert) or die(mysqli_error($link));
  
	   echo $values;
   	  
?>