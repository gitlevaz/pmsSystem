<?php

	session_start();
	

	
	# File Name 	: UserFacility.php
	# Type			: PHP&MySQL
	# Date Create	: 16-08-2009
	# Last Modified	: 16-08-2009
	# Modified User : P.H.S.Prajapriya
	# IITS - Impact IT Solutions

	//	Open the Session for the page.......
	//session_start ();
	
	//	Inserting the PHP Pages call from out-side......
	
	include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
    include ("class/sql_project.php");          //  sql commands for the access controles
    include ("class/sql_task.php");             //  sql commands for the access controles
    include ("class/accesscontrole.php");       //  sql commands for the access controles
    include ("class/sql_empdetails.php");   //  connection file to the mysql database
	
	mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "Teams";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/styleB.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />
    <link href="css/task.css" rel="stylesheet" type="text/css" />
<title>,:PMS:. | Employee Designations</title>

    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
   <!-- <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

     <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.TableHeadings {
	font-size: 14px;
	font-weight: 500;
	font-family: Arial, Helvetica, sans-serif;
	color: #003399;
}
.MenueNameFont {
	font-family: "Century Gothic";
	color: #000099;
	font-size: 18px;
	font-style: normal;
	font-weight: bold;
	font-variant: normal;
	line-height: normal;
}
.style3 {
	font-size: 14px;
	font-weight: bold;
	color: #003399;
}
-->
</style>
<script language="javascript" type="text/javascript">
			
		
		function DeleteFac(hlink){		
			
			var Error = "False";
			
			if (document.getElementById("lstFacUsers").value == "" ) {		
				Error = "True" ;		
				document.getElementById("lstFacUsers").style.backgroundColor = "#ff9999" ;	
			}else{
				Error = "False";
				document.getElementById("lstFacUsers").style.backgroundColor = "" ;		
			}
			
			if (Error == "False") {
			
				FacCode = document.getElementById('optFacilities').value ;
				User 	= document.getElementById('lstFacUsers').value ;	
							
				document.forms[0].action = "UserFacility.php?Mode=Delete&FacCode="+FacCode+"&User="+User+"";
				document.forms[0].submit();
			}
		}
		
		function SaveFac(hlink){
		
			var Error = "False";
			
			if (document.getElementById("lstSysUsers").value == "" ) {		
				Error = "True" ;		
				document.getElementById("lstSysUsers").style.backgroundColor = "#ff9999" ;	
			}else{
				Error = "False";
				document.getElementById("lstSysUsers").style.backgroundColor = "" ;		
			}
			
			if (Error == "False") {						
				FacCode = document.getElementById('optFacilities').value ;
				User 	= document.getElementById('lstSysUsers').value ;			
				
				document.forms[0].action = "UserFacility.php?Mode=Save&FacCode="+FacCode+"&User="+User+"";
				document.forms[0].submit();
			}
			
		}
		
		function Selection(){	
		
			FacCode = document.getElementById('optFacilities').value ;
			document.forms[0].action = "UserFacility.php?Mode=Chg&FacCode="+FacCode+"";
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

    
    <div class="Div-SysUserFacBG">
<?php	
	
		if(isset($_GET["Mode"]) && isset($_GET["FacCode"])) { 
					
			if ($_GET["Mode"] == "Save") {				
				createFacility($str_dbconnect,$_GET["FacCode"], $_GET["User"] ) ;					
			}		
			
			if ($_GET["Mode"] == "Delete") {				
				deleteFacility($str_dbconnect,$_GET["FacCode"], $_GET["User"] ) ;					
			}		
					
		}
		
		$_FAC			=	"EMP/1" ;
		
		if (isset($_GET["FacCode"])) {
		
			$_FAC			=	$_GET["FacCode"] ;
		
		}
		
		$_FacilityUSERS = getUSERFACILITIES($str_dbconnect,$_FAC);					
		$_FacilitySet 	= getUSERSBYFAC($str_dbconnect,$_FAC);
		
		if(isset($_GET["Mode"]) && isset($_GET["FacCode"])) { 
			if ($_GET["Mode"] == "Chg") {	
				
					$_FAC			= $_GET["FacCode"] ;			
					$_FacilityUSERS = getUSERFACILITIES($str_dbconnect,$_FAC);				
					$_FacilitySet 	= getUSERSBYFAC($str_dbconnect,$_FAC);								
					
			}
		}
	?>
<form name="Designation" id="Designation" method="post" class="cmxform">

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
									                              
                                    <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td width="20%"><strong>Create Teams</strong>
                                                    </td>
                                                    </tr>
                                                    <tr> 
                                                        <table width="565" border="0" align="center" cellpadding="1" cellspacing="1" class="required ui-widget-content">
                                                          <tr>
                                                            <td width="234" height="65" ><div align="left"></div></td>
                                                            <td width="50">&nbsp;</td>
                                                            <td colspan="2"><div align="left"></div></td>
                                                            <td width="16">&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td ><div align="right">TEAM LEADER</div></td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="2">
                                                                <div align="left">
                                                                <select id="optFacilities" name="optFacilities" class="required ui-widget-content" onchange="Selection();">
                                                                    <?php
                                                                        #	Get Designation details ...................
                                                                        $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                    ?>
                                                                    <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_FAC) echo "selected=\"selected\";" ?>><?php echo $_myrowRes['FirstName']. " " . $_myrowRes['LastName'] ; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                              </div>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td >&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="2">&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td ><div align="center">ALL EMPLOYESS</div></td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="2"><div align="left" >
                                                                <div align="center">TEAM MEMBERS</div>
                                                              </div></td>
                                                            <td>&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td rowspan="4"><div align="right">
                                                                <select name="lstSysUsers" size="10" class="required ui-widget-content" id="lstSysUsers" style="width:200px">
                                                                  <?php
                                                                            #	Get Designation details ...................
                                                
                                                                            while($_myrowRes = mysqli_fetch_array($_FacilitySet)) {
                                                                                if ($_FAC <> $_myrowRes['EmpCode']) {
                                                                        ?>
                                                                  <option value="<?php echo $_myrowRes['EmpCode']; ?>" > <?php echo $_myrowRes['FirstName']. " " . $_myrowRes['LastName'] ; ?> </option>
                                                                  <?php
                                                                            }
                                                                        } ?>
                                                                </select>
                                                              </div></td>
                                                            <td height="43"><div align="center"></div></td>
                                                            <td colspan="2" rowspan="4"><div align="left">
                                                                <select name="lstFacUsers" size="10" class="required ui-widget-content" id="lstFacUsers" style="width:200px">
                                                                  <?php 						
                                                                            #	Get Designation details ...................
                                                                            #$_ResultSet = getUSERSBYFAC($str_dbconnect) ;
                                                                            
                                                                            while($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {
                                                                        ?>
                                                                  <option value="<?php echo $_myrowRes['EmpCode']; ?>" > <?php echo $_myrowRes['UserName'];?> </option>
                                                                  <?php } ?>
                                                                </select>
                                                              </div></td>
                                                            <td rowspan="4">&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td height="40"><div align="center">
                                                                <input name="Save" type="button" style="width: 60px" id="Save" value="&gt;" onclick="SaveFac('<?php echo $_FAC; ?>');" />
                                                              </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td height="40"><div align="center">
                                                                <input name="Del" type="button" style="width: 60px" id="Del" value="&lt;" onclick="DeleteFac('<?php echo $_FAC; ?>');" />
                                                              </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td><div align="center"></div></td>
                                                          </tr>
                                                          <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="2">&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td></td>
                                                          </tr>
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
