
<?php

//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 include ("../class/accesscontrole.php");
 $array = array();

 $query = "SELECT  taskcode FROM tbl_taskupdates WHERE  taskcode = '".$_GET["TaskId"]."' ";    
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 

  
 if($row<1)
 {
 	    $query = "SELECT  compcode, procode, taskcode, parent, sublevel, taskname, TaskDetails, DATE_FORMAT(taskcrtdate,'%m-%d-%Y') as TaskStartDate,DATE_FORMAT(taskenddate,'%m-%d-%Y') as TaskEnddate , AllHours, assignuser, Priority, tbl_task.taskstatus, (select  Status  from  tbl_systemstatus where StatusCode = tbl_task.taskstatus) as Status , (select  CONCAT_WS(' ', FirstName, LastName) as AssignBy from tbl_employee where EmpCode = AssignBy) as AssignBy , Precentage, MailCCTo, '00:00:00' as TotHors,  '' as  Note FROM tbl_task  WHERE  taskcode = '".$_GET["TaskId"]."'";
 	    $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 	    $row=mysqli_fetch_assoc($Result);
		  array_push($array, $row);
 echo json_encode($array);
 }
 else	{
	  $query = "SELECT  compcode, procode, tbl_task.taskcode, parent, sublevel, taskname, TaskDetails, DATE_FORMAT(taskcrtdate,'%m-%d-%Y') as TaskStartDate,DATE_FORMAT(taskenddate,'%m-%d-%Y') as TaskEnddate, AllHours, assignuser, Priority, tbl_task.taskstatus, (select  Status  from  tbl_systemstatus where StatusCode = tbl_task.taskstatus) as Status , (select  CONCAT_WS(' ', FirstName, LastName) as AssignBy from tbl_employee where EmpCode = AssignBy) as AssignBy , Precentage, MailCCTo, SEC_TO_TIME( SUM( TIME_TO_SEC(TotHors))) as TotHors, (select Note from tbl_taskupdates d where d.taskcode =tbl_task.taskcode order by  d.updatedate desc,d.spentto desc limit 1) as  Note FROM tbl_task ,tbl_taskupdates WHERE  tbl_task.taskcode = '".$_GET["TaskId"]."' and  tbl_taskupdates.taskcode=tbl_task.taskcode";
         
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
   array_push($array, $row);
 echo json_encode($array);
 }

?>