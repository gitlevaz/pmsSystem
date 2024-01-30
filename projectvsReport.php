<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Project Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization       //  connection file to the mysql database
//include ("class\accesscontrole.php");         //  sql commands for the access controles
include ("class/sql_project.php");              //  sql commands for the access controles
include ("class/sql_empdetails.php");           //  connection file to the mysql database
include ("class/sql_crtprocat.php");            //  connection file to the mysql database
//include ("class/sql_crtgroups.php");        //  sql commands for the access controles
include ("class/accesscontrole.php");          //  sql commands for the access controles

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "ProjectVsReport";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

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
       
    

    <script type="text/javascript" charset="utf-8">

       function getPageSize() {            
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );
            parent.resizeIframeToFitContent(height);
        }

        function Selection(){
            hlink = document.getElementById('txtGrpNote').value ;
            document.forms[0].action = "projectvsReport.php?&division="+hlink+"";
            document.forms[0].submit();
        }

        function DownloadFile(){

            hlink = document.getElementById('optDownload').value ;
            //alert(hlink);
			newwindow = window.open('','File Download');
            if (window.focus) {newwindow.focus()}
				return false;
		}

	function printDeleayedReport(){
				
				newwindow=window.open('class/rpt_PMSAgeAnalysis.php');
				if (window.focus) {newwindow.focus()}
					return false;
			}
        function printReport(){

            division		= 	document.getElementById('txtGrpNote').value;
			department		=	document.getElementById("optDepartment").value ;
			ProjectCategory =   document.getElementById("optCategory").value;
			empcode		    =	document.getElementById('optAssignUser').value ;
            proowner		=	document.getElementById('optInitUser').value ;
            prostatus		=	document.getElementById('optProStatus').value ;
            tskstatus		=	document.getElementById('optTskStatus').value ;
            StartDate		=	document.getElementById('txt_StartDate').value ;
            EndDate		    =	document.getElementById('txt_EndDate').value ;
			ProInit		    =	document.getElementById('ProinitUser').value ;
			
			newwindow=window.open('class/Print_projectstatusEmployee.php?division='+division+'&department='+department+'&catergory='+ProjectCategory+'&empcode='+empcode+'&proowner='+proowner+'&prostatus='+prostatus+'&StartDate='+StartDate+'&tskstatus='+tskstatus+'&EndDate='+EndDate+'&ProInit='+ProInit+'');
            if (window.focus) {newwindow.focus()}
				return false;
        }
		function printDelayReport(){


            division		= 	document.getElementById('txtGrpNote').value;
			department		=	document.getElementById("optDepartment").value ;
			empcode		    =	document.getElementById('optAssignUser').value ;
            proowner		=	document.getElementById('optInitUser').value ;
            prostatus		=	document.getElementById('optProStatus').value ;
            tskstatus		=	document.getElementById('optTskStatus').value ;
            StartDate		=	document.getElementById('txt_StartDate').value ;
            EndDate		    =	document.getElementById('txt_EndDate').value ;


			newwindow=window.open('class/Print_projectDelaystatus.php?division='+division+'&department='+department+'&empcode='+empcode+'&proowner='+proowner+'&prostatus='+prostatus+'&StartDate='+StartDate+'&tskstatus='+tskstatus+'&EndDate='+EndDate+'');
            if (window.focus) {newwindow.focus()}
				return false;
        }


    </script>

    <script type="text/javascript">
    
    var queueSize = 0;

    function startUpload(){
        var valdator = false;
        valdator = $("#frm_porject").valid();
        if(valdator != false){
            if (queueSize == 0) {
                //alert("No Any Files to Upload!");
                document.forms['frm_porject'].action = "project.php?btnSave=btnSave";
                document.forms['frm_porject'].submit();
            }
            $('#fileUploadstyle').fileUploadStart()
        }
    }

    $(document).ready(function() {

        $("#fileUploadstyle").fileUpload({
            'uploader': 'uploadify/uploader.swf',
            'cancelImg': 'uploadify/cancel.png',
            'script': 'uploadify/upload copy.php',
            'folder': 'files',
            'fileExt': '*.pdf;*.PDF;*.doc;*.DOC;*.docx;*.DOCX;*.xls;*.XLS;*.xlsx;*.XLSX;*.psd;*.PSD;*.ai;*.AI;*.zip;*.ZIP;*.rar;*.RAR;*.exe;*.EXE',
            'multi': true,
            'simUploadLimit': 1,
            'sizeLimit': 200000000,
            'displayData': 'speed',
            'width': 90,
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
                //alert('complete');
                //alert('There are ' + data.fileCount + ' files remaining in the queue.');
            },
            'onAllComplete' : function(event,data) {
                queueSize = 0;
                alert(data.filesUploaded + ' files uploaded successfully!');
                document.forms['frm_porject'].action = "project.php?btnSave=btnSave";
                document.forms['frm_porject'].submit();
            }}
        );

    });

    $().ready(function() {
        // validate signup form on keyup and submit
        $("#frm_porject").validate({
            onsubmit: false,
            rules: {
                txtProCode: {
				    required: false
			    },
                txtProName: {
				    required: true
			    },
                txt_StartDate: {
				    required: true
			    },
                txt_EndDate: {
				    required: true
			    }
            },
            messages: {
                txtProCode: "Please Enter a Project Name",
                txtProName: "Please Enter a Project Name",
                txt_StartDate: "Please Select the Start Date",
                txt_EndDate: "Please Select the End Date"
            }
        });
    });
	
	$(window).load(function() { 
         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
    });

</script>

</head>

    <body>
	<div id="preloader"></div>
    <?php

	


        $Str_ProCode    =   "";
        $Str_ProName    =   "";
        $Dte_Startdate  =   "";
        $Dte_Enddate    =   "";
        $bool_ReadOnly  =	"FALSE";
        $Save_Enable    =	"No";
        $ErrorString    =   "";

        $_strEMPCODE    =   "ALL";
        $_strDptCode    =   "ALL";
        $_strDivCode    =   "ALL";

        $_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);

        $_strProInit    =   "ALL";
        $fileUpload     =   "";
        $NewFileCode    =   "";
        $_strSecOwner   =   "";
        $_strSupport    =   "";

        if(isset($_GET["division"]))
        {
            $_strDivCode    = $_GET["division"];
            /*$Str_ProCode    = $_POST["txtProCode"];
            $Str_ProName    = $_POST["txtProName"];
            $Dte_Startdate  = $_POST["txt_StartDate"];
            $Dte_Enddate    = $_POST["txt_EndDate"];*/
            $_strEMPCODE    = $_POST["optAssignUser"];
            $_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
            $_strProInit    = $_POST["optInitUser"];
            /*$_strSecOwner   = $_POST["optSecondOwner"];
            $_strSupport    = $_POST["optSupporter"];*/

            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
        }


    ?>
	<form name="frm_porject" id="frm_porject" method="post" action="project.php" enctype="multipart/form-data" class="cmxform">
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
                                                <font color="#0066FF">Project Status</font>                                               
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
	                                                    <td width="20%">
	                                                        Division
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <select id="txtGrpNote" name="txtGrpNote" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> onchange="Selection();" class="TextBoxStyle">
								                                <option id="ALL" value="ALL" <?php if($_strDivCode == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
								                                <option id="SL" value="SL" <?php if($_strDivCode == "SL") echo "selected=\"selected\""; ?>>SL</option>
								                                <option id="US" value="US" <?php if($_strDivCode == "US") echo "selected=\"selected\""; ?>>US</option>
								                                <option id="TI" value="TI" <?php if($_strDivCode == "TI") echo "selected=\"selected\""; ?>>TI &nbsp;&nbsp;</option>
																<option id="UK" value="UK" <?php if($_strDivCode == "UK") echo "selected=\"selected\""; ?>>UK &nbsp;&nbsp;</option>
																<option id="MLD" value="MLD" <?php if($_strDivCode == "MLD") echo "selected=\"selected\""; ?>>MLD &nbsp;&nbsp;</option>
																<option id="CN" value="CN" <?php if($_strDivCode == "CN") echo "selected=\"selected\""; ?>>CN &nbsp;&nbsp;</option>
																<option id="AU" value="AU" <?php if($_strDivCode == "AU") echo "selected=\"selected\""; ?>>AU &nbsp;&nbsp;</option>
								                            </select>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                        Department
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <select id="optDepartment" name="optDepartment" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
								                                <option id="ALL" value="ALL" <?php if($_strDptCode == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
								                                <?php
								                                    #	Get Designation details ...................
								                                    //$_GrpCode       =   $_SESSION["EmpCode"];
								                                    //$_ResultSet = getGROUP($str_dbconnect);
								                                    while($_myrowRes = mysqli_fetch_array($_DepartmentSet)) {
								                                ?>
								                                <option value="<?php echo $_myrowRes['GrpCode']; ?>"  <?php if ($_myrowRes['GrpCode'] == $_strDptCode) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['Group']; ?> </option>
								                                <?php } ?>
								                            </select>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
														Project Category
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <select id="optCategory" name="catergory" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
															   <option value= "ALL">All</option>
															   <option value = "N/A">N/A</option>
								                               <option value="Regular">Reqular</option>
															   <option value = "Strategic">Strategic</option>
								                            </select>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                        Project Owner
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <select id="optInitUser" name="optInitUser" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
								                                <option id="ALL" value="ALL" <?php if($_strProInit == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
								                                <?php
								                                    #	Get Designation details ...................
								                                    //$_EmpCode        = $_SESSION["EmpCode"];
								                                    $_ResultSet      = getEMPLOYEEDETAILS($str_dbconnect) ;
								                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
								                                ?>
								                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strProInit) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
								                                <?php } ?>
								                            </select>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                        Task Owners
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <select id="optAssignUser" name="optAssignUser" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
								                                <option id="ALL" value="ALL" <?php if($_strEMPCODE == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
								                                <?php
								                                    #	Get Designation details ...................
								                                    //$_EmpCode       =   $_SESSION["EmpCode"];
								                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
								                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
								                                ?>
								                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
								                                <?php } ?>
								                            </select>
	                                                    </td>
	                                                </tr>
													<tr>
                                                    <td width="20%">
                                                        Initiated By
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="ProinitUser" name="ProinitUser" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
															<option id="ALL" value="ALL" <?php if($_strEMPCODE == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
							                                <?php
							                                    #	Get Designation details ...................
							                                    $_EmpCode        = $_SESSION["EmpCode"];
							                                    $_ResultSet      = getEMPLOYEEDETAILS($str_dbconnect) ;
							                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							                                ?>
							                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strProInit) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
							                                <?php } ?>
							                            </select>
                                                    </td>
                                                </tr> 
													<tr>
	                                                    <td width="20%">
	                                                        Project Status
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <select id="optProStatus" name="optProStatus" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>  class="TextBoxStyle">
								                                <option id="ALL" value="ALL" >ALL</option>
								                                <option id="I" value="I" >Not Started</option>
								                                <option id="A" value="A" >In Progress</option>
								                                <option id="W" value="W" >Completed Pending for Approvals</option>
								                                <option id="C" value="C" >Completed Approved</option>
								                                <option id="H" value="H" >Hold</option>
								                                <option id="S" value="S" >Suspend</option>
								                            </select>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                       Task Status
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <select id="optTskStatus" name="optTskStatus" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>  class="TextBoxStyle">
								                                <option id="ALL" value="ALL" >ALL</option>
								                                <option id="I" value="I" >Not Started</option>
								                                <option id="A" value="A" >In Progress</option>
								                                <option id="W" value="W" >Completed Pending for Approvals</option>
								                                <option id="C" value="C" >Completed Approved</option>
								                                <option id="H" value="H" >Hold</option>
								                                <option id="S" value="S" >Suspend</option>
								                            </select>
	                                                    </td>
	                                                </tr>
													<div id="timepicker"></div>
													<tr>
	                                                    <td width="20%">
	                                                       Project Start From Date
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <input  class="TextBoxStyle" type="text" id="txt_StartDate" name="txt_StartDate" size="15" value="ALL<?php //echo $Dte_Startdate; ?>" />
								                            <input  class="TextBoxStyle" name="StartDate" type="hidden" id="StartDate" value="..." class="buttonDot" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>
								
								                            <script type="text/javascript">
								                                $('#txt_StartDate').datepicker({
								                                    dateFormat:'yy-mm-dd'
								                                    });
								                            </script>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                       Project Start To Date
														   
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                        <input class="TextBoxStyle" type="text" id="txt_EndDate" name="txt_EndDate"  size="15" value="ALL<?php //echo $Dte_Enddate; ?>" />
								                            <input class="TextBoxStyle" name="EndDate" type="hidden" id="EndDate" value="..." <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>
								
								                            <script type="text/javascript">
								                                $('#txt_EndDate').datepicker({
								                                    dateFormat:'yy-mm-dd'
								                                    });
								                            </script>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td colspan="3"><br/></td>
	                                                </tr>
	                                                <tr>
	                                                    <td colspan="3" align="center">
	                                                        <table width="60%" cellpadding="0" cellspacing="0">
	                                                            <tr style="height: 50px; background-color: #E0E0E0;">
	                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">
	                                                                    <input name="btnSave" id="btnSave" type="button" class="submit"  value="View Report" style="width: 100px" onclick="printReport()"/>
                                										&nbsp;<input name="btnCancel" id="btnCancel" type="Reset"  value="Cancel" style="width: 60px" />
                                                                        <input name="btnDelay" id="btnDelay" type="button" class="submit"  value="View Delayed Tasks" style="width: 150px" onclick="printDeleayedReport()"/>
                                                                        <!--<input name="btndelay" id="btndelay" type="button" class="submit"  value="View Delay Report" style="width: 130px" onclick="printDelayReport()"/>-->
	                                                                </td>                                            
	                                                            </tr>
	                                                        </table>
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
                    <?php include ('footer.php') ?>
                </div>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
