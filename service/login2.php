
<?php 

   
  $connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  
  include ('../class/accesscontrole.php');
  
  $str_Database   =   "cispmsmobile";       //  Database Name

 mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
    
 // $Username=$_POST['UserName'];
 // $Password=$_POST['Password'];
  $intRESULT = USER_Login($str_dbconnect,$_GET["UserName"], $_GET["Password"]);
  
  echo json_encode($intRESULT);

?>