<?php
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
include("../class/accesscontrole.php");	



$today_date  = date("Y-m-d");
$dateArray=explode("-",$today_date);
$startDate=$dateArray[0]."-".$dateArray[1]."-01";
/* echo $startDate;
echo $today_date; */

$array = "[{";

/*Total No of WorkFlow Updated */	
/* $TolWorkFlowquery = "SELECT count(distinct(wok.wk_id))  FROM `tbl_workflow`wok inner join tbl_workflowupdate upd on wok.wk_id=upd.wk_id where wok.report_owner='".$_GET["EmpId"]."' and wok.crt_date between '$startDate' and '$today_date '"; */
$TolWorkFlowquery = "SELECT count(wok.wk_id)  FROM `tbl_workflow`wok inner join tbl_workflowupdate upd on wok.wk_id=upd.wk_id where wok.wk_owner='".$_GET["EmpId"]."' and upd.crt_date between '$startDate' and '$today_date ' and `wk_update` != '' ";
$TolWorkFlowResult = mysqli_query($link, $TolWorkFlowquery) or die(mysqli_error($link));
$row=mysqli_fetch_assoc($TolWorkFlowResult);
$array =$array.'"Total WorkFlow Updated":"'  . implode('|',$row).'"';
  
 /*Total No Of workFlow*/ 
$TotalWorkFlowYesquery = "SELECT count(*)  FROM `tbl_workflow` wok inner join tbl_workflowupdate upd on wok.wk_id=upd.wk_id where wok.wk_owner='".$_GET["EmpId"]."' and upd.crt_date between '$startDate' and '$today_date'";
$TotalWorkFlowYesResult=mysqli_query($link,$TotalWorkFlowYesquery) or die(mysqli_error($link));
$row=mysqli_fetch_assoc($TotalWorkFlowYesResult);
$array =$array.',"Total WorkFlow":"'  . implode('|',$row).'"}]';
  

 echo ($array);



?>
