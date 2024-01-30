<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$workflowCode = $_GET["workflowCode"];

if($workflowCode != null)
{
	
	$selectQuery = "SELECT crt_by,report_owner,wk_id,wk_Owner FROM tbl_workflow WHERE wk_id='$workflowCode'";
	
	$result = mysqli_query($link, $selectQuery) or die(mysqli_error($link));
	$row = mysqli_fetch_assoc($result);
		
	$wfId = $row["wk_id"];
	$crtBy = $row["crt_by"];
	$rptOwner = $row["report_owner"];
	$wkOwner = $row["wk_Owner"]; 
			
	$query = "SELECT 'Creator'  as Type , ProCode, ParaCode, FileName, SystemName FROM prodocumets WHERE ParaCode='$wfId' AND CreatBy='$crtBy' 
	 Union SELECT 'Supervisor'  as Type ,ProCode , ParaCode , FileName , SystemName FROM workflowattachments WHERE ParaCode='$wfId' AND CreatBy='$rptOwner'
	 Union SELECT 'User' as Type , ProCode , ParaCode , FileName , SystemName  FROM workflowattachments WHERE ParaCode='$wfId' AND CreatBy='$wkOwner'";

	$docResult = mysqli_query($link,$query) or die(mysqli_error($link));	
		
	$rows = array();
	while ($r = mysqli_fetch_assoc($docResult)) {
		$rows[] = $r;
	}

	echo json_encode($rows); 

}




 

?>