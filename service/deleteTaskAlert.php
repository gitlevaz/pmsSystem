<?php
//$connection = include_once('../connection/sqlconnection.php');
// $connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 
   $TaskCode = $_GET["TaskCode"];
  
   
       $DeteleTaskAlert="DELETE FROM tbl_taskalert WHERE TaskCode='$TaskCode'";
	   $values=mysqli_query($link,$DeteleTaskAlert) or die(mysqli_error($link));
  
	   echo $values;
   	  
?>