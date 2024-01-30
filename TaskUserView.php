<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Home Page for the All Controles
 * Last Update      :   19-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

if(!isset($_SESSION["LogUserName"]) || !isset($_SESSION["CompCode"])){
    echo "<script type='text/javascript'>";
    echo "self.SessionLost();"; 
    echo "</script>";
}
//  importing all neccessary clasess

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
include ("class/accesscontrole.php");       //  sql commands for the access controles
include ("class/sql_empdetails.php");        //  connection file to the mysql database
include ("class/sql_project.php");          //  sql commands for the access controles
include ("class/sql_sysusers.php");          //  sql commands for the access controls
include ("class/sql_task.php");             //  sql commands for the access controles
include ("class/Authentication/AuthTypeTwo.php"); //  Role Autherization

//  connecting the mysql database
mysqli_select_db($str_dbconnect,"$str_Database") or die ("Unable to establish connection to the MySql database");

$path = "";
$Menue	= "UserView";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>.:: PMS 3.0v ::.</title>
<meta charset="utf-8" />

<link href="css/styleB.css" rel="stylesheet" type="text/css" />

<!--    Loading Jquerry Plugin  -->
<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>

<link rel="stylesheet" href="css/project.css" type="text/css"/>
<link rel="stylesheet" href="css/slider.css" type="text/css"/>
<link href="css/textstyles.css" rel="stylesheet" type="text/css"/>

<script src="ui/jquery.ui.core.js"></script>
<script src="ui/jquery.ui.widget.js"></script>
<script src="ui/jquery.ui.dialog.js"></script>

<!-- **************** NEW GRID ***************** -->
<style type="text/css" title="currentStyle">
        @import "media/css/demo_page.css";
        @import "media/css/demo_table.css";
</style>    
<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
<!-- **************** NEW GRID END ***************** -->

<script type="text/javascript" src="charts/jscharts.js"></script>
    
<script>
    
    $(function() {
        $( "input:submit, a, button", ".button" ).button();
        $( "a", ".button" ).click(function() { return false; });
    });

    function PleaseWait(){
        $( "#loading" ).dialog({
            height: 140,
            modal: true,
            closeOnEscape: false
        });        
    }
    
    function unloadPleaseWait(){       
       $("#loading").dialog("close");       
    }

    $(document).ready(function(){ 
       $( "#loading" ).dialog({
            height: 140,
            modal: true,
            closeOnEscape: false
        });            
    });
    
    $(function() {
        $( "#accordion" ).accordion({
            collapsible: true,
            autoHeight: false,
            navigation: true
        });
    });
    
    function fnFormatDetails ( oTable, nTr, hlink ){
        var aData = oTable.fnGetData( nTr );
        var sOut = "<table border='0'>";
        sOut += "<tr><td><center><iframe width='800px' style='border: none;' src='MaintaskbrowseDigUserView.php?&procode="+aData[2]+"'></center> </td></tr>";
        sOut += "</table>";
        return sOut;
    }

    $(document).ready(function() {
        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement( 'th' );
        var nCloneTd = document.createElement( 'td' );
        nCloneTd.innerHTML = '<img src="images/details_open.png">';
        nCloneTd.className = "center";

        $('#example thead tr').each( function () {
            this.insertBefore( nCloneTh, this.childNodes[0] );
        } );

        $('#example tbody tr').each( function () {
            this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
        } );

        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#example').dataTable( {
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 0 ] }
            ],
            "aaSorting": [[1, 'asc']]
        });

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#example tbody td img').live('click', function () {
            var nTr = this.parentNode.parentNode;
            if ( this.src.match('details_close') )
            {
                /* This row is already open - close it */
                this.src = "images/details_open.png";
                oTable.fnClose( nTr );
            }
            else
            {
                /* Open this row */
                this.src = "images/details_close.png";
                oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr, 'PRO/62' ), 'details' );
            }
        } );
    } );
    
    $(document).ready(function() {
        $('#example1').dataTable();
    } );

    $(document).ready(function() {
        $('#example2').dataTable();
    } );
    
    $(window).load(function() { 
         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
    }); 
    
</script>

<script type="text/javascript">
		function getCountry(){           
		 	countryid = document.getElementById('countrycode1').value;	
			//alert (countryid);		 	
            $.post('class/sql_taskuserview.php',{countrydata : countryid},			
                function(output){ 						                 
                    $('#departmentcode').html(output);
					//alert (output);
                }
            )           
        }
		function getDepartment(){           
		 	depid = document.getElementById('departmentcode').value;	
			//alert (depid);		 	
            $.post('class/sql_taskuserview.php',{depdata : depid},			
                function(output){ 						                 
                    $('#empcode').html(output);
					//alert (output);
                }
            )           
        }
		

    function View(hlink){           
        document.forms[0].action = "MaintaskbrowseUserView.php?&procode="+hlink+"";
        document.forms[0].submit();
    }

    function Approve(hlink,hlinkID ){        
        document.forms[0].action = "ApproveTaskUser.php?&taskcode="+hlink+"&taskid="+hlinkID+"&Page=Main";
        document.forms[0].submit();
    }

    function toggle() {
         if( document.getElementById("hidethis").style.display=='none' ){
           document.getElementById("hidethis").style.display = '';
         }else{
           document.getElementById("hidethis").style.display = 'none';
         }
    }
    
    function ViewUserDetails(){
        EmpCode = document.getElementById('empcode').value;
        document.forms['frm_Home'].action = "TaskUserView.php?EmpCode=" + EmpCode + "";
        document.forms['frm_Home'].submit();
    }
	
	function ChangePriority(hlink){     
		//alert(hlink);      
		EmpCode = document.getElementById('optEmployee').value;
        document.forms[0].action = "TaskUserView.php?ChgCode="+hlink+"&EmpCode=" + EmpCode + "";
        document.forms[0].submit();
    }
    
    
</script>

</head>
<body>
<?php
    $countrycode = "";
    if(isset($_GET["EmpCode"])){
        $_strEMPCODE = $_GET["EmpCode"];
		$countrycode = $_POST["countrycode1"];
		$depcode = $_POST["departmentcode"];		
        $_SESSION["Fake_EmpCode"] = $_strEMPCODE;
        
    }else{
        $_strEMPCODE = $_SESSION["LogEmpCode"];
        $_SESSION["Fake_EmpCode"] = $_strEMPCODE;
    }
	
	if(isset($_GET["ChgCode"]) && $_GET["ChgCode"] != "" ){
		$ChngeProject	= 	$_GET["ChgCode"];	
		$Priority		=	$_POST["$ChngeProject"];
		
		ChangeProjectPriority($str_dbconnect,$ChngeProject, $Priority);	
		
	}
?>
   
<div id="preloader"></div>

<form name="frm_Home" id="frm_Home" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

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
                                                <font color="#0066FF"> User Level Task View, </font> of Employee :  <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["Fake_EmpCode"]) ?>                                                 
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>
                                    <br></br>
                                    <table width="80%" cellpadding="0" cellspacing="0" border="1px" style="border-color: #0066FF; border-width: 1px" align="center">
                                        <tr style="height: 50px;background-color: #E0E0E0">                                        	
                                            <td style="padding-left: 10px;position: relative" align="center">
                                            	<table>
                                                <tr height="5px"></tr>
                                                <tr>
                                                    <td><font color="#0066FF">Country</font>&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;
                                                    	
                                                        <select name="countrycode1" id="countrycode1" class="TextBoxStyle" style="width:180px" onChange="getCountry();">           
                                                       <option id="ALL" value="ALL" <?php if($countrycode == "ALL") echo "selected=\"selected\""; ?>>ALL</option>
								                                <option id="SL" value="SL" <?php if($countrycode == "SL") echo "selected=\"selected\""; ?>>SL</option>
								                                <option id="US" value="US" <?php if($countrycode == "US") echo "selected=\"selected\""; ?>>US</option>
								                                <option id="TI" value="TI" <?php if($countrycode == "TI") echo "selected=\"selected\""; ?>>TI &nbsp;&nbsp;</option>
																<option id="UK" value="UK" <?php if($countrycode == "UK") echo "selected=\"selected\""; ?>>UK &nbsp;&nbsp;</option>
																<option id="MLD" value="MLD" <?php if($countrycode == "MLD") echo "selected=\"selected\""; ?>>MLD &nbsp;&nbsp;</option>
																<option id="CN" value="CN" <?php if($countrycode == "CN") echo "selected=\"selected\""; ?>>CN &nbsp;&nbsp;</option>
																<option id="AU" value="AU" <?php if($countrycode == "AU") echo "selected=\"selected\""; ?>>AU &nbsp;&nbsp;</option>
																<option id="FIJI" value="FIJI" <?php if($countrycode == "FIJI") echo "selected=\"selected\""; ?>>FIJI &nbsp;&nbsp;</option>
                                                        </select>  
                                                    </td>
                                                </tr>
                                               <tr height="5px"></tr>
                                                <tr>
                                                    <td><font color="#0066FF">Department</font>&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;
                                                     <script type="text/javascript">
                                                            getCountry();
                                                     </script>
                                                     <select id="departmentcode" name="departmentcode" style="width:180px"  class="TextBoxStyle" onChange="getDepartment();">
                                                     </select> 
                                                    
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>  
                                                    <font color="#0066FF">Employee Name</font>&nbsp;&nbsp;                                                   <script type="text/javascript">
                                                           getDepartment();
                                                     </script>
                                                     <select id="empcode" name="empcode" style="width:180px"  class="TextBoxStyle">         
                                                     </select> 
                                                   
                                                    &nbsp;&nbsp;
                                                    <input type="button" name="ViewUser" id="ViewUser" value="View Details" onclick="ViewUserDetails()"/>                                              </td>
                                                 </tr> 
                                                </table>                                                
                                            </td>
                                        </tr>
                                    </table>  
                                    <br></br>
                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>
                                                <div class="demo">
                                                    <div id="accordion">
                                                            <h3><a href="#">Summary</a></h3>
                                                            <div style="overflow: hidden">
<!--                                                                <p>-->
                                                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0px">
                                                                        <tr>
                                                                            <td align="center" >                                                                            
                                                                                <div id="graph" >Loading graph...</div>
                                                                                <?php
                                                                                    $Total_Task = "0";
                                                                                    $Task_Completed = "0";
                                                                                    $TaskInProgress = "0";
                                                                                    $TaskPendApproval = "0";
                                                                                    $TaskNotStarted = "0";
                                                                                    
                                                                                    $Total_Task = get_NoOfTaskforEmp($str_dbconnect,$_strEMPCODE);
                                                                                    $Task_Completed = get_NoOfTaskforEmpTC($str_dbconnect,$_strEMPCODE);
                                                                                    $TaskInProgress =  get_NoOfTaskforEmpTI($str_dbconnect,$_strEMPCODE);
                                                                                    $TaskPendApproval =   get_NoOfTaskforEmpCW($str_dbconnect,$_strEMPCODE);
                                                                                    $TaskNotStarted =   get_NoOfTaskforEmpTN($str_dbconnect,$_strEMPCODE);
																					
																					$List = "";
																					$Colour = "";
																					if($Task_Completed != "0"){
																						if($List != ""){
																							$List 	.= ",['Task Completed - [TC]', ".$Task_Completed."]"; 
																							$Colour .= ",'#C40000'";		
																						}else{
																							$List .= "['Task Completed - [TC]', ".$Task_Completed."]";
																							$Colour .= "'#C40000'"; 		
																						}
																						
																					}
																					
																					if($TaskInProgress != "0"){
																						if($List != ""){
																							$List .= ",['Task In Progress - [TIP]', ".$TaskInProgress."]"; 	
																							$Colour .= ",'#750303'";	
																						}else{
																							$List .= "['Task In Progress - [TIP]', ".$TaskInProgress."]"; 
																							$Colour .= "'#750303'";		
																						}
																						
																					}
																					
																					if($TaskPendApproval != "0"){
																						if($List != ""){
																							$List .= ",['Task In Pending Approval - [TIPA]', ".$TaskPendApproval."]"; 
																							$Colour .= ",'#158f2c'";		
																						}else{
																							$List .= "['Task In Pending Approval - [TIPA]', ".$TaskPendApproval."]"; 	
																							$Colour .= "'#158f2c'";	
																						}
																						
																					}
																					
																					if($TaskNotStarted != "0"){
																						if($List != ""){
																							$List .= ",['Task Not Started - [TNS]', ".$TaskNotStarted."]"; 
																							$Colour .= ",'#FA9000'";		
																						}else{
																							$List .= "['Task Not Started - [TNS]', ".$TaskNotStarted."]"; 	
																							$Colour .= "'#FA9000'";	
																						}
																						
																					}
																					
																					//echo $List;
                                                                                
                                                                                ?>
                                                                                <script type="text/javascript">
                                                                                        var myData = new Array(<?php echo $List; ?>);
                                                                                        var colors = [<?php echo $Colour; ?>];
                                                                                        var myChart = new JSChart('graph', 'pie');
                                                                                        myChart.setDataArray(myData);
                                                                                        myChart.colorizePie(colors);
                                                                                        myChart.setTitle('<?php echo $Total_Task; ?> - Tasks Assigned');
                                                                                        myChart.setTitleColor('#000000');
                                                                                        myChart.setTitleFontSize(11);
                                                                                        myChart.setTextPaddingTop(30);
                                                                                        myChart.setSize(500, 340);
//                                                                                        myChart.setPiePosition(200, 170);
                                                                                        myChart.setPieRadius(85);
                                                                                        myChart.setPieUnitsColor('#0066FF');
//                                                                                        myChart.setBackgroundImage('');
                                                                                        myChart.draw();
                                                                                </script>
                                                                            </td>
                                                                            <td align="center">
                                                                                <div id="chartcontainer">This is just a replacement in case Javascript is not available or used for SEO purposes</div>

                                                                                <script type="text/javascript">
                                                                                    var myData = new Array(['TC', <?php echo $Task_Completed; ?>], ['TIP', <?php echo $TaskInProgress; ?>], ['TIPA', <?php echo $TaskPendApproval; ?>], ['TNS', <?php echo $TaskNotStarted; ?>]);
                                                                                    var myChart = new JSChart('chartcontainer', 'bar');
                                                                                    myChart.setDataArray(myData);
                                                                                    myChart.setTitle('<?php echo $Total_Task; ?> - Tasks Assigned');
                                                                                    myChart.setTitleColor('#000000');
//                                                                                    myChart.setSize(616, 321);
                                                                                    myChart.draw();
                                                                                </script>                                                                    
                                                                            </td>
                                                                        </tr> 
																		<tr>
                                                                            <td align="center" >    
																				<?php
																				
																					$timezone = "Asia/Colombo";			
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
																					if($Country == "UK"){
																						$timezone = "Europe/London";
																					}	
																						
																					if($Country == "MLD"){
																						$timezone = "Indian/Maldives";
																					}
																					if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
																					date_default_timezone_set($timezone);
																			           
																			        $today_date  = date("Y-m-d");
																						
                                                                                    $Total_WF = "0";
                                                                                    $WF_Yes = "0";
                                                                                    $WF_No = "0";
                                                                                    $WF_NA = "0";                                                                                    
                                                                                    
                                                                                    $Total_WF 	= get_NoOfTaskforWF($str_dbconnect,$_strEMPCODE,$today_date);
                                                                                    $WF_Yes 	= get_NoOfTaskforWFYES($str_dbconnect,$_strEMPCODE,$today_date);
                                                                                    $WF_No 		= get_NoOfTaskforWFNO($str_dbconnect,$_strEMPCODE,$today_date);
                                                                                    $WF_NA 		= get_NoOfTaskforWFNA($str_dbconnect,$_strEMPCODE,$today_date);                                                                                    
																					
																					$ListWF = "";
																					$ColourWF = "";
																					
																					if($WF_Yes != "0"){
																						if($ListWF != ""){
																							$ListWF 	.= ",['W/F Completed', ".$WF_Yes."]"; 
																							$ColourWF .= ",'#C40000'";		
																						}else{
																							$ListWF .= "['W/F Completed', ".$WF_Yes."]";
																							$ColourWF .= "'#C40000'"; 		
																						}																						
																					}
																					
																					if($WF_No != "0"){
																						if($ListWF != ""){
																							$ListWF .= ",['W/F Not Done', ".$WF_No."]"; 	
																							$ColourWF .= ",'#750303'";	
																						}else{
																							$ListWF .= "['W/F Not Done', ".$WF_No."]"; 
																							$ColourWF .= "'#750303'";		
																						}
																						
																					}
																					
																					if($WF_NA != "0"){
																						if($ListWF != ""){
																							$ListWF .= ",['W/F Not Applicable', ".$WF_NA."]"; 
																							$ColourWF .= ",'#158f2c'";		
																						}else{
																							$ListWF .= "['W/F Not Applicable', ".$WF_NA."]"; 	
																							$ColourWF .= "'#158f2c'";	
																						}
																						
																					}												
                                                                                	
                                                                                ?>                                                                        
                                                                           		<div id="graph2" >Loading graph...</div>
																				<script type="text/javascript">
                                                                                        var myData = new Array(<?php echo $ListWF; ?>);
                                                                                        var colors = [<?php echo $ColourWF; ?>];
                                                                                        var myChart = new JSChart('graph2', 'pie');
                                                                                        myChart.setDataArray(myData);
                                                                                        myChart.colorizePie(colors);
                                                                                        myChart.setTitle('<?php echo $Total_WF; ?> - W/F Task For the Day');
                                                                                        myChart.setTitleColor('#000000');
                                                                                        myChart.setTitleFontSize(11);
                                                                                        myChart.setTextPaddingTop(30);
                                                                                        myChart.setSize(500, 340);
//                                                                                        myChart.setPiePosition(200, 170);
                                                                                        myChart.setPieRadius(85);
                                                                                        myChart.setPieUnitsColor('#0066FF');
//                                                                                        myChart.setBackgroundImage('');
                                                                                        myChart.draw();
                                                                                </script>    
                                                                            </td>
                                                                            <td align="center">
                                                                                <div id="chartcontainer23">This is just a replacement in case Javascript is not available or used for SEO purposes</div>

                                                                                <script type="text/javascript">
                                                                                    var myData1 = new Array(<?php echo $ListWF; ?>);
                                                                                    var myChart1 = new JSChart('chartcontainer23', 'bar');
                                                                                    myChart1.setDataArray(myData1);
                                                                                    myChart1.setTitle('<?php echo $Total_WF; ?> - W/F Task For the Day');
                                                                                    myChart1.setTitleColor('#000000');
//                                                                                    myChart.setSize(616, 321);
                                                                                    myChart1.draw();
                                                                                </script>                                                                    
                                                                            </td>
                                                                        </tr>                                                                       
                                                                    </table>
<!--                                                                </p>-->
                                                            </div>
                                                            <h3><a href="#">Task To be Complete</a></h3>
                                                            <div>
                                                                <p>                                                                    
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="95%" style="font-family: verdana;font-size: 12px">
                                                                        <thead>
                                                                            <tr>
																				<th>Priority</th>
                                                                                <th>Project Code</th>
                                                                                <th>Project Name</th>
                                                                                <th>Start Date</th>
                                                                                <th>Project Initiator</th>
                                                                                <th>Status</th>
                                                                                <th>View</th>
                                                                                <th>Attachments</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $ColourCode = 0 ;
                                                                                $LoopCount = 0;
                                                                                $_ResultSet = get_USERProjectDetailsTask($str_dbconnect,$_strEMPCODE);
                                                                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                                    if ($ColourCode == 0 ) {
                                                                                        $Class = "even gradeA" ;
                                                                                        $ColourCode = 1 ;
                                                                                    } elseif ($ColourCode == 1 ) {
                                                                                        $Class = "odd gradeA";
                                                                                        $ColourCode = 0 ;
                                                                                    }

                                                                                    $Str_ProCode = $_myrowRes['procode'];
                                                                            ?>

                                                                                <tr  class="<?php echo $Class; ?>">
                                                                                    <!--
                                                                                    <td style="width: 10px">
                                                                                        <?php
                                                                                            echo "<input type='button' name='view' value='[+]' style='cursor:pointer; width: 20px' onclick='return showDialog(\"$Str_ProCode\")'/>";
                                                                                        ?>
                                                                                    </td>-->
																					<td width="10%">
																						
																						<select name="<?php echo $Str_ProCode; ?>" id="<?php echo $Str_ProCode; ?>" onchange="ChangePriority('<?php echo $Str_ProCode; ?>')">
																						    <option value="0" <?php if($_myrowRes['Rate'] == 0) echo "Selected='Selected'"; ?>>+3 (Highest)</option>
																						    <option value="1" <?php if($_myrowRes['Rate'] == 1) echo "Selected='Selected'"; ?>>+2 (Higher)</option>
																						    <option value="2" <?php if($_myrowRes['Rate'] == 2) echo "Selected='Selected'"; ?>>+1 (High)</option>
																						    <option value="3" <?php if($_myrowRes['Rate'] == 3) echo "Selected='Selected'"; ?>>+0 (Normal)</option>
																							<option value="4" <?php if($_myrowRes['Rate'] == 4) echo "Selected='Selected'"; ?>>-1 (Low)</option>
																						</select>																						
																						
																						<?php																							
																							echo "<label style='width:200px;color:transparent'> ".$_myrowRes["Rate"]."</label>";
																						?>
																						
																					</td>
                                                                                    <td>
                                                                                        <?php
                                                                                            echo $_myrowRes['procode'];
                                                                                            $Str_ProCode = $_myrowRes['procode'];
                                                                                        ?>
                                                                                    </td>
                                                                                    <td><?php echo $_myrowRes['proname']; ?></td>
                                                                                    <td ><?php echo $_myrowRes['startdate']; ?></td>
                                                                                    <td ><?php echo getSELECTEDEMPLOYENAME($str_dbconnect,($_myrowRes['ProInit'])); ?></td>
                                                                                    <td ><?php echo GetStatusDesc($str_dbconnect,$_myrowRes['prostatus']); ?></td>
                                                                                    <td >
                                                                                        <?php
                                                                                            echo "<input type='button' class='buttonView' name='view' value='VIEW' style='cursor:pointer; width: 70px' onclick='return View(\"$Str_ProCode\")' />";                                                                                            
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                            $_ProjectSet      = get_projectupload($str_dbconnect,$Str_ProCode) ;
                                                                                            while($_ProjectRes = mysqli_fetch_array($_ProjectSet)) {
                                                                                        ?>
                                                                                        <a href="files/<?php echo $_ProjectRes['SystemName'] ; ?>"><?php echo $_ProjectRes['SystemName'] ; ?></a><font color="Red"> | </font>  
                                                                                        <?php } ?>

                                                                                        <?php
                                                                                            $_ProjectSet      = get_projectuploadunderTask($str_dbconnect,$Str_ProCode) ;
                                                                                            while($_ProjectRes = mysqli_fetch_array($_ProjectSet)) {
                                                                                        ?>
                                                                                            <a href="files/<?php echo $_ProjectRes['SystemName'] ; ?>"><?php echo $_ProjectRes['SystemName'] ; ?></a><font color="Red"> | </font> 
                                                                                        <?php } ?>
                                                                                    </td>

                                                                                </tr>

                                                                            <?php
                                                                                $LoopCount = $LoopCount + 1;
                                                                                }
                                                                            ?>

                                                                        </tbody>

                                                                    </table>
                                                                </p>
                                                            </div>
                                                            <h3><a href="#">Pending Approval Project Completed Request</a></h3>
                                                            <div>
                                                                <p>
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2" width="95%" style="font-family: verdana;font-size: 12px">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Project Code</th>
                                                                            <th>Task Code</th>
                                                                            <th>Task Name</th>
                                                                            <th>Request By</th>
                                                                            <th>Attachments</th>
                                                                            <th>View</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $CurrentProCode =   "";
                                                                            $ColourCode = 0 ;
                                                                            $LoopCount = 0;
                                                                            $_ResultSet = get_USERApproveTaskDetails($str_dbconnect,"Task Completed",$_strEMPCODE);
                                                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                                                                if ($ColourCode == 0 ) {
                                                                                    $Class = "gradeA" ;
                                                                                    $ColourCode = 1 ;
                                                                                } elseif ($ColourCode == 1 ) {
                                                                                    $Class = "gradeA";
                                                                                    $ColourCode = 0;
                                                                                }

                                                                                $Str_taskCode = $_myrowRes['TaskCode'];
                                                                                $Str_taskID = $_myrowRes['ID'];

                                                                        ?>
                                                                                <tr style="cursor: pointer" onclick="Approve('<?php echo $Str_taskCode; ?>','<?php echo$Str_taskID; ?>')" class="<?php echo $Class; ?>">
                                                                                    <td>
                                                                                        <?php
                                                                                            echo $_myrowRes['ID'];
                                                                                            $Str_taskCode = $_myrowRes['TaskCode'];
                                                                                            $Str_taskID = $_myrowRes['ID'];
                                                                                        ?>
                                                                                    </td>
                                                                                    <td><?php echo $_myrowRes['TaskCode']; ?></td>
                                                                                    <td><?php echo get_selectedTaskNAME($str_dbconnect,$_myrowRes['TaskCode']); ?></td>
                                                                                    <td class="center"><?php echo getSELECTEDSYSUSERNAME($str_dbconnect,($_myrowRes['crtusercode'])); ?></td>
                                                                                    <td>
                                                                                    <?php   
                                                                                        $ProcodeSelected = get_selectedTaskPRONAME($str_dbconnect,$Str_taskCode);
                                                                                        $_ResultSet10      = get_projectuploadupdates($str_dbconnect,$ProcodeSelected) ;
                                                                                        while($_myrowRes10 = mysqli_fetch_array($_ResultSet10)) {                 
                                                                                            echo  "<a href='files/" . $_myrowRes10['SystemName'] ."'>" .$_myrowRes10['SystemName']."</a><font color='Red'> | </font>";
                                                                                        }

                                                                                        $_ResultSet11      = get_projectuploadupdates($str_dbconnect,$Str_taskCode) ;
                                                                                        while($_myrowRes11 = mysqli_fetch_array($_ResultSet11)) {                 
                                                                                            echo  "<a href='files/" . $_myrowRes11['SystemName'] ."'>" .$_myrowRes11['SystemName']."</a><font color='Red'> | </font>";
                                                                                        }
                                                                                     ?>
                                                                                    </td>
                                                                                    <td class='center'>
                                                                                        <?php
                                                                                            echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' />";
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $LoopCount = $LoopCount + 1;
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                    </table>
                                                                </p>
                                                            </div>
                                                            <h3><a href="#">Pending Approval Additional Hours Request</a></h3>
                                                            <div>
                                                                <p>
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1" width="95%" style="font-family: verdana;font-size: 12px">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Project Code</th>
                                                                                <th>Task Code</th>
                                                                                <th>Task Name</th>
                                                                                <th>Request By</th>
                                                                                <th>Attachments</th>
                                                                                <th>View</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $CurrentProCode =   "";
                                                                                $ColourCode = 0 ;
                                                                                $LoopCount = 0;
                                                                                $_ResultSet = get_USERApproveTaskDetails($str_dbconnect,"Addl Hrs Request", $_strEMPCODE);
                                                                                while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                                                                    if ($ColourCode == 0 ) {
                                                                                        $Class = "gradeA" ;
                                                                                        $ColourCode = 1 ;
                                                                                    } elseif ($ColourCode == 1 ) {
                                                                                        $Class = "gradeA";
                                                                                        $ColourCode = 0;
                                                                                    }

                                                                                    $Str_taskCode = $_myrowRes['TaskCode'];
                                                                                    $Str_taskID = $_myrowRes['ID'];

                                                                            ?>
                                                                                <tr style="cursor: pointer" onclick="Approve('<?php echo $Str_taskCode; ?>','<?php echo$Str_taskID; ?>')" class="<?php echo $Class; ?>">
                                                                                    <td>
                                                                                        <?php
                                                                                            echo $_myrowRes['ID'];
                                                                                            $Str_taskCode = $_myrowRes['TaskCode'];
                                                                                            $Str_taskID = $_myrowRes['ID'];
                                                                                        ?>
                                                                                    </td>
                                                                                    <td><?php echo $_myrowRes['TaskCode']; ?></td>
                                                                                    <td><?php echo get_selectedTaskNAME($str_dbconnect,$_myrowRes['TaskCode']); ?></td>
                                                                                    <td class="center"><?php echo getSELECTEDSYSUSERNAME($str_dbconnect,($_myrowRes['crtusercode'])); ?></td>
                                                                                    <td>
                                                                                    <?php   
                                                                                        $ProcodeSelected = get_selectedTaskPRONAME($str_dbconnect,$Str_taskCode);
                                                                                        $_ResultSet10      = get_projectuploadupdates($str_dbconnect,$ProcodeSelected) ;
                                                                                        while($_myrowRes10 = mysqli_fetch_array($_ResultSet10)) {                 
                                                                                            echo  "<a href='files/" . $_myrowRes10['SystemName'] ."'>" .$_myrowRes10['SystemName']."</a><font color='Red'> | </font> ";
                                                                                        }

                                                                                        $_ResultSet11      = get_projectuploadupdates($str_dbconnect,$Str_taskCode) ;
                                                                                        while($_myrowRes11 = mysqli_fetch_array($_ResultSet11)) {                 
                                                                                            echo  "<a href='files/" . $_myrowRes11['SystemName'] ."'>" .$_myrowRes11['SystemName']."</a><font color='Red'> | </font> ";
                                                                                        }
                                                                                     ?>
                                                                                    </td>
                                                                                    <td class='center'>
                                                                                        <?php
                                                                                            echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_taskCode\",\"$Str_taskID\")'/>";
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                                $LoopCount = $LoopCount + 1;
                                                                                }
                                                                            ?>
                                                                            </tbody>
                                                                    </table>
                                                                </p>
                                                            </div>
															<h3><a href="#">User W/F Task Summary</a></h3>
                                                            <div>
                                                                <p>                                                                    
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example3" width="95%" style="font-family: verdana;font-size: 12px">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Time</th>
                                                                                <th>Task Status</th>
                                                                                <th>Hrs Summary</th>
                                                                                <th>Task Description</th> 
																				<th>Comments</th>                                                                               
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $ColourCode = 0 ;
                                                                                $LoopCount = 0;
																				
																				//$LogUserCode = $_SESSION["LogEmpCode"];    
																				
																				$sortby 	= "NRM";
        																		$sortby2 	= "TME";
																				
                                                                                $_ResultSet = browseTaskWFH($str_dbconnect,$_strEMPCODE, $sortby, $sortby2);
                                                                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                                    if ($ColourCode == 0 ) {
                                                                                        $Class = "even gradeA" ;
                                                                                        $ColourCode = 1 ;
                                                                                    } elseif ($ColourCode == 1 ) {
                                                                                        $Class = "odd gradeA";
                                                                                        $ColourCode = 0 ;
                                                                                    }

                                                                                    //$Str_ProCode = $_myrowRes['procode'];
                                                                            ?>

                                                                                <tr  class="<?php echo $Class; ?>">                                                                                    
                                                                                    <td align="center">
                                                                                        <?php
                                                                                            echo date("H:i", strtotime($_myrowRes['start_time']))."-".date("H:i", strtotime($_myrowRes['end_time']));
                                                                                            //$Str_ProCode = $_myrowRes['procode'];
                                                                                        ?>
                                                                                    </td>
                                                                                    <td align="center"><?php echo $_myrowRes['status']; ?></td>
                                                                                    <td align="center"><?php echo $_myrowRes['TimeType']."-".date("H:i", strtotime($_myrowRes['TimeTaken'])); ?></td>
																					<td><?php echo $_myrowRes['wk_name']; ?></td>
																					<td><?php echo $_myrowRes['wk_update']; ?></td> 
                                                                                </tr>

                                                                            <?php
                                                                                $LoopCount = $LoopCount + 1;
                                                                                }
                                                                            ?>

                                                                        </tbody>

                                                                    </table>
                                                                </p>
                                                                
                                                            </div>
                                                    </div>
                                                </div><!-- End demo -->
                                                <br></br>
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