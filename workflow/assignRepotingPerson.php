<?php

session_start();

include("../connection/sqlconnection.php");
//  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
include("../class/accesscontrole.php"); //  sql commands for the access controles
include("../class/sql_empdetails.php"); //  connection file to the mysql database
include("../class/sql_crtprocat.php");            //  connection file to the mysql database

include("../class/sql_wkflow.php");            //  connection file to the mysql database

require_once("../class/class.phpmailer.php");
#include ("../class/MailBodyOne.php"); //  connection file to the mysql database

mysqli_select_db($str_dbconnect, "$str_Database") or die("Unable to establish connection to the MySql database");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS - WORK FLOW ::.</title>

    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/screen.css" />
    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />

    <!-- **************** TIME PICKER START  ***************** -->
    <script type="text/javascript" src="jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>

    <link rel="stylesheet" href="jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />


    <!-- **************** TIME PICKER END ***************** -->
    <!--
    <script src="../ui/jquery.ui.core.js"></script>
    <script src="../ui/jquery.ui.widget.js"></script>
   
     **************** NEW GRID ***************** -->

    <style type="text/css" title="currentStyle">
        @import "../media/css/demo_page.css";
        @import "../media/css/demo_table.css";
    </style>

    <script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>

    <!-- **************** NEW GRID END ***************** -->

    <!-- ************ FILE UPLOAD ********* -->

    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />

    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>

    <!-- ****************END***************** -->

    <link href="../css/styleB.css" rel="stylesheet" type="text/css" />

    <style type="text/css">

    </style>

<script>
        function getWFDetails(){     
            $.post('get_Departments.php',{wfOner : frm_WorkFlow.cmbOwner.value},
                function(output){  
                    $('#tblGrid').html(output);                    
                }
            ),				 	
            $.post('../class/sql_getKJR.php',{wfuser : frm_WorkFlow.cmbOwner.value},			
                function(output){ 						                 
                    $('#kjrcode').html(output);
                }
            )   
			           
        }
</script>


</head>

<body>

    <?php


    $_SESSION["Str_NEW"]       =   "TRUE";
    $_SESSION["Str_MOD"]       =   "TRUE";
    $_SESSION["Str_SAV"]       =   "FALSE";
    $_SESSION["Str_DEL"]       =   "FALSE";
    $_SESSION["PageReoad"]      = "FALSE";

    $Str_WKID       =   "";     //  WORK FLOW ID
    $Str_ProName    =   "";
    $Dte_Startdate  =   "";
    $Dte_Enddate    =   "";
    $bool_ReadOnly  =    "FALSE";
    $Save_Enable    =    "No";
    $ErrorString    =   "";
    $_strEMPCODE    =   "";
    $_strDptCode    =   "";
    $_strDivCode    =   "SL";
    $_strProInit    =   "";
    $fileUpload     =   "";
    $NewFileCode    =   "";
    $_strSecOwner   =   "";
    $_strSupport    =   "";
    $MailsCC[]        = "";


    if (isset($_POST['btn_Save'])) {
        $_report_owner = $_POST['cmbReportOwner'];
        $_wk_Owner =  $_POST['cmbOwner'];

        $_SelectQuery   =   "UPDATE tbl_workflow SET `report_owner` = '$_report_owner' WHERE `wk_Owner` = '$_wk_Owner' " or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect, $_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

    ?>


    <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left">
                    <div id="wrapper">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" style="width: 100%;">
                                    <div id="header">
                                        <!--Header-->
                                        <?php include('../Header.php'); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <!--border-left: 2px solid #063794; border-right: 2px solid #063794-->
                                <td style="width: 220px; height: auto; background-color: #599b83" align="left" valign="top" id="leftBottom">
                                    <div id="left" style="background-color: transparent">
                                        <div id="leftTop">
                                            <div class="menu" id="MenuListNav">
                                                <?php include('../Menu.php'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td align="left" style="width: 100%; vertical-align: top;">
                                    <div id="right">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                <td style="padding-left: 10px; font-size: 16px">
                                                    <font color="#0066FF">Assign Reporting Person</font>
                                                </td>
                                            </tr>
                                            <tr align="center">

                                            </tr>
                                        </table>
                                        <br></br>
                                        <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                            <tr>
                                                <td>
                                                    <table width="80%" style="border-bottom: 0px; border-left: 0px; border-right: 0px; border-top: 0px; padding: 0 0 0 0px">
                                                        <tr>
                                                            <td width="30%" align="Right" height="30">
                                                                Work Flow Owner
                                                            </td>
                                                            <td width="1%" height="30">
                                                                &nbsp;:&nbsp;
                                                            </td>
                                                            <td width="65%" align="left" height="30">
                                                                <select id="cmbOwner" name="cmbOwner" class="Div-TxtStyleNormal" onchange="getWFDetails()">
                                                                    <?php
                                                                    #	Get Designation details ...................
                                                                    $_EmpCode       =   $_SESSION["EmpCode"];
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
                                                                    while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                    ?>
                                                                        <option value="<?php echo $_myrowRes['EmpCode']; ?>" <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td width="30%" align="Right" height="30">
                                                                Report Owner
                                                            </td>
                                                            <td width="1%" height="30">
                                                                &nbsp;:&nbsp;
                                                            </td>
                                                            <td width="65%" align="left" height="30">
                                                                <select id="cmbReportOwner" name="cmbReportOwner" class="Div-TxtStyleNormal">
                                                                    <?php
                                                                    #	Get Designation details ...................
                                                                    $_EmpCode       =   $_SESSION["EmpCode"];
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
                                                                    while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                    ?>
                                                                        <option value="<?php echo $_myrowRes['EmpCode']; ?>" <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="demo">
                                                                    <br></br>
                                                                    <center>
                                                                      <input type="submit" value="Save" id="btn_Save" name="btn_Save" />
                                                                    </center>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table><br></br>  <br></br>  

                                                    <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td>
                                                            <center>
                                                                <h3 style="color: #666">Work Flow List</h3>
                                                            </center>
                                                            <hr></hr>
                                                            <br></br>                                                           
                                                            <div  style="padding-left: 5px; padding-right: 5px">
                                                                <div class="demo" id="tblGrid">

                                                                </div>                                                               
                                                            </br>                                                            
                                                        </td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            
                                                        </td>
                                                    </tr>
                                                </table>

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
                        <?php include('../footer.php') ?>
                    </div>
                </td>
            </tr>
        </table>
        <script>
            getWFDetails();
        </script>

        <!-- <br></br>
        <div class="demo">
            <br></br>
            <center>
                <input type="button" value="Save" id="btn_Save" name="btn_Save" <?php if ($_SESSION["Str_SAV"] == "FALSE") echo "disabled=\"disabled\";" ?> onclick="startUpload()" />
            </center>
        </div>
        <br>
   
        </br> -->
        </div>
    </form>
</body>

</html>