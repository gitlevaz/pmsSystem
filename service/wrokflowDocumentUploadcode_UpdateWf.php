<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');

	$InsertFirstItem = "insert into  workflowattachments (`ProCode` ,`ParaCode` ,`FileName` , `SystemName`,`CreatBy` , `CreatDate`)  values ('".$_GET["ProCode"]."','".$_GET["workFlowId"]."','".$_GET["FileName"]."','".$_GET["SystemName"]."','".$_GET["CreatBy"]."','".Date("Y-m-d H:m:s")."')";
	
	$result = mysqli_query($link,$InsertFirstItem) or die(mysqli_error($link));
	
	echo $result;
	
?>