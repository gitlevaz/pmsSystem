<?php


$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
include("../class/accesscontrole.php");

$query = "SELECT  `compcode`, `procode`, `taskcode`, `parent`, `sublevel`, `taskname`, `TaskDetails`, 	DATE_FORMAT(`taskcrtdate`,'%m-%d-%Y'), 	DATE_FORMAT(`taskenddate`,'%m-%d-%Y'), `AllHours`, `assignuser`, `Priority`, `taskstatus`, `AssignBy`, `Precentage`, `MailCCTo` FROM tbl_task WHERE  procode = '". $_GET["ProId"] ."' AND taskstatus = '".$_GET["Status"]."' AND  taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '" . $_GET["EmpId"] . "')  LIMIT 40";
$Result = mysqli_query($link, $query) or die(mysqli_error($link));

$rows = array();
while ($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
}
echo json_encode($rows);


?>

