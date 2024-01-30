<?php
session_start();

include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\sql_Task.php");       //  sql commands for the access controles
include ("class\sql_crtgroups.php");   //  connection file to the mysql database
include ("class\sql_project.php");       //  sql commands for the access controles
require_once("class/class.phpmailer.php");
include ("class\MailBodyTwo.php");   //  connection file to the mysql database
include ("class\sql_empdetails.php");   //  connection file to the mysql database
include ("class/accesscontrole.php");       //  sql commands for the access controles
//include ("class/sql_sysusers.php");          //  sql commands for the access controls


mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "Home";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS CONTENT ::.</title>
    <link rel="stylesheet" href="css/content.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
	
	<!--    Loading Jquerry Plugin  -->
	<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>
	
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.button.js"></script>
	
	<style type="text/css" title="currentStyle">
	    @import "media/css/demo_page.css";
	    @import "media/css/demo_table.css";
	</style>
	
	<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
	
	<!-- **************** NEW GRID END ***************** -->
	
	<link rel="stylesheet" href="css/updateTask.css" type="text/css" />
	<link rel="stylesheet" href="css/slider.css" type="text/css" />
	<link href="css/textstyles.css" rel="stylesheet" type="text/css" />
	<!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->
	
	<!-- **************** SLIDER ***************** -->
	<script src="js/jquery-ui.min.js"></script>
	
	<script type="text/javascript"  src="src/js/jscal2.js"></script>
	<script type="text/javascript"  src="src/js/lang/en.js"></script>
	
	<link type="text/css" rel="stylesheet" href="src/css/jscal2.css" />
	<link type="text/css" rel="stylesheet" href="src/css/border-radius.css" />
	
	<link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
	<link rel="stylesheet" href="css/uploadify.styling.css" type="text/css" />
	<script type="text/javascript" src="js/jquery.uploadify.js"></script>
	
	<!-- ************ TIME PICKER ***************** -->
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<!-- ************************************* -->	
		
	<link href="css/styleB.css" rel="stylesheet" type="text/css" />
    
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	
	
</head>
    
<body onload="init()" >
    
	<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">
                <div id="wrapper">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2" style="width: 100%;">
                                <div id="header">                                    
                                    <!--Header-->
                                    <?php include('Header.php'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <!--border-left: 2px solid #063794; border-right: 2px solid #063794-->
                            <td style="width: 220px; height: auto; background-color: #599b83" align="left" valign="top" id="leftBottom">
                                <div id="left" style="background-color: transparent">                                   
                                    <div id="leftTop">                                        
                                        <div class="menu" id="MenuListNav">
                                            <?php include('Menu.php'); ?>
                                        </div>
                                    </div>
                                </div> 
                            </td>
                            <td align="left" style="width: 100%; vertical-align: top;">
                                <div id="right" >
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr style="height: 50px; background-color: #E0E0E0;">
                                            <td style="padding-left: 10px; font-size: 16px">
                                                <font color="#0066FF">No ACCESS</font>
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>                                    
                                    <br></br>
                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td align="center" style="height:400px">                                                
                                             	<H1 style="color:#a74343">YOU DON'T HAVE PERMISSION TO ACCESS THIS PAGE</H1> 
												<H2>- Please Contact System Admin -</H2>  
                                            </td>
                                        </tr>
                                    </table>                                    
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>            
        </tr>   
        <tr>
            <td colspan="2" style="width: 100%">
                <div id="footer">
                    <?php include ('footer.php') ?>
                </div>
            </td>
        </tr>
    </table>  
    
</body>
</html>