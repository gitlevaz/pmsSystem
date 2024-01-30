<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Project Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
include ("class/sql_crtgroups.php");        //  sql commands for the access controles
include ("class/accesscontrole.php");          //  sql commands for the access controles
include ("class\sql_empdetails.php");    

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "AccessControl";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS ACCESS DETAILS ::.</title>
    <link href="css/styleB.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="css/crtAccess.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

     <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>

    <script type="text/javascript" charset="utf-8">

       function getPageSize() {
            /*var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );
            parent.resizeIframeToFitContent(height);*/
        }


    </script>
    <script language="javascript" type="text/javascript">


		function DeleteFac(hlink){

			var Error = "False";

			if (document.getElementById("lstAccessGrant").value == "" ) {
				Error = "True" ;
				document.getElementById("lstAccessGrant").style.backgroundColor = "#ff9999" ;
			}else{
				Error = "False";
				document.getElementById("lstAccessGrant").style.backgroundColor = "" ;
			}

			if (Error == "False") {

				GRPCODE = document.getElementById('opt_Groups').value ;
				Access 	= document.getElementById('lstAccessGrant').value ;

				document.forms[0].action = "crtAccess.php?Mode=Delete&GRPCODE="+GRPCODE+"&Access="+Access+"";
				document.forms[0].submit();
			}
		}

		function SaveFac(hlink){

			var Error = "False";

			if (document.getElementById("lstAccessPoints").value == "" ) {
				Error = "True" ;
				document.getElementById("lstAccessPoints").style.backgroundColor = "#ff9999" ;
			}else{
				Error = "False";
				document.getElementById("lstAccessPoints").style.backgroundColor = "" ;
			}

			if (Error == "False") {

				GRPCODE = document.getElementById('opt_Groups').value ;
				Access 	= document.getElementById('lstAccessPoints').value ;

				document.forms[0].action = "crtAccess.php?Mode=Save&GRPCODE="+GRPCODE+"&Access="+Access+"";
				document.forms[0].submit();
			}

		}

		function ChangeTask(){

			GRPCODE = document.getElementById('opt_Groups').value ;

			document.forms[0].action = "crtAccess.php?Mode=Chg&GRPCODE="+GRPCODE+"";
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
            document.forms[0].action = "task.php?&procode="+hlink+"";
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

    <body><div id="preloader"></div>
    <?php

        $_GRPCODE 		= "";

		if(isset($_GET["Mode"]) && isset($_GET["GRPCODE"])) {

			if ($_GET["Mode"] == "Save") {
				createAccess($str_dbconnect,$_GET["GRPCODE"], $_GET["Access"] ) ;
			}

			if ($_GET["Mode"] == "Delete") {
				deleteAccess($str_dbconnect,$_GET["GRPCODE"], $_GET["Access"] ) ;
			}

		}

		#$_FAC			=	"PAO" ;


		if (isset($_GET["GRPCODE"])) {

			$_GRPCODE			=	$_GET["GRPCODE"] ;

		}

		$_GROUPSETINGS 	= getACCESSPOINTS($str_dbconnect,$_GRPCODE);
		$_ACCESSPOINTS 	= getACCESSBYGROUP($str_dbconnect,$_GRPCODE);

		if(isset($_GET["Mode"]) && isset($_GET["GRPCODE"])) {
			if ($_GET["Mode"] == "Chg") {

					$_GRPCODE			= $_GET["GRPCODE"] ;
					$_GROUPSETINGS 		= getACCESSPOINTS($str_dbconnect,$_GRPCODE);
					$_ACCESSPOINTS 		= getACCESSBYGROUP($str_dbconnect,$_GRPCODE);

			}
		}

        if(isset($_POST['btnSearch'])) {
            //header("Location:M_Reference.php");
            echo "<script>";
            echo " self.location='projectbrowse.php';";
            echo "</script>";
        }

    ?>
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
                                   <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td ><strong>Access Control</strong>
                                                     <td></td>
                                                    <td></td>
                                                     <td></td>
                                                    <td ></td>
                                                    </td>
                                                    </tr>
                                                    <tr height="25px"></tr>
                                                    <tr>
                                                    	<td></td>
                                                    <td>
                                                        User Group
                                                     </td>
                                                    <td>    
                                                        <select name="opt_Groups" id="opt_Groups" class="required ui-widget-content" onchange="ChangeTask()">                            
                                                            <?php
                                                            $_ResultSet = getGROUP($str_dbconnect) ;
                                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                            ?>
                                                            <option value="<?php echo $_myrowRes['GrpCode']; ?>"  <?php if ($_myrowRes['GrpCode'] == $_GRPCODE) echo "selected=\"selected\";" ?>  > <?php echo $_myrowRes['GrpCode'] . " - " . $_myrowRes['Group'] ; ?>
                                                            </option>
                                                            <?php } ?>
                            
                                                        </select>
                       								 </td>
                                                     <td></td>
                                                </tr> 
                                                <tr height="15px"></tr>
												<tr>
                                                    <td>
                            							Access Points
                                                         </td>
                                                    <td></td>
                                                    <td></td>
                                                     <td></td>
                                                    <td>                           
                            							Allowed Access Points
                                                    </td>
                                                </tr> 
												<tr>
                                                	<td>                       
                                                        <select name="lstAccessPoints" size="15" class="required ui-widget-content" id="lstAccessPoints" style="width:400px">
                                                            <?php
                                                            #	Get Designation details ...................
                                                            while($_myrowRes = mysqli_fetch_array($_ACCESSPOINTS)) {
                                                            ?>
                                                            <option value="<?php echo $_myrowRes['Acccode']; ?>" > <?php echo $_myrowRes['Description'];?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                    	<input name="Save" type="button" id="Save" style="width: 40px; vertical-align: 600%; cursor: pointer" value="&gt;" onclick="SaveFac('<?php echo $_GRPCODE; ?>');" />
                            							<input name="Del" type="button" id="Del" style="width: 40px; vertical-align: 600%; cursor: pointer" value="&lt;" onclick="DeleteFac('<?php echo $_GRPCODE; ?>');" />
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <select name="lstAccessGrant" size="15" class="required ui-widget-content" id="lstAccessGrant" style="width:400px">
                                <?php
                                    #	Get Designation details ...................
                                    #$_ResultSet = getUSERSBYFAC($str_dbconnect) ;
                                    while($_myrowRes = mysqli_fetch_array($_GROUPSETINGS)) {
                                ?>
                                    <option value="<?php echo $_myrowRes['AccPoint']; ?>" > <?php echo $_myrowRes['Description'];?> </option>
                                <?php } ?>
                                </select>

                        							</td>
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
                                         </tr>
                                         <tr>
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