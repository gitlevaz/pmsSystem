<?php

	session_start();
	
	if(!isset($_SESSION["UserCode"]) || !isset($_SESSION["UserName"])) {
		header("Location:index.php");	
	}
	
	# File Name 	: EmployeeDet.php
	# Type			: PHP&MySQL
	# Date Create	: 16-08-2009
	# Last Modified	: 16-08-2009
	# Modified User : P.H.S.Prajapriya
	# IITS - Impact IT Solutions

	//	Open the Session for the page.......
	//session_start ();
	
	//	Inserting the PHP Pages call from out-side......
	
	include ("Connection/MySQLConnect.php");		#	PHP Class to Connect the Database
	include ("Class/Function.php");					#	PHP Class to Access All Functions relevent to the Database
	
	mysqli_select_db($str_dbconnect,"$_DataBase") or die ("Unable to Connect to the Database - PMSDB.");
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link href="CSS/TextStyles.css" rel="stylesheet" type="text/css" />
   
<title>.: PMS :. | Employee Details</title>
    
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
		
		.style3 {font-size: 14px; font-weight: bold; color: #003399; }
			-->
	</style>
    
    <link href="CSS/common.css" rel="stylesheet" type="text/css" />
</head>

<body onLoad="init()">

	<div id="loading" style="position:absolute; width:100px; text-align:center; top:180px; left: 180px; height: 20px;">
        <img alt=""  src="images/Wait.gif" border=0/>
    </div>

    <script language="javascript" type="text/javascript">
        var ld=(document.all);
        var ns4=document.layers;
        var ns6=document.getElementById&&!document.all;
        var ie4=document.all;
        if (ns4)
            ld=document.loading;
        else if (ns6)
            ld=document.getElementById("loading").style;
        else if (ie4)
            ld=document.all.loading.style;

        function init() {
            if(ns4){ld.visibility="hidden";}
            else if (ns6||ie4) ld.display="none";
        }

    </script>
    
    <script language="javascript" type="text/javascript">
		
		function EditEmployee(hlink){				
			document.forms[0].action = "EmployeeDet.php?Mode=Edit&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		function deleteEMPLOYEE($str_dbconnect,hlink){				
			document.forms[0].action = "EmployeeDet.php?Mode=Delete&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		function SaveEmployee(hlink){	
			
			document.forms[0].action = "EmployeeDet.php?Mode=Save&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		function popitup(hlink) {
			
			newwindow=window.open('EmpDetView.php?Mode=Edit&ID='+hlink+'','Agent Detail Viewer','height=400,width=760,top=200,left=200');
			
			if (window.focus) {newwindow.focus()}
			return false;
			
		}

		
		</script>
        
        <?php
	
		$_strEmpCODE 	= "";
		$_strEmpNIC 	= "";
		$_strADDRESS 	= "";
		$_strStreet 	= "";
		$_strCity		= "";
		$_strTitle 		= "";
		$_strFirstName 	= "";
		$_strLastName 	= "";
		$_strContactL 	= "";
		$_strContactM 	= "";
		$_strFaxNo 		= "";
		$_strEMail 		= "";
		$_strDesig 		= "";		
		$_strREADONLY	= "FALSE";
	
		if(isset($_GET["Mode"]) && isset($_GET["ID"])) { 
					
			if ($_GET["Mode"] == "Edit") {
				
				$_ResultSet = getSELECTEDEMPLOYEE($str_dbconnect,$_GET["ID"]);
				
				while($_myrowRes 	= mysqli_fetch_array($_ResultSet)) {
					$_strEmpCODE 	= $_myrowRes['EmpCode'];
					$_strEmpNIC 	= $_myrowRes['EmpNIC'];
					$_strADDRESS 	= $_myrowRes['Address1'];
					$_strStreet 	= $_myrowRes['Street'];
					$_strCity		= $_myrowRes['City'];
					$_strTitle 		= $_myrowRes['Title'];
					$_strFirstName 	= $_myrowRes['FirstName'];
					$_strLastName 	= $_myrowRes['LastName'];
					$_strContactL 	= $_myrowRes['ContactL'];
					$_strContactM 	= $_myrowRes['ContactM'];
					$_strFaxNo 		= $_myrowRes['FaxNo'];
					$_strEMail 		= $_myrowRes['EMail'];	
					$_strDesig		= $_myrowRes['DesCode'];							
					$_strREADONLY	= "TRUE";
				}	
				
			}
					
		}
	
		?>

	<form name="AgntDet" id="AgntDet" method="post">
        <table width="762" height="538" border="0" cellpadding="0" cellspacing="0" background="Images/BG.jpg" >         	
        	<td align="center" valign="top">
				<table>
                	  <td width="305" height="53" align="center" valign="middle"><span class="MenueNameFont">~ EMPLOYEE DETAILS ~</span></td>
                </table>	
                
            <Br />
            <Br/>    
            <table width="724" border="0" cellspacing="1" cellpadding="1">
<tr>
                    <td width="124" class="ContentStyle"><div align="left">Employee Code</div></td>
<td width="200">
                  <div align="left"><input name="txtEmpCode" type="text" class="TextStyle" id="txtEmpCode" size="15" readonly="readonly" value="<?php echo $_strEmpCODE; ?>"/></div>
                </td>
            <td width="10">&nbsp;</td>
            <td width="115">&nbsp;</td>
            <td width="259">&nbsp;</td>
              </tr>
                  <tr>
                    <td class="ContentStyle"><div align="left">Employee NIC</div></td>
                    <td>
                      <div align="left"><input name="txtNIC" type="text" class="TextStyle" id="txtNIC" size="25" value="<?php echo $_strEmpNIC; ?>"/></div>
                    </td>
                    <td>&nbsp;</td>
                    <td class="ContentStyle"><div align="left">Designation</div></td>
                    <td>
                    	<div align="left" >
                  	<select name="opt_Designation" id="opt_Designation" class="TextStyle" >
					<?php 
						
                        #	Get Designation details ...................
						$_ResultSet = getDESIGNATION($str_dbconnect) ;
                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    ?>                
                  		<option value="<?php echo $_myrowRes['DesCode']; ?>"  <?php if ($_myrowRes['DesCode'] == $_strDesig) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['Designation'] ; ?> </option>
                    
                  <?php } ?>
  	        </select>  	
                  </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="ContentStyle"><div align="left">Address #</div></td>
                    <td>
                      <div align="left"><input name="txtAdd1" type="text" class="TextStyle" id="txtAdd1" size="25" value="<?php echo $_strADDRESS; ?>"/></div>
                    </td>
                    <td>&nbsp;</td>
                    <td class="ContentStyle"><div align="left">Street</div></td>
                    <td><div align="left"><input name="txtStrt" type="text" class="TextStyle" id="txtStrt" size="25" value="<?php echo $_strStreet; ?>"/></div></td>
                  </tr>
                  <tr>
                    <td class="ContentStyle"><div align="left">City</div></td>
                    <td>
                      <div align="left"><input name="txtCity" type="text" class="TextStyle" id="txtCity" size="20" value="<?php echo $_strCity; ?>"/></div>
                   </td>
                    <td>&nbsp;</td>
                    <td class="ContentStyle"><div align="left">Title</div></td>
                    <td><div align="left">
                    	 <select name="optTitle" class="TextStyle" id="optTitle">
                         	<option id="Mr" <?php if ("Mr" == $_strTitle) echo "selected=\"selected\";" ?>>Mr</option>
                            <option id="Mis" <?php if ("Mis" == $_strTitle) echo "selected=\"selected\";" ?>>Mis</option>
                            <option id="Mrs" <?php if ("Mrs" == $_strTitle) echo "selected=\"selected\";" ?>>Mrs</option>
                            <option id="Dr" <?php if ("Dr" == $_strTitle) echo "selected=\"selected\";" ?>>Dr</option>
                         </select> </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="ContentStyle"><div align="left">First Name</div></td>
                    <td>
                      <div align="left"><input name="txtFstName" type="text" class="TextStyle" id="txtFstName" size="25" value="<?php echo $_strFirstName; ?>"/></div>
                    </td>
                    <td>&nbsp;</td>
                    <td class="ContentStyle"><div align="left">Last Name</div></td>
                    <td>
                      <div align="left"><input name="txtLstName" type="text" class="TextStyle" id="txtLstName" size="25" value="<?php echo $_strLastName; ?>"/></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="ContentStyle"><div align="left">Contact No ( L )</div></td>
                    <td>
                      <div align="left"><input name="txtCont1" type="text" class="TextStyle" id="txtCont1" size="10" value="<?php echo $_strContactL; ?>"/></div>
                    </td>
                    <td>&nbsp;</td>
                    <td class="ContentStyle"><div align="left">Contact No ( M )</div></td>
                    <td>
                      <div align="left"><input name="txtCont2" type="text" class="TextStyle" id="txtCont2" size="10" value="<?php echo $_strContactM; ?>"/></div>
                   </td>
                  </tr>
                  <tr>
                    <td class="ContentStyle"><div align="left">Fax</div></td>
                    <td>
                      <div align="left"><input name="txtFax" type="text" class="TextStyle" id="txtFax" size="10" value="<?php echo $_strFaxNo; ?>"/></div>
                    </td>
                    <td>&nbsp;</td>
                    <td class="ContentStyle"><div align="left">E-Mail</div></td>
                    <td>
                      <div align="left"><input name="txtEMail" type="text" class="TextStyle" id="txtEMail" size="30" value="<?php echo $_strEMail; ?>"/></div>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            <table width="289" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="139"><label>
           		    <div align="center">
               		    <input type="button" name="Cancel" id="Cancel" value="Close" class="buttonSml" onclick="javascript:window.close()"/>
       		          </div>
       		    </label></td>                
              </tr>
            </table>
   
            </td>            
        </table>
    </form>
    
</body>
</html>
