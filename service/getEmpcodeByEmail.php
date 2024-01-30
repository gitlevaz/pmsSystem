
<?php
//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php"); 
 $mail = $_GET["mail"];
 $query = "SELECT EmpCode FROM tbl_employee WHERE EMail='$mail'";        
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 echo $row["EmpCode"];
?>