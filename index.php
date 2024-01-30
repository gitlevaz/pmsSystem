<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   PMS
 * Last Update      :   11-04-2013
 * Company Name     :   Tropical Fish International (pvt) ltd
 * Create Date 		:	19-04-2011
 * Test
 */ 

ini_set('session.gc_maxlifetime', 28800);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(28800); 
//  importing all neccessary clasess 


session_start();
    $_SESSION["Mode"] = $_GET['mode'];

$_SESSION["login_time_stamp"] = time();;

include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\accesscontrole.php");       //  sql commands for the access controles
//  connecting the mysql database
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>.: PMS :. | Login</title>
    <link href="css/index.css" rel="stylesheet" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />

<!--    Loading Jquerry Plugin  -->
<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>

		
    <link href="css/styleB.css" rel="stylesheet" type="text/css" />
    
    <style type="text/css">
        * { margin: 0; padding: 0; } 
        html 
        {
            background: url('wallpapers/bg_main_login.jpg') no-repeat left top fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }        
    </style>
    
    <script type="text/javascript">
        $(window).load(function() { 
             $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
        });
    </script>
</head>

<body>
    <div id="preloader"></div>
	
	<script type="text/javascript"  language="javascript">
        
        
        function Loading() {
            //document.getElementById("msg").innerHTML = "Incorrect User Name or Password.";
            document.getElementById("msg").innerHTML = "<img src='images/loading.gif' border=0>";
        }
        function Authonticate1() {
            window.location = "home.php";
            document.getElementById("msg").innerHTML = "Your allowed to Proceed";
        }
        function Authonticate2() {
            window.location = "./workflow/updateworkflow.php";
            document.getElementById("msg").innerHTML = "Your allowed to Proceed";
        }
        function Error() {
            document.getElementById("msg").innerHTML = "Incorrect User Name or Password.";
			
        }
		function validate() {
			if(($('#UserName').val() == "")||($('#Password').val() == "") ){
				//document.getElementById("msg").innerHTML = "Incorrect User Name or Password.";
				Error();
				return false;				
			}
			
        }
        function PopOut() {
            //                window.location="index.php"
            //                newwindow=window.open('Home.php','.:: PMS by IITS ::.','height=768,width=1024');
            //                if (window.focus) {newwindow.focus()}
            return false;
        }

    </script>
    <?php
    // PMS Logged 
    //  param - true - direct to home
    //  param - false - direct to workflow
    // PMS Not Logged
    //  param - true - need to login - direct to home
    //  param - false - need to login - direct to workflow
    
        if (isset($_POST['Login'])) {

            echo "<script language=javascript>Loading()</script>";

            $_SESSION["LogUserCode"] = "";
            $_SESSION["LogUserName"] = "";
            $_SESSION["LogUserGroup"] = "";
            $_SESSION["LogEmpCode"] = "";
            $_SESSION["CompCode"] = "CIS";
			$_SESSION["LogCountry"] = "";
			
            $intRESULT      = "-";
            //$_SESSION["SERVERPATH"] = "http://localhost/PMS/";   
            //$_SESSION["SERVERPATH"] = "http://69.63.218.233:86/PMS/";
			  $_SESSION["SERVERPATH"] = "http://74.205.57.65:86/PMS/";

            $intRESULT = getUSER_ACCESS($str_dbconnect,$_POST["UserName"], $_POST["Password"]);
           
            if ($intRESULT != "-") {
                
                $_ResultSet = getSELECTEDDETAILS($str_dbconnect,$intRESULT);
                while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                    $_SESSION["LogUserCode"] = $_myrowRes['Id'];
                    $_SESSION["LogUserName"] = strtoupper($_myrowRes['User_name']);
                    $_SESSION["LogUserGroup"] = $_myrowRes['UserGroup'];
                    $_SESSION["LogEmpCode"] = $_myrowRes['EmpCode'];
                    $_EmpCoded  =   $_myrowRes['EmpCode'];
					$Country	= "";
					
					$_SelectCountry 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND EmpCode = '$_EmpCoded'" or die(mysqli_error($str_dbconnect));
					$_ResultCountrySet 	= mysqli_query($str_dbconnect,$_SelectCountry) or die(mysqli_error($str_dbconnect));
				
				    while($_myrowCountryRes = mysqli_fetch_array($_ResultCountrySet)) {						
						$Country	 = $_myrowCountryRes["Division"];						
					}
		
					$_SESSION["LogCountry"] = $Country;
                    
					//echo "<script language=javascript>alert('".$_EmpCoded."');";                   
                }
                
                // header('Location: home.php');
                if($_SESSION["Mode"]==='true'){ 
                echo "<script language=javascript>Authonticate1();</script>";
                }
                else if($_SESSION["Mode"]==='false'){
                echo "<script language=javascript>Authonticate2();</script>";
                }
                else{
                echo "<script language=javascript>Authonticate1();</script>";
                }
            } else {
				
                echo "<script language=javascript>Error();</script>";
            }
        }
    
		
		/*if (isset($_GET['UserName'])) {

            echo "<script language=javascript>Loading()</script>";

            $_SESSION["LogUserCode"] = "";
            $_SESSION["LogUserName"] = "";
            $_SESSION["LogUserGroup"] = "";
            $_SESSION["LogEmpCode"] = "";
            $_SESSION["CompCode"] = "CIS";
			$_SESSION["LogCountry"] = "";
			
            $intRESULT      = "-";
            //$_SESSION["SERVERPATH"] = "http://localhost/PMS/";
            $_SESSION["SERVERPATH"] = "http://69.63.218.233:86/PMS/";

            $intRESULT = getUSER_ACCESS($str_dbconnect,$_GET["UserName"], $_GET["Password"]);

            if ($intRESULT != "-") {
                
                $_ResultSet = getSELECTEDDETAILS($str_dbconnect,$intRESULT);
                while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                    $_SESSION["LogUserCode"] = $_myrowRes['Id'];
                    $_SESSION["LogUserName"] = strtoupper($_myrowRes['User_name']);
                    $_SESSION["LogUserGroup"] = $_myrowRes['UserGroup'];
                    $_SESSION["LogEmpCode"] = $_myrowRes['EmpCode'];
                    $_EmpCoded  =   $_myrowRes['EmpCode'];
					$Country	= "";
					
					$_SelectCountry 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND EmpCode = '$_EmpCoded'" or die(mysqli_error($str_dbconnect));
					$_ResultCountrySet 	= mysqli_query($str_dbconnect,$_SelectCountry) or die(mysqli_error($str_dbconnect));
				
				    while($_myrowCountryRes = mysqli_fetch_array($_ResultCountrySet)) {						
						$Country	 = $_myrowCountryRes["City"];						
					}
		
					$_SESSION["LogCountry"] = $Country;
					//echo "<script language=javascript>alert('".$_EmpCoded."');";                   
                }
                
                echo "<script language=javascript>Authonticate();</script>";
            } else {

                echo "<script language=javascript>Error();</script>";
            }
        }*/
		
    ?>
	
    <div id="header" style="background-color: #008000"></div>
    <div id="container" align="center">        
        <form name="Login" id="Login"  method="post" OnSubmit="return validate();">        
            <div id="Div-Login">
                
                <table width="90%" cellpadding="0" cellspacing="5px" align="center" style="font-family: verdana; font-size: 14px;">
                        <tr style="color: White; font-size: 18px;">
                            <td width="10%"></td>
                            <td width="90%" align="left" colspan="2">
                                Log in to <b>Project Management System</b><br/>
                                Version 3.0
                            </td>                            
                        </tr>
                </table>
                <table width="90%" cellpadding="0" cellspacing="10px" align="center" style="font-family: verdana; font-size: 14px;">
                        <tr>
                            <td colspan="3" align="left">
                                Enter the login name into "Login" and password into the "Password" fields respectively. Then click "Log In".
                                <br/><br/>
                            </td>
                        </tr>                        
                        <tr >
                            <td align="left" width="30%">
                                User Name
                            </td>
                            <td></td>
                            <td align="right">
                                <input name="UserName" id="UserName" type="text" size="30" class="TextBoxStyle" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                Password
                            </td>
                            <td></td>
                            <td align="right">
                                <input name="Password" type="password" id="Password" size="30" class="TextBoxStyle"/>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td align="left" ><div class="Div-MsgError" id="msg" align="left"></div></td>
                            <td></td>
                            <td align="right"><input name="Login" type="submit" class="buttonSubmit" value="Login" onclick="validate();" /></td>
                        </tr>   
                        <tr>
                            <!-- <td style="font-size: 12px;" align="left"><a href="#">Forgot my Password</a></td> -->
                            <td></td>
                            <td style="font-size: 12px;" align="right">© CIS International (Pvt) Ltd - 2023</td>
                        </tr>                        
                    </table>
                </div>            
        </form>        
    </div>

    
</body>
</html>
