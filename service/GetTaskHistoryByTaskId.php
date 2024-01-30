<?php


$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');

 $query = "SELECT  taskcode,  category,  Note, UpdateDate FROM tbl_taskupdates WHERE taskcode = '".$_GET["TaskId"]."' ORDER BY UpdateDate desc ";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 
 $rows = array();
 while($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
}
   echo json_encode($rows);
   
  
?>

