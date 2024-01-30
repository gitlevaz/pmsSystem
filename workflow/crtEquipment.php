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
	$Menue	= "CreateEquip";
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
/*        body{
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
            background-color:#FFFFFF; 
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
            border-color: #FFE7A1;
            
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
                }*/

        
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
    
    <style>
	.toggler { width: 500px; height: 200px;}
	/*#button { padding: .5em 1em; text-decoration: none; }*/
	#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
	#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
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
        
        function get_eqtypes(){            
            $.post('get_Departments.php',{cmd: 'get', eqid : frm_WorkFlow.txtEquioID.value},
                function(output){  
                    //alert(output);
                    $('#details').html(output); 
                    runEffect(frm_WorkFlow.txtEquioID.value);
                }
            )            
        }
        
        function creat_EqTypes(){            
            $.post('get_Departments.php',{cmd: 'insert', eqid : frm_WorkFlow.txtEquioID.value, eqtype : frm_WorkFlow.txtEquioName.value},
                function(output){  
                    //alert(output);
                    //$('#tblGrid').html(output);  
                    get_eqtypes($str_dbconnect);
                }
            )            
        }
        
      
        //callback function to bring a hidden box back
        function callback() {
                setTimeout(function() {
                        $( "#details:visible" ).removeAttr( "style" ).fadeOut();
                }, 1000 );
        };
            
        function runEffect(idvalue) {
            var options = {};           
            $('#details').show( pulsate, options, 500, callback );
        }
       
        
    </script>
    
</head>
<body>
    <?php
    
        $Str_EQID = "";
        $Str_EQName = "";
    
    ?>
     <form id="frm_WorkFlow" name="frm_WorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
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
                                                <font color="#0066FF">Equipment Details</font>
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>                                    
                                    <br></br>
                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>                                                
                                                <table width="100%"> 
                                                    <tr>
                                                        <td width="20%" align="left" height="30">Equipment Code</td>
                                                        <td width="2%" >:</td>
                                                        <td align="left" ><input type="text" class="TextBoxStyle" name="txtEquioID" size="10" value="<?php echo $Str_EQID; ?>"></input></td>
                                                    </tr>

                                                     <tr>
                                                         <td align="left">Equipment Name</td>
                                                         <td width="2%">:</td>
                                                         <td align="left"><input type="text" class="TextBoxStyle" name="txtEquioName" size="40" value="<?php echo $Str_EQName; ?>"></input></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><br/><br/></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="demo">                
                                                                <center>                   
                                                                    <input type="button" value="Save" id="btn_Save" name="btn_Save"  onclick="creat_EqTypes()"/>
                                                                    <input type="submit" value="Cancel" id="btn_Delete" name="btn_Delete" />
                                                                </center>
                                                            </div>
                                                        </td>                                                            
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><br/></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div style="padding-left: 5px; padding-right: 5px" >                    
                                                                <p id="details">

                                                                </p>                    
                                                            </div>   
                                                        </td>
                                                    </tr>                                                        
                                                </table>
                                                <script type="text/javascript">
                                                     get_eqtypes();
                                                </script>
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