<?php
 //$connection = include_once('../connection/sqlconnection.php');
 //$connection = include_once('../connection/previewconnection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php"); 
 
  
    $EmpCode = $_GET["EmpCode"];
	

		$Selectquery = "SELECT * FROM tbl_PushNotificationMessage WHERE EmpCode='$EmpCode'";        
		$Result=mysqli_query($link,$Selectquery) or die(mysqli_error($link));
        $rows = array();
		   while($r = mysqli_fetch_assoc($Result))
		   {
			$rows[] = $r;
		   }
           echo json_encode($rows);
		  
         /*$Detele="DELETE FROM tbl_PushNotificationMessage WHERE EmpCode='$EmpCode'";
	     $values=mysqli_query($link,$Detele) or die(mysqli_error($link));*/
	
	
	  
?>