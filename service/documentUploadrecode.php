
				<?php
//$connection = include_once('../connection/sqlconnection.php');
// $connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 
  
	   $InsertFirstTime = "insert into `prodocumets` ( `ProCode`,  `ParaCode`, `FileName`,  `SystemName`,  `CreatBy`,  `CreatDate`)  values( '".$_GET["ProCode"]."','".$_GET["taskcode"]."','".$_GET["FileName"]."','".$_GET["SystemName"]."','".$_GET["CreatBy"]."','".Date("Y-m-d H:m:s")."')";
               
	   $result=mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
	   
	   echo $result;
   
	  
?>