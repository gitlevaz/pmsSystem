<?php
$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php"); 
 
    $DeviceId = $_GET["DeviceId"];
    $EmpCode = $_GET["EmpCode"];
	$Active="";
	
	$Selectquery = "SELECT COUNT(*) FROM tbl_pushnotificationdevice WHERE EmployeeId='$EmpCode'";        
    $Result=mysqli_query($link,$Selectquery) or die(mysqli_error($link));
    $row=mysqli_fetch_assoc($Result);
	
	
    IF($row["COUNT(*)"] > 0)
	{

		$Selectquery = "SELECT Active FROM tbl_pushnotificationdevice WHERE EmployeeId='$EmpCode'";        
		$Result=mysqli_query($link,$Selectquery) or die(mysqli_error($link));
		$row=mysqli_fetch_assoc($Result);
		$Active=$row["Active"];
		
		if($Active != null)
		{   
			$DeteleTaskAlert="DELETE FROM tbl_pushnotificationdevice WHERE DeviceId='$DeviceId' or EmployeeId='$EmpCode'";
			$values=mysqli_query($link,$DeteleTaskAlert) or die(mysqli_error($link));
				 
			$InsertFirstTime = "INSERT INTO tbl_pushnotificationdevice (DeviceId, EmployeeId,Active) VALUES ('$DeviceId','$EmpCode','$Active')";               
			$result=mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
			echo $Active;
		}
		else
		{
			echo $Active;
		}
	
	}
	else
	{
		$InsertFirstTime = "INSERT INTO tbl_pushnotificationdevice (DeviceId, EmployeeId) VALUES ('$DeviceId','$EmpCode')";               
		$result=mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
		echo 'true';
		
	}
	
	  
?>