<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Project Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
include ("class/accesscontrole.php");       //  sql commands for the access controles
include ("class/sql_Task.php");       //  sql commands for the access controles
include ("class/sql_crtgroups.php");   //  connection file to the mysql database
include ("class/sql_project.php");       //  sql commands for the access controles

//include ("class\class.phpmailer.php");   //  connection file to the mysql database
require_once("class/class.phpmailer.php");
require_once("class/class.SMTP.php");
include ("class/MailBodyTwo.php");   //  connection file to the mysql database
include ("class/sql_empdetails.php");   //  connection file to the mysql database

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "Home";
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
	
	<!-- **************** Page Validation ***************** -->
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<!-- ****************NICE FOMR ***************** -->
	
	<link href="css/styleB.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
    #slider-result {
        position:absolute;
        top: 460px;
        left: 55%;
        font-size:16px;
        /*height:10px;*/
        font-family:Arial, Helvetica, sans-serif;
        color:#000066;
        width:200px;
        text-align:left;
        text-shadow:0 1px 1px #000;
        font-weight:700;
        padding:20px 0;
    }
</style>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        $('#example').dataTable();
    } );

</script>

    <!--<style type="text/css">
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

    </style>-->


    <script type="text/javascript" charset="utf-8">

       function getPageSize() {
        }

       $().ready(function() {
        // validate signup form on keyup and submit
            $("#frm_Task").validate({
                onsubmit: false,
                rules: {
                    optProCode: {
                        required: true
                    },
                    txtTaskCode: {
                        required: false
                    },
                    txtTaskName: {
                        required: true
                    },
                    optTaskParent: {
                        required: false
                    },
                    txt_StartDate: {
                        required: true
                    },
                    txt_EndDate: {
                        required: true
                    },
                    txtEstHours: {
                        required: true
                    },
                    lstSysUsers: {
                        required: false
                    },
                    lstFacUsers: {
                        required: false
                    },
                    optPriority: {
                        required: true
                    }
                },
                messages: {
                    txtProCode: "Please Select a Project Name",
                    txtTaskName: "Please Enter a Task Name",
                    txtTaskDescription: "Please Enter the Task Description",
                    optTaskParent: "Please Select the Parent Task",
                    txt_StartDate: "Please Enter the Start Date",
                    txt_EndDate: "Please Enter the End Date",
                    txtEstHours: "Please Enter the Estimated Hours",
                    lstFacUsers: "Please Add a Task Owners",
                    optPriority: "Please Select the Task Priority"
                }
            });
        });
    </script>

    <script type="text/javascript" src="tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript">
        $().ready(function() {
            $('textarea.tinymce').tinymce({
                // Location of TinyMCE script
                script_url : 'tiny_mce/tiny_mce.js',

                // General options
                theme : "advanced",
                plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

                // Theme options
                theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,iespell",
                theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,forecolor,backcolor",
                /*theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",*/
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                theme_advanced_resizing : true,

                // Example content CSS (should be your site CSS)
                content_css : "css/contentext.css",

                // Drop lists for link/image/media/template dialogs
                template_external_list_url : "lists/template_list.js",
                external_link_list_url : "lists/link_list.js",
                external_image_list_url : "lists/image_list.js",
                media_external_list_url : "lists/media_list.js",

                // Replace values for the template plugin
                template_replace_values : {
                    username : "Some User",
                    staffid : "991234"
                }
            });
        });
    </script>

    <SCRIPT language="JavaScript">


    function getTimeDiff(){

        var time1 = document.getElementById('txtStart').value + ":" ;
        var time2 = document.getElementById('txtEnd').value + ":" ;

        var H1 = 0;
        var H2 = 0;

        var M1 = 0;
        var M2 = 0;

        var arrTime1  =   time1.split(":");
        H1  =   parseFloat(arrTime1[0]);
        M1  =   parseFloat(arrTime1[1]);

        var arrTime2  =   time2.split(":");
        H2  =   parseFloat(arrTime2[0]);
        M2  =   parseFloat(arrTime2[1]);

        var HH  = 0;
        var MM  =  0;
           
        HH  =  H2 - H1;

        if(M2 < M1 ){
            MM = (M2 + 60) - M1;
            HH = HH - 1;
        }else{
            MM = M2 - M1;
        }
        document.getElementById('txtHoursSpent').value = HH + ":" + MM;

        if(HH < 0 || MM < 0){
            document.getElementById('txtHoursSpent').style.backgroundColor='red';
        }else{
            document.getElementById('txtHoursSpent').style.backgroundColor='';
        }
    }

    function getTimeDiffRemaining( timeA,timeB){

        var time1 = timeA + ":" ;
        var time2 = timeB + ":" ;

        var H1 = 0;
        var H2 = 0;

        var M1 = 0;
        var M2 = 0;

        var arrTime1  =   time1.split(":");
        H1  =   parseFloat(arrTime1[0]);
        M1  =   parseFloat(arrTime1[1]);

        var arrTime2  =   time2.split(":");
        H2  =   parseFloat(arrTime2[0]);
        M2  =   parseFloat(arrTime2[1]);

        var HH  = 0;
        var MM  =  0;

        HH  =  H2 - H1;

        if(M2 < M1 ){
            MM = (M2 + 60) - M1;

            HH = HH - 1;
        }else{
            MM = M2 - M1;
        }
        var answertime = HH + ":" + MM;
        document.getElementById('txtHrsRemaining').value = answertime + ":00";

        if(HH < 0 || MM < 0){
            document.getElementById('txtHrsRemaining').style.backgroundColor='red';
        }else{
            document.getElementById('txtHrsRemaining').style.backgroundColor='';
        }
    }

    function submitForm() {
        //if($("#myform").validate().form())
        //$('#fileUploadstyle').fileUploadStart()

        return $('#fileUploadstyle').fileUploadStart();
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
	
</SCRIPT>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#fileUploadstyle").fileUpload({
                'uploader': 'uploadify/uploader.swf',
                'cancelImg': 'uploadify/cancel.png',
                'script': 'uploadify/upload copy.php',
                'folder': 'files',
                'multi': true,
                'displayData': 'speed',
                'width': 100,
                'height': 25,
                'onAllComplete' : function(event,data) {
                  //alert(data.filesUploaded + ' files uploaded successfully!');
                    return true;
                }}
            );
        });
    </script>
        

</head>

    <body>
	<div id="preloader"></div>
    <?php
        
        $Str_ProCode    =   "";
        $Str_ProName    =   "";
        
        $Str_TaskCode   =   "";
        $Str_TaskName   =   "";
        $Precentage     =   0;
        $bool_ReadOnly  =   "TRUE";
        $Save_Enable    =   "No";
        $EstimatedHours     =   "00:00:00";
        $Str_txtHoursSpent  =   "00:00:00";
        $EstimatedHours     =   "00:00:00";
        $HoursSpent         =   "00:00:00";
        $HoursRemaining     =   "00:00:00";
        $AddlHrsRequest     =   "00:00:00";
        $AddlHrsApproved    =   "00:00:00";

        $_txtTaskID             =   "";
        $_optPriority           =   "";
        $_txtTaskDescription    =   "";
        $_txtStart              =   "";
        $_txtEnd                =   "";
        $_txtHoursSpent         =   "";
        $_txtHrsRequest         =   "";

        $Str_TaskDescription  =   "";

        if(isset($_POST['btnCancel'])) {
            $bool_ReadOnly          =	"TRUE";
            $Save_Enable            =	"No";
            $_SESSION["DataMode"]   =	"";
            $_SESSION["taskcode"]    =   "";
        }

        if(isset($_GET["taskcode"]) && isset($_GET["taskid"]))
        {

            $_SESSION["BackPageApp"]    =   $_GET["Page"];

            $Str_TaskCode               =   $_GET["taskcode"];
            $_TaskID                    =   $_GET["taskid"];
            $_SESSION["taskcode"]       =   $Str_TaskCode;
            $_SESSION["taskid"]         =   $_TaskID;

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode    = $_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                $MailCCTo           =   $_myrowRes['MailCCTo'];

                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }

            $EstimatedHours  = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent      = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);


            $_ResultSet = updateTaskStatusDetailsvsID($str_dbconnect,$Str_TaskCode, $_TaskID);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_txtTaskID             =   $_myrowRes['UpdateCode'];
                $_optPriority           =   $_myrowRes['category'];
                $Str_TaskDescription    =   $_myrowRes['Note'];
                $_txtStart              =   $_myrowRes['SpentFrom'];
                $_txtEnd                =   $_myrowRes['SpentFrom'];
                $_txtHoursSpent         =   $_myrowRes['TotHors'];
                $_txtHrsRequest         =   $_myrowRes['HrsRequest'];
            }
            //$HoursRemaining = $EstimatedHours -  $HoursSpent;
            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_ProOwner      = "";
            $_ProCrt        = "";
			$_ProCrtdate    = "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =  	$_myrowRes['Division'];
                $_DepartCode    =  	$_myrowRes['Department'];
                $_ProInit       =  	$_myrowRes['ProInit'];
                $_ProOwner      =  	$_myrowRes['ProOwner'];
                $_ProCrt        =  	$_myrowRes['crtusercode'];
                $_strSecOwner   =  	$_myrowRes["SecOwner"];
                $_strSupport    =  	$_myrowRes["Support"];
				$_ProCrtdate	=	$_myrowRes["crtdate"];
            }

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $bool_ReadOnly              =   "TRUE";
            $Save_Enable                =   "No";
            $_SESSION["DataMode"]       =   "";
        }

        if(isset($_POST['btnSearch'])) {
            //header("Location:M_Reference.php");
            echo "<script>";
            echo "self.location='Apptaskbrowse.php';";
            echo "</script>";
        }

        if(isset($_POST['btnAdd'])) {
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"N";
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please Enter New Project Details</div>";

            $Str_TaskCode   = $_SESSION["taskcode"];

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode 	= 	$_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }
            $EstimatedHours = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);

            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_ProOwner      = "";
            $_ProCrt        = "";
			$_ProCrtdate	= "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =  $_myrowRes['Division'];
                $_DepartCode    =  $_myrowRes['Department'];
                $_ProInit       =  $_myrowRes['ProInit'];
                $_ProOwner      =  $_myrowRes['ProOwner'];
                $_ProCrt        =  $_myrowRes['crtusercode'];
                $_strSecOwner   =  $_myrowRes["SecOwner"];
                $_strSupport    =  $_myrowRes["Support"];
				$_ProCrtdate	=	$_myrowRes["crtdate"];
            }

            $_SESSION["ProjectCode"]    =   $Str_ProCode;

            $NewFileCode            =   create_FileName($str_dbconnect);
            $_SESSION["NewUPLCode"] =   $NewFileCode;
            $_SESSION["UploadeFileCode"]    =   "";

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
                $Str_ProCode = $_myrowRes['procode'];
                $Str_ProName = $_myrowRes['proname'];
                $Dte_Startdate = $_myrowRes['startdate'];
            }

            $EstimatedHours = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);

            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

        }

        if(isset($_POST['btnEdit'])) {
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"E";
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please update the Project Details</div>";
        }

        if(isset($_POST['btnSave'])) {

            $Str_TaskCode               =   $_SESSION["taskcode"];
            $_TaskID                    =   $_SESSION["taskid"];

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode    = $_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                $MailCCTo       =   $_myrowRes['MailCCTo'];
                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }

            $EstimatedHours  = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent      = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);



            $_ResultSet = updateTaskStatusDetailsvsID($str_dbconnect,$Str_TaskCode, $_TaskID);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_txtTaskID             =   $_myrowRes['UpdateCode'];
                $_optPriority           =   $_myrowRes['category'];
                $Str_TaskDescription    =   $_myrowRes['Note'];
                $_txtStart              =   $_myrowRes['SpentFrom'];
                $_txtEnd                =   $_myrowRes['SpentFrom'];
                $_txtHoursSpent         =   $_myrowRes['TotHors'];
                $_txtHrsRequest         =   $_myrowRes['HrsRequest'];
            }
            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_ProOwner      = "";
            $_ProCrt        = "";
			$_ProCrtdate	= "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =  $_myrowRes['Division'];
                $_DepartCode    =  $_myrowRes['Department'];
                $_ProInit       =  $_myrowRes['ProInit'];
                $_ProOwner      =  $_myrowRes['ProOwner'];
                $_ProCrt        =  $_myrowRes['crtusercode'];
                $_strSecOwner   =  $_myrowRes["SecOwner"];
                $_strSupport    =  $_myrowRes["Support"];
				$_ProCrtdate	=	$_myrowRes["crtdate"];
            }

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $bool_ReadOnly              =   "TRUE";
            $Save_Enable                =   "No";
            $_SESSION["DataMode"]       =   "";

            $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'C' WHERE `taskcode` = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            $_SelectQuery   = 	"UPDATE tbl_apptask SET `AppStat` = 'C' WHERE `TaskCode` = '$Str_TaskCode' AND `ID` = '$_TaskID'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            get_TaskPrimaryUpdate($str_dbconnect,$_POST["txtTaskCode"], "Approved");

            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_strSecOwner   = "";
            $_strSupport    = "";
            $_ProOwner      = "";
            $_ProCrt        = "";
			$_ProCrtdate	= "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =   $_myrowRes['Division'];
                $_DepartCode    =   $_myrowRes['Department'];
                $_ProInit       =   $_myrowRes['ProInit'];
                $_strSecOwner   =   $_myrowRes["SecOwner"];
                $_strSupport    =   $_myrowRes["Support"];

                $_ProOwner      =  $_myrowRes['ProOwner'];
                $_ProCrt        =  $_myrowRes['crtusercode'];
				$_ProCrtdate	=	$_myrowRes["crtdate"];

            }

            $_Department = getGROUPNAME2($str_dbconnect,$_DepartCode);

            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_ProOwner      = "";
            $_ProCrt        = "";
			$_ProCrtdate	= "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =  $_myrowRes['Division'];
                $_DepartCode    =  $_myrowRes['Department'];
                $_ProInit       =  $_myrowRes['ProInit'];
                $_ProOwner      =  $_myrowRes['ProOwner'];
                $_ProCrt        =  $_myrowRes['crtusercode'];
                $_strSecOwner   =  $_myrowRes["SecOwner"];
                $_strSupport    =  $_myrowRes["Support"];
				$_ProCrtdate	=	$_myrowRes["crtdate"];
            }

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $Dte_SysDate    = 	date("Y/m/d");
			
			updateTaskStatusApprove($str_dbconnect,$_POST["txtTaskCode"], "APPROVED", $_POST["txtAppNote"],  $_POST["hidden"], $_POST["txtStart"],$_POST["txtEnd"], $_POST["txtHoursSpent"], $_POST["txtHrsRequest"]);

            $StrFromMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_SESSION["LogEmpCode"]);
            $StrToMail      =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInit);

            $StrSenderName  =   getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]);

            $MagBody        =   CreateMailApprove($Str_ProCode, $Str_ProName, $Str_TaskCode, $Str_TaskName, $_optPriority, $Str_TaskDescription, $Dte_SysDate, $_POST["txtAppNote"]);

            $mailer = new PHPMailer();
            $mailer->IsSMTP();
             $mailer->Host = 'smtp.office365.com';//$mailer->Host 		= '10.9.0.166:25';						// $mailer->Host 		= 'ssl://smtp.gmail.com:465';
            $mailer->SetLanguage("en", 'class/');									//  $mailer->SetLanguage("en", 'class/');
            $mailer->SMTPAuth 	= TRUE;
            $mailer->IsHTML(true);//$mailer->IsHTML 	= TRUE;
            $mailer->Username = 'pms@eteknowledge.com';//$mailer->Username 	= 'pms@eTeKnowledge.com';  // Change this to your gmail adress		$mailer->Username 	= 'info@tropicalfishofasia.com';
            $mailer->Password = 'Cissmp@456';//$mailer->Password 	= 'pms@321';  // Change this to your gmail password							$mailer->Password 	= 'info321';
            $mailer->Port = 587;
			$mailer->SetFrom('pms@eteknowledge.com','PMS');
			$mail->CharSet = "text/html; charset=UTF-8;";
			$mailer->Body =str_replace('"','\'',$MagBody);
			//$mailer->From 		= $StrFromMail;  // This HAVE TO be your gmail adress
            //$mailer->FromName 	= 'PMS'; // This is the from name in the email, you can put anything you like here
            //$mailer->Body 		= $MagBody;

            $TaskUsers  		=   "";
            
            $DepartmentMails = getTASKUSERFACILITIES($str_dbconnect,$Str_TaskCode);
            while ($_MailRes = mysqli_fetch_array($DepartmentMails)) {
                $EmpDpt = $_MailRes['EmpCode'];
                $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

                if ($TaskUsers == "") {
                    $TaskUsers = getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                } else {
                    $TaskUsers = $TaskUsers . "/" . getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                }

                $mailer->AddAddress($MailAddressDpt); // This is where you put the email adress of the person you want to mail
            }
            /* ----------------------------------------------------------------- */

            $MailTitile =   "TO : ".$TaskUsers." - TASK COMPLETION APPROVED - ".$_Division." ".$_Department." - ".$Str_TaskName;
            $mailer->Subject = $MailTitile;

            if($_ProOwner != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner));
            }

            if($_strSecOwner != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner));
            }

            if($_strSupport != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport));
            }

            if($_ProCrt != ""){
                 $mailer->AddCC(getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt));
            }
            
            $mailer->AddCC($StrFromMail);  // This is where you put the email adress of the person you want to mail

            //echo $StrFromMail;
            $MailsCC = explode("-", $MailCCTo);

            for($a=0;$a<(sizeof($MailsCC)-1);$a++){
                $mailer->AddCC($MailsCC[$a]);
            }
			
				/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
			
            if(!$mailer->Send())
            {
               echo "Message was not sent<br/ >";
               echo "Mailer Error: " . $mailer->ErrorInfo;
            }
            else
            {
               //echo "Message has been sent";
            }

            echo "<div class='Div-Msg' id='msg' align='left'>*** TASK APPROVED SUCCESSFULLY</div>";
        }

        if(isset($_POST['btnReject'])) {
		
			updateTaskStatusApprove($str_dbconnect,$_POST["txtTaskCode"], "REJECT", $_POST["txtAppNote"],  $_POST["hidden"], $_POST["txtStart"],$_POST["txtEnd"], $_POST["txtHoursSpent"], $_POST["txtHrsRequest"]);

           $Str_TaskCode               =   $_SESSION["taskcode"];
           $_TaskID                   =   $_SESSION["taskid"];

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode    = $_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                $MailCCTo       =   $_myrowRes['MailCCTo'];
                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }

            $EstimatedHours  = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent      = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);



            $_ResultSet = updateTaskStatusDetailsvsID($str_dbconnect,$Str_TaskCode, $_TaskID);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_txtTaskID             =   $_myrowRes['UpdateCode'];
                $_optPriority           =   $_myrowRes['category'];
                $Str_TaskDescription    =   $_myrowRes['Note'];
                $_txtStart              =   $_myrowRes['SpentFrom'];
                $_txtEnd                =   $_myrowRes['SpentFrom'];
                $_txtHoursSpent         =   $_myrowRes['TotHors'];
                $_txtHrsRequest         =   $_myrowRes['HrsRequest'];
            }
            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_ProOwner      = "";
            $_ProCrt        = "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =  $_myrowRes['Division'];
                $_DepartCode    =  $_myrowRes['Department'];
                $_ProInit       =  $_myrowRes['ProInit'];
                $_ProOwner      =  $_myrowRes['ProOwner'];
                $_ProCrt        =  $_myrowRes['crtusercode'];
                $_strSecOwner   =  $_myrowRes["SecOwner"];
                $_strSupport    =  $_myrowRes["Support"];
            }
            
            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $bool_ReadOnly              =   "TRUE";
            $Save_Enable                =   "No";
            $_SESSION["DataMode"]       =   "";

            $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'A' WHERE `taskcode` = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            $_SelectQuery   = 	"UPDATE tbl_apptask SET `AppStat` = 'C' WHERE `TaskCode` = '$Str_TaskCode' AND `ID` = '$_TaskID'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_strSecOwner   = "";
            $_strSupport    = "";
            $_ProOwner      = "";
            $_ProCrt        = "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =   $_myrowRes['Division'];
                $_DepartCode    =   $_myrowRes['Department'];
                $_ProInit       =   $_myrowRes['ProInit'];
                $_strSecOwner   =   $_myrowRes["SecOwner"];
                $_strSupport    =   $_myrowRes["Support"];

                $_ProOwner      =  $_myrowRes['ProOwner'];
                $_ProCrt        =  $_myrowRes['crtusercode'];

            }

            $_Department = getGROUPNAME2($str_dbconnect,$_DepartCode);

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $Dte_SysDate    = 	date("Y/m/d");

            $StrFromMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_SESSION["LogEmpCode"]);
            $StrToMail      =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInit);

            $StrSenderName  =   getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]);

            $MagBody        =   CreateMailApprove($Str_ProCode, $Str_ProName, $Str_TaskCode, $Str_TaskName, $_optPriority, $Str_TaskDescription, $Dte_SysDate, $_POST["txtAppNote"]);

            $mailer = new PHPMailer();
            $mailer->IsSMTP();
            $mailer->Host = 'smtp.office365.com';//$mailer->Host = '10.9.0.166:25';							// $mailer->Host = 'ssl://smtp.gmail.com:465';
            $mailer->SetLanguage("en", 'class/');								// $mailer->SetLanguage("en", 'class/');
            $mailer->SMTPAuth = TRUE;
            $mailer->IsHTML(true);//$mailer->IsHTML = TRUE;
            $mailer->Username = 'pms@eteknowledge.com';//	$mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress			$mailer->Username = 'info@tropicalfishofasia.com';
            $mailer->Password = 'Cissmp@456';//$mailer->Password = 'pms@321';  // Change this to your gmail password							$mailer->Password = 'info321';
            $mailer->Port = 587;
			$mailer->SetFrom('pms@eteknowledge.com','PMS');
			$mail->CharSet = "text/html; charset=UTF-8;";
			$mailer->Body =str_replace('"','\'',$MagBody);
			// $mailer->From = $StrFromMail;  // This HAVE TO be your gmail adress
            // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
            // $mailer->Body = $MagBody;

            $TaskUsers  =   "";

            $DepartmentMails = getTASKUSERFACILITIES($str_dbconnect,$Str_TaskCode);
            while ($_MailRes = mysqli_fetch_array($DepartmentMails)) {
                $EmpDpt = $_MailRes['EmpCode'];
                $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

                if ($TaskUsers == "") {
                    $TaskUsers = getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                } else {
                    $TaskUsers = $TaskUsers . "/" . getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                }

                $mailer->AddAddress($MailAddressDpt); // This is where you put the email adress of the person you want to mail
            }
            /* ----------------------------------------------------------------- */

            $MailTitile =   "TO : ".$TaskUsers." - TASK COMPLETION REQUEST REJECTED - ".$_Division." ".$_Department." - ".$Str_TaskName;
            $mailer->Subject = $MailTitile;

            if($_ProOwner != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner));
            }

            if($_strSecOwner != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner));
            }

            if($_strSupport != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport));
            }

            if($_ProCrt != ""){
                 $mailer->AddCC(getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt));
            }

            $mailer->AddCC($StrFromMail);  // This is where you put the email adress of the person you want to mail

            //echo $StrFromMail;
            $MailsCC = explode("-", $MailCCTo);

            for($a=0;$a<(sizeof($MailsCC)-1);$a++){
                $mailer->AddCC($MailsCC[$a]);
            }
			
				/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
			
            if(!$mailer->Send())
            {
               echo "Message was not sent<br/ >";
               echo "Mailer Error: " . $mailer->ErrorInfo;
            }
            else
            {
               //echo "Message has been sent";
            }

            get_TaskPrimaryUpdate($str_dbconnect,$_POST["txtTaskCode"], "Reject");

            echo "<div class='Div-Msg' id='msg' align='left'>*** TASK REJECTED SUCCESSFULLY</div>";
        }

        if(isset($_POST['btnApprove'])) {
		
			

            $Str_TaskCode               =   $_SESSION["taskcode"];
            $_TaskID                    =   $_SESSION["taskid"];

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode    = $_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                $MailCCTo       =   $_myrowRes['MailCCTo'];
                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }

            $EstimatedHours  = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent      = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);



            $_ResultSet = updateTaskStatusDetailsvsID($str_dbconnect,$Str_TaskCode, $_TaskID);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_txtTaskID             =   $_myrowRes['UpdateCode'];
                $_optPriority           =   $_myrowRes['category'];
                $Str_TaskDescription    =   $_myrowRes['Note'];
                $_txtStart              =   $_myrowRes['SpentFrom'];
                $_txtEnd                =   $_myrowRes['SpentFrom'];
                $_txtHoursSpent         =   $_myrowRes['TotHors'];
                $_txtHrsRequest         =   $_myrowRes['HrsRequest'];
                $MailCCTo           =   $_myrowRes['MailCCTo'];
            }
            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $bool_ReadOnly              =   "TRUE";
            $Save_Enable                =   "No";
            $_SESSION["DataMode"]       =   "";

            $HRSApproved    =   $_POST['txtHrsApp'];

            $_SelectQuery   = 	"UPDATE tbl_taskupdates SET `Hrs Approved` = '$HRSApproved' WHERE `taskcode` = '$Str_TaskCode' AND `UpdateCode` = '$_TaskID'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            $_SelectQuery   = 	"UPDATE tbl_apptask SET `AppStat` = 'C' WHERE `TaskCode` = '$Str_TaskCode' AND `ID` = '$_TaskID'" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            get_TaskPrimaryUpdate($str_dbconnect,$_POST["txtTaskCode"], "Update");

            $_DepartCode    = "";
            $_Department    = "";
            $_Division      = "";
            $_ProInit       = "";
            $_strSecOwner   = "";
            $_strSupport    = "";
            $_ProOwner      = "";
            $_ProCrt        = "";

            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_Division      =   $_myrowRes['Division'];
                $_DepartCode    =   $_myrowRes['Department'];
                $_ProInit       =   $_myrowRes['ProInit'];
                $_strSecOwner   =   $_myrowRes["SecOwner"];
                $_strSupport    =   $_myrowRes["Support"];

                $_ProOwner      =  $_myrowRes['ProOwner'];
                $_ProCrt        =  $_myrowRes['crtusercode'];

            }

            $_Department = getGROUPNAME2($str_dbconnect,$_DepartCode);

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $Dte_SysDate    = 	date("Y/m/d");

            $StrFromMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_SESSION["LogEmpCode"]);
            $StrToMail      =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInit);

            $StrSenderName  =   getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]);

            $MagBody        =   CreateMail($str_dbconnect,$Str_ProCode, $Str_ProName, $Str_TaskCode, $Str_TaskName, $_optPriority, $Str_TaskDescription, $Dte_SysDate);

            $mailer = new PHPMailer();
            $mailer->IsSMTP();
            $mailer->Host = 'smtp.office365.com';//$mailer->Host = '10.9.0.166:25';							// $mailer->Host = 'ssl://smtp.gmail.com:465';
            $mailer->SetLanguage("en", 'class/');								// $mailer->SetLanguage("en", 'class/');
            $mailer->SMTPAuth = TRUE;
            $mailer->IsHTML(true);//$mailer->IsHTML = TRUE;
            $mailer->Username = 'pms@eteknowledge.com';//$mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress			$mailer->Username = 'info@tropicalfishofasia.com';
            $mailer->Password = 'Cissmp@456';//	$mailer->Password = 'pms@321';  // Change this to your gmail password							$mailer->Password = 'info321';
            $mailer->Port = 587;
			$mailer->SetFrom('pms@eteknowledge.com','Work Flow');
			$mail->CharSet = "text/html; charset=UTF-8;";
			$mailer->Body =str_replace('"','\'',$MagBody);
			
			// $mailer->From = $StrFromMail;  // This HAVE TO be your gmail adress
            // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
            // $mailer->Body = $MagBody;

            $TaskUsers  =   "";

            $DepartmentMails = getTASKUSERFACILITIES($str_dbconnect,$Str_TaskCode);
            while ($_MailRes = mysqli_fetch_array($DepartmentMails)) {
                $EmpDpt = $_MailRes['EmpCode'];
                $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

                if ($TaskUsers == "") {
                    $TaskUsers = getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                } else {
                    $TaskUsers = $TaskUsers . "/" . getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                }

                $mailer->AddAddress($MailAddressDpt); // This is where you put the email adress of the person you want to mail
            }
            /* ----------------------------------------------------------------- */

            $MailTitile =   "TO : ".$TaskUsers." - Addl Hrs Approved - ".$_Division." ".$_Department." - ".$Str_TaskName;
            $mailer->Subject = $MailTitile;


            if($_ProOwner != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner));
            }

            if($_strSecOwner != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner));
            }

            if($_strSupport != ""){
                 $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport));
            }

            if($_ProCrt != ""){
                 $mailer->AddCC(getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt));
            }

            $mailer->AddCC($StrFromMail);  // This is where you put the email adress of the person you want to mail

            //echo $StrFromMail;
            $MailsCC = explode("-", $MailCCTo);

            for($a=0;$a<(sizeof($MailsCC)-1);$a++){
                $mailer->AddCC($MailsCC[$a]);
            }
			
				/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
			
            if(!$mailer->Send())
            {
               echo "Message was not sent<br/ >";
               echo "Mailer Error: " . $mailer->ErrorInfo;
            }
            else
            {
               //echo "Message has been sent";
            }

            echo "<div class='Div-Msg' id='msg' align='left'>*** TASK APPROVED SUCCESSFULLY</div>";

        }

        if(isset($_POST['btnCancel'])) {

            $Str_TaskCode               =   $_SESSION["taskcode"];
            $_TaskID                    =   $_SESSION["taskid"];

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode    = $_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                $MailCCTo       =   $_myrowRes['MailCCTo'];
                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }

            $EstimatedHours  = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent      = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);



            $_ResultSet = updateTaskStatusDetailsvsID($str_dbconnect,$Str_TaskCode, $_TaskID);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $_txtTaskID             =   $_myrowRes['UpdateCode'];
                $_optPriority           =   $_myrowRes['category'];
                $Str_TaskDescription    =   $_myrowRes['Note'];
                $_txtStart              =   $_myrowRes['SpentFrom'];
                $_txtEnd                =   $_myrowRes['SpentFrom'];
                $_txtHoursSpent         =   $_myrowRes['TotHors'];
                $_txtHrsRequest         =   $_myrowRes['HrsRequest'];
            }
            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $bool_ReadOnly              =   "TRUE";
            $Save_Enable                =   "No";
            $_SESSION["DataMode"]       =   "";

        }


        if(isset($_POST['btnSave1'])) {

            if($_SESSION["DataMode"] == "N"){
//                $Str_ProCode    = create_project($str_dbconnect,$_POST["txtProName"], $_POST["txt_StartDate"]);

                updateTaskStatus($str_dbconnect,$_POST["txtTaskCode"], $_POST["optPriority"], $_POST["txtTaskDescription"],  $_POST["hidden"], $_POST["txtStart"],$_POST["txtEnd"], $_POST["txtHoursSpent"], $_POST["txtHrsRequest"]);

                
                $Str_TaskCode   = $_SESSION["taskcode"];

                //update_projectuploadTaskupdate1($str_dbconnect,$_SESSION["NewUPLCode"], $Str_TaskCode, "TSK");

                $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    $Str_ProCode        = $_myrowRes['procode'];
                    $Str_ProName        =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                    $Str_TaskName       =   $_myrowRes['taskname'];
                    $Str_AssignBy       =   $_myrowRes['AssignBy'];
                    $Precentage         =   $_myrowRes['Precentage'];
                    $MailCCTo           =   $_myrowRes['MailCCTo'];
                }

                $_DepartCode    = "";
                $_Department    = "";
                $_Division      = "";
                $_ProInit       = "";

                $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    $_Division      =   $_myrowRes['Division'];
                    $_DepartCode    =   $_myrowRes['Department'];
                    $_ProInit       =   $_myrowRes['ProInit'];
                }

                $_Department = getGROUPNAME2($str_dbconnect,$_DepartCode);

                $_SESSION["ProjectCode"]    =   $Str_ProCode;
                $Dte_SysDate    = 	date("Y/m/d");

                $StrFromMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_SESSION["LogEmpCode"]);
                $StrToMail      =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInit);

                //$StrToBCC       =   "shameerap@cisintl.com";

                $StrSenderName  =   getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]);

                $MagBody        =   CreateMail($str_dbconnect,$Str_ProCode, $Str_ProName, $Str_TaskCode, $Str_TaskName, $_POST["optPriority"], $_POST["txtTaskDescription"], $Dte_SysDate);
                /*
                $mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'outbounds10.obsmtp.com';
                $mail->SMTPDebug  = 2;
                $mailer->SMTPAuth = TRUE;
                $mail->SMTPSecure = "tls";
                $mail->Port       = 587;
                $mailer->Username = 'info@tropicalfishofasia.com';  // Change this to your gmail adress
                $mailer->Passwosrd = 'info@321';  // Change this to your gmail password
                $mailer->From = $StrFromMail;  // This HAVE TO be your gmail adress
                $mailer->FromName = $StrSenderName; // This is the from name in the email, you can put anything you like here
                $mailer->Body = $MagBody;*/

            /* ----------------------------------------------------------------- */
                $mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';//	$mailer->Host = '10.9.0.166:25';					// $mailer->Host = 'ssl://smtp.gmail.com:465';
                $mailer->SetLanguage("en", 'class/');						// $mailer->SetLanguage("en", 'class/');
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//$mailer->IsHTML = TRUE;
                $mailer->Username = 'pms@eteknowledge.com';//$mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress			$mailer->Username = 'info@tropicalfishofasia.com';
                $mailer->Password = 'Cissmp@456';//	$mailer->Password = 'pms@321';  // Change this to your gmail password							$mailer->Password = 'info321';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','Work Flow');
				$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =str_replace('"','\'',$MagBody);
				// $mailer->From = $StrFromMail;  // This HAVE TO be your gmail adress
                // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                // $mailer->Body = $MagBody;
                /* ----------------------------------------------------------------- */

                $MailTitile =   "TO : ".getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$_ProInit)." - TASK UPDATE- ".$_Division." ".$_Department." - ".$Str_TaskName;
                $mailer->Subject = $MailTitile;

                $mailer->AddAddress($StrToMail);  // This is where you put the email adress of the person you want to mail

                //echo $StrFromMail;
                $MailsCC = explode("-", $MailCCTo);

                for($a=0;$a<(sizeof($MailsCC)-1);$a++){
                    $mailer->AddCC($MailsCC[$a]);
                    //echo "RRER".$MailsCC[$a]."ttt<BR>";
                }
                //$mailer->AddCC($StrFromMail);
               // $mailer->AddCC('shameerap@cisintl.com');
                //$mailer->AddBCC($StrFromMail);
				
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
				
                if(!$mailer->Send())
                {
                   echo "Message was not sent<br/ >";
                   echo "Mailer Error: " . $mailer->ErrorInfo;
                }
                else
                {
                   //echo "Message has been sent";
                }

                echo "<div class='Div-Msg' id='msg' align='left'>*** Project Created Successfully</div>";
            }elseif($_SESSION["DataMode"] == "E"){
//                update_project($str_dbconnect,$_POST["txtProCode"], $_POST["txtProName"], $_POST["txt_StartDate"]);
//                $Str_ProCode    = $_POST["txtProCode"];
//                $Str_ProName    = $_POST["txtProName"];
//                $Dte_Startdate  = $_POST["txt_StartDate"];
//                echo "<div class='Div-Msg' id='msg' align='left'>*** Project Updated Successfully</div>";
            }

            $bool_ReadOnly          = "TRUE";
            $Save_Enable            = "No";
            $_SESSION["DataMode"]   = "E";
            $_SESSION["ProjectCode"]= "";

            $EstimatedHours = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);

            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

        }

        if(isset($_POST['btnBack'])) {
            //header("Location:M_Reference.php");

            if((isset($_SESSION["BackPageApp"])) && ($_SESSION["BackPageApp"] == "Main")){
                echo "<script>";
                echo " self.location='Home.php';";
                echo "</script>";
            }else{
                
            }
        }

    ?>
<!--    <div id="container">   -->         

<form name="frm_porject" id="frm_porject" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" class="cmxform">

<!--<div id="Div-Form_Back" >
    <input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="     " size="5"/>
</div>
<div id="Div-Form_Search">
    <input type="submit" id="btnSearch" name="btnSearch" title="Search Task Details" class="buttonSearch" value="     " size="5"  />
</div>-->

<!--creating data entry Interface-->

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
                                                <font color="#0066FF"> Welcome, </font> <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]) ?>                                                
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>
                                    <br><br>
									<table width="80%" cellpadding="0" cellspacing="0" border="0px" style="background-color: #E0E0E0; border-width: 1px" align="center">
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>
                                        <tr style="">
                                            <td style="padding-left: 10px;position: relative" align="left" width="20%">
                                            	Project Owner     
                                            </td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
												:	
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left">
												<?php echo getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_ProOwner); ?>
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
													
											</td>
											<td style="padding-left: 10px;position: relative" align="left" width="20%">
                                            	Task Owners
                                            </td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
												:	
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left">
												<?php													
													$_ResultSet = getTASKUSERFACILITIES($str_dbconnect,$Str_TaskCode);
									                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
									                	echo getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowRes['EmpCode'])."</br>";
													}
												?>
											</td>
										</tr>
                                        <tr>
											<td colspan="3">&nbsp;</td>
										</tr>
                                        <tr style="">
											<td style="padding-left: 10px;position: relative" align="left" width="20%">
                                            	Project Initiator   
                                            </td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
												:	
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left">
												<?php echo getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_ProInit); ?>
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
													
											</td>
											<td style="padding-left: 10px;position: relative" align="left" width="20%">
                                            	Project Creator
                                            </td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
												:	
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left">
												<?php echo GetProjectCreator($str_dbconnect,$_ProCrt);?>
											</td>
                                        </tr>
										<tr>
											<td colspan="3">&nbsp</td>
										</tr>
										<tr style="">
											<td style="padding-left: 10px;position: relative" align="left" width="20%">
                                            	Project Initiate Date    
                                            </td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
												:	
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left">
												<?php echo $_ProCrtdate; ?>
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
													
											</td>
											<td style="padding-left: 10px;position: relative" align="left" width="20%">
                                            	Date Completed
                                            </td>
											<td tyle="padding-left: 10px;position: relative" align="left" width="2%">
												:	
											</td>
											<td tyle="padding-left: 10px;position: relative" align="left">
												<?php													
													$_ResultSet = GetTaskCompleteLast($str_dbconnect,$Str_TaskCode);
													while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
									                	echo $_myrowRes['UpdateDate'];
													}
												?>
											</td>
                                        </tr>
                                        <tr>
											<td colspan="3">&nbsp;</td>
										</tr>
                                        
                                    </table>  
									<br><br>
                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>   
												<input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" value="Back to Previous Screen" size="5"/>                                             
                                            	<table width="100%" cellpadding="0" cellspacing="8px">	                                                
													<tr>
	                                                    <td width="20%">
	                                                    	Project Code    
	                                                    </td>
	                                                    <td width="2%">:</td>
	                                                    <td>
	                                                    	<input type="text" id="txtProCode" name="txtProCode" class="Div-TxtStyle" size="20" value="<?php echo $Str_ProCode; ?>" readonly="readonly"/>    
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                    	Project Name    
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                    	<input type="text" id="txtProName" name="txtProName" class="Div-TxtStyle" size="60" value="<?php echo $Str_ProName; ?>" readonly="readonly"/>    
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                    	Task Code    
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                    	<input type="text" id="txtTaskCode" name="txtTaskCode" class="Div-TxtStyle" size="20" value="<?php echo $Str_TaskCode; ?>" readonly="readonly"/>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                    	Task Name    
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                    	<input type="text" id="txtTaskName" name="txtTaskName" class="Div-TxtStyle" size="60" value="<?php echo $Str_TaskName; ?>" readonly="readonly"/>    
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="20%">
	                                                    	Category    
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                    	<input id="optPriority" name="optPriority" class="required ui-widget-content" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> value="<?php echo $_optPriority; ?>">    
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td>
	                                                        Percentage Completed
	                                                    </td>
	                                                    <td></td>
														
	                                                    <td>
	                                                        <input type="hidden" id="hidden" name="hidden" class="TextBoxStyle" value="<?php echo $Precentage; ?>" size="10" readonly="readonly"/>
	                                                    </td>
	                                                </tr>
	                                                
	                                                <div class="slider" style="top: 155px; left: 24%; width: 200px"></div>
													
	                                                <div id="slider-result" style = "margin-top: -20px;"><?php echo $Precentage; ?> % Completed</div>
															
	                                                <script>
	                                                    $( ".slider" ).slider({
	                                                        animate: true,
	                                                        range: "min",
	                                                        value: <?php echo $Precentage; ?>,
	                                                        min: 1,
	                                                        max: 100,
	                                                        step: 1,
	
	                                                        //this gets a live reading of the value and prints it on the page
	                                                        slide: function( event, ui ) {
	                                                            $( "#slider-result" ).html( ui.value + '% Completed' );
	                                                        },
	
	                                                        //this updates the hidden form field so we can submit the data using a form
	                                                        change: function(event, ui) {
	                                                        $('#hidden').attr('value', ui.value);
	                                                        }
	                                                    });
	                                                </script>
													
													<tr>
	                                                    <td width="20%">
	                                                    	Update Details    
	                                                    </td>
	                                                    <td width="2%"></td>
	                                                    <td>
	                                                    	<textarea cols="80" rows="5" style="width: 100%" id="txtTaskDescription" name="txtTaskDescription" class="tinymce" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>><?php echo $Str_TaskDescription;?></textarea>
	                                                    </td>
	                                                </tr>													
                                                <div id="timepicker"></div>
                                                
                                                <tr>
                                                    <td>Update Latest Hours Spent</td>
                                                    <td>:</td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td>From</td>
                                                                <td width="50px" align="center">:</td>
                                                                <td>
                                                                    <input type="text" name="txtStart" id="txtStart"  class="TextBoxStyle" value="00:00" size="9" onchange="getTimeDiff()" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?> align="center"/>
                                                                    <script type="text/javascript">
                                                                        $('#txtStart').timepicker({
                                                                            timeFormat: 'h:m',
                                                                            separator: ' @ '
                                                                        });                                                                        
                                                                    </script>
                                                                </td>
                                                                <td width="20px" align="center"></td>
                                                                <td>To</td>
                                                                <td width="50px" align="center">:</td>
                                                                <td>
                                                                    <input type="text" name="txtEnd" id="txtEnd"  class="TextBoxStyle" value="00:00" size="9" onchange="getTimeDiff()" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?> align="center"/>
                                                                    <script type="text/javascript">
                                                                        $('#txtEnd').timepicker({
                                                                            timeFormat: 'h:m',
                                                                            separator: ' @ '
                                                                            });                                                                        
                                                                    </script>  
                                                                </td>
                                                                <td width="20px" align="center"></td>
                                                                <td>OR Total Hours Spent</td>
                                                                <td width="50px" align="center">:</td>
                                                                <td>
                                                                    <input type="text" id="txtHoursSpent" name="txtHoursSpent" class="TextBoxStyle" size="9" value="<?php echo $Str_txtHoursSpent; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?> align="center"/>
                                                                </td>
                                                            </tr>
                                                        </table>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><br/></td>
                                                </tr>
												<tr>
                                                    <td>Hours Summary</td>
                                                    <td>:</td>
                                                    <td>
                                                        <table width="100%" cellpadding="0" cellspacing="8px">
                                                            <tr>
                                                                <td>
                                                                    Hrs Estimated
                                                                </td>
                                                                <td align="center">:</td>
                                                                <td>
                                                                    <input type="text" name="txtHrsEstimated" id="txtHrsEstimated" class="TextBoxStyle" value="<?php echo $EstimatedHours; ?>" size="9" readonly="readonly" align="center"/>
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    Addl Hrs Requested
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <input type="text" name="txtHrsRequested" id="txtHrsRequested"  class="TextBoxStyle" value="<?php echo $AddlHrsRequest; ?>" size="9" onchange="getTimeDiff()" readonly="readonly" align="center"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Addl Hrs Approved
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <input type="text" name="txtHrsEstimated" id="txtHrsEstimated" class="TextBoxStyle" value="<?php echo $EstimatedHours; ?>" size="9" readonly="readonly" align="center"/>
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    Hrs Remaining
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <input type="text" id="txtHrsRemaining" name="txtHrsRemaining" class="TextBoxStyle" size="9" value="" readonly="readonly" align="center"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Request Additional Hours</td>
                                                                <td>:</td>
                                                                <td>
                                                                    <input type="text" name="txtHrsRequest" id="txtHrsRequest"  class="TextBoxStyle" value="00:00" size="9" onchange="getTimeDiff()" readonly="readonly" align="center"/>
                                                                    <script type="text/javascript">
                                                                        $('#txtHrsRequest').timepicker({
                                                                            timeFormat: 'h:m',
                                                                            separator: ' @ '
                                                                            });
                                                                        //$('example3').timepicker();
                                                                    </script>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </table>     
                                                    </td>
                                                </tr> 
                                                <tr>
                                                    <td colspan="3"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center">
                                                        <table width="90%" cellpadding="0" cellspacing="8px" border="0" style="background-color: #E0E0E0;">
                                                            <tr>
                                                                <td align="left" width="50%">
                                                                    <b>Download Task Support Documents</b>
                                                                </td>
                                                                <td align="left" width="50%">
                                                                    <b>Download - Task Relate Documents</b>                                                                    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" style="vertical-align: text-top">
                                                                    <p>
                                                                        <?php
                                                                            $ItemCount = 0;
                                                                            $_ResultSet      = get_projectupload($Str_ProCode) ;
                                                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                                $ItemCount += 1;
                                                                            //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                                                                        ?>
                                                <!--                           <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>-->
                                                                        <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a> | <font color="red"><a style="color: Red" href="updateTaskMain.php?taskcode=<?php echo $Str_TaskCode?>&DocCode=<?php echo $_myrowRes['ProCode'] ; ?>">Remove</a></font><br>
                                                                        <?php }
                                                                            if($ItemCount == 0) {
                                                                                echo "* No Documents Attached"  ;
                                                                            }
                                                                        ?>

                                                                    </p>
                                                                </td>
                                                                <td align="left" style="vertical-align: text-top">
                                                                    <?php
                                                                        $ItemCount = 0;
                                                                        $_ResultSet      = get_projectuploadupdates($Str_TaskCode) ;
                                                                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                            $ItemCount += 1;
                                                                    ?>
                                                                    <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a> | <font color="red"><a style="color: Red" href="updateTaskMain.php?taskcode=<?php echo $Str_TaskCode?>&DocCode=<?php echo $_myrowRes['ProCode'] ; ?>">Remove</a></font><br>

                                                                    <?php } 
                                                                        if($ItemCount == 0) {
                                                                            echo "* No Documents Attached"  ;
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>     
                                                <tr>
                                                    <td colspan="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>TASK Alerts Recepient List</td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                            $ProOwnerMail       =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner);
                                                            $StrToMail          =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInit);

                                                            if($StrToMail != ""){

                                                                echo "<input type='checkbox' id='chk1'/>&nbsp;". $StrToMail. " - [ Project Initiator ]<br>";
                                                                echo "<input type='checkbox' id='chk2'/>&nbsp;". $ProOwnerMail." - [ Project Primary Owner ]<br>";
                                                                echo "<input type='checkbox' id='chk3'/>&nbsp;". getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner)." - [ Project Secondary Owner ]<br>";
                                                                echo "<input type='checkbox' id='chk4'/>&nbsp;". getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport)." - [ Project Supporter ]<br>";
                                                                echo "<input type='checkbox' id='chk5'/>&nbsp;". getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt)." - [ Project Creator ]<br>";

                                                                $MailsCC = explode("-", $MailCCTo);

                                                                for($a=0;$a<(sizeof($MailsCC)-1);$a++){
                                                                    echo "<input type='checkbox' id='chk1".$a."'/>&nbsp;".$MailsCC[$a]."<br>";
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                    	Task Approve / Reject Note   
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                    	<textarea cols="80" rows="5" style="width: 100%" id="txtAppNote" name="txtAppNote" class="tinymce" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>><?php //echo $Str_TaskDescription;?></textarea>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="3" align="center">
                                                        <table width="60%" cellpadding="0" cellspacing="0">
                                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">
																
																	<?php
											                            if($_optPriority == "Task Completed"){
											                        ?>
											                                <input name="btnSave" id="btnSave" type="submit"  value="Approve Task Completion" />&nbsp
											                                <input name="btnReject" id="btnReject" type="submit"  value="Reject" />
											                        <?php
											                            }
											                        ?>
											
											                        <?php
											                            if($_optPriority == "Addl Hrs Request"){
											                        ?>
											                                <input name="btnApprove" id="btnApprove" type="submit"  value="Approve Addl. Hrs." />&nbsp
											                                <input name="btnCancel" id="btnCancel" type="submit"  value="Cancel" />
											                        <?php
											                            }
											                        ?>
																
                                                                    <!--<input name="btnSave" id="btnSave" type="button" value="Save All Updates" <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?> onclick="startUpload()" />&nbsp;                                                
                                                                    &nbsp;<input name="btnCancel" id="btnCancel" type="reset"  value="Cancel" />-->
                                                                </td>                                            
                                                            </tr>
                                                        </table>
                                                    </td>                                                    
                                                </tr> 												
												</table>  
												<table width="60%" cellpadding="0" cellspacing="0" align="center">
                                                <tr style="height: 50px;">
                                                    <td style="padding-left: 10px; font-size: 18px;" align="center">
                                                        <u>Task Update History</u>
                                                    </td>                                            
                                                </tr>
                                            </table>
                                            <table cellpadding="0" cellspacing="0" class="display" border="0" id="example" title="Task Update History" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width="20%">Category</th>
                                                        <th>Note</th>
                                                        <th width="20%">Update Date</th>
                                                        <th width="20%">Update By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $ColourCode     = 0 ;
                                                        $LoopCount      = 0;
                                                        $taskcode       = "";

                                                        if (isset($_SESSION["taskcode"])){
                                                           $taskcode = $_SESSION["taskcode"];
                                                        }
                                                        $_ResultSet = updateTaskStatusDetails($str_dbconnect,$taskcode);
                                                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                            if ($ColourCode == 0 ) {
                                                                $Class = "gradeA" ;
                                                                $ColourCode = 1 ;
                                                            } elseif ($ColourCode == 1 ) {
                                                                $Class = "gradeA";
                                                                $ColourCode = 0 ;
                                                            }
                                                    ?>
                                                        <tr class="<?php echo $Class; ?>">
                                                            <td><?php echo $_myrowRes['category']; ?></td>
                                                            <td><?php echo $_myrowRes['Note']; ?></td>
                                                            <td >
                                                                <?php
                                                                    echo $_myrowRes['UpdateDate'];?>
                                                            </td>
                                                            <td><?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_myrowRes['UpdateUser']); ?></td>
                                                        </tr>
                                                    <?php
                                                        $LoopCount = $LoopCount + 1;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                            
                                            <?php
                                                echo "<script>";
                                                echo "getTimeDiffRemaining('".$HoursSpent."','".$EstimatedHours."')";
                                                echo "</script>";
                                            ?>     
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
