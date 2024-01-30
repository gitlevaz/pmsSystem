<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Project Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database          //  connection file to the mysql database
//include ("class\accesscontrole.php");         //  sql commands for the access controles
//include ("../class/sql_project.php");              //  sql commands for the access controles
include ("../class/sql_empdetails.php");           //  connection file to the mysql database
include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
//include ("class/sql_crtgroups.php");        //  sql commands for the access controles
include ("../class/accesscontrole.php");          //  sql commands for the access controles
include ("../class/sql_wkflow.php");
require_once("../class/class.phpmailer.php");

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

    <!-- **************** JQUERRY ****************** -->
    <script type="text/javascript" language="javascript" src="../js/jquery-1.6.1.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.6.custom.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--link rel="stylesheet" href="themes/humanity/jquery.ui.all.css" type="text/css" /-->
    <link rel="stylesheet" type="text/css" media="screen" href="../css/screen.css" />


    <script src="../ui/jquery.ui.core.js"></script>
	<script src="../ui/jquery.ui.widget.js"></script>

	<script src="../ui/jquery.ui.button.js"></script>
    <link rel="stylesheet" href="../themes/humanity/jquery.ui.button.css" type="text/css" />
    
    <!-- **************** SLIDER ***************** -->
    <script src="../js/jquery-ui.min.js"></script>
    <!-- ************************************* -->
     <!-- ************ TIME PICKER ***************** -->
    <script type="text/javascript" src="../js/jquery-ui-timepicker-addon.js"></script>
    <!-- ************************************* -->
    <!-- ************ FILE UPLOAD ********* -->

    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
    <!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>

    <!-- ****************END***************** -->

    
    
    <!-- **************** Page Validation ***************** -->
    <script src="../js/jquery.validate.js" type="text/javascript"></script>

    <!-- ****************NICE FOMR ***************** -->
    <!--
    <script language="javascript" type="text/javascript" src="niceforms.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" /> -->
    
    <!-- ****************END***************** -->

    <link rel="stylesheet" href="../css/projectvsReport.css" type="text/css" />
    <link rel="stylesheet" href="../css/slider.css" type="text/css" />
    <link href="../css/textstyles.css" rel="stylesheet" type="text/css" />
    
    
    <style type="text/css">
        body { font-size: 70%; font-family: "Lucida Sans" }
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
        }

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
            document.forms[0].action = "eqstatus.php?&division="+hlink+"";
            document.forms[0].submit();
        }

        function DownloadFile(){

            hlink = document.getElementById('optDownload').value ;
            //alert(hlink);
			newwindow = window.open('','File Download');
            if (window.focus) {newwindow.focus()}
				return false;
		}

        function printReport(){


            division		= 	document.getElementById('txtGrpNote').value;
            department		=	document.getElementById("optDepartment").value ;
            empcode		=	document.getElementById('optInitUser').value ;            
            tskstatus		=	document.getElementById('optProStatus').value ;            
            StartDate		=	document.getElementById('txt_StartDate').value ;
            EndDate		=	document.getElementById('txt_EndDate').value ;
            
            newwindow=window.open('Print_eqStatus.php?division='+division+'&department='+department+'&empcode='+empcode+'&tskstatus='+tskstatus+'&StartDate='+StartDate+'&EndDate='+EndDate+'');
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

</script>

</head>

    <body onLoad="init()" class="ui-form">
    <?php

        $Str_ProCode    =   "";
        $Str_ProName    =   "";
        $Dte_Startdate  =   "";
        $Dte_Enddate    =   "";
        $bool_ReadOnly  =	"FALSE";
        $Save_Enable    =	"No";
        $ErrorString    =   "";
        
        $today_date  = date("Y-m-d");

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
            $_strEMPCODE    = $_POST["optAssignUser"];
            $_DepartmentSet = getALLMList($str_dbconnect,$_strDivCode);
            $_strProInit    = $_POST["optInitUser"];            

            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
        }


    ?>

            <div id="loading" style="position:absolute; width:100px; text-align:center; top:180px; left: 180px; height: 20px;">
                <img alt=""  src="images/Wait.gif" border=0/>
            </div>

            <script language="javascript" type="text/javascript">
                var ld=(document.all);
                var ns4=document.layers;
                var ns6=document.getElementById&&!document.all;
                var ie4=document.all;
                if (ns4)
                    ld=document.loading;
                else if (ns6)
                    ld=document.getElementById("loading").style;
                else if (ie4)
                    ld=document.all.loading.style;

                function init() {
                    if(ns4){ld.visibility="hidden";}
                    else if (ns6||ie4) ld.display="none";
                }

            </script>
           
            <div id="container">
                <form name="frm_porject" id="frm_porject" method="post" action="eqstatus.php" enctype="multipart/form-data" class="cmxform">
                    
                    <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px;">
    	            <legend ><strong>Maintenance Status</strong></legend>
                        <p>
                            <label >Equipment</label>
                            <select id="txtGrpNote" name="txtGrpNote" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> onchange="Selection();" class="required ui-widget-content">
                                <!--<option id="ALL" value="ALL" <?php if($_strDivCode == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
                                <option id="SL" value="SL" <?php if($_strDivCode == "SL") echo "selected=\"selected\""; ?>>SL</option>
                                <option id="US" value="US" <?php if($_strDivCode == "US") echo "selected=\"selected\""; ?>>US</option>
								<option id="AU" value="AU" <?php if($_strDivCode == "AU") echo "selected=\"selected\""; ?>>AU</option>
                                <option id="TI" value="TI" <?php if($_strDivCode == "TI") echo "selected=\"selected\""; ?>>TI &nbsp;&nbsp;</option>-->
                                
                                <option id="ALL" value="ALL" <?php if($_strDptCode == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
                                <?php         
                                    $_EquipSetSet = getAllEquipments($str_dbconnect);
                                    while($_EqRes = mysqli_fetch_array($_EquipSetSet)) {
                                ?>
                                <option value="<?php echo $_EqRes['eq_code']; ?>"  <?php if ($_EqRes['eq_code'] == $_strDivCode) echo "selected=\"selected\";" ?>> <?php echo $_EqRes['eq_name']; ?> </option>
                                <?php } ?>
                            </select>
                            
                            
                        </p>

                        <p>
                            <label for="optDepartment">Maintenance Type</label>
                            <select id="optDepartment" name="optDepartment" class="required ui-widget-content" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
                                <option id="ALL" value="ALL" <?php if($_strDptCode == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
                                <?php                                    
                                    while($_myrowRes = mysqli_fetch_array($_DepartmentSet)) {
                                ?>
                                <option value="<?php echo $_myrowRes['mt_id']; ?>"  <?php if ($_myrowRes['mt_id'] == $_strDptCode) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['mt_type']; ?> </option>
                                <?php } ?>
                            </select>
                        </p>
                        
                        <p>
                            <label for="optInitUser">W/F Owner</label>
                            <select id="optInitUser" name="optInitUser" class="required ui-widget-content" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
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
                        </p>                        
                        
                        <p>
                            <label >W/F Status</label>
                            <select id="optProStatus" name="optProStatus" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>  class="required ui-widget-content">
                                <option id="ALL" value="ALL" >ALL</option>
                                <option id="I" value="Yes" >Yes - Completed</option>
                                <option id="A" value="No" >No - Not Completed</option>
                                <option id="W" value="N/A" >N/A - Not Applicable</option>                                
                            </select>
                        </p>
                        
                        <div id="timepicker"></div>
                        <p>
                            <label >W/F Start From Date</label>

                            <input  class="required ui-widget-content" type="text" id="txt_StartDate" name="txt_StartDate" size="15" value="<?php echo $today_date; ?>" readonly="readonly" />
                            <input  class="required ui-widget-content" name="StartDate" type="hidden" id="StartDate" value="..." class="buttonDot" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>

                            <script type="text/javascript">
                                $('#txt_StartDate').datepicker({
                                    dateFormat:'yy-mm-dd'
                                    });
                            </script>
                        </p>
                        <p>
                            <label >W/F Start To Date</label>
                            <input class="required ui-widget-content" type="text" id="txt_EndDate" name="txt_EndDate"  size="15" value="<?php echo $today_date; ?>" readonly="readonly"/>
                            <input class="required ui-widget-content" name="EndDate" type="hidden" id="EndDate" value="..." <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>

                            <script type="text/javascript">
                                $('#txt_EndDate').datepicker({
                                    dateFormat:'yy-mm-dd'
                                    });
                            </script>
                        </p>
                        
                        </fieldset>

                        <p>
                            <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 240px; padding-top: 10px; padding-bottom: 10px;">
                                <input name="btnSave" id="btnSave" type="button" class="submit"  value="View Report" style="width: 100px" onclick="printReport()"/>
                                <input name="btnCancel" id="btnCancel" type="button"  value="Cancel" style="width: 60px" />
                            </fieldset>
                        </p>

                </form>
            </div>
<!--
        </div>
    </div>-->

</body>
</html>
