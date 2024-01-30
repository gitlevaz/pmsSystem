<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
session_start();
include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\sql_empdetails.php");   //  connection file to the mysql database
include ("class\sql_sysusers.php");   //  connection file to the mysql database
include ("class\sql_crtgroups.php");   //  connection file to the mysql database
include ("class/accesscontrole.php");          //  sql commands for the access controles
// include ("sqlconnection2.php");   //  connection file to the mysql database
// include ("sql_empdetails.php");   //  connection file to the mysql database
// include ("sql_sysusers.php");   //  connection file to the mysql database
// include ("sql_crtgroups.php");   //  connection file to the mysql database
// include ("accesscontrole2.php");          //  sql commands for the access controles
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "SystemUsers";
$created_by = $_SESSION["LogUserName"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS SYSTEM USER DETAILS ::.</title>

	<link href="css/styleB.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />
    <link href="css/SystemUsers.css" rel="stylesheet" type="text/css" /> 

     <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

    <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>

    <script type="text/javascript" charset="utf-8">
       function getPageSize() {
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );
            parent.resizeIframeToFitContent(height);
        }
    </script>

 <script type="text/javascript" charset="utf-8">

        $(document).ready(function() {
            $('#checkPasswordButton').click(function() {
                // Check the condition (you can replace this with your actual condition)
                var needsToChangePassword = true; // Replace with your actual condition
                
                if (needsToChangePassword) {
                    $('.passwordFields').show();
                } else {
                    $('.passwordFields').hide();
                }
            });

           var usercode = '<?php  echo $_GET["usercode"] ?>';
           if(!usercode){
            $('.checkPasswordButton').hide();
            $('.passwordFields').show();
           }

        });

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
      
	        // $('#example').dataTable();

            $('#btnBack').click(function(){
                document.forms[0].action = "browseusers.php";
                document.forms[0].submit();
            });
        
	    });

 
    </script>
   
</head>
    <?php 

        $_strUSERCODE 	= "";
        $_strUSERNAME 	= "";
        $_strUSERPSW 	= "";
        $_strEMPCODE 	= "";
        $_strPSWDEXP	= "";
        $_strEXPINDAYS 	= "1";
        $_strUSERGRP 	= "";
        $_strCRTDATE 	= "";
        $_strLSTUPDATE 	= "";
        $_strUSERSTAT 	= "";
        $_strREADONLY	= "FALSE";
        $bool_ReadOnly = "Yes";
        
        if(isset($_POST['btnAdd'])) {
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"N";
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please Enter New Project Details</div>";
        }

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
       if(isset($_GET["usercode"]))
        {
            $_POST["txtUserCode"] = $_GET["usercode"];
                $_strUSERCODE     =  $_GET["usercode"];
                $bool_ReadOnly              =	"No";
                $Save_Enable                =	"No";
                $_SESSION["DataMode"]       =	"";

                $_ResultSet = getSELECTEDDETAILS($str_dbconnect,$_strUSERCODE);
				while($_myrowRes 	= mysqli_fetch_array($_ResultSet)) {
                    $_strUSERNAME 	= $_myrowRes['User_name'];
                    $_strUSERPSW 	= $_myrowRes['User_password'];
                    $_strEMPCODE 	= $_myrowRes['EmpCode'];
                    $_strPSWDEXP	= $_myrowRes['PswdExp'];
                    $_strEXPINDAYS 	= $_myrowRes['ExpInDays'];
                    $_strUSERGRP 	= $_myrowRes['UserGroup'];
                    $_strCRTDATE 	= $_myrowRes['CreateDate'];
                    $_strLSTUPDATE 	= $_myrowRes['UpdateDate'];
                    $_strUSERSTAT 	= $_myrowRes['UserStat'];
                }
        }

        if(isset($_POST['btnEdit'])) {
            
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"E";
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please update the Project Details</div>";

            $_strUSERCODE    =  $_POST["txtUserCode"];

            $_ResultSet = getSELECTEDDETAILS($str_dbconnect,$_strUSERCODE);
            while($_myrowRes 	= mysqli_fetch_array($_ResultSet)) {
                $_strUSERNAME 	= $_myrowRes['User_name'];
                $_strUSERPSW 	= $_myrowRes['User_password'];
                $_strEMPCODE 	= $_myrowRes['EmpCode'];
                $_strPSWDEXP	= $_myrowRes['PswdExp'];
                $_strEXPINDAYS 	= $_myrowRes['ExpInDays'];
                $_strUSERGRP 	= $_myrowRes['UserGroup'];
                $_strCRTDATE 	= $_myrowRes['CreateDate'];
                $_strLSTUPDATE 	= $_myrowRes['UpdateDate'];
                $_strUSERSTAT 	= $_myrowRes['UserStat'];
            }
        }

        if(isset($_POST['btnSave'])) {

            if($_SESSION["DataMode"] == "N"){

        
                createSYSUSERWIthCreatedBy($str_dbconnect,$_POST["txtUserName"], $_POST["txtPsw1"], $_POST["optEmployee"], $_POST["optPswE"], $_POST["txtExpinDays"], $_POST["optUserGroup"], $_POST["optUserStat"],$created_by);
                //echo "<div class='Div-Msg' id='msg' align='left'>*** System User Created Successfully</div>";
     
              ?>
                <script type="text/javascript">
                alert(" System User Created Successfully");
                window.location.href = "browseusers.php";
            </script>
<?php                
            }elseif($_SESSION["DataMode"] == "E"){
                if(empty($_POST["txtPsw1"])){
                    updateSYSUSERWithoutPW($str_dbconnect,$_POST["txtUserCode"],$_POST["txtUserName"], $_POST["optEmployee"], $_POST["optPswE"], $_POST["txtExpinDays"], $_POST["optUserGroup"], $_POST["optUserStat"]);
                }else{
                    updateSYSUSER($str_dbconnect,$_POST["txtUserCode"],$_POST["txtUserName"], $_POST["txtPsw1"], $_POST["optEmployee"], $_POST["optPswE"], $_POST["txtExpinDays"], $_POST["optUserGroup"], $_POST["optUserStat"]);
                }
                //echo "<div class='Div-Msg' id='msg' align='left'>*** User Details Updated Successfully</div>";
                ?>
                <script type="text/javascript">
                alert(" User Details Updated Successfully");
                window.location.href = "browseusers.php";
            </script>
<?php
            }

            $bool_ReadOnly          = "Yes";
            $Save_Enable            = "No";
            $_SESSION["DataMode"]   = "E";
            $_SESSION["ProjectCode"]= "";

        }

        if(isset($_POST['btnSearch'])) {
            //header("Location:M_Reference.php");
            echo "<script>";
            echo " self.location='browseusers.php';";
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
                                <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr style="height: 50px; background-color: #E0E0E0;">
                                            <td style="padding-left: 10px; font-size: 16px">
                                                <font color="#0066FF"><strong>System User Details Add/Edit</strong></font>                                             
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                        	                                                 
                                        </tr>
                                    </table><br></br><br></br>                                       
									<table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
										<tr>
											<td>                    
                        						<input   id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="" size="5"/>
                   							</td>
											<td>
                       						 	<input type="submit" id="btnSearch" name="btnSearch" title="Search Project Details" class="buttonSearch" value="" size="5" />
                    						</td>
											<td>
                        						<input type="submit" id="btnAdd" name="btnAdd" title="Add New Project" class="buttonAdd" value="     " size="5"/>
                    						</td>
											<td>
                        						<input type="submit" id="btnEdit" name="btnEdit" title="Edit Project" class="buttonEdit" value="     "  size="10"/>
											</td>
											<td> 
                                                <input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Project" class="buttonDel" value="     " size="10"/>
                    						</td>
											<td>
                        						<input type="submit" id="btnPrint" name="btnPrint" title="Print Project Details" class="buttonPrint" value="     " size="10"/>
                    						</td>
                                         </tr>
									</table>  
<!--                    creating data entry Interface-->

                    <br><br><br>
                    <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td width="20%">User Code
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtUserCode" type="text" id="txtUserCode" class="required ui-widget-content" size="15" value="<?php echo $_strUSERCODE; ?>" <?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>/>
                       								</td>
                                                </tr> 
												<tr>
                                                    <td width="20%">User Name
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtUserName" type="text" id="txtUserName" class="required ui-widget-content" size="25" value="<?php echo $_strUSERNAME; ?>" <?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>/>
                        							</td>
                                                </tr>
												<tr>
                                                    <td width="20%">Employee Details
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>   
                                                        <select name="optEmployee" id="optEmployee" class="required ui-widget-content" <?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>>
                                                          <option value="00"> NOT AN EMPLOYEE </option>
                                                          <?php
                            
                                                                #	Get Designation details ...................
                                                            $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                            ?>
                                                          <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['Title']." ".$_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                          <?php } ?>
                                                        </select>
                         							</td>
                                                </tr>

                                                <?php if(!empty($_strUSERCODE )){ ?>
                                                <tr>
                                                    <td width="0%"> <input type="button" class="checkPasswordButton"  id="checkPasswordButton" value="Change Password">
                                                    </td>
                                                </tr>
                                                <?php } ?>

                                                <tr class="passwordFields" style="display: none;">
                                                    <td width="20%"> User Password
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td> 
                                                        <input name="txtPsw1" type="text" id="txtPsw1" class="required ui-widget-content" size="25" value="<?php //echo $_strUSERPSW; ?>" <?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>/>
                                                    </td>
                                                </tr>

<!--                                                 
                                                <tr class="passwordFields" style="display: none;">
                                                    <td  width="20%">Re-Type Password
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td> 
                                                        <input name="txtPsw2" type="text" id="txtPsw2" class="required ui-widget-content" size="25" value="<?php //echo $_strUSERPSW; ?>"<?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>/>
                                                    </td>
                                                </tr> -->
                                                                    
                                                <tr>
                                                    <td width="20%"> Password Exp:
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td> 
                                                        <select name="optPswE" id="optPswE" class="required ui-widget-content" <?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";"?>>
                                                      
                                                          <option id="E" value="1" <?php if (1 == $_strPSWDEXP){echo "selected=\"selected\"";}  ?>>Enable</option>
                                                          <option id="D" value="0" <?php if (0 == $_strPSWDEXP) {echo "selected=\"selected\"";}   ?>>Disable</option>
                                                        </select>
                       								</td>
                                                </tr>

                                                <tr>
                                                    <td width="20%">Exp: In Days
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td> 
                            							<input name="txtExpinDays" type="text"  class="required ui-widget-content" id="txtExpinDays" size="20" value="<?php echo $_strEXPINDAYS; ?>"<?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>/>
                        							</td>
                                                </tr>

                                                <!-- <tr >
                                                        <td width="20%">
                                                            Report Owner
                                                        </td>
                                                     
                                                        <td width="2%"></td>
                                                                
                                                        <td >
                                                            <select id="cmbReportOwner" name="cmbReportOwner" class="TextBoxStyle">
                                                                <?php
                                                                    #	Get Designation details ...................
                                                                 
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                  
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_strEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr> -->

                                                <tr>
                                                    <td width="20%">User Group
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td> 
                                                        <select name="optUserGroup" id="optUserGroup" class="required ui-widget-content" <?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>>
                                                        <?php
                                                            #	Get Designation details ...................
                                                            $_ResultSet = getGROUP($str_dbconnect);
                                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                        ?>
                                                            <option value="<?php echo $_myrowRes['GrpCode']; ?>"  <?php if ($_myrowRes['GrpCode'] == $_strUSERGRP) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['Group'] ;?> </option>
                                                        <?php } ?>
                                                        </select>
                       								</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">User Status
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td> 
                                                        <select name="optUserStat" id="optUserStat" class="required ui-widget-content" <?php if($bool_ReadOnly == "Yes") echo "disabled=\"disabled\";" ?>>
                                                          <option value="A" <?php if ("A" == $_strUSERSTAT) echo "selected=\"selected\";" ?>>Active</option>
                                                          <option value="I" <?php if ("I" == $_strUSERSTAT) echo "selected=\"selected\";" ?>>Inactive</option>
                                                        </select>
                        							</td>
                                                </tr>

                                                <tr height="12px"></tr>
                                                <tr>
													<td colspan="3" align="center">
                                                        <table width="60%" cellpadding="0" cellspacing="0">
                                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">             						
                        								<input name="btnSave" id="btnSave" type="submit"  value="Save" style="width: 60px"/>
                        								<input name="btnCancel" id="btnCancel" type="reset"  value="Cancel" style="width: 60px"/>
                                                         </td>                                            
                                                       </tr>
                                                      </table>
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