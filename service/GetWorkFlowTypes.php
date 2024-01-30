<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php");

 $query = "SELECT * FROM tbl_workflowtypes";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 
 $rows = array();
while($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
}
   echo json_encode($rows);
   
  
?>

