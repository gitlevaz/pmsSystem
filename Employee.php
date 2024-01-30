<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Create - Update - Remove - Employee Details
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();
include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\accesscontrole.php");       //  sql commands for the access controles
include ("class\sql_empdetails.php");       //  sql commands for the access controles
include ("class\sql_crtprocat.php");            //  connection file to the mysql database

// include ("connection/sqlconnection.php");   
// //  Role Autherization   //  connection file to the mysql database
// include ("class/sql_crtprocat.php");   //  connection file to the mysql database
// include ("class/sql_empdetails.php");   //  connection file to the mysql database
// include ("class/accesscontrole.php");         //  sql commands for the access controles

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "Employee";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS EMPLOYEE DETAILS ::.</title>
    
    <link href="css/styleB.css" rel="stylesheet" type="text/css" />  
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />   
	<script type="text/javascript" src="js/jquery.uploadify.js"></script>
	 <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>
	
	
	<!-- **************** Page Val+6idation ***************** -->
	<script src="js/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
   <!-- <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->
         <script type="text/javascript" charset="utf-8">

        function getPageSize() {/*
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);*/
        }
        
		function Selection(){
            hlink = document.getElementById('opt_Division').value ;
            document.forms[0].action = "Employee.php?&division="+hlink+"";
            document.forms[0].submit();
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

        $_strEmpCODE 	= "";
        $_strEmpNIC 	= "";
        $_strADDRESS 	= "";
        $_strStreet 	= "";
        $_strCity	= "";
        $_strTitle 	= "";
        $_strFirstName 	= "";
        $_strLastName 	= "";
        $_strContactL 	= "";
        $_strContactM 	= "";
        $_strFaxNo 	= "";
        $_strEMail 	= "";
        $_strDesig 	= "";
        $_strDivCode = "";
        $_strDptCode = "";
        $_ReportOwnEMPCODE 	= "";
       // $bool_ReadOnly  =	"TRUE";
        $Save_Enable    =   "No";
        $bool_ReadOnly          =	"True";
        $Save_Enable            =	"Yes";
        //$_SESSION["DataMode"] = "";
        #*************************************************************
	

        if(isset($_GET["division"]))
        {
            $_strDivCode    = $_GET["division"]; 
           // $_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);       

            $bool_ReadOnly          =	"True";
            $Save_Enable            =	"Yes";
        }


		
        if(isset($_POST['btnSearch'])) {
            //header("Location:M_Reference.php");
            echo "<script>";
            echo " self.location='employeebrowse.php';";
            echo "</script>";
        }

        if(isset($_POST['btnAdd'])) {
            $bool_ReadOnly          =	"False";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"N";
            $_SESSION["EmpCode"]   = "";

            $_POST["txtEmpCode"] 	= "";
            $_POST["txtEPF"] 	    = "";
            $_POST["txtAdd1"] 	    = "";
            $_POST["txtStrt"] 	    = "";
            $_POST["txtCity"]       = "";
            $_POST["opt_Title"]     = "";
            $_POST["txtFstName"] 	= "";
            $_POST["txtLstName"] 	= "";
            $_POST["txtCont1"] 	    = "";
            $_POST["txtCont2"]	    = "";
            $_POST["txtFax"]        = "";
            $_POST["txtEMail"]      = "";
            $_POST["opt_Designation"] = "";
			$_POST["opt_Department"]  = "";
			$_POST["opt_Division"]    = "";				
        }

         if(isset($_POST['btnCancel'])) {
            $bool_ReadOnly          =	"TRUE";
            $Save_Enable            =	"No";
            $_SESSION["DataMode"]   =	"";
            $_SESSION["EmpCode"]   = "";
        }

        #	VALIDATING THE PARAMETER FROM THE SEARCH TABLE
        if(isset($_GET["empcode"]))
        {
                $_SESSION["EmpCode"]       =  $_GET["empcode"];
                $bool_ReadOnly              =	"False";
                $Save_Enable                =	"No";
                $_SESSION["DataMode"]       =	"N";
                
                $_ResultSet = getSELECTEDEMPLOYEE($str_dbconnect,$_SESSION["EmpCode"]);
                
                while($_myrowRes 	= mysqli_fetch_array($_ResultSet)) {
                    $_strEmpCODE 	= $_myrowRes['EmpCode'];
                    $_strEmpNIC 	= $_myrowRes['EmpNIC'];
                    $_strADDRESS 	= $_myrowRes['Address1'];
                    $_strStreet 	= $_myrowRes['Street'];
                    $_strCity       = $_myrowRes['City'];
                    $_strTitle      = $_myrowRes['Title'];
                    $_strFirstName 	= $_myrowRes['FirstName'];
                    $_strLastName 	= $_myrowRes['LastName'];
                    $_strContactL 	= $_myrowRes['ContactL'];
                    $_strContactM 	= $_myrowRes['ContactM'];
                    $_strFaxNo      = $_myrowRes['FaxNo'];
                    $_strEMail      = $_myrowRes['EMail'];
                    $_strDesig      = $_myrowRes['DesCode'];
					$_strDptCode    = $_myrowRes['DeptCode'];
					$_strDivCode    = $_myrowRes['Division'];
                    $_ReportOwnEMPCODE = $_myrowRes['report_owner'];
                    
                    //$_strREADONLY	= "TRUE";
                }
                //echo $_GET["division"] = $_strDesig;
             
				  if(isset($_GET["division"]))
				{
					$_strDivCode    = $_GET["division"];
					$_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
			    } 
        }
		
		if(isset($_SESSION["EmpCode"])  && $_SESSION["EmpCode"] <> ""){
                $_ResultSet = getSELECTEDEMPLOYEE($str_dbconnect,$_SESSION["EmpCode"]);
                while($_myrowRes 	= mysqli_fetch_array($_ResultSet)) {
                    $_strEmpCODE 	= $_myrowRes['EmpCode'];
                    $_strEmpNIC 	= $_myrowRes['EmpNIC'];
                    $_strADDRESS 	= $_myrowRes['Address1'];
                    $_strStreet 	= $_myrowRes['Street'];
                    $_strCity       = $_myrowRes['City'];
                    $_strTitle      = $_myrowRes['Title'];
                    $_strFirstName 	= $_myrowRes['FirstName'];
                    $_strLastName 	= $_myrowRes['LastName'];
                    $_strContactL 	= $_myrowRes['ContactL'];
                    $_strContactM 	= $_myrowRes['ContactM'];
                    $_strFaxNo      = $_myrowRes['FaxNo'];
                    $_strEMail      = $_myrowRes['EMail'];
                    $_strDesig      = $_myrowRes['DesCode'];
					$_strDptCode    = $_myrowRes['DeptCode'];
					$_strDivCode    = $_myrowRes['Division'];
                    $_ReportOwnEMPCODE = $_myrowRes['report_owner'];
                    //$_strREADONLY	= "TRUE";
                }
				if(isset($_GET["division"]))
				{
					$_strDivCode    = $_GET["division"];
					$_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
			    }
        }
		
//        if(isset($_SESSION["ProjectCode"])  && $_SESSION["ProjectCode"] <> ""){
//            $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_SESSION["ProjectCode"]);
//            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
//                $Str_ProCode = $_myrowRes['procode'];
//                $Str_ProName = $_myrowRes['proname'];
//                $Dte_Startdate = $_myrowRes['startdate'];
//            }
//        }

        if(isset($_POST['btnEdit'])) {
            $bool_ReadOnly          =	"False";
            $Save_Enable            =	"Yes";
            $_SESSION["DataMode"]   =	"E";

            $_ResultSet = getSELECTEDEMPLOYEE($str_dbconnect,$_SESSION["EmpCode"]);
            while($_myrowRes 	= mysqli_fetch_array($_ResultSet)) {
                $_strEmpCODE 	= $_myrowRes['EmpCode'];
                $_strEmpNIC 	= $_myrowRes['EmpNIC'];
                $_strADDRESS 	= $_myrowRes['Address1'];
                $_strStreet 	= $_myrowRes['Street'];
                $_strCity       = $_myrowRes['City'];
                $_strTitle      = $_myrowRes['Title'];
                $_strFirstName 	= $_myrowRes['FirstName'];
                $_strLastName 	= $_myrowRes['LastName'];
                $_strContactL 	= $_myrowRes['ContactL'];
                $_strContactM 	= $_myrowRes['ContactM'];
                $_strFaxNo      = $_myrowRes['FaxNo'];
                $_strEMail      = $_myrowRes['EMail'];
                $_strDesig      = $_myrowRes['DesCode'];
				$_strDptCode    = $_myrowRes['DeptCode'];
				$_strDivCode    = $_myrowRes['Division'];
                $_ReportOwnEMPCODE = $_myrowRes['report_owner'];
                //$_strREADONLY	= "TRUE";
                }
				if(isset($_GET["division"]))
				{
					$_strDivCode    = $_GET["division"];
					$_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
			    }
	    }

        if(isset($_POST['btnSave']))
		{ 
            $_hasReqFields = FALSE;
			if($_POST["opt_Division"]=="Select" || $_POST["opt_Department"]=="Select" || $_POST["opt_Designation"]=="Select" || $_POST["opt_Title"]=="Select" ||
			   $_POST["txtFstName"]=="" || $_POST["txtLstName"]=="" || $_POST["txtEMail"]=="")
			{
				$_hasReqFields = TRUE;
			}
		    else
			{
				$_hasReqFields = FALSE;
		    }
            if($_SESSION["DataMode"] == "N" && !$_hasReqFields){
              
                #	Inserting Values to the Database by using the Function ................
                $_strEmpCODE = createEMPLOYEEByReported($str_dbconnect,$_POST["txtEPF"], $_POST["txtAdd1"], $_POST["txtStrt"], $_POST["txtCity"], $_POST["opt_Title"], $_POST["txtFstName"], $_POST["txtLstName"], $_POST["txtCont1"], $_POST["txtCont2"], $_POST["txtFax"], $_POST["txtEMail"], $_POST["opt_Designation"], $_POST["opt_Department"], $_POST["opt_Division"], $_POST["cmbReportOwner"]);

                //echo "<div class='Div-Msg' id='msg' align='left'>*** Employee Created Successfully</div>";
                ?>
                <script type="text/javascript">
                alert(" Employee Created Successfully");
                window.location.href = "employeebrowse.php";
            </script>
<?php
            }elseif($_SESSION["DataMode"] == "E" && !$_hasReqFields){

                updateEMPLOYEEByReported($str_dbconnect,$_POST["txtEmpCode"], $_POST["txtEPF"], $_POST["txtAdd1"], $_POST["txtStrt"], $_POST["txtCity"], $_POST["opt_Title"], $_POST["txtFstName"], $_POST["txtLstName"], $_POST["txtCont1"], $_POST["txtCont2"], $_POST["txtFax"], $_POST["txtEMail"], $_POST["opt_Designation"], $_POST["opt_Department"], $_POST["opt_Division"], $_POST["cmbReportOwner"]);

                //echo "<div class='Div-Msg' id='msg' align='left'>*** Employee Updated Successfully</div>";
                ///echo '<script>alert(" Employee Updated Successfully")</script>';
                //header("Location:employeebrowse.php");
                ?>
                <script type="text/javascript">
                alert(" Employee Updated Successfully");
                window.location.href = "employeebrowse.php";
            </script>
<?php
                
            }

			if(!$_hasReqFields)
			{
				$bool_ReadOnly          = "TRUE";
				$Save_Enable            = "No";
				$_SESSION["DataMode"]   = "E";
				$_SESSION["EmpCode"]= "";
			}
			else
			{
				$bool_ReadOnly          =	"False";
				$Save_Enable            =	"Yes";
			
				echo '<script language="javascript">';
				echo 'alert("Please enter required (*) details.")';
				echo '</script>';
			}
			
			$_strEmpNIC 	= $_POST["txtEPF"];
            $_strADDRESS 	= $_POST["txtAdd1"];
            $_strStreet 	= $_POST["txtStrt"];
            $_strCity       = $_POST["txtCity"];
            $_strTitle      = $_POST["opt_Title"];
            $_strFirstName 	= $_POST["txtFstName"];
            $_strLastName 	= $_POST["txtLstName"];
            $_strContactL 	= $_POST["txtCont1"];
            $_strContactM 	= $_POST["txtCont2"];
            $_strFaxNo      = $_POST["txtFax"];
            $_strEMail      = $_POST["txtEMail"];
            $_strDesig      = $_POST["opt_Designation"];
			$_strDptCode    = $_POST["opt_Department"];
			$_strDivCode    = $_POST["opt_Division"];			
	    }    
		
		if(isset($_GET["empcode"]))
        {
                $_strEmpCODE    =  $_GET["empcode"];               
				$bool_ReadOnly          = "TRUE";
				$Save_Enable            = "No";
				$_SESSION["DataMode"]   = "E";
				$_SESSION["EmpCode"]= $_strEmpCODE;

            $_POST["txtEmpCode"] 	= "";
            $_POST["txtEPF"] 	    = "";
            $_POST["txtAdd1"] 	    = "";
            $_POST["txtStrt"] 	    = "";
            $_POST["txtCity"]       = "";
            $_POST["opt_Title"]     = "";
            $_POST["txtFstName"] 	= "";
            $_POST["txtLstName"] 	= "";
            $_POST["txtCont1"] 	    = "";
            $_POST["txtCont2"]	    = "";
            $_POST["txtFax"]        = "";
            $_POST["txtEMail"]      = "";
            $_POST["opt_Designation"] = "";
			$_POST["opt_Department"]  = "";
			$_POST["opt_Division"]    = "";	

				$_ResultSet = getSELECTEDEMPLOYEE($str_dbconnect,$_strEmpCODE);
				while($_myrowRes 	= mysqli_fetch_array($_ResultSet)) {
					$_strEmpCODE 	= $_myrowRes['EmpCode'];
					$_strEmpNIC 	= $_myrowRes['EmpNIC'];
					$_strADDRESS 	= $_myrowRes['Address1'];
					$_strStreet 	= $_myrowRes['Street'];
					$_strCity       = $_myrowRes['City'];
					$_strTitle      = $_myrowRes['Title'];
					$_strFirstName 	= $_myrowRes['FirstName'];
					$_strLastName 	= $_myrowRes['LastName'];
					$_strContactL 	= $_myrowRes['ContactL'];
					$_strContactM 	= $_myrowRes['ContactM'];
					$_strFaxNo      = $_myrowRes['FaxNo'];
					$_strEMail      = $_myrowRes['EMail'];
					$_strDesig      = $_myrowRes['DesCode'];
					$_strDptCode    = $_myrowRes['DeptCode'];
					$_strDivCode    = $_myrowRes['Division'];
                    $_ReportOwnEMPCODE = $_myrowRes['report_owner'];
					$_strREADONLY	= "TRUE";
				}

				if(isset($_GET["division"]))
				{
					$_strDivCode    = $_GET["division"];
					$_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$_strDivCode);
			    }
        }

        if(isset($_POST['btnSearch'])) {
            //header("Location:M_Reference.php");
            echo "<script>";
            echo " self.location='projectbrowse.php';";
            echo "</script>";
        }
		
		if($bool_ReadOnly=="False" && $Save_Enable=="Yes" && 
           $_SESSION["DataMode"]=="N")
		{
            $_POST["txtEmpCode"] 	= "";
            $_POST["txtEPF"] 	    = "";
            $_POST["txtAdd1"] 	    = "";
            $_POST["txtStrt"] 	    = "";
            $_POST["txtCity"]       = "";
            $_POST["opt_Title"]     = "";
            $_POST["txtFstName"] 	= "";
            $_POST["txtLstName"] 	= "";
            $_POST["txtCont1"] 	    = "";
            $_POST["txtCont2"]	    = "";
            $_POST["txtFax"]        = "";
            $_POST["txtEMail"]      = "";
            $_POST["opt_Designation"] = "";
			$_POST["opt_Department"]  = "";
			$_POST["opt_Division"]    = "";	

			$_strEmpCODE 	= $_POST["txtEmpCode"];
            $_strEmpNIC 	= $_POST["txtEPF"];
            $_strADDRESS 	= $_POST["txtAdd1"];
            $_strStreet 	= $_POST["txtStrt"];
            $_strCity       = $_POST["txtCity"];
            $_strTitle      = $_POST["opt_Title"];
            $_strFirstName 	= $_POST["txtFstName"];
            $_strLastName 	= $_POST["txtLstName"];
            $_strContactL 	= $_POST["txtCont1"];
            $_strContactM 	= $_POST["txtCont2"];
            $_strFaxNo      = $_POST["txtFax"];
            $_strEMail      = $_POST["txtEMail"];
            $_strDesig      = $_POST["opt_Designation"];
			$_strDptCode    = $_POST["opt_Department"];
			$_strDivCode    = $_POST["opt_Division"];
            
		}
		
		if($bool_ReadOnly=="False" && $Save_Enable=="Yes" && 
           $_SESSION["DataMode"]=="E")
		{
			if(isset($_GET["division"]))
			{
				$_strDptCode = "";
			}
		}
    ?>
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
                                                <font color="#0066FF"><strong>Employee Details</strong></font>                              
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
                   							

<!--                    creating data entry Interface-->
                    <br><br><br>
                     <table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td width="20%">
                            							Employee Code
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtEmpCode" type="text" class="required ui-widget-content" id="txtEmpCode" size="15" readonly="readonly" value="<?php echo $_strEmpCODE; ?>"/>
                        							</td>
                                                </tr> 
												<tr>
                                                    <td width="20%">
                           								 Employee EPF No
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtEPF" type="text" class="required ui-widget-content" id="txtEPF" size="25" value="<?php echo $_strEmpNIC; ?>" />
                                                    </td>
                                                    
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Division *
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="opt_Division" name="opt_Division" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?> onchange="Selection();" class="required ui-widget-content">
							                                <option id="divisionSelect" value="Select">Select</option>
							                                <option id="SL" value="SL" <?php if($_strDivCode == "SL") echo "selected=\"selected\""; ?>>SL</option>
							                                <option id="US" value="US" <?php if($_strDivCode == "US") echo "selected=\"selected\""; ?>>US</option>
							                                <option id="TI" value="TI" <?php if($_strDivCode == "TI") echo "selected=\"selected\""; ?>>TI &nbsp;&nbsp;</option>
															<option id="UK" value="UK" <?php if($_strDivCode == "UK") echo "selected=\"selected\""; ?>>UK &nbsp;&nbsp;</option>
															<option id="MLD" value="MLD" <?php if($_strDivCode == "MLD") echo "selected=\"selected\""; ?>>MLD &nbsp;&nbsp;</option>
															<option id="CN" value="CN" <?php if($_strDivCode == "CN") echo "selected=\"selected\""; ?>>CN &nbsp;&nbsp;</option>
															<option id="AU" value="AU" <?php if($_strDivCode == "AU") echo "selected=\"selected\""; ?>>AU &nbsp;&nbsp;</option>
															<option id="FIJI" value="FIJI" <?php if($_strDivCode == "FIJI") echo "selected=\"selected\""; ?>>FIJI &nbsp;&nbsp;</option>
							                            </select>
                                                    </td>
                                                    
                                                </tr>
												<tr>
                                                    <td width="20%">
                                                        Department *
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select id="opt_Department" name="opt_Department" class="required ui-widget-content" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
							                                <option id="departmentSelect" value="Select">Select</option>
							                                <?php
							                                    if($_strDivCode == "SL")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"SL");
																if($_strDivCode == "US")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"US");
																if($_strDivCode == "TI")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"TI");
																if($_strDivCode == "UK")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"UK");
																if($_strDivCode == "MLD")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"MLD");
																if($_strDivCode == "CN")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"CN");
																if($_strDivCode == "AU")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"AU");
																if($_strDivCode == "FIJI")
																	$_DepartmentSet=getSELECTEDDepartments($str_dbconnect,"FIJI");
							                                    while($_myrowRes = mysqli_fetch_array($_DepartmentSet)) {
							                                ?>
							                                <option value="<?php echo $_myrowRes['GrpCode']; ?>"  <?php if ($_myrowRes['GrpCode'] == $_strDptCode) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['Group']; ?> </option>
							                                <?php } ?>
							                            </select>
                                                    </td>
                                                </tr>												
												<tr>
                                                    <td width="20%">                       
                            							Designation *
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>   
                            							<select name="opt_Designation" id="opt_Designation" class="required ui-widget-content" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
														<option id="designationSelect" value="Select">Select</option>
													   <?php
                                                        $_ResultSet = getDESIGNATION($str_dbconnect) ;
                                                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                        ?>
                                                        <option value="<?php echo $_myrowRes['DesCode']; ?>"  <?php if ($_myrowRes['DesCode'] == $_strDesig) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['Designation'] ; ?> </option>
                                                       <?php } ?>
                                                    </select>
                                                    </td>
                                                </tr>

                                                <tr >
                                                        <td width="20%">
                                                         Reporting Person
                                                        </td>
                                                     
                                                        <td width="2%"></td>
                                                                
                                                        <td>
                                                            <select id="cmbReportOwner" name="cmbReportOwner" class="required ui-widget-content">
                                                                <?php
                                                                    #	Get Designation details ...................
                                                                 
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                  
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $_ReportOwnEMPCODE) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                </tr>

                                                <tr>
                                                    <td width="20%">                        
                            							Address
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>   
                            							<input name="txtAdd1" type="text" class="required ui-widget-content" id="txtAdd1" size="60" value="<?php echo $_strADDRESS; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                       								</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%"> 
                            							Street
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>   
                           								 <input name="txtStrt" type="text" class="required ui-widget-content" id="txtStrt" size="60" value="<?php echo $_strStreet; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                        							</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">
                            							City *
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>    
                            							<input name="txtCity" type="text" class="required ui-widget-content" id="txtCity" size="30" value="<?php echo $_strCity; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                         							</td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                            							Title *
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>
                                                        <select name="opt_Title" class="required ui-widget-content" id="opt_Title" <?php if($bool_ReadOnly == "TRUE") echo "disabled=\"disabled\";" ?>>
														  <option id="titleSelect" value="Select">Select</option>														
                                                          <option id="Mr" <?php if ("Mr" == $_strTitle) echo "selected=\"selected\";" ?>>Mr</option>
                                                          <option id="Mis" <?php if ("Mis" == $_strTitle) echo "selected=\"selected\";" ?>>Mis</option>
                                                          <option id="Mrs" <?php if ("Mrs" == $_strTitle) echo "selected=\"selected\";" ?>>Mrs</option>
                                                          <option id="Dr" <?php if ("Dr" == $_strTitle) echo "selected=\"selected\";" ?>>Dr</option>
                                                        </select>
                       								 </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                            							First Name *
                                                     </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtFstName" type="text" class="required ui-widget-content" id="txtFstName" size="40" value="<?php echo $_strFirstName; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                        							</td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                           								Last Name *
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtLstName" type="text" class="required ui-widget-content" id="txtLstName" size="40" value="<?php echo $_strLastName; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                       							   </td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                           								 Contact No ( L )
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtCont1" type="text" class="required ui-widget-content" id="txtCont1" size="30" value="<?php echo $_strContactL; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                        							</td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                            							Contact No ( M )
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtCont2" type="text" class="required ui-widget-content" id="txtCont2" size="30" value="<?php echo $_strContactM; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                        							</td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                            							Fax
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input name="txtFax" type="text" class="required ui-widget-content" id="txtFax" size="30" value="<?php echo $_strFaxNo; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                        							</td>
                                                </tr>
												<tr>
                                                    <td width="20%">
                           								E-Mail *
                                                    </td>
                                                    <td width="2%"></td>
                                                    <td>    
                           								<input name="txtEMail" type="text" class="required ui-widget-content" id="txtEMail" size="60" value="<?php echo $_strEMail; ?>" <?php if($bool_ReadOnly == "TRUE") echo "readonly=\"readonly\";" ?>/>
                      							    </td>
                                                </tr>
                                                <tr height="12px"></tr>
												<tr>
													<td colspan="3" align="center">
                                                        <table width="60%" cellpadding="0" cellspacing="0">
                                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">                    
                        											<input name="btnSave" id="btnSave" type="submit"  style="width: 60px" value="Save" <?php if($Save_Enable == "No") echo "disabled=\"disabled\";" ?>/>
                        											&nbsp;<input name="btnCancel" id="btnCancel" type="submit" style="width: 60px" value="Cancel" />
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
                    </table >
                     </div >
            </td>            
        </tr>   
        <tr>
            <td colspan="2" style="width: 100%">
                <div id="footer">
                    <?php include ('footer.php') ?>
                </div >
            </td>
        </tr>
    </table >
</form>
</body>
</html>
