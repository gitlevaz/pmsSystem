
<?php

//"select (SELECT email FROM tbl_employee WHERE `EmpCode`= T.`assignuser`) as assignuser, (SELECT email FROM tbl_employee WHERE `EmpCode`= T.`AssignBy`) as `AssignBy`,(SELECT email FROM tbl_employee WHERE `EmpCode`= `ProOwner`) as ProOwner,(SELECT email FROM tbl_employee WHERE `EmpCode`= `ProInit`) as ProInit,(SELECT email FROM tbl_employee WHERE `EmpCode`= `SecOwner`) as SecOwner,(SELECT email FROM tbl_employee WHERE `EmpCode`= `Support`) as Support from tbl_task T inner join tbl_projects P on T.procode = P.procode where taskcode = '".$_GET["TaskId"]."'";

//$connection = include_once('../connection/sqlconnection.php');
 //$connection = include_once('../connection/Liveconnection.php'); 
 $connection = include_once('../connection/mobilesqlconnection.php');

 $query = "select (SELECT email FROM tbl_employee WHERE `EmpCode`= T.`assignuser`) as assignuser, (SELECT email FROM tbl_employee WHERE `EmpCode`= T.`AssignBy`) as `AssignBy`,(SELECT email FROM tbl_employee WHERE `EmpCode`= `ProOwner`) as ProOwner,(SELECT email FROM tbl_employee WHERE `EmpCode`= `ProInit`) as ProInit,(SELECT email FROM tbl_employee WHERE `EmpCode`= `SecOwner`) as SecOwner,(SELECT email FROM tbl_employee WHERE `EmpCode`= `Support`) as Support from tbl_task T inner join tbl_projects P on T.procode = P.procode where assignuser = '".$_GET["EmployeeId"]."'";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 
 $rows = array();
 while($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
}
   echo json_encode($rows);
   
  
?>