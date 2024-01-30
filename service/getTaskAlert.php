<?php
//$connection = include_once('../connection/sqlconnection.php');
 //$connection = include_once('../connection/previewconnection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
  $TaskCode = $_GET["TaskCode"];
  $query = "SELECT Email FROM tbl_taskalert WHERE TaskCode='$TaskCode'";
  $Result=mysqli_query($link,$query) or die(mysqli_error($link));
  $rows = array();
   while($r = mysqli_fetch_assoc($Result))
   {
    $rows[] = $r;
   }
   echo json_encode($rows);
   
   
   
   
	  
?>