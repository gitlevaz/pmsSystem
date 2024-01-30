<?php


//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
include("../class/accesscontrole.php");

$query = "SELECT 		`procode` ,	`proname` ,	DATE_FORMAT(`startdate`,'%m-%d-%Y') as startDate ,		`prostatus`  ,	DATE_FORMAT(`EndDate`,'%m-%d-%Y') endDate ,(select  CONCAT_WS(' ', FirstName, LastName) as projectInitiator from tbl_employee where EmpCode = ProInit) as projectInitiator  FROM tbl_projects WHERE procode in (SELECT `procode` FROM tbl_task WHERE    taskcode IN(SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')) ";
$Result = mysqli_query($link, $query) or die(mysqli_error($link));
$rows = array();
while ($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
}
echo json_encode($rows);


?>
