<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
 include ("../class/accesscontrole.php");
$array = "[{";

 
  $query = "SELECT  count(*) as 'I' FROM tbl_task WHERE taskstatus = 'I' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
  $array =$array.'"Not Started":"'  . implode('|',$row).'"';
  
  
   $query = "SELECT  count(*) as 'W' FROM tbl_task WHERE taskstatus = 'W' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
  $array =$array.',"Pending for Approval":"'  . implode('|',$row).'"';
  

  $query = "SELECT  count(*) as 'C' FROM tbl_task WHERE taskstatus = 'C' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
   $array =$array.',"Completed":"'  . implode('|',$row).'"';
   
     $query = "SELECT  count(*) as 'A' FROM tbl_task WHERE taskstatus = 'A' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result); 
   $array =$array.',"In Progress":"'  . implode('|',$row).'"';
   
 
  $query = "SELECT  count(*) as 'H' FROM tbl_task WHERE taskstatus = 'H' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 $array =$array.',"Hold":"'  . implode('|',$row).'"';
 
  $query = "SELECT count(*) as 'All' FROM tbl_task WHERE taskstatus = 'S' AND taskcode in (SELECT taskcode  FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 $array =$array.',"Suspend":"'  . implode('|',$row).'"';
 
   $query = "SELECT  count(*) as 'H' FROM tbl_task WHERE taskstatus = 'IM' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 $array =$array.',"Impediment":"'  . implode('|',$row).'"}]';
  
  //$query = "SELECT  count(*) as 'O' FROM tbl_task WHERE taskstatus not in ('C','A','W','I','H','IM') AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '".$_GET["EmpId"]."')";
 //$Result=mysqli_query($link,$query) or die(mysqli_error($link));
 //$row=mysqli_fetch_assoc($Result);
  //$array =$array.',"Others":"'  . implode('|',$row).'"}]';
 echo ($array);
?>
