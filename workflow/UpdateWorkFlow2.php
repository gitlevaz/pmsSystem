<?php

    session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("../class/accesscontrole.php"); //  sql commands for the access controles
    include ("../class/sql_empdetails.php"); //  connection file to the mysql database
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    
    require_once("../class/class.phpmailer.php");
	require_once("../class/class.SMTP.php");

    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database
    
    include ("../class/sql_wkflow.php");            //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
    $path = "../";
	$Menue	= "UpdateWF";
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

    <!-- ****************END***************** -->
    
     <!-- **************** TIME PICKER START  ***************** -->
    <script type="text/javascript" src="../jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>    

    <link rel="stylesheet" href="../jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />
        
    <script type="text/javascript">        
        
        $(function() {
            $( "input:submit", ".demo" ).button();		
	});       
        
    </script>
    
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
        
        $(window).load(function() { 
             $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
        }); 
        
        function getWFDetails(){
            sort = document.getElementById("cmbSort").value;
            sort2 = document.getElementById("cmbSort2").value;
            document.forms['frm_WorkFlow'].action = "Updateworkflow.php?sort="+sort+"&sort2="+sort2+"";
            document.forms['frm_WorkFlow'].submit();
        }
    </script>
</head>
<body>
    <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
     
    <?php
        
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
        }
        
        if ( validateLoading($str_dbconnect,$LogUserCode) < 1 ){ 
            
            Get_DailyWorkFlow($str_dbconnect,$LogUserCode);
            Get_WeeklyWorkFlow($str_dbconnect,$LogUserCode);
            Get_MonthlyWorkFlow($str_dbconnect,$LogUserCode);
            Get_DailyEQFlow($str_dbconnect,$LogUserCode);
            
            updateSummary($str_dbconnect,$LogUserCode);
            
        }
        
        if(isset($_POST["btn_Save"])){            
            //echo "PAGE SUBMIT";
            $wk_id = "";
            $_ResultSet = browseTask($str_dbconnect,$LogUserCode);
            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                
                $InputBox = $_myrowRes['wk_id']."-COM";
                $RadioButton = $_myrowRes['wk_id']."-RDO"; 
                $wk_id = $_myrowRes['wk_id'];
                updateWorkFlow($str_dbconnect,$LogUserCode, $_myrowRes['wk_id'], $_POST[$InputBox] , $_POST[$RadioButton]);
            }
            
            /* ----------------------------------------------------------------- */
                // $mailer = new PHPMailer();
                // $mailer->IsSMTP();
                // $mailer->Host = '10.9.0.166:25';					// $mailer->Host = 'ssl://smtp.gmail.com:465';
                // $mailer->SetLanguage("en", 'class/');						// $mailer->SetLanguage("en", 'class/');
                // $mailer->SMTPAuth = TRUE;
                // $mailer->IsHTML = TRUE;
                // $mailer->Username = 'pms@eTeKnowledge.com'; // Change this to your gmail adress			$mailer->Username = 'info@tropicalfishofasia.com';
                // $mailer->Password = 'pms@321'; // Change this to your gmail password			$mailer->Password = 'info321';
                // $mailer->From = 'pms@eTeKnowledge.com'; //$StrFromMail; // This HAVE TO be your gmail adress   $mailer->From = 'info@tropicalfishofasia.com';
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
				$mail->CharSet = "text/html; charset=UTF-8;";
						
				//O365 Email Function END			
				
                $MagBody  = getWFUPDATEMAIL($str_dbconnect,$LogUserCode);
                
                	$mailer->Body =str_replace('"','\'',$MagBody);	
                //$mailer->Body = $MagBody;
                /* ----------------------------------------------------------------- */
                $TskUser =  getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$LogUserCode);
                $today_date  = date("Y-m-d");
                
                $mailer->AddAddress('shameerap@cisintl.com');
                $mailer->AddCC('indikag@cisintl.com');
                $MailTitile = "Daily Work Flow Task Status For W/F User : ".$TskUser." Date : ".$today_date."";
                $mailer->Subject = $MailTitile;
				
								
                /*$MailTitile = "TO : " . $TaskUsers . " - NEW TASK - " . $_Division . " " . $_Department . " - " . $Str_TaskName;
                
                echo "<script type='text/javascript'>
						alert('W/F Updated & Mail Sent');
						window.location.href = '../Home.php';
					</script>";
					
                $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner));
                $mailer->AddBCC('pms@cisintl.com');*/
				
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='WORKFLOW' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
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

            $InputBox = $_myrowRes['wk_id']."-COM";
            $RadioButton = $_myrowRes['wk_id']."-RDO"; 
            
            $_POST[$InputBox] = $_myrowRes['wk_update'];
            $_POST[$RadioButton] = $_myrowRes['status'];
            
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
                                            <font color="#0066FF">Update Work Flow</font> of User : <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]) ?> on <?php echo $today_date; ?>
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
                                                    <option id="WFN" value="WFN" <?php if ("WFN" == $sortby) echo "selected=\"selected\";" ?>>-- Work Flow Task Only</option>
                                                    <option id="EMO" value="EMO" <?php if ("EMO" == $sortby) echo "selected=\"selected\";" ?>>-- Equipment Maintenance Only</option>
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
                                <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                    <tr>
                                        <td>                                                
                                            <table cellpadding="2px" cellspacing="0px" border="1px" style="border-color: #0063DC; border-width: 1px" width="100%" border="1px">
                                                <thead style="background-color: #FFE7A1">
                                                <tr>                    
                                                    <th width="120px">Time</th>
                                                    <th width="150px">Task Status</th>
													<th width="150px">Hrs Spent</th>
                                                    <th>Task</th>                                                
                                                </tr>
                                            </thead>
                                            <tbody style="border-color: #0063DC; border-width: 2px">

                                                <?php
                                                    //
                                                    $BackColour = "";
                                                    $_ResultSet = browseTaskWFH($str_dbconnect,$LogUserCode, $sortby, $sortby2);
                                                    while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {

                                                        $ColorCode = substr($_myrowRes['wk_id'],0,1);

                                                        if($ColorCode == "E"){
                                                            $BackColour = "lavender";
                                                        }

                                                        if($ColorCode == "W"){
                                                            $BackColour = "lavenderblush";
                                                        }
                                                ?>  
                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">                                     
                                                     <td rowspan="2" >
													 	<?php echo $_myrowRes['start_time'] .' - '.$_myrowRes['end_time']; ?>
													</td>
                                                     <td align="center" >                        
                                                         <input type="radio" id="radio1" name="<?php echo $_myrowRes['wk_id'].'-RDO'; ?>" class="radio_b" 
                                                                value="Yes" <?php if(isset($_POST[$_myrowRes['wk_id'].'-RDO']) && $_POST[$_myrowRes['wk_id'].'-RDO'] == "Yes") echo "checked='checked'" ?> />Yes
                                                         <input type="radio" id="radio2" name="<?php echo $_myrowRes['wk_id'].'-RDO'; ?>" class="radio_b"  
                                                                value="No" <?php if(isset($_POST[$_myrowRes['wk_id'].'-RDO']) && $_POST[$_myrowRes['wk_id'].'-RDO'] == "No") echo "checked='checked'" ?>/>No
                                                         <input type="radio" id="radio3" name="<?php echo $_myrowRes['wk_id'].'-RDO'; ?>"  class="radio_b" 
                                                                value="N/A" value="No" <?php if(isset($_POST[$_myrowRes['wk_id'].'-RDO']) && $_POST[$_myrowRes['wk_id'].'-RDO'] == "N/A") echo "checked='checked'" ?>/>N/A                  
                                                     </td>
													 <td>
													 	<input type="text" id="txtHrsSpent" name="txtHrsSpent" value="00:00:00" width="10px"/>
													 </td>
                                                     <td >
                                                        <?php echo "[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . " - <font color='RED'>" . getwfcatogorybyName($str_dbconnect,$_myrowRes['catcode']) . "</font>"; ?>
                                                     </td>  
                                                 </tr>    
                                                 <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                     <td colspan="3" align="center" bgcolor="grey" style="border-color: #0063DC; border-width: 1px">
                                                         <textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'].'-COM'; ?>" 
                                                                   id="<?php echo $_myrowRes['wk_id'].'COM'; ?>" rows="3"><?php if(isset($_POST[$_myrowRes['wk_id'].'-COM'])) echo $_POST[$_myrowRes['wk_id'].'-COM']; ?></textarea>                         
                                                     </td>                         
                                                 </tr>
                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                    <td ><b>Attachments</b></td>
                                                    <td colspan="2" align="left" >  
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


                                                <?php        

                                                    }
                                                ?> 
                                            </tbody>
                                            </table>
                                            <br/>
                                            <table>
                                                <tr >
                                                    <td width="30%" align="Right" height="30">
                                                        Upload Support Documents
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
                                                </tr>  
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="demo">        
                                                            <br>
                                                            <center>                            
                                                                <input type="submit" value="Save" id="btn_Save" name="btn_Save" />
                                                                <input type="submit" value="Cancel" id="btn_Cancel" name="btn_Cancel" />            
                                                            </center>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                    echo "<div class='Div-Msg' id='msg' align='left'>".$Message."</div>";        
                                                ?>
                                            </table>
                                            <br/><Br/>
											<?php echo getWFUPDATEMAILSUMMARY($str_dbconnect); ?>
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