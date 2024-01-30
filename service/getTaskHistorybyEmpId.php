<?php


//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php");
 $query = "SELECT taskcode, category, Note, UpdateDate FROM tbl_taskupdates WHERE taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."') ORDER BY UpdateDate desc";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 
 $rows = array();
while($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
}
   echo json_encode($rows);
   
  
?>