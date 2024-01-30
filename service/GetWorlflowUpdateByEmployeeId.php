<?php

	//$connection = include_once('../connection/connection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
include("../class/accesscontrole.php");

$today_date  = date("Y-m-d");

$query = "SELECT * FROM   tbl_workflowupdate WHERE `wk_owner`='".$_GET["EmpId"]."' AND crt_date = '$today_date'" ;

$result = mysqli_query($link, $query) or die(mysqli_error($link));

$rows = array();

while($r = mysqli_fetch_assoc($result))
{
	$rows[] = $r;
}

echo json_encode($rows);


?>