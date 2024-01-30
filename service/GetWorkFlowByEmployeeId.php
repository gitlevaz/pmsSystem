<?php
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
include ("../class/accesscontrole.php");

//echo $today_date;
//$WorkFlowTypeCode = $_GET["WorkFlowTypeCode"];
$EmpId = $_GET["EmpId"];
$selectedprvDate = $_GET["selectedDate"];

$timezone = "Asia/Colombo";	
date_default_timezone_set($timezone);

if($selectedprvDate != "") 
{
 $today_date  = $selectedprvDate;
}
else{
	$today_date  = date("Y-m-d");
}



/* if( $WorkFlowTypeCode == "USRWF")  
 {
	 $query = "SELECT *,'USRWF' as wftypecode FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'EMP%' order by `start_time`"; 
 }	
 else  if( $WorkFlowTypeCode == "REDO")  
 {
	 $query = "SELECT *,'REDO' as wftypecode FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'RE%' order by `start_time`"; 
 }
 else if( $WorkFlowTypeCode == "CWK")  
 {
	 $query = "SELECT *,'CWK' as wftypecode FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'CWK%' order by `start_time`"; 
 }
 else 
 {	
	 WF
	  $query = "SELECT *,'WF' as wftypecode FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` not like 'EMP%' AND `wk_id` not like 'RD%' AND `wk_id` not like 'CWK%' order by `start_time`"; 
 }
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $rows = array();
	while($r = mysqli_fetch_assoc($Result)) 
	{
		$rows[] = $r;
	}
 echo json_encode($rows); */
 


 //$query = "SELECT *,wfu.status as workflowstatus,'USRWF' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'EMP%'  UNION SELECT *,wfu.status as workflowstatus,'REDO' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'RE%'  UNION SELECT *,wfu.status as workflowstatus,'CWK' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'CWK%'  UNION SELECT *,wfu.status as workflowstatus,'WF' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` not like 'EMP%' AND `wk_id` not like 'RD%' AND `wk_id` not like 'CWK%' order by `start_time`";
$query = "SELECT *,(select  CONCAT_WS(' ', FirstName, LastName) as TaskOf from tbl_employee where EmpCode = wfu.wk_id) as TaskOf, wfu.status as workflowstatus,'USRWF' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'EMP%' UNION SELECT *,wfu.wk_id as TaskOf, wfu.status as workflowstatus,'REDO' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'RE%' UNION SELECT *,wfu.wk_id as TaskOf,wfu.status as workflowstatus,'CWK' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` like 'CWK%' UNION SELECT *,wfu.wk_id as TaskOf,wfu.status as workflowstatus,'WF' as wftypecode ,wfc.Icon FROM tbl_workflowupdate  wfu inner join wfcategory wfc on  wfu.catcode=wfc.catcode WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EmpId' AND `wk_id` not like 'EMP%' AND `wk_id` not like 'RD%' AND `wk_id` not like 'CWK%' order by `start_time`, `end_time`";
 
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $rows = array();
	while($r = mysqli_fetch_assoc($Result)) 
	{
		$rows[] = $r;
	}
 

 
echo json_encode($rows);
   
  
?>

