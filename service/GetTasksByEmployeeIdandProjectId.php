<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
 include ("../class/accesscontrole.php");
//$query = "SELECT  `compcode`, `procode`, `taskcode`, `parent`, `sublevel`, `taskname`, `TaskDetails`, 	DATE_FORMAT(`taskcrtdate`,'%m-%d-%Y'), 	DATE_FORMAT(`taskenddate`,'%m-%d-%Y'), `AllHours`, `assignuser`, `Priority`, `taskstatus`, `AssignBy`, `Precentage`, `MailCCTo` FROM tbl_task WHERE  procode = '". $_GET["ProId"] ."'  AND  taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '" . $_GET["EmpId"] . "') ";
//$query="SELECT DISTINCT compcode, procode, tsk.taskcode, parent, sublevel, taskname, TaskDetails, DATE_FORMAT(taskcrtdate,'%m-%d-%Y') as taskStartDate, DATE_FORMAT(taskenddate,'%m-%d-%Y') as taskEnddate, AllHours, assignuser, Priority, taskstatus, AssignBy, Precentage, MailCCTo, SEC_TO_TIME( SUM( TIME_TO_SEC(TotHors))) as TotHors,((CAST( AllHours AS UNSIGNED)*3600) - ((CAST(  SUBSTRING_INDEX(TotHors, ':', 1) AS UNSIGNED) * 3600) + (CAST(  SUBSTRING_INDEX(TotHors, ':', 2) AS UNSIGNED) * 60) + (CAST(  SUBSTRING_INDEX(TotHors, ':', 3) AS UNSIGNED)))) as remainingHours FROM tbl_task tsk inner join tbl_taskupdates tskupdt on tsk.taskcode= tskupdt.taskcode WHERE procode = '". $_GET["ProId"] ."' AND tsk.taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '" . $_GET["EmpId"] . "') group by tsk.taskcode LIMIT 60";
$query="SELECT DISTINCT compcode, procode, tsk.taskcode,parent,sublevel, taskname, TaskDetails, DATE_FORMAT(taskcrtdate,'%m-%d-%Y') as taskStartDate,DATE_FORMAT(taskenddate,'%m-%d-%Y') as taskEnddate, AllHours, assignuser, Priority, taskstatus, AssignBy, Precentage, MailCCTo, SEC_TO_TIME( SUM( TIME_TO_SEC(TotHors))) as TotHors FROM tbl_task tsk left join tbl_taskupdates tskupdt on tsk.taskcode= tskupdt.taskcode WHERE procode = '". $_GET["ProId"] ."' AND tsk.taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '" . $_GET["EmpId"] . "') group by tsk.taskcode";
$Result = mysqli_query($link, $query) or die(mysqli_error($link));

$rows = array();
while ($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
}
echo json_encode($rows);


?>

