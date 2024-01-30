<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
    session_start();
    include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
    include ("class/sql_crtprocat.php");   //  connection file to the mysql database
    include ("class/sql_empdetails.php");   //  connection file to the mysql database
	include ("class/accesscontrole.php");         //  sql commands for the access controles
	
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	$path = "";
	$Menue	= "ProjectGroups";
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
	
	<!-- **************** SLIDER ***************** -->
	<script src="js/jquery-ui.min.js"></script>
	
	<script type="text/javascript"  src="src/js/jscal2.js"></script>
	<script type="text/javascript"  src="src/js/lang/en.js"></script>
	
	<link type="text/css" rel="stylesheet" href="src/css/jscal2.css" />
	<link type="text/css" rel="stylesheet" href="src/css/border-radius.css" />
	
	<link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
	<link rel="stylesheet" href="css/uploadify.styling.css" type="text/css" />
	<script type="text/javascript" src="js/jquery.uploadify.js"></script>
	
	<!-- ************ TIME PICKER ***************** -->
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<!-- ************************************* -->	
		
	<link href="css/styleB.css" rel="stylesheet" type="text/css" />
	
	<script src="js/jquery.validate.js" type="text/javascript"></script>

    <script type="text/javascript" charset="utf-8">
       function getPageSize() {
            /*var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );
            parent.resizeIframeToFitContent(height);*/
        }
		
		$(window).load(function() { 
	         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
	    });
		
		$(document).ready(function() {
	        $('#example').dataTable();
	    } );

        function View(hlink){
            document.forms[0].action = "crtprojectgroups.php?&grpcode="+hlink+"";
            document.forms[0].submit();
        }

       function startUpload(){
            var valdator = "false";
            valdator = $("#frm_porject").valid();
            if(valdator != "false"){
                document.forms['frm_porject'].action = "crtprojectgroups.php?btnSave=btnSave";
                document.forms['frm_porject'].submit();
            }
        }

        $().ready(function() {
        // validate signup form on keyup and submit
            $("#frm_porject").validate({
                onsubmit: false,
                rules: {
                    txtGrpCode: {
                        required: false
                    },
                    txtGrpName: {
                        required: true
                    },
                    txtGrpNote:{
                        required: false
                    },
                    lstSysUsers:{
                        required: false
                    },
                    lstFacUsers:{
                        required: false
                    }
                },
                messages: {
                    txtGrpCode: "Please Enter a Group Code",
                    txtGrpName: "Please Enter a Group Name"
                }
            });
        });

    </script>
    
</head>
    <?php

        $Str_GrpCode    =   "";
        $Str_GrpName    =   "";
        $Str_GrpNote    =   "";
        $Str_MailTo     =   "";
        $_FAC           =   "";
        $bool_ReadOnly  =	"TRUE";
        $Save_Enable    =	"Yes";

        
        if((isset($_GET["grpcode"])) && ($_GET["grpcode"] <> "")){

             $_SESSION["GrpCode"]    = $_GET["grpcode"];
             $Str_GrpCode            = $_SESSION["GrpCode"];
             
            $_ResultSet = getSELECTEDGROUP($str_dbconnect,$Str_GrpCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_GrpCode = $_myrowRes['GrpCode'];
                $Str_GrpName = $_myrowRes['Group'];
                $Str_GrpNote = $_myrowRes['Country'];
            }

            $_FAC			        =	$Str_GrpCode;
            $_FacilityUSERS         =   getMailUSERFACILITIES($str_dbconnect,$_FAC);
            $_FacilitySet 	        =   getMailUSERSBYFAC($str_dbconnect,$_FAC);
        }

        if(isset($_POST['btnAdd'])) {
            $Str_GrpCode            =   gettemporySerial($str_dbconnect);
            $_SESSION["GrpCode"]    =   $Str_GrpCode;
            $Str_GrpName            =   "";
            $_SESSION["DataMode"]   =	"N";
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";

            echo "<div class='Div-Msg' id='msg' align='left'>*** Please Enter the Division Details</div>";
        }

        if(isset($_POST['btnEdit'])) {

            $Str_GrpCode    =   $_SESSION["GrpCode"];

            $_ResultSet = getSELECTEDGROUP($str_dbconnect,$Str_GrpCode);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                $Str_GrpCode = $_myrowRes['GrpCode'];
                $Str_GrpName = $_myrowRes['Group'];
                $Str_GrpNote = $_myrowRes['Country'];
            }

            $_FAC			        =	$Str_GrpCode;
            $_FacilityUSERS         =   getMailUSERFACILITIES($str_dbconnect,$_FAC);
            $_FacilitySet 	        =   getMailUSERSBYFAC($str_dbconnect,$_FAC);

            $_SESSION["DataMode"]   =	"E";
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";

            echo "<div class='Div-Msg' id='msg' align='left'>*** Please Update the Division Details</div>";
        }

        if(isset($_GET['btnSave'])) {

            if($_SESSION["DataMode"] == "N"){
                $Str_GrpCode    =   $_SESSION["GrpCode"];
                $Str_GrpName    =   $_POST["txtGrpName"];
                $Str_GrpNote    =   $_POST["txtGrpNote"];

                $Str_GrpCode = createGROUP($str_dbconnect,$Str_GrpCode, $Str_GrpName, $Str_GrpNote);

                $_SESSION["GrpCode"]    =   $Str_GrpCode;
                $_FAC			        =	$Str_GrpCode;
                $_FacilityUSERS         =   getMailUSERFACILITIES($str_dbconnect,$_FAC);
                $_FacilitySet 	        =   getMailUSERSBYFAC($str_dbconnect,$_FAC);

                echo "<div class='Div-Msg' id='msg' align='left'>*** Division Created Successfully</div>";
            }elseif($_SESSION["DataMode"] == "E"){

                $Str_GrpCode    =   $_SESSION["GrpCode"];
                $Str_GrpName    =   $_POST["txtGrpName"];
                $Str_GrpNote    =   $_POST["txtGrpNote"];

                updateGROUP ($str_dbconnect,$Str_GrpCode, $Str_GrpName, $Str_GrpNote);

                $_SESSION["GrpCode"]    =   $Str_GrpCode;
                $_FAC			        =	$Str_GrpCode;
                $_FacilityUSERS         =   getMailUSERFACILITIES($str_dbconnect,$_FAC);
                $_FacilitySet 	        =   getMailUSERSBYFAC($str_dbconnect,$_FAC);

                echo "<div class='Div-Msg' id='msg' align='left'>*** Division Updated Successfully</div>";
            }

            $bool_ReadOnly  =	"TRUE";
            $Save_Enable    =	"No";
        }

        if (isset($_POST['Save']) && isset($_SESSION["GrpCode"])) {
            createMailFacility($str_dbconnect,$_SESSION["GrpCode"], $_POST["lstSysUsers"] ) ;
        }

        if (isset($_POST['Del']) && isset($_SESSION["GrpCode"])) {
            deleteMailFacility($str_dbconnect,$_SESSION["GrpCode"], $_POST["lstFacUsers"] ) ;
        }

        $_FacilityUSERS = getMailUSERFACILITIES($str_dbconnect,$_FAC);
		$_FacilitySet 	= getMailUSERSBYFAC($str_dbconnect,$_FAC);

        if((isset($_SESSION["GrpCode"])) && ($_SESSION["GrpCode"] <> "") && (($_SESSION["DataMode"] == "E")||($_SESSION["DataMode"] == "N")) && (!isset($_GET["grpcode"]))) {
            $Str_GrpCode    =   $_SESSION["GrpCode"];
            $Str_GrpName    =   $_POST["txtGrpName"];
            $Str_GrpNote    =   $_POST["txtGrpNote"];
            $_FAC			=	$Str_GrpCode ;
            $_FacilityUSERS = getMailUSERFACILITIES($str_dbconnect,$_FAC);
            $_FacilitySet 	= getMailUSERSBYFAC($str_dbconnect,$_FAC);

            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
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
                                                <font color="#0066FF"> Welcome, </font> <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]) ?>                                                
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>
                                    <br></br>  
									<table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
										<tr>
											<!--<td>
												<input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="     " size="5"/>
											</td>-->
											<!--<td>
												<input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="     " size="5"/>
											</td>-->
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
                                    <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>                                                
                                            	<tr>
                                                    <td width="20%">
                                                        Department Code
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input type="text" id="txtGrpCode" name="txtGrpCode" class="TextBoxStyle" size="20" value="<?php echo $Str_GrpCode; ?>"/>
                                                    </td>
                                                </tr>  
												<tr>
                                                    <td width="20%">
                                                        Department Name
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <input type="text" id="txtGrpName" name="txtGrpName" class="TextBoxStyle" size="40" value="<?php echo $Str_GrpName; ?>" />
                                                    </td>
                                                </tr> 
												<tr>
                                                    <td width="20%">
                                                        Division
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="txtGrpNote" name="txtGrpNote" class="TextBoxStyle" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
							                                <option id="SL" value="SL" <?php if($Str_GrpNote == "SL") echo "selected=\"selected\""; ?>>SL</option>
							                                <option id="US" value="US" <?php if($Str_GrpNote == "US") echo "selected=\"selected\""; ?>>US</option>
							                                <option id="TI" value="TI" <?php if($Str_GrpNote == "TI") echo "selected=\"selected\""; ?>>TI &nbsp;&nbsp;</option>
															<option id="UK" value="UK" <?php if($Str_GrpNote == "UK") echo "selected=\"selected\""; ?>>UK &nbsp;&nbsp;</option>
															<option id="MLD" value="MLD" <?php if($Str_GrpNote == "MLD") echo "selected=\"selected\""; ?>>MLD &nbsp;&nbsp;</option>
															<option id="CN" value="CN" <?php if($Str_GrpNote == "CN") echo "selected=\"selected\""; ?>>CN &nbsp;&nbsp;</option>
															<option id="AU" value="AU" <?php if($Str_GrpNote == "AU") echo "selected=\"selected\""; ?>>AU &nbsp;&nbsp;</option>
															<option id="FIJI" value="FIJI" <?php if($Str_GrpNote == "FIJI") echo "selected=\"selected\""; ?>>FIJI &nbsp;&nbsp;</option>
							                            </select>
                                                    </td>
                                                </tr> 
												<tr>
                                                    <td width="20%">
                                                        Mail Daily Status Report
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                    	<select name="lstSysUsers" size="10" class="" id="lstSysUsers" style="width:200px" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
							                              <?php
							                                while($_myrowRes = mysqli_fetch_array($_FacilitySet)) {
							                              ?>
							                                    <option value="<?php echo $_myrowRes['EmpCode']; ?>" > <?php echo $_myrowRes['FirstName']. " " . $_myrowRes['LastName'] ; ?> </option>
							                              <?php
							                                }
							                              ?>
							                            </select>
							
							                            <input name="Save" type="submit" id="Save" style="width: 40px; vertical-align: 500%; cursor: pointer" value=">" <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?>/>
							                            <input name="Del" type="submit" id="Del" style="width: 40px;  vertical-align: 500%; cursor: pointer" value="<" <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?>/>
							
							                            <select name="lstFacUsers" size="10" class="" id="lstFacUsers" style="width:200px" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
							                                <?php
							                                    while($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {
							                                ?>
							                                    <option value="<?php echo $_myrowRes['EmpCode']; ?>" > <?php echo $_myrowRes['UserName'];?> </option>
							                                <?php
							                                    }
							                                ?>
							                            </select>    
                                                    </td>
                                                </tr> 
												<tr>
                                                    <td colspan="3" align="center"></td>
												</tr>
												<tr>
                                                    <td colspan="3" align="center">
                                                        <table width="60%" cellpadding="0" cellspacing="0">
                                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">
																	<input name="btnSave" id="btnSave" type="button"  style=" cursor: pointer" value="Save" <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?> onclick="startUpload()"/>
                            										&nbsp;<input name="btnCancel" id="btnCancel" type="reset"  style=" cursor: pointer"" value="Cancel" />                                                                   
                                                                </td>                                            
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </td>
                                        </tr>
                                    </table> 
									<br>
									<table width="60%" cellpadding="0" cellspacing="0" align="center">
                                        <tr style="height: 50px;">
                                            <td style="padding-left: 10px; font-size: 18px;" align="center">
                                                <u>Project Groups</u>
                                            </td>                                            
                                        </tr>
                                    </table>
									<br>
									<table cellpadding="0" cellspacing="0" class="display" border="0" id="example" width="100%">
										<thead>
                                            <tr>
                                                <th>Group Code</th>
                                                <th>Group name</th>
                                                <th>Country</th>												
												<th></th>
                                            </tr>
                                        </thead>
				                        <tbody>
				                            <?php
				                                $ColourCode = 0 ;
				                                $LoopCount = 0;
				                                $_ResultSet = getGROUP($str_dbconnect);
				                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				                                    if ($ColourCode == 0 ) {
				                                        $Class = "gradeA" ;
				                                        $ColourCode = 1 ;
				                                    } elseif ($ColourCode == 1 ) {
				                                        $Class = "gradeA";
				                                        $ColourCode = 0 ;
				                                    }
				                            ?>
				                                <tr class="<?php echo $Class; ?>">
				                                    <td>
				                                        <?php
				                                            echo $_myrowRes['GrpCode'];
				                                            $Str_GrpCode = $_myrowRes['GrpCode'];
				                                        ?>
				                                    </td>
				                                    <td align="left"><?php echo $_myrowRes['Group']; ?></td>
				                                    <td align="center"><?php echo $_myrowRes['Country']; ?></td>
				                                    <td align="center">
				                                        <?php
				                                            echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_GrpCode\")'/>";
				                                        ?>
				                                    </td>
				                                </tr>
				                            <?php
				                                $LoopCount = $LoopCount + 1;
				                                }
				                            ?>
				                            </tbody>
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