<?php
session_start();
if (time() - $_SESSION["login_time_stamp"] > 86400) {
    session_unset();
    session_destroy();
    header("Location:index.php");
  }

if(!isset($_SESSION["LogUserName"]) || !isset($_SESSION["CompCode"])){
    echo "<script type='text/javascript'>";
    echo "self.SessionLost();"; 
    echo "</script>";
}
include ("connection/sqlconnection.php");    //  connection file to the mysql database
include ("class/accesscontrole.php");       //  sql commands for the access controles
include ("class/sql_empdetails.php");        //  connection file to the mysql database
//include ("class/sql_getupdateTaskMain.php");
include ("class/sql_project.php");          //  sql commands for the access controles
include ("class/sql_sysusers.php");          //  sql commands for the access controls
include ("class/sql_task.php");             //  sql commands for the access controles
 
          //  connection file to the mysql database
//  connecting the mysql database
mysqli_select_db($str_dbconnect,"$str_Database") or die ("Unable to establish connection to the MySql database");

$path = "";
$Menue	= "Home";
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

<!--<script type="text/javascript" src="jQuerry/jRating.jquery.js"></script>-->
<link rel="stylesheet" href="Rating/jRating.jquery.css" type="text/css" />

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
<style type="text/css">
		/* preloader DIV-Styles*/
		#preloader { 
			display:none; /* Hide the DIV */
			position:fixed;  
			_position:absolute; /* hack for internet explorer 6 */  
			height:330px;  
			width:600px;  
			background:#FFFFFF;  
			left: 400px;
			top: 130px;
			z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
			margin-left: 15px;  
			
			/* additional features, can be omitted */
			border:2px solid #06F;      
			padding:15px;  
			font-size:15px;  
			-moz-box-shadow: 0 0 5px #ff0000;
			-webkit-box-shadow: 0 0 5px #ff0000;
			box-shadow: 0 0 5px #ff0000;
			
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
	/*body {margin:15px;font-family:Arial;font-size:13px}*/
	a img{border:0}
	.datasSent, .serverResponse{margin-top:20px;width:470px;height:73px;border:1px solid #F0F0F0;background-color:#F8F8F8;padding:10px;float:left;margin-right:10px}
	.datasSent{width:200px;position:fixed;left:680px;top:0}
	.serverResponse{position:fixed;left:680px;top:100px}
	.datasSent p, .serverResponse p {font-style:italic;font-size:12px}
	.exemple{margin-top:15px;}
	.clr{clear:both}
	pre {margin:0;padding:0}
	/*.notice {background-color:#F4F4F4;color:#666;border:1px solid #CECECE;padding:10px;font-weight:bold;width:600px;font-size:12px;margin-top:10px}*/
</style>

<!-- JRating -->
<script type="text/javascript" src="JqueryRating/jquery.rating.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="JqueryRating/jquery.rating.css" />

    
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
        sOut += "<tr><td><center><iframe width='800px' style='border: none;' src='MaintaskbrowseDig.php?&procode="+aData[3]+"'></center> </td></tr>";
        sOut += "</table>";
        return sOut;
    }

    $(document).ready(function() {
	
		/*$('.basic').jRating();*/
		
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
        $('#example2').dataTable(
		{	iDisplayLength: 25,		
          	bProcessing: true, 
			sPaginationType: "full_numbers",         	
			aLengthMenu: [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]]	
		});
    } );
	
	$(document).ready(function() {
        $('#example3').dataTable();
    } );
    
    $(window).load(function() { 
         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
    }); 
	
	
		    
</script>

<script type="text/javascript">
    function View(hlink){           
        document.forms[0].action = "Maintaskbrowse.php?&procode="+hlink+"";
        document.forms[0].submit();
    }

    function Approve(hlink,hlinkID ){        
        document.forms[0].action = "ApproveTask.php?&taskcode="+hlink+"&taskid="+hlinkID+"&Page=Main";
        document.forms[0].submit();
    }

    function toggle() {
         if( document.getElementById("hidethis").style.display=='none' ){
           document.getElementById("hidethis").style.display = '';
         }else{
           document.getElementById("hidethis").style.display = 'none';
         }
    }
	
	function ChangePriority(hlink){     
		//alert(hlink);      
        document.forms[0].action = "Home.php?ChgCode="+hlink+"";
        document.forms[0].submit();
    }
	
	function rate(hlink){     
		alert(hlink);      
        document.forms[0].action = "Home.php?Rate="+hlink+"";
        document.forms[0].submit();
    }
	
		
	$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		/*$( "#dialog:ui-dialog" ).dialog( "close" );*/
	
		$( "#dialog-modal" ).dialog({
			height: 400,
			modal: true,
			autoOpen: false
		});
	});
	
	function ShowAttachments(target){	
		//alert(target);	
		url = 'Attachements.php?procode=' + target;
		newwindow=window.open( url ,'name','height=400,width=400');
		if (window.focus) {newwindow.focus()}
		return false;	
	}
    
	 function closeimpediment(task,emp,todaydate,loguser){  
			var answer = confirm("Do you want to Close Task ID : " + task)
			if (answer){
					$.post('class/sql_getupdateTaskMain.php',{taskdata : task , empdata : emp, todaydata : todaydate , loguserdata : loguser},			
						function(output){ 						                 
						   if(output==1){
							   document.forms['frm_Home'].submit();
						   }
						   else{
							   alert("Could Not Close");
						   }
						}
            		)   				 
	         }
			else{
				alert("Action Cancelled");
			}		
        }
    
</script>
<script type="text/javascript">
    
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
            $("#container").css({ // this is just for style        
                "opacity": "1"  
            });			
			 document.forms['frm_Home'].submit();
        }    
        
        function loadPopupBox() {    // To Load the Popupbox
            $('#preloader').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "0.3"  
            });         
        }   
	
	function updateimpediment(task,emp,todaydate){
		
			loadPopupBox();				
			$('#EditImpediment').attr('src', 'updateImpedimentReason.php?taskid='+task+'&empcode='+emp+'&today='+todaydate+'')
	}
	function closeimpediment(task,emp,todaydate){
		
			loadPopupBox();
			var sta = "Close";				
			$('#EditImpediment').attr('src', 'updateImpedimentReason.php?taskid='+task+'&empcode='+emp+'&today='+todaydate+'&stt='+sta+'')
	}
</script>   

</head>
<body>
<div id="preloader"></div>

       <div id="preloader">    <!-- OUR PopupBox DIV-->
            <iframe id="EditImpediment" width="600px"  height="475px" frameborder="0" scrolling="no"></iframe>
            <a id="popupBoxClose">Close(X)</a>    
        </div>
<form name="frm_Home" id="frm_Home" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	
	<?php	
		//	Running Project Priority Assignment
		SetupProOrderSequence($str_dbconnect);
		
		if(isset($_GET["ChgCode"]) && $_GET["ChgCode"] != "" ){
			$ChngeProject	= 	$_GET["ChgCode"];	
			$Priority		=	$_POST["$ChngeProject"];
			
			ChangeProjectPriority($str_dbconnect,$ChngeProject, $Priority);	
			
		}		
		
		if(isset($_GET["Rate"]) && $_GET["Rate"] != "" ){
			
			//echo $_GET["Rate"];
			
			$ChngeProject	=	$_GET["Rate"];		
			$Chngerate		= 	"P".$_GET["Rate"];	
			$Priority		=	$_POST["$Chngerate"];
			
			ChangeRate($str_dbconnect,$ChngeProject, $Priority);	
			//echo $ChngeProject." - ".$Chngerate." - ".$Priority;
		}
	?>
	
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
                                                <font color="#0066FF"> Welcome, </font> <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]) ?>                                                													
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>
                                    <br></br>
                                    <table width="80%" cellpadding="0" cellspacing="0" border="1px" style="border-color: #0066FF; border-width: 1px" align="center">
                                        <tr style="height: 50px;">
                                            <td style="padding-left: 10px;position: relative" align="left">
                                                <div style="width: 400px;position: absolute;top: 20px; left: 20px"><font color="#0066FF">Last Login : </font>No Data</div>
                                                <div style="width: 400px;position: absolute;top: 20px; left: 405px"><font color="#0066FF">Comments : </font>You have no New Comments</div> 
                                            </td>
											<!--<td>
												<div class="datasSent">
													Datas sent to the server :
													<p></p>
												</div>
												<div class="serverResponse">
													Server response :
													<p></p>
												</div>
											</td>-->
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
                                                                                    
                                                                                    $Total_Task = get_NoOfTaskforEmp($str_dbconnect,$_SESSION["LogEmpCode"]);
                                                                                    $Task_Completed = get_NoOfTaskforEmpTC($str_dbconnect,$_SESSION["LogEmpCode"]);
                                                                                    $TaskInProgress =  get_NoOfTaskforEmpTI($str_dbconnect,$_SESSION["LogEmpCode"]);
                                                                                    $TaskPendApproval =   get_NoOfTaskforEmpCW($str_dbconnect,$_SESSION["LogEmpCode"]);
                                                                                    $TaskNotStarted =   get_NoOfTaskforEmpTN($str_dbconnect,$_SESSION["LogEmpCode"]);
																					
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
																					
																					date_default_timezone_set($timezone);
																			           
																			        $today_date  = date("Y-m-d");
																						
                                                                                    $Total_WF = "0";
                                                                                    $WF_Yes = "0";
                                                                                    $WF_No = "0";
                                                                                    $WF_NA = "0";                                                                                    
                                                                                    
                                                                                    $Total_WF 	= get_NoOfTaskforWF($str_dbconnect,$_SESSION["LogEmpCode"],$today_date);
                                                                                    $WF_Yes 	= get_NoOfTaskforWFYES($str_dbconnect,$_SESSION["LogEmpCode"],$today_date);
                                                                                    $WF_No 		= get_NoOfTaskforWFNO($str_dbconnect,$_SESSION["LogEmpCode"],$today_date);
                                                                                    $WF_NA 		= get_NoOfTaskforWFNA($str_dbconnect,$_SESSION["LogEmpCode"],$today_date);                                                                                    
																					
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
																	<center>
																	<h4>Legend Of Priority Assigned</h4>
																	<table cellpadding="0" cellspacing="0" border="0" width="50%" title="Legend">
																		<tr style="height:20px">
																			<td style="background-color:#ffd5d5">
																				+3 (Highest)	
																			</td>
																			<td style="background-color:#d5e8ff">
																				+2 (Higher
																			</td>
																			<td style="background-color:#d5ffd5">
																				+1 (High)	
																			</td>
																			<td style="background-color:#ffffd5">
																				+0 (Normal)	
																			</td>
																			<td style="background-color:#ffe6d5">
																				-1 (Low)	
																			</td>		
																		</tr>
																	</table>   
																	</center>
																	</br>     
                                                    
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="95%" style="font-family: verdana;font-size: 12px">
                                                                        <thead>
                                                                            <tr>
																				<th width="10%">Rating</th>
																				<th width="10%">Priority</th>																			
                                                                                <th>Project Code</th>
																				<th>Project Name</th>
                                                                                <th>Economic Value</th>
                                                                                <th>Time Spend</th>
                                                                                <th>Category</th>
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
                                                                                $_ResultSet = get_ProjectDetailsTask($str_dbconnect);
                                                                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                                    if ($ColourCode == 0 ) {
                                                                                        $Class = "even gradeA";
                                                                                        $ColourCode = 1 ;
                                                                                    } elseif ($ColourCode == 1 ) {
                                                                                        $Class = "odd gradeA";
                                                                                        $ColourCode = 0;
                                                                                    }

                                                                                    $Str_ProCode = $_myrowRes['procode'];
																					
																					$rater_id = 1;
																					
																					if($_myrowRes['Rate'] == "0"){
																						$Colour = "style='background-color:#ffd5d5'";
																					}else if($_myrowRes['Rate'] == "1"){
																						$Colour = "style='background-color:#d5e8ff'";
																					}else if($_myrowRes['Rate'] == "2"){
																						$Colour = "style='background-color:#d5ffd5'";
																					}else if($_myrowRes['Rate'] == "3"){
																						$Colour = "style='background-color:#ffffd5'";
																					}else{
																						$Colour = "style='background-color:#ffe6d5'";
																					}																					
                                                                            ?>

                                                                                <tr class="<?php echo $Class; ?>" <?php echo $Colour; ?>>
                                                                                    <!--
                                                                                    <td style="width: 10px">
                                                                                        <?php
                                                                                            echo "<input type='button' name='view' value='[+]' style='cursor:pointer; width: 20px' onclick='return showDialog(\"$Str_ProCode\")'/>";
                                                                                        ?>
                                                                                    </td>-->
																					<td width="10%" align="center">
																						<?php	
																							$_PriorityNumber = getOrderByNumber($str_dbconnect,$Str_ProCode);
																							if($_PriorityNumber < 10){
																								$_PrintOrder = "0".$_PriorityNumber;
																							}else{
																								$_PrintOrder = $_PriorityNumber;																								
																							}
																						?>
																						<input type="text" id="P<?php echo $Str_ProCode; ?>" name="P<?php echo $Str_ProCode; ?>" style="width:20px;" ondblclick="rate('<?php echo $Str_ProCode; ?>')" value="<?php echo getOrderByNumber($str_dbconnect,$Str_ProCode); ?>"/>
																						<?php																																	
																							echo "<label style='width:200px;color:transparent'>".$_PrintOrder."</label>";
																						?>
																					</td>
																					
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
                                                                                    <td><?php echo $_myrowRes['economic_value']; ?></td>
                                                                                    <td><?php echo $_myrowRes['timepicker_start']; ?></td>
                                                                                    <td><?php echo $_myrowRes['proCat']; ?></td>
                                                                                    <td ><?php echo date_create($_myrowRes['startdate'])->diff(date_create($_myrowRes['enddate']))->format('%H:%i:%s'); ?></td>
                                                                                    <td ><?php echo getSELECTEDEMPLOYENAME($str_dbconnect,($_myrowRes['ProInit'])); ?></td>
                                                                                    <td ><?php echo GetProStatusDef($str_dbconnect,$Str_ProCode, $_myrowRes['prostatus']); ?></td>
                                                                                    <td >
                                                                                        <?php
                                                                                            echo "<input type='button' class='buttonView' name='view' value='VIEW' style='cursor:pointer; width: 70px' onclick='return View(\"$Str_ProCode\")' />";                                                                                            
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
																							
																							$ProDocCount = 0;
																							
                                                                                            $_ProjectSet      = get_projectupload($str_dbconnect,$Str_ProCode) ;
                                                                                            while($_ProjectRes = mysqli_fetch_array($_ProjectSet)) {
																							
																							$ProDocCount = $ProDocCount + 1;
																								
																								if($ProDocCount < 3){																									
																							
                                                                                        ?>
                                                                                        <a href="files/<?php echo $_ProjectRes['SystemName'] ; ?>"><?php echo $_ProjectRes['SystemName'] ; ?></a><font color="Red"> | </font>  
                                                                                        <?php 
																								}																								 																						
																							} 
																						?>

                                                                                        <?php																							
                                                                                            $_ProjectSet      = get_projectuploadunderTask($str_dbconnect,$Str_ProCode) ;
                                                                                            while($_ProjectRes = mysqli_fetch_array($_ProjectSet)) {
																							
																								$ProDocCount = $ProDocCount + 1;
																								
																								if($ProDocCount < 3){
                                                                                        ?>
																							
																							
                                                                                            <a href="files/<?php echo $_ProjectRes['SystemName'] ; ?>"><?php echo $_ProjectRes['SystemName'] ; ?></a><font color="Red"> | </font> 
                                                                                        <?php
																							}																							
																								
																						 } 
																						 
																						 if($ProDocCount > 3){																						 
																						 ?>
																						 
																						 <label id="<?php echo $Str_ProCode; ?>" style="cursor:pointer" onclick="return  ShowAttachments('<?php echo $Str_ProCode; ?>');"><font color="blue"><u>View More</u></font></label> 
																						 																							
																						<?php																							
																							
																						 }
																						 
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
                                                            <h3><a href="#">Pending Approval Project Completed Request</a></h3>
                                                            <div>
                                                                <p>
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2" width="95%" style="font-family: verdana;font-size: 12px">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Project Code</th>
                                                                            <th>Task Code</th>
                                                                            <th>Task Owner</th>
                                                                            <th>Task Name</th>
                                                                            <th >Task Completed</th>
                                                                            <th >Requested By</th>
                                                                            <th>Attachments</th>
                                                                            <th>View</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $CurrentProCode = "";
                                                                            $ColourCode = 0;
                                                                            $LoopCount = 0;
                                                                            $_ResultSet = get_ApproveTaskDetails($str_dbconnect,"Task Completed");
                                                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                                                                if ($ColourCode == 0 ) {
                                                                                    $Class = "gradeA";
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
                                                                                    <td><?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_myrowRes['ProOwner']);?></td>
                                                                                    <td><?php echo get_selectedTaskNAME($str_dbconnect,$_myrowRes['TaskCode']); ?></td>
                                                                                    <td><?php echo getUpdatedate($str_dbconnect,($_myrowRes['TaskCode'])); ?></td>
                                                                                    <td><?php echo getRequestedBy($str_dbconnect,($_myrowRes['TaskCode'])); ?></td>
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
                                                                                $_ResultSet = get_ApproveTaskDetails($str_dbconnect,"Addl Hrs Request");
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
																				
																				$LogUserCode = $_SESSION["LogEmpCode"];    
																				
																				$sortby 	= "NRM";
        																		$sortby2 	= "TME";
																				
                                                                                $_ResultSet = browseTaskWFH($str_dbconnect,$LogUserCode, $sortby, $sortby2);
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
                                                             <h3><a href="#">Impediment Alerts</a></h3>
                                                            <div id="updateImp">
                                                                <p>
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2" width="1000px" style="font-family: verdana;font-size: 12px">
                                                                    <thead width="1000px" align="left">
                                                                        <tr align="left">
                                                                            <th width="100px">Create Date</th>
                                                                            <th width="100px">Task Code</th>
                                                                            <th width="300px">Task Name</th>
                                                                            <th width="200px">From</th>
                                                                             <th width="200px">Impedimented By</th>
                                                                            <th width="100px">Update</th>
                                                                            <th width="100px">Close</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody width="1000px" align="left">
                                                                        <?php
                                                                            $CurrentProCode = "";
                                                                            $ColourCode = 0;
                                                                            $LoopCount = 0;
																			$LogUserCode = $_SESSION["LogEmpCode"]; 
                                                                            $_ResultSet = get_impedimentDetails($str_dbconnect,$LogUserCode);
                                                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                                                                if ($ColourCode == 0 ) {
                                                                                    $Class = "gradeA";
                                                                                    $ColourCode = 1 ;
                                                                                } elseif ($ColourCode == 1 ) {
                                                                                    $Class = "gradeA";
                                                                                    $ColourCode = 0;
                                                                                }
																				$Str_taskCode = $_myrowRes['TaskCode'];
                                                                               ?>
                                                                                <tr style="cursor: pointer" align="left">
                                                                                    <td width="100px">
                                                                                        <?php
                                                                                            echo $_myrowRes['create_date'];
                                                                                            $Str_taskCode = $_myrowRes['TaskCode'];        
                                                                                        ?>
                                                                                    </td>
                                                                                    <td width="100px"><?php echo $_myrowRes['TaskCode']; ?></td>
                                                                                    <td width="300px"><?php echo get_selectedTaskNAME($str_dbconnect,$_myrowRes['TaskCode']); ?></td>                                                               <td width="200px">
                                                                                    <?php   
																						$emp = $_myrowRes['created_by'];
                                                                                        echo getSELECTEDEMPLOYENAME($str_dbconnect,$emp);        
                                                                                     ?>
                                                                                    </td>
                                                                                    <td width="200px">
                                                                                    <?php   
																						$by = $_myrowRes['UserName'];
                                                                                        echo $by;        
                                                                                     ?>
                                                                                    </td>                                                                                    
                                                                                    <td  align="left" width="100px">
                                                                                    	<?php $Str_taskCode = $_myrowRes['TaskCode'];
																						$EmpCode = $_myrowRes['EmpCode'];
																						$Dte_StartDate  = date("Y-m-d");
																						$LogUserCode = $_SESSION["LogEmpCode"]; 
																						$crtby = $_myrowRes['created_by']; 
																						if($LogUserCode!=$crtby){?>
                                                                                       <input type="button" id="updateimp" name="updateimp" value="Update" onClick="updateimpediment('<?php echo $Str_taskCode;?>','<?php echo $EmpCode;?>','<?php echo $Dte_StartDate; ?>')"><?php }?>
                                                                                    </td>
                                                                                    <td  align="left" width="100px">
                                                                                    	<?php $Str_taskCode = $_myrowRes['TaskCode'];
																						$EmpCode = $_myrowRes['EmpCode'];
																						$Dte_StartDate  = date("Y-m-d");
																						$LogUserCode = $_SESSION["LogEmpCode"]; 
																						$crtby = $_myrowRes['created_by']; 
																						if($LogUserCode!=$crtby){?>
                                                                                       <input type="button" id="closeimp" name="closeimp" value="Close" onClick="closeimpediment('<?php echo $Str_taskCode;?>','<?php echo $EmpCode;?>','<?php echo $Dte_StartDate; ?>')"><?php }?>
                                                                                            
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
	<script type="text/javascript" src="Rating/jRating.jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.basic').jRating();
			
			$('.exemple2').jRating({
				type:'small',
				length : 40,
				decimalLength : 1
			});
			
			$('.exemple3').jRating({
				step:true,
				length : 20
			});
			
			$('.exemple4').jRating({
				isDisabled : true
			});
			
			$('.exemple5').jRating({
				length:10,
				decimalLength:1,
				onSuccess : function(){
					alert('Success : your rate has been saved :)');
				},
				onError : function(){
					alert('Error : please retry');
				}
			});
			
			$(".exemple6").jRating({
			  length:10,
			  decimalLength:1,
			  showRateInfo:false
			});
		});
	</script>
</body>
</html>