
<?php

//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 include ("../class/accesscontrole.php");
 $array = array();

   $query = "SELECT  compcode, procode, taskcode, parent, sublevel, taskname, TaskDetails, DATE_FORMAT(taskcrtdate,'%m-%d-%Y'),DATE_FORMAT(taskenddate,'%m-%d-%Y') , AllHours, assignuser, Priority, taskstatus, (select  CONCAT_WS(' ', FirstName, LastName) as AssignBy from tbl_employee where EmpCode = AssignBy) as AssignBy , Precentage, MailCCTo FROM tbl_task WHERE  taskcode = '".$_GET["TaskId"]."'";
           
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 array_push($array, $row);
 echo json_encode($array);
?>