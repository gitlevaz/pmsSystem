<?php

	//$connection = include_once('../connection/sqlconnection.php');
	//$connection = include_once('../connection/previewconnection.php');
	$connection = include_once('../connection/mobilesqlconnection.php');
	include ("../class/accesscontrole.php");
  
	$SQLString = $_GET["SQLString"];
  
	if($SQLString != null)
	{
		$Result=mysqli_query($link,$SQLString) or die(mysqli_error($link));
		$rows = array();
		while($r = mysqli_fetch_assoc($Result)) {
			$rows[] = $r;
		}
	
		echo json_encode($rows);
	}
	else
	{
		echo "No String found!";
	}
 
?>