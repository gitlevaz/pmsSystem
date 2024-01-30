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
$_SESSION["path"] = "../";
$path = "../";
$Menue	= "CreateWF";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS - WORK FLOW ::.</title>
    
    <link href="../css/styleB.css" rel="stylesheet" type="text/css" />
    
    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    
    <script type="text/javascript" src="../jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>    
    
  
    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />
	
	<script type="text/javascript" src="jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>
	<link rel="stylesheet" href="jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />
        
<!--    <script src="../ui/jquery.ui.core.js"></script>
    <script src="../ui/jquery.ui.widget.js"></script>-->
   
     <!--**************** NEW GRID ***************** -->

    <style type="text/css" title="currentStyle">
            @import "../media/css/demo_page.css";
            @import "../media/css/demo_table.css";
    </style>
    
    <script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>

    <!-- **************** NEW GRID END ***************** -->
    
    <!-- ************ FILE UPLOAD ********* -->

    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
   <!-- <script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>-->
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>

    <!-- ****************END***************** -->
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
    
    <script>
		$(function() {
	            $( "input:submit", ".demo" ).button();
	            $( "input:button", ".demo" ).button();
		});
	        
	    $(document).ready(function() {
	        $('#example').dataTable();
	    } );
        
        /*var queueSize = 0;

        function startUpload(){
            var valdator = false;
            valdator = $("#frm_WorkFlow").valid();
            if(valdator != false){
                if (queueSize == 0) {
                    //alert("No Any Files to Upload!");
                    document.forms['frm_WorkFlow'].action = "createworkflow.php?btnSave=btnSave";
                    document.forms['frm_WorkFlow'].submit();
                }
                $('#fileUploadstyle').fileUploadStart()
            }
        }*/
        
        function getDepartments(){            
            $.post('get_Departments.php',{id : frm_WorkFlow.cmbDiv.value},
                function(output){                      
                    $('#cmbDpt').html(output);
                }
            )            
        }
		
		function getUserWFTypes(){            
            $.post('get_Departments.php',{usertypelist: 'select', usercode : frm_WorkFlow.cmbOwner.value},
                function(output){                      
                    $('#cmbWFUserCat').html(output);					
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
					getUserWFTypes();                   
                }
            )            
        }
        
        function viewWKFID(wkfid){            
            document.forms['frm_WorkFlow'].action = "createworkflow.php?status=view&id=" + wkfid + "";
            document.forms['frm_WorkFlow'].submit();
        }
        
        function deleteWKFID(wkfid){    
			
			var answer = confirm("Do you want to Delete W/F ID : " + wkfid)
			if (answer){				 
	            document.forms['frm_WorkFlow'].action = "createworkflow.php?status=del&id=" + wkfid + "";
	            document.forms['frm_WorkFlow'].submit();
			}
			else{
				alert("Action Cancelled");
			}		
        }        
    </script>
    
    <script>
		$(function() {		
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
			$( "#dialog-modal" ).dialog({
				height: 400,
				width: 600,
				modal: true,
				autoOpen: false
			});
		});
		
		function ShowUpdateTask(WFID){			
			
			$( "#dialog-modal" ).dialog( "open" );	
			$('#txt_UpdateWFId').val(WFID);	
			$('#tblUpdateMessage').html(""); 
			//document.getElementsById('txt_UpdateWFId').Value = "dfgd"; 	
		}	
		
		function UpdateWFDetails(){ 
			var wfidsp = $('#txt_UpdateWFId').val();   
			var wfcatidsp = $('#cmbUpdateWFUserCat').val();
			
            $.post('get_Departments.php',{wftaskid : wfidsp, wftaskmcat : wfcatidsp},
                function(output){                   
                    $('#tblUpdateMessage').html(output); 	
					getWFDetails();				
                }
            ) 
			      
        }		
		
		
		function LoadWFOwners(){   
		
			var Act_User = "";	
			var Inact_User = "";			
			
		
			if(document.getElementById('chk_ActiveUsers').checked == true)
			{				
				Act_User = "A";	
			}
			
			if(document.getElementById('chk_InActiveUsers').checked == true)
			{
				Inact_User = "I";			
			}
			   
            $.post('get_Departments.php',{WFUserOld: 'select', ActiveUser : Act_User, InactiveUser : Inact_User},
                function(output){                      
                    $('#cmbOwner').html(output);					
                }
            )            
        }
		
	</script
    
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
			
			if (isset($_GET['status'])) {			
				if ($_GET['status'] == "del"){					
					$WKID = $_GET['id'];					
					DeleteWorkFlowDetails($str_dbconnect,$WKID);						
				}				
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
                
                $wk_Owner = $_POST["cmbOwner"];
                $_strEMPCODE = $wk_Owner;
				$_SESSION["strWFOwnerDet"] = $wk_Owner;
            }
            
            if (isset($_POST['btn_Save'])) {
                
//                $_Serial_Val    =   -1;
//                $_CompCode      =   "CIS";
//                
//                $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'" or die(mysqli_error($str_dbconnect));
//                $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
//
//                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
//                    $_Serial_Val =   $_myrowRes['Serial'];
//                }
//                
//                $_Serial_Val = $_Serial_Val + 1;
//
//                $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'" or die(mysqli_error($str_dbconnect));
//                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 
//                
//                $Str_WKID = "WK/" . $_Serial_Val;
//                
//                $Str_UPLCode = $_SESSION["NewUPLCode"];
//                
//                $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
//                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
//                
//                $wk_id = $Str_WKID;
//                $wk_name = $_POST["txtTaskName"];
//                $wk_Owner = $_POST["cmbOwner"];
//                $schedule = $_POST["cmbSchedule"];
//                $sched_time = $_POST["cmbTime"];
//                $start_time = $_POST["timepicker_start"];
//                $end_time = $_POST["timepicker_end"];
//                $report_owner = $_POST["cmbReportOwner"];
//                $report_div = $_POST["cmbDiv"];
//                $report_Dept = $_POST["cmbDpt"];
//                $crt_date = "12/10/2011";
//                $crt_by = "EMP/22";
//                $wfcategory = $_POST["cmbwfcat"];
//                
//                $_strDivCode = $_POST["cmbSchedule"];
//                
//                createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $wfcategory);
//                
//                
//                $_SESSION["Str_WKID"] = $Str_WKID;
//                
//                $_SESSION["Str_NEW"]       =   "TRUE";
//                $_SESSION["Str_MOD"]       =   "TRUE";
//                $_SESSION["Str_SAV"]       =   "FALSE";
//                $_SESSION["Str_DEL"]       =   "FALSE";
                
                $wk_name 	= mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskName"]);
                $wk_Owner 	= $_POST["cmbOwner"];
                $schedule 	= $_POST["cmbSchedule"];
                $sched_time = $_POST["cmbTime"];
                $start_time = $_POST["timepicker_start"];
                $end_time 	= $_POST["timepicker_end"];
                $report_owner 	= $_POST["cmbReportOwner"];
                $report_div		= $_POST["cmbDiv"];
                $report_Dept 	= $_POST["cmbDpt"];
                $crt_date 		= "12/10/2011";
                $crt_by 		= "EMP/22";
                $wfcategory 	= $_POST["cmbwfcat"];
				$WFUser_cat 	= $_POST["cmbWFUserCat"];
				
				$WF_Desc 		= mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskDesc"]);
                
                $_strDivCode 	= $_POST["cmbSchedule"];
                
                $FacCode = $_POST["txtTaskID"];
                
                $_strEMPCODE = $wk_Owner;
				$_SESSION["strWFOwnerDet"] = $wk_Owner;
				
				/*$path= "files/".$HTTP_POST_FILES['ufile']['name'];
				if($ufile !=none)
				{
					if(copy($HTTP_POST_FILES['ufile']['tmp_name'], $path))
					{
					}
				}*/
                
                if($schedule != "Weekly"){ 
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
                    createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                }
                
                if($schedule == "Weekly"){
                    if(isset($_POST["Sunday"])){
                        
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
                        
                        $sched_time = $_POST["Sunday"]; 
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Monday"])){
                                                
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
     
                        $sched_time = $_POST["Monday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Tuesday"])){
                                                
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
     
                        $sched_time = $_POST["Tuesday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Wednesday"])){
                                                
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
     
                        $sched_time = $_POST["Wednesday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Thursday"])){
                                                
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
     
                        $sched_time = $_POST["Thursday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Friday"])){
                                                
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
     
                        $sched_time = $_POST["Friday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Saturday"])){
                                                
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
     
                        $sched_time = $_POST["Saturday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }                    
                }    
                
                $_SESSION["Str_WKID"] = $Str_WKID;
                
                $_SESSION["Str_NEW"]       =   "TRUE";
                $_SESSION["Str_MOD"]       =   "TRUE";
                $_SESSION["Str_SAV"]       =   "FALSE";
                $_SESSION["Str_DEL"]       =   "FALSE";
                
                $_SelectQuery 	= "DELETE FROM tbl_wfalert WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            }
            
            if (isset($_GET['btn_Save'])) {                
                
                $wk_name 	= mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskName"]);
                $wk_Owner 	= $_POST["cmbOwner"];
                $schedule 	= $_POST["cmbSchedule"];
                $sched_time = $_POST["cmbTime"];
                $start_time = $_POST["timepicker_start"];
                $end_time 	= $_POST["timepicker_end"];
                $report_owner 	= $_POST["cmbReportOwner"];
                $report_div 	= $_POST["cmbDiv"];
                $report_Dept 	= $_POST["cmbDpt"];
                $crt_date 		= "12/10/2011";
                $crt_by 		= "EMP/22";
                $wfcategory 	= $_POST["cmbwfcat"];
                
				$WF_Desc 		= mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskDesc"]);
				
                $_strDivCode 	= $_POST["cmbSchedule"];
                
                $FacCode 		= $_POST["txtTaskID"];
				$WFUser_cat 	= $_POST["cmbWFUserCat"];
                
                $_strEMPCODE 	= $wk_Owner;	
				
				$_CrtBy         =	$_SESSION["LogEmpCode"];
    			$Dte_CrtDate    = 	date("Y/m/d") ;			
                
                if($schedule != "Weekly"){ 
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
                    createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                }
                
                if($schedule == "Weekly"){
                    if(isset($_POST["Sunday"])){
                        
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

                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));									                     
                        }

                        $wk_id = $Str_WKID;
                        
                        $sched_time = $_POST["Sunday"]; 
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Monday"])){
                                                
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

                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	          
                        }

                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Monday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Tuesday"])){
                                                
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

                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	        
                        }

                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Tuesday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Wednesday"])){
                                                
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

                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$tCreateBy', '$tCreateDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));		       
                        }	

                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Wednesday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Thursday"])){
                                                
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

                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	
                        }

                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Thursday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Friday"])){
                                                
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

                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	             
                        }	

                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Friday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }
                    
                    if(isset($_POST["Saturday"])){
                                                
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

                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));								                          
                        }

                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Saturday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc, $WFUser_cat);
                    }                       
                }    
                
                $_SESSION["Str_WKID"] = $Str_WKID;
                
                $_SESSION["Str_NEW"]       =   "TRUE";
                $_SESSION["Str_MOD"]       =   "TRUE";
                $_SESSION["Str_SAV"]       =   "FALSE";
                $_SESSION["Str_DEL"]       =   "FALSE";
                
                $_SelectQuery 	= "DELETE FROM tbl_wfalert WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
				
				$Str_UPLCode = $_SESSION["NewUPLCode"];
				$_SelectQuery 	= "DELETE FROM prodocumets WHERE ProCode = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
                
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
	<div id="dialog-modal" title=".::Update W/F Task ::." align="center">
		<table width="100%" cellpadding="0" cellspacing="5" align="center">
			<tr>
				<td align="left">W/F ID</td>
				<td>:</td>
				<td align="left">
					<input type="text" class="TextBoxStyle" readonly="readonly" name="txt_UpdateWFId" id="txt_UpdateWFId" size="20" value=""></input>
				</td>
			</tr>
			<tr >
                <td align="left">
                    W/F Master Category
                </td>
                <td >
                    :
                </td>
                <td align="left" >
                    <select id="cmbUpdateWFUserCat" name="cmbUpdateWFUserCat" class="TextBoxStyle" style="height:25px;">
                        <?php
                            #	Get Designation details ...................																	
                            $_EmpCode       =   $_SESSION["LogEmpCode"];
                            $_ResultSet = getwfUsercategory($str_dbconnect,$_EmpCode) ;
                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                        ?>
                        <option value="<?php echo $_myrowRes['id']; ?>"  <?php if (isset($_POST["cmbWFUserCat"]) && $_myrowRes['id'] == $_POST["cmbWFUserCat"]){ echo "selected=\"selected\""; }?>> <?php echo $_myrowRes['Description']; ?> </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
			<td>
				<tr><td colspan="3"><br/></td></tr>
			</td>
			<tr>
				<td colspan="3" align="center">
					<div class="demo" id="tblUpdateMessage">
					
					</div>
				</td>
			</tr>
			<tr>
	            <td colspan="3">
	                <div class="demo">
	                    <br></br>
	                    <center>	                        
	                        <input type="button" value="Save" id="btn_Update" name="btn_Update" onclick="UpdateWFDetails()"/>	                        
	                    </center>
	                </div>
	            </td>
        	</tr>
		</table>	
	</div>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">
                <div id="wrapper">
                    <table width="100%" cellpadding="0" cellspacing="0">                        
                        <tr>
                            <!--border-left: 2px solid #063794; border-right: 2px solid #063794-->                            
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
                                                <table width="100%" cellpadding="0" cellspacing="8px">  
													 <tr>
                                                        <td align="left">
                                                           	Load User Details
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td width="65%" align="left" height="30">
                                                            <input type="checkbox" id="chk_ActiveUsers" name="chk_ActiveUsers" onclick="LoadWFOwners()" <?php if(isset($_POST['chk_ActiveUsers']) && $_POST['chk_ActiveUsers'] == true) { echo "checked='checked'"; }?> checked="checked">Active Users</input>
															<input type="checkbox" id="chk_InActiveUsers" name="chk_InActiveUsers" onclick="LoadWFOwners()" <?php if(isset($_POST['chk_InActiveUsers']) && $_POST['chk_InActiveUsers'] == true) { echo "checked='checked'"; }?>>Inactive Users</input>
															<script type="text/javascript">
																LoadWFOwners();
															</script>
                                                        </td>
                                                    </tr>      
                                                    <tr >
                                                        <td width="20%" align="left">
                                                            Work Flow Owner
                                                        </td>
                                                        <td width="2%" >
                                                            :
                                                        </td>
                                                        <td align="left" >															
                                                            <select id="cmbOwner" name="cmbOwner" class="TextBoxStyle" onchange="getWFDetails()" >
                                                                <?php
                                                                   /* #	Get Designation details ...................																	
                                                                    $_EmpCode       =   $_SESSION["LogEmpCode"];
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {*/
                                                                ?>
                                                                <!--<option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>-->
                                                                <?php /*}*/ ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            W/F ID
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td width="65%" align="left" height="30">
                                                            <input type="text" class="TextBoxStyle" name="txtTaskID" size="10" value="<?php echo $Str_WKID; ?>"></input>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            W/F Name
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
															<textarea id="txtTaskName" name="txtTaskName" class="TextAreaStyle" cols="40" rows="4"><?php if(isset($_POST['txtTaskName'])) { echo $_POST['txtTaskName']; } ?></textarea>                                                            
                                                        </td>
                                                    </tr>
													<tr>
                                                        <td align="left">
                                                            W/F Description
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
															<textarea id="txtTaskDesc" name="txtTaskDesc" cols="40" rows="4" class="TextAreaStyle"><?php if(isset($_POST['txtTaskDesc'])) { echo $_POST['txtTaskDesc']; } ?></textarea>  
                                                            <!--<input type="text"  class="TextBoxStyle" name="txtTaskName" size="60" value="<?php if(isset($_POST['txtTaskName'])) { echo $_POST['txtTaskName']; } ?>" ></input>-->
                                                        </td>
                                                    </tr>
													<tr >
                                                        <td width="20%" align="left">
                                                            W/F Master Category
                                                        </td>
                                                        <td width="2%" >
                                                            :
                                                        </td>
                                                        <td align="left" >
                                                            <select id="cmbWFUserCat" name="cmbWFUserCat" class="TextBoxStyle">
                                                                <?php
                                                                    #	Get Designation details ...................																	
                                                                    $_EmpCode       =   $_SESSION["LogEmpCode"];
                                                                    $_ResultSet = getwfUsercategory($str_dbconnect,$_EmpCode) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['id']; ?>"  <?php if (isset($_POST["cmbWFUserCat"]) && $_myrowRes['id'] == $_POST["cmbWFUserCat"]){ echo "selected=\"selected\""; }?>> <?php echo $_myrowRes['Description']; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            W/F Category
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <select id="cmbwfcat" name="cmbwfcat" class="TextBoxStyle">
                                                                <?php                                    
                                                                    $_ResultSet = getwfcategory($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['catcode']; ?>"  <?php if ($_myrowRes['category'] == $_strEMPCODE) //echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['category'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>                    
                                                    <tr>
                                                        <td align="left">
                                                            Schedule
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <select id="cmbSchedule" name="cmbSchedule" class="TextBoxStyle">
                                                                <option id="Daily" value="Daily">Daily</option>
                                                                <option id="Weekly" value="Weekly">Weekly</option>
                                                                <option id="Monthly" value="Monthly">Monthly</option>
                                                            </select>                            
                                                            <select id="cmbTime" name="cmbTime" class="TextBoxStyle">                                                                
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
                                                        <td></td>
                                                        <td>:</td>
                                                        <td>
                                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td><input type="checkbox" id="Sunday" name="Sunday" value="Sunday" >Sunday</input></td>                                                                
                                                                    <td><input type="checkbox" id="Monday" name="Monday" value="Monday" >Monday</input></td>                                                                
                                                                    <td><input type="checkbox" id="Tuesday" name="Tuesday" value="Tuesday" >Tuesday</input></td>                                                                
                                                                    <td><input type="checkbox" id="Wednesday" name="Wednesday" value="Wednesday" >Wednesday</input></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" id="Thursday" name="Thursday" value="Thursday" >Thursday</input></td>                                                                
                                                                    <td><input type="checkbox" id="Friday" name="Friday" value="Friday" >Friday</input></td>                                                                
                                                                    <td><input type="checkbox" id="Saturday" name="Saturday" value="Saturday" >Saturday</input></td>                                                                    
                                                                    <td></td>
                                                                </tr> 
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            Report Start Time
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <input type="text" class="TextBoxStyle" name="timepicker_start" id="timepicker_start" size="15" value="<?php if(isset($_POST['timepicker_start'])) { echo $_POST['timepicker_start']; }?>"></input>                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            Report End Time
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <input type="text" class="TextBoxStyle" name="timepicker_end" id="timepicker_end" size="15" value="<?php if(isset($_POST['timepicker_end'])) { echo $_POST['timepicker_end']; }?>"></input>                            
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
                                                        <td align="left">
                                                             Reporting Person
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <select id="cmbReportOwner" name="cmbReportOwner" class="TextBoxStyle">
                                                                <?php
                                                                    #	Get Designation details ...................
                                                                    $_EmpCode       =   $_SESSION["LogEmpCode"];
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>                    
                                                    <tr >
                                                        <td align="left">
                                                            Report Division
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <select id="cmbDiv" name="cmbDiv" onchange="getDepartments()" class="TextBoxStyle">
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
                                                        <td align="left">
                                                            Report Departments
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>

                                                        <script type="text/javascript">
                                                            getDepartments();
                                                        </script>

                                                        <td align="left">
                                                            <select id="cmbDpt" name="cmbDpt" class="TextBoxStyle">
                                                                <option>Select Department</option>
                                                            </select>      
                                                            <input type="hidden" name="txtDpt" id="txtDpt" value="<?php if(isset($report_Dept)) echo $report_Dept; ?>"></input>
                                                        </td>
                                                        <p id="age"></p>
                                                    </tr>
                                                    <tr >
                                                        <td align="left">
                                                            Upload Support Documents
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                           <fieldset style="padding-left: 0px;border: 0 0 0 0 "  id="fileUpload" name="fileUpload" >
								                            <legend><strong></strong></legend>
								                                <br>
								                                <div id="fileUploadstyle">You have a problem with your javascript</div>
								                                <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()"> Clear Queue</a>
								                                <p></p>                            
								                            </fieldset>															
                                                        </td>
                                                    </tr>                    
                                                    <tr>
                                                        <td align="left">
                                                            Work flow Alert List
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left"> 
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
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="demo">
                                                                <br></br>
                                                                <center>                            
                                                                    <input type="submit"  value="New"  id="btn_New" name="btn_New" <?php if ($_SESSION["Str_NEW"] == "FALSE") echo "disabled=\"disabled\";" ?>/>
                                                                    <input type="submit" value="Modify" id="btn_Modify" name="btn_Modify" <?php if ($_SESSION["Str_MOD"] == "FALSE") echo "disabled=\"disabled\";" ?>/>
                                                                    <input type="button" value="Save" id="btn_Save" name="btn_Save" <?php if ($_SESSION["Str_SAV"] == "FALSE") echo "disabled=\"disabled\";" ?> onclick="startUpload()"/>
                                                                    <input type="submit" value="Delete" id="btn_Delete" name="btn_Delete" <?php if ($_SESSION["Str_DEL"] == "FALSE") echo "disabled=\"disabled\";" ?>/>
                                                                </center>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table> 
                                                
                                                <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td>
                                                            <center>
                                                                <h3 style="color: #666">Work Flow List</h3>
                                                            </center>
                                                            <hr></hr>
                                                            <br></br>
                                                            <div style="padding-left: 5px; padding-right: 5px">
                                                                <div class="demo" id="tblGrid">

                                                                </div>
                                                            </br>
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
        
    </table>
    <script>
        getWFDetails();
    </script>
</form>    
</body>
</html> 
