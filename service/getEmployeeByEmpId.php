
<?php

// $connection = include_once('../connection/sqlconnection.php');
// $connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 include ("../class/accesscontrole.php");
 $array = array();
 

   $query = "select * from tbl_employee where EmpCode= '".$_GET["EmpCode"]."' ";
	  
        
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 array_push($array, $row);
 echo json_encode($array);
?>