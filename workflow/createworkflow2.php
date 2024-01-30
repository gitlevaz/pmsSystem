<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Crate Work Flow
 * Last Update      :   06/10/2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

    session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("../class/accesscontrole.php"); //  sql commands for the access controles
    include ("../class/sql_empdetails.php"); //  connection file to the mysql database
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    
    include ("../class/sql_wkflow.php");            //  connection file to the mysql database
    
    require_once("../class/class.phpmailer.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
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
	$(function() {
            $( "input:submit", ".demo" ).button();
            $( "input:button", ".demo" ).button();
	});
        
        $(document).ready(function() {
            $('#example').dataTable();
        } );
        
        var queueSize = 0;

        function startUpload(){
            var valdator = false;
            valdator = $("#frm_porject").valid();
            if(valdator != false){
                if (queueSize == 0) {
                    //alert("No Any Files to Upload!");
                    document.forms['frm_porject'].action = "../updateTask.php?btnSave=btnSave";
                    document.forms['frm_porject'].submit();
                }
                $('#fileUploadstyle').fileUploadStart()
            }
        }
        
        function getDepartments(){            
            $.post('get_Departments.php',{id : frm_WorkFlow.cmbDiv.value},
                function(output){                      
                    $('#cmbDpt').html(output);
                }
            )            
        }
        
        function refreshList(){            
            $.post('get_Departments.php',{refresh : frm_WorkFlow.lstSysUsers.value},
                function(output){                     
                    $('#lstSysUsers').html(output);
                }
            )            
        }
        
        function selectUser(){   
            var w = frm_WorkFlow.lstSysUsers.selectedIndex;
            
            $.post('get_Departments.php',{selectUser : frm_WorkFlow.lstSysUsers.value , UserName : frm_WorkFlow.lstSysUsers.options[w].text},
                function(output){                    
                    $('#lstFacUsers').html(output);
                    refreshList();
                }
            )            
        }
        
        function removeUser(){            
            $.post('get_Departments.php',{removeUser : frm_WorkFlow.lstFacUsers.value},
                function(output){                    
                    $('#lstFacUsers').html(output);   
                    refreshList();
                }
            )            
        }
        
        function getWFDetails(){            
            $.post('get_Departments.php',{wfuser : frm_WorkFlow.cmbOwner.value},
                function(output){  
                    //alert(output);
                    $('#tblGrid').html(output);                    
                }
            )            
        }
        
        function viewWKFID(wkfid){            
            document.forms['frm_WorkFlow'].action = "createworkflow.php?status=view&id=" + wkfid + "";
            document.forms['frm_WorkFlow'].submit();
        }
        
        function deleteWKFID(wkfid){           
            document.forms['frm_WorkFlow'].action = "createworkflow.php?status=del&id=" + wkfid + "";
            document.forms['frm_WorkFlow'].submit();
        }
        
    </script>
    
    <script type="text/javascript">

        var queueSize = 0;

        function startUpload(){
            
            var valdator = true;
            //valdator = $("#frm_WorkFlow").valid();
            if(valdator != false){
                if (queueSize == 0) {
                    alert("No Any Files to Upload!");
                    document.forms['frm_WorkFlow'].action = "createworkflow.php?btn_Save=btn_Save";
                    document.forms['frm_WorkFlow'].submit();
                }else{
                    alert('asdfasf');
                    $('#fileUploadstyle').fileUploadStart();
                }
            }
        }

        $(document).ready(function() {
            
            $("#fileUploadstyle").fileUpload({                
                'uploader': '../uploadify/uploader.swf',
                'cancelImg': '../uploadify/cancel.png',
                'script': '../uploadify/workFlowUpload.php',
                'folder': 'files',
                'fileExt': '*.pdf;*.PDF;*.doc;*.DOC;*.docx;*.DOCX;*.xls;*.XLS;*.xlsx;*.XLSX;*.psd;*.PSD;*.ai;*.AI;*.zip;*.ZIP;*.rar;*.RAR;*.exe;*.EXE',
                'multi': true,
                'simUploadLimit': 1,
                'sizeLimit': 200000000,
                'displayData': 'speed',
                'width': 105,
                'height': 25,
                'onCancel': function (a, b, c, d) {
                    queueSize = d.fileCount;
                },
                'onClearQueue': function (a, b) {
                    queueSize = b.fileCount;
                },
                'onSelectOnce': function (a, b) {
                    queueSize = b.fileCount;
                },
                'onComplete'  : function(event, ID, fileObj, response, data) {
                    alert('complete');
                    //alert('There are ' + data.fileCount + ' files remaining in the queue.');
                },
                'onAllComplete' : function(event,data) {
                    queueSize = 0;
                    alert(data.filesUploaded + ' files uploaded successfully!');
                    document.forms['frm_WorkFlow'].action = "createworkflow.php?btn_Save=btn_Save";
                    document.forms['frm_WorkFlow'].submit();
                }}
            );
        });       
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
            $bool_ReadOnly  =	"FALSE";
            $Save_Enable    =	"No";
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
            
            if(isset($_POST['txtTaskID'])) 
            { 
                $Str_WKID = $_POST['txtTaskID'];                 
            } 
                
            
            if (isset($_POST['btn_New'])) {
                
                $bool_ReadOnly = "TRUE";
                $Save_Enable = "No";
                
                $_SESSION["DataMode"] = "";
                $_SESSION["Str_WKID"] = "";
                
                $_Serial_Val    =   -1;
                $_CompCode      =   "CIS";
                
                $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1050'" or die(mysqli_error($str_dbconnect));
                $_ResultSet      =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    $_Serial_Val	=   $_myrowRes['Serial'];
                }
                
                $_Serial_Val = $_Serial_Val + 1;

                $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1050'" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 
                
                $Str_WKID = "TWK/" . $_Serial_Val;
                
                $_SESSION["Str_WKID"] = "TWK/" . $_Serial_Val;
                
                $_SESSION["Str_NEW"]       =   "FALSE";
                $_SESSION["Str_MOD"]       =   "FALSE";
                $_SESSION["Str_SAV"]       =   "TRUE";
                $_SESSION["Str_DEL"]       =   "FALSE";
                
                $NewFileCode = create_FileName($str_dbconnect);
                $_SESSION["NewUPLCode"] = $NewFileCode;
                $_SESSION["UploadeFileCode"] = "";
            }
            
            if (isset($_POST['btn_Save'])) {
                
                $_Serial_Val    =   -1;
                $_CompCode      =   "CIS";
                
                $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'" or die(mysqli_error($str_dbconnect));
                $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    $_Serial_Val =   $_myrowRes['Serial'];
                }
                
                $_Serial_Val = $_Serial_Val + 1;

                $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 
                
                $Str_WKID = "WK/" . $_Serial_Val;
                
                $Str_UPLCode = $_SESSION["NewUPLCode"];
                
                $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
                
                $wk_id = $Str_WKID;
                $wk_name = $_POST["txtTaskName"];
                $wk_Owner = $_POST["cmbOwner"];
                $schedule = $_POST["cmbSchedule"];
                $sched_time = $_POST["cmbTime"];
                $start_time = $_POST["timepicker_start"];
                $end_time = $_POST["timepicker_end"];
                $report_owner = $_POST["cmbReportOwner"];
                $report_div = $_POST["cmbDiv"];
                $report_Dept = $_POST["cmbDpt"];
                $crt_date = "12/10/2011";
                $crt_by = $_SESSION["LogEmpCode"];
                
                $_strDivCode = $_POST["cmbSchedule"];
                
                createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by);
                
                
                $_SESSION["Str_WKID"] = $Str_WKID;
                
                $_SESSION["Str_NEW"]       =   "TRUE";
                $_SESSION["Str_MOD"]       =   "TRUE";
                $_SESSION["Str_SAV"]       =   "FALSE";
                $_SESSION["Str_DEL"]       =   "FALSE";
            }
            
            if (isset($_GET['btn_Save'])) {
                
                $_Serial_Val    =   -1;
                $_CompCode      =   "CIS";
                
                $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'" or die(mysqli_error($str_dbconnect));
                $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    $_Serial_Val =   $_myrowRes['Serial'];
                }
                
                $_Serial_Val = $_Serial_Val + 1;

                $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 
                
                $Str_WKID = "WK/" . $_Serial_Val;
                $Str_UPLCode = $_SESSION["NewUPLCode"];
                
                $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
                
                $wk_id = $Str_WKID;
                $wk_name = $_POST["txtTaskName"];
                $wk_Owner = $_POST["cmbOwner"];
                $schedule = $_POST["cmbSchedule"];
                $sched_time = $_POST["cmbTime"];
                $start_time = $_POST["timepicker_start"];
                $end_time = $_POST["timepicker_end"];
                $report_owner = $_POST["cmbReportOwner"];
                $report_div = $_POST["cmbDiv"];
                $report_Dept = $_POST["cmbDpt"];
                $crt_date = "12/10/2011";
                $crt_by = $_SESSION["LogEmpCode"];
                
                $_strDivCode = $_POST["cmbSchedule"];
                
                $FacCode = $_POST["txtTaskID"];
                createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode);
                
                
                $_SESSION["Str_WKID"] = $Str_WKID;
                
                $_SESSION["Str_NEW"]       =   "TRUE";
                $_SESSION["Str_MOD"]       =   "TRUE";
                $_SESSION["Str_SAV"]       =   "FALSE";
                $_SESSION["Str_DEL"]       =   "FALSE";
                
                
                
                
            }
            
            if(isset($_GET['status']) && $_GET['status'] != ''){
                
                $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$id'";       
                $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
                
                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    $_Serial_Val	=   $_myrowRes['Serial'];
                }
                
            }
        
        ?>
        
        
        <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >

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
                                <div id="right" >
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr style="height: 50px; background-color: #E0E0E0;">
                                            <td style="padding-left: 10px; font-size: 16px">
                                                <font color="#0066FF">Assign Work Flow</font>                                              
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
                    <tr >
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
                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                ?>
                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" align="Right" height="30">
                            W/F ID
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30">
                            <input type="text" class="textboxStyle" name="txtTaskID" size="10" value="<?php echo $Str_WKID; ?>"></input>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" align="Right" height="30">
                            W/F Name
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30">
                            <input type="text"  class="textboxStyle" name="txtTaskName" size="60" value="<?php if(isset($_POST['txtTaskName'])) { echo $_POST['txtTaskName']; } ?>" ></input>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" align="Right" height="30">
                            Schedule
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30">
                            <select id="cmbSchedule" name="cmbSchedule" class="Div-TxtStyleNormal">
                                <option id="Daily" value="Daily">Daily</option>
                                <option id="Weekly" value="Weekly">Weekly</option>
                                <option id="Monthly" value="Monthly">Monthly</option>
                            </select>                            
                            <select id="cmbTime" name="cmbTime" class="Div-TxtStyleNormal">
                                <option id="Sunday" value="Sunday">Sunday</option>
                                <option id="Monday" value="Monday">Monday</option>
                                <option id="Tuesday" value="Tuesday">Tuesday</option>
                                <option id="Wednesday" value="Wednesday">Wednesday</option>
                                <option id="Thursday" value="Thursday">Thursday</option>
                                <option id="Friday" value="Friday">Friday</option>
                                <option id="Saturday" value="Saturday">Saturday</option>
                                <option id="1" value="1">1</option>
                                <option id="2" value="2">2</option>
                                <option id="3" value="3">3</option>
                                <option id="4" value="4">4</option>
                                <option id="5" value="5">5</option>
                                <option id="6" value="6">6</option>
                                <option id="7" value="7">7</option>
                                <option id="8" value="8">8</option>
                                <option id="9" value="9">9</option>
                                <option id="10" value="10">10</option>
                                <option id="11" value="11">11</option>
                                <option id="12" value="12">12</option>
                                <option id="13" value="13">13</option>
                                <option id="14" value="14">14</option>
                                <option id="15" value="15">15</option>
                                <option id="16" value="16">16</option>
                                <option id="17" value="17">17</option>
                                <option id="18" value="18">18</option>
                                <option id="19" value="19">19</option>
                                <option id="20" value="20">20</option>
                                <option id="21" value="21">21</option>
                                <option id="22" value="22">22</option>
                                <option id="23" value="23">23</option>
                                <option id="24" value="24">24</option>
                                <option id="25" value="25">25</option>
                                <option id="26" value="26">26</option>
                                <option id="27" value="27">27</option>
                                <option id="28" value="28">28</option>
                                <option id="29" value="29">29</option>
                                <option id="30" value="30">30</option>
                                <option id="31" value="31">31</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" align="Right" height="30">
                            Report Start Time
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30">
                            <input type="text" class="textboxStyle" name="timepicker_start" id="timepicker_start" size="15" value="<?php if(isset($_POST['timepicker_start'])) { echo $_POST['timepicker_start']; }?>"></input>                                                        
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" align="Right" height="30">
                            Report End Time
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30">
                            <input type="text" class="textboxStyle" name="timepicker_end" id="timepicker_end" size="15" value="<?php if(isset($_POST['timepicker_end'])) { echo $_POST['timepicker_end']; }?>"></input>                            
                        </td>
                    </tr>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#timepicker_start').timepicker({
                                showLeadingZero: true,
                                onHourShow: tpStartOnHourShowCallback,
                                onMinuteShow: tpStartOnMinuteShowCallback
                            });
                            $('#timepicker_end').timepicker({
                                showLeadingZero: true,
                                onHourShow: tpEndOnHourShowCallback,
                                onMinuteShow: tpEndOnMinuteShowCallback
                            });
                        });

                        function tpStartOnHourShowCallback(hour) {
                            var tpEndHour = $('#timepicker_end').timepicker('getHour');
                            // Check if proposed hour is prior or equal to selected end time hour
                            if (hour <= tpEndHour) { return true; }
                            // if hour did not match, it can not be selected
                            return false;
                        }
                        function tpStartOnMinuteShowCallback(hour, minute) {
                            var tpEndHour = $('#timepicker_end').timepicker('getHour');
                            var tpEndMinute = $('#timepicker_end').timepicker('getMinute');
                            // Check if proposed hour is prior to selected end time hour
                            if (hour < tpEndHour) { return true; }
                            // Check if proposed hour is equal to selected end time hour and minutes is prior
                            if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
                            // if minute did not match, it can not be selected
                            return false;
                        }

                        function tpEndOnHourShowCallback(hour) {
                            var tpStartHour = $('#timepicker_start').timepicker('getHour');
                            // Check if proposed hour is after or equal to selected start time hour
                            if (hour >= tpStartHour) { return true; }
                            // if hour did not match, it can not be selected
                            return false;
                        }
                        function tpEndOnMinuteShowCallback(hour, minute) {
                            var tpStartHour = $('#timepicker_start').timepicker('getHour');
                            var tpStartMinute = $('#timepicker_start').timepicker('getMinute');
                            // Check if proposed hour is after selected start time hour
                            if (hour > tpStartHour) { return true; }
                            // Check if proposed hour is equal to selected start time hour and minutes is after
                            if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
                            // if minute did not match, it can not be selected
                            return false;
                        }
                    </script>
                    <tr >
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
                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                ?>
                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                    
                    <tr >
                        <td width="30%" align="Right" height="30">
                            Report Division
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30">
                            <select id="cmbDiv" name="cmbDiv" onchange="getDepartments()" class="Div-TxtStyleNormal">>
                                <option id="0" selected="selected">Select Division</option>                                    
                                <option id="SL" value="SL" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "SL") { echo "selected='selected'"; }?>>SL</option>
                                <option id="US" value="US" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "US") { echo "selected='selected'"; }?>>US</option>
                                <option id="TI" value="TI" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "TI") { echo "selected='selected'"; }?>>TI &nbsp;&nbsp;</option>
								<option id="CN" value="CN" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "CN") { echo "selected='selected'"; }?>>CN &nbsp;&nbsp;</option>
								<option id="AU" value="AU" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "AU") { echo "selected='selected'"; }?>>AU &nbsp;&nbsp;</option>
								<option id="FIJI" value="FIJI" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "FIJI") { echo "selected='selected'"; }?>>FIJI &nbsp;&nbsp;</option>
                            </select>
                        </td>
                    </tr>   
                    
                    <tr >
                        <td width="30%" align="Right" height="30">
                            Report Departments
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        
                        <script type="text/javascript">
                            getDepartments();
                        </script>
                        
                        <td width="65%" align="left" height="30">
                            <select id="cmbDpt" name="cmbDpt" class="Div-TxtStyleNormal">
                                <option>Select Department</option>
                            </select>      
                            <input type="hidden" name="txtDpt" id="txtDpt" value="<?php if(isset($report_Dept)) echo $report_Dept; ?>"></input>
                        </td>
                        <p id="age"></p>
                    </tr>
                    <tr >
                        <td width="30%" align="Right" height="30">
                            Upload Support Documents
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30">
                            <fieldset style="padding-left: 0px;border: 0 0 0 0 "  id="fileUpload" >
                            <legend><strong></strong></legend>
                                <br>
                                <div id="fileUploadstyle">You have a problem with your javascript</div>
                                <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()">Clear Queue</a>
                                <p></p>                            
                            </fieldset>
                        </td>
                    </tr>                    
                    <tr>
                        <td width="30%" align="Right" height="30">
                            Work flow Alert List
                        </td>
                        <td width="1%" height="30">
                            &nbsp;:&nbsp;
                        </td>
                        <td width="65%" align="left" height="30"> 
                            <div class="demo">
                                <select name="lstSysUsers" size="10" id="lstSysUsers" style="width:160px" >                               
                                    <?php
                                        $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                            ?>
                                            <option value="<?php echo $_myrowRes['EmpCode']; ?>"> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
                                    <?php } ?>
                                </select>
                                
                                <input name="Save" class="demo" type="button"  id="Save" value=">" style="width: 40px; vertical-align: 500%; cursor: pointer" onclick="selectUser()"/>
                                <input name="Del"  class="demo" type="button"  id="Del" value="<" style="width: 40px; vertical-align: 500%; cursor: pointer;" onclick="removeUser()"/>                                   
                                    

                                <select name="lstFacUsers" size="10" class="" id="lstFacUsers" style="width:160px" >
                                    <option></option>                                
                                </select>     
                            </div>
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
                    <?php include ('../footer.php') ?>
                </div>
            </td>
        </tr>
    </table>
    <script>
        getWFDetails();
    </script>

            <br></br>
            <div class="demo">
                <br></br>
                <center>                            
                    <input type="submit"  value="New"  id="btn_New" name="btn_New" <?php if ($_SESSION["Str_NEW"] == "FALSE") echo "disabled=\"disabled\";" ?>/>
                    <input type="submit" value="Modify" id="btn_Modify" name="btn_Modify" <?php if ($_SESSION["Str_MOD"] == "FALSE") echo "disabled=\"disabled\";" ?>/>
                    <input type="button" value="Save" id="btn_Save" name="btn_Save" <?php if ($_SESSION["Str_SAV"] == "FALSE") echo "disabled=\"disabled\";" ?> onclick="startUpload()"/>
                    <input type="submit" value="Delete" id="btn_Delete" name="btn_Delete" <?php if ($_SESSION["Str_DEL"] == "FALSE") echo "disabled=\"disabled\";" ?>/>
                </center>
            </div>
            <br>
        <!--</fieldset>-->
        </br>
        
        <!--<fieldset class="fieldsetclass" style="padding-left: 10px;" id="WorkFlowList" >
        <legend><strong></strong></legend>-->
        
            <center>
            <h3 style="color: #666">Work Flow List</h3>
            </center>
            <hr></hr>
            <br></br>
            <div style="padding-left: 5px; padding-right: 5px" >
                <div class="demo" id="tblGrid">
                <!--    
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Task Name</th>
                            <th>Schedule</th>
                            <th>Create User</th>
                            <th>Status</th>
                            <th align="center">View</th>                                
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="center"><input type="submit" value="View"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="center"><input type="submit" value="View"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="center"><input type="submit" value="View"/></td>
                        </tr>
                        <div >
                        </div>
                    </tbody>
                </table>
                    -->
                </div>
            </br>
            </fieldset>
        </div>
    </div>
    </form>    
</body>
</html> 
