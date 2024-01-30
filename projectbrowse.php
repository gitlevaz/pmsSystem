<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
session_start();

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization       //  connection file to the mysql database
include ("class/accesscontrole.php");           //  sql commands for the access controles
include ("class/sql_project.php");              //  sql commands for the access controles
include ("class/sql_empdetails.php");           //  connection file to the mysql database
include ("class/sql_sysusers.php");             //  sql commands for the access controls

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "CrtProject";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

    <!--    Loading Jquerry Plugin  -->
<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
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

<link href="css/styleB.css" rel="stylesheet" type="text/css" />

<script src="js/jquery.validate.js" type="text/javascript"></script>

    <script type="text/javascript" charset="utf-8">

        function getPageSize() {
            /*
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);*/
        }

        function View(hlink){           
            document.forms[0].action = "project.php?&procode="+hlink+"";
            document.forms[0].submit();
        }
		
		$(window).load(function() { 
	         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
	    });
		
		$(document).ready(function() {
	        $('#example').dataTable();
	    } );
    </script>
    
</head>
<?php
    if(isset($_POST['btnBack'])) {        
        echo "<script>";
        echo " self.location='project.php';";
        echo "</script>";
    }
?>
<body>
	<div id="preloader"></div>
	
	<form name="frm_porject" id="frm_porject" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" class="cmxform">
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
                                                <font color="#0066FF"> Browse Project Details </font> 
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>
                                    <br></br>
									<table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
										<tr>
											<td>
												<input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="     " size="5"/>
											</td>
											<td>
												<input type="submit" id="btnSearch" name="btnSearch" title="Search Project Details" class="buttonSearch" value="     " size="5" />	
											</td>
											<td>
												<input type="submit" id="btnAdd" name="btnAdd" title="Add New Project" class="buttonAdd" value="     " size="5"/>	
											</td>
											<td>
												<input type="submit" id="btnEdit" name="btnEdit" title="Edit Project" class="buttonEdit" value="     " size="10"/>	
											</td>
											<td>
												<input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Project" class="buttonDel" value="     " size="10"/>	
											</td>
											<td>
												<input type="submit" id="btnPrint" name="btnPrint" title="Print Project Details" class="buttonPrint" value="     " size="10"/>	
											</td>
										</tr>
									</table>      
									</br>                                     
                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>                                                
                                            	<input type="submit"  id="btnBack" name="btnBack" value="Go to Previous Page" onclick=""/><br><br>
												<table cellpadding="0" cellspacing="0" class="display" border="0" id="example" title="Task Update History" width="100%">
													<thead>
	                                                    <tr>
	                                                        <th>Project Code</th>
	                                                        <th>Project name</th>
	                                                        <th>Start Date</th>
															<th>Create User</th>
															<th>Status</th>
															<th></th>
	                                                    </tr>
	                                                </thead>
							                        <tbody>
							                            <?php
							                                $ColourCode = 0 ;
							                                $LoopCount = 0;
							                                $_ResultSet = get_ProjectDetails($str_dbconnect);
							                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
							                                    if ($ColourCode == 0 ) {
							                                        $Class = "gradeA" ;
							                                        $ColourCode = 1 ;
							                                    } elseif ($ColourCode == 1 ) {
							                                        $Class = "gradeA";
							                                        $ColourCode = 0 ;
							                                    }
							                            ?>
							                                <tr style="cursor: pointer" onclick="View('<?php echo $_myrowRes['procode']; ?>') " class="<?php echo $Class; ?>">
							                                    <td>
							                                        <?php
							                                            echo $_myrowRes['procode'];
							                                            $Str_ProCode = $_myrowRes['procode'];
							                                        ?>
							                                    </td>
							                                    <td><?php echo $_myrowRes['proname']; ?></td>
							                                    <td class="center"><?php echo $_myrowRes['startdate']; ?></td>
							                                    <td class="center"><?php echo getSELECTEDSYSUSERNAME($str_dbconnect,($_myrowRes['crtusercode'])); ?></td>
							                                    <td class="center"><?php echo GetStatusDesc($str_dbconnect,$_myrowRes['prostatus']); ?></td>
							                                    <td class='center'>
							                                        <?php 
							                                            echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_ProCode\")'/>";
							                                        ?>
							                                    </td>
							                                </tr>
							                            <?php
							                                $LoopCount = $LoopCount + 1;
							                                }
							                            ?>                                
							                            </tbody>
							                    </table>													    
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
