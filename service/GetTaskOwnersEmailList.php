<?php

$connection = include_once('../connection/mobilesqlconnection.php');

$proCode = $_GET["ProCode"];

$_SelectQuery = "SELECT distinct(SELECT distinct email from tbl_employee WHERE EmpCode = tow.EmpCode) AS 'TaskOwnerEmai' from tbl_task task
				INNER JOIN tbl_taskOwners tow ON task.TaskCode = tow.TaskCode
				WHERE task.procode = '$proCode'";

$_ResultSet = mysqli_query($link,$_SelectQuery) or die (mysqli_error($link));
$taskList = array ();

while($_myrowRes = mysqli_fetch_assoc($_ResultSet))
{
    $taskList [] = $_myrowRes;
}

echo json_encode($taskList);

?>