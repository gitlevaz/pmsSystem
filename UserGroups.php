<?php
	
	session_start();
	
	if(!isset($_SESSION["UserCode"]) || !isset($_SESSION["UserName"])) {
            header("Location:index.php");
	}
	
	# File Name 	: UserGroups.php
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
<link href="CSS/UserGroups.css" rel="stylesheet" type="text/css" />
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
		
		function EditGroup(hlink){				
			document.forms[0].action = "UserGroups.php?Mode=Edit&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		function deleteGROUP($str_dbconnect,hlink){				
			document.forms[0].action = "UserGroups.php?Mode=Delete&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
		function SaveGroup(hlink){	
			
			document.forms[0].action = "UserGroups.php?Mode=Save&ID="+hlink+"";
			document.forms[0].submit();
			
		}
		
	</script>
</head>
<body onLoad="init()" background="Images/SysUserGrpBG.png">

<script language="javascript" type="text/javascript">
		
		function Back(){
			document.forms[0].action = "Menue.php";
			document.forms[0].submit();			
		}	
		
		function NextRecord(Record){
			Record = parseFloat(Record) + 10 ;
			document.forms[0].action = "UserGroups.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function PreviousRecord(Record){
			Record = parseFloat(Record) - 10 ;
			document.forms[0].action = "UserGroups.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function LastRecord(Record){			
			document.forms[0].action = "UserGroups.php?Record="+Record+"";
			document.forms[0].submit();			
		}
		
		function FirstRecord(Record){
			Record = 0 ;
			document.forms[0].action = "UserGroups.php?Record="+Record+"";
			document.forms[0].submit();			
		}	
			
	</script>
    
    <div class="Div-SysUserGrpBG"> 
<?php
	
		$_strGRPCODE        = "";
		$_strGROUP          = "";
		$_strDESCRIPTION    = "";
		$_strREADONLY       = "FALSE";
	
		if(isset($_GET["Mode"]) && isset($_GET["ID"])) { 
					
			if ($_GET["Mode"] == "Edit") {
				
				$_ResultSet = getSELECTEDGROUP($str_dbconnect,$_GET["ID"]);
				
				while($_myrowRes 		= mysqli_fetch_array($_ResultSet)) {
					$_strGRPCODE 		= $_myrowRes['GrpCode'];
					$_strGROUP              = $_myrowRes['Group'];
					$_strDESCRIPTION 	= $_myrowRes['Task'];
					$_strREADONLY		= "TRUE";
				}	
				
			}
					
		}
	
	?>
<form name="Designation" id="Designation" method="post">

    <div id="loading" style="position:absolute; width:100px; text-align:center; top:180px; left: 280px; height: 20px;">
        <img alt=""  src="images/Wait.gif" border=0/>
    </div>

    <script type="text/javascript">
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
    </script>

    <script language="javascript" type="text/javascript">
        function init() {
            if(ns4){ld.visibility="hidden";}
            else if (ns6||ie4) ld.display="none";
        }
    </script>
	
    <div class="Div-BackButton"> 
       	  <input type="image" title="Previous Menu" src="Images/BackNew.png" align="middle" width="32" height="32" onclick="Back();"/>
	</div>
    
	<div class="Div-McatList">Group Code</div>
    
    <div class="Div-lstMcatCode">
    	<input name="txtGRPCODE" type="text" class="Div-Text" id="txtGRPCODE" size="20" value="<?php echo $_strGRPCODE; ?>" <?php if($_strREADONLY == "TRUE") echo "readonly = \"readonly\";" ?> />
    </div>
    
    <div class="Div-ScatCodeText">Designation</div>
    
    <div class="Div-ScatCodeList">
    	<input name="txtGROUP" type="text" class="Div-Text" id="txtGROUP" size="40" value="<?php echo $_strGROUP; ?>"/>
    </div>
    
    <div class="Div-Task">Task</div>
    
    <div class="Div-txtTask">
    	<input name="txtTASK" type="text" class="Div-Text" id="txtTASK" size="40" value="<?php echo $_strDESCRIPTION; ?>"/>
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
        <td width="295" align="center" valign="middle"><div align="right">
              <input name="Save" type="button" class="div-CmdSave" id="Save" value="Save" onclick="SaveGroup('<?php echo $_strREADONLY; ?>');" />
            </div></td>
    <td width="130"><div align="left">
              <input name="Clear" type="reset" class="div-CmdSave" id="Clear" value="Clear" />
            </div></td>
      </tr>
    </table>
<!--
  <table width="762" height="630" border="0" cellpadding="0" cellspacing="0" background="Images/BG.jpg" >
  <td align="center" valign="top"><table width="720">
        <tr>
          <td width="29" align="center" valign="middle"><input type="image" title="Previous Menu" src="Icons/Back.png" align="middle" width="24" height="24" onclick="Back();"/></td>
          <td width="29" align="center" valign="middle">&nbsp;</td>
          <td width="29" align="center" valign="middle">&nbsp;</td>
          <td width="24" align="center" valign="middle">&nbsp;</td>
          <td width="437" align="center" valign="middle"><div align="center"><span class="MenueNameFont">~ USER ACCESS GROUP DETAILS ~</span></div>
            <div align="center"></div></td>
          <td width="32" align="center" valign="middle"></td>
          <td width="31" height="53" align="center" valign="middle"></td>
          <td width="31" align="center" valign="middle"></td>
          <td width="38" align="center" valign="middle">&nbsp;</td>
      </table>
      <table width="524" border="0" align="center" cellpadding="1" cellspacing="1" >
        <tr>
          <td width="140" class="ContentStyle"><div align="left">Group Code</div></td>
          <td width="9">&nbsp;</td>
          <td colspan="2"><label>
            <div align="left">
              <input name="txtGRPCODE" type="text" class="TextStyle" id="txtGRPCODE" size="20" value="<?php echo $_strGRPCODE; ?>" <?php if($_strREADONLY == "TRUE") echo "readonly = \"readonly\";" ?> />
            </div>
            </label></td>
          <td width="14">&nbsp;</td>
        </tr>
        <tr>
          <td class="ContentStyle"><div align="left">Designation</div></td>
          <td>&nbsp;</td>
          <td colspan="2"><div align="left">
              <input name="txtGROUP" type="text" class="TextStyle" id="txtGROUP" size="40" value="<?php echo $_strGROUP; ?>"/>
            </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="ContentStyle"><div align="left">Task</div></td>
          <td>&nbsp;</td>
          <td colspan="2"><div align="left">
              <input name="txtTASK" type="text" class="TextStyle" id="txtTASK" size="40" value="<?php echo $_strDESCRIPTION; ?>"/>
            </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="25">&nbsp;</td>
          <td>&nbsp;</td>
          <td width="157" align="center" valign="middle"><div align="right">
              <input name="Save" type="button" class="buttonSml" id="Save" value="Save" onclick="SaveGroup('<?php echo $_strREADONLY; ?>');" />
            </div></td>
          <td width="188"><div align="left">
              <input name="Clear" type="reset" class="buttonSml" id="Clear" value="Clear" />
            </div></td>
          <td></td>
        </tr>
      </table>
      
      -->
      <br />
      <?php
						
					
				if(isset($_GET['Mode']) && isset($_GET['ID'])) {					
					
					if(($_GET['Mode'] == "Save") && ($_GET['ID'] == "FALSE")) {								
						
						#	Inserting Values to the Database by using the Function ................
						createGROUP ($_POST["txtGRPCODE"], $_POST["txtGROUP"], $_POST["txtTASK"]);	
										
					}elseif (($_GET['Mode'] == "Save") && ($_GET['ID'] == "TRUE")){		
								
						updateGROUP ($_POST["txtGRPCODE"], $_POST["txtGROUP"], $_POST["txtTASK"]);
						
					}elseif($_GET['Mode'] == "Delete"){	
									
						deleteGROUP ($_GET['ID']);
						
					}
					
				}
				
			?>
      <?php
				$_RecordNumber = 0;			
				#	Quering the Master Category Details by using the Function.....................
				$_ResultSet = getGROUP($str_dbconnect);
				$_CountSet 	= getGROUP($str_dbconnect);
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
          <td width="137" bgcolor="#999999"><div align="center" ><b>Group Code</b></div></td>
          <td width="193" bgcolor="#999999"><div align="center" ><b>Group</b></div></td>
          <td width="296" bgcolor="#999999"><div align="center" ><b>Task</b></div></td>
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
          <td width="137"><div align="left">
              <?php 
							$Group = $_myrowRes['GrpCode'];
							echo	$_myrowRes["GrpCode"]; ?>
            </div></td>
          <td width="193" ><div align="left"> <?php echo	$_myrowRes["Group"];		?> </div></td>
          <td width="296" ><div align="left"> <?php echo	$_myrowRes["Task"];		?> </div></td>
          <?php 
					$_setname = $_myrowRes["GrpCode"];
					echo "<td width='32' ><div align='center'><input type='image' src='Icons/Update.png' width='12' height='12' name='Edit' id='Edit' onclick='EditGroup(\"$Group\")' /></td>" ;  
                    echo "<td width='32' ><div align='center'><input type='image' src='Icons/Erase.png' width='12' height='12' name='Edit' id='Edit' onclick='deleteGROUP($str_dbconnect,\"$Group\")' /></td>" ; ?>
        </tr>
        <?php }
				}	?>
      </table>
</form>
</div>
</body>
</html>
