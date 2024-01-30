<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Project Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database      //  connection file to the mysql database
include ("../class/sql_crtgroups.php");        //  sql commands for the access controles
include ("../class/accesscontrole.php");          //  sql commands for the access controles
include ("../class/sql_empdetails.php");    

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "../";
$Menue	= "WorkFlowEmailBccGroup";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: WORKFLOW EMAIL ALERT GROUP DETAILS ::.</title>
    <link href="../css/styleB.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="../css/crtAccess.css" type="text/css" />
    <link rel="stylesheet" href="../css/slider.css" type="text/css" />
    <link href="../css/textstyles.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" language="javascript" src="../js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="../css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

     <script src="../jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="../jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="../jQuerry/development-bundle/ui/jquery.ui.button.js"></script>

    <script type="text/javascript" charset="utf-8">

       function getPageSize() { 
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

				document.forms[0].action = "WorkFlowEmailBccGroup.php?Mode=Delete&GRPCODE="+GRPCODE+"&Access="+Access+"";
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

				document.forms[0].action = "WorkFlowEmailBccGroup.php?Mode=Save&GRPCODE="+GRPCODE+"&Access="+Access+"";
				document.forms[0].submit();
			}

		}

		function ChangeTask(){

			EmpCODE = document.getElementById('opt_Groups').value ;

			document.forms[0].action = "WorkFlowEmailBccGroup.php?Mode=Chg&GRPCODE="+EmpCODE+"";
			document.forms[0].submit();

		}

	</script>
     <script type="text/javascript" charset="utf-8">

        
		
		$(window).load(function() { 
	         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
	    });
		
		 
    </script>
</head>

    <body><div id="preloader"></div>
    <?php

       
		$_Category		= "WORKFLOW";
		$_LoggedEmpCode	= $_SESSION["LogEmpCode"];
		
		$_GROUPSETINGS 	= getBccEmployees($str_dbconnect,$_GET["GRPCODE"],$_Category);
		$_ACCESSPOINTS 	= getAllEmployeesforEmailBcc($str_dbconnect,$_GET["GRPCODE"],$_Category);

		if(isset($_GET["Mode"]) && isset($_GET["GRPCODE"])) {
			if ($_GET["Mode"] == "Save") {
				createEmailBcc($str_dbconnect,$_GET["GRPCODE"], $_GET["Access"],$_Category,$_LoggedEmpCode) ;
				$_GROUPSETINGS 	= getBccEmployees($str_dbconnect,$_GET["GRPCODE"],$_Category);
				$_ACCESSPOINTS 	= getAllEmployeesforEmailBcc($str_dbconnect,$_GET["GRPCODE"],$_Category);

			}
			if ($_GET["Mode"] == "Delete") {
				deleteEmailBcc($str_dbconnect,$_GET["GRPCODE"], $_GET["Access"],$_Category,$_LoggedEmpCode) ;
				$_GROUPSETINGS 	= getBccEmployees($str_dbconnect,$_GET["GRPCODE"],$_Category);
				$_ACCESSPOINTS 	= getAllEmployeesforEmailBcc($str_dbconnect,$_GET["GRPCODE"],$_Category);

			}
		}

	 
		if (isset($_GET["GRPCODE"])) {
			$_GRPCODE			=	$_GET["GRPCODE"] ;
		}

		

		if(isset($_GET["Mode"]) && isset($_GET["GRPCODE"])) {		
			if ($_GET["Mode"] == "Chg") {
					$_GRPCODE			= $_GET["GRPCODE"] ;
					$_GROUPSETINGS 		= getBccEmployees($str_dbconnect,$_GRPCODE,$_Category);
					$_ACCESSPOINTS 		= getAllEmployeesforEmailBcc($str_dbconnect,$_GRPCODE,$_Category);
			}
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
                                   <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td ><strong>WORKFLOW Email Alert Group</strong>
                                                     <td></td>
                                                    <td></td>
                                                     <td></td>
                                                    <td ></td>
                                                    </td>
                                                    </tr>
                                                    <tr height="25px"></tr>
                                                    <tr>
                                                    	<td align="right">Select the WorkFlow Owner</td>
                                                    <td>
                                                        
                                                     </td>
                                                    <td>    
                                                        <select name="opt_Groups" id="opt_Groups" class="required ui-widget-content" onchange="ChangeTask()">                            
                                                            <?php
                                                            $_ResultSet =getEMPLOYEEDETAILS($str_dbconnect) ;
                                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                            ?>
                                                            <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_GRPCODE) echo "selected=\"selected\";" ?>  > <?php echo $_myrowRes['FirstName'] . "   " . $_myrowRes['LastName'] ; ?>
                                                            </option>
                                                            <?php } ?>
                            
                                                        </select>
                       								 </td>
                                                     <td></td>
                                                </tr> 
                                                <tr height="15px"></tr>
												<tr>
                                                    <td>
                            							Select the e-mail recipients
                                                         </td>
                                                    <td></td>
                                                    <td></td>
                                                     <td></td>
                                                    <td>                           
                            							Selected Employees
                                                    </td>
                                                </tr> 
												<tr>
                                                	<td>                       
                                                        <select name="lstAccessPoints" size="15" class="required ui-widget-content" id="lstAccessPoints" style="width:400px">
                                                            <?php
                                                            #	Get Designation details ...................
                                                            while($_myrowRes = mysqli_fetch_array($_ACCESSPOINTS)) {
                                                            ?>
                                                            <option value="<?php echo $_myrowRes['EmpCode']; ?>"><?php echo $_myrowRes['FirstName']. "   " .$_myrowRes['LastName'] ; ?>
                                                            </option>                                                            
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                    <td align="center">
                                                    	<input name="Save" type="button" class="buttonView" id="Save" style="cursor: pointer" value="Save  >  " onclick="SaveFac('<?php echo $_GRPCODE; ?>');" /><br/><br/><br/>
                            							<input name="Del" type="button" class="buttonView" id="Del" style="cursor: pointer" value="< Remove  " onclick="DeleteFac('<?php echo $_GRPCODE; ?>');" />
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <select name="lstAccessGrant" size="15" class="required ui-widget-content" id="lstAccessGrant" style="width:400px">
                                <?php
                                    #	Get Designation details ...................
                                    #$_ResultSet = getUSERSBYFAC($str_dbconnect) ;
                                    while($_myrowRes = mysqli_fetch_array($_GROUPSETINGS)) {
                                ?>
                                    <option value="<?php echo $_myrowRes['EmpCode']; ?>"><?php echo $_myrowRes['FirstName']. "   " .$_myrowRes['LastName'] ; ?>
                                                            </option>   
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
                                                <?php include ('../footer.php') ?>
                                            </div >
                                          </td>
                                         </tr>
                                        </table>
                                         
                                                  
                </form>
            </div>
</body>
</html>