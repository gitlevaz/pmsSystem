<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
	include ("../class/accesscontrole.php");
	
	$LoggedUser = $_GET["loggedUser"];
	
	if($LoggedUser == null)
	{
		echo "No Data Passed";
	}
	else
	{
		$outputLine = "";
		
		$selectOwnerEmpCodeQuery = "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='WORKFLOW' AND EmailBccStatus='A'";
		
		$resultSet1 = mysqli_query($link, $selectOwnerEmpCodeQuery) or die(mysqli_error($str_dbconnect$connection));
				
		while($resultRow1 = mysqli_fetch_assoc($resultSet1)) 
		{
						
			if($LoggedUser == $resultRow1['OwnerEmpCode'])
			{
				$selectEmailQuery = "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$LoggedUser' AND Category='WORKFLOW' AND EmailBccStatus='A'";
				
				$resultSet2 = mysqli_query($link, $selectEmailQuery) or die(mysqli_error($str_dbconnect$connection));
				
				while($resultRow2 = mysqli_fetch_assoc($resultSet2)) 
				{
					$outputLine = $outputLine.$resultRow2['EMail'].",";
				}
			}
			
		}
		
		$outputLine = substr($outputLine,0,-1);
		
		//echo $outputLine;
		$array = "[{";
	$array =$array.'"EmailCc":"'  . $outputLine.'"}]';
	echo $array;
		
	}
		

  
?>