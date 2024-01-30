<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Project Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\sql_Task.php");       //  sql commands for the access controles
include ("class\sql_crtgroups.php");   //  connection file to the mysql database
include ("class\sql_project.php");       //  sql commands for the access controles

//include ("class\class.phpmailer.php");   //  connection file to the mysql database
require_once("class/class.phpmailer.php");
require_once("class/class.SMTP.php");
include ("class\MailBodyTwo.php");   //  connection file to the mysql database
include ("class\sql_empdetails.php");   //  connection file to the mysql database

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

    <!-- **************** JQUERRY ****************** -->
    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />

    <!-- ******************************************** -->
    <!-- **************** FLEX GRID ****************** -->
    <script type="text/javascript" language="javascript" src="js/flexigrid.js"></script>
    <script type="text/javascript" language="javascript" src="js/flexigrid.pack.js"></script>

    <link href="css/flexigrid.css" rel="stylesheet" type="text/css" />
    <link href="css/flexigrid.pack.css" rel="stylesheet" type="text/css" />
    <!-- ************************************* -->


    <link rel="stylesheet" href="css/updateTask.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />

    <!-- **************** SLIDER ***************** -->
    <script src="js/jquery-ui.min.js"></script>

    <script type="text/javascript"  src="src/js/jscal2.js"></script>
    <script type="text/javascript"  src="src/js/lang/en.js"></script>

    <link type="text/css" rel="stylesheet" href="src/css/jscal2.css" />
    <link type="text/css" rel="stylesheet" href="src/css/border-radius.css" />

    <!-- ************************************* -->

<!-- ************ FILE UPLOAD ********* -->

    <link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="css/uploadify.styling.css" type="text/css" />
    <!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->
    <script type="text/javascript" src="js/jquery.uploadify.js"></script>

    <!-- ****************END***************** -->


     <!-- ************ TIME PICKER ***************** -->
    <script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
    <!-- ************************************* -->

    <style type="text/css">
        #slider-result {
            position:relative;
            top: 160px;
            left: 600px;
            font-size:16px;
            height:100px;
            font-family:Arial, Helvetica, sans-serif;
            color:#000066;
            width:200px;
            text-align:left;
            text-shadow:0 1px 1px #000;
            font-weight:700;
            padding:20px 0;
        }
    </style>
    <!--
    <style type="text/css">
        /*the slider background*/
        .slider {
            width:230px;
            height:11px;
            background:url(images/slider-bg.png);
            position:relative;
            margin:0;
            padding:0 10px;
            top: 195px;
            left: 325px;
        }

        .slidervalue {
            position:relative;
            margin:0;
            padding:0 10px;
            top: 40px;
            left: 590px;
        }

        /*Style for the slider button*/
        .ui-slider-handle {
            width:24px;
            height:24px;
            position:absolute;
            top:-7px;
            margin-left:-12px;
            z-index:200;
            background:url(images/slider-button.png);
        }

        /*Result div where the slider value is displayed*/
        #slider-result {
            position:relative;
            top: 158px;
            left: 600px;
            font-size:18px;
            height:100px;
            font-family:Arial, Helvetica, sans-serif;
            color:#000066;
            width:200px;
            text-align:left;
            text-shadow:0 1px 1px #000;
            font-weight:700;
            padding:20px 0;
        }

        /*This is the fill bar colour*/
       .ui-widget-header {
            background:url(images/fill.png) no-repeat left;
            height:8px;
            left:1px;
            top:1px;
            position:absolute;
        }

       .a {
            outline:none;
            -moz-outline-style:none;
        }

    </style>

    <style type="text/css">

        .ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
        .ui-timepicker-div dl{ text-align: left; }
        .ui-timepicker-div dl dt{ height: 25px; }
        .ui-timepicker-div dl dd{ margin: -25px 0 10px 65px; }
        .ui-timepicker-div td { font-size: 90%; }


    </style>
    -->

    <script type="text/javascript" charset="utf-8">

       function getPageSize() {/*
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );
            parent.resizeIframeToFitContent(height);*/
        }
        /*
        $(document).ready(function() {
            $('#example').dataTable();
        } );
        */
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
        //alert('uploading Started');
        return $('#fileUploadstyle').fileUploadStart();
    }

    function DownloadFile(){

        hlink = document.getElementById('optDownload').value ;
        //alert(hlink);
        newwindow = window.open('','File Download');
        if (window.focus) {newwindow.focus()}
            return false;
    }
</SCRIPT>

    <script type="text/javascript">

        var queueSize = 0;

        function startUpload(){
            if (queueSize == 0) {
                //alert("No Any Files to Upload!");
                document.forms['frm_porject'].action = "updateTaskMain.php?btnSave=btnSave";
                document.forms['frm_porject'].submit();
            }
            $('#fileUploadstyle').fileUploadStart()
        }
        
        $(document).ready(function() {
            $("#fileUploadstyle").fileUpload({
                'uploader': 'uploadify/uploader.swf',
                'cancelImg': 'uploadify/cancel.png',
                'script': 'uploadify/upload.php',
                'folder': 'files',
                'fileExt': '*.pdf;*.PDF;*.doc;*.DOC;*.docx;*.DOCX;*.xls;*.XLS;*.xlsx;*.XLSX;*.psd;*.PSD;*.ai;*.AI;*.zip;*.ZIP;*.rar;*.RAR;*.exe;*.EXE',
                'multi': true,
                'simUploadLimit': 1,
                'sizeLimit': 200000000,
                'displayData': 'speed',
                'width': 100,
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
                    document.forms['frm_porject'].action = "updateTaskMain.php?btnSave=btnSave";
                    document.forms['frm_porject'].submit();
                }}
            );
        });
    </script>

    <script language="javascript" type="text/javascript">

        function ShowLoading(){
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
        }
        
        function HideLoading() {
            if(ns4){ld.visibility="hidden";}
            else if (ns6||ie4) ld.display="none";
        }

    </script>
        

</head>

    <body onLoad="init()">
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

        $Str_TaskDescription    =   "";
        $_strSecOwner           =   "";
        $_strSupport            =   "";

        $_ProInit       = "";
        $_ProOwner      = "";
        $_ProCrt        = "";

        $MailCCTo       = "";

        if(isset($_POST['btnCancel'])) {
            $bool_ReadOnly          =	"TRUE";
            $Save_Enable            =	"No";
            $_SESSION["DataMode"]   =	"";
            $_SESSION["taskcode"]    =   "";
        }
    
        if(isset($_GET["taskcode"]))
        {

            $Str_TaskCode               =   $_GET["taskcode"];
            $_SESSION["taskcode"]       =   $Str_TaskCode;

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode = $_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }

            $EstimatedHours  = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent      = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);

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
            //$HoursRemaining = $EstimatedHours -  $HoursSpent;

            $_SESSION["ProjectCode"]    =   $Str_ProCode;
            $bool_ReadOnly              =   "TRUE";
            $Save_Enable                =   "No";
            $_SESSION["DataMode"]       =   "";
        }

        if(isset($_POST['btnSearch'])) {
            //header("Location:M_Reference.php");
            echo "<script>";
            echo " self.location='taskbrowse.php';";
            echo "</script>";
        }

        if(isset($_POST['btnAdd'])) {
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"N";
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please Enter New Task Updates</div>";

            $Str_TaskCode   = $_SESSION["taskcode"];

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode = $_myrowRes['procode'];
                $Str_ProName    =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName   =   $_myrowRes['taskname'];
                $Precentage     =   $_myrowRes['Precentage'];
                //$Str_TaskDescription    =   $_myrowRes['TaskDetails'];
            }

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
                $_strSecOwner   = $_myrowRes["SecOwner"];
                $_strSupport    = $_myrowRes["Support"];
            }

            $EstimatedHours = getEstimatedHours($str_dbconnect,$Str_TaskCode);
            $HoursSpent = getHoursSpent($str_dbconnect,$Str_TaskCode);
            $AddlHrsRequest  = getaddlHrsRequest($str_dbconnect,$Str_TaskCode);
            $AddlHrsApproved = getaddlHrsApproved($str_dbconnect,$Str_TaskCode);

            //$HoursRemaining = $EstimatedHours -  $HoursSpent;
            

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
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please update the Task Details</div>";
        }

        if(isset($_GET['btnSave'])) {

            echo "<script>";
            echo "ShowLoading();";
            echo "</script>";

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
                $_ProOwner      = "";
                $_ProCrt        = "";

                $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode );
                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    $_Division      =   $_myrowRes['Division'];
                    $_DepartCode    =   $_myrowRes['Department'];
                    $_ProInit       =   $_myrowRes['ProInit'];
                    $_ProOwner      =   $_myrowRes['ProOwner'];
                    $_ProCrt        =   $_myrowRes['crtusercode'];
                    $_strSecOwner   = $_myrowRes["SecOwner"];
                    $_strSupport    = $_myrowRes["Support"];

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
                // $mailer = new PHPMailer();
                // $mailer->IsSMTP();
                // $mailer->Host = '10.9.0.166:25';				// $mailer->Host = 'ssl://smtp.gmail.com:465';
                // $mailer->SetLanguage("en", 'class/');					//  $mailer->SetLanguage("en", 'class/');
                // $mailer->SMTPAuth = TRUE;
                // $mailer->IsHTML = TRUE;
                // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress		 $mailer->Username = 'info@tropicalfishofasia.com';
                // $mailer->Password = 'pms@321';  // Change this to your gmail password		$mailer->Password = 'info321';
                // $mailer->From = $StrFromMail;  // This HAVE TO be your gmail adress
                // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                // $mailer->Body = $MagBody;
				
				//O365 Email Function Start
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','PMS');
				$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =str_replace('"','\'',$MagBody);				
				//O365 Email Function END			
				
                /* ----------------------------------------------------------------- */

                $MailTitile =   "TO : ".getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$_ProInit)." - TASK UPDATE- ".$_Division." ".$_Department." - ".$Str_TaskName;
                $mailer->Subject = $MailTitile;

                $mailer->AddAddress($StrToMail);  // This is where you put the email adress of the person you want to mail

                $_strSecOwnerMail   =   "";
                $_strSecOwnerMail   =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner);

                $_strSupportMail    =   "";
                $_strSupportMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport);


                if($_strSecOwnerMail != ""){
                    $mailer->AddCC($_strSecOwnerMail);
                }

                if($_strSupportMail != ""){
                    $mailer->AddCC($_strSupportMail);
                }

                $ProCrtMail         =   getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt);
                $mailer->AddCC($ProCrtMail);

                //echo $StrFromMail;
                $MailsCC = explode("-", $MailCCTo);

                for($a=0;$a<(sizeof($MailsCC)-1);$a++){
                    $mailer->AddCC($MailsCC[$a]);
                    //echo "RRER".$MailsCC[$a]."ttt<BR>";
                }
                $mailer->AddCC($StrFromMail);

                $mailer->AddBCC('pms@cisintl.com');
                //$mailer->AddCC($StrFromMail);
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

                 if($_POST["optPriority"] == "Addl Hrs Request"){

                    $MagBody        =   CreateMail($str_dbconnect,$Str_ProCode, $Str_ProName, $Str_TaskCode, $Str_TaskName, $_POST["optPriority"], $_POST["txtTaskDescription"], $Dte_SysDate);
                    // $mailer = new PHPMailer();
                    // $mailer->IsSMTP();
                    // $mailer->Host = '10.9.0.166:25';				// $mailer->Host = 'ssl://smtp.gmail.com:465';
                    // $mailer->SetLanguage("en", 'class/');					//  $mailer->SetLanguage("en", 'class/');
                    // $mailer->SMTPAuth = TRUE;
                    // $mailer->IsHTML = TRUE;
                    // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress    $mailer->Username = 'info@tropicalfishofasia.com';
                    // $mailer->Password = 'pms@321';  // Change this to your gmail password			$mailer->Password = 'info321';
                    // $mailer->From = $StrFromMail;  // This HAVE TO be your gmail adress
                    // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                    // $mailer->Body = $MagBody;
					
					//O365 Email Function Start
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','PMS');
				$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =str_replace('"','\'',$MagBody);				
				//O365 Email Function END			
					
                    /* ----------------------------------------------------------------- */

                    $MailTitile =   "TO : ".getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$_ProInit)." - APPROVAL FOR ADDL HRS REQUEST - ".$_Division." ".$_Department." - ".$Str_TaskName;
                    $mailer->Subject = $MailTitile;

                    $mailer->AddAddress($StrToMail);  // This is where you put the email adress of the person you want to mail



                    $ProOwnerMail      =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner);
                    $ProCrtMail        =   getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt);

                    $mailer->AddCC($ProOwnerMail);

                    $_strSecOwnerMail   =   "";
                    $_strSecOwnerMail   =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner);

                    $_strSupportMail    =   "";
                    $_strSupportMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport);

                    if($_strSecOwnerMail != ""){
                        $mailer->AddCC($_strSecOwnerMail);
                    }

                    if($_strSupportMail != ""){
                        $mailer->AddCC($_strSupportMail);
                    }

                    $mailer->AddCC($ProCrtMail);

                    $mailer->AddCC($StrFromMail);
                    $mailer->AddBCC('pms@cisintl.com');
					
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
                }

                if($_POST["optPriority"] == "Task Completed"){

                    $MagBody        =   CreateMail($str_dbconnect,$Str_ProCode, $Str_ProName, $Str_TaskCode, $Str_TaskName, $_POST["optPriority"], $_POST["txtTaskDescription"], $Dte_SysDate);
                    // $mailer = new PHPMailer();
                    // $mailer->IsSMTP();
                    // $mailer->Host = '10.9.0.166:25';				// $mailer->Host = 'ssl://smtp.gmail.com:465';
                    // $mailer->SetLanguage("en", 'class/');					// $mailer->SetLanguage("en", 'class/');
                    // $mailer->SMTPAuth = TRUE;
                    // $mailer->IsHTML = TRUE;
                    // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress			$mailer->Username = 'info@tropicalfishofasia.com';
                    // $mailer->Password = 'pms@321';  // Change this to your gmail password							 $mailer->Password = 'info321';
                    // $mailer->From = $StrFromMail;  // This HAVE TO be your gmail adress
                    // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                    // $mailer->Body = $MagBody;
					
					//O365 Email Function Start
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','PMS');
				$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =str_replace('"','\'',$MagBody);				
				//O365 Email Function END			
					
                    /* ----------------------------------------------------------------- */

                    $MailTitile =   "TO : ".getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$_ProInit)." - APPROVAL FOR TASK COMPLETION - ".$_Division." ".$_Department." - ".$Str_TaskName;
                    $mailer->Subject = $MailTitile;

                    $mailer->AddAddress($StrToMail);  // This is where you put the email adress of the person you want to mail



                    $ProOwnerMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner);

                    $_strSecOwnerMail   =   "";
                    $_strSecOwnerMail   =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner);

                    $_strSupportMail    =   "";
                    $_strSupportMail    =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport);

                    if($_strSecOwnerMail != ""){
                        $mailer->AddCC($_strSecOwnerMail);
                    }

                    if($_strSupportMail != ""){
                        $mailer->AddCC($_strSupportMail);
                    }

                    $ProCrtMail      =   getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt);

                    $mailer->AddCC($ProOwnerMail);
                    $mailer->AddCC($ProCrtMail);

                    $mailer->AddCC($StrFromMail);
                    $mailer->AddBCC('pms@cisintl.com');
					
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
                }

                echo "<div class='Div-Msg' id='msg' align='left'>*** Task Details Updated Successfully</div>";
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

            echo "<script>";
            echo "HideLoading();";
            echo "</script>";

        }

        if(isset($_POST['btnBack'])) {
            //header("Location:M_Reference.php");
            $StrProCode = $_SESSION["MainProCode"];
            echo "<script>";
            echo "self.location='Maintaskbrowse.php?&procode=$StrProCode';";
            echo "</script>";
        }

    ?>
    <div id="containerc">

        <div id="loading" style="position:absolute; width:100px; text-align:center; top:180px; left: 180px; height: 20px; z-index: 1">
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
        
        <div id="Centeredc">

            <div id="Div-Form_logo">
                <input type="button" title="Tropical Fish International (pvt) ltd" class="logo"/>
            </div>

            <div class="Application" align="left">
                User Name : <?php echo $_SESSION["LogUserName"]; ?>
            </div>

            <div class="body" onload="parent.resizeIframeToFitContent(this);">
                <form name="frm_porject" id="frm_porject" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div id="Div-Form_Back" >
                        <input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="     " size="5"/>
                    </div>
                    <div id="Div-Form_Search">
                        <input type="submit" id="btnSearch" name="btnSearch" title="Search Task Details" class="buttonSearch" value="     " size="5"  />
                    </div>
                    <div id="Div-Form_Add">
                        <input type="submit" id="btnAdd" name="btnAdd" title="Add Task Update" class="buttonAdd" value="     " size="5"/>
                    </div><!--
                    <div id="Div-Form_Edit">
                        <input type="submit" id="btnEdit" name="btnEdit" title="Edit Project" class="buttonEdit" value="     " size="10"/>
                    </div>
                    <div id="Div-Form_Del">
                        <input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Project" class="buttonDel" value="     " size="10"/>
                    </div>
                    <div id="Div-Form_Print">
                        <input type="submit" id="btnPrint" name="btnPrint" title="Print Project Details" class="buttonPrint" value="     " size="10"/>
                    </div>
                    -->
<!--                    creating data entry Interface-->
                    <div id="div-lbl_ProCode">
                        Project Code
                    </div>
                    <div id="Div-txt_ProCode">
                        <input type="text" id="txtProCode" name="txtProCode" class="Div-TxtStyle" size="20" value="<?php echo $Str_ProCode; ?>" readonly="readonly"/>
                    </div>

                    <div id="div-lbl_ProName">
                        Project Name
                    </div>
                    <div id="Div-txt_ProName">
                        <input type="text" id="txtProName" name="txtProName" class="Div-TxtStyle" size="60" value="<?php echo $Str_ProName; ?>" readonly="readonly"/>
                    </div>
                    <div id="div-lbl_TaskCode">
                        Task Code
                    </div>
                    <div id="Div-txt_TaskCode">
                        <input type="text" id="txtTaskCode" name="txtTaskCode" class="Div-TxtStyle" size="20" value="<?php echo $Str_TaskCode; ?>" readonly="readonly"/>
                    </div>

                    <div id="div-lbl_TaskName">
                        Task Name
                    </div>
                    <div id="Div-txt_TaskName">
                        <input type="text" id="txtTaskName" name="txtTaskName" class="Div-TxtStyle" size="60" value="<?php echo $Str_TaskName; ?>" readonly="readonly"/>
                    </div>

                    <div id="div-lbl_Priority">
                        Category
                    </div>
                    <div id="Div-txt_Priority"  >
                        <select id="optPriority" name="optPriority" class="Div-TxtStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
                            <?php
                            $IneerCount =   0;
                            $IneerCount =   getTaskCategoryInner($str_dbconnect,$Str_TaskCode, "Task Started") ;

                            $Completed  =   0;
                            $Completed =   getTaskCategoryInner($str_dbconnect,$Str_TaskCode, "Task Completed") ;


                            ?>
                                <option id="Task Started" value="Task Started" >Task Started</option>
                            <?php


                            ?>
                                <option id="Task Update" value="Task Update" >Task Update</option>
                                <option id="Approval" value="Approval" >Approval &nbsp;&nbsp;</option>
                                <option id="Impediment" value="Impediment" >Impediment &nbsp;&nbsp;</option>
                                <option id="Addl Hrs Request" value="Addl Hrs Request" >Addl Hrs Request &nbsp;&nbsp;</option>
                            <?php


                            ?>
                                <option id="Task Completed" value="Task Completed" >Task Completed</option>
                            <?php

                            ?>
                        </select>
                    </div>

                    <?php
                        //$Precentage =   50;
                    ?>

                    <div class="slider" style="top: 194px; left: 350px; width: 200px"></div>
                    <div id="slider-result"><?php echo $Precentage; ?> % Completed</div>
  		            <input type="hidden" id="hidden" name="hidden" class="slidervalue" value="<?php echo $Precentage; ?>" size="10" readonly="readonly"/>

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

                    <div id="div-lbl_TaskDescription">
                        Task Description
                    </div>
                    <div id="Div-txt_TaskDescription">
                        <textarea cols="60"   rows="5" id="txtTaskDescription" name="txtTaskDescription" class="Div-TxtStyle" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>><?php echo $Str_TaskDescription;?></textarea>
                    </div>

                    <div id="div-lbl_HoursSpent">
                        Hours Spent
                    </div>

                    <div id="timepicker"></div>

                    <div id="Div-txt_HoursSpent">
                        <font class="Div-TxtStyleNormal">From : </font>
                        <input type="text" name="txtStart" id="txtStart"  class="Div-TxtStyle" value="00:00" size="5" onchange="getTimeDiff()" readonly="readonly" align="center"/>
                        <script type="text/javascript">
                            $('#txtStart').timepicker({
                                timeFormat: 'h:m',
                                separator: ' @ '
                                });
                            //$('example3').timepicker();
                        </script>
                    </div>

                    <div id="Div-txt_HoursSpent1">
                        <font class="Div-TxtStyleNormal">To : </font>
                        <input type="text" name="txtEnd" id="txtEnd"  class="Div-TxtStyle" value="00:00" size="5" onchange="getTimeDiff()" readonly="readonly" align="center"/>
                        <script type="text/javascript">
                            $('#txtEnd').timepicker({
                                timeFormat: 'h:m',
                                separator: ' @ '
                                });
                            //$('example3').timepicker();
                        </script>
                    </div>

                    <div id="Div-txt_HoursSpent2">
                        <font class="Div-TxtStyleNormal"> Total Hours Spent : </font>
                        <input type="text" id="txtHoursSpent" name="txtHoursSpent" class="Div-TxtStyle" size="7" value="<?php echo $Str_txtHoursSpent; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?> align="center"/>
                    </div>

                    <!----------------------------------------->

                    <div id="div-lbl_HoursSummary" align="center">
                        - HOURS SUMMARY -
                    </div>

                    <div id="Div-lbl_HoursSummary">
                        <font class="Div-TxtStyleNormal">Hrs Estimated : &nbsp;</font>
                    </div>

                    <div id="Div-txt_HoursSummary">
                        <input type="text" name="txtHrsEstimated" id="txtHrsEstimated" class="Div-TxtStyle" value="<?php echo $EstimatedHours; ?>" size="7" readonly="readonly" align="center"/>
                    </div>

                    <div id="Div-lbl_HoursSummary1">
                        <font class="Div-TxtStyleNormal">Addl Hrs Requested : &nbsp;</font>
                    </div>

                    <div id="Div-txt_HoursSummary1">
                        <input type="text" name="txtHrsRequested" id="txtHrsRequested"  class="Div-TxtStyle" value="<?php echo $AddlHrsRequest; ?>" size="7" onchange="getTimeDiff()" readonly="readonly" align="center"/>
                    </div>

                    <div id="Div-lbl_HoursSummary2">
                        <font class="Div-TxtStyleNormal">Addl Hrs Approved : &nbsp;</font>
                    </div>

                    <div id="Div-txt_HoursSummary2">
                        <input type="text" id="txtHrsApproved" name="txtHrsApproved" class="Div-TxtStyle" size="7" value="<?php echo $AddlHrsApproved; ?>" readonly="readonly" align="center"/>
                    </div>

                    <div id="Div-lbl_HoursSummary3">
                        <font class="Div-TxtStyleNormal">Hrs Remaining : </font>
                    </div>

                    <div id="Div-txt_HoursSummary3">
                        <input type="text" id="txtHrsRemaining" name="txtHrsRemaining" class="Div-TxtStyle" size="7" value="" readonly="readonly" align="center"/>
                    </div>

                    <!------------------------------------------------------->

                    <div id="div-lbl_AddlHours" align="left">
                        Request Additional Hours
                    </div>

                    <div id="Div-txt_AddlHours">
                        <input type="text" name="txtHrsRequest" id="txtHrsRequest"  class="Div-TxtStyle" value="00:00" size="5" onchange="getTimeDiff()" readonly="readonly" align="center"/>
                        <script type="text/javascript">
                            $('#txtHrsRequest').timepicker({
                                timeFormat: 'h:m',
                                separator: ' @ '
                                });
                            //$('example3').timepicker();
                        </script>
                    </div>

                    <div id="Div-txt_DownloadT">

                            <legend><strong> Download - Task Documents </strong></legend><br>
                            <?php
                                $_ResultSet      = get_projectupload($str_dbconnect,$Str_TaskCode) ;
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                            ?>
                                <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>

                            <?php } ?>

                    </div>

                    <div id="Div-txt_Recepient">

                            <legend><strong> TASK Alerts Recepient List </strong></legend><br><br>
                            <?php
                                $ProOwnerMail       =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner);

                                $StrToMail          =   getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInit);
                        
                                if($StrToMail != ""){
                                    echo    $StrToMail. " - [ Project Initiator ]<br>";
                                    echo    $ProOwnerMail." - [ Project Primary Owner ]<br>";
                                    echo    getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner)." - [ Project Secondary Owner ]<br>";
                                    echo    getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport)." - [ Project Supporter ]<br>";
                                    echo    getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt)." - [ Project Creator ]<br>";

                                    $MailsCC = explode("-", $MailCCTo);

                                    for($a=0;$a<(sizeof($MailsCC)-1);$a++){
                                        echo $MailsCC[$a]."<br>";
                                    }
                                }
                            ?>

                    </div>

                    <div id="Div-txt_Upload">
                         <fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0" id="fileUpload" >
                            <legend><strong> Upload / Download - Task Updates Documents </strong></legend>
                            <br>
                            <div id="fileUploadstyle">You have a problem with your javascript</div>
                            <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()">Clear Queue</a>
                            <p></p>
                            <hr width=100% size="1" color="" align="center">
                        </fieldset>

                        <div id="Div-txt_Download">
                            <?php
                                $_ResultSet      = get_projectuploadupdates($str_dbconnect,$Str_TaskCode) ;
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                            ?>
                                        <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>

                            <?php } ?>
                        </div>

                    </div>

                    <div id="Div-pannel">
                        <input name="btnSave" id="btnSave" type="button" class="buttonSave" value="Save" <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?> onclick="startUpload()"/>
                        <input name="btnCancel" id="btnCancel" type="reset" class="buttonCancel" value="Cancel" />
                    </div>

                    <div id="Div-tblpannel">
                    <table cellpadding="0" cellspacing="0" border="0" class="flexme3" id="flexme3" onmousemove ="getPageSize();">
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
                                        $Class = "even gradeC" ;
                                        $ColourCode = 1 ;
                                    } elseif ($ColourCode == 1 ) {
                                        $Class = "odd gradeC";
                                        $ColourCode = 0 ;
                                    }
                            ?>
                                <tr class="<?php echo $Class; ?>">
                                    <td align="left">
                                        <?php
                                            //echo $_myrowRes['id'];
                                            $Str_IdCode = $_myrowRes['UpdateCode'];
                                            
                                            echo "<img src='toolbar/sml_del.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_IdCode\")'/>";

                                        ?>
                                    </td>
                                    <td><?php echo $_myrowRes['category']; ?></td>
                                    <td><?php echo $_myrowRes['Note']; ?></td>
                                </tr>
                            <?php
                                $LoopCount = $LoopCount + 1;
                                }
                            ?>
                            </tbody>
                    </table>
                </div>

                <script type="text/javascript">
                    $(".flexme3").flexigrid({
                        url : false,
                        resizable: false,
                        nowrap : true,
                        colModel : [ {  
                            display : 'Delete',
                            name : 'delete',
                            width : 80,
                            sortable : true,
                            align : 'center'
                        }, {
                            display : 'Category',
                            name : 'category',
                            width : 180,
                            sortable : true,
                            align : 'left'
                        }, {
                            display : 'Note',
                            name : 'note',
                            width : 400,
                            sortable : true,
                            align : 'left'
                        }],
                        searchitems : [ {
                            display : 'Category',
                            name : 'category',
                            isdefault : true
                        }],
                        usepager : true,
                        title : 'TASK UPDATES',
                        useRp : true,
                        rp : 15,
                        showTableToggleBtn : false,
                        width : 720,
                        height : 120
                    });

                    function test(com, grid) {
                        if (com == 'Delete') {
                            confirm('Delete ' + $('.trSelected', grid).length + ' items?')
                        } else if (com == 'Add') {
                            alert('Add New Item');
                        }
                    }
                </script>
                <?php
                    echo "<script>";
                    echo "getTimeDiffRemaining('".$HoursSpent."','".$EstimatedHours."')";
                    echo "</script>";
                ?>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
