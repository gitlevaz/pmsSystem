<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php"); 
 
    $Message = $_GET["Message"];
    $EmpCode = $_GET["EmpCode"];
	 $Title = $_GET["Title"];
	 	 
			$InsertFirstTime = "INSERT INTO tbl_PushNotificationMessage(EmpCode, Message ,Category,Title) VALUES ('$EmpCode', '$Message','Update Notification','$Title')";               
			$result=mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
			echo $result;
	
	  
?>