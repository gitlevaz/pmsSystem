<?php
 // $connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php"); 
 
  
    $Id = $_GET["Id"];
	

		  
         $Detele="DELETE FROM tbl_PushNotificationMessage WHERE messageId='$Id'";
	     $values=mysqli_query($link,$Detele) or die(mysqli_error($link));
		 echo $values;
	
	
	  
?>