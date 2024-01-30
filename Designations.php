<?php

	session_start();
	
	if(!isset($_SESSION["UserCode"]) || !isset($_SESSION["UserName"])) {
		header("Location:index.php");	
	}
	
	# File Name 	: Designations.php
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
<link href="CSS/common.css" rel="stylesheet" type="text/css" />
<link href="CSS/Designation.css" rel="stylesheet" type="text/css" />
<title>,:PMS:. | Employee Designations</title>
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
		
		function EditDesignation(hlink){				
			document.forms[0].action = "Designations.php?Mode=Edit&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		function deleteDESIGNATION($str_dbconnect,hlink){				
			document.forms[0].action = "Designations.php?Mode=Delete&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		function SaveDesignation(hlink){	
			
			document.forms[0].action = "Designations.php?Mode=Save&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		
		
	</script>
</head>
<body onLoad="init()" background="Images/DesignationBG.png">
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
    <script type="text/javascript">
		function Back(){
			document.forms[0].action = "Menue.php";
			document.forms[0].submit();			
		}
		
		function NextRecord(Record){
			Record = parseFloat(Record) + 10 ;
			document.forms[0].action = "Designations.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function PreviousRecord(Record){
			Record = parseFloat(Record) - 10 ;
			document.forms[0].action = "Designations.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function LastRecord(Record){			
			document.forms[0].action = "Designations.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function FirstRecord(Record){
			Record = 0 ;
			document.forms[0].action = "Designations.php?Record="+Record+"";
			document.forms[0].submit();			
		}		
	</script>
<div class="Div-DesignationBG">
  <?php
	
		$_strDESCODE 			= "";
		$_strDESIGNATION 		= "";
		$_strTASK 				= "";
		$_strREADONLY			= "FALSE";
	
		if(isset($_GET["Mode"]) && isset($_GET["ID"])) { 
					
			if ($_GET["Mode"] == "Edit") {
				
				$_ResultSet = getSELECTEDDESIGNATION($str_dbconnect,$_GET["ID"]);
				
				while($_myrowRes 		= mysqli_fetch_array($_ResultSet)) {
					$_strDESCODE 		= $_myrowRes['DesCode'];
					$_strDESIGNATION 	= $_myrowRes['Designation'];
					$_strTASK 			= $_myrowRes['Task'];
					$_strREADONLY		= "TRUE";
				}	
				
			}
					
		}
	
	?>
  <form name="Designation" id="Designation" method="post">
    <div class="Div-BackButton">
      <input type="image" title="Previous Menu" src="Images/BackNew.png" align="middle" width="32" height="32" onclick="Back();"/>
    </div>
    <div class="Div-McatList"> Designation Code </div>
    <div class="Div-lstMcatCode">
      <input name="txtDESCODE" type="text" class="Div-TxtStyle" id="txtDESCODE" size="20" value="<?php echo $_strDESCODE; ?>" <?php if($_strREADONLY == "TRUE") echo "readonly = \"readonly\";" ?> />
    </div>
    <div class="Div-ScatCodeText"> Designation </div>
    <div class="Div-ScatCodeList">
      <input name="txtDESIGNATION" type="text" class="Div-TxtStyle" id="txtDESIGNATION" size="40" value="<?php echo $_strDESIGNATION; ?>"/>
    </div>
    <div class="Div-Task"> Task </div>
    <div class="Div-txtTask">
      <input name="txtTASK" type="text" class="Div-TxtStyle" id="txtTASK" size="40" value="<?php echo $_strTASK; ?>"/>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />  
    <br />
    <table width="437" height="31">
      <tr>
        <td width="301" align="center" valign="middle"><div align="right">
            <input name="Save" type="button" class="div-CmdSave" id="Save" value="Save" onclick="SaveDesignation('<?php echo $_strREADONLY; ?>');" />
          </div></td>
        <td width="124"><div align="left">
            <input name="Clear" type="reset" class="div-CmdSave" id="Clear" value="Clear" />
          </div></td>
      </tr>
    </table>
    
    <br />
    <?php
						
					
				if(isset($_GET['Mode']) && isset($_GET['ID'])) {					
					
					if(($_GET['Mode'] == "Save") && ($_GET['ID'] == "FALSE")) {								
						
						#	Inserting Values to the Database by using the Function ................
						createDESIGNATION ($_POST["txtDESCODE"], $_POST["txtDESIGNATION"], $_POST["txtTASK"]);	
										
					}elseif (($_GET['Mode'] == "Save") && ($_GET['ID'] == "TRUE")){		
								
						updateDESIGNATION ($_POST["txtDESCODE"], $_POST["txtDESIGNATION"], $_POST["txtTASK"]);
						
					}elseif($_GET['Mode'] == "Delete"){	
									
						deleteDESIGNATION ($_GET['ID']);
						
					}
					
				}
				
			?>
    <?php
				$_RecordNumber = 0;				
				#	Quering the Master Category Details by using the Function.....................
				$_ResultSet = getDESIGNATION($str_dbconnect);
				$_CountSet 	= getDESIGNATION($str_dbconnect);
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
    <table width="706" border="0" align="center" cellpadding="1" cellspacing="1" title="Master Category Browser" class="Div-Text">
      <tr>
        <td width="137" bgcolor="#999999"><div align="center"><b>Designation Code</b></div></td>
        <td width="193" bgcolor="#999999"><div align="center"><b>Designation</b></div></td>
        <td width="296" bgcolor="#999999"><div align="center"><b>Task</b></div></td>
        <td width="32" bgcolor="#999999"><div align="center"><b>E</b></div></td>
        <td width="32" bgcolor="#999999"><div align="center"><b>D</b></div></td>
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
        <td width="137"  class="TextStyle" ><div align="left">
            <?php 
							$Designation = $_myrowRes['DesCode'];
							echo	$_myrowRes["DesCode"]; ?>
          </div></td>
        <td width="193" ><div align="left"> <?php echo	$_myrowRes["Designation"];		?> </div></td>
        <td width="296" ><div align="left"> <?php echo	$_myrowRes["Task"];		?> </div></td>
        <?php 
					$_setname = $_myrowRes["DesCode"];
					echo "<td width='32' ><div align='center'><input type='image' src='Icons/Update.png' width='12' height='12' name='Edit' id='Edit' onclick='EditDesignation(\"$Designation\")' /></td>" ;  
                    echo "<td width='32' ><div align='center'><input type='image' src='Icons/Erase.png' width='12' height='12' name='Edit' id='Edit' onclick='deleteDESIGNATION($str_dbconnect,\"$Designation\")' /></td>" ; ?>
      </tr>
      <?php }	
				}?>
    </table>
  </form>
</div>
</body>
</html>
