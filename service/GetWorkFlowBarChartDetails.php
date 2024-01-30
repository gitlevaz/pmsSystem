<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
include("../class/accesscontrole.php");	



$today_date  = date("Y-m-d");
$array = "[{";

/*Total No Of workFlow */	
$TolWorkFlowquery = "SELECT count(*) FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '".$_GET["EmpId"]."' ";
$TolWorkFlowResult = mysqli_query($link, $TolWorkFlowquery) or die(mysqli_error($link));
$row=mysqli_fetch_assoc($TolWorkFlowResult);
$array =$array.'"Total WorkFlow Count":"'  . implode('|',$row).'"';
  
 /*Total No Of workFlow  with status Yes*/ 
$TotalWorkFlowYesquery = "SELECT count(*) FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '".$_GET["EmpId"]."' AND `wk_update` != '' AND `status` != 'N/A' ";
$TotalWorkFlowYesResult=mysqli_query($link,$TotalWorkFlowYesquery) or die(mysqli_error($link));
$row=mysqli_fetch_assoc($TotalWorkFlowYesResult);
$array =$array.',"Total WorkFlow with Yes Count":"'  . implode('|',$row).'"';
  
 /*Total No Of workFlow  with status No*/ 
$TotalWorkFlowNoquery = "SELECT count(*) FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '".$_GET["EmpId"]."' AND `wk_update` = ''";
$TotalWorkFlowNoResult=mysqli_query($link,$TotalWorkFlowNoquery) or die(mysqli_error($link));
$row=mysqli_fetch_assoc($TotalWorkFlowNoResult);
$array =$array.',"Total WorkFlow with No Count":"'  . implode('|',$row).'"';
   
   
 /*Total No Of workFlow  with status NA*/
$TotalWorkFlowNaquery = "SELECT count(*) FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '".$_GET["EmpId"]."' AND `status` = 'N/A'";
$TotalWorkFlowNaResult=mysqli_query($link,$TotalWorkFlowNaquery) or die(mysqli_error($link));
$row=mysqli_fetch_assoc($TotalWorkFlowNaResult); 
$array =$array.',"Total WorkFlow with NA Count":"'  . implode('|',$row).'"}]';

 echo ($array);



?>
