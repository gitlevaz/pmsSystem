
<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
 include ("../class/accesscontrole.php");
 
   $array = array();
   $LogUserCode = $_GET["LogUserCode"];
   $dateof = date("Y-m-d");
   $Wk_id = $_GET["Wk_id"];
   
   $query = "SELECT * FROM tbl_notifications WHERE `toUser` = '$LogUserCode' AND `WFDate` = '$dateof' AND `Wk_id` = '$Wk_id' order by `id`";	   
   $Result=mysqli_query($link,$query) or die(mysqli_error($link));
   $row=mysqli_fetch_assoc($Result);
   array_push($array, $row);
   echo json_encode($array);
?>