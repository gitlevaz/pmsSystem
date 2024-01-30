<?php

    session_start();
    
    include ("../connection/sqlconnection.php");//  connection file to the mysql database    
    include ("../class/accesscontrole.php"); //  sql commands for the access controles
    include ("../class/sql_empdetails.php"); //  connection file to the mysql database
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    require_once("../class/class.phpmailer.php");
	require_once("../class/class.SMTP.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database
    
    include ("../class/sql_wkflow.php");            //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
    $path = "../";
	$Menue	= "WFHistory";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS - WORK FLOW ::.</title>
    
    <link href="../css/styleB.css" rel="stylesheet" type="text/css" />
    
    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
    <script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>
    
<!--    <link rel="stylesheet" type="text/css" media="screen" href="../css/screen.css" />-->
    
    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />	
    
    <!-- ************ FILE UPLOAD ********* -->

    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
   
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>
    
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>
    <script type="text/javascript" src="../js/jquery.fileupload.js"></script> 
    <script type="text/javascript" src="../js/jquery.ui.widget.js"></script> 
    <!-- ****************END***************** -->
    
     <!-- **************** TIME PICKER START  ***************** -->
     <script type="text/javascript" src="../js/jquery-ui-timepicker-addon.js"></script>
   <!-- <script type="text/javascript" src="../jQuerry/development-bundle/ui/jquery.ui.timepicker.js?v=0.2.5"></script>-->    

    <!--<link rel="stylesheet" href="../css/ui/smoothness/ui.timepicker.css" type="text/css" />-->
        
    <script type="text/javascript">        
        
        $(function() {
            $( "input:submit", ".demo" ).button();		
	});       
        
    </script>
     <style type="text/css">
		/* preloader DIV-Styles*/
		#preloader { 
			display:none; /* Hide the DIV */
			position:fixed;  
			_position:absolute; /* hack for internet explorer 6 */  
			height:405px;  
			width:670px;  
			background:#FFFFFF;  
			left: 350px;
			top: 160px;
			z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
			margin-left: 15px;  
			
			/* additional features, can be omitted */
			border:8px solid #06F;      
			padding:15px;  
			font-size:15px;  
			-moz-box-shadow: 0 0 5px #ff0000;
			-webkit-box-shadow: 0 0 5px #ff0000;
			box-shadow: 0 0 20px #ff0000;
			
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
    <style type="text/css">
        .radio_b{
            padding:1px 5px 1px 5px;
            background-color:transparent;
            cursor: default;
            border: 0px;
            vertical-align: middle
        }
        
    </style>   
    
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
        
       /* $(window).load(function() { 
             $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
        }); */
        
        function getWFDetails(){
            sort = document.getElementById("cmbSort").value;
            sort2 = document.getElementById("cmbSort2").value;
			Emp = document.getElementById("optEmployee").value;
			Dte = document.getElementById("txt_StartDate").value;
            document.forms['frm_WorkFlow'].action = "viewWorkFlow.php?sort="+sort+"&sort2="+sort2+"&Emp="+Emp+"&Dte="+Dte+"";
            document.forms['frm_WorkFlow'].submit();
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
            $("#container").css({ // this is just for style        s
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
	
        function OpenEditWindow(workid, empCode){
        
        loadPopupBox();				
        $('#EditWorkFlow').attr('src', 'Editworkflow.php?id='+workid+'&empCode='+empCode+'')
}
</script>         
    
   
</head>
<body>
<div id="preloader"></div>
        <div id="preloader">    <!-- OUR PopupBox DIV-->
          <iframe id="UploadDocuments" width="670px" height="405px" frameborder="0" scrolling="no"></iframe>
            	<a id="popupBoxClose">Close(X)</a>                
        </div>  

    <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
     
    <?php
    
		$wk_id = "";		
		$timezone = "Asia/Colombo";	
		
		$Country = $_SESSION["LogCountry"];
		
		//$_strEMPCODE =$_SESSION["LogEmpCode"];
		$_strEMPCODE= "";
		$Dte_StartDate  = date("Y-m-d");
		$bool_ReadOnly = "FALSE";
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}
		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		//date_timezone_set($date, timezone_open($timezone));

		date_default_timezone_set($timezone);
		//date.timezone = $timezone;
        
        $LogUserCode = $_SESSION["LogEmpCode"];        
        $today_date  = date("Y-m-d");
        
        $wk_update  =   "";
        $status     =   "";
        
        $Message    =   "";
        
        $sortby = "NRM";
        $sortby2 = "TME";
       
       
        if(isset($_GET["sort"])){
            
			$sortby = $_GET["sort"];
            $sortby2 = $_GET["sort2"];
			
			$_strEMPCODE = $_GET["Emp"];
			$Dte_StartDate = $_GET["Dte"];
			
			$_ResultSetRecords = User_browseTaskWFH($str_dbconnect,$_strEMPCODE, $sortby, $sortby2, $Dte_StartDate);	
			
        }
        
        /*if ( validateLoading($str_dbconnect,$LogUserCode) < 1 ){ 
            
			$Country = $_SESSION["LogCountry"];
			
			if($Country == "SL"){
				$timezone = "Asia/Colombo";	
			}
			
			if($Country == "US"){
				$timezone = "America/Los_Angeles";
			}
			
			if($Country == "TI"){
				$timezone = "Asia/Bangkok";
			}
			if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
            Get_DailyWorkFlow($str_dbconnect,$LogUserCode, $Country);
            Get_WeeklyWorkFlow($str_dbconnect,$LogUserCode, $Country);
            Get_MonthlyWorkFlow($str_dbconnect,$LogUserCode, $Country);
            Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country);
            
            updateSummary($str_dbconnect,$LogUserCode);
            
        }*/
		
		
		if(isset($_POST["optEmployee"])){
	        $_strEMPCODE = $_POST["optEmployee"];
	        $_SESSION["Fake_EmpCode"] = $_strEMPCODE;
	    }
		
		
		
		if(isset($_POST["btn_Search"])){			
			
			$Dte_StartDate = $_POST["txt_StartDate"];	
			
			/*$myDate = strtotime($Dte_StartDate); 
			echo $myDate;
			echo date('l',$myDate);*/
			/*echo $_strEMPCODE;*/
			User_Get_DailyWorkFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
            User_Get_WeeklyWorkFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
            User_Get_MonthlyWorkFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
            User_Get_DailyEQFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
			$_ResultSetRecords = User_browseTaskWFH($str_dbconnect,$_strEMPCODE, $sortby, $sortby2, $Dte_StartDate);			
		}
        
		
		
		
        if(isset($_POST["btn_Save"])){            
            //echo "PAGE SUBMIT";
			$Dte_StartDate = $_POST["txt_StartDate"];	
			$_strEMPCODE = $_POST["optEmployee"];
            $wk_id = "";			
            $_ResultSetNote = browseTaskViewUser($str_dbconnect,$_strEMPCODE, $Dte_StartDate);
            while ($_myrowResNote = mysqli_fetch_array($_ResultSetNote)) {
                /*echo "Test dfsf";*/
                $InputBox = $_myrowResNote['wk_id']."-NOTE";
				$Dte_StartDate = $_POST["txt_StartDate"];
           /*     $RadioButton = $_myrowRes['wk_id']."-RDO"; 
				
				$TimeButton 	= $_myrowRes['wk_id']."-RDOT";
            	$TimeBox 		= $_myrowRes['wk_id']."-TIME";*/
				
                $wk_id = $_myrowResNote['wk_id'];
				if($_POST[$InputBox] != ""){
					updateWorkFlowNotification($str_dbconnect,$LogUserCode, $wk_id, $_POST[$InputBox] , $_strEMPCODE, $Dte_StartDate);	
				}
                /*echo $InputBox;*/
            }
			$_ResultSetRecords = User_browseTaskWFH($str_dbconnect,$_strEMPCODE, $sortby, $sortby2, $Dte_StartDate);
			if( $_POST['delall']){
                $checkBox = $_POST['delall'];
			$tdate = $_POST['txt_RedoDate'];			
			for($i=0; $i<sizeof($checkBox); $i++){
				insertRedo($str_dbconnect,$checkBox[$i],$tdate);
			}
            }
       /* }
		
		if(isset($_POST["btn_Mail"])){    */  
            /* ----------------------------------------------------------------- */
                // $mailer = new PHPMailer();
                // $mailer->IsSMTP();
                // $mailer->Host = '10.9.0.166:25';				//$mailer->Host = 'ssl://smtp.gmail.com:465';
                // $mailer->SetLanguage("en", 'class/');					//$mailer->SetLanguage("en", 'class/');
                // $mailer->SMTPAuth = TRUE;
                // $mailer->IsHTML = TRUE;
                // $mailer->Username = 'pms@eTeKnowledge.com'; // Change this to your gmail adress		$mailer->Username = 'info@tropicalfishofasia.com';
                // $mailer->Password = 'pms@321'; // Change this to your gmail password			$mailer->Password = 'info321';
                // $mailer->From = 'pms@eTeKnowledge.com'; //$StrFromMail; // This HAVE TO be your gmail adress			 $mailer->From = 'info@tropicalfishofasia.com';
                // $mailer->FromName = 'Work Flow'; // This is the from name in the email, you can put anything you like here
                
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
				$mailer->CharSet = "text/html; charset=UTF-8;";
							
				//O365 Email Function END			
				
                $MagBody  = getWFUPDATEMAIL($str_dbconnect,$LogUserCode);
                
                $mailer->Body =str_replace('"','\'',$MagBody);	
                //$mailer->Body = $MagBody;
                /* ----------------------------------------------------------------- */
                $TskUser =  getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$LogUserCode);
                $today_date  = date("Y-m-d");
                $Country = $_SESSION["LogCountry"];
				$WKOwner = Get_Supervior($str_dbconnect,$LogUserCode, $Country);
				$WKOwnerFName = getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$WKOwner);
				
				$timestamp = strtotime($today_date);
            	$TodayDay 		= date("l", $timestamp);
				
                //$mailer->AddAddress('shameerap@cisintl.com');
                //$mailer->AddCC('indikag@cisintl.com');
                $MailTitile = $WKOwner." - ".$TodayDay." Date : ".$today_date."";
                $mailer->Subject = $MailTitile;
				
				/*echo $MailTitile;*/
				
				
				$MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$LogUserCode);
            	$mailer->AddAddress($MailAddressDpt); 
				
				$_SelectQuery 	=   "SELECT * FROM tbl_wfalert WHERE FacCode = '$wk_id'";
        		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 
				
				while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
		            $EmpDpt   		=   $_myrowRes['EmpCode'];
					$MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

            		$mailer->AddAddress($MailAddressDpt);
		        }
				
				$mailer->AddBCC('pms@cisintl.com');
				//$mailer->AddBCC('thilina.dtr@gmail.com');
				//$mailer->AddBCC('shameerap@cisintl.com'); 			
                $MailTitile = "TO : " . $TaskUsers . " - NEW TASK - " . $_Division . " " . $_Department . " - " . $Str_TaskName;
                echo "MailTitile";
                echo $MailTitile;
                echo "<script type='text/javascript'>
						alert('W/F Updated & Mail Sent');
						window.location.href = '../Home.php';
					</script>";
					
                $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner));
                $mailer->AddBCC('pms@cisintl.com');
				
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='WORKFLOW' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='WORKFLOW' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
				
                if (!$mailer->Send()) {  
                    $Message = "<b>W/F Updated & Mail Error : ". $mailer->ErrorInfo."</b><br/><br/>";                    
                }else{
                    //$Message = "<b>W/F Updated & Mail Sent</b></br>";
					$Message = "<script type='text/javascript'>
						alert('W/F Updated & Mail Sent');
						window.location.href = '../Home.php';
					</script>";
                }
            
            	//echo $MagBody;
            
        }
        
        $_ResultSet = browseTask($str_dbconnect,$LogUserCode);
        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

            $InputBox 		= $_myrowRes['wk_id']."-COM";
            $RadioButton 	= $_myrowRes['wk_id']."-RDO"; 
			
			$TimeButton 	= $_myrowRes['wk_id']."-RDOT";
            $TimeBox 		= $_myrowRes['wk_id']."-TIME";
			
			$TimeStart 		= $_myrowRes['wk_id']."-FMTIME";
			
            $_POST[$InputBox] 		= $_myrowRes['wk_update'];
            $_POST[$RadioButton] 	= $_myrowRes['status'];
			
			$timestamp = strtotime($_myrowRes['TimeTaken']);
            $_POST[$TimeBox] 		= date("H:i", $timestamp);
			
			$timestamp = strtotime($_myrowRes['StartTime']);
            $_POST[$TimeStart] 		= date("H:i", $timestamp);
			
			$_POST[$TimeButton] 	= $_myrowRes['TimeType'];
            
			
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
                            <div id="right" >
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr style="height: 50px; background-color: #E0E0E0;">
                                        <td style="padding-left: 10px; font-size: 16px">
                                            <font color="#0066FF">Work Flow : User Level View </font> of User : <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["Fake_EmpCode"]) ?> on <?php echo $Dte_StartDate ; ?>
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
												Employee Name : 
							                    <select name="optEmployee" id="optEmployee" class="TextBoxStyle">                                                    
                                                <?php 
													if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "C1") == 1 ){
														$_ResultSet = getEMPLOYEEDETAILS($str_dbconnect,$LogUserCode) ;	
													}else{
														$_ResultSet = getEMPLOYEEDETAILSWFSupervisor($str_dbconnect,$LogUserCode) ;	
													}                                                    
                                                    
                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                ?>
                                                    <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                <?php } ?>
                                                </select>    
							                    
											</p>
											<p style="padding-left: 60px">
												W/F Date:
												<input type="text" id="txt_StartDate" name="txt_StartDate" class="TextBoxStyle" size="15" readonly="readonly" value="<?php echo $Dte_StartDate; ?>" onchange="getHours();"/>
						                        <input name="StartDate" type="hidden" id="StartDate" value="..." class="buttonDot" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>
						                        <script type="text/javascript">
						                            $('#txt_StartDate').datepicker({
						                                dateFormat:'yy-mm-dd'
						                            });
						                        </script>
												<div class="demo" style="padding-left:120px">                    
	                                                    <input type="submit" value="Search" id="btn_Search" name="btn_Search" />														
	                                            </div>
												<!--<input type="button" id="Search" name="Search" value="Search" style="width: 100px"/>	-->
											</p>
										</td>
									</tr>									
                                    <tr style="height: 100px;">
                                        <td style="padding-left: 10px;background-color: #E0E0E0">
                                            <p style="padding-left: 20px">
                                                1. Sort Work Flow By :
                                                <select id="cmbSort" name="cmbSort" class="Div-TxtStyleNormal" onchange="getWFDetails()">
                                                    <option id="NRM" value="NRM" <?php if ("NRM" == $sortby) echo "selected=\"selected\";" ?>>** ALL</option>
                                                    <!--<option id="WFN" value="WFN" <?php if ("WFN" == $sortby) echo "selected=\"selected\";" ?>>-- Work Flow Task Only</option>
                                                    <option id="EMO" value="EMO" <?php if ("EMO" == $sortby) echo "selected=\"selected\";" ?>>-- Equipment Maintenance Only</option>-->
                                                    <?php                                    
                                                        $_ResultSet = getwfcategory($str_dbconnect) ;
                                                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                    ?>
                                                    <option value="<?php echo $_myrowRes['catcode']; ?>"  <?php if ($_myrowRes['catcode'] == $sortby) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['category'] ; ?> </option>
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
                                                    <table cellpadding="0px" cellspacing="0" width="60%" border="1px" align="center">			
                                                        <tr>
                                                            <td style='background-color:lavender' align='center' width="20%">
                                                                EMPLOYEE
                                                            </td>
                                                            <td style='background-color:lavenderblush' align='center' width="20%">
                                                                WORKFLOW
                                                            </td>
                                                            <td style='background-color:PaleTurquoise' align='center' width="20%">
                                                                CUSTOMIZED WORKFLOW
                                                            </td>
                                                        </tr>
                                                   </table>
                            <br></br><br>    
                                <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                    <tr>
                                        <td>                                                
                                            <table cellpadding="2px" cellspacing="0px" border="1px" style="border-color: #0063DC; border-width: 1px" width="100%" border="1px">
                                                <thead style="background-color: #FFE7A1">
                                                <tr>                    
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
                                                    $BackColour = "";
                                                    $_ResultSetRecords = User_browseTaskWFH($str_dbconnect,$_strEMPCODE, $sortby, $sortby2, $Dte_StartDate);													
                                                    /*$_ResultSet = User_browseTaskWFH($str_dbconnect,$LogUserCode, $sortby, $sortby2);*/
                                                    while ($_myrowRes = mysqli_fetch_array($_ResultSetRecords)) {

                                                        $ColorCode = substr($_myrowRes['wk_id'],0,1);

                                                        if($ColorCode == "E"){
                                                            $BackColour = "lavender";
                                                        }

                                                        if($ColorCode == "W"){
                                                            $BackColour = "lavenderblush";
                                                        }
														if($ColorCode == "C"){
                                                            $BackColour = "PaleTurquoise";
                                                        }
                                                ?>  
                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">                                     
                                                     <td rowspan="2" >
													 	<?php echo $_myrowRes['start_time'] .' - '.$_myrowRes['end_time']; ?>
													</td>
													<td rowspan="2" >
													 	<?php echo "<font color='RED'>" . getwfcatogorybyName($str_dbconnect,$_myrowRes['catcode']) . "</font>" ?>
													 </td>
                                                     <td align="center" >                        
                                                         <input type="radio" id="radio1" name="<?php echo $_myrowRes['wk_id'].'-RDO'; ?>" class="radio_b" 
                                                                value="Yes" <?php if($_myrowRes['status'] == "Yes") echo "checked='checked'" ?> />Yes
                                                         <input type="radio" id="radio2" name="<?php echo $_myrowRes['wk_id'].'-RDO'; ?>" class="radio_b"  
                                                                value="No" <?php if($_myrowRes['status'] == "No") echo "checked='checked'" ?>/>No
                                                         <input type="radio" id="radio3" name="<?php echo $_myrowRes['wk_id'].'-RDO'; ?>"  class="radio_b" 
                                                                value="N/A" value="No" <?php if($_myrowRes['status'] == "N/A") echo "checked='checked'" ?>/>N/A                  
                                                     </td>
													 <td>
													 	<input type="hidden" id="radio1" name="<?php echo $_myrowRes['wk_id'].'-RDOT'; ?>" class="radio_b" 
                                                                value="Time Taken" <?php if($_myrowRes['TimeType'] == "Time Taken") echo "checked='checked'" ?> />
                                                         <input type="hidden" id="radio2" name="<?php echo $_myrowRes['wk_id'].'-RDOT'; ?>" class="radio_b"  
                                                                value="Approx. Time Needed" <?php if($_myrowRes['TimeType'] == "Approx. Time Needed") echo "checked='checked'" ?>/>
<!--													 	<input type="text" id="<?php echo $_myrowRes['wk_id'].'-TIME'; ?>" name="<?php echo $_myrowRes['wk_id'].'-TIME'; ?>" value="<?php echo $_POST[$_myrowRes['TimeTaken'].'-TIME'];?>" width="10px"/>
-->														Start Time [00:00]	
														<input type="text" id="<?php echo $_myrowRes['wk_id'].'-FMTIME'; ?>" name="<?php echo $_myrowRes['wk_id'].'-FMTIME'; ?>" value="<?php if(isset($_POST[$_myrowRes['wk_id'].'-FMTIME'])) echo $_POST[$_myrowRes['wk_id'].'-FMTIME']; else echo '00:00' ?>" width="10px"/></br>
													 	End Time [00:00]
														<input type="text" id="<?php echo $_myrowRes['wk_id'].'-TIME'; ?>" name="<?php echo $_myrowRes['wk_id'].'-TIME'; ?>" value="<?php if(isset($_POST[$_myrowRes['wk_id'].'-TIME'])) echo $_POST[$_myrowRes['wk_id'].'-TIME']; else echo '00:00' ?>" width="10px"/></br>
											 			</td>
													
                                                     <td >
                                                        <b><?php echo "[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . ""; ?></b>
                                                     	<br/><br/>
														<font color='#383d7d'><?php echo "<b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i>"; ?></font>
														
													 </td>  
                                                 </tr>    
                                                 <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
												 	<td align="center" bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
														User Review Note
													</td>
                                                     <td colspan="2" align="center" bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                         <textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'].'-COM'; ?>" 
                                                                   id="<?php echo $_myrowRes['wk_id'].'COM'; ?>" rows="3"><?php echo $_myrowRes['wk_update']; ?></textarea>
                                                                   <br/>
                                                                    <?php  $WorkFlowid = $_myrowRes['wk_id']; ?> 
                                                      
                                                    	
                                                       <font color="#0000FF" size="3px"><u> <?php /*?> <input type="button" value=" Upload " onclick="OpenEditWindow(<?php echo $WorkFlowid; ?>)"/><?php */
                                                      	 echo "<a onclick=\"OpenEditWindow('".$WorkFlowid."');\">Upload Documents </a>";
														// echo "<input type=\"button\" value=\" Upload \" onclick=\"OpenEditWindow('".$WorkFlowid."');\"/>";  	?></u></font>                         
                                                     </td>   
                                                                           
                                                 </tr>
                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                    <td ><b>Workflow Attachments By Creator</b></td>
                                                    <td colspan="4" align="left" >  
                                                        <?php
                                                        $WorkFlowid = $_myrowRes['wk_id'];
                                                        $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
                                                        $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                        $num_rows = mysqli_num_rows($_ResultSetq);
                                                        if($num_rows > 0){                            
                                                            while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
                                                                echo "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> | ";                           
                                                            }                                                    
                                                        }else{
                                                            echo "There are no Attachments to Download";
                                                        }
                                                        ?>
                                                     </td>                         
                                                 </tr>
                                                  <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                 	<td ><b>Workflow Updated Attachments By User / Supervisor</b></td>
                                                    <td colspan="5" align="left" >  
                                                        <?php
                                                        $WorkFlowid = $_myrowRes['wk_id'];
                                                        $_SelectQueryq   =   "SELECT * FROM WorkflowAttachments WHERE `ParaCode` = '$WorkFlowid'";
                                                        $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));

                                                        $num_rows = mysqli_num_rows($_ResultSetq);
                                                        if($num_rows > 0){                            
                                                            while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {      
																//echo "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> | ";            
                                                                echo "<a href='files/".$_myrowResq['FileName']."'>".$_myrowResq['SystemName']."</a> | ";                           
                                                            }                                                    
                                                        }else{
                                                            echo "There are no Uploaded Documents to Download";
                                                        }
                                                        ?>
                                                     </td>                         
                                                 </tr>
                                                 <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                 	<td ><b>Covering Person</b></td>
                                                    <td colspan="5" align="left" >  
                                                        <?php

                                                        echo "<font color='BLACK'>" . getwfcoveringpersonbyName($str_dbconnect,$_myrowRes['wk_id']) . "</font>" ?>
                                                     </td>                         
                                                 </tr>
												 <tr bgcolor="#c0fbb6" style="border-color: #0063DC; border-width: 1px">
												 	<td ><b>Supervisor Note</b></td>
                                                 	<td colspan="3" align="center" bgcolor="grey" style="border-color: #0063DC; border-width: 1px">
                                                     	<textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'].'-NOTE'; ?>" 
                                                               id="<?php echo $_myrowRes['wk_id'].'NOTE'; ?>" rows="2"><?php  $_strEMPCODE = $_POST["optEmployee"];$Dte_StartDate = $_POST["txt_StartDate"];	 echo get_UserNotificationsWFV($str_dbconnect,$_strEMPCODE, $Dte_StartDate, $_myrowRes['wk_id']); ?></textarea>                         
                                                 	</td> 
                                                    <td >Re Do Task : &nbsp;&nbsp;<input type="checkbox" id="delall[]" name="delall[]" value="<?php echo $_myrowRes['wk_id']; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     <input type="text" id="txt_RedoDate" name="txt_RedoDate" class="TextBoxStyle" size="15"  value="<?php echo date("Y-m-d",strtotime('+1 days'));?>" onchange="getHours();"/>
						                        <input name="StartDate" type="hidden" id="StartDate" value="..." class="buttonDot" />
                                                <!--<script type='text/javascript'>
													$('#txt_RedoDate').datepicker(
														{dateFormat:'yy-mm-dd'}
													);
                                                </script>-->
						                         </td>                         
                                                 </tr>
												 <tr bgcolor="#FFE7A1" style="border-color: #0063DC; border-width: 1px;height:10px"> 
												 	<td colspan="5"></td>
												 </tr>
                                                <?php        

                                                    }
                                                ?> 

                                                
                                            </tbody>
                                            </table>
                                            <br/>
                                            <table align="center">
                                                <!--<tr >
                                                    <td width="30%" align="Right" height="30">
                                                        Upload Support Documents
														<?php echo $wk_id; ?>
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
                                                </tr>  -->
                                                <tr align="center">
                                                    <td colspan="3">
                                                        <div class="demo">        
                                                            <br>                                                           
                                                            <center>  
                                                            	 <input type="submit" value="Save Notes" id="btn_Save" name="btn_Save" />
																<!--<input type="submit" value="Send Mail" id="btn_Mail" name="btn_Mail" />
                                                                <input type="submit" value="Cancel" id="btn_Cancel" name="btn_Cancel" />       -->     
                                                            </center>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                    echo "<div class='Div-Msg' id='msg' align='left'>".$Message."</div>";        
                                                ?>
                                            </table>
                                            <br/><Br/>											
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
 
</form>
</body>
</html>