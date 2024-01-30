<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Crate Task
 * Last Update      :   25/04/2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */
    session_start();
	include ("class/class.smtp.php");
    include ("connection/sqlconnection.php");   
                                                 //  Role Autherization //  connection file to the mysql database
    include ("class/sql_project.php"); //  sql commands for the access controles
    include ("class/sql_task.php"); //  sql commands for the access controles
	include ("class/sql_getKJR.php"); //  sql commands for get KJR Details
    include ("class/accesscontrole.php"); //  sql commands for the access controles
    include ("class/sql_empdetails.php"); //  connection file to the mysql database
    require_once("class/class.phpmailer.php");
    include ("class/MailBodyOne.php"); //  connection file to the mysql database
	include ("uploadify/upload copy.php");  
    include ("class/taskUpload.php");  
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	
	$path = "";
	$Menue	= "TASK";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS PROJECT DETAILS ::.</title>
	
		
	<!--    Loading Jquerry Plugin <script type="text/javascript" src="jQuerry/js/jquery-1.7.1.min.js"></script> -->
	<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js">-->	
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
	
	<!-- **************** Page Val+6idation ***************** -->
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<!-- ****************NICE FOMR ***************** -->
	
	<link href="css/styleB.css" rel="stylesheet" type="text/css" />    
    
    <script type="text/javascript" charset="utf-8">
        function getPageSize() {
        }

        function SearchList() {
            var l = document.getElementById('optProCode');
            var tb = document.getElementById('txtSProCode');

            if (tb.value == "") {
                ClearSelection(l);
            } else {
                for (var i = 0; i < l.options.length; i++) {
                    if (l.options[i].text.toLowerCase().match(tb.value.toLowerCase())) {
                        l.options[i].selected = true;
                        return false;
                    } else {
                        ClearSelection(l);
                    }
                }
            }
        }
		
		
		$(window).load(function() { 
	         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
	    });

        function SearchUser() {
            var l = document.getElementById('optAssignUser');
            var tb = document.getElementById('txtSUserCode');

            if (tb.value == "") {
                ClearSelection(l);
            } else {
                for (var i = 0; i < l.options.length; i++) {
                    if (l.options[i].text.toLowerCase().match(tb.value.toLowerCase())) {
                        l.options[i].selected = true;
                        return false;
                    } else {
                        ClearSelection(l);
                    }
                }
            }
        }

        function ClearSelection(lb) {
            lb.selectedIndex = -1;
        }

        function getHours() {
            t1 = document.getElementById("txt_StartDate").value;
            t2 = document.getElementById("txt_EndDate").value;

            var one_day = 1000 * 60 * 60 * 24;
            //Here we need to split the inputed dates to convert them into standard format for furter execution

            var x = t1.split("-");
            var y = t2.split("-");
            //date format(Fullyear,month,date)

            var date1 = new Date(x[0], (x[1] - 1), x[2]);

            var date2 = new Date(y[0], (y[1] - 1), y[2])

            var month1 = x[1] - 1;
            var month2 = y[1] - 1;

            //Calculate difference between the two dates, and convert to days

            Diff = Math.ceil((date2.getTime() - date1.getTime()) / (one_day));
            //_Diff gives the diffrence between the two dates.

            Hours = ((Diff + 1) * 8);

            document.getElementById("txtEstHours").value = Hours + ":00:00";
        }

        function DownloadFile() {

            hlink = document.getElementById('optDownload').value;
            //alert(hlink);
            newwindow = window.open('', 'File Download');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }

        function LOADTASK() {
            hlink = document.getElementById('optTaskParent').value;
            if(hlink != "Project"){
                document.forms[0].action = "Task.php?&taskcode="+hlink+"";
                document.forms[0].submit();
            }
        }
    </script>

    <script type="text/javascript">

        var queueSize = 0;

        function startUpload(){		
            var valdator = false;
            valdator = $("#frm_Task").valid();
            if(valdator != false){
                if (queueSize == 0) {
                    alert("No Any Files to Upload!");
                    document.forms['frm_Task'].action = "task.php?btnSave=btnSave";
                    document.forms['frm_Task'].submit();
                }
				$('#fileUploadstyle').fileUploadStart()
            }
        }

       $(document).ready(function() {	
			var empid = document.getElementById('hddLogUser').value;
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
				'scriptData'     : {'empid': empid},
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
					var fileCount = data.filesUploaded;
                    alert(data.filesUploaded + ' files uploaded successfully!');
                    document.forms['frm_Task'].action = "task.php?btnSave=btnSave & fileCount="+fileCount;
                    document.forms['frm_Task'].submit();
                }}
            );
        }); 

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
    <!--................ Thilina - import jquery file to select kjr, kpi, skpi     jQuerry/js/jquery-1.7.1.min.js -->
    
    <script type="text/javascript">	
			
		 function getKjr(){           
		 	kjrid = document.getElementById('kjrcode').value;			 	
            $.post('class/sql_getKJR.php',{kjrdata : frm_Task.kjrcode.value},			
                function(output){ 						                 
                    $('#indicatorcode').html(output);
                }
            )            
        }
         function getIndicator(){           
		 	indid = document.getElementById('indicatorcode').value;			 	
            $.post('class/sql_getKJR.php',{inddata : frm_Task.indicatorcode.value},			
                function(output){ 						                 
                    $('#subindicatorcode').html(output);
                }
            )            
        }
	</script>
    
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
</head>

<body>
	<div id="preloader"></div>
    	
    <?php
       
        $Str_ProCode    = "";
        $Str_TaskCode   = "";
        $pro_Cat     = "";
        $Str_TaskName   = "";
        $Str_TaskDescription = "";
        $Str_ParentTask = "";
        $Dte_StartDate  = date("Y-m-d");
        $Dte_EndDate    = date("Y-m-d");
        $Str_AllHours   = "00:00:00";
        $_strEMPCODE    = "";
        $Str_Priority   = "";
        $_FAC           = "";
        $MailTitile     = "";
        $MailsCC[]        = "";
		$Str_kjrcode     ="";
		$Str_indicatorcode	= "";
        $MailCCTo   =   "";
        $bool_ReadOnly  = "TRUE";
        $Save_Enable    = "No";
        $ErrorString    = "";
		$_kjrintern  = "";
		$_POST["txtProCat"] = "";
        $_POST["Action_Memo"] = "";
        $fileCount = 0;
        $_GET["fileCount"] = 0;
		/* $_POST["txtTaskName"] = "";
		$_POST["txtTaskDescription"] = "";
		$_POST["optTaskParent"] = "";
		$_POST["txt_StartDate"] = "";
        $_POST["txt_EndDate"] = "";
		$_POST["txtEstHours"] = "";
		$_POST["kjrcode1"] = "";
		$_POST["indicatorcode1"] = "";
		$_POST["subindicatorcode1"] = "";
        $_POST["optPriority"] = "";
        $_SESSION["ProjectCode"] = "";
        $_POST["indicatorcode"] = "";
        $_POST["subindicatorcode"] = ""; */
        if (isset($_POST['btnCancel'])) {
            $bool_ReadOnly = "TRUE";
            $Save_Enable = "No";
            $_SESSION["DataMode"] = "";
            $_SESSION["ProjectCode"] = "";
        }

        if (isset($_POST['btnSearch'])) {
            echo "<script>";
            echo " self.location='projecttask.php';";
            echo "</script>";
        }

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
        if (isset($_GET["procode"])) {
            $_SESSION["ProjectCode"] = $_GET["procode"];
            $bool_ReadOnly = "TRUE";
            $Save_Enable = "No";
            $_SESSION["DataMode"] = "";
            $_SESSION["TaskCode"] = "";
        }

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
		if(isset($_POST['txtTaskName'])){
		}
		else{
			$_SESSION["tempkjrcode"]=0;
			$_SESSION["tempindcode"]=0;
			$_SESSION["tempsubindcode"]=0;
		}
        if (isset($_GET["taskcode"])) {

            $Str_ProCode = $_SESSION["ProjectCode"];
            $Str_TaskCode = $_GET["taskcode"];
            $_SESSION["TaskCode"] = $Str_TaskCode;

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode        =   $_myrowRes['procode'];
				$Str_ProCat 		=   $_myrowRes['procat'];
                $Str_ProName        =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName       =   $_myrowRes['taskname'];
                $Str_TaskDescription=   $_myrowRes['TaskDetails'];
                $Str_ParentTask     =   $_myrowRes['parent'];
                $Str_Priority       =   $_myrowRes['Priority'];
                $Dte_StartDate      =   $_myrowRes['taskcrtdate'];
                $Dte_EndDate        =   $_myrowRes['taskenddate'];
                $Str_AllHours       =   $_myrowRes['AllHours'];
                $Precentage         =   $_myrowRes['Precentage'];
                $MailCCTo           =   $_myrowRes['MailCCTo'];
				$Str_kjrcode        =   $_myrowRes['KJRid'];
				$Str_indicatorcode	= $_POST["indicatorcode"];
            }

            $MailsCC = explode("-", $MailCCTo);
            /*
                $Str_ProCode = $_SESSION["ProjectCode"];
                $Str_TaskCode = $_SESSION["TaskCode"];
                $Str_TaskName = $_POST["txtTaskName"];
                $Str_TaskDescription = $_POST["txtTaskDescription"];
                $Str_ParentTask = $_POST["optTaskParent"];
                $Dte_StartDate = $_POST["txt_StartDate"];
                $Dte_EndDate = $_POST["txt_EndDate"];
                $Str_AllHours = $_POST["txtEstHours"];
                //$_strEMPCODE            =   $_POST["optAssignUser"];
                $Str_Priority = $_POST["optPriority"];
            */
            $_FAC = $Str_TaskCode;
            $_FacilityUSERS = getTASKUSERFACILITIES($str_dbconnect,$_FAC);
            $_FacilitySet = getTASKUSERSBYFAC($str_dbconnect,$_FAC);
            $_SESSION["DataMode"] = "";

            echo "<div class='Div-Msg' id='msg' align='left'>*** You have Selected Task Code : ".$Str_TaskCode."</div>";
        }

        if (isset($_POST['btnAdd'])) {
            $bool_ReadOnly = "No";
            $Save_Enable = "Yes";
            $_SESSION["DataMode"] = "N";
            $_SESSION["TaskCode"] = "";
            $Str_TaskCode = gettemporySerial($str_dbconnect);
            $_SESSION["TaskCode"] = $Str_TaskCode;

            $_FAC = $Str_TaskCode;
            $_FacilityUSERS = getTASKUSERFACILITIES($str_dbconnect,$_FAC);
            $_FacilitySet = getTASKUSERSBYFAC($str_dbconnect,$_FAC);

            $NewFileCode = create_FileName($str_dbconnect);
            $_SESSION["NewUPLCode"] = $NewFileCode;
            $_SESSION["UploadeFileCode"] = "";
			
			
			
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please Enter New Task Details</div>";
        }
		//echo $_SESSION["NewUPLCode"];
		?>  
            <input type="hidden" id="hddNewFileCode" value="<?php echo $_SESSION["NewUPLCode"]; ?>" />
            <input type="hidden" id="hddLogUser" value="<?php echo $_SESSION["LogEmpCode"]; ?>" />
            <?php

        if (isset($_POST['Save']) && isset($_SESSION["TaskCode"])) {
			$_SESSION["tempkjrcode"] = $_POST["kjrcode"];
			$_SESSION["tempindcode"]=$_POST["indicatorcode"];
			$_SESSION["tempsubindcode"]=$_POST["subindicatorcode"];
            createTASKFacility($str_dbconnect,$_SESSION["TaskCode"], $_POST["lstSysUsers"]);
        }
		
		 if ((isset($_POST['kjrcode1']))&&(isset($_POST['indicatorcode1']))&&(isset($_POST['indicatorcode1']))) {
			$_SESSION["tempkjrcode"] = $_POST["kjrcode1"];
			$_SESSION["tempindcode"]=$_POST["indicatorcode1"];
			$_SESSION["tempsubindcode"]=$_POST["subindicatorcode1"];
            
        }

        if (isset($_POST['Del']) && isset($_SESSION["TaskCode"])) {
			$_SESSION["tempkjrcode"] = $_POST["kjrcode1"];
			$_SESSION["tempindcode"]=$_POST["indicatorcode1"];
			$_SESSION["tempsubindcode"]=$_POST["subindicatorcode1"];
            deleteTASKFacility($str_dbconnect,$_SESSION["TaskCode"], $_POST["lstFacUsers"]);
        }

        if ((isset($_SESSION["TaskCode"])) && ($_SESSION["TaskCode"] <> "") && (($_SESSION["DataMode"] == "E") || ($_SESSION["DataMode"] == "N")) && (!isset($_GET["taskcode"]))) {

            $Str_ProCode    = $_SESSION["ProjectCode"];
            $Str_TaskCode   = $_SESSION["TaskCode"];
			$Str_ProCat		= $_POST["txtProCat"];
            $Str_TaskName   = $_POST["txtTaskName"];
            $Str_TaskDescription = $_POST["txtTaskDescription"];
            $Str_ParentTask = $_POST["optTaskParent"];
            $Dte_StartDate  = $_POST["txt_StartDate"];
            $Dte_EndDate    = $_POST["txt_EndDate"];
            $Str_AllHours   = $_POST["txtEstHours"];
			$Str_kjrcode	= $_POST["kjrcode1"];
			$Str_indicatorcode	= $_POST["indicatorcode1"];
			$Str_subindicatorcode	= $_POST["subindicatorcode1"];
            //$_strEMPCODE            =   $_POST["optAssignUser"];
            $Str_Priority   = $_POST["optPriority"];

            $_FAC = $Str_TaskCode;
            $_FacilityUSERS = getTASKUSERFACILITIES($str_dbconnect,$_FAC);
            $_FacilitySet = getTASKUSERSBYFAC($str_dbconnect,$_FAC);

            

            if (isset($_POST['optMAILCC'])) {
                $MailCCTo = $_POST['optMAILCC'];
            }

            $Str_MailAddress    =   "";
            if($MailCCTo <> "") {
                for($a=0;$a<sizeof($MailCCTo);$a++){
                     $Str_MailAddress .= $MailCCTo[$a]."-";
                }
            }

            $MailsCC = explode("-", $Str_MailAddress);

            $bool_ReadOnly = "No";
            $Save_Enable = "Yes";
        }

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
        if (isset($_POST["btnEdit"])) {
            $Str_ProCode = $_SESSION["ProjectCode"];
            $Str_TaskCode = $_SESSION["TaskCode"];

            $bool_ReadOnly = "No";
            $Save_Enable = "Yes";
            $_SESSION["DataMode"] = "E";

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode        =   $_myrowRes['procode'];
                $Str_proCat   =         $_myrowRes['proCat'];
                $Str_ProName        =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName       =   $_myrowRes['taskname'];
                $Str_TaskDescription=   $_myrowRes['TaskDetails'];
                $Str_ParentTask     =   $_myrowRes['parent'];
                $Str_Priority       =   $_myrowRes['Priority'];
                $Dte_StartDate      =   $_myrowRes['taskcrtdate'];
                $Dte_EndDate        =   $_myrowRes['taskenddate'];
                $Str_AllHours       =   $_myrowRes['AllHours'];
                $Precentage         =   $_myrowRes['Precentage'];
                $MailCCTo           =   $_myrowRes['MailCCTo'];
				$Str_kjrcode		= $_POST["KJRid"];
				$Str_indicatorcode	= $_POST["Indicatorid"];
				$Str_subindicatorcode	= $_POST["SubIndicatorid"];
            }

            $MailsCC = explode("-", $MailCCTo);

            $_FAC = $Str_TaskCode;
        }

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
        if (isset($_POST["btnDelete"])) {

            $Str_ProCode = $_SESSION["ProjectCode"];
            $Str_TaskCode = $_SESSION["TaskCode"];

            $bool_ReadOnly = "No";
            $Save_Enable = "Yes";
            $_SESSION["DataMode"] = "D";

            $_ResultSet = get_selectedTask($str_dbconnect,$Str_TaskCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_ProCode        =   $_myrowRes['procode'];
                $Str_ProName        =   get_SelectedProjectName($str_dbconnect,$Str_ProCode);
                $Str_TaskName       =   $_myrowRes['taskname'];
                $Str_TaskDescription=   $_myrowRes['TaskDetails'];
                $Str_ParentTask     =   $_myrowRes['parent'];
                $Str_Priority       =   $_myrowRes['Priority'];
                $Dte_StartDate      =   $_myrowRes['taskcrtdate'];
                $Dte_EndDate        =   $_myrowRes['taskenddate'];
                $Str_AllHours       =   $_myrowRes['AllHours'];
                $Precentage         =   $_myrowRes['Precentage'];
                $MailCCTo           =   $_myrowRes['MailCCTo'];
				$Str_kjrcode		= $_POST["KJRid"];
				$Str_indicatorcode	= $_POST["Indicatorid"];
				$Str_subindicatorcode	= $_POST["SubIndicatorid"];
            }

            $MailsCC = explode("-", $MailCCTo);

            $_FAC = $Str_TaskCode;

            echo "<div class='Div-Msg' id='msg' align='left'>*** Do you want to Continue deleting this Task. Please Click on SAVE</div>";
        }

        $_FacilityUSERS = getTASKUSERFACILITIES($str_dbconnect,$_FAC);
        $_FacilitySet = getTASKUSERSBYFAC($str_dbconnect,$_FAC);


        if (isset($_GET['btnSave'])) {

            if ($_POST["txtTaskName"] <> "" && $_POST["txtTaskDescription"]) {
                $MailCC = "";
                if ($_SESSION["DataMode"] == "N") {
                    if (isset($_POST['optMAILCC'])) {
                        $MailCC = $_POST['optMAILCC'];
                    }
					/* $filecount = 0;
					if(0 != $_GET["fileCount"])
					{
						$filecount=$_GET["fileCount"];
					}	 */
                    
                    $filecount = count(array_filter($_FILES['file']['name']));
                    if($filecount!=0){
                        for($i=0;$i<$filecount;$i++){
                            fileUploadTaskNew($str_dbconnect,$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i],$filecount);    
                        }  
                    }
                    
					//$Asi = $_POST['lstSysUsers'];
                    $Str_TEMPTaskCode = $_SESSION["TaskCode"];
                    $Str_TaskCode = create_Task($str_dbconnect,$_SESSION["ProjectCode"],$_POST["txtProCat"], mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskName"]), mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskDescription"]), $_POST["optTaskParent"], $_POST["txt_StartDate"], $_POST["txt_EndDate"], $_POST["txtEstHours"],$_POST["optPriority"], $MailCC,$_POST["kjrcode1"],$_POST["indicatorcode1"],$_POST["subindicatorcode1"],$_POST["txtTaskCode"],$filecount);
                    UpdateTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$Str_TEMPTaskCode, $Str_TaskCode);
					//UpdateTASKDETAILSKJRBase($str_dbconnect,$Str_TaskCode);
                    //update_projectupload($str_dbconnect,$_SESSION["NewUPLCode"], $Str_TaskCode);
					
					$_SESSION["tempkjrcode"] = "";
					$_SESSION["tempindcode"]="";
					$_SESSION["tempsubindcode"]="";
                    $_SESSION["TaskCode"] = $Str_TaskCode;

                    $Str_ProCode = $_SESSION["ProjectCode"];
                    #$Str_TaskCode           =   "";
                    $Str_TaskName = $_POST["txtTaskName"];
                    $Str_proCat   = $_POST["txtProCat"];
                    $Str_TaskDescription = $_POST["txtTaskDescription"];
                    $Str_ParentTask = $_POST["optTaskParent"];
                    $Dte_StartDate = $_POST["txt_StartDate"];
                    $Dte_EndDate = $_POST["txt_EndDate"];
                    $Str_AllHours = $_POST["txtEstHours"];
                    //$_strEMPCODE            =   $_POST["optAssignUser"];
                    $Str_Priority = $_POST["optPriority"];
					 $Str_kjrcode	= $_POST["kjrcode1"];
			        $Str_indicatorcode	= $_POST["indicatorcode1"];
			        $Str_subindicatorcode	= $_POST["subindicatorcode1"];
                    $StrFromMail = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_SESSION["LogEmpCode"]);
	//echo $_SESSION["LogEmpCode"];
	//echo "<br/>";
	//echo $StrFromMail;
					$str_ActionMemo = $_POST["Action_Memo"];
					
                    //$StrToBCC = "shameerap@cisintl.com";


                    $MagBody = CreateMail($str_dbconnect,$Str_ProCode, get_SelectedProjectName($str_dbconnect,$Str_ProCode), $Str_TaskCode, $Str_TaskName, $Str_TaskDescription, $Dte_StartDate, $Dte_EndDate, $Str_AllHours, $Str_Priority, "NEW", $str_ActionMemo);

                    echo "<div class='Div-Msg' id='msg' align='left'>*** Task Created Successfully</div>";

                    
                    //header("location : task.php");

                    $_DepartCode = "";
                    $_Department = "";
                    $_Division = "";
                    $_ProInit       =   "";
                    $_strSecOwner   =   "";
                    $_strSupport    =   "";
			        $_ProInitiator = "";
                    $_ProOwner      =  "";
                    $_ProCrt        =  "";

                    $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode);
                    while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                        $_Division = $_myrowRes['Division'];
						$pro_Cat   = $_myrowRes['proCat'];
                        $_DepartCode = $_myrowRes['Department'];
                        $_ProInit       =   $_myrowRes['ProInit'];
                        $_strSecOwner   =   $_myrowRes["SecOwner"];
                        $_strSupport    =   $_myrowRes["Support"];
				        $_ProInitiator  =   $_myrowRes["ProInit"];
                        $_ProOwner      =  $_myrowRes['ProOwner'];
                        $_ProCrt        =  $_myrowRes['crtusercode'];
                    }

                    $_Department = getGROUPNAME($str_dbconnect,$_DepartCode);


                    //                require("class.phpmailer.php");
                    /*
                    $mailer = new PHPMailer();
                    $mailer->IsSMTP();
                    //$mailer->Host = 'mail.iits.lk';
                    $mailer->Host = 'ssl://smtp.gmail.com:465';
                    $mailer->SetLanguage("en", 'class/');
                    //$mailer->SMTPDebug  = 2;
                    $mailer->SMTPAuth = True;
                    $mailer->IsHTML = TRUE;
                    $mailer->SMTPSecure = "tls";
                    $mailer->Port       = 587;
                    $mailer->Username = 'info@tropicalfishofasia.com';  // Change this to your gmail adress
                    $mailer->Passwosrd = 'info321';  // Change this to your gmail password
                    $mailer->From = 'info@tropicalfishofasia.com';  // This HAVE TO be your gmail adress
                    $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                    $mailer->Body = $MagBody;
                    */

                    /* ----------------------------------------------------------------- */
                  // $mailer = new PHPMailer();
                  /* $mailer = new PHPMailer();
                    $mailer->IsSMTP();
                    $mailer->Host = '10.9.0.166:25';			// $mailer->Host = 'ssl://smtp.gmail.com:465';   //69.63.218.231:86		//10.9.0.165:25
                    $mailer->SetLanguage("en", 'class/');				// $mailer->SetLanguage("en", 'class/');
                    $mailer->SMTPAuth = TRUE;
                    $mailer->IsHTML = TRUE;
                    $mailer->Username = 'pms@eteknowledge.com'; // Change this to your gmail adress   $mailer->Username = 'info@tropicalfishofasia.com';   //pms@eTeKnowledge.com
                    $mailer->Password = 'Cissmp@456'; // Change this to your gmail password			$mailer->Password = 'info321';   //pms@321
					$mailer->Port = 587;
                    $mailer->From = $StrFromMail; // This HAVE TO be your gmail adress
                    $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                    $mailer->Body = $MagBody;*/
					
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','PMS - '.$StrSenderName);
				//$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =$MagBody;				
					
                    /* ----------------------------------------------------------------- */

                    
                    $TaskUsers = "";

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
						
						//testing 2014-06-18
						//echo $MailAddressDpt;
						//echo "<br/>";
						//end of testing 2014-06-18
						
                    }
					if($str_ActionMemo == "on"){
						$MailTitile = "FROM : ".getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"])." - TO : " . $TaskUsers . " - NEW PMS / ACTION MEMO TASK ASSIGNED - " . $_Division . " " . $_Department . " - " . $Str_TaskName;	
					}
					else{
						$MailTitile = "FROM : ".getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"])." - TO : " . $TaskUsers . " - NEW PMS TASK ASSIGNED - " . $_Division . " " . $_Department . " - " . $Str_TaskName;		
					}
                    
                    $mailer->Subject = $MailTitile;

                    if($_ProOwner != ""){
                         $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner));
						// echo getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner);
						 //echo "<br/>";
                    }

                    if($_strSecOwner != ""){
                         $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner));
						// echo getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner);
						// echo "<br/>";
                    }

                    if($_strSupport != ""){
                         $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport));
						// echo getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport);
						// echo "<br/>";
                    }

                    if($_ProCrt != ""){
                         $mailer->AddCC(getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt));
						// echo getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt);
						// echo "<br/>";
                    }

			    if($_ProInitiator != ""){
                         $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInitiator));
						// echo getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInitiator);
						// echo "<br/>";
                    }

                     /*$mailer->AddAddress($StrToMail);*/  // This is where you put the email adress of the person you want to mail
                    $mailer->AddCC($StrFromMail);
                    /*$mailer->AddBCC($StrToBCC);*/
                   // $mailer->AddCC("shameerap@cisintl.com");
					//$mailer->AddCC("thilina.dtr@gmail.com");
                    $mailer->AddBCC('pms@cisintl.com');
                    if ($MailCC <> "") {
                        for ($a = 0; $a < sizeof($MailCC); $a++) {
                            $mailer->AddCC($MailCC[$a]);
							 //echo $MailCC[$a];
							 // echo "<br/>";
                        }
                    }
					
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysql_error());
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysql_error());			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysql_error());
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysql_error());			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
                    if (!$mailer->Send()) {
                        //echo "Message was not sent<br/ >";
                        echo "Mailer Error: " . $mailer->ErrorInfo;
                    }
                    else
                    {
                        //echo "Message has been sent";
                    }

                    $bool_ReadOnly = "TRUE";
                    $Save_Enable = "No";
                    $_SESSION["DataMode"] = "";
                    $_SESSION["TaskCode"] = "";

                } elseif ($_SESSION["DataMode"] == "E") {

                    if (isset($_POST['optMAILCC'])) {
                        $MailCC = $_POST['optMAILCC'];
                    }

                    $Str_TEMPTaskCode = $_SESSION["TaskCode"];

                    updateMain_Task($str_dbconnect,$_SESSION["ProjectCode"],$_SESSION["TaskCode"], mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskName"]),mysqli_real_escape_string($str_dbconnect,$_POST["txtProCat"]), mysqli_real_escape_string($str_dbconnect,$_POST["txtTaskDescription"]), $_POST["optTaskParent"], $_POST["txt_StartDate"], $_POST["txt_EndDate"], $_POST["txtEstHours"], "", $_POST["optPriority"], $MailCC);
                    UpdateTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$Str_TEMPTaskCode, $Str_TaskCode);
                    //update_projectupload($str_dbconnect,$_SESSION["NewUPLCode"], $Str_TaskCode);

                    $Str_TaskCode = $_SESSION["TaskCode"];
                    $Str_proCat   = $_POST["txtProCat"];
                    $Str_ProCode = $_SESSION["ProjectCode"];
                    $Str_TaskCode           =   $_SESSION["TaskCode"];;
                    $Str_TaskName = $_POST["txtTaskName"];
                    $Str_TaskDescription = $_POST["txtTaskDescription"];
                    $Str_ParentTask = $_POST["optTaskParent"];
                    $Dte_StartDate = $_POST["txt_StartDate"];
                    $Dte_EndDate = $_POST["txt_EndDate"];
                    $Str_AllHours = $_POST["txtEstHours"];
                    //$_strEMPCODE            =   $_POST["optAssignUser"];
                    $Str_Priority = $_POST["optPriority"];
                    $StrFromMail = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_SESSION["LogEmpCode"]);

                    //$StrToBCC = "shameerap@cisintl.com";
					
					$str_ActionMemo = $_POST["Action_Memo"];


                    $MagBody = CreateMail($str_dbconnect,$Str_ProCode, get_SelectedProjectName($str_dbconnect,$Str_ProCode), $Str_TaskCode, $Str_TaskName, $Str_TaskDescription, $Dte_StartDate, $Dte_EndDate, $Str_AllHours, $Str_Priority, "EDIT", $str_ActionMemo);

                    echo "<div class='Div-Msg' id='msg' align='left'>*** Task Updated Successfully</div>";

                    $_DepartCode = "";
                    $_Department = "";
                    $_Division = "";

                    $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode);
                    while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                        $_Division = $_myrowRes['Division'];
                        $_DepartCode = $_myrowRes['Department'];
                    }

                    $_Department = getGROUPNAME($str_dbconnect,$_DepartCode);


                    //                require("class.phpmailer.php");
                    /*
                    $mailer = new PHPMailer();
                    $mailer->IsSMTP();
                    //$mailer->Host = 'mail.iits.lk';
                    $mailer->Host = 'ssl://smtp.gmail.com:465';
                    $mailer->SetLanguage("en", 'class/');
                    //$mailer->SMTPDebug  = 2;
                    $mailer->SMTPAuth = True;
                    $mailer->IsHTML = TRUE;
                    $mailer->SMTPSecure = "tls";
                    $mailer->Port       = 587;
                    $mailer->Username = 'info@tropicalfishofasia.com';  // Change this to your gmail adress
                    $mailer->Passwosrd = 'info321';  // Change this to your gmail password
                    $mailer->From = 'info@tropicalfishofasia.com';  // This HAVE TO be your gmail adress
                    $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                    $mailer->Body = $MagBody;
                    */

                    /* ----------------------------------------------------------------- */
					/*$mailer = new PHPMailer();
                    $mailer->IsSMTP();
                    $mailer->Host = '10.9.0.166:25';				//$mailer->Host = 'ssl://smtp.gmail.com:465';
                    $mailer->SetLanguage("en", 'class/');					// $mailer->SetLanguage("en", 'class/');
                    $mailer->SMTPAuth = TRUE;
                    $mailer->IsHTML = TRUE;
                    $mailer->Username = 'pms@eTeKnowledge.com'; // Change this to your gmail adress  $mailer->Username = 'info@tropicalfishofasia.com';
                    $mailer->Password = 'pms@321'; // Change this to your gmail password			$mailer->Password = 'info321';
                    $mailer->From = $StrFromMail; // This HAVE TO be your gmail adress
                    $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                    $mailer->Body = $MagBody;*/
					
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','PMS - '.$StrSenderName);
				//$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =$MagBody;				
					
                    /* ----------------------------------------------------------------- */

                    $TaskUsers = "";

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

                    $MailTitile = "TO : " . $TaskUsers . " - PMS TASK UPDATED - " . $_Division . " " . $_Department . " - " . $Str_TaskName;
                    $mailer->Subject = $MailTitile;
                     /*$mailer->AddAddress($StrToMail);*/  // This is where you put the email adress of the person you want to mail
                    $mailer->AddCC($StrFromMail);
                    //$mailer->AddBCC($StrToBCC);
                    //$mailer->AddCC("prajapriya@gmail.com");
                    $mailer->AddBCC('pms@cisintl.com');
                    if ($MailCC <> "") {
                        for ($a = 0; $a < sizeof($MailCC); $a++) {
                            $mailer->AddCC($MailCC[$a]);
                        }
                    }
					
							/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysql_error());
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysql_error());			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysql_error());
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysql_error());			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
					
					
                    if (!$mailer->Send()) {
                        //echo "Message was not sent<br/ >";
                        echo "Mailer Error: " . $mailer->ErrorInfo;
                    }
                    else
                    {
                        //echo "Message has been sent";
                    }

                    $bool_ReadOnly = "TRUE";
                    $Save_Enable = "No";
                    $_SESSION["DataMode"] = "";
                    $_SESSION["TaskCode"] = "";

            } elseif ($_SESSION["DataMode"] == "D") {

                //     if (isset($_POST['optMAILCC'])) {
                //         $MailCC = $_POST['optMAILCC'];
                //     }

                //     $Str_TEMPTaskCode = $_SESSION["TaskCode"];

                //     //updateMain_Task($str_dbconnect,$_SESSION["ProjectCode"],$_SESSION["TaskCode"], $_POST["txtTaskName"], $_POST["txtTaskDescription"], $_POST["optTaskParent"], $_POST["txt_StartDate"], $_POST["txt_EndDate"], $_POST["txtEstHours"], "", $_POST["optPriority"], $MailCC);
                //     //UpdateTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$Str_TEMPTaskCode, $Str_TaskCode);
                //     //update_projectupload($str_dbconnect,$_SESSION["NewUPLCode"], $Str_TaskCode);

                //     $Str_TaskCode = $_SESSION["TaskCode"] ;

                //     $Str_ProCode = $_SESSION["ProjectCode"];
                //     $Str_TaskCode           =   $_SESSION["TaskCode"];;
                //     $Str_TaskName = $_POST["txtTaskName"];
                //     $Str_proCat   = $_POST["txtProCat"];
                //     $Str_TaskDescription = $_POST["txtTaskDescription"];
                //     $Str_ParentTask = $_POST["optTaskParent"];
                //     $Dte_StartDate = $_POST["txt_StartDate"];
                //     $Dte_EndDate = $_POST["txt_EndDate"];
                //     $Str_AllHours = $_POST["txtEstHours"];
                //     //$_strEMPCODE            =   $_POST["optAssignUser"];
                //     $Str_Priority = $_POST["optPriority"];
                //     $StrFromMail = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_SESSION["LogEmpCode"]);

                //     //$StrToBCC = "shameerap@cisintl.com";
				// 	$str_ActionMemo = $_POST["Action_Memo"];

                //     $MagBody = CreateMail($str_dbconnect,$Str_ProCode, get_SelectedProjectName($str_dbconnect,$Str_ProCode), $Str_TaskCode, $Str_TaskName, $Str_TaskDescription, $Dte_StartDate, $Dte_EndDate, $Str_AllHours, $Str_Priority, "REMOVE", $str_ActionMemo);



                //     $_DepartCode = "";
                //     $_Department = "";
                //     $_Division = "";

                //     $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode);
                //     while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                //         $_Division = $_myrowRes['Division'];
                //         $_DepartCode = $_myrowRes['Department'];
                //     }

                //     $_Department = getGROUPNAME($str_dbconnect,$_DepartCode);


                //     //                require("class.phpmailer.php");
                //     /*
                //     $mailer = new PHPMailer();
                //     $mailer->IsSMTP();
                //     //$mailer->Host = 'mail.iits.lk';
                //     $mailer->Host = 'ssl://smtp.gmail.com:465';
                //     $mailer->SetLanguage("en", 'class/');
                //     //$mailer->SMTPDebug  = 2;
                //     $mailer->SMTPAuth = True;
                //     $mailer->IsHTML = TRUE;
                //     $mailer->SMTPSecure = "tls";
                //     $mailer->Port       = 587;
                //     $mailer->Username = 'info@tropicalfishofasia.com';  // Change this to your gmail adress
                //     $mailer->Passwosrd = 'info321';  // Change this to your gmail password
                //     $mailer->From = 'info@tropicalfishofasia.com';  // This HAVE TO be your gmail adress
                //     $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                //     $mailer->Body = $MagBody;
                //     */

                //     /* ----------------------------------------------------------------- */
				// 	/*$mailer = new PHPMailer();
                //     $mailer->IsSMTP();
                //     $mailer->Host = '10.9.0.166:25';					// $mailer->Host = 'ssl://smtp.gmail.com:465';
                //     $mailer->SetLanguage("en", 'class/');						// $mailer->SetLanguage("en", 'class/');
                //     $mailer->SMTPAuth = TRUE;
                //     $mailer->IsHTML = TRUE;
                //     $mailer->Username = 'pms@eTeKnowledge.com'; // Change this to your gmail adress		$mailer->Username = 'info@tropicalfishofasia.com';
                //     $mailer->Password = 'pms@321'; // Change this to your gmail password	$mailer->Password = 'info321';
                //     $mailer->From = $StrFromMail; // This HAVE TO be your gmail adress
                //     $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                //     $mailer->Body = $MagBody;
                //     $mailer->Body = $MagBody;
				// 	*/
				// $mailer = new PHPMailer();
                // $mailer->IsSMTP();
                // $mailer->Host = 'smtp.office365.com';
                // $mailer->SetLanguage("en", 'class/');					
                // $mailer->SMTPAuth = TRUE;
                // $mailer->IsHTML(true);//
                // $mailer->Username = 'pms@eteknowledge.com';
                // $mailer->Password = 'Cissmp@456';
                // $mailer->Port = 587;
				// $mailer->SetFrom('pms@eteknowledge.com','PMS - '.$StrSenderName);
				// //$mail->CharSet = "text/html; charset=UTF-8;";
				// $mailer->Body =$MagBody;				
					
                //     /* ----------------------------------------------------------------- */

                //     $TaskUsers = "";

                //     $DepartmentMails = getTASKUSERFACILITIES($str_dbconnect,$Str_TaskCode);
                //     while ($_MailRes = mysqli_fetch_array($DepartmentMails)) {
                //         $EmpDpt = $_MailRes['EmpCode'];
                //         $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

                //         if ($TaskUsers == "") {
                //             $TaskUsers = getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                //         } else {
                //             $TaskUsers = $TaskUsers . "/" . getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                //         }

                //         $mailer->AddAddress($MailAddressDpt); // This is where you put the email adress of the person you want to mail
                //     }

                //     $MailTitile = "TO : " . $TaskUsers . " - PMS TASK REMOVED - " . $_Division . " " . $_Department . " - " . $Str_TaskName;
                //     $mailer->Subject = $MailTitile;
                //     // $mailer->AddAddress($StrToMail);  // This is where you put the email adress of the person you want to mail
                //     $mailer->AddCC($StrFromMail);
                //     $mailer->AddBCC('pms@cisintl.com');
                //     //$mailer->AddCC("prajapriya@gmail.com");
                //     //$mailer->AddCC("nelumw@cisintl.com");
                //     if ($MailCC <> "") {
                //         for ($a = 0; $a < sizeof($MailCC); $a++) {
                //             $mailer->AddCC($MailCC[$a]);
                //         }
                //     }
					
				// 			/*Adding Bcc Function on 2014-07-16 by thilina*/
				// 	$_SelectQuery ="";
				// 	$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysql_error());
				// 	$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysql_error());			
				// 	while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
				// 		if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
				// 		{
				// 		$loggedUser = $_myrowRes['OwnerEmpCode'];
				// 			$_SelectQuery = "";
				// 			$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysql_error());
				// 			$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysql_error());			
				// 			while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
				// 			{
				// 				$mailer->AddCC($_myrowRes2['EMail']);
				// 			}
				// 		}						 
				// 	}
				// 	/*Adding Bcc Function on 2014-07-16 by thilina*/
					
					
                //     if (!$mailer->Send()) {
                //         //echo "Message was not sent<br/ >";
                //         echo "Mailer Error: " . $mailer->ErrorInfo;
                //     }
                //     else
                //     {
                //         //echo "Message has been sent";
                //     }

                    DeleteMain_Task($str_dbconnect,$Str_TaskCode);

                    echo "<div class='Div-Msg' id='msg' align='left'>*** Task Removed Successfully</div>";
                }

                $bool_ReadOnly = "TRUE";
                $Save_Enable = "No";
                $_SESSION["DataMode"] = "";
                $_SESSION["TaskCode"] = "";

             }else {
                $Str_TaskName = $_POST["txtTaskName"];
                $Str_TaskDescription = $_POST["txtTaskDescription"];
                //$_strEMPCODE            =   $_POST["optAssignUser"];

                if ($Str_TaskName == "") {
                    $ErrorString = "Task Name ";
                }
                if ($Str_TaskDescription == "") {
                    $ErrorString .= "Task Description ";
                }

                if ($_strEMPCODE == "") {
                    $ErrorString .= "Assign User ";
                }

                $bool_ReadOnly = "FALSE";
                $Save_Enable = "Yes";
                $_SESSION["DataMode"] = "N";
                $_SESSION["TaskCode"] = "";
                echo "<div class='Div-Error' id='msg' align='left'>*** Data Cannot be blank on <B>" . $ErrorString . "</B></div>";
            }
			//echo '<meta http-equiv="refresh" content="0; URL=task.php">';
        }
		
	?>
        
<form name="frm_Task" id="frm_Task" method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data"  class="cmxform">
    
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
                                                <font color="#0066FF">Create Task</font>                                             
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                        	                                                 
                                        </tr>
                                    </table>
                                    <br></br>  
									<table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
										<tr>
											<td>
												<input type="submit" id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack" value="     " size="5"/>
											</td>
											<td>
												<input type="submit" id="btnSearch" name="btnSearch" title="Search Task Details" class="buttonSearch" value="     " size="5"/>
											</td>
											<td>
												<input type="submit" id="btnAdd" name="btnAdd" title="Add New Task" class="buttonAdd" value="     " size="5"/>
											</td>
											<td>
												<input type="submit" id="btnEdit" name="btnEdit" title="Edit Task" class="buttonEdit" value="     " size="10"/>
											</td>
											<td>
												<input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Task" class="buttonDel" value="     " size="10"/>
											</td>
											<td>
												<input type="submit" id="btnPrint" name="btnPrint" title="Print Task Details" class="buttonPrint" value="     " size="10"/>
											</td>
										</tr>
									</table>                                   
                                    <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td width="20%">
                                                        Select Project
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input type="text" id="optProCode" name="optProCode" class="TextBoxStyle" value="<?php if (isset($_SESSION["ProjectCode"])) echo get_SelectedProjectName($str_dbconnect,$_SESSION["ProjectCode"]); ?>" size="45" readonly="readonly">
                                                    </td>
                                                </tr> 
												  <tr>
                                                    <td width = "20%">
                                                        Project Catagory:
                                                    </td>
                                                    <td width = "2%"></td>
                                                    <td>
														<input name= "procat" class="TextBoxStyle" disabled="true" value="<?php if (isset($_SESSION["ProjectCode"])) echo get_SelectedProjectCatagory($str_dbconnect,$_SESSION["ProjectCode"]); ?>">
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Task Code
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input type="text" id="txtTaskCode" name="txtTaskCode" class="TextBoxStyle" size="20" value="<?php echo $Str_TaskCode; ?>" readonly="readonly"/>
														<input type="checkbox" id="Action_Memo" name="Action_Memo">Action Memo</input>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Task Name
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input type="text" id="txtTaskName" name="txtTaskName" class="TextBoxStyle" size="60" value="<?php echo $Str_TaskName; ?>" <?php if ($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                                                    </td>
                                                </tr>
                                              
                                                <tr>
                                                <tr>
                                                    <td width="20%">
                                                        KJR Code
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td><?php 
                                                    if ($_SESSION["tempkjrcode"] != ""){?>
															 <select name="kjrcode1" id="kjrcode1" class="TextBoxStyle" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> style="width:180px" ><option value="<?php echo $_SESSION["tempkjrcode"];?>" > <?php echo $_SESSION["tempkjrcode"];?> </option> </select> <?php } else {?>
                                                        <select name="kjrcode" id="kjrcode" class="TextBoxStyle" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> style="width:180px" onChange="getKjr();">  <option value="0"> Select KJR</option>          <?php
														$empno = $_SESSION["LogEmpCode"];
														
                                                        $_ResultSetKJRDetail = get_KJRDetails($str_dbconnect,$empno);													
									                        while ($myrowRes = mysqli_fetch_array($_ResultSetKJRDetail))
									                        {?>
                                                        <option value="<?php echo $myrowRes["KJRId"];?>"> <?php echo $myrowRes["Name"]." - ".$myrowRes["Description"]; ?></option> <?php }?>                                                      
                                                         <?php } ?></select>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%"> 		
                                                        KPI 
                                                    </td>
                                                    <td width="2%"></td>
                                                    
                                                    <script type="text/javascript">
                                                            getKjr();
                                                     </script>
                                                     <td> <?php if ($_SESSION["tempindcode"] != ""){?>
														<select id="indicatorcode1" name="indicatorcode1" style="width:180px" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> class="TextBoxStyle" >	 <option value="<?php echo $_SESSION["tempindcode"];?>" > <?php echo $_SESSION["tempindcode"];?> </option> 					</select> 	 <?php  } else { ?>                                                     
                                                     	<select id="indicatorcode" name="indicatorcode" style="width:180px" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> class="TextBoxStyle" onChange="getIndicator();">						</select> <?php } ?>     
                                                          <input type="hidden" name="txtindicatorcode" id="txtindicatorcode" value=""></input>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">
                                                        Activity 
                                                    </td>
                                                    <td width="2%"></td>
                                                    
                                                    <script type="text/javascript">
                                                            getIndicator();
                                                     </script>
                                                     <td> 
                                                     	<?php if ($_SESSION["tempsubindcode"] != ""){?>
														<select id="subindicatorcode1" name="subindicatorcode1" style="width:180px" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> class="TextBoxStyle" >	 <option value="<?php echo $_SESSION["tempsubindcode"];?>" > <?php echo $_SESSION["tempsubindcode"];?> </option> 					</select> 	 <?php  } else { ?>                                                     
                                                     	<select id="subindicatorcode" name="subindicatorcode" style="width:180px" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> class="TextBoxStyle" >						</select> <?php } ?>     
                                                          <input type="hidden" name="txtindicatorcode" id="txtindicatorcode" value=""></input>                                                           
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Task Description
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <textarea  cols="80" rows="5" style="width: 100%" id="txtTaskDescription" name="txtTaskDescription" class="tinymce" <?php if ($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>><?php echo $Str_TaskDescription; ?></textarea>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Parent Tasks
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="optTaskParent" name="optTaskParent" class="" size="10" <?php if(($_SESSION["DataMode"] == "") || ($_SESSION["DataMode"] == " " )  ) echo "ONCLICK='LOADTASK()'" ?> >
									                        <option id="0" value="0" selected="selected">
									                            Project
									                        </option>
									                        <?php
									
									                        $Sublelvelcount = "0";
									                        $MaximumSubLevel = "0";
									
									                        $_ResultSet = get_TaskDetails($str_dbconnect,$_SESSION["ProjectCode"]);
                                                            
									                        while ($_myrowRes = mysqli_fetch_array($_ResultSet))
									                        {
									                            //                                    $MaximumSubLevel = get_MaximumSub($str_dbconnect,"PRO/1");
									                            //                                        echo "<script>";
									                            //                                        echo "alert('1-".$_myrowRes['taskcode']."')" ;
									                            //                                        echo "</script>";
									                            if ($_myrowRes['parent'] == "0") {
									                                ?>
									                                <option id="<?php echo $_myrowRes['taskcode']; ?>" value="<?php echo $_myrowRes['taskcode']; ?>">
									                                    &nbsp;<?php echo $_myrowRes['taskname']; ?>
									                                </option>
									                                <?php
									
									                            }
									                            ?>
									                            <?php
									                             $_Resultsub = get_TaskDetailsParent($str_dbconnect,$_myrowRes['taskcode'], "2");
									                            while ($_myrowsub = mysqli_fetch_array($_Resultsub)) {
									                                //                                        echo "<script>";
									                                //                                        echo "alert('2-".$_myrowsub['taskcode']."')" ;
									                                //                                        echo "</script>";
									
									                                ?>
									                                <option id="<?php echo $_myrowsub['taskcode']; ?>" value="<?php echo $_myrowsub['taskcode']; ?>">
									                                    &nbsp;-&nbsp;<?php echo $_myrowsub['taskname']; ?>
									                                </option>
									                                <?php
									                                 $_Resultsub1 = get_TaskDetailsParent($str_dbconnect,$_myrowsub['taskcode'], "3");
									                                while ($_myrowsub1 = mysqli_fetch_array($_Resultsub1)) {
									
									                                    //                                                 echo "<script>";
									                                    //                                        echo "alert('3-".$_myrowsub1['taskcode']."')" ;
									                                    //                                        echo "</script>";
									                                    ?>
									                                <option id="<?php echo $_myrowsub1['taskcode']; ?>" value="<?php echo $_myrowsub1['taskcode']; ?>">
									                                 &nbsp-&nbsp;-&nbsp;<?php echo $_myrowsub1['taskname']; ?>
									                                </option>
									                                 <?php
									                                    $_Resultsub2 = get_TaskDetailsParent($str_dbconnect,$_myrowsub1['taskcode'], "4");
									                                    while ($_myrowsub2 = mysqli_fetch_array($_Resultsub2)) {
									                                        ?>
									                                        <option id="<?php echo $_myrowsub2['taskcode']; ?>"
									                                                value="<?php echo $_myrowsub2['taskcode']; ?>">
									                                            &nbsp-&nbsp;-&nbsp;-&nbsp;<?php echo $_myrowsub2['taskname']; ?>
									                                        </option>
									                                        <?php
									
									                                    }
									                                }
									
									                            }
									                            $Sublelvelcount++;
									                        }
									                        ?>
									                    </select>
                                                    </td>													
                                                </tr>	
												<div id="timepicker"></div>
												<tr>
                                                    <td width="20%">
                                                        Start Date
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input type="text" id="txt_StartDate" name="txt_StartDate" class="TextBoxStyle" size="15" readonly="readonly" value="<?php echo $Dte_StartDate; ?>" onchange="getHours();"/>
								                        <input name="StartDate" type="hidden" id="StartDate" value="..." class="buttonDot" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>
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
                                                        <input type="text" id="txt_EndDate" name="txt_EndDate" class="TextBoxStyle" size="15" readonly="readonly" value="<?php echo $Dte_EndDate ?>" onchange="getHours();"/>
								                        <input name="EndDate" type="hidden" id="EndDate" value="..." class="buttonDot" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>
								                        <script type="text/javascript">
								                            $('#txt_EndDate').datepicker({
								                                dateFormat:'yy-mm-dd'
								                            });
								                        </script>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Allocated Hours
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input type="text" id="txtEstHours" name="txtEstHours" class="TextBoxStyle" size="10" value="<?php echo $Str_AllHours; ?>" onfocus="getHours();" <?php if ($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                        								HH
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Task Owners
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select name="lstSysUsers" size="10" class="" id="lstSysUsers" style="width:200px" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
										                    <?php
										                        while ($_myrowRes = mysqli_fetch_array($_FacilitySet)) {
										                    ?>
										                    <option value="<?php echo $_myrowRes['EmpCode']; ?>"> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
										                    <?php
										                        }
										                    ?>
										                    </select>
										
										                    <input name="Save" type="submit"  id="Save" value=">" style="width: 40px; vertical-align: 500%; cursor: pointer" <?php if ($Save_Enable == "No") echo "disabled=\"disabled\";" ?>/>
										                    <input name="Del" type="submit"  id="Del" value="<" style="width: 40px; vertical-align: 500%; cursor: pointer" <?php if ($Save_Enable == "No") echo "disabled=\"disabled\";" ?>/>
										
										                    <select name="lstFacUsers" size="10" class="" id="lstFacUsers" style="width:200px" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
										                    <?php
										                        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {
										                    ?>
										                        <option value="<?php echo $_myrowRes['EmpCode']; ?>"> <?php echo $_myrowRes['UserName'];?> </option>
										                    <?php
										                        }
										                    ?>
										                 </select>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Priority
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="optPriority" name="optPriority" class="TextBoxStyle" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
									                        <option id="None" value="None">None</option>
									                        <option id="Very Low" value="Very Low" style="background-color:lightgrey" <?php if ($Str_Priority == "Very Low") echo "selected=\"selected\""; ?>>
									                            Very Low &nbsp;&nbsp;</option>
									                        <option id="Low" value="Low" style="background-color:lightslategray" <?php if ($Str_Priority == "Low") echo "selected=\"selected\""; ?>>
									                            Low &nbsp;&nbsp;</option>
									                        <option id="Medium" value="Medium" style="background-color:skyblue" <?php if ($Str_Priority == "Medium") echo "selected=\"selected\""; ?>>
									                            Medium &nbsp;&nbsp;</option>
									                        <option id="High" value="High" style="background-color:lightcoral" <?php if ($Str_Priority == "High") echo "selected=\"selected\""; ?>>
									                            High &nbsp;&nbsp;</option>
									                        <option id="Very High" value="Very High" style="background-color:coral" <?php if ($Str_Priority == "Very High") echo "selected=\"selected\""; ?>>
									                            Very High &nbsp;&nbsp;</option>
									                    </select>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        CC TO ALL
                                                    </td>
                                                    <td width="2%"></td>
                                                 
                                                    <td>
                                                    <select id="optMAILCC[]" name="optMAILCC[]" class="" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> multiple="multiple" size="12">

                                                        <!-- <select id="optMAILCC[]" name="optMAILCC[]" class="" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> multiple size="20"> -->
									                    <?php
									                        $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
									                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
									                            ?>
									                            <option value="<?php echo $_myrowRes['EMail']; ?>" <?php if (in_array($_myrowRes['EMail'],$MailsCC)) echo "selected=\"selected\""; ?>> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
									                    <?php } ?>
									                    </select>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Upload / Download - Task Documents
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <!-- <div id="fileUploadstyle">You have a problem with your javascript</div>
								                        <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()">Clear Queue</a> -->
                                                        <input type="file" name="file[]" id="files" multiple>       
								                        <p></p>
								                        <hr width=100% size="1" color="" align="center">
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
																	<input name="btnSave" id="btnSave" type="button"  value="Save" <?php if ($Save_Enable == "No") echo "disabled=\"disabled\";" ?> onclick="startUpload()" />
                    												&nbsp;<input name="btnCancel" id="btnCancel" type="submit"  value="Cancel" />                                                                 
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
                    </table >
                </div >
            </td>            
        </tr>   
        <tr>
            <td colspan="2" style="width: 100%">
                <div id="footer">
                    <?php include ('footer.php') ?>
                </div >
            </td>
        </tr>
    </table >              
				
				
				<!--<div id="Div-Form_Back">
                    <input type="submit" id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack" value="     " size="5"/>
                </div>
                <div id="Div-Form_Search">
                    <input type="submit" id="btnSearch" name="btnSearch" title="Search Task Details" class="buttonSearch" value="     " size="5"/>
                </div>
                <div id="Div-Form_Add">
                    <input type="submit" id="btnAdd" name="btnAdd" title="Add New Task" class="buttonAdd" value="     " size="5"  <?php if (isset($_SESSION["ProjectCode"]) && ($_SESSION["ProjectCode"] == "")) echo "disabled=\"disabled\";" ?> />
                </div>
                <div id="Div-Form_Edit">
                    <input type="submit" id="btnEdit" name="btnEdit" title="Edit Task" class="buttonEdit" value="     " size="10"/>
                </div>
                <div id="Div-Form_Del">
                    <input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Task" class="buttonDel" value="     " size="10"/>
                </div>
                <div id="Div-Form_Print">
                    <input type="submit" id="btnPrint" name="btnPrint" title="Print Task Details" class="buttonPrint" value="     " size="10"/>
                </div>-->

                

</form>
    
</body>
</html>