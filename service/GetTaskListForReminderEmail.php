<?php

$connection = include_once('../connection/mobilesqlconnection.php');

$proCode = $_GET["ProCode"];

$_SelectQuery = "SELECT distinct task.taskCode,task.taskName AS 'taskName',task.taskEndDate AS 'TaskEndDate',
				(SELECT concat_ws(' ',FirstName,LastName) from tbl_employee WHERE Empcode = tow.EmpCode) AS 'TaskOwnerName',
				(SELECT email from tbl_employee WHERE Empcode = tow.EmpCode) AS 'TaskOwnerEmail' FROM tbl_task task 
					JOIN tbl_taskOwners tow ON task.TaskCode = tow.TaskCode WHERE task.procode = '$proCode'";

$_ResultSet = mysqli_query($link,$_SelectQuery) or die (mysqli_error($link));
$taskList = array ();

while($_myrowRes = mysqli_fetch_assoc($_ResultSet))
{
    $taskList [] = $_myrowRes;
}

echo json_encode($taskList);

?>