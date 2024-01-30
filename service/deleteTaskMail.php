<?php
//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 
   $TaskCode = $_GET["TaskCode"];
 
   
       $DeteleTaskMail="DELETE FROM tbl_taskemail WHERE TaskCode='$TaskCode'";
	   $values=mysqli_query($link,$DeteleTaskMail) or die(mysqli_error($link));
  
	   echo $values;
   	  
?>