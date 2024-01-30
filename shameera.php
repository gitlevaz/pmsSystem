<?php

		
	include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\accesscontrole.php");       //  sql commands for the access controles
include ("class\sql_empdetails.php");       //  sql commands for the access controles
//  connecting the mysql database
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	
?>
<?php
	//echo "dsfsdf";
	$_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
	
	$json = array();



	if(mysqli_num_rows($_ResultSet)){


		while($row = mysqli_fetch_assoc($_ResultSet)){
//echo $row['FirstName'];
			$json['emp_info'][] = $row;

		}
	}
		
	echo json_encode($json); 
	//echo "sadas";
?>