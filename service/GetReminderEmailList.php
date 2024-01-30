<?php

$connection = include_once('../connection/mobilesqlconnection.php');

$date = $_GET["MailDate"];

$_SelectQuery = "SELECT project.ProCode,project.EndDate AS 'ProjEndDate',project.Proname 
				as 	'ProjName',(SELECT concat_ws(' ',FirstName,LastName) from tbl_employee WHERE EmpCode = project.ProOwner) AS 'ProjOwnerName',
				(SELECT email from tbl_employee WHERE Empcode = project.ProOwner) AS 'ProjOwnerEmail' 
				FROM tbl_projects project WHERE project.EndDate = '$date'";

$_ResultSet = mysqli_query($link,$_SelectQuery) or die (mysqli_error($link));
$taskList = array ();

while($_myrowRes = mysqli_fetch_assoc($_ResultSet))
{
    $taskList [] = $_myrowRes;
}

echo json_encode($taskList);

?>
