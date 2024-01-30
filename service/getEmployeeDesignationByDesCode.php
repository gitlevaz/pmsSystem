
<?php

 //$connection = include_once('../connection/connection.php');
 //$connection = include_once('../connection/previewconnection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
 include ("../class/accesscontrole.php");
 $array = array();
 

   $query = "select Designation from tbl_designation where DesCode= '".$_GET["DesCode"]."' ";
	  
        
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 array_push($array, $row);
 echo json_encode($array);
?>