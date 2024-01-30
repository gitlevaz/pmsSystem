<?php
//$connection = include_once('../connection/sqlconnection.php');
// $connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php");
  $query ="SELECT * FROM tbl_task ts Left join tbl_taskowners tso on ts.taskcode = tso.TaskCode WHERE tso.EmpCode='".$_GET["EmpCode"]."'";
  $Result=mysqli_query($link,$query) or die(mysqli_error($link));
  $rows = array();
   while($r = mysqli_fetch_assoc($Result))
 {
    $rows[] = $r;
   }
   echo json_encode($rows);
  
?>

