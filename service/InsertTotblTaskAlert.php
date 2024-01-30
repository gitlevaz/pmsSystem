<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
 
 
  //$getSerialTask =
  
   $TaskCode = $_GET["TaskCode"];
   $Email = $_GET["Email"];
   
	   $InsertFirstTime = "INSERT INTO tbl_taskalert (TaskCode, Email) VALUES ('$TaskCode', '$Email')";
               
	   $result=mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
	   
	   echo $result;
   
	  
?>