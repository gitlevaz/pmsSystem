<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Crate Work Flow
 * Last Update      :   06/10/2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

    session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("../class/accesscontrole.php"); //  sql commands for the access controles
    include ("../class/sql_empdetails.php"); //  connection file to the mysql database
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    
    include ("../class/sql_wkflow.php");            //  connection file to the mysql database
    
    require_once("../class/class.phpmailer.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
    $path = "../";
	$Menue	= "EmpShd";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS - WORK FLOW ::.</title>
    
    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
    <script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>
    
    <script src="jQuerry/development-bundle/ui/jquery.effects.pulsate.js"></script>
    

    
    <link rel="stylesheet" type="text/css" media="screen" href="../css/screen.css" />
    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />	
    
     <!-- **************** TIME PICKER START  ***************** -->
    <script type="text/javascript" src="jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>    

    <link rel="stylesheet" href="jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />
   

    <style type="text/css" title="currentStyle">
            @import "../media/css/demo_page.css";
            @import "../media/css/demo_table.css";
    </style>
    
    <script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>

    <!-- **************** NEW GRID END ***************** -->
    
    <!-- ************ FILE UPLOAD ********* -->

    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
   
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>

    <!-- ****************END***************** -->
    
    

    <style type="text/css">
        body{
            font-family:sans-serif;
            font-size:12px;
            color:#000066;
        }
        
        .imagebg{
            position: absolute;
            bottom: 0px;
            left: 0px;
            background-image: url("images/bg.png");
            background-repeat: repeat-x;
            z-index: 0;
            width: 100%; 
            height: 100%;
            z-index: 0;
        }
        
        .fieldsetclass{
            /*background-color:#FFFFFF;*/ 
            filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr='#fff9e1',EndColorStr='#ffea94');
            margin: 0px auto;
            border-color: #fff9e1;
        }
        
        .textboxStyle{
            border-radius: 4px; 
            -moz-border-radius: 4px; 
            -webkit-border-radius: 4px; 
            border-color: silver;
            color: #000066;
            border: 1 ;
            border-style: groove;            
        }
        
        table, td, tr, thead, tbody, th{
            /*border-color: #FFE7A1;*/
            
        }
        
        .table {
                font: 11px/24px Verdana, Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                }

        .th {
                padding: 0 0.1em;
                text-align: left;
                }
                
        .tr{
                border-top: 1px solid #FB7A31;
                border-bottom: 1px solid #FB7A31;
                background: #FFC;
                }

        .td {
                border-bottom: 1px solid #CCC;                
                padding-top: 0.1em;
                padding-left:  0.1em;
                padding-right:  0.1em;
                padding-bottom: 0.1em;
                }

        
        /*         
        td.adjacent {
                border-left: 1px solid #CCC;
                text-align: center;
                }
                
         
         */      
        .radio_b{
            padding:1px 5px 1px 5px;
            background-color:transparent;
            cursor: default;
            border: 0px;
            vertical-align: middle
        }
    </style>   
    
    
    <script>
	$(function() {
            $( "input:submit", ".demo" ).button();
            $( "input:button", ".demo" ).button();
	});
        
        $(document).ready(function() {
            $('#example').dataTable();
        } );
        
        var queueSize = 0;

        function startUpload(){
            var valdator = false;
            valdator = $("#frm_porject").valid();
            if(valdator != false){
                if (queueSize == 0) {
                    //alert("No Any Files to Upload!");
                    document.forms['frm_porject'].action = "../updateTask.php?btnSave=btnSave";
                    document.forms['frm_porject'].submit();
                }
                $('#fileUploadstyle').fileUploadStart()
            }
        }
        
        function load_scedule(){            
            $.post('get_Departments.php',{Sccmd: 'load', mtid : frm_WorkFlow.cmbEquioID.value},
                function(output){   
                    //alert(output);
                    $('#cmbmType').html(output);    
                    load_ScheduleDetails();
                }
            )            
        }
        
        function creat_MtTypes(){            
            $.post('get_Departments.php',{Mtcmd: 'insert', eqid : frm_WorkFlow.cmbEquioID.value, mttid : frm_WorkFlow.txtMaintCode.value, mttype : frm_WorkFlow.txtMaintType.value},
                function(output){  
                    //alert(output);
                    //$('#tblGrid').html(output);  
                    get_MtTypes();
                }
            )            
        }
        
        function get_MTYPESMC(){            
            $.post('get_Departments.php',{id : frm_WorkFlow.cmbDiv.value},
                function(output){                      
                    $('#cmbDpt').html(output);
                }
            )            
        }
        
        function creat_Schedule(){            
            $.post('get_Departments.php',{
                Schcmd: 'insert', 
                eqid : frm_WorkFlow.cmbEquioID.value, 
                mttid : frm_WorkFlow.cmbmType.value, 
                wfdate : frm_WorkFlow.txt_StartDate.value,
                starttime : frm_WorkFlow.timepicker_start.value,
                endtime : frm_WorkFlow.timepicker_end.value,
                emp : frm_WorkFlow.cmbEMP.value
            },
                function(output){  
                    //alert(output);
                    load_ScheduleDetails()
                }
            )            
        }
        
        function creat_EMPSchedule(){
            
            
            datasetvalue = document.frm_WorkFlow.dataSet.value;
            //alert(datasetvalue);
            splitdata = datasetvalue.split("@");
            //alert(datasetvalue);
            for (x in splitdata)
            {                
                wkid = splitdata[x];
                empcode = document.getElementById(wkid).value;
                //alert(wkid);
                $.post('get_Departments.php',{
                    Schcmd: 'updatewf', 
                    wfid : wkid, 
                    empcode : empcode
                },
                    function(output){  
                        //alert(output);                        
                    }
                )    
            }
            
            alert("Data Updated Successfully");
            load_ScheduleDetails();
        }
        
        function load_ScheduleDetails(){            
            $.post('get_Departments.php',{
                Schcmd: 'loadEmpData', 
                eqid : frm_WorkFlow.cmbEquioID.value, /*
                mttid : frm_WorkFlow.cmbmType.value, 
                wfdate : frm_WorkFlow.txt_StartDate.value,
                starttime : frm_WorkFlow.timepicker_start.value,
                endtime : frm_WorkFlow.timepicker_end.value,
                emp : frm_WorkFlow.cmbEMP.value,*/
                Fromdate : frm_WorkFlow.txt_FromDate.value,
                Todate : frm_WorkFlow.txt_ToDate.value
            },
                function(output){  
                    //alert(output);
                    $('#details').html(output); 
                    //get_MtTypes();
                }
            )            
        }
        
        $(function() {
		// run the currently selected effect
		function runEffect() {
			// get effect type from 
			var selectedEffect = 'Pulsate';

			// most effect types need no options passed by default
			var options = {};
			// some effects have required parameters
			if ( selectedEffect === "scale" ) {
				options = { percent: 100 };
			} else if ( selectedEffect === "size" ) {
				options = { to: { width: 280, height: 185 } };
			}
                        //alert('23434');
			// run the effect
			$( "#effect" ).show( selectedEffect, options, 500, callback );
                        //alert('sfsd');
		};

		//callback function to bring a hidden box back
		function callback() {
			setTimeout(function() {
				$( "#effect:visible" ).removeAttr( "style" ).fadeOut();
			}, 1000 );
		};

		// set effect from select menu value
		$( "#btn_Save" ).click(function() {
			runEffect();
			return false;
		});

		//$( "#effect" ).hide();
	});

    </script>
    
    <style>
	.toggler { width: 500px; height: 200px; }
	#button { padding: .5em 1em; text-decoration: none; }
	#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
	#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
    </style>
	

    
    
</head>
<body>
    
    <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >

        <div style="height: 100%;z-index: 1;" >
        
            <fieldset style="padding-left: 10px;" class="fieldsetclass" id="AssignWorkFlow" >
            <legend><strong></strong></legend>
                
                <center>
                <h3 style="color: #666">Labor Schedule</h3>
                </center>

                <hr></hr>
                <br/>                
                <center>        
                
<!--                <div class="demo">

                <div class="toggler">
                    <div id="effect" class="ui-widget-content ui-corner-all">
                        <h3 class="ui-widget-header ui-corner-all">Show</h3>
                        <p>
                                Etiam libero neque, luctus a, eleifend nec, semper at, lorem. Sed pede. Nulla lorem metus, adipiscing ut, luctus sed, hendrerit vitae, mi.
                        </p>
                    </div>
                </div>
                    </div>-->
                <table>
                    <caption align="center" style="height: 20px">Please Select the Week</caption>
                    
                    <tr>
                        <td>Date From</td>
                        <td>:</td>
                        <td>
                            <input type="text" id="txt_FromDate" name="txt_FromDate" class="textboxStyle" size="10" readonly="readonly"/>
                            <script type="text/javascript">
                                $('#txt_FromDate').datepicker({
                                    dateFormat:'yy-mm-dd'
                                });
                            </script>
                        </td>
                        <td>&nbsp</td>
                        <td>Date To</td>
                        <td>:</td>
                        <td>
                            <input type="text" id="txt_ToDate" name="txt_ToDate" class="textboxStyle" size="10" readonly="readonly"/>
                            <script type="text/javascript">
                                $('#txt_ToDate').datepicker({
                                    dateFormat:'yy-mm-dd'
                                });
                            </script>
                        </td>
                    </tr>
                </table>    
                 <hr></hr>
                <br/>     
                <br/>    
                <p>
                    <table width="80%" style="border-bottom: 0px; border-left: 0px; border-right: 0px; border-top: 0px; padding: 0 0 0 0px">
                        <tr>
                            <td  align="left">Equipment Name</td>                            
                            <td  colspan="4" align="left">
                                <select id="cmbEquioID" name="cmbEquioID" class="Div-TxtStyleNormal" onchange="load_scedule()">
                                <?php                                    
                                    $_ResultSet = get_eqtypes($str_dbconnect) ;
                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                ?>
                                    <option value="<?php echo $_myrowRes['eq_code']; ?>" > <?php echo $_myrowRes['eq_code']." ".$_myrowRes['eq_name'] ; ?> </option>
                                <?php } ?>
                                </select> 
                            </td> 
                        </tr>  
                        <tr><td colspan="5" height="10"></td></tr>
                        <!--
                        <tr>
                            <td  align="left">Maintenance Type</td>
                            <td  colspan="4" align="left">
                                <select id="cmbmType" name="cmbmType" class="Div-TxtStyleNormal" onchange="load_ScheduleDetails()">
                                    <option>Select Type</option>
                                </select>   
                            </td> 
                        </tr>  
                        <tr><td colspan="5" height="10"></td></tr>
                        <tr>
                            <td align="left">Date</td>
                            <td align="left">Start Time</td>
                            <td align="left">End Time</td>
                            <td align="left">Employee</td>
                            <td align="left"></td>
                        </tr>                        
                        <tr>
                            <td align="left">
                                <input type="text" id="txt_StartDate" name="txt_StartDate" class="textboxStyle" size="10" readonly="readonly"/>
                                <script type="text/javascript">
                                    $('#txt_StartDate').datepicker({
                                        dateFormat:'yy-mm-dd'
                                    });
                                </script>
                            </td>
                            <td align="left">
                                <input type="text" class="textboxStyle" name="timepicker_start" id="timepicker_start" size="10"></input>                                                        
                            </td>
                            <td align="left">
                                <input type="text" class="textboxStyle" name="timepicker_end" id="timepicker_end" size="10" ></input>                            
                            </td>
                            <td align="left">
                                <select id='cmbEMP' name='cmbEMP' class='Div-TxtStyleNormal'>";  
                                <?php
                                    $_ResultSet5 = getEMPLOYEEDETAILS($str_dbconnect) ;
                                    while($_myrowRes5 = mysqli_fetch_array($_ResultSet5)) {                                
                                        echo "<option value='".$_myrowRes5['EmpCode']."'>".$_myrowRes5['FirstName'].' '.$_myrowRes5['LastName']."</option>";                               
                                    } 
                                ?>
                                </select>
                            </td>
                        -->
                        <tr>
                            <td align="center" colspan="5">
                                <div class="demo">
                                    <input type="button" value="Save" id="btn_Save" name="btn_Save" onclick="creat_EMPSchedule()"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                    
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
                </p>
                
                <br/>
                
                <div style="padding-left: 5px; padding-right: 5px" >                    
                    <p id="details">
                        
                    </p>                    
                </div>     
                    
                <br/>
                <!--
                <div class="demo">
                <br/>
                <center>                     
                    
                    <input type="submit" value="Cancel" id="btn_Delete" name="btn_Delete" />
                </center>
                <br/>
                </div>
                </center>
                -->
            </fieldset>
            
        </div>
        <script type="text/javascript">
            load_scedule()
            //load_ScheduleDetails()
        </script>
    </form>
    
</body>
</html>