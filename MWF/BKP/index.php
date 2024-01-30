<?php

	session_start();
	session_destroy();
	session_start();
	
	include ("..\connection\sqlconnection.php");   //  connection file to the mysql database
	include ("..\class\accesscontrole.php");       //  sql commands for the access controles	
	
	mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">   
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sample Page</title> 
		
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Sample Page</title>  
		         
        <link rel="stylesheet" href="jquery.mobile-1.2.0/jquery.mobile-1.0.min.css" />  
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery-1.6.4.min.js"></script>        
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery.mobile-1.0.min.js"></script>
		
		<script type="text/javascript">
			eraseCookie("UserCode");
		</script>
		
		<script type="text/javascript">
			
			function createCookie(name,value,days) {
				if (days) {
					var date = new Date();
					date.setTime(date.getTime()+(days*24*60*60*1000));
					var expires = "; expires="+date.toGMTString();
				}
				else var expires = "";
				document.cookie = name+"="+value+expires+"; path=/";
			}
			
			function readCookie(name) {
				var nameEQ = name + "=";
				var ca = document.cookie.split(';');
				for(var i=0;i < ca.length;i++) {
					var c = ca[i];
					while (c.charAt(0)==' ') c = c.substring(1,c.length);
					if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
				}
				return null;
			}
			
			function eraseCookie(name) {
				createCookie(name,"",-1);
			}
		
			function GoHome(){
				alert("sadfsaf");
				/*window.location = "home.php";	*/		
			}	
			
			
			function GetURLParameter(sParam)
			{
				var testd = "";
    			var sPageURL = window.location.search.substring(1);
    			var sURLVariables = sPageURL.split('&');
    			for (var i = 0; i < sURLVariables.length; i++)
    			{
	       			var sParameterName = sURLVariables[i].split('=');	
	        		if (sParameterName[0] == sParam)	
	        		{	
	            		return sParameterName[1];	
	        		}
    			}				
				return testd;				
			}​
			
			function sendmessage(){
				alert("asdas");
			}
			
			
		</script>
		
		<script type="text/javascript">
			var MCID = "M3";			
		</script>
		
		<script type="text/javascript">
			function LoadHomePage(){			
				alert("Loading Home");				
				window.location = "home.php";
			}
			
			function LoadServices(MCID,MCNAME){		
				alert("Loading Services");		
				window.location = "ServiceList.php?MCID="+MCID+"&MCNAME="+MCNAME;			
			}
			
			function LoadStations(MCID,MCNAME){		
				alert("Loading Stations");		
				window.location = "ServiceList.php?MCID="+MCID+"&MCNAME="+MCNAME;			
			}
		</script>
    </head>   
    <body>   
		
		<?php	
			
			
			$MCID		=	"";
			$MCNAME		=	"";
			$Country	=	"";
			
			if(isset($_GET["MCID"])){
				$MCID =	$_GET["MCID"]; 		
			}
			
			if(isset($_GET["MCNAME"])){
				$MCNAME =	$_GET["MCNAME"]; 		
			}
			
			$timezone = "Asia/Colombo";	
		
			if(isset($_SESSION["LogCountry"])){
				$Country = $_SESSION["LogCountry"];
			}
				
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
	
			/*date_default_timezone_set($timezone);			
	        
	        $LogUserCode = $_SESSION["LogEmpCode"];        
	        $today_date  = date("Y-m-d");
			
			Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country);*/
			
			$EquipedName =  $MCID."-".$MCNAME;
			
			/*$count = $count + 1;*/
			
			/*if(isset($_COOKIE["UserCode"]) && $MCID != ""){			
				$_UserCode 				= 	$_COOKIE["UserCode"];        
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
							$Country	 = $_myrowCountryRes["City"];	
							$EmpName	 = $_myrowCountryRes["FirstName"];					
						}
			
						$_SESSION["LogCountry"] = $Country;
						$_SESSION["LogEmpName"] = $EmpName;
						           
		            }            
		        }		
				echo "<script language='javascript' type='text/javascript'>LoadServices('".$MCID."','".$MCNAME."');</script>";
			}*/
			
			if(isset($_POST["btn_submit"]))
			{			
				$MCID		=	"";
				$MCNAME		=	"";
				$Country	=	"";
				
				if(isset($_GET["MCID"])){
					$MCID =	$_GET["MCID"]; 		
				}
				
				if(isset($_GET["MCNAME"])){
					$MCNAME =	$_GET["MCNAME"]; 		
				}
				
				$timezone = "Asia/Colombo";	
			
				if(isset($_SESSION["LogCountry"])){
					$Country = $_SESSION["LogCountry"];
				}
					
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
				$_UserCode 				= 	$_POST['txt_userID'];        
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
							$Country	 = $_myrowCountryRes["Division"];	
							$EmpName	 = $_myrowCountryRes["FirstName"];					
						}
			
						$_SESSION["LogCountry"] = $Country;
						$_SESSION["LogEmpName"] = $EmpName;
						//echo "<script language=javascript>alert('".$_EmpCoded."');</script>";                   
		            }            
		        }				
				if ($str_Authonticate != "-") {
					$EquipedName = $EquipedName." ".$EmpName;
					/*setcookie("UserCode", $_UserCode);	*/
					if($MCID != ""){
						echo "<script language='javascript' type='text/javascript'>alert('IN');</script>";
						if(substr($MCID, 0, 1) == "M"){						
							echo "<script language='javascript' type='text/javascript'>LoadServices('".$MCID."','".$MCNAME."');</script>";			
						}else{
							echo "<script language='javascript' type='text/javascript'>LoadStations('".$MCID."','".$MCNAME."');</script>";				
						}			
					}else{
						echo "<script language='javascript' type='text/javascript'>alert('OUT');</script>";
						echo "<script language='javascript' type='text/javascript'>LoadHomePage();</script>";									
					}					
				}
			}			
		?>			
		<form name="Login" id="Login"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div id="MWF_Header" data-theme="a" data-role="header">				
                <h1>
                    Mobile Work Flow
                </h1>				               
            </div>	
			<div data-role="content">		
				<fieldset data-role="controlgroup" style="text-align:center;">
					<?php echo $EquipedName."<br/>"; ?>
		            <label for="txt_userID" >
		                User Code
		            </label>
		            	<input name="txt_userID" id="txt_userID" placeholder="" value="" type="password" />
						<input name="txt_MCID" id="txt_userID" placeholder="" value="<?php echo '';?>" type="hidden" />
						<input name="txt_MCNAME" id="txt_userID" placeholder="" value="<?php echo ''; ?>" type="hidden" />
						<br/>				
						<input type="submit" id="btn_submit" name="btn_submit" value="Submit"/>  					
					<br/><br/>	
				</fieldset>
			</div>
			<div id="MWF_Footer" data-theme="a" data-role="footer" data-position="fixed">
                <h3>
                    Teknowledge &copy; 2012
                </h3>
            </div>
		 </form>
		
    </body>
</html>​