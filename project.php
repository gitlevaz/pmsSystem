<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Project Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

if(!isset($_SESSION["LogUserName"]) || !isset($_SESSION["CompCode"])){
    echo "<script type='text/javascript'>";
    echo "parent.SessionLost();"; 
    echo "</script>";
}

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization       //  connection file to the mysql database
include ("class/accesscontrole.php");         //  sql commands for the access controles
include ("class/sql_project.php");              //  sql commands for the access controles
include ("class/sql_empdetails.php");           //  connection file to the mysql database
include ("class/sql_crtprocat.php");            //  connection file to the mysql database
include ("uploadify/upload copy.php");  
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

$path = "";
$Menue	= "CrtProject";

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
    
    <style type="text/css">
        /*body { font-size: 70%; font-family: "Lucida Sans" }
        label { display: inline-block; width: 200px; }
        legend { padding: 0.5em; }
        fieldset fieldset label { display: block; }
        #commentForm { width: 500px; }
        #commentForm label { width: 250px; }
        #commentForm label.error, #commentForm button.submit { margin-left: 253px; }
        #signupForm { width: 670px; }
        #signupForm label.error {
            margin-left: 10px;
            width: auto;
            display: inline;
        }
        #newsletter_topics label.error {
            display: none;
            margin-left: 103px;
        }*/

    </style>

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
            document.forms[0].action = "project.php?&division="+hlink+"";
            document.forms[0].submit();
        }

        function DownloadFile(){

            hlink = document.getElementById('optDownload').value ;
            //alert(hlink);
			newwindow = window.open('','File Download');
            if (window.focus) {newwindow.focus()}
				return false;
		}
		
		$(window).load(function() { 
	         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
	    });

    </script>

    <script type="text/javascript">
    
    var queueSize = 0;

    function startUpload(){
        var valdator = "false";
        valdator = $("#frm_porject").valid();
        if(valdator != "false"){
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
            'width': 110,
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

</script>

</head>

    <body>
    <?php

        $Str_ProCode    =   "";
        $Str_ProCat     =   "";
        $Str_ProName    =   "";
        $Dte_Startdate  =   "";
        $Dte_Enddate    =   "";
        $bool_ReadOnly  =	"TRUE";
        $Save_Enable    =	"No";
        $ErrorString    =   "";
        $_strEMPCODE    =   "";
        $_strDptCode    =   "";
        $_strDivCode    =   "ALL";
        //$_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
		$_DepartmentSet = getAllDepartments($str_dbconnect);
        $_strProInit    =   "";
        $fileUpload     =   "";
        $NewFileCode    =   "";
        $_strSecOwner   =   "";
        $_strSupport    =   "";

        if(isset($_GET["division"]))
        {
            $_strDivCode    = $_GET["division"]; 
            $Str_ProCat     = $_POST["txtProCat"];
            $Str_ProName    = $_POST["txtProName"];
            $Dte_Startdate  = $_POST["txt_StartDate"];
            $Dte_Enddate    = $_POST["txt_EndDate"];
            $_strEMPCODE    = $_POST["optAssignUser"];
            $_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
            $_strProInit    = $_POST["optInitUser"];
            $_strSecOwner   = $_POST["optSecondOwner"];
            $_strSupport    = $_POST["optSupporter"];

            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
        }


        if(isset($_POST['btnAdd'])) {
            $bool_ReadOnly          =	"FALSE";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"N";
            $_SESSION["ProjectCode"]=   "";
            $NewFileCode            =   create_FileName($str_dbconnect);
            $_SESSION["NewUPLCode"] =   $NewFileCode;
            $_SESSION["UploadeFileCode"]    =   "";
            //echo "<div class='ui-state-highlight ui-corner-all' style='padding: 0 .7em;' id='msg' align='left'>*** Please Enter New Project Details</div>";
        }

        if(isset($_POST['btnCancel'])) {
            $bool_ReadOnly          =	"TRUE";
            $Save_Enable            =	"No";
            $_SESSION["DataMode"]   =	"";
            $_SESSION["ProjectCode"]= "";
        }

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
        if(isset($_GET["procode"]))
        {
                $_SESSION["ProjectCode"]    =  $_GET["procode"];
                $bool_ReadOnly              =	"TRUE";
                $Save_Enable                =	"No";
                $_SESSION["DataMode"]       =	"";
        }

        if(isset($_SESSION["ProjectCode"])  && $_SESSION["ProjectCode"] <> ""){
            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_SESSION["ProjectCode"]);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode    = $_myrowRes['procode'];
                $Str_ProCat     = $_myrowRes['proCat'];
                $Str_ProName    = $_myrowRes['proname'];
                $Dte_Startdate  = $_myrowRes['startdate'];
                $Dte_Enddate    = $_myrowRes["EndDate"];
                $_strEMPCODE    = $_myrowRes["ProOwner"];
                $_strDivCode    = $_myrowRes["Division"];
                $_strDptCode    = $_myrowRes["Department"];
                $_strProInit    = $_myrowRes["ProInit"];
                $_strSecOwner   = $_myrowRes["SecOwner"];
                $_strSupport    = $_myrowRes["Support"];		
                //new	
               $timepicker_start    = $_myrowRes["timepicker_start"];
               $timepicker_end      = $_myrowRes["timepicker_end"];
               $economic_value      = $_myrowRes["economic_value"];
               $txtProPrio          = $_myrowRes["txtProPrio"];
               $project_description = $_myrowRes["project_description"];
               $kpis                = $_myrowRes["kpis"];			
            }
			 if(isset($_GET["division"]))
        	{
				$_strDivCode    = $_GET["division"];
			}
			$_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
        }

        if(isset($_POST['btnEdit'])) {
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"E";
            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_SESSION["ProjectCode"]);
                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                        // var_dump($_myrowRes); die();
                        $Str_ProCode    = $_myrowRes['procode'];
                        $Str_ProCat     = $_myrowRes['proCat'];
                        $Str_ProName    = $_myrowRes['proname'];
                        $Dte_Startdate  = $_myrowRes['startdate'];
                        $Dte_Enddate    = $_myrowRes["EndDate"];
                        $_strEMPCODE    = $_myrowRes["ProOwner"];
                        $_strDivCode    = $_myrowRes["Division"];
                        $_strDptCode    = $_myrowRes["Department"];
                        $_strProInit    = $_myrowRes["ProInit"];
                        $_strSecOwner   = $_myrowRes["SecOwner"];
                        $_strSupport    = $_myrowRes["Support"];	
                         //new	
                        $timepicker_start    = $_myrowRes["timepicker_start"];
                        $timepicker_end      = $_myrowRes["timepicker_end"];
                        $economic_value      = $_myrowRes["economic_value"];
                        $txtProPrio          = $_myrowRes["txtProPrio"];
                        $project_description = $_myrowRes["project_description"];
                        $kpis                = $_myrowRes["kpis"];			
                    }
            $NewFileCode            =   create_FileName($str_dbconnect);
            $_SESSION["NewUPLCode"] =   $NewFileCode;
            $_SESSION["UploadeFileCode"]    =   "";
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please update the Project Details</div>";
        }

        if(isset($_POST['btnDelete'])) {
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"D";
            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_SESSION["ProjectCode"]);
                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                        $Str_ProCode    = $_myrowRes['procode'];
                        $Str_ProCat     = $_myrowRes['proCat'];
                        $Str_ProName    = $_myrowRes['proname'];
                        $Dte_Startdate  = $_myrowRes['startdate'];
                        $Dte_Enddate    = $_myrowRes["EndDate"];
                        $_strEMPCODE    = $_myrowRes["ProOwner"];
                        $_strDivCode    = $_myrowRes["Division"];
                        $_strDptCode    = $_myrowRes["Department"];
                        $_strProInit    = $_myrowRes["ProInit"];
                        $_strSecOwner   = $_myrowRes["SecOwner"];
                        $_strSupport    = $_myrowRes["Support"];				
                    }
            $NewFileCode            =   create_FileName($str_dbconnect);
            $_SESSION["NewUPLCode"] =   $NewFileCode;
            $_SESSION["UploadeFileCode"]    =   "";
            echo "<div class='Div-Msg' id='msg' align='left'>*** Do you want to Continue deleting this Task. Please Click on SAVE</div>";
        } 

        if(isset($_GET['btnSave'])) {
       
            if($_POST["txtProName"] <> "" && $_POST["txt_StartDate"] <> "") {
                if($_SESSION["DataMode"] == "N"){
                    $Str_ProCode    = create_project($str_dbconnect,$_POST["txtProCat"],$_POST["txtProName"], $_POST["txt_StartDate"], $_POST["optAssignUser"], $_POST["txt_EndDate"], $_POST["optDepartment"], $_POST["txtGrpNote"],$_POST["optInitUser"],$_POST["optSecondOwner"],$_POST["optSupporter"],$_POST["timepicker_start"],$_POST["timepicker_end"],$_POST["economic_value"],$_POST["txtProPrio"],$_POST["project_description"],$_POST["kpis"]);
                    $filecount = count(array_filter($_FILES['file']['name']));
            
                    if($filecount!=0){
                        for($i=0;$i<$filecount;$i++){
                            fileUploadProjectNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$filecount, $Str_ProCode);    
                        }  
                    }
                    
                    $Str_ProCat     = $_POST["txtProCat"];
                    $Str_ProName    = $_POST["txtProName"];
                    $Dte_Startdate  = $_POST["txt_StartDate"];
                    $Dte_Enddate    = $_POST["txt_EndDate"];
                    $_strEMPCODE    = $_POST["optAssignUser"];
                    $_strDivCode    = $_POST["txtGrpNote"];
                    $_strDptCode    = $_POST["optDepartment"];
                    $_strProInit    = $_POST["optInitUser"];
                    $_strSecOwner   = $_POST["optSecondOwner"];
                    $_strSupport    = $_POST["optSupporter"];

                   // update_projectupload($str_dbconnect,$_SESSION["NewUPLCode"], $Str_ProCode);

                    //echo $_SESSION["NewUPLCode"];
                    
                    echo "<div class='Div-Msg' id='msg' align='left'>*** Project Created Successfully</div>";

                }elseif($_SESSION["DataMode"] == "E"){
                    $Str_ProCode    = $_POST["txtProCode"];
                    $Str_ProCat     = $_POST["txtProCat"];
                    $Str_ProName    = $_POST["txtProName"];
                    $Dte_Startdate  = $_POST["txt_StartDate"];
                    $Dte_Enddate    = $_POST["txt_EndDate"];
                    $_strEMPCODE    = $_POST["optAssignUser"];
                    $_strDivCode    = $_POST["txtGrpNote"];
                    $_strDptCode    = $_POST["optDepartment"];
                    $_strProInit    = $_POST["optInitUser"];
                    $_strSecOwner   = $_POST["optSecondOwner"];
                    $_strSupport    = $_POST["optSupporter"];
                    //new	
                    $timepicker_start    = $_POST["timepicker_start"];
                    $timepicker_end      = $_POST["timepicker_end"];
                    $economic_value      = $_POST["economic_value"];
                    $txtProPrio          = $_POST["txtProPrio"];
                    $project_description = $_POST["project_description"];
                    $kpis                = $_POST["kpis"];	

                    update_project($str_dbconnect,$_POST["txtProCode"],$_POST['txtProCat'] ,$_POST["txtProName"], $_POST["txt_StartDate"], $_POST["optAssignUser"], $_POST["txt_EndDate"], $_POST["optDepartment"], $_POST["txtGrpNote"],$_POST["optInitUser"],$_POST["optSecondOwner"],$_POST["optSupporter"],$timepicker_start,$timepicker_end,$economic_value,$txtProPrio,$project_description,$kpis);
                               
                   // update_projectupload($str_dbconnect,$_SESSION["NewUPLCode"], $Str_ProCode);
                    //echo $_SESSION["NewUPLCode"];
                    
                    echo "<div class='Div-Msg' id='msg' align='left'>*** Project Updated Successfully</div>";
                }
                elseif($_SESSION["DataMode"] == "D"){
                    delete_project($str_dbconnect,$_POST["txtProCode"]);
                    
                   // update_projectupload($str_dbconnect,$_SESSION["NewUPLCode"], $Str_ProCode);
                    //echo $_SESSION["NewUPLCode"];
                    
                    echo "<div class='Div-Msg' id='msg' align='left'>*** Task Removed Successfully</div>";
                }
                $bool_ReadOnly          = "TRUE";
                $Save_Enable            = "No";
                $_SESSION["DataMode"]   = "";
                $_SESSION["ProjectCode"]= "";
    
            } 
            else {
                $Str_ProName    = $_POST["txtProName"];
                $Dte_Startdate  = $_POST["txt_StartDate"];

                if ($Str_ProName == ""){
                    $ErrorString    =   "Project Name ";
                }
                if($Dte_Startdate == ""){
                    $ErrorString    .=  "Start Date ";
                }
                $bool_ReadOnly          =	"FALSE";
                $Save_Enable            =	"Yes";
                $_SESSION["DataMode"]   =	"N";
                $_SESSION["ProjectCode"]= "";
                echo "<div class='Div-Error' id='msg' align='left'>*** Data Cannot be blank on <B>".$ErrorString."</B></div>";
            }
            
        }

        if(isset($_POST['btnSearch'])) {
            //header("Location:M_Reference.php");
            echo "<script>";
            echo " self.location='projectbrowse.php';";
            echo "</script>";
        }

    ?>
<form name="frm_porject" id="frm_porject" method="post" action="project.php" enctype="multipart/form-data" class="cmxform">
<div id="preloader"></div>
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
                                                <font color="#0066FF"> Create Project </font>                                              
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>
                                    <br></br>
									<table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
										<tr>
											<td>
												<input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="" size="5"/>
											</td>
											<td>
												<input type="submit" id="btnSearch" name="btnSearch" title="Search Project Details" class="buttonSearch" value="" size="5" />	
											</td>
											<td>
												<input type="submit" id="btnAdd" name="btnAdd" title="Add New Project" class="buttonAdd" value="" size="5"/>	
											</td>
											<td>
												<input type="submit" id="btnEdit" name="btnEdit" title="Edit Project" class="buttonEdit" value="" size="10"/>	
											</td>
											<!-- <td>
												<input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Project" class="buttonDel" value="" size="10"/>	
											</td> -->
											<td>
												<input type="submit" id="btnPrint" name="btnPrint" title="Print Project Details" class="buttonPrint" value="" size="10"/>	
											</td>
										</tr>
									</table>                                    
                                    <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>                                                
                                             	<tr>
                                                    <td width="20%">
                                                        Division
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="txtGrpNote" name="txtGrpNote" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> onchange="Selection();" class="TextBoxStyle">
							                                <option id="SL" value="SL" <?php if($_strDivCode == "SL") echo "selected=\"selected\""; ?>>SL</option>
							                                <option id="US" value="US" <?php if($_strDivCode == "US") echo "selected=\"selected\""; ?>>US</option>
							                                <option id="TI" value="TI" <?php if($_strDivCode == "TI") echo "selected=\"selected\""; ?>>TI &nbsp;&nbsp;</option>
															<option id="UK" value="UK" <?php if($_strDivCode == "UK") echo "selected=\"selected\""; ?>>UK &nbsp;&nbsp;</option>
															<option id="MLD" value="MLD" <?php if($_strDivCode == "MLD") echo "selected=\"selected\""; ?>>MLD &nbsp;&nbsp;</option>
															<option id="CN" value="CN" <?php if($_strDivCode == "CN") echo "selected=\"selected\""; ?>>CN &nbsp;&nbsp;</option>
															<option id="AU" value="AU" <?php if($_strDivCode == "AU") echo "selected=\"selected\""; ?>>AU &nbsp;&nbsp;</option>
															<option id="FIJI" value="FIJI" <?php if($_strDivCode == "FIJI") echo "selected=\"selected\""; ?>>FIJI &nbsp;&nbsp;</option>
							                            </select>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Project Code
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input class="TextBoxStyle" type="text" id="txtProCode" name="txtProCode" size="20" value="<?php echo $Str_ProCode; ?>" readonly="readonly"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">
                                                        Project Category
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select  id="txtProCat"  name="txtProCat" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> >
                                                            <option  value="Strategic Initiatives"  <?php if($Str_ProCat  == "Strategic Initiatives") echo "selected=\"selected\""; ?>>Strategic </option>
                                                            <option value="Cost-Saving Initiatives" <?php if($Str_ProCat  == "Cost-Saving Initiatives") echo "selected=\"selected\""; ?> >Cost-Saving Initiatives</option>
                                                            <option value="Profit Potential Initiatives" <?php if($Str_ProCat  == "Profit Potential Initiatives") echo "selected=\"selected\""; ?> >Profit Potential Initiatives</option>
                                                            <option  value="Operational"  <?php if($Str_ProCat  == "Operational") echo "selected=\"selected\""; ?>>Operational</option>
                                                            <!-- <option  value="Process Improvement"  <?php if($Str_ProCat  == "Process Improvement") echo "selected=\"selected\""; ?>>Process Improvement</option> -->
                                                            <option value="Regular" <?php if($Str_ProCat  == "Regular") echo "selected=\"selected\""; ?> >Regular</option>
                                                        </select>
                                                    </td>
                                                </tr> 
												<tr>
                                                    <td width="20%">
                                                        Project Name
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input class="TextBoxStyle" type="text" id="txtProName" name="txtProName" size="60" value="<?php echo $Str_ProName; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?> />
                                                    </td>
                                                </tr>
												<div id="timepicker"></div>
												<tr>
                                                    <td width="20%">
                                                        Start Date
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input  class="TextBoxStyle" type="text" id="txt_StartDate" name="txt_StartDate" size="15" readonly="readonly" value="<?php echo $Dte_Startdate; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
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
                                                        End Date
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input class="TextBoxStyle" type="text" id="txt_EndDate" name="txt_EndDate"  size="15" readonly="readonly" value="<?php echo $Dte_Enddate; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
							                            <input class="TextBoxStyle" name="EndDate" type="hidden" id="EndDate" value="..." <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>
							
							                            <script type="text/javascript">
							                                $('#txt_EndDate').datepicker({
							                                    dateFormat:'yy-mm-dd'
							                                    });
							                            </script> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                        <td align="left">
                                                             Start Time 
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <input type="time" class="TextBoxStyle" name="timepicker_start" id="timepicker_start" size="15" value="<?php echo $timepicker_start; ?>"></input>                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                             End Time 
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <input type="time" class="TextBoxStyle" name="timepicker_end" id="timepicker_end" size="15" value="<?php echo $timepicker_end; ?>"></input>                          
                                                        </td>
                                                    </tr>  
												<tr>

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

                                                <tr>
                                                    <td width="20%">
                                                      Economic Value
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input class="TextBoxStyle" type="text" id="economic_value" name="economic_value" size="60" value="<?php echo $economic_value; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?> />
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="20%">
                                                      Project Priority 
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="txtProPrio"  name="txtProPrio" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> >
                                                            <option  value="high"  <?php if($txtProPrio  == "high") echo "selected=\"selected\""; ?>> High Priority Level  </option>
                                                            <option  value="medium"  <?php if($txtProPrio  == "medium") echo "selected=\"selected\""; ?>> Medium Priority Level </option>
                                                            <option value="low" <?php if($txtProPrio  == "low") echo "selected=\"selected\""; ?>> Low Priority Level </option>
                                                        </select>
                                                    </td>
                                                </tr> 

                                                <tr>
                                                    <td width="20%">
                                                     Project Description / Problem Statement 
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                    <input class="TextBoxStyle" type="text" id="project_description" name="project_description" size="60" value="<?php echo $project_description; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="20%">
                                                    Desired Business Outcomes / KPIs 
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                    <input class="TextBoxStyle" type="text" id="kpis" name="kpis" size="60" value="<?php echo $kpis; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                                                    </td>
                                                </tr>

                                                        <td width="20%">
                                                            Project Primary Owner
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td>
                                                            <select id="optAssignUser" name="optAssignUser" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
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
                                                    <td width="20%">
                                                        Department
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="optDepartment" name="optDepartment" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
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
                                                        Project Initiator
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="optInitUser" name="optInitUser" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
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
                                                        Project Secondary Owner
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="optSecondOwner" name="optSecondOwner" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
							                                <?php
							                                    #	Get Designation details ...................
							                                    $_EmpCode       =   $_SESSION["EmpCode"];
							                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
							                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							                                ?>
							                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strSecOwner) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
							                                <?php } ?>
							                            </select>
                                                    </td>
                                                </tr>  
												<tr>
                                                    <td width="20%">
                                                        Project Supporter
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="optSupporter" name="optSupporter" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
							                                <?php
							                                    #	Get Designation details ...................
							                                    $_EmpCode       =   $_SESSION["EmpCode"];
							                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
							                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							                                ?>
							                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strSupport) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
							                                <?php } ?>
							                            </select>
                                                    </td>
                                                </tr>  
												<tr>
                                                    <td width="20%">
                                                        Upload - Project Documents
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <fieldset class="" style="padding-left: 10px" id="fileUpload" >
							                                <!--<legend><strong> Upload - Project Documents </strong></legend>-->
							                                <br>
                                                            <input type="file" name="file[]" id="files" multiple>       
							                                <!-- <div id="fileUploadstyle">You have a problem with your javascript</div>
							                                <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()">Clear Queue</a> -->
							
							                                <hr width=100% size="1" color="" align="center">
							                            </fieldset>
                                                    </td>
                                                </tr> 
												<tr>
                                                    <td width="20%">
                                                        Download - Project Documents
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <?php
						                                    $_ResultSet      = get_projectupload($str_dbconnect,$Str_ProCode) ;
						                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
						                                ?>
						                                    <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a> <font color="red">&nbsp;|&nbsp;</font>
						                                <?php }
						     							?>
                                                    </td>
                                                </tr>  
												<tr>
													<td colspan="3" align="center"></td>
												</tr>
												<tr>
													<td colspan="3" align="center">
                                                        <table width="60%" cellpadding="0" cellspacing="0">
                                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">
																	<input name="btnSave" id="btnSave" type="button" class="submit"  value="Save" <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?> onclick="startUpload()" />
                                									&nbsp;<input name="btnCancel" id="btnCancel" type="button"  value="Cancel"  />                                                                    
                                                                </td>                                            
                                                            </tr>
                                                        </table>
                                                    </td>   
												</tr>
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
