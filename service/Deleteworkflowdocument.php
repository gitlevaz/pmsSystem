<?php
 
//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
include ("../class/accesscontrole.php"); 
 
$SystemName = $_GET["SystemName"];
$WFCode = $_GET["WFCode"];

$SelectAttachmentQuery = "SELECT COUNT(*) FROM workflowattachments WHERE SystemName='$SystemName' AND ParaCode = '$WFCode'";

$executingQuery = mysqli_query($link, $SelectAttachmentQuery) or die(mysqli_error($link));
$toRow = mysqli_fetch_assoc($executingQuery);

$resultCount = $toRow["COUNT(*)"];

if($resultCount == 0)
{
	echo "No Attachments found to be Deleted";
}
else
{
	$DeteleQuery="DELETE FROM workflowattachments WHERE SystemName='$SystemName'";
	$ResultValue=mysqli_query($link,$DeteleQuery) or die(mysqli_error($link));
	
	if($ResultValue == 1)
	{
		$SelectAttachmentQueryNew = "SELECT COUNT(*) FROM workflowattachments WHERE SystemName='$SystemName' AND ParaCode = '$WFCode'";

		$executingQueryNew = mysqli_query($link, $SelectAttachmentQueryNew) or die(mysqli_error($link));
		$toRowNew = mysqli_fetch_assoc($executingQueryNew);

		$resultCountNew = $toRowNew["COUNT(*)"];
		
		if($resultCountNew == 0)
		{
			echo "Deleted Successfully";
		}
		else
		{
			echo "Record Not Deleted";
		}
	}
	else
	{
		echo "Error Occurred";
	}
}
	

		  

	
	
	  
?>