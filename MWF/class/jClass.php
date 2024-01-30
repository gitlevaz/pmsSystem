<?php
	
	session_start();
	
	include ("..\..\connection\sqlconnection.php");   //  connection file to the mysql database
	include ("..\..\class\accesscontrole.php");       //  sql commands for the access controles	
	
	mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	
	if(isset($_POST['Command']) && isset($_POST['UserCode']) && $_POST['Command'] == "AuthorizedUser"){
        
        $_UserCode 				= 	$_POST['UserCode'];        
        $str_Authonticate       =	"-";

	    $str_SelectQuery        = 	"SELECT * FROM tbl_sysusers WHERE WMF_Code = '$_UserCode'" or die(mysqli_error($str_dbconnect));
	    $str_ResultSet          =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	    while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {
	        $str_Authonticate   =	$_myrowRes['Id'];;
	    }
		
		if ($str_Authonticate != "-") {
		                
            $_ResultSet = getSELECTEDDETAILS($str_dbconnect,$str_Authonticate);
            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                $_SESSION["LogUserCode"] = $_myrowRes['Id'];
                $_SESSION["LogUserName"] = strtoupper($_myrowRes['User_name']);
                $_SESSION["LogUserGroup"] = $_myrowRes['UserGroup'];
                $_SESSION["LogEmpCode"] = $_myrowRes['EmpCode'];
                $_EmpCoded  =   $_myrowRes['EmpCode'];
				
				$Country	= "";
				$EmpName	= "";
				
				$_SelectCountry 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND EmpCode = '$_EmpCoded'" or die(mysqli_error($str_dbconnect));
				$_ResultCountrySet 	= mysqli_query($str_dbconnect,$_SelectCountry) or die(mysqli_error($str_dbconnect));
				
				
			    while($_myrowCountryRes = mysqli_fetch_array($_ResultCountrySet)) {						
					$Country	 = $_myrowCountryRes["Division "];	
					$EmpName	 = $_myrowCountryRes["FirstName"];					
				}
	
				$_SESSION["LogCountry"] = $Country;
				$_SESSION["LogEmpName"] = $EmpName;
				//echo "<script language=javascript>alert('".$_EmpCoded."');</script>";                   
            }            
        }
		    
	    echo $str_Authonticate  ;
        
    }
	
	if(isset($_POST['Command']) && isset($_POST['WF_ID']) && $_POST['Command'] == "UpdateService"){	
		
		$WF_ID				=	$_POST['WF_ID'];
		$TaskComletion		=	$_POST['TaskStatus'];
		$TaskStartTime		=	$_POST['TaskStartTime'];
		$TaskEndTime		=	$_POST['TaskEndTime'];
		$UserNote			=	$_POST['UserNote'];
		$LogUserCode 		= 	$_SESSION["LogEmpCode"]; 
		
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}		
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		if($Country == "FIJI"){
			$timezone = "Pacific/Fiji";	
		}

		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");        
        
        $_SelectQuery 	=   "UPDATE tbl_workflowupdate SET `wk_update` = '$UserNote' , `status` = '$TaskComletion', crt_by = '$LogUserCode', TimeTaken = '$TaskEndTime', StartTime = '$TaskStartTime' WHERE  wk_id = '$WF_ID' AND crt_date = '$today_date'" or die(mysqli_error($str_dbconnect));            
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		echo "SAVED";
		
	}
	
	if(isset($_POST['Command']) && isset($_POST['Station_ID']) && $_POST['Command'] == "UpdateStation"){		
					
		$Station_ID 	= $_POST['Station_ID']; 
		$Station_Name 	= $_POST['Station_Name']; 
		$Update_Cat 	= $_POST['Update_Cat']; 
		$TimeLog		= $_POST['TimeLog'];
		$UserComment	= $_POST['UserComment'];		
		$TaskID			= $_POST['TaskID'];	
		
		
		$LogUserCode 		= 	$_SESSION["LogEmpCode"]; 
		
		$Country = $_SESSION["LogCountry"];
		$timezone = "Asia/Colombo";	
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}		
if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		if($Country == "FIJI"){
			$timezone = "Pacific/Fiji";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
		
		if($Update_Cat == 'S'){			
			
			$_SelectQueryChk 	=   "SELECT * FROM tbl_stationlog WHERE TrnDateTime = '$today_date' AND EmpCode = '$LogUserCode' AND TrnType = 'S' ORDER BY Trn_ID" or die(mysqli_error($str_dbconnect));
	        $_ResultSetChk 		=   mysqli_query($str_dbconnect,$_SelectQueryChk) or die(mysqli_error($str_dbconnect));      
	
	        while($_myrowResChk = mysqli_fetch_array($_ResultSetChk)) {		
				
	            $_Chk_1   =   $_myrowResChk['Trn_ID'];
				$_Chk_2   =   $_myrowResChk['Station_Name'];
				$_Chk_3   =   $_myrowResChk['TaskID'];			
				
				/*$_SelectQuery	=	"INSERT INTO tbl_stationlog (`Station_ID`, `Station_Name`, `EmpCode`, `TimeLog`, `TrnType`, `TaskID`, `UserComments`, `TrnDateTime`, `Status`) VALUES ('$_Chk_1', '$_Chk_2', '$LogUserCode', '$TimeLog', 'P', '$_Chk_3', 'Station Task Auto Log-Off', '$today_date', 'A')";                
	        	mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
				
				$_SelectQuery	=	"UPDATE tbl_stationlog SET TrnType = 'P',  TimeLogEnd = '$TimeLog' WHERE Trn_ID = '$_Chk_1'";                
	        	mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	        }
		
			$_SelectQuery	=	"INSERT INTO tbl_stationlog (`Station_ID`, `Station_Name`, `EmpCode`, `TimeLog`, `TrnType`, `TaskID`, `UserComments`, `TrnDateTime`, `Status`) VALUES ('$Station_ID', '$Station_Name', '$LogUserCode', '$TimeLog', '$Update_Cat', '$TaskID', '$UserComment', '$today_date', 'A')";                
        	mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
			
			echo "SAVED";	
		}		
		
		if($Update_Cat == 'P'){			
			
			$_Chk_1 = "No";
			
			$_SelectQueryChk 	=   "SELECT * FROM tbl_stationlog WHERE TrnDateTime = '$today_date' AND EmpCode = '$LogUserCode' AND TrnType = 'S' AND Station_ID = '$Station_ID' ORDER BY Trn_ID" or die(mysqli_error($str_dbconnect));
	        $_ResultSetChk 		=   mysqli_query($str_dbconnect,$_SelectQueryChk) or die(mysqli_error($str_dbconnect));      
	
	        while($_myrowResChk = mysqli_fetch_array($_ResultSetChk)) {		
				
	            $_Chk_1   =   $_myrowResChk['Trn_ID'];
				$_Chk_2   =   $_myrowResChk['Station_Name'];
				$_Chk_3   =   $_myrowResChk['TaskID'];				
				
				$_SelectQuery	=	"UPDATE tbl_stationlog SET TrnType = 'P',  TimeLogEnd = '$TimeLog' WHERE Trn_ID = '$_Chk_1'";                
	        	mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	        }
			
			if($_Chk_1 != "No"){				
				echo "SAVED";
			}else if($_Chk_1 == "No"){				
				echo "NOT SAVED";		
			}	
				
		}				
		
	}
	
?>