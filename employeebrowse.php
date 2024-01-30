<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
session_start();

include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\accesscontrole.php");       //  sql commands for the access controles
include ("class\sql_empdetails.php");       //  sql commands for the access controles

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "Employee";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS EMPLOYEE SEARCH DETAILS ::.</title>
    <link href="css/styleB.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="css/project.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />


    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

     <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>


    <style type="text/css" title="currentStyle">
            @import "media/css/demo_page.css";
            @import "media/css/demo_table.css";
    </style>
    <script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#example').dataTable();
        } );

        function getPageSize() {
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);
        }

        function View(hlink){           
            document.forms[0].action = "Employee.php?&empcode="+hlink+"";
            document.forms[0].submit();
        }
    </script>
     <script type="text/javascript" charset="utf-8">

        function getPageSize() {/*
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);*/
        }

        function View(hlink){           
            document.forms[0].action = "Employee.php?&empcode="+hlink+"";
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
        echo " self.location='Employee.php';";
        echo "</script>";
    }
?>
<body><div id="preloader"></div>
    <div id="container">

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
                                    <br></br>  
									<table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
										<tr>
											<td>             
                        						<input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack" onclick=""/>
                                            </td>
											</tr>
									</table>                                   
                                    <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td width="20%"><strong>Employee Details</strong>
                                                    </td>
                                                    </tr>
                                                    <tr>                        
                                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" onmousemove ="getPageSize();">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee Code</th>
                                                                    <th>Employee Name</th>
                                                                    <th>Designation</th>
                                                                    <th>E-Mail</th>
                                                                    <th>S</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $ColourCode = 0 ;
                                                                    $LoopCount = 0;
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                        if ($ColourCode == 0 ) {
                                                                            $Class = "even gradeC" ;
                                                                            $ColourCode = 1 ;
                                                                        } elseif ($ColourCode == 1 ) {
                                                                            $Class = "odd gradeC";
                                                                            $ColourCode = 0 ;
                                                                        }
                                                                ?>
                                                                    <tr class="<?php echo $Class; ?>">
                                                                        <td>
                                                                            <?php
                                                                                echo $_myrowRes['EmpCode'];
                                                                                $Str_EmpCode = $_myrowRes['EmpCode'];
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName']; ?></td>
                                                                        <td class="left"><?php echo getSELECTEDDESIGNATIONNAME($str_dbconnect,$_myrowRes['DesCode']); ?></td>
                                                                        <td class="left"><?php echo $_myrowRes['EMail']; ?></td>
                                                                        <td class='center'>
                                                                            <?php 
                                                                                echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_EmpCode\")'/>";
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                    $LoopCount = $LoopCount + 1;
                                                                    }
                                                                ?>                                
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>Employee Code</th>
                                                                        <th>Employee Name</th>
                                                                        <th>Designation</th>
                                                                        <th>E-Mail</th>
                                                                        <th>S</th>
                                                                    </tr>
                                                                </tfoot>
                                                        </table>
                                                       </tr>
                                                      </td>
                                                     </tr>
                                                    </table>
                                                   </div>
                                                  </td>
                                                 </tr>
                                                </table>
                                               </div>
                                              </td>
                                              <td colspan="2" style="width: 100%">
                                                    <div id="footer">
                                                        <?php include ('footer.php') ?>
                                                    </div >
                                                </td>
                                             </tr>
                                            </table>
                  
                </form>
            </div>

</body>
</html>
