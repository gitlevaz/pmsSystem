<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php"); 
 
  
    $TaskCode = $_GET["TaskCode"];
	

		$Selectquery = "SELECT SystemName  FROM prodocumets WHERE ParaCode='$TaskCode' order by  CreatDate  desc limit 1";
		/*SELECT  group_concat(SystemName SEPARATOR ',') as UploadFiles FROM prodocumets WHERE ParaCode='$TaskCode' order by  CreatDate  asc limit 1";  */      
		$Result=mysqli_query($link,$Selectquery) or die(mysqli_error($link));
        $rows = array();
		   while($r = mysqli_fetch_assoc($Result))
		   {
			$rows[] = $r;
		   }
           echo json_encode($rows);
		  
        
	
	
	  
?>