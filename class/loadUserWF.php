<?php
	
	
	session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("accesscontrole.php"); //  sql commands for the access controles
    include ("sql_empdetails.php"); //  connection file to the mysql database
    include ("sql_crtprocat.php");            //  connection file to the mysql database
    
    require_once("class.phpmailer.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database
    
    include ("sql_wkflow.php");            //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
    
	
	$path = "../";
	$Menue	= "UpdateWF";	
	
	$ProcessCountry = $_GET["Country"];
	
	echo $ProcessCountry."</br>";
	

	$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND City = '$ProcessCountry'" or die(mysqli_error($str_dbconnect));
	$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
	
		$LogUserCode = $_myrowRes["EmpCode"];  
		$Country	 = $_myrowRes["Division"];
		
		echo $LogUserCode."</br>";
		
		// if ( validateLoading($str_dbconnect,$LogUserCode) > 0 ){ 
		
			echo $LogUserCode." Got In</br>";
			            
	        Get_DailyWorkFlow($str_dbconnect,$LogUserCode, $Country);
	        Get_WeeklyWorkFlow($str_dbconnect,$LogUserCode, $Country);
	        Get_MonthlyWorkFlow($str_dbconnect,$LogUserCode, $Country);
	        Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country);
	        
	        updateSummary($str_dbconnect,$LogUserCode);	        
	    // }
	}
?>