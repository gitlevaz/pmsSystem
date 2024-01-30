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
	$Menue	= "CreateMT";
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
        
        function get_MtTypes(){            
            $.post('get_Departments.php',{Mtcmd: 'get', mtid : frm_WorkFlow.cmbEquioID.value},
                function(output){                                
                    $('#details').html(output);                    
                }
            )            
        }
        
        function creat_MtTypes(){            
            $.post('get_Departments.php',
            {
                Mtcmd: 'insert', 
                eqid : frm_WorkFlow.cmbEquioID.value, 
                mttid : frm_WorkFlow.txtMaintCode.value, 
                mttype : frm_WorkFlow.txtMaintType.value,
                mtSced : frm_WorkFlow.cmbSchedule.value,
                mtStart : frm_WorkFlow.timepicker_start.value,
                mtEnd : frm_WorkFlow.timepicker_end.value,
                wfcat : frm_WorkFlow.cmbwfcat.value
            },
                function(output){  
                    //alert(output);
                    //$('#tblGrid').html(output);  
                    get_MtTypes();
                }
            )            
        }
        
        function deleteMT(Eqid, MtId){
            //alert(Eqid);
            $.post('get_Departments.php',
            {
                Mtcmd: 'delete', 
                eqid : Eqid, 
                mttid : MtId                
            },
                function(output){  
                    //alert(output);
                    //$('#tblGrid').html(output);  
                    get_MtTypes();
                }
            )
        }
    </script>
    
</head>
<body>
    <?php
    
        $Str_EQID = "";
        $Str_EQName = "";
    
    ?>
     <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >

        <div style="height: 100%;z-index: 1;" >
        
            <fieldset style="padding-left: 10px;" class="fieldsetclass" id="AssignWorkFlow" >
            <legend><strong></strong></legend>
                
                <center>
                <h3 style="color: #666">Maintenance Type</h3>
                </center>

                <hr></hr>
                <br/>
                <center>
                <p>
                    <table width="80%" style="border-bottom: 0px; border-left: 0px; border-right: 0px; border-top: 0px; padding: 0 0 0 0px"> 
                        <tr>
                            <td width="30%" align="Right" height="30">Equipment Name</td>
                            <td width="1%" height="30">&nbsp;:&nbsp;</td>
                            <td width="65%" align="left" height="30">                                
                                <select id="cmbEquioID" name="cmbEquioID" class="Div-TxtStyleNormal" onchange="get_MtTypes()">
                                <?php                                    
                                    $_ResultSet = get_eqtypes($str_dbconnect) ;
                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                ?>
                                    <option value="<?php echo $_myrowRes['eq_code']; ?>" > <?php echo $_myrowRes['eq_code']." ".$_myrowRes['eq_name'] ; ?> </option>
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="30%" align="Right" height="30">Maintenance Code</td>
                            <td width="1%" height="30">&nbsp;:&nbsp;</td>
                            <td width="65%" align="left" height="30"><input type="text" class="textboxStyle" name="txtMaintCode" size="40" value="<?php echo $Str_EQName; ?>"></input></td>
                        </tr>                        
                        <tr>
                            <td width="30%" align="Right" height="30">Maintenance Type</td>
                            <td width="1%" height="30">&nbsp;:&nbsp;</td>
                            <td width="65%" align="left" height="30"><input type="text" class="textboxStyle" name="txtMaintType" size="40" value="<?php echo $Str_EQName; ?>"></input></td>
                        </tr>
                        <tr>
                            <td width="30%" align="Right" height="30">
                                W/F Category
                            </td>
                            <td width="1%" height="30">
                                &nbsp;:&nbsp;
                            </td>
                            <td width="65%" align="left" height="30">
                                <select id="cmbwfcat" name="cmbwfcat" class="Div-TxtStyleNormal">
                                    <?php                                    
                                        $_ResultSet = getwfcategory($str_dbconnect) ;
                                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                    ?>
                                    <option value="<?php echo $_myrowRes['catcode']; ?>"  <?php //if ($_myrowRes['category'] == $_strEMPCODE) //echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['category'] ; ?> </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>    
                        <tr>
                            <td width="30%" align="Right" height="30">Schedule</td>
                            <td width="1%" height="30">&nbsp;:&nbsp;</td>
                            <td width="65%" align="left" height="30">
                                <select id="cmbSchedule" name="cmbSchedule" class="Div-TxtStyleNormal">
                                    <option id="Daily" value="Daily">Daily</option>
                                    <option id="Weekly" value="Weekly">Weekly</option>
                                    <option id="ByWeekly" value="by Weekly">By Weekly</option>
                                    <option id="Monthly" value="Monthly">Monthly</option>
                                </select>   
                            </td>
                        </tr>
                        <tr>
                            <td width="30%" align="Right" height="30">
                                Report Start Time
                            </td>
                            <td width="1%" height="30">
                                &nbsp;:&nbsp;
                            </td>
                            <td width="65%" align="left" height="30">
                                <input type="text" class="textboxStyle" name="timepicker_start" id="timepicker_start" size="15" value="<?php if(isset($_POST['timepicker_start'])) { echo $_POST['timepicker_start']; }?>"></input>                                                        
                            </td>
                        </tr>
                        <tr>
                            <td width="30%" align="Right" height="30">
                                Report End Time
                            </td>
                            <td width="1%" height="30">
                                &nbsp;:&nbsp;
                            </td>
                            <td width="65%" align="left" height="30">
                                <input type="text" class="textboxStyle" name="timepicker_end" id="timepicker_end" size="15" value="<?php if(isset($_POST['timepicker_end'])) { echo $_POST['timepicker_end']; }?>"></input>                            
                            </td>
                        </tr>
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
                    </table>
                </p>
           
            <div class="demo">
                <br/>
                <center>                     
                    <input type="button" value="Save" id="btn_Save" name="btn_Save" onclick="creat_MtTypes()"/>
                    <input type="submit" value="Cancel" id="btn_Delete" name="btn_Delete" />
                </center>
            </div>
                       
            <br/>
            <center>
            <h3 style="color: #666">Maintenance List</h3>
            </center>
            <hr></hr>
            <br/>
            </center>
            
                <div style="padding-left: 5px; padding-right: 5px" >                    
                    <p id="details">
                        
                    </p>                    
                </div>  
                
            </fieldset>
        </div>
         
         <script type="text/javascript">
             get_MtTypes();
        </script>
     </form>
    
    
</body>
</html>