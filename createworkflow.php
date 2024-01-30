<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Crate Work Flow
 * Last Update      :   06/10/2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("../connection/sqlconnection.php"); //  connection file to the mysql database    
include ("../class/accesscontrole.php"); //  sql commands for the access controles
include ("../class/sql_empdetails.php"); //  connection file to the mysql database
include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
include ("../class/sql_wkflow.php");            //  connection file to the mysql database
include ("../class/workFlowUpload.php");    //File Upload
//include ("../class/sql_getKJRWorkFlow.php");

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
	
    <style type="text/css">
		/* preloader DIV-Styles*/
		#preloader { 
			display:none; /* Hide the DIV */
			position:fixed;  
			_position:absolute; /* hack for internet explorer 6 */  
			height:585px;  
			width:675px;  
			background:#FFFFFF;  
			left: 350px;
			top: 10px;
			z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
			margin-left: 15px;  
			
			/* additional features, can be omitted */
			border:2px solid #06F;      
			padding:15px;  
			font-size:15px;  
			-moz-box-shadow: 0 0 5px #ff0000;
			-webkit-box-shadow: 0 0 5px #ff0000;
			box-shadow: 0 0 5px #ff0000;
			
		}
		
		#container {
			background: #d2d2d2; /*Sample*/
			width:100%;
			height:100%;
		}
		
		a{  
		cursor: pointer;  
		text-decoration:none;  
		} 
		
		/* This is for the positioning of the Close Link */
		#popupBoxClose {
			font-size:20px;  
			line-height:15px;  
			right:5px;  
			top:5px;  
			position:absolute;  
			color:#F00;  
			font-weight:500;      
		}
		</style>   
    
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
    <script type="text/javascript" src="../js/jquery.leanModal.min.js"></script>
 
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>
    <script type="text/javascript" src="../js/jquery.fileupload.js"></script> 
    <script type="text/javascript" src="../js/jquery.ui.widget.js"></script> 

    <!-- ****************END***************** -->
    <script type="text/javascript">

       /*  var queueSize = 0;

        function startUpload(){   
                   
            var valdator = true;
            //valdator = $("#frm_WorkFlow").valid();
            if(valdator != false){
                if (queueSize == 0) {
                    alert("No Any Files to Upload!");
                    document.forms['frm_WorkFlow'].action = "workflow/createworkflow.php?btn_Save=btn_Save";
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
        });*/       
    </script> 
    
    <script>
		$(function() {
	            $( "input:submit", ".demo" ).button();
	            $( "input:button", ".demo" ).button();
		});
	        
	    $(document).ready(function() {
	        $('#example').dataTable();
	    } );
        
        var queueSize = 0;

        /* function startUpload(){
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
        } */
        function startUpload(){   
                   
                   var valdator = true;
                   //valdator = $("#frm_WorkFlow").valid();
                   if(valdator != false){
                       if (queueSize == 0) {
                           document.forms['frm_WorkFlow'].action = "../workflow/createworkflow.php?btn_Save=btn_Save";
                           document.forms['frm_WorkFlow'].submit();
                       }else{                    
                           $('#fileUploadstyle').fileUploadStart();
                       }
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
                }
            )            
        }
        
        function removeUser(){            
            $.post('get_Departments.php',{removeUser : frm_WorkFlow.lstFacUsers.value},
                function(output){                    
                    $('#lstFacUsers').html(output);   
                }
            )            
        }
               
        function selectcoveringUser(){   
            var w = frm_WorkFlow.lstcovSysUsers.selectedIndex;
            var x=frm_WorkFlow.cmbReportOwner.value;
           
            $.post('get_Departments.php',{selectcoveringUser : frm_WorkFlow.lstcovSysUsers.value , UserName : frm_WorkFlow.lstcovSysUsers.options[w].text, Owner : frm_WorkFlow.cmbReportOwner.value},
                function(output){                    
                    $('#lstcovFacUsers').html(output);
                }
            )            
        }
        
        function removecoveringUser(){            
            $.post('get_Departments.php',{removecoveringUser : frm_WorkFlow.lstcovFacUsers.value},
                function(output){                    
                    $('#lstcovFacUsers').html(output);   
                }
            )            
        }

        function getWFDetails(){     
            $.post('get_Departments.php',{wfuser : frm_WorkFlow.cmbOwner.value},
                function(output){  
                    //alert(output);
                    $('#tblGrid').html(output);                    
                }
            ),				 	
            $.post('../class/sql_getKJR.php',{wfuser : frm_WorkFlow.cmbOwner.value},			
                function(output){ 						                 
                    $('#kjrcode').html(output);
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
		
		
		 function delcheck(workid, empCode){  
		 	   var wemp = frm_WorkFlow.cmbOwner.value;	
			   $('#tblGrid input[type=checkbox]:checked').each(function() {
				 currentVal  = $(this).val();
                 console.log("Ela");
                 console.log(currentVal);
                 console.log(empCode);
					$.post('get_Departments.php',{delcheck : currentVal, wk_Owner : empCode})
					$.post('get_Departments.php',{wfuser : wemp},
						function(output){ 
							$('#tblGrid').html(output); 
							refreshList();							   
						}
				   )
				}); 
			
		 }
	
        
    </script> 
    
    <script type="text/javascript">
     $(window).load(function() { 
         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
    }); 
    $(document).ready( function() {
    
        // When site loaded, load the Popupbox First
        //loadPopupBox();
    
        $('#popupBoxClose').click( function() {            
            unloadPopupBox();
        });
        
        $('#container').click( function() {
            unloadPopupBox();
        });

             
    });
	
	function unloadPopupBox() {    // TO Unload the Popupbox
            $('#preloader').fadeOut("slow");
            $("#container").css({ // this is just for style        
                "opacity": "1"  
            });
			var wemp = frm_WorkFlow.cmbOwner.value;
			$.post('get_Departments.php',{wname : wemp},
				function(output){ 								      
					$('#tblGrid').html(output); 
					refreshList();                  
				}
			)  
        }    
        
        function loadPopupBox() {    // To Load the Popupbox
            $('#preloader').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "0.3"  
            });         
        }   
	
	function OpenEditWindow(workid, empCode){
        
			loadPopupBox();				
			$('#EditWorkFlow').attr('src', 'Editworkflow.php?id='+workid+'&empCode='+empCode+'')
	}
</script>  
    <script type="text/javascript">	
			
		 function getKjr(){ 
		 	kjrid = document.getElementById('kjrcode').value;		 	
            $.post('../class/sql_getKJR.php',{kjrdata : frm_WorkFlow.kjrcode.value},			
                function(output){ 						                 
                    $('#indicatorcode').html(output);
                }
            )            
        }
         function getIndicator(){           
		 	indid = document.getElementById('indicatorcode').value;			 	
            $.post('../class/sql_getKJR.php',{inddata : frm_WorkFlow.indicatorcode.value},			
                function(output){ 						                 
                    $('#subindicatorcode').html(output);
                }
            )            
        }
		
			
		function SendNewMobileNotification(empCode,message,title,workflowId)
		{
						
			$.ajax({
        url: 'http://69.63.218.233:86/PMS/service/PushNotificationForNewWorkflow.php',
        type: 'get',
        dataType: "json",
        data: {
            EmpCode: empCode,
            Message: message,
            Title: title,
			wfId: workflowId
        }
    }).done(function(data){
             alert("Notification sent");
    });
       
		}
		
	</script> 

    
</head>
    <body><div id="preloader"></div>
        <div id="preloader">    <!-- OUR PopupBox DIV-->
            <iframe id="EditWorkFlow" width="675px"  height="585px" frameborder="0" scrolling="yes"></iframe>
            <a id="popupBoxClose">Close(X)</a>    
        </div>
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
            $_POST["kjrcode"] = "";
            $_POST["indicatorcode"] = "";
			$_POST["subindicatorcode"] = "";
			
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
                
                $bool_ReadOnly = "False";
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
                
                $wk_name = mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskName"]);
                $wk_Owner = $_POST["cmbOwner"];
                $schedule = $_POST["cmbSchedule"];
                $sched_time = $_POST["cmbTime"];
                $start_time = $_POST["timepicker_start"];
                $end_time = $_POST["timepicker_end"];
                $report_owner = $_POST["cmbReportOwner"];
                $report_div = $_POST["cmbDiv"];
                $report_Dept = $_POST["cmbDpt"];
                $crt_date = date("Y-m-d");
                $crt_by = $_SESSION["LogEmpCode"];
                $wfcategory = $_POST["cmbwfcat"];
				$kjrid = $_POST["kjrcode"];
				$kpiid = $_POST["indicatorcode"];
				$activityid = $_POST["subindicatorcode"];
                
				
				$WF_Desc = mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskDesc"]);
                
                $_strDivCode = $_POST["cmbSchedule"];
                
                $FacCode = $_POST["txtTaskID"];
                
                $_strEMPCODE = $wk_Owner;
				
				/*$path= "files/".$HTTP_POST_FILES['ufile']['name'];
				if($ufile !=none)
				{
					if(copy($HTTP_POST_FILES['ufile']['tmp_name'], $path))
					{
					}
				}*/
				
				$isNotDuplicate = isWorkflowNotDuplicate($str_dbconnect,$wk_name, $wk_Owner, $schedule, $sched_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $wfcategory, $WF_Desc);
                
                if($schedule != "Weekly" && $isNotDuplicate){ 
                    $countfiles = count($_FILES['file']['name']);
                    for($i=0;$i<$countfiles;$i++){
                        fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                    } 
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'" or die(mysqli_error($str_dbconnect));
                    $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }
                    

                    $_Serial_Val = $_Serial_Val + 1;
                    echo "save1";
                    $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'" or die(mysqli_error($str_dbconnect));
                    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 

                    $Str_WKID = "WK/" . $_Serial_Val;
                    $Str_UPLCode = $_SESSION["NewUPLCode"];
                    echo "save2";
                    $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                    $wk_id = $Str_WKID;
					
                    createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                   
                    echo "save3";
                }
                
                if($schedule == "Weekly" && $isNotDuplicate){
                    if(isset($_POST["Sunday"])){
                        $countfiles = count($_FILES['file']['name']);
                        for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                        } 
                        
                        $_Serial_Val    =   -1;
                        $_CompCode      =   "CIS";

                        $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            $_Serial_Val =   $_myrowRes['Serial'];
                        }

                        $_Serial_Val = $_Serial_Val + 1;
                        echo "save4";
                        $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'" or die(mysqli_error($str_dbconnect));
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 

                        $Str_WKID = "WK/" . $_Serial_Val;
                        $Str_UPLCode = $_SESSION["NewUPLCode"];
                        echo "save5";
                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        $wk_id = $Str_WKID;
                        
                        $sched_time = $_POST["Sunday"]; 
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                       
                        echo "save6";
                    }
                    
                    if(isset($_POST["Monday"])){
                        $countfiles = count($_FILES['file']['name']);
                        for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                        }                     
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
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
                    }
                    
                    if(isset($_POST["Tuesday"])){
                        $countfiles = count($_FILES['file']['name']);
                        for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                        }                       
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
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                       
                    }
                    
                    if(isset($_POST["Wednesday"])){
                        $countfiles = count($_FILES['file']['name']);
                        for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                        }                       
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
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
                    }
                    
                    if(isset($_POST["Thursday"])){
                        $countfiles = count($_FILES['file']['name']);
                        for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                        }                        
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
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
                    }
                    
                    if(isset($_POST["Friday"])){
                        $countfiles = count($_FILES['file']['name']);
                        for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                        }                        
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
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
                    }
                    
                    if(isset($_POST["Saturday"])){
                        $countfiles = count($_FILES['file']['name']);
                        for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);    
                        }                     
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
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
                    }                    
                }    
                
                $_SESSION["Str_WKID"] = $Str_WKID;
                
                $_SESSION["Str_NEW"]       =   "TRUE";
                $_SESSION["Str_MOD"]       =   "TRUE";
                $_SESSION["Str_SAV"]       =   "FALSE";
                $_SESSION["Str_DEL"]       =   "FALSE";
                
                $_SelectQuery 	= "DELETE FROM tbl_wfalert WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
                mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
				
				$workflowId = $Str_WKID;
			    $empcode = $wk_Owner;
			    $Message = $wk_name ;
			    $title = "You have new workflow";
		 	    echo '<script type="text/javascript">SendNewMobileNotification("'.$empcode.'","'.$Message.'","'.$title.'","'.$workflowId.'");</script>';
                 
            }
            
            if (isset($_GET['btn_Save'])) {                
                
                $wk_name = mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskName"]);
                $wk_Owner = $_POST["cmbOwner"];
                $schedule = $_POST["cmbSchedule"];
                $sched_time = $_POST["cmbTime"];
                $start_time = $_POST["timepicker_start"];
                $end_time = $_POST["timepicker_end"];
                $report_owner = $_POST["cmbReportOwner"];
                $report_div = $_POST["cmbDiv"];
                $report_Dept = $_POST["cmbDpt"];
                //$crt_date = "12/10/2011";
                $crt_date = date("Y-m-d H:i:s");
                $crt_by = $_SESSION["LogEmpCode"];
                $wfcategory = $_POST["cmbwfcat"];
				$kjrid = $_POST["kjrcode"];
				$kpiid = $_POST["indicatorcode"];
				$activityid = $_POST["subindicatorcode"];

				$WF_Desc = mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskDesc"]);
				
                $_strDivCode = $_POST["cmbSchedule"];
                
                $FacCode = $_POST["txtTaskID"];
                
                $_strEMPCODE = $wk_Owner;	
				
				$_CrtBy         =	$_SESSION["LogEmpCode"];
    			$Dte_CrtDate    = 	date("Y/m/d") ;			
                
				$isNotDuplicate = isWorkflowNotDuplicate($str_dbconnect,$wk_name, $wk_Owner, $schedule, $sched_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $wfcategory, $WF_Desc);
				
                if($schedule != "Weekly" && $isNotDuplicate){ 
                   
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

                    $countfiles = count($_FILES['file']['name']);
                    
                    for($i=0;$i<$countfiles;$i++){
                        fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                    } 
/* 
                    $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); */

                    $wk_id = $Str_WKID;
                    createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                    
                    //FIle upload

                }
                
                if($schedule == "Weekly" && $isNotDuplicate){
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

                        $countfiles = count($_FILES['file']['name']);
                            for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                        } 
                        /*$_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                    

                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
						
						/* $_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                         while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            echo "Sunday while";
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));									                     
                        }  */

                        $wk_id = $Str_WKID;
                        
                        $sched_time = $_POST["Sunday"]; 
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
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

                        $countfiles = count($_FILES['file']['name']);
                            for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                        } 
                       /* $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            echo "Monday while";
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	          
                        } 
 */
                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Monday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
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

                        $countfiles = count($_FILES['file']['name']);
                            for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                        } 
                       /* $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            echo "Monday while";
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	          
                        } 
 */
                        $wk_id = $Str_WKID;
                        $sched_time = $_POST["Tuesday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
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

                        $countfiles = count($_FILES['file']['name']);
                            for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                        } 
                       /* $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            echo "Monday while";
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	          
                        } 
 */
                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Wednesday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
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

                        $countfiles = count($_FILES['file']['name']);
                            for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                        } 
                       /* $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            echo "Monday while";
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	          
                        } 
 */
                        $wk_id = $Str_WKID;
                        $sched_time = $_POST["Thursday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
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

                        $countfiles = count($_FILES['file']['name']);
                            for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                        } 
                       /* $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            echo "Monday while";
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	          
                        } 
 */
                        $wk_id = $Str_WKID;
                        $sched_time = $_POST["Friday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
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

                        $countfiles = count($_FILES['file']['name']);
                            for($i=0;$i<$countfiles;$i++){
                            fileUploadNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i],$_Serial_Val,$Str_WKID);    
                        } 
                       /* $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        $_SelectQuery   =   "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
                        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
						
						$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''" or die(mysqli_error($str_dbconnect));
                        $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            echo "Monday while";
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    						mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));	          
                        } 
 */
                        $wk_id = $Str_WKID;
     
                        $sched_time = $_POST["Saturday"];
                        createworkflow($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc,$kjrid,$kpiid,$activityid);
                        
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
                
				$workflowId = $Str_WKID;
			    $empcode = $wk_Owner;
			    $Message = $wk_name ;
			    $title = "You have new workflow";
		 	    echo '<script type="text/javascript">SendNewMobileNotification("'.$empcode.'","'.$Message.'","'.$title.'","'.$workflowId.'");</script>';
                echo("<script>location.href = '../workflow/createworkflow.php';</script>");
                
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
                                                <table width="100%" cellpadding="0" cellspacing="8px">        
                                                    <tr >
                                                        <td width="20%" align="left">
                                                            Work Flow Owner
                                                        </td>
                                                        <td width="2%" >
                                                            :
                                                        </td>
                                                        <td align="left" >
                                                            <select id="cmbOwner" name="cmbOwner" class="TextBoxStyle" onchange="getWFDetails()">
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
                                                            Covering Person
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left"> 
                                                            <div class="demo">
                                                                <select name="lstcovSysUsers" size="10" id="lstcovSysUsers" style="width:160px" >                               
                                                                    <?php
                                                                        $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
                                                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                            ?>
                                                                            <option value="<?php echo $_myrowRes['EmpCode']; ?>"> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
                                                                    <?php } ?>
                                                                </select>

                                                                <input name="Save" class="demo" type="button"  id="Save" value=">" style="width: 40px; vertical-align: 500%; cursor: pointer" onclick="selectcoveringUser()"/>
                                                                <input name="Del"  class="demo" type="button"  id="Del" value="<" style="width: 40px; vertical-align: 500%; cursor: pointer;" onclick="removecoveringUser()"/>                                   


                                                                <select name="lstcovFacUsers" size="10" class="" id="lstcovFacUsers" style="width:160px" >
                                                                    <option></option>                                
                                                                </select>     
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>

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
                                                    <td >
                                                        KJR Code
                                                    </td>
                                                    <td >:</td>
                                                    <td> 
                                                        <select name="kjrcode" id="kjrcode" style="width:250px" class="TextBoxStyle"  onChange="getKjr();">  </select>  
                                                                                                  
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td > 		
                                                        KPI 
                                                    </td>
                                                    <td >:</td>
                                                    
                                                    <script type="text/javascript">
                                                            getKjr();
                                                     </script>
                                                     <td> 
                                                     	<select id="indicatorcode" name="indicatorcode" style="width:250px" class="TextBoxStyle" onChange="getIndicator();">						</select>     
                                                          <input type="hidden" name="txtindicatorcode" id="txtindicatorcode" value=""></input>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td >
                                                        Activity 
                                                    </td>
                                                    <td >:</td>
                                                    
                                                    <script type="text/javascript">
                                                            getIndicator();
                                                     </script>
                                                     <td> 
                                                     	                                                     
                                                     	<select id="subindicatorcode" name="subindicatorcode" style="width:250px" class="TextBoxStyle" >						</select>    
                                                          <input type="hidden" name="txtindicatorcode" id="txtindicatorcode" value=""></input>                                                           
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
                                                            Report Owner
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
																<option id="UK" value="UK" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "UK") { echo "selected='selected'"; }?>>UK &nbsp;&nbsp;</option>
																<option id="MLD" value="MLD" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "MLD") { echo "selected='selected'"; }?>>MLD &nbsp;&nbsp;</option>
																<option id="CN" value="CN" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "CN") { echo "selected='selected'"; }?>>CN &nbsp;&nbsp;</option>
																<option id="AU" value="AU" <?php if(isset($_POST['cmbDiv']) && $_POST['cmbDiv'] == "AU") { echo "selected='selected'"; }?>>AU &nbsp;&nbsp;</option>
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
                                                           <!-- <fieldset style="padding-left: 0px;border: 0 0 0 0 "  id="fileUpload" name="fileUpload" >
								                            <legend><strong></strong></legend>
								                                <br>
								                                <div id="fileUploadstyle">You have a problem with your javascript</div>
								                                <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()"> Clear Queue</a>
								                                <p></p>                            
								                            </fieldset>	 -->	
                                                            <!-- <input type="file" name="files" class="box"> -->
                                                            <input type="file" name="file[]" id="files" multiple>													
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
                                                                   <?php /*?> <input type="submit" value="Modify" id="btn_Modify" name="btn_Modify" <?php if ($_SESSION["Str_MOD"] == "FALSE") echo "disabled=\"disabled\";" ?>/><?php */?>
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
                    <?php include ('../footer.php') ?>
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
