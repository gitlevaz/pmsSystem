
<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
 include ("../class/accesscontrole.php");
 $array = array();

$query = "SELECT `id`,	`compcode`,	`procode` ,	`proname` ,	DATE_FORMAT(`startdate`,'%m-%d-%Y') as startDate ,	`crtusercode` ,	`crtdate` ,	`prostatus`  ,	DATE_FORMAT(`EndDate`,'%m-%d-%Y') endDate ,	`Department`,	`Division` ,(select  CONCAT_WS(' ', FirstName, LastName) as projectInitiator from tbl_employee where EmpCode = ProInit) as projectInitiator ,	`SecOwner`,	`Support` ,	`OrderByNum` ,	`Rate`,	`ProOwner` FROM tbl_projects WHERE procode in (SELECT `procode` FROM tbl_task WHERE    taskcode IN(SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')) ";
$Result=mysqli_query($link,$query) or die(mysqli_error($link));
$row=mysqli_fetch_assoc($Result);
array_push($array, $row);
echo json_encode($array);
 

?>