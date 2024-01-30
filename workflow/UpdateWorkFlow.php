<?php
session_start();
include("../connection/sqlconnection.php"); //  connection file to the mysql database    
include("../class/accesscontrole.php"); //  sql commands for the access controles
include("../class/sql_empdetails.php"); //  connection file to the mysql database
include("../class/sql_crtprocat.php");            //  connection file to the mysql database
require_once("../class/class.phpmailer.php");
require_once("../class/class.SMTP.php");
#include ("../class/MailBodyOne.php"); //  connection file to the mysql database
// include ("uploadify/UploadUserAttachments.php");  
include("../class/sql_wkflow.php");            //  connection file to the mysql database

mysqli_select_db($str_dbconnect, "$str_Database") or die("Unable to establish connection to the MySql database");
$path = "../";
$Menue    = "UpdateWF";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS - WORK FLOW ::.</title>

    <link href="../css/styleB.css" rel="stylesheet" type="text/css" />

    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />

    <script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>

    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />

    <style type="text/css">
        /* preloader DIV-Styles*/
        #preloader {
            display: none;
            /* Hide the DIV */
            position: fixed;
            _position: absolute;
            /* hack for internet explorer 6 */
            height: 405px;
            width: 670px;
            background: #FFFFFF;
            left: 350px;
            top: 160px;
            z-index: 100;
            /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
            margin-left: 15px;

            /* additional features, can be omitted */
            border: 8px solid #06F;
            padding: 15px;
            font-size: 15px;
            -moz-box-shadow: 0 0 5px #ff0000;
            -webkit-box-shadow: 0 0 5px #ff0000;
            box-shadow: 0 0 20px #ff0000;

        }

        #dialog-modal {

            display: none;
        }

        #container {
            background: #d2d2d2;
            /*Sample*/
            width: 100%;
            height: 100%;
        }

        #popupBoxClose {
            margin: 15px;
        }

        a {
            cursor: pointer;
            text-decoration: none;
        }

        /* This is for the positioning of the Close Link */
        #popupBoxClose {
            font-size: 20px;
            line-height: 15px;
            right: 5px;
            top: 5px;
            position: absolute;
            color: #F00;
            font-weight: 500;
        }
    </style>


    <!-- Jquery Notification Plugin -->
    <script type="text/javascript" src="jQuerry/js/jquery.notify.js"></script>
    <link type="text/css" href="jQuerry/css/ui.notify.css" rel="stylesheet" />
    <!-- Jquery Notification Plugin -->


    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>
    <script type="text/javascript" src="../js/jquery.fileupload.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
    <!-- <script type="text/javascript" src="../js/jquery.leanModal.min.js"></script>-->

    <!-- **************** TIME PICKER START  ***************** -->
    <!-- <script type="text/javascript" src="../jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>    

    <link rel="stylesheet" href="../jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />-->
    <script type="text/javascript" src="../js/jquery-ui-timepicker-addon.js"></script>

    <script type="text/javascript">
        $(function() {
            $("input:submit", ".demo").button();
        });

        function getHours() {
            var t1 = document.getElementById("txt_StartTime").value;
            var t2 = document.getElementById("txt_EndTime").value;

            var timeFormat = /^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;

            // Check if the input time values have the correct format
            if (!timeFormat.test(t1) || !timeFormat.test(t2)) {
                alert("Invalid time format. Please enter time in the format hh:mm:ss.");
            } else {
                var one_hour = 1000 * 60 * 60;

                var time1 = new Date("January 1, 1970 " + t1);
                var time2 = new Date("January 1, 1970 " + t2);

                var diff = Math.abs(time2.getTime() - time1.getTime());

                var hours = Math.floor(diff / one_hour);
                var minutes = Math.floor((diff % one_hour) / (1000 * 60));
                var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                var formattedDuration = pad(hours) + ":" + pad(minutes) + ":" + pad(seconds);

                document.getElementById("duration").value = formattedDuration;
            }

            function pad(n) {
                return (n < 10) ? "0" + n : n;
            }
        }
    </script>


    <style type="text/css">
        .radio_b {
            padding: 1px 5px 1px 5px;
            background-color: transparent;
            cursor: default;
            border: 0px;
            vertical-align: middle
        }
    </style>


    <script type="text/javascript">
        var queueSize = 0;

        function startUpload() {

            var valdator = true;
            //valdator = $("#frm_WorkFlow").valid();
            if (valdator != false) {
                if (queueSize == 0) {
                    alert("No Any Files to Upload!");
                    document.forms['frm_WorkFlow'].action = "createworkflow.php?btn_Save=btn_Save";
                    document.forms['frm_WorkFlow'].submit();
                } else {
                    $('#fileUploadstyle').fileUploadStart();
                }
            }
        }

        function create(template, vars, opts) {
            return $container.notify("create", template, vars, opts);
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
                'onCancel': function(a, b, c, d) {
                    queueSize = d.fileCount;
                },
                'onClearQueue': function(a, b) {
                    queueSize = b.fileCount;
                },
                'onSelectOnce': function(a, b) {
                    queueSize = b.fileCount;
                },
                'onComplete': function(event, ID, fileObj, response, data) {
                    alert('complete');
                    //alert('There are ' + data.fileCount + ' files remaining in the queue.');
                },
                'onAllComplete': function(event, data) {
                    queueSize = 0;
                    alert(data.filesUploaded + ' files uploaded successfully!');
                    document.forms['frm_WorkFlow'].action = "createworkflow.php?btn_Save=btn_Save";
                    document.forms['frm_WorkFlow'].submit();
                }
            });
        });

        /*  $(window).load(function() { 
               $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
          }); */

        function getWFDetails() {
            sort = document.getElementById("cmbSort").value;
            sort2 = document.getElementById("cmbSort2").value;
            document.forms['frm_WorkFlow'].action = "Updateworkflow.php?sort=" + sort + "&sort2=" + sort2 + "";
            document.forms['frm_WorkFlow'].submit();
        }

        $(function() {
            // initialize widget on a container, passing in all the defaults.
            // the defaults will apply to any notification created within this
            // container, but can be overwritten on notification-by-notification
            // basis.

            $container = $("#container").notify();

            // create two when the pg loads
            /*create("default", { title:'Default Notification', text:'Example of a default notification.  I will fade out after 5 seconds'});
            create("sticky", { title:'Process Compete', text:'Re do the Process'},{ expires:false });			
            create("sticky", { title:'Update Notification', text:'make sure to update task complete Hours'},{ expires:false });			
            create("sticky", { title:'Completed', text:'Test The System Details'},{ expires:false });
            create("sticky", { title:'Work Flow', text:'test'},{ expires:false });	*/

        });
    </script>

    <script type="text/javascript">
        $(window).load(function() {
            $('#preloader').fadeOut('slow', function() {
                $(this).remove();
            });
        });

        $(document).ready(function() {

            // When site loaded, load the Popupbox First
            //loadPopupBox();

            $('#popupBoxClose').click(function() {
                unloadPopupBox();

            });

            $('#container').click(function() {
                unloadPopupBox();
            });


        });

        function unloadPopupBox() { // TO Unload the Popupbox
            $('#preloader').fadeOut("slow");
            $("#container").css({ // this is just for style        
                "opacity": "1"
            });
            document.forms['frm_WorkFlow'].submit();
        }

        function loadPopupBox() {
            $('#preloader').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "0.3"
            });
        }

        function OpenEditWindow(workid) {
            window.location.href = 'UploadAttachments.php?id=' + workid + '';
            //$('#UploadDocuments').attr('src', 'UploadAttachments.php?id='+workid+'');	
        }
    </script>
    <script>
        $(function() {
            // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
            $("#dialog:ui-dialog").dialog("destroy");

            $("#dialog-modal").dialog({
                height: 600,
                modal: true,
                autoOpen: false,
                width: 1000
            });
        });

        function buttonclose() {
            $("#dialog-modal").toggle();
        }

        function ShowUserWF(EmpUser) {
            //$("#dialog-modal").toggle();  
            //$("#dialog-modal").dialog("open");//http://localhost:86/PMS/Workflow/
            //$("#modalIframeId").attr("src", "PopupuserWf.php?empUser="+EmpUser); 
            window.open("PopupuserWf.php?empUser=" + EmpUser);
            return false;
        }

        function AddUserWF() {
            $("#dialog-modal").dialog("open"); //http://localhost:86/PMS/Workflow/
            $("#modalIframeId").attr("src", "CustomeWF.php");
            return false;
        }
    </script>
</head>

<body>
    <div id="preloader"></div>
    <div id="preloader"> <!-- OUR PopupBox DIV-->
        <iframe id="UploadDocuments" width="670px" height="405px" frameborder="0" scrolling="no"></iframe>
        <a id="popupBoxClose">Close(X)</a>
    </div>

    <div id="dialog-modal" title="Basic dialog">
        <a id="popupBoxClose" onclick="buttonclose()">Close(X)</a>
        <iframe id="modalIframeId" width="100%" height="100%" style="background-color:#E6E6E6" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto" title="Dialog Title">
        </iframe>
    </div>

    <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">


        <?php

        $timezone = "Asia/Colombo";

        $Country = $_SESSION["LogCountry"];

        if ($Country == "SL") {
            $timezone = "Asia/Colombo";
        }

        if ($Country == "US") {
            $timezone = "America/Los_Angeles";
        }

        if ($Country == "TI") {
            $timezone = "Asia/Bangkok";
        }
        if ($Country == "CN") {
            $timezone = "Asia/Hong_Kong";
        }
        if ($Country == "AU") {
            $timezone = "Australia/Melbourne";
        }
        //date_timezone_set($date, timezone_open($timezone));

        date_default_timezone_set($timezone);
        //date.timezone = $timezone;

        $LogUserCode = $_SESSION["LogEmpCode"];
        /* console.log("Hello world!");  */
        $today_date  = date("Y-m-d");

        $wk_update  =   "";
        $status     =   "";

        $Message    =   "";
        $sortby = "NRM";
        $sortby2 = "TME";

        if (isset($_POST["btn_addworkflow"])) {
            $_LogEMPCODE = $_SESSION["LogEmpCode"];
            //header("Location: viewAddWorkFlow.php?logempid=$_LogEMPCODE");
            echo ("<script>location.href = 'viewAddWorkFlow.php?logempid=$_LogEMPCODE';</script>");
        }

        if (isset($_GET["logempid"])) {
            $logid = $_GET["logempid"];
            $Dte_StartDate  = date("Y-m-d");
        }


        if (isset($_GET["sort"])) {
            $sortby = $_GET["sort"];
            $sortby2 = $_GET["sort2"];
        }

        $Country = $_SESSION["LogCountry"];

        if ($Country == "SL") {
            $timezone = "Asia/Colombo";
        }

        if ($Country == "US") {
            $timezone = "America/Los_Angeles";
        }

        if ($Country == "TI") {
            $timezone = "Asia/Bangkok";
        }
        if ($Country == "CN") {
            $timezone = "Asia/Hong_Kong";
        }
        if ($Country == "AU") {
            $timezone = "Australia/Melbourne";
        }
        Get_DailyWorkFlow($str_dbconnect, $LogUserCode, $Country);
        Get_WeeklyWorkFlow($str_dbconnect, $LogUserCode, $Country);
        Get_MonthlyWorkFlow($str_dbconnect, $LogUserCode, $Country);
        Get_DailyEQFlow($str_dbconnect, $LogUserCode, $Country);

        updateSummary($str_dbconnect, $LogUserCode);

        $_ResultSet = getEMPLOYEEDETAILSWFSupervisor($str_dbconnect, $LogUserCode);
        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {


            $wk_id        =    $_myrowRes['EmpCode'];
            $wk_Owner      =     $LogUserCode;
            $wk_name      =     "Review W/Fs";
            $start_time =     "18:00";
            $end_time     =     "19:00";
            $catcode     =     "1";
            $Wf_Desc     =     "Review Work Flow of " . $_myrowRes['FirstName'] . " " . $_myrowRes['LastName'] . "";
            $WFUser_cat =     "0";
            $crt_date   = date("Y-m-d");

            $HasData = "No";

            // $_SelectQuery516 	=   "SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode'";        
            // $_ResultSet516 	=   mysqli_query($str_dbconnect,$_SelectQuery516) or die(mysqli_error($str_dbconnect));
            // $num_rows = mysqli_num_rows($_ResultSet516);

            // echo '<script>console.log("count'.$num_rows.'")</script>';
            $_SelectQuery56     =   "SELECT `wk_name` FROM tbl_workflowupdate WHERE `crt_date` = '$crt_date' AND `wk_Owner` = '$LogUserCode' AND `wk_id` = '$wk_id'";
            $_ResultSet56     =   mysqli_query($str_dbconnect, $_SelectQuery56) or die(mysqli_error($str_dbconnect));
            $num_rows = mysqli_num_rows($_ResultSet56);
            echo '<script>console.log("count' . $num_rows . '")</script>';

            while ($_myrowRes56 = mysqli_fetch_array($_ResultSet56)) {
                $HasData = "Yes";
            }

            if ($HasData == "No" && $wk_id != $wk_Owner) {
                $_SelectQuery99     =   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`)
	                                VALUES ('$wk_id', '$wk_Owner', '$wk_name', '$crt_date', '$start_time', '$end_time',  'No', '$catcode', '$Wf_Desc')" or die(mysqli_error($str_dbconnect));

                mysqli_query($str_dbconnect, $_SelectQuery99) or die(mysqli_error($str_dbconnect));
            }
        }

        if (isset($_POST["btn_Save"])) {

            /*  //echo "PAGE SUBMIT";
            if($_FILES['fileOne']){
                echo "one";
                //var_dump($_FILES['fileOne']);
                $result = array_filter($_FILES['fileOne']);                 
                var_dump($result);
            }else if($_FILES['fileTwo']){
                echo "two";
                var_dump($_FILES['fileTwo']);
            }
            else if($_FILES['fileThree']){
                echo "three";
                var_dump($_FILES['fileThree']);
            }
            else if($_FILES['fileFour']){
                echo "four";
                var_dump($_FILES['fileFour']);
            }else if($_FILES['fileFive']){
                echo "five";
                var_dump($_FILES['fileFive']);
            } */

            /* var_dump($_FILES);
            var_dump($_FILES['file']['name']); 
            echo count(array_filter($_FILES['file']['name']));
            $filecount = sizeof($_FILES['file']['name']);
            echo $filecount;
                if($filecount!=0){
                    for($i=0;$i<$filecount;$i++){
                        if($_FILES['file']['name']!=''){
                            fileUploadTaskNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['type'][$i]);  
                        }  
                }  
            } */

            $_ResultSet = browseTask($str_dbconnect, $LogUserCode);
            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                $InputBox = $_myrowRes['wk_id'] . "-COM";
                $RadioButton = $_myrowRes['wk_id'] . "-RDO";

                $TimeButton     = $_myrowRes['wk_id'] . "-RDOT";
                $TimeBox         = $_myrowRes['wk_id'] . "-TIME";
                $TimeStart         = $_myrowRes['wk_id'] . "-FMTIME";

                $wk_id = $_myrowRes['wk_id'];

                updateWorkFlow($str_dbconnect, $LogUserCode, $_myrowRes['wk_id'], mysqli_real_escape_string($str_dbconnect, $_POST[$InputBox]), $_POST[$RadioButton], $_POST[$TimeButton],  $_POST[$TimeBox], $_POST[$TimeStart]);
            }


            //$Message = "<script type='text/javascript'>
            //						alert('W/F Updated Only.. please Make sure to Send the Mail Once you complete All W/F | W/F actualiza solo .. por favor asegúrese de enviar el correo Una vez que complete todas W/F');
            //						window.location.href = '../Home.php';
            //					";
        }

        if (isset($_POST["btn_Mail"])) {

            $wk_id = "";
            $_ResultSet = browseTask($str_dbconnect, $LogUserCode);
            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                $InputBox = $_myrowRes['wk_id'] . "-COM";
                $RadioButton = $_myrowRes['wk_id'] . "-RDO";

                $TimeButton     = $_myrowRes['wk_id'] . "-RDOT";
                $TimeBox         = $_myrowRes['wk_id'] . "-TIME";
                $TimeStart         = $_myrowRes['wk_id'] . "-FMTIME";

                $wk_id = $_myrowRes['wk_id'];
                updateWorkFlow($str_dbconnect, $LogUserCode, $_myrowRes['wk_id'], mysqli_real_escape_string($str_dbconnect, $_POST[$InputBox]), $_POST[$RadioButton], $_POST[$TimeButton],  $_POST[$TimeBox], $_POST[$TimeStart]);
            }

            /* ----------------------------------------------------------------- */
            $mailer = new PHPMailer();
            $mailer->IsSMTP();
            $mailer->Host = 'smtp.office365.com'; //$mailer->Host = '10.9.0.166:25';					//$mailer->Host = 'ssl://smtp.gmail.com:465';
            $mailer->SetLanguage("en", 'class/');                        // $mailer->SetLanguage("en", 'class/');
            $mailer->SMTPAuth = TRUE;
            $mailer->IsHTML(true);
            $mailer->Username = 'pms@eteknowledge.com'; //$mailer->Username = 'pms@eTeKnowledge.com'; // Change this to your gmail adress      $mailer->Username = 'info@tropicalfishofasia.com';
            $mailer->Password = 'Cissmp@456'; //$mailer->Password = 'pms@321'; // Change this to your gmail password                         $mailer->Password = 'info321';
            $mailer->Port = 587;
            $mailer->SetFrom('pms@eteknowledge.com', 'Work Flow');
            //$mailer->CharSet = "text/html; charset=UTF-8;";
            //$mailer->SMTPDebug = 2; 

            //$mailer->From = 'pms@eTeKnowledge.com'; //$StrFromMail; // This HAVE TO be your gmail adress    $mailer->From = 'info@tropicalfishofasia.com';				
            //$mailer->FromName = 'Work Flow'; // This is the from name in the email, you can put anything you like here

            $MagBody  = getWFUPDATEMAIL($str_dbconnect, $LogUserCode);
            //$mailer->Body = $MagBody;
            $mailer->Body = str_replace('"', '\'', $MagBody);
            /* ----------------------------------------------------------------- */
            $TskUser =  getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect, $LogUserCode);
            $today_date  = date("Y-m-d");
            $Country = $_SESSION["LogCountry"];
            $WKOwner = Get_Supervior($str_dbconnect, $LogUserCode, $Country);

            $timestamp = strtotime($today_date);
            $TodayDay = date("l", $timestamp);

            //$mailer->AddAddress('shameerap@cisintl.com');
            //$mailer->AddAddress('piumit@cisintl.com');
            //  $mailer->AddCC('indikag@cisintl.com');  // Commented by thilina on 2014-05-06 due to request from Mr. janidu (Requested from mr. Niluka)

            $MailTitile = $WKOwner . " - " . $TodayDay . " Date : " . $today_date . "";
            $mailer->Subject = $MailTitile;
            $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect, $LogUserCode);

            $mailer->AddAddress($MailAddressDpt);


            $_SelectQuery     =   "SELECT * FROM tbl_wfalert WHERE FacCode = '$wk_id'";
            $_ResultSet     = mysqli_query($str_dbconnect, $_SelectQuery) or die(mysqli_error($str_dbconnect));

            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $EmpDpt           =   $_myrowRes['EmpCode'];

                $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect, $EmpDpt);

                $mailer->AddAddress($MailAddressDpt);
            }

            //$MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$LogUserCode);
            $_SelectQuery2    =   "SELECT * FROM tbl_workflow WHERE wk_Owner='$LogUserCode'";
            $_ResultSet2     = mysqli_query($str_dbconnect, $_SelectQuery2) or die(mysqli_error($str_dbconnect));
            while ($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) {
                $rpowner           =   $_myrowRes2['report_owner'];
                $rpmail = getSELECTEDEMPLOYEEMAIL($str_dbconnect, $rpowner);
                $mailer->AddCC($rpmail);
                $crtby           =   $_myrowRes2['crt_by'];
                $crtbymail = getSELECTEDEMPLOYEEMAIL($str_dbconnect, $crtby);
                $mailer->AddCC($crtbymail);
                $wowner          =   $_myrowRes2['wk_Owner'];
                $wownermail = getSELECTEDEMPLOYEEMAIL($str_dbconnect, $wowner);
                $mailer->AddCC($wownermail);
            }
            $mailer->AddBCC('pms@cisintl.com');
            //$mailer->AddBCC('shameerap@cisintl.com');

            /*Adding Bcc Function on 2014-07-16 by thilina*/
            $_SelectQuery = "";
            $_SelectQuery     =   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='WORKFLOW' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
            $_ResultSet     =   mysqli_query($str_dbconnect, $_SelectQuery) or die(mysqli_error($str_dbconnect));
            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                if ($_SESSION["LogEmpCode"] == $_myrowRes['OwnerEmpCode']) {
                    $loggedUser = $_myrowRes['OwnerEmpCode'];
                    $_SelectQuery = "";
                    $_SelectQuery     =   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='WORKFLOW' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
                    $_ResultSet2     =   mysqli_query($str_dbconnect, $_SelectQuery) or die(mysqli_error($str_dbconnect));
                    while ($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) {
                        $mailer->AddCC($_myrowRes2['EMail']);
                    }
                }
            }
            /*Adding Bcc Function on 2014-07-16 by thilina*/

            if (!$mailer->Send()) {
                $Message = "<script type='text/javascript'>
						alert('W/F Updated & Mail Error : . $mailer->ErrorInfo.Please Try again!');
						window.location.href = './UpdateWorkFlow.php';
					</script>";
            } else {
                //$Message = "<b>W/F Updated & Mail Sent</b></br>";
                $Message = "<script type='text/javascript'>
						alert('W/F Updated & Mail Sent');
						window.location.href = '../Home.php';
					</script>";
            }

            //echo $MagBody;

        }

        $_ResultSet = browseTask($str_dbconnect, $LogUserCode);
        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

            $InputBox         = $_myrowRes['wk_id'] . "-COM";
            $RadioButton     = $_myrowRes['wk_id'] . "-RDO";

            $TimeButton     = $_myrowRes['wk_id'] . "-RDOT";
            $TimeBox         = $_myrowRes['wk_id'] . "-TIME";
            $TimeStart         = $_myrowRes['wk_id'] . "-FMTIME";

            $_POST[$InputBox]         = $_myrowRes['wk_update'];
            $_POST[$RadioButton]     = $_myrowRes['status'];

            $timestamp = strtotime($_myrowRes['TimeTaken']);
            $_POST[$TimeBox]         = date("H:i", $timestamp);

            $timestamp = strtotime($_myrowRes['StartTime']);
            $_POST[$TimeStart]         = date("H:i", $timestamp);

            $_POST[$TimeButton]     = $_myrowRes['TimeType'];
        }
        ?>
        <!--$Message = "<script type='text/javascript'>alert('W/F Updated & Mail Sent');window.location.href = '../Home.php';</script>";-->

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
                                                    <font color="#0066FF">Update Work Flow</font> of User : <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]) ?> on <?php echo $today_date ." - ". date("l") ." - ".$timezone." - ".$Country; ?>
                                                </td>
                                            </tr>
                                            <tr align="center">

                                            </tr>
                                        </table>
                                        <br></br>
                                        <table width="80%" cellpadding="0" cellspacing="0" border="1px" style="border-color: #0066FF; border-width: 1px" align="center">
                                            <tr style="height: 100px;">
                                                <td style="padding-left: 10px;background-color: #E0E0E0">
                                                    <p style="padding-left: 20px">
                                                        1. Sort Work Flow By :
                                                        <select id="cmbSort" name="cmbSort" class="Div-TxtStyleNormal" onchange="getWFDetails()">
                                                            <option id="NRM" value="NRM" <?php if ("NRM" == $sortby) echo "selected=\"selected\";" ?>>** ALL</option>
                                                            <!--<option id="WFN" value="WFN" <?php if ("WFN" == $sortby) echo "selected=\"selected\";" ?>>-- Work Flow Task Only</option>
                                                    <option id="EMO" value="EMO" <?php if ("EMO" == $sortby) echo "selected=\"selected\";" ?>>-- Equipment Maintenance Only</option>-->
                                                            <?php
                                                            $_ResultSet = getwfcategory($str_dbconnect);
                                                            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                            ?>
                                                                <option value="<?php echo $_myrowRes['catcode']; ?>" <?php if ($_myrowRes['catcode'] == $sortby) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['category']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </p>
                                                    <p style="padding-left: 20px">
                                                        2. Sort Work Flow By :
                                                        <select id="cmbSort2" name="cmbSort2" class="Div-TxtStyleNormal" onchange="getWFDetails()">
                                                            <option id="TME" value="TME" <?php if ("TME" == $sortby2) echo "selected=\"selected\";" ?>>TIME</option>
                                                            <option id="CAT" value="CAT" <?php if ("CAT" == $sortby2) echo "selected=\"selected\";" ?>>CATEGORY</option>
                                                        </select>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        <br></br>


                                        <center><U><h2>Daily W/F Tasks - <?php echo date("l") ?></h2></U></center>
                                        <br />
                                        <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                            <tr>
                                                <td>
                                                    <table cellpadding="2px" cellspacing="0px" border="1px" style="border-color: #0063DC; border-width: 1px" width="100%" border="1px">
                                                        <thead style="background-color: #FFE7A1">
                                                            <tr>
                                                                <th width="50px">No</th>
                                                                <th width="120px">Scheduled Time</th>
                                                                <th width="120px">Category</th>
                                                                <th width="150px">Task Completion Status</th>
                                                                <th width="150px">Actual Hrs Spent</th>
                                                                <th>Task</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="border-color: #0063DC; border-width: 2px">

                                                            <?php
                                                            //
                                                            $RowCount = 0;
                                                            $BackColour = "";
                                                            echo '<script>console.log("user' . $LogUserCode . '")</script>';
                                                            echo '<script>console.log("sortby' . $sortby . '")</script>';
                                                            echo '<script>console.log("sortby2' . $sortby2 . '")</script>';
                                                            $_ResultSet = browseTaskWFH($str_dbconnect, $LogUserCode, $sortby, $sortby2, "WF");
                                                            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                                                                $ColorCode = substr($_myrowRes['wk_id'], 0, 1);

                                                                if ($ColorCode == "E") {
                                                                    $BackColour = "lavender";
                                                                }

                                                                if ($ColorCode == "W") {
                                                                    $BackColour = "lavenderblush";
                                                                }

                                                                $RowCount = $RowCount + 1;
                                                                echo '<script>console.log("Your stuff here")</script>';
                                                            ?>
                                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                    <td rowspan="5" align="center" style="height:50px;">
                                                                        <?php echo $RowCount; ?>
                                                                    </td>
                                                                    <td rowspan="3">
                                                                        <?php echo $_myrowRes['start_time'] . ' - ' . $_myrowRes['end_time']; ?>
                                                                    </td>
                                                                    <td rowspan="3">
                                                                        <?php echo "<font color='RED'>" . getwfcatogorybyName($str_dbconnect, $_myrowRes['catcode']) . "</font>" ?>
                                                                    </td>
                                                                    <td align="center">
                                                                        <input type="radio" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="Yes" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "Yes") echo "checked='checked'" ?> />Yes
                                                                        <input type="radio" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "No") echo "checked='checked'" ?> />No
                                                                        <input type="radio" id="radio3" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="N/A" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "N/A") echo "checked='checked'" ?> />N/A
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" id="radio1" name="<?php echo $_myrowRes['wk_id'].'-RDOT'; ?>" class="radio_b" 
                                                                                value="Time Taken" <?php if(isset($_POST[$_myrowRes['wk_id'].'-RDOT']) && $_POST[$_myrowRes['wk_id'].'-RDOT'] == "Time Taken") echo "checked='checked'" ?> />
                                                                        <input type="hidden" id="radio2" name="<?php echo $_myrowRes['wk_id'].'-RDOT'; ?>" class="radio_b"  
                                                                                value="Approx. Time Needed" <?php if(isset($_POST[$_myrowRes['wk_id'].'-RDOT']) && $_POST[$_myrowRes['wk_id'].'-RDOT'] == "Approx. Time Needed") echo "checked='checked'" ?>>	
                                                                        
                                                                    Start Time [HH:MM]	
                                                                        <!-- <?php //if(isset($_POST[$_myrowRes['wk_id'].'-FMTIME'])) echo $_POST[$_myrowRes['wk_id'].'-FMTIME']; else echo '00:00' ?> -->
                                                                        <!-- <input type="text"  onchange="getHours();" id="<?php echo $_myrowRes['wk_id'].'-FMTIME'; ?>" name="<?php echo $_myrowRes['start_time'].'-FMTIME'; ?>" value="<?php if(isset($_myrowRes['start_time'])) echo $_myrowRes['start_time']; else echo '00:00' ?>" width="10px"/></br> -->
                                                                        
                                                                        <input type="text"  onchange="getHours();"id="txt_StartTime" name="<?php echo $_myrowRes['start_time'].'-FMTIME'; ?>" value="<?php if(isset($_myrowRes['start_time'])) echo $_myrowRes['start_time']; else echo '00:00' ?>" width="10px"/></br>
                                                                        End Time [HH:MM]
                                                                        <!-- <?php //if(isset($_POST[$_myrowRes['wk_id'].'-TIME'])) echo $_POST[$_myrowRes['wk_id'].'-TIME']; else echo '00:00' ?> -->
                                                                        <input type="text"  onchange="getHours();"  id="txt_EndTime" name="<?php echo $_myrowRes['wk_id'].'-TIME'; ?>" value="<?php if(isset($_myrowRes['end_time'])) echo $_myrowRes['end_time']; else echo '00:00' ?>" width="10px"/></br>
                                                                    
                                                                        Duration Time [HH:MM]
                                                                        <input type="text"  onchange="getHours();" id="duration" name="duration" value="<?php echo date_create($_myrowRes['start_time'])->diff(date_create($_myrowRes['end_time']))->format('%H:%i:%s'); ?>" width="10px"/></br>
                                                                    </td>

                                                                    <td>
                                                                        <b><?php echo "[" . $_myrowRes['wk_id'] . "] - " . $_myrowRes['wk_name'] . ""; ?></b>
                                                                        <br /><br />
                                                                        <font color='#383d7d'><?php echo "<b>Description : </b><i>" . $_myrowRes['Wf_Desc'] . "</i>"; ?></font>
                                                                        <br />
                                                                        <br />

                                                                        <?php
                                                                        if ($_myrowRes['wk_name'] == "Review W/Fs") {
                                                                            echo "<a style='cursor:pointer' onclick=\"ShowUserWF('" . $_myrowRes['wk_id'] . "')\">View Work Flow</a>";
                                                                        }
                                                                        ?>

                                                                        <br />
                                                                        <br />
                                                                    </td>
                                                                </tr>
                                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                    <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                        User Review Note
                                                                    </td>

                                                                    <td colspan="2" align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                        <textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'] . '-COM'; ?>" id="<?php echo $_myrowRes['wk_id'] . 'COM'; ?>" rows="1"><?php if (isset($_POST[$_myrowRes['wk_id'] . '-COM'])) echo $_POST[$_myrowRes['wk_id'] . '-COM']; ?></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                    <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                        Remove This Task
                                                                    </td>

                                                                    <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                        <input type="checkbox" name="reasoncheck[]" id="reasoncheck" value="<?php echo $_myrowRes['wk_id']; ?>" />
                                                                    </td>
                                                                    <td align="left" bgcolor="<?php echo $BackColour; ?>">
                                                                        Reason :
                                                                        <select name="lst_Options">
                                                                            <option>I am Not Responisble For this Task</option>
                                                                            <option>This Equipment is No Longer Available</option>
                                                                            <option>This is Duplicate on My W/F</option>
                                                                        </select>
                                                                        <?php $WorkFlowid = $_myrowRes['wk_id']; ?>

                                                                        <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                ?></u></font>
                                                                    </td>
                                                                </tr>
                                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                    <td><b>Workflow Attachments By Creator</b></td>
                                                                    <td colspan="4" align="left">
                                                                        <?php
                                                                        $WorkFlowid = $_myrowRes['wk_id'];
                                                                        $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
                                                                        $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                        $num_rows = mysqli_num_rows($_ResultSetq);
                                                                        if ($num_rows > 0) {
                                                                            while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                echo "<a href='files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['FileName'] . "</a> | ";
                                                                            }
                                                                        } else {
                                                                            echo "There are no Attachments to Download";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">

                                                                    <td><b>Workflow Updated Attachments By User / Supervisor</b></td>
                                                                    <!-- <td>
                                                     <input type="file" name="file[]" id="files" multiple>
								                        <hr width=100% size="1" color="" align="center">
                                                    </td> -->
                                                                    <td>
                                                                        <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                ?></u></font>
                                                                    </td>
                                                                    <td colspan="4" align="left">
                                                                        <?php
                                                                        $WorkFlowid = $_myrowRes['wk_id'];
                                                                        $_SelectQueryq   =   "SELECT * FROM WorkflowAttachments WHERE `ParaCode` = '$WorkFlowid'";
                                                                        $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                        $num_rows = mysqli_num_rows($_ResultSetq);

                                                                        if ($num_rows > 0) {
                                                                            echo '<script>console.log("Your stuff here")</script>';
                                                                            while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                //echo "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> | ";            
                                                                                echo "<a href='../files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['SystemName'] . "</a> | ";
                                                                            }
                                                                        } else {
                                                                            echo "There are no Uploaded Documents to Download";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                    <td></td>
                                                                    <td><b>Covering Person</b></td>
                                                                    <td colspan="4" align="left">
                                                                        <?php echo "<font color='BLACK'>" . getwfcoveringpersonbyName($str_dbconnect, $_myrowRes['wk_id']) . "</font>" ?>
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#FFE7A1" style="border-color: #0063DC; border-width: 1px;height:10px">
                                                                    <td colspan="6"></td>
                                                                </tr>


                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <br />
                                                    <br />



                                                    <center><U>
                                                            <h2>Covering Daily W/F Tasks of <?php echo getSELECTEDEMPLOYENAME($str_dbconnect, $_SESSION["LogEmpCode"]) ?></h2>
                                                        </U></center>
                                                    <br />
                                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                                        <tr>
                                                            <td>
                                                                <table cellpadding="2px" cellspacing="0px" border="1px" style="border-color: #0063DC; border-width: 1px" width="100%" border="1px">
                                                                    <thead style="background-color: #FFE7A1">
                                                                        <tr>
                                                                            <th width="50px">No</th>
                                                                            <th width="50px">Task Owner</th>
                                                                            <th width="120px">Scheduled Time</th>
                                                                            <th width="120px">Category</th>
                                                                            <th width="150px">Task Completion Status</th>
                                                                            <th width="150px">Actual Hrs Spent</th>
                                                                            <th>Task</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="border-color: #0063DC; border-width: 2px">

                                                                        <?php
                                                                        //
                                                                        $RowCount = 0;
                                                                        $BackColour = "";
                                                                        $_ResultSet = browseTaskCoveringWFH($str_dbconnect, $LogUserCode, $sortby, $sortby2, "WF");
                                                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                                                                            $ColorCode = substr($_myrowRes['wk_id'], 0, 1);

                                                                            if ($ColorCode == "E") {
                                                                                $BackColour = "lavender";
                                                                            }

                                                                            if ($ColorCode == "W") {
                                                                                $BackColour = "lavenderblush";
                                                                            }

                                                                            $RowCount = $RowCount + 1;
                                                                        ?>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td rowspan="4" align="center" style="height:50px;">
                                                                                    <?php echo $RowCount; ?>
                                                                                </td>
                                                                                <td rowspan="3">
                                                                                    <?php echo getwfownerbyId($str_dbconnect, $_myrowRes['wk_owner']) ?>
                                                                                    <!-- getwfownerbyId($str_dbconnect,$_myrowRes['wk_owner']) -->
                                                                                    <!-- $_myrowRes['wk_owner'] -->
                                                                                </td>
                                                                                <td rowspan="3">
                                                                                    <?php echo $_myrowRes['start_time'] . ' - ' . $_myrowRes['end_time']; ?>
                                                                                </td>
                                                                                <td rowspan="3">
                                                                                    <?php echo "<font color='RED'>" . getwfcatogorybyName($str_dbconnect, $_myrowRes['catcode']) . "</font>" ?>
                                                                                </td>
                                                                                <td align="center">
                                                                                    <input type="radio" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="Yes" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "Yes") echo "checked='checked'" ?> />Yes
                                                                                    <input type="radio" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "No") echo "checked='checked'" ?> />No
                                                                                    <input type="radio" id="radio3" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="N/A" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "N/A") echo "checked='checked'" ?> />N/A
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Time Taken" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Time Taken") echo "checked='checked'" ?> />
                                                                                    <input type="hidden" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Approx. Time Needed" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Approx. Time Needed") echo "checked='checked'" ?>>
                                                                                    Start Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" value="<?php if (isset($_myrowRes['start_time'])) echo $_myrowRes['start_time'];
                                                                                                                                                                                                                    else echo '00:00' ?>" width="10px" /></br>
                                                                                    End Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" value="<?php if (isset($_myrowRes['end_time'])) echo $_myrowRes['end_time'];
                                                                                                                                                                                                                else echo '00:00' ?>" width="10px" /></br>
                                                                                </td>
                                                                                <td>
                                                                                    <b><?php echo "[" . $_myrowRes['wk_id'] . "] - " . $_myrowRes['wk_name'] . ""; ?></b>
                                                                                    <br /><br />
                                                                                    <font color='#383d7d'><?php echo "<b>Description : </b><i>" . $_myrowRes['Wf_Desc'] . "</i>"; ?></font>
                                                                                    <br />
                                                                                    <br />

                                                                                    <?php
                                                                                    if ($_myrowRes['wk_name'] == "Review W/Fs") {
                                                                                        echo "<a style='cursor:pointer' onclick=\"ShowUserWF('" . $_myrowRes['wk_id'] . "')\">View Work Flow</a>";
                                                                                    }
                                                                                    ?>

                                                                                    <br />
                                                                                    <br />
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    User Review Note
                                                                                </td>

                                                                                <td colspan="2" align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    <textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'] . '-COM'; ?>" id="<?php echo $_myrowRes['wk_id'] . 'COM'; ?>" rows="1"><?php if (isset($_POST[$_myrowRes['wk_id'] . '-COM'])) echo $_POST[$_myrowRes['wk_id'] . '-COM']; ?></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    Remove This Task
                                                                                </td>

                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    <input type="checkbox" name="reasoncheck[]" id="reasoncheck" value="<?php echo $_myrowRes['wk_id']; ?>" />
                                                                                </td>
                                                                                <td align="left" bgcolor="<?php echo $BackColour; ?>">
                                                                                    Reason :
                                                                                    <select name="lst_Options">
                                                                                        <option>I am Not Responisble For this Task</option>
                                                                                        <option>This Equipment is No Longer Available</option>
                                                                                        <option>This is Duplicate on My W/F</option>
                                                                                    </select>
                                                                                    <?php $WorkFlowid = $_myrowRes['wk_id']; ?>

                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td><b>Workflow Attachments By Creator</b></td>
                                                                                <td colspan="5" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            echo "<a href='files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['FileName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Attachments to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">

                                                                                <td><b>Workflow Updated Attachments By User / Supervisor</b></td>
                                                                                <!-- <td>
                                                    <input type="file" name="file[]" id="files" multiple> 
								                        <hr width=100% size="1" color="" align="center">
                                                    </td> -->
                                                                                <td>
                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>
                                                                                </td>
                                                                                <td colspan="5" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM WorkflowAttachments WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            //echo "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> | ";            
                                                                                            echo "<a href='../files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['SystemName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Uploaded Documents to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="#FFE7A1" style="border-color: #0063DC; border-width: 1px;height:10px">
                                                                                <td colspan="7"></td>
                                                                            </tr>


                                                                        <?php

                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                                <br />
                                                                <br />
                                                                <br />

                                                                <center><U>
                                                                        <h2>W/F Tasks of Staff Reporting to <?php echo getSELECTEDEMPLOYENAME($str_dbconnect, $_SESSION["LogEmpCode"]) ?></h2>
                                                                    </U></center>
                                                                <br />
                                                                <table cellpadding="2px" cellspacing="0px" border="1px" style="border-color: #0063DC; border-width: 1px" width="100%" border="1px">
                                                                    <thead style="background-color: #FFE7A1">
                                                                        <tr>
                                                                            <th width="50px">No</th>
                                                                            <th width="120px">Scheduled Time</th>
                                                                            <th width="120px">Category</th>
                                                                            <th width="150px">Task Completion Status</th>
                                                                            <th width="150px">Actual Hrs Spent</th>
                                                                            <th>Task</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="border-color: #0063DC; border-width: 2px">

                                                                        <?php
                                                                        //
                                                                        $RowCount = 0;
                                                                        $BackColour = "";
                                                                        $_ResultSet = browseTaskWFH($str_dbconnect, $LogUserCode, $sortby, $sortby2, "USRWF");
                                                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                                                                            $ColorCode = substr($_myrowRes['wk_id'], 0, 1);

                                                                            if ($ColorCode == "E") {
                                                                                $BackColour = "lavender";
                                                                            }

                                                                            if ($ColorCode == "W") {
                                                                                $BackColour = "lavenderblush";
                                                                            }

                                                                            $RowCount = $RowCount + 1;
                                                                        ?>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td rowspan="4" align="center" style="height:50px;">
                                                                                    <?php echo $RowCount; ?>
                                                                                </td>
                                                                                <td rowspan="3">
                                                                                    <?php echo $_myrowRes['start_time'] . ' - ' . $_myrowRes['end_time']; ?>
                                                                                </td>
                                                                                <td rowspan="3">
                                                                                    <?php echo "<font color='RED'>" . getwfcatogorybyName($str_dbconnect, $_myrowRes['catcode']) . "</font>" ?>
                                                                                </td>
                                                                                <td align="center">
                                                                                    <input type="radio" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="Yes" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "Yes") echo "checked='checked'" ?> />Yes
                                                                                    <input type="radio" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "No") echo "checked='checked'" ?> />No
                                                                                    <input type="radio" id="radio3" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="N/A" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "N/A") echo "checked='checked'" ?> />N/A
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Time Taken" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Time Taken") echo "checked='checked'" ?> />
                                                                                    <input type="hidden" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Approx. Time Needed" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Approx. Time Needed") echo "checked='checked'" ?>>
                                                                                    Start Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" value="<?php if (isset($_myrowRes['start_time'])) echo $_myrowRes['start_time'];
                                                                                                                                                                                                                    else echo '00:00' ?>" width="10px" /></br>
                                                                                    End Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" value="<?php if (isset($_myrowRes['end_time'])) echo $_myrowRes['end_time'];
                                                                                                                                                                                                                else echo '00:00' ?>" width="10px" /></br>
                                                                                </td>
                                                                                <td>
                                                                                    <b><?php echo "[" . $_myrowRes['wk_id'] . "] - " . $_myrowRes['wk_name'] . ""; ?></b>
                                                                                    <br /><br />
                                                                                    <font color='#383d7d'><?php echo "<b>Description : </b><i>" . $_myrowRes['Wf_Desc'] . "</i>"; ?></font>
                                                                                    <br />
                                                                                    <br />

                                                                                    <?php
                                                                                    if ($_myrowRes['wk_name'] == "Review W/Fs") {
                                                                                        echo "<a style='cursor:pointer;color:blue;' onclick=\"ShowUserWF('" . $_myrowRes['wk_id'] . "')\"><u>View Work Flow</u></a>";
                                                                                    }
                                                                                    ?>
                                                                                    <br />
                                                                                    <br />
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    User Review Note
                                                                                </td>

                                                                                <td colspan="2" align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    <textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'] . '-COM'; ?>" id="<?php echo $_myrowRes['wk_id'] . 'COM'; ?>" rows="1"><?php if (isset($_POST[$_myrowRes['wk_id'] . '-COM'])) echo $_POST[$_myrowRes['wk_id'] . '-COM']; ?></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    Remove This Task
                                                                                </td>

                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>">
                                                                                    <input type="checkbox" name="reasoncheck[]" id="reasoncheck" value="<?php echo $_myrowRes['wk_id']; ?>" />
                                                                                </td>
                                                                                <td align="left" bgcolor="<?php echo $BackColour; ?>">
                                                                                    Reason :
                                                                                    <select name="lst_Options">
                                                                                        <option>I am Not Responisble For this Task</option>
                                                                                        <option>This Equipment is No Longer Available</option>
                                                                                        <option>This is Duplicate on My W/F</option>
                                                                                    </select>
                                                                                    <?php $WorkFlowid = $_myrowRes['wk_id']; ?>

                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>

                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td><b>Workflow Attachments By Creator</b></td>
                                                                                <td colspan="4" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            echo "<a href='files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['FileName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Attachments to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">

                                                                                <td><b>Workflow Updated Attachments By User / Supervisor</b></td>
                                                                                <!-- <td>
                                                    <input type="file" name="file[]" id="files" multiple> 
								                        <hr width=100% size="1" color="" align="center">
                                                    </td> -->
                                                                                <td>
                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>
                                                                                </td>
                                                                                <td colspan="4" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM WorkflowAttachments WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            //echo "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> | ";            
                                                                                            echo "<a href='../files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['SystemName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Uploaded Documents to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="#FFE7A1" style="border-color: #0063DC; border-width: 1px;height:10px">
                                                                                <td colspan="6"></td>
                                                                            </tr>


                                                                        <?php

                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                                <br />
                                                                <br />
                                                                <br />
                                                                <center><U>
                                                                        <h2>W/F Tasks to Revisit</h2>
                                                                    </U></center>
                                                                <br />
                                                                <table cellpadding="2px" cellspacing="0px" border="1px" style="border-color: #0063DC; border-width: 1px" width="100%" border="1px">
                                                                    <thead style="background-color: #FFE7A1">
                                                                        <tr>
                                                                            <th width="50px">No</th>
                                                                            <th width="120px">Scheduled Time</th>
                                                                            <th width="120px">Category</th>
                                                                            <th width="150px">Task Completion Status</th>
                                                                            <th width="150px">Actual Hrs Spent</th>
                                                                            <th>Task</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="border-color: #0063DC; border-width: 2px">

                                                                        <?php
                                                                        //
                                                                        $RowCount = 0;
                                                                        $BackColour = "";
                                                                        $_ResultSet = browseTaskWFH($str_dbconnect, $LogUserCode, $sortby, $sortby2, "REDO");
                                                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                                                                            $ColorCode = substr($_myrowRes['wk_id'], 0, 1);

                                                                            if ($ColorCode == "E") {
                                                                                $BackColour = "lavender";
                                                                            }



                                                                            $RowCount = $RowCount + 1;
                                                                        ?>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td rowspan="3" align="center" style="height:50px;">
                                                                                    <?php echo $RowCount; ?>
                                                                                </td>
                                                                                <td rowspan="2">
                                                                                    <?php echo $_myrowRes['start_time'] . ' - ' . $_myrowRes['end_time']; ?>
                                                                                </td>
                                                                                <td rowspan="2">
                                                                                    <?php echo "<font color='RED'>" . getwfcatogorybyName($str_dbconnect, $_myrowRes['catcode']) . "</font>" ?>
                                                                                </td>
                                                                                <td align="center">
                                                                                    <input type="radio" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="Yes" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "Yes") echo "checked='checked'" ?> />Yes
                                                                                    <input type="radio" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "No") echo "checked='checked'" ?> />No
                                                                                    <input type="radio" id="radio3" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="N/A" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "N/A") echo "checked='checked'" ?> />N/A
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Time Taken" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Time Taken") echo "checked='checked'" ?> />
                                                                                    <input type="hidden" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Approx. Time Needed" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Approx. Time Needed") echo "checked='checked'" ?>>
                                                                                    Start Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" value="<?php if (isset($_myrowRes['start_time'])) echo $_myrowRes['start_time'];
                                                                                                                                                                                                                    else echo '00:00' ?>" width="10px" /></br>
                                                                                    End Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" value="<?php if (isset($_myrowRes['end_time'])) echo $_myrowRes['end_time'];
                                                                                                                                                                                                                else echo '00:00' ?>" width="10px" /></br>
                                                                                </td>
                                                                                <td>
                                                                                    <b><?php echo "[" . $_myrowRes['wk_id'] . "] - " . $_myrowRes['wk_name'] . ""; ?></b>
                                                                                    <br /><br />
                                                                                    <font color='#383d7d'><?php echo "<b>Description : </b><i>" . $_myrowRes['Wf_Desc'] . "</i>"; ?></font>
                                                                                    <br />
                                                                                    <br />

                                                                                    <?php
                                                                                    if ($_myrowRes['wk_name'] == "Review W/Fs") {
                                                                                        echo "<a style='cursor:pointer' onclick=\"ShowUserWF('" . $_myrowRes['wk_id'] . "')\">View Work Flow</a>";
                                                                                    }
                                                                                    ?>

                                                                                    <br />
                                                                                    <br />
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                    User Review Note
                                                                                </td>

                                                                                <td colspan="3" align="center" bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                    <textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'] . '-COM'; ?>" id="<?php echo $_myrowRes['wk_id'] . 'COM'; ?>" rows="1"><?php if (isset($_POST[$_myrowRes['wk_id'] . '-COM'])) echo $_POST[$_myrowRes['wk_id'] . '-COM']; ?></textarea> <br />
                                                                                    <?php $WorkFlowid = $_myrowRes['wk_id']; ?>

                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td><b>Workflow Attachments By Creator</b></td>
                                                                                <td colspan="4" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            echo "<a href='files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['FileName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Attachments to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">

                                                                                <td><b>Workflow Updated Attachments By User / Supervisor</b></td>
                                                                                <!-- <td>
                                                    <input type="file" name="file[]" id="files" multiple> 
								                        <hr width=100% size="1" color="" align="center">
                                                    </td> -->
                                                                                <td>
                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>
                                                                                </td>
                                                                                <td colspan="4" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM WorkflowAttachments WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            //echo "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> | ";            
                                                                                            echo "<a href='../files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['SystemName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Uploaded Documents to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="#FFE7A1" style="border-color: #0063DC; border-width: 1px;height:10px">
                                                                                <td colspan="6"></td>
                                                                            </tr>


                                                                        <?php

                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                                <br />
                                                                <br />
                                                                <br />
                                                                <center><U>
                                                                        <h2>Non Scheduled Tasks for the Day</h2>
                                                                    </U></center>
                                                                <br />
                                                                <table cellpadding="2px" cellspacing="0px" border="1px" style="border-color: #0063DC; border-width: 1px" width="100%" border="1px">
                                                                    <thead style="background-color: #FFE7A1">
                                                                        <tr>
                                                                            <th width="50px">No</th>
                                                                            <th width="120px">Scheduled Time</th>
                                                                            <th width="120px">Category</th>
                                                                            <th width="150px">Task Completion Status</th>
                                                                            <th width="150px">Actual Hrs Spent</th>
                                                                            <th>Task</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="border-color: #0063DC; border-width: 2px">

                                                                        <?php
                                                                        //
                                                                        $RowCount = 0;
                                                                        $BackColour = "";
                                                                        $_ResultSet = browseTaskWFH($str_dbconnect, $LogUserCode, $sortby, $sortby2, "CWK");
                                                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                                                                            $ColorCode = substr($_myrowRes['wk_id'], 0, 1);

                                                                            if ($ColorCode == "E") {
                                                                                $BackColour = "lavender";
                                                                            }

                                                                            if ($ColorCode == "W") {
                                                                                $BackColour = "lavenderblush";
                                                                            }
                                                                            if ($ColorCode == "C") {
                                                                                $BackColour = "PaleTurquoise";
                                                                            }

                                                                            $RowCount = $RowCount + 1;
                                                                        ?>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td rowspan="3" align="center" style="height:50px;">
                                                                                    <?php echo $RowCount; ?>
                                                                                </td>
                                                                                <td rowspan="2">
                                                                                    <?php echo $_myrowRes['start_time'] . ' - ' . $_myrowRes['end_time']; ?>
                                                                                </td>
                                                                                <td rowspan="2">
                                                                                    <?php echo "<font color='RED'>" . getwfcatogorybyName($str_dbconnect, $_myrowRes['catcode']) . "</font>" ?>
                                                                                </td>
                                                                                <td align="center">
                                                                                    <input type="radio" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="Yes" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "Yes") echo "checked='checked'" ?> />Yes
                                                                                    <input type="radio" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "No") echo "checked='checked'" ?> />No
                                                                                    <input type="radio" id="radio3" name="<?php echo $_myrowRes['wk_id'] . '-RDO'; ?>" class="radio_b" value="N/A" value="No" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDO']) && $_POST[$_myrowRes['wk_id'] . '-RDO'] == "N/A") echo "checked='checked'" ?> />N/A
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden" id="radio1" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Time Taken" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Time Taken") echo "checked='checked'" ?> />
                                                                                    <input type="hidden" id="radio2" name="<?php echo $_myrowRes['wk_id'] . '-RDOT'; ?>" class="radio_b" value="Approx. Time Needed" <?php if (isset($_POST[$_myrowRes['wk_id'] . '-RDOT']) && $_POST[$_myrowRes['wk_id'] . '-RDOT'] == "Approx. Time Needed") echo "checked='checked'" ?>>
                                                                                    Start Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-FMTIME'; ?>" value="<?php if (isset($_myrowRes['start_time'])) echo $_myrowRes['start_time'];
                                                                                                                                                                                                                    else echo '00:00' ?>" width="10px" /></br>
                                                                                    End Time [HH:MM]
                                                                                    <input type="text" id="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" name="<?php echo $_myrowRes['wk_id'] . '-TIME'; ?>" value="<?php if (isset($_myrowRes['end_time'])) echo $_myrowRes['end_time'];
                                                                                                                                                                                                                else echo '00:00' ?>" width="10px" /></br>
                                                                                </td>
                                                                                <td>
                                                                                    <b><?php echo "[" . $_myrowRes['wk_id'] . "] - " . $_myrowRes['wk_name'] . ""; ?></b>
                                                                                    <br /><br />
                                                                                    <font color='#383d7d'><?php echo "<b>Description : </b><i>" . $_myrowRes['Wf_Desc'] . "</i>"; ?></font>
                                                                                    <br />
                                                                                    <br />

                                                                                    <?php
                                                                                    if ($_myrowRes['wk_name'] == "Review W/Fs") {
                                                                                        echo "<a style='cursor:pointer' onclick=\"ShowUserWF('" . $_myrowRes['wk_id'] . "')\">View Work Flow</a>";
                                                                                    }
                                                                                    ?>

                                                                                    <br />
                                                                                    <br />
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td align="center" bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                    User Review Note
                                                                                </td>

                                                                                <td colspan="3" align="center" bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                    <textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'] . '-COM'; ?>" id="<?php echo $_myrowRes['wk_id'] . 'COM'; ?>" rows="1"><?php if (isset($_POST[$_myrowRes['wk_id'] . '-COM'])) echo $_POST[$_myrowRes['wk_id'] . '-COM']; ?></textarea> <br />
                                                                                    <?php $WorkFlowid = $_myrowRes['wk_id']; ?>

                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                                                <td><b>Workflow Attachments By Creator</b></td>
                                                                                <td colspan="4" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            echo "<a href='files/" . $_myrowResq['FileName'] . "'>" . $_myrowResq['FileName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Attachments to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">

                                                                                <td><b>Workflow Updated Attachments By User / Supervisor</b></td>
                                                                                <!-- <td>
                                                    <input type="file" name="file[]" id="files" multiple>  
								                        <hr width=100% size="1" color="" align="center">
                                                    </td> -->
                                                                                <td>
                                                                                    <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                                                                                            echo "<a onclick=\"OpenEditWindow('" . $WorkFlowid . "');\">Upload Documents </a>";
                                                                                                                            // echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	
                                                                                                                            ?></u></font>
                                                                                </td>
                                                                                <td colspan="4" align="left">
                                                                                    <?php
                                                                                    $WorkFlowid = $_myrowRes['wk_id'];
                                                                                    $_SelectQueryq   =   "SELECT * FROM WorkflowAttachments WHERE `ParaCode` = '$WorkFlowid'";
                                                                                    $_ResultSetq     =   mysqli_query($str_dbconnect, $_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                                                    $num_rows = mysqli_num_rows($_ResultSetq);
                                                                                    if ($num_rows > 0) {
                                                                                        while ($_myrowResq = mysqli_fetch_array($_ResultSetq)) {
                                                                                            //echo "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> | ";            
                                                                                            echo "<a href='../files/" . $_myrowResq['SystemName'] . "'>" . $_myrowResq['SystemName'] . "</a> | ";
                                                                                        }
                                                                                    } else {
                                                                                        echo "There are no Uploaded Documents to Download";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr bgcolor="#FFE7A1" style="border-color: #0063DC; border-width: 1px;height:10px">
                                                                                <td colspan="6"></td>
                                                                            </tr>


                                                                        <?php

                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                                <table align="center">
                                                                    <!--<tr >
                                                    <td width="30%" align="Right" height="30">
                                                        Upload Support Documents
														<?php echo $wk_id; ?>
                                                    </td>
                                                    <td width="1%" height="30">
                                                        &nbsp;:&nbsp;
                                                    </td>n_Mail
                                                    <td width="65%" align="left" height="30">
                                                        <fieldset style="padding-left: 0px;border: 0 0 0 0 "  id="fileUpload" >
                                                        <legend><strong></strong></legend>
                                                            <br>
                                                            <div id="fileUploadstyle">You have a problem with your javascript</div>
                                                            <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()">Clear Queue</a>
                                                            <p></p>                            
                                                        </fieldset>
                                                    </td>
                                                </tr>  -->
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <div class="demo">
                                                                                <br>
                                                                                <center>
                                                                                    <input type="submit" value="Add Non Scheduled Tasks" id="btn_addworkflow" name="btn_addworkflow" />
                                                                                    <input type="submit" value="Save" id="btn_Save" name="btn_Save" />
                                                                                    <input type="submit" value="Send Mail" id="btn_Mail" name="btn_Mail" />
                                                                                    <input type="submit" value="Cancel" id="btn_Cancel" name="btn_Cancel" />
                                                                                </center>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <?php
                                                                echo "<div class='Div-Msg' id='msg' align='left'>" . $Message . "</div>";
                                                                $RecID = "";
                                                                $_WKID = "";
                                                                $_WKUserFromName = "";
                                                                $_WKdate = "";
                                                                $_WKTime = "";
                                                                $_WKNotification = "";
                                                                $_HTMLString = "";
                                                                $_HTMLNoteFor = "";

                                                                $_ResultSetNT = get_UserNotifications($str_dbconnect, $LogUserCode);
                                                                while ($_myrowResNT = mysqli_fetch_array($_ResultSetNT)) {
                                                                    $RecID = $_myrowResNT['id'];
                                                                    $_WKID = $_myrowResNT['Wk_id'];
                                                                    $_WKUserFromName = $_myrowResNT['fromUser'];
                                                                    $_WKdate = $_myrowResNT['crt_date'];
                                                                    $_WKTime = $_myrowResNT['crt_time'];
                                                                    $_WKNotification = $_myrowResNT['Notification'];
                                                                    $_HTMLNoteFor = $_myrowResNT['WFDate'];

                                                                    $_HTMLString = "";
                                                                    $_HTMLString .= "<b>W/F :</b> [" . $_WKID . "] - " . get_WFName($str_dbconnect, $_WKID) . "</br>";
                                                                    $_HTMLString .= "<b>Note :</b> " . $_WKNotification . "</br>";
                                                                    $_HTMLString .= "<b>Create Date & Time :</b> " . $_WKdate . " | " . $_WKTime . "</br>";
                                                                    $_HTMLString .= "<b>Create By :</b> " . getSELECTEDEMPLOYENAME($str_dbconnect, $_WKUserFromName) . "</br>";

                                                                    echo "<script>$(function(){create('sticky', { title:'<U>W/F Notification For the Date " . $_HTMLNoteFor . "</U>', text:'" . $_HTMLString . "'},{ expires:false });});</script>";

                                                                    NotificationReadUpdate($str_dbconnect, $RecID);
                                                                }

                                                                ?>
                                                                <br /><Br />

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
        <!--<div id="content">
	<div id="container">		
		<div id="default">
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
		
		<div id="sticky">
			<a class="ui-notify-close ui-notify-cross" href="#">x</a>
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
		
		<div id="themeroller" class="ui-state-error" style="padding:10px; -moz-box-shadow:0 0 6px #980000; -webkit-box-shadow:0 0 6px #980000; box-shadow:0 0 6px #980000;">
			<a class="ui-notify-close" href="#"><span class="ui-icon ui-icon-close" style="float:right"></span></a>
			<span style="float:left; margin:2px 5px 0 0;" class="ui-icon ui-icon-alert"></span>
			<h1>#{title}</h1>
			<p>#{text}</p>
			<p style="text-align:center"><a class="ui-notify-close" href="#">Close Me</a></p>
		</div>
		
		<div id="withIcon">
			<a class="ui-notify-close ui-notify-cross" href="#">x</a>
			<div style="float:left;margin:0 10px 0 0"><img src="#{icon}" alt="warning" /></div>
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
		
		<div id="buttons">
			<h1>#{title}</h1>
			<p>#{text}</p>
			<p style="margin-top:10px;text-align:center">
				<input type="button" class="confirm" value="Close Dialog" />
			</p>
		</div>
	</div>
</div> -->
    </form>
</body>

</html>