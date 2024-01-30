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
<link href="CSS/Employee.css" rel="stylesheet" type="text/css" />
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
.style3 {
	font-size: 14px;
	font-weight: bold;
	color: #003399;
}
-->
</style>
<link href="CSS/common.css" rel="stylesheet" type="text/css" />
</head>
<body onLoad="init()" background="Images/EmployeeBG.png">
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
		
			var Error = "False" ;
			
			if (document.getElementById("txtNIC").value == "" ) {		
				Error = "True" ;		
				document.getElementById("txtNIC").style.backgroundColor = "#ff9999" ;	
			}else{
				document.getElementById("txtNIC").style.backgroundColor = "" ;		
			}
			
			
			if (document.getElementById("txtAdd1").value == "" ) {	
				Error = "True" ;				
				document.getElementById("txtAdd1").style.backgroundColor = "#ff9999" ;	
			}
			
			if (document.getElementById("txtFstName").value == "" ) {
				Error = "True" ;					
				document.getElementById("txtFstName").style.backgroundColor = "#ff9999" ;	
			}
			/*
			if (document.getElementById("txtEMail").value == "" ) {
				Error = "True" ;					
				document.getElementById("txtEMail").style.backgroundColor = "#ff9999" ;	
			}else{
				document.getElementById("txtEMail").style.backgroundColor = "" ;	
			}*/
			
			// Contact 1 Validation ..................
			strng = document.getElementById("txtCont1").value ;
			
			if (strng != "") {			   	
				var stripped = strng; //strip out acceptable non-numeric characters
				if (isNaN(parseInt(stripped))) {
					Error = "True" ;					
					document.getElementById("txtCont1").style.backgroundColor = "#ff9999" ;				  
				}else {
					if (!(stripped.length == 10)) {
						Error = "True" ;					
						document.getElementById("txtCont1").style.backgroundColor = "#ff9999" ;
					} else {
						document.getElementById("txtCont1").style.backgroundColor = "" ;		
					}
				}
			}
			
			//****************************************************************************
			
			// Contact Mobile Validation ..................
			strng = document.getElementById("txtCont2").value ;
			
			if (strng != "") {			   	
				var stripped = strng; //strip out acceptable non-numeric characters
				if (isNaN(parseInt(stripped))) {
					Error = "True" ;					
					document.getElementById("txtCont2").style.backgroundColor = "#ff9999" ;				  
				}else {
					if (!(stripped.length == 10)) {
						Error = "True" ;					
						document.getElementById("txtCont2").style.backgroundColor = "#ff9999" ;
					} else {
						document.getElementById("txtCont2").style.backgroundColor = "" ;		
					}
				}
			}
			
			//****************************************************************************
			
			// Fax Validation ..................
			strng = document.getElementById("txtFax").value ;
			
			if (strng != "") {			   	
				var stripped = strng; //strip out acceptable non-numeric characters
				if (isNaN(parseInt(stripped))) {
					Error = "True" ;					
					document.getElementById("txtFax").style.backgroundColor = "#ff9999" ;				  
				}else {
					if (!(stripped.length == 10)) {
						Error = "True" ;					
						document.getElementById("txtFax").style.backgroundColor = "#ff9999" ;
					} else {
						document.getElementById("txtFax").style.backgroundColor = "" ;		
					}
				}
			}
			
			//****************************************************************************
			
			if (Error == "False"){			
				document.forms[0].action = "EmployeeDet.php?Mode=Save&ID="+hlink+"";
				document.forms[0].submit();
			}	
			
			
			
		}
		
		function Back(){				
			document.forms[0].action = "Menue.php";
			document.forms[0].submit();			
		}
		
		function popitup(hlink) {
			
			newwindow=window.open('EmpDetView.php?Mode=Edit&ID='+hlink+'','Agent Detail Viewer','height=400,width=760,top=200,left=200');
			
			if (window.focus) {newwindow.focus()}
			return false;
			
		}
		
		function NextRecord(Record){
			Record = parseFloat(Record) + 10 ;
			document.forms[0].action = "EmployeeDet.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function PreviousRecord(Record){
			Record = parseFloat(Record) - 10 ;
			document.forms[0].action = "EmployeeDet.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function LastRecord(Record){			
			document.forms[0].action = "EmployeeDet.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function FirstRecord(Record){
			Record = 0 ;
			document.forms[0].action = "EmployeeDet.php?Record="+Record+"";
			document.forms[0].submit();			
		}


		
		</script>
<div class="Div-EmployeeBG">
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
    <div class="Div-BackButton">
      <input type="image" title="Previous Menu" src="Images/BackNew.png" align="middle" width="32" height="32" onclick="Back();"/>
    </div>
    <Br />
    <Br/>
    <Br />
    <Br/>
    <table width="724" border="0" cellspacing="1" cellpadding="1" class="Div-TxtStyle" align="center">
      <tr>
        <td width="124" ><div align="left">Employee Code</div></td>
        <td width="200"><div align="left">
            <input name="txtEmpCode" type="text" class="Div-TxtStyle" id="txtEmpCode" size="15" readonly="readonly" value="<?php echo $_strEmpCODE; ?>"/>
          </div></td>
        <td width="10">&nbsp;</td>
        <td width="115">&nbsp;</td>
        <td width="259">&nbsp;</td>
      </tr>
      <tr>
        <td ><div align="left">Employee NIC</div></td>
        <td><div align="left">
            <input name="txtNIC" type="text" class="Div-TxtStyle" id="txtNIC" size="25" value="<?php echo $_strEmpNIC; ?>"/>
          </div></td>
        <td>&nbsp;</td>
        <td ><div align="left">Designation</div></td>
        <td><div align="left" >
            <select name="opt_Designation" id="opt_Designation" class="Div-TxtStyle" >
              <?php 
						
                        #	Get Designation details ...................
						$_ResultSet = getDESIGNATION($str_dbconnect) ;
                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                    ?>
              <option value="<?php echo $_myrowRes['DesCode']; ?>"  <?php if ($_myrowRes['DesCode'] == $_strDesig) echo "selected=\"selected\";" ?>> <?php echo $_myrowRes['Designation'] ; ?> </option>
              <?php } ?>
            </select>
          </div></td>
      </tr>
      <tr>
        <td ><div align="left">Address #</div></td>
        <td><div align="left">
            <input name="txtAdd1" type="text" class="Div-TxtStyle" id="txtAdd1" size="25" value="<?php echo $_strADDRESS; ?>"/>
          </div></td>
        <td>&nbsp;</td>
        <td ><div align="left">Street</div></td>
        <td><div align="left">
            <input name="txtStrt" type="text" class="Div-TxtStyle" id="txtStrt" size="25" value="<?php echo $_strStreet; ?>"/>
          </div></td>
      </tr>
      <tr>
        <td ><div align="left">City</div></td>
        <td><div align="left">
            <input name="txtCity" type="text" class="Div-TxtStyle" id="txtCity" size="20" value="<?php echo $_strCity; ?>"/>
          </div></td>
        <td>&nbsp;</td>
        <td ><div align="left">Title</div></td>
        <td><div align="left">
            <select name="optTitle" class="Div-TxtStyle" id="optTitle">
              <option id="Mr" <?php if ("Mr" == $_strTitle) echo "selected=\"selected\";" ?>>Mr</option>
              <option id="Mis" <?php if ("Mis" == $_strTitle) echo "selected=\"selected\";" ?>>Mis</option>
              <option id="Mrs" <?php if ("Mrs" == $_strTitle) echo "selected=\"selected\";" ?>>Mrs</option>
              <option id="Dr" <?php if ("Dr" == $_strTitle) echo "selected=\"selected\";" ?>>Dr</option>
            </select>
          </div></td>
      </tr>
      <tr>
        <td ><div align="left">First Name</div></td>
        <td><div align="left">
            <input name="txtFstName" type="text" class="Div-TxtStyle" id="txtFstName" size="25" value="<?php echo $_strFirstName; ?>"/>
          </div></td>
        <td>&nbsp;</td>
        <td ><div align="left">Last Name</div></td>
        <td><div align="left">
            <input name="txtLstName" type="text" class="Div-TxtStyle" id="txtLstName" size="25" value="<?php echo $_strLastName; ?>"/>
          </div></td>
      </tr>
      <tr>
        <td ><div align="left">Contact No ( L )</div></td>
        <td><div align="left">
            <input name="txtCont1" type="text" class="Div-TxtStyle" id="txtCont1" size="10" value="<?php echo $_strContactL; ?>"/>
          </div></td>
        <td>&nbsp;</td>
        <td ><div align="left">Contact No ( M )</div></td>
        <td><div align="left">
            <input name="txtCont2" type="text" class="Div-TxtStyle" id="txtCont2" size="10" value="<?php echo $_strContactM; ?>"/>
          </div></td>
      </tr>
      <tr>
        <td ><div align="left">Fax</div></td>
        <td><div align="left">
            <input name="txtFax" type="text" class="Div-TxtStyle" id="txtFax" size="10" value="<?php echo $_strFaxNo; ?>"/>
          </div></td>
        <td>&nbsp;</td>
        <td ><div align="left">E-Mail</div></td>
        <td><div align="left">
            <input name="txtEMail" type="text" class="Div-TxtStyle" id="txtEMail" size="30" value="<?php echo $_strEMail; ?>"/>
          </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <table width="289" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="139"><div align="right">
            <input type="button" name="Save" id="Save" value="Save" class="div-CmdSave" onclick="SaveEmployee('<?php echo $_strREADONLY; ?>');"/>
          </div></td>
        <td width="10">&nbsp;</td>
        <td width="140"><div align="left">
            <input type="button" name="Cancel" id="Cancel" value="Cancel" class="div-CmdSave"/>
          </div></td>
      </tr>
    </table>
    <?php					
					
		if(isset($_GET['Mode']) && isset($_GET['ID'])) {					
			
			if(($_GET['Mode'] == "Save") && ($_GET['ID'] == "FALSE")) {								
				
				#	Inserting Values to the Database by using the Function ................
				createEMPLOYEE($str_dbconnect,$_POST["txtNIC"], $_POST["txtAdd1"], $_POST["txtStrt"], $_POST["txtCity"], $_POST["optTitle"], $_POST["txtFstName"], $_POST["txtLstName"], $_POST["txtCont1"], $_POST["txtCont2"], $_POST["txtFax"], $_POST["txtEMail"], $_POST["opt_Designation"]);	
								
			}elseif (($_GET['Mode'] == "Save") && ($_GET['ID'] == "TRUE")){		
						
				updateEMPLOYEE($str_dbconnect,$_POST["txtEmpCode"], $_POST["txtNIC"], $_POST["txtAdd1"], $_POST["txtStrt"], $_POST["txtCity"], $_POST["optTitle"], $_POST["txtFstName"], $_POST["txtLstName"], $_POST["txtCont1"], $_POST["txtCont2"], $_POST["txtFax"], $_POST["txtEMail"], $_POST["opt_Designation"]);	
				
			}elseif($_GET['Mode'] == "Delete"){	
										
				deleteEMPLOYEE($str_dbconnect,$_GET['ID']);
				
			}
			
		}
				
	?>
    <?php
				
				$_RecordNumber = 0;					
				#	Quering the Master Category Details by using the Function.....................
				$_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
				$_CountSet 	= getEMPLOYEEDETAILS($str_dbconnect);
				$_Total 	= mysqli_num_rows($_CountSet);
				
				$_TotalRecords = (int)($_Total / 10 );  
				$_TotalRecords = $_TotalRecords * 10 ;
				
				if(isset($_GET["Record"]))  {		
					$_RecordNumber = $_GET["Record"] ;	
					
					if( $_Total == $_TotalRecords ) {
						$_TotalRecords = $_TotalRecords - 10 ;	
						
					}
					
				}										
		?>
    <BR>
    <table width="720" align="center">
      <tr>
        <td width="29" align="center" valign="middle"><input type="image" title="First Page" src="Icons/Previous record.png" align="middle" width="24" height="24" onclick="FirstRecord('<?php echo $_RecordNumber; ?>');" /></td>
        <td width="29" align="center" valign="middle"><input type="image" src="Icons/Playback.png" width="24" height="24" title="Previous Page" onclick="PreviousRecord('<?php echo $_RecordNumber; ?>');" <?php if (($_RecordNumber - 10 ) < 0) echo "disabled=\"disabled\";" ?> /></td>
        <td width="29" align="center" valign="middle">&nbsp;</td>
        <td width="24" align="center" valign="middle">&nbsp;</td>
        <td width="437" align="center" valign="middle"><div align="center" class="TableHeadings"><span class="DataTableHeading"></span></div>
          <div align="center"></div></td>
        <td width="32" align="center" valign="middle"></td>
        <td width="31" height="26" align="center" valign="middle"></td>
        <td width="31" align="center" valign="middle"><input type="image" src="Icons/Play.png" width="24" height="24" title="Next Page" onclick="NextRecord('<?php echo $_RecordNumber; ?>');" <?php if (($_RecordNumber + 10 ) > $_Total) echo "disabled=\"disabled\";" ?>/></td>
        <td width="38" align="center" valign="middle"><input type="image" src="Icons/Next track.png" width="24" height="24" /title="Last Page" onclick="LastRecord('<?php echo $_TotalRecords; ?>');"></td>
    </table>
    <table width="706" border="0" align="center" cellpadding="1" cellspacing="1" title="Master Category Browser" align="center" class="Div-TxtStyle">
    <tr>
      <td width="137" bgcolor="#999999"><div align="center" ><b>Employee Code</b></div></td>
      <td width="193" bgcolor="#999999"><div align="center" ><b>First Name</b></div></td>
      <td width="296" bgcolor="#999999"><div align="center" ><b>Last Name</b></div></td>
      <td width="32" bgcolor="#999999"><div align="center" ><b>V</b></div></td>
      <td width="32" bgcolor="#999999"><div align="center" ><b>E</b></div></td>
      <td width="32" bgcolor="#999999"><div align="center" ><b>D</b></div></td>
    </tr>
    <?php	
			  	$_RecordCounter	= 0;
				$_RecordPoss 	= 0;
			  	$code = 0 ;
			  	while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
					if ($code == 0 ) {
						$Color = "#e9edf8" ;
						$code = 1 ;
					} elseif ($code == 1 ) {
						$Color = "#CCCCCC";
						$code = 0 ;
					}
					
					$_RecordCounter = $_RecordCounter + 1 ;
					
					if ( $_RecordCounter > $_RecordNumber &&  $_RecordCounter <= ($_RecordNumber + 10) ) { 
				
			   ?>
    <tr onmousemove="this.bgColor='#b9d7ff'" onmouseout="this.bgColor='<?php echo $Color ; ?>'" bgcolor="<?php echo $Color ; ?>">
      <td width="137" ><div align="left">
          <?php 
							$EmpCode = $_myrowRes['EmpCode'];
							echo	$_myrowRes["EmpCode"]; ?>
        </div></td>
      <td width="193" ><div align="left"> <?php echo	$_myrowRes["Title"]. " " .$_myrowRes["FirstName"] ;		?> </div></td>
      <td width="296" ><div align="left"> <?php echo	$_myrowRes["LastName"] ;		?> </div></td>
      <?php 
					$_setname = $_myrowRes["EmpCode"];
					echo "<td width='32' ><div align='center'><input type='image' src='Icons/View.png' width='12' height='12' name='Edit' id='Edit' onclick='return popitup(\"$EmpCode\")' /></td>" ; 
					echo "<td width='32' ><div align='center'><input type='image' src='Icons/Update.png' width='12' height='12' name='Edit' id='Edit' onclick='EditEmployee(\"$EmpCode\")' /></td>" ;  
                    echo "<td width='32' ><div align='center'><input type='image' src='Icons/Erase.png' width='12' height='12' name='Edit' id='Edit' onclick='deleteEMPLOYEE($str_dbconnect,\"$EmpCode\")' /></td>" ; ?>
    </tr>
    <?php }	
				}
				?>
    </table>
    <!-- End of Mother Table --------------------------------------------------->
  </form>
</div>
</body>
</html>
