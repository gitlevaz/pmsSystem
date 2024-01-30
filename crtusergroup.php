<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
    session_start();
    include ("connection\sqlconnection.php");   //  connection file to the mysql database
    include ("class\sql_crtgroups.php");   //  connection file to the mysql database
	include ("class\sql_empdetails.php");
	include ("class\accesscontrole.php");  

    // include ("sqlconnection2.php");    //  connection file to the mysql database
    // include ("sql_crtgroups.php");   //  connection file to the mysql database
	// include ("sql_empdetails.php");
    // include ("accesscontrole2.php");  
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	$path = "";
    $Menue	= "UserGroups";


    $read_status = '';
    if(!isset($_SESSION["LogUserGroup"]) == 'SADM' ) {
        $read_status = 'readonly';
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>
	
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />
    <link href="css/crtusergroup.css" rel="stylesheet" type="text/css" />

    <style type="text/css" title="currentStyle">
            @import "media/css/demo_page.css";
            @import "media/css/demo_table.css";
    </style>

    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

	<link href="css/styleB.css" rel="stylesheet" type="text/css" /> 
    <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>
    
    <script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>

    <script type="text/javascript" charset="utf-8">
       function getPageSize() {
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );
            parent.resizeIframeToFitContent(height);
        }

        $(document).ready(function() {
            $('#example').dataTable();
        } );
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
        document.forms[0].action = "crtusergroup.php?&procode="+hlink+"";
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

$Str_GrpCode    =   "";
$Str_GrpName    =   "";
$Str_GrpNote    =   "";
$strTask        =    "";


if (isset($_POST['btnSave'])) {   
    $Save_Enable    =	"No";
if($_SESSION["DataMode"] == "E"){

    $Str_GrpCode    = $_POST['txtGrpCode'];
    $Str_GrpName    = $_POST['txtGrpName'];
    $Str_GrpNote    = $_POST['txtGrpTask'];
    $_SelectQuery   = 	"UPDATE tbl_accessgroups SET `Group` = '".$Str_GrpName."',`Task` = '".$Str_GrpNote."' WHERE `GrpCode` = '$Str_GrpCode' " or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    $_SESSION["DataMode"]   =	"";
    echo "<div class='Div-Msg' id='msg' align='left'>*** User Group Updated Successfully</div>";
    header("Location: crtusergroup.php");
    exit();
}
if($_SESSION["DataMode"] == "D"){

    $Str_GrpCode    = $_POST['txtGrpCode'];
    $_SelectQuery   = 	"DELETE FROM tbl_accessgroups  WHERE `GrpCode` = '$Str_GrpCode' " or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    $_SESSION["DataMode"]   =	"";
    echo "<div class='Div-Msg' id='msg' align='left'>*** User Group Deleted Successfully</div>";
}
else{
    if(empty($_POST['txtGrpCode'])){
        $Str_GrpCode =  uniqid();
    }else{
        $Str_GrpCode = $_POST['txtGrpCode'];
    }
   
    $Str_GrpName = $_POST['txtGrpCode'];
    $strTask = $_POST["txtGrpTask"]; 
    createGROUP($str_dbconnect,$Str_GrpCode, $Str_GrpName, $strTask);
    echo "<div class='Div-Msg' id='msg' align='left'>*** User Group Saved Successfully</div>";
}
}

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
        if(isset($_GET["procode"]))
        {
                $_SESSION["ProjectCode"]    =  $_GET["procode"];
                $bool_ReadOnly              =	"TRUE";
                $Save_Enable                =	"No";
                $_SESSION["DataMode"]       =	"";
        }

        if(isset($_SESSION["ProjectCode"])  && $_SESSION["ProjectCode"] <> ""){
            $_ResultSet = getSELECTEDGROUP($str_dbconnect,$_SESSION["ProjectCode"]);
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                // var_dump($_myrowRes); die();
                $Str_GrpCode    = $_myrowRes['GrpCode'];
                $Str_GrpName     = $_myrowRes['Group'];
                $Str_GrpNote    = $_myrowRes['Task'];
                $Save_Enable    =	"No";

            }

            // $_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
        }

        if(isset($_POST['btnAdd'])) {
            $bool_ReadOnly          =	"FALSE";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"N";
            $_SESSION["ProjectCode"]=   "";
        }

        if(isset($_POST['btnEdit'])) {
            $_SESSION["DataMode"]   =	"E";
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
           
            echo "<div class='Div-Msg' id='msg' align='left'>*** Please update the Project Details</div>";
        }

        if(isset($_POST['btnDelete'])) {
            $bool_ReadOnly          =	"No";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"D";

            echo "<div class='Div-Msg' id='msg' align='left'>*** Do you want to Continue deleting this Grooup. Please Click on SAVE</div>";
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
                                                <font color="#0066FF"><strong>User Group</strong></font>                              
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
                   							<!-- <td> 
                        						<input type="submit" id="btnPrint" name="btnPrint" title="Print Project Details" class="buttonPrint" value="     " size="10"/>
                   							</td> -->
                                            </tr>
									</table>  
                   							
<!--                    creating data entry Interface-->

                    <br><br><br>
                    
                    <legend ><strong>Create User Groups</strong></legend><br/>
 									<table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td width="20%">Group Code </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input type="text" id="txtGrpCode" name="txtGrpCode"  <?php echo $read_status; ?> class="required ui-widget-content" size="20" value="<?php echo $Str_GrpCode; ?>" />
                        							</td>
                                                </tr> 
												<tr>
                                                    <td width="20%">Group Name</td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input type="text" id="txtGrpName" name="txtGrpName"  <?php echo $read_status; ?> class="required ui-widget-content" size="40" value="<?php echo $Str_GrpName; ?>" />
                        							</td>
                                                </tr> 
												<tr>
                                                    <td width="20%">Task</td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input type="text" id="txtGrpTask" name="txtGrpTask"  <?php echo $read_status; ?> class="required ui-widget-content" size="60" value="<?php echo $Str_GrpNote; ?>" />
                       								</td>
                                                </tr>
                                                <tr height="12px"></tr>
												<tr>
													<td colspan="3" align="center">
                                                        <table width="60%" cellpadding="0" cellspacing="0">
                                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">                    
                                                                <input name="btnSave" id="btnSave" type="submit" style="width: 60px" value="Save"  <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?>/>
                                                                    <input name="btnCancel" id="btnCancel" type="reset" style="width: 60px" value="Cancel" />
                   												</td>                                            
                                                            </tr>
                                                        </table>
                                                    </td>
												</tr>
                                              </td>
                                            </tr>
                                         </table><br/><br/><br/>
                
                                        <legend ><strong>Groups Summary</strong></legend><br/>
                                           <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" onmousemove ="getPageSize();">
                                                <thead>
                                                    <tr>
                                                        <th>Group Code</th>
                                                        <th>Group Name</th>
                                                        <th>Task</th>
                                                        <th>S</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $ColourCode = 0 ;
                                                        $LoopCount = 0;
                                                        $_ResultSet = getGROUP($str_dbconnect);
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
                                                                    echo $_myrowRes['GrpCode'];
                                                                    $Str_GrpCode = $_myrowRes['GrpCode'];
                                                                ?>
                                                            </td>
                                                            <td><?php echo $_myrowRes['Group']; ?></td>
                                                            <td><?php echo $_myrowRes['Task']; ?></td>
                                                            <td>
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
                                                    <tfoot>
                                                        <tr>
                                                            <th>Group Code</th>
                                                            <th>Group Name</th>
                                                            <th>Task</th>
                                                            <th>S</th>
                                                        </tr>
                                                    </tfoot>
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