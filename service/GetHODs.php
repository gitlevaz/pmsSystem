<?php

$connection = include_once('../connection/mobilesqlconnection.php');

$proCode = $_GET["ProCode"];

$_SelectQuery = "SELECT distinct EMail from tbl_employee emp inner join tbl_promails Pro ON emp.EmpCode = Pro.EmpCode
				Inner Join tbl_projects Proj ON Pro.proCode = Proj.Department
				WHERE Proj.procode = '$proCode'";

$_ResultSet = mysqli_query($link,$_SelectQuery) or die (mysqli_error($link));
$taskList = array ();

while($_myrowRes = mysqli_fetch_assoc($_ResultSet))
{
    $taskList [] = $_myrowRes;
}

echo json_encode($taskList);

?>