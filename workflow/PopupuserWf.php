<?php

    session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("../class/accesscontrole.php"); //  sql commands for the access controles
    include ("../class/sql_empdetails.php"); //  connection file to the mysql database
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    
    require_once("../class/class.phpmailer.php");
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

    <!-- ****************END***************** -->
    
     <!-- **************** TIME PICKER START  ***************** -->
    <!--<script type="text/javascript" src="../jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>    -->

    <!--<link rel="stylesheet" href="../jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />-->
    <script type="text/javascript" src="../js/jquery-ui-timepicker-addon.js"></script>
        
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
			Emp = document.getElementById("optEmployee").value;
			Dte = document.getElementById("txt_StartDate").value;
            document.forms['frm_WorkFlow'].action = "viewWorkFlow.php?sort="+sort+"&sort2="+sort2+"&Emp="+Emp+"&Dte="+Dte+"";
            document.forms['frm_WorkFlow'].submit();
        }
    </script>
   
   
</head>
<body>
    <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
     
    <?php
		$wk_id = "";		
		$timezone = "Asia/Colombo";	
		
		$Country = $_SESSION["LogCountry"];
		
		$_strEMPCODE = $_SESSION["LogEmpCode"];
		
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
		if($Country == "FIJI"){
			$timezone = "Pacific/Fiji";	
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
        
		
		if(isset($_GET["empUser"])){	
			
			$Dte_StartDate = $today_date;	
			
			$_strEMPCODE = $_GET["empUser"];
			$_SESSION["Fake_EmpCode"] = $_strEMPCODE;
			
			User_Get_DailyWorkFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
            User_Get_WeeklyWorkFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
            User_Get_MonthlyWorkFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
            User_Get_DailyEQFlow($str_dbconnect,$_strEMPCODE, $Country, $Dte_StartDate);
			
			$_ResultSetRecords = User_browseTaskWFH($str_dbconnect,$_strEMPCODE, $sortby, $sortby2, $Dte_StartDate);			
		}
        
        if(isset($_POST["btn_Save"])){            
			$Dte_StartDate = $today_date;	
			$_strEMPCODE = $_SESSION["Fake_EmpCode"];
            $wk_id = "";			
            $_ResultSetNote = browseTaskViewUser($str_dbconnect,$_strEMPCODE, $Dte_StartDate);
            while ($_myrowResNote = mysqli_fetch_array($_ResultSetNote)) {
			
                $InputBox = $_myrowResNote['wk_id']."-NOTE";
				$LogUserCode = $_SESSION["LogEmpCode"]; 			      
				
                $wk_id = $_myrowResNote['wk_id'];
				if($_POST[$InputBox] != ""){					
					updateWorkFlowNotification($str_dbconnect,$LogUserCode, $wk_id, $_POST[$InputBox] , $_strEMPCODE, $Dte_StartDate);	
					
				} 
				               
            }			
			$_ResultSetRecords = User_browseTaskWFH($str_dbconnect,$_strEMPCODE, $sortby, $sortby2, $Dte_StartDate);
			
			$checkBox = $_POST['delall'];
			$tdate = $_POST['txt_StartDate'];			
			for($i=0; $i<sizeof($checkBox); $i++){
				insertRedo($str_dbconnect,$checkBox[$i],$tdate);
			}
					
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
	
	
<div id="preloader"></div>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <div id="wrapper">
                <table width="100%" cellpadding="0" cellspacing="0">                    
                    <tr>                       
                        <td style="width: 0px; height: auto; background-color: #599b83" align="left" valign="top" id="leftBottom">
                            
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
                                                    /*$_ResultSet = User_browseTaskWFH($str_dbconnect,$LogUserCode, $sortby, $sortby2);*/
                                                    while ($_myrowRes = mysqli_fetch_array($_ResultSetRecords)) {

                                                        $ColorCode = substr($_myrowRes['wk_id'],0,1);

                                                        if($ColorCode == "E"){
                                                            $BackColour = "lavender";
                                                        }

                                                        if($ColorCode == "W"){
                                                            $BackColour = "lavenderblush";
                                                        }
														$RowCount = $RowCount + 1;
                                                ?>  
                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">    
													<td rowspan="4" align="center" style="height:50px;">
													 	<?php echo $RowCount; ?>
													 </td>                                
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
                                                                   id="<?php echo $_myrowRes['wk_id'].'COM'; ?>" rows="1"><?php echo $_myrowRes['wk_update']; ?></textarea>                         
                                                     </td>                         
                                                 </tr>
                                                <tr bgcolor="<?php echo $BackColour; ?>" style="border-color: #0063DC; border-width: 1px">
                                                    <td ><b>Attachments</b></td>
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
												 <tr bgcolor="#c0fbb6" style="border-color: #0063DC; border-width: 1px">
												 	<td ><b>Supervisor Note</b></td>
                                                 	<td colspan="3" align="center" bgcolor="grey" style="border-color: #0063DC; border-width: 1px">
                                                     	<textarea style="width: 99%" name="<?php echo $_myrowRes['wk_id'].'-NOTE'; ?>" 
                                                               id="<?php echo $_myrowRes['wk_id'].'NOTE'; ?>" rows="1"><?php  $_strEMPCODE = $_SESSION["Fake_EmpCode"];$Dte_StartDate = $today_date;	 echo get_UserNotificationsWFV($str_dbconnect,$_strEMPCODE, $Dte_StartDate, $_myrowRes['wk_id']); ?></textarea>                         
                                                 	</td>
													<td >Re Do Task : &nbsp;<input type="checkbox" id="delall[]" name="delall[]" value="<?php echo $_myrowRes['wk_id']; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id="txt_StartDate" name="txt_StartDate" class="TextBoxStyle" size="15"  value="<?php echo date("Y-m-d",strtotime('+1 days'));?>" onchange="getHours();"/>
						                        <input name="StartDate" type="hidden" id="StartDate" value="..." class="buttonDot" <?php if ($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>/>
						                        <!--<script type="text/javascript">
						                            $('#txt_StartDate').datepicker({
						                                dateFormat:'yy-mm-dd'
						                            });
						                        </script>--></td>                         
                                                 </tr>
												 <tr bgcolor="#FFE7A1" style="border-color: #0063DC; border-width: 1px;height:10px"> 
												 	<td colspan="6"></td>
												 </tr>


                                                <?php        

                                                    }
                                                ?> 
                                            </tbody>
                                            </table>
                                            <br/>
                                            <table align="center">                                                
                                                <tr align="center">
                                                    <td colspan="3">
                                                        <div class="demo">        
                                                            <br>
                                                            <center>                            
                                                                <input type="submit" value="Save Notes" id="btn_Save" name="btn_Save" />																
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