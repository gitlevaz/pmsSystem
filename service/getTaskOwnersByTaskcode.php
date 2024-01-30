
<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php"); 
  
 $Taskcode = $_GET["Taskcode"];
 $query = "SELECT UserName FROM tbl_taskowners WHERE TaskCode='$Taskcode'";        
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $rows = array();
 while($r = mysqli_fetch_assoc($Result))
   {
    $rows[] = $r;
   }
 echo json_encode($rows);
?>