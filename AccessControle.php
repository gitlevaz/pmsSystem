<?php
	
	# File Name 	: UserFacility.php
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
<link href="CSS/AccCtrl.css" rel="stylesheet" type="text/css" />

    <!-- **************** JQUERRY ****************** -->
    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />

    <script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>

	<script src="ui/jquery.ui.button.js"></script>

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

    <style type="text/css">
        body { font-size: 70%; font-family: "Lucida Sans" }
        label { display: inline-block; width: 200px; }
        legend { padding: 0.5em; }
        fieldset fieldset label { display: block; }
        #commentForm { width: 500px; }
        #commentForm label { width: 250px; }
        #commentForm label.error, #commentForm button.submit { margin-left: 253px; }
        #signupForm { width: 670px; }
        #signupForm label.error {
            margin-left: 10px;
            width: auto;
            display: inline;
        }
        #newsletter_topics label.error {
            display: none;
            margin-left: 103px;
        }

    </style>
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
					
				document.forms[0].action = "AccessControle.php?Mode=Delete&GRPCODE="+GRPCODE+"&Access="+Access+"";
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
				
				document.forms[0].action = "AccessControle.php?Mode=Save&GRPCODE="+GRPCODE+"&Access="+Access+"";
				document.forms[0].submit();
			}
			
		}
		
		function ChangeTask(){	
		
			GRPCODE = document.getElementById('opt_Groups').value ;
			
			document.forms[0].action = "AccessControle.php?Mode=Chg&GRPCODE="+GRPCODE+"";
			document.forms[0].submit();
			
		}
		
	</script>
</head>
<body onLoad="init()" >
<!--
	<div id="loading" style="position:absolute; width:75%; text-align:center; top:225px;">
	<img src="Images/loading.gif" border=0 ></div>	-->
<script language="javascript" type="text/javascript">
		
		function Back(){
			document.forms[0].action = "Menue.php";
			document.forms[0].submit();			
		}		
		
	</script>
    
    <div class="Div-SysUserAccBG"> 
    
<?php	
		
		$_GRPCODE 		= "";
		
		if(isset($_GET["Mode"]) && isset($_GET["GRPCODE"])) { 
					
			if ($_GET["Mode"] == "Save") {				
				createAccess($str_dbconnect,$_GET["GRPCODE"], $_GET["Access"] ) ;					
			}		
			
			if ($_GET["Mode"] == "Delete") {				
				deleteAccess($str_dbconnect,$_GET["GRPCODE"], $_GET["Access"] ) ;					
			}		
					
		}
		
		#$_FAC			=	"PAO" ;
		
		
		if (isset($_GET["GRPCODE"])) {
		
			$_GRPCODE			=	$_GET["GRPCODE"] ;
		
		}
		
		$_GROUPSETINGS 	= getACCESSPOINTS($str_dbconnect,$_GRPCODE);					
		$_ACCESSPOINTS 	= getACCESSBYGROUP($str_dbconnect,$_GRPCODE);
		
		if(isset($_GET["Mode"]) && isset($_GET["GRPCODE"])) { 
			if ($_GET["Mode"] == "Chg") {	
				
					$_GRPCODE			= $_GET["GRPCODE"] ;			
					$_GROUPSETINGS 		= getACCESSPOINTS($str_dbconnect,$_GRPCODE);					
					$_ACCESSPOINTS 		= getACCESSBYGROUP($str_dbconnect,$_GRPCODE);							
					
			}
		}
	?>
<form name="Designation" id="Designation" method="post">

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
  		
        <div class="Div-BackButton"> 
       	  <input type="image" title="Previous Menu" src="Images/BackNew.png" align="middle" width="32" height="32" onclick="Back();"/>
		</div>
        
        <br />
        <br />
        <table width="565" border="0" align="center" cellpadding="1" cellspacing="1" class="Div-TxtStyle">
          <tr>
            <td width="234" height="46" class="ContentStyle"><div align="left"></div></td>
            <td width="50">&nbsp;</td>
            <td colspan="2"><div align="left"></div></td>
            <td width="16">&nbsp;</td>
          </tr>
          <tr>
            <td ><div align="right">User Group</div></td>
            <td>&nbsp;</td>
            <td colspan="2"><div align="left">
                <select name="opt_Groups" id="opt_Groups" class="Div-TxtStyle" <?php if($_strREADONLY == "TRUE") echo "disabled=\"disabled\";" ?> >
                    
					<?php 
					
						$_ResultSet = getGROUP($str_dbconnect) ;
						
                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
						
                    ?>       
                    	          
                  		<option value="<?php echo $_myrowRes['GrpCode']; ?>"  <?php if ($_myrowRes['GrpCode'] == $_GRPCODE) echo "selected=\"selected\";" ?> onclick="ChangeTask()" > <?php echo $_myrowRes['GrpCode'] . " - " . $_myrowRes['Group'] ; ?> 
                        </option>
                    
                  <?php } ?>
  	        			</select>
              </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td ><div align="center">Access Points</div></td>
            <td>&nbsp;</td>
            <td colspan="2"><div align="left" >
                <div align="center">Allowed Access Points</div>
              </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4" valign="top"><div align="right">
                <select name="lstAccessPoints" size="15" class="Div-TxtStyle" id="lstAccessPoints" style="width:200px">
                  <?php 						
							#	Get Designation details ...................
							
							while($_myrowRes = mysqli_fetch_array($_ACCESSPOINTS)) {
                    	?>
                  <option value="<?php echo $_myrowRes['Acccode']; ?>" > <?php echo $_myrowRes['Description'];?> </option>
                  <?php } ?>
                </select>
              </div></td>
            <td height="43"><div align="center"></div></td>
            <td colspan="2" rowspan="4" valign="top"><div align="left">
                <select name="lstAccessGrant" size="15" class="Div-TxtStyle" id="lstAccessGrant" style="width:200px">
                  <?php 						
							#	Get Designation details ...................
							#$_ResultSet = getUSERSBYFAC($str_dbconnect) ;
							
							while($_myrowRes = mysqli_fetch_array($_GROUPSETINGS)) {
                    	?>
                  <option value="<?php echo $_myrowRes['AccPoint']; ?>" > <?php echo $_myrowRes['Description'];?> </option>
                  <?php } ?>
                </select>
              </div></td>
            <td rowspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td height="40"><div align="center">
                <input name="Save" type="button" class="div-CmdSave" id="Save" value="&gt;" onclick="SaveFac('<?php echo $_GRPCODE; ?>');" />
              </div></td>
          </tr>
          <tr>
            <td height="40"><div align="center">
                <input name="Del" type="button" class="div-CmdSave" id="Del" value="&lt;" onclick="DeleteFac('<?php echo $_GRPCODE; ?>');" />
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
        <br />
        <br />
      </td>
  </table>
</form>
</div>
</body>
</html>
