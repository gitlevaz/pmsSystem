<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Transfer Work Flow
 * Last Update      :   06/10/2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
include ("../class/accesscontrole.php"); //  sql commands for the access controles
include ("../class/sql_empdetails.php"); //  connection file to the mysql database
include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
include ("../class/sql_wkflow.php");            //  connection file to the mysql database

//require_once("../class/class.phpmailer.php");

#include ("../class/MailBodyOne.php"); //  connection file to the mysql database

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS - TRANSFER WORK FLOW ::.</title>
    
    <link href="../css/styleB.css" rel="stylesheet" type="text/css" />
    
    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    
    <script type="text/javascript" src="../jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>    
    
  
    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />
	
	<script type="text/javascript" src="jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>
	<link rel="stylesheet" href="jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />
        
<!--    <script src="../ui/jquery.ui.core.js"></script>
    <script src="../ui/jquery.ui.widget.js"></script>-->
   
     <!--**************** NEW GRID ***************** -->
 
    
    <style type="text/css" title="currentStyle">
            @import "../media/css/demo_page.css";
            @import "../media/css/demo_table.css";
    </style>
   
    <script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>

    <!-- **************** NEW GRID END ***************** -->
    
    <!-- ************ FILE UPLOAD ********* -->

    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
   <!-- <script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>-->
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>
    <script type="text/javascript" src="../js/jquery.leanModal.min.js"></script>

    <!-- ****************END***************** -->
   
    
    <script>
		$(function() {
	            $( "input:submit", ".demo" ).button();
	            $( "input:button", ".demo" ).button();
		});
	        
	    $(document).ready(function() {
	        $('#example').dataTable();
	    } );
        
		
       function getworkflowOwner(){           
		 	ownerid = document.getElementById('cmbOwner').value;				 	
            $.post('../class/sql_getTransferWorkflow.php',{empdata : ownerid},			
                function(output){ 						                 
                    $('#ownertasks').html(output);
					//refreshList();
                }
            )            
        }
		
		function getworkflowEmp(){           
		 	empid = document.getElementById('cmbEmp').value;
            $.post('../class/sql_getTransferWorkflow.php',{empeedata : empid},			
                function(output){ 						                 
                    $('#emptasks').html(output);
					//refreshList();
                }
            )            
        }
		
		function Copy_to_Employee(){
			ownerid = document.getElementById('cmbOwner').value;
			empid = document.getElementById('cmbEmp').value;
			$('#ownertasks input[type=checkbox]:checked').each(function() {
				currentVal  = $(this).val();
				$.post('../class/sql_getTransferWorkflow.php',{copycheck : currentVal , oownerdata1 : ownerid , eempdata1 : empid}).done(function() {
					$.post('../class/sql_getTransferWorkflow.php',{eempdata22 : empid},
					function(output){
						$('#emptasks').html(output);
					})
					
					$.post('../class/sql_getTransferWorkflow.php',{ownerdata22 : ownerid},
					function(output){
						$('#ownertasks').html(output);
					}) 
				})		
			});
		}
		
		function Move_to_Employee(){   
          
			ownerid = document.getElementById('cmbOwner').value;
			empid = document.getElementById('cmbEmp').value;
           $('#ownertasks input[type=checkbox]:checked').each(function() {
				 currentVal  = $(this).val();
				 $.post('../class/sql_getTransferWorkflow.php',{delcheck : currentVal , ownerdata1 : ownerid , empdata1 : empid})			
				});
			$.post('../class/sql_getTransferWorkflow.php',{mworkflowdata1 : empid},			
                function(output){ 						                 
                    $('#emptasks').html(output);
                }
            ) 
			$.post('../class/sql_getTransferWorkflow.php',{ownerdata22 : ownerid},			
                function(output){ 						                 
                    $('#ownertasks').html(output);				 
                }
            ) 
        }
		
		function Copy_Owner(){
			ownerid = document.getElementById('cmbOwner').value;
			empid = document.getElementById('cmbEmp').value;
			
			$('#emptasks input[type=checkbox]:checked').each(function() {
				currentVal  = $(this).val();
				$.post('../class/sql_getTransferWorkflow.php',{copycheckowner : currentVal , odata1 : ownerid , edata1 : empid}).done(function() {
					$.post('../class/sql_getTransferWorkflow.php',{ownerdata22 : ownerid},
					function(output){
						$('#ownertasks').html(output);
					})
					$.post('../class/sql_getTransferWorkflow.php',{checkmoveownerdata : empid},
					function(output){
						$('#emptasks').html(output);
					}) 
				 }) 
		    });
		}
		
		function Move_to_Owner(){   
           
			ownerid = document.getElementById('cmbOwner').value;
			empid = document.getElementById('cmbEmp').value;
           
		   $('#emptasks input[type=checkbox]:checked').each(function() {
				 currentVal  = $(this).val();
				 $.post('../class/sql_getTransferWorkflow.php',{delcheckowner : currentVal , owdata1 : ownerid , epdata1 : empid})			
				});
		   
			$.post('../class/sql_getTransferWorkflow.php',{ownerdata22 : ownerid},			
                function(output){ 						                 
                    $('#ownertasks').html(output);				 
                }
            ) 
			$.post('../class/sql_getTransferWorkflow.php',{checkmoveownerdata : empid},			
                function(output){ 						                 
                    $('#emptasks').html(output);
                }
            ) 
        }
		
  </script>
    
 
    
</head>
    <body>     
        <?php
        $_SESSION["path"] = "../";
$path = "../";
$Menue	= "TransWF";
        ?>
        
        
<form id="frm_TransferWorkFlow" name="frm_TransferWorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">
                <div id="wrapper">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2" style="width: 100%;">
                                <div id="header">                                    
                                    <!--Header-->
                                    <?php include('../Header.php'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <!--border-left: 2px solid #063794; border-right: 2px solid #063794-->
                            <td style="width: 220px; height: auto; background-color: #599b83" align="left" valign="top" id="leftBottom">
                                <div id="left" style="background-color: transparent">                                   
                                    <div id="leftTop">                                        
                                        <div class="menu" id="MenuListNav">
                                            <?php include('../Menu.php'); ?>
                                        </div>
                                    </div>
                                </div> 
                            </td>
                            <td align="left" style="width: 100%; vertical-align: top;">
                                <div id="right" >
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr style="height: 50px; background-color: #E0E0E0;">
                                            <td style="padding-left: 10px; font-size: 16px">
                                                <font color="#0066FF">Transfer Work Flow</font>                                              
                                            </td>                                            
                                        </tr>    
                                        <tr align="center">
                                                                                         
                                        </tr>
                                    </table>
                                    <br></br>                                            
                                     <table width="100%" cellpadding="0" cellspacing="8px">        
                                         <tr align="left" >
                                                        <td width="08%" align="left">
                                                            Transfer From
                                                        </td>
                                                        <td width="2%" >
                                                            :
                                                        </td>                                                        
                                                        <td align="left" width="28%" >
                                                            <select id="cmbOwner" name="cmbOwner" class="TextBoxStyle" onchange="getworkflowOwner()">
                                                                <?php
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  > <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td width="05%">
                                                        <td width="08%" align="left">
                                                            Transfer To
                                                        </td>
                                                        <td width="2%" >
                                                            :
                                                        </td>
                                                        <td align="left" width="28%" >
                                                            <select id="cmbEmp" name="cmbEmp" class="TextBoxStyle" onchange="getworkflowEmp()">
                                                                <?php
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['EmpCode']; ?>" > <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr> 
                                                    <tr height="12px"></tr>                                               
                                                    <tr>
                                                        <td align="left" width="08%"></td>
                                                        <td width="02%" ></td>
                                                        <td align="left" width="28%" style="vertical-align:top"> 
                                                            <div  id="ownertasks" style="width:90%">
                                                 				<!--<select name="ownertasks" size="15" class="" id="ownertasks" style="width:275px" >
                                                                    <option></option>                                
                                                                </select> -->
                                                            </div>
														</td>
                                                        <td width="05%" >                                                                
                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input name="Copy_to_Selected_Employee" title="Copy to Selected Employee"  type="button" class='buttonView' id="Copy_to_Selected_Employee" value=" Copy   >" style="cursor: pointer" onclick="Copy_to_Employee()"/>                                           
                                                                </td>                                            
                                                            </tr>
                                                            <tr height="7px"></tr>
                                                            <tr>
                                                                <td ><input name="Move_to_Selected_Employee" title="Move to Selected Employee"  type="button" class='buttonView'  id="Move_to_Selected_Employee" value="Move   >>" style="cursor: pointer" onclick="Move_to_Employee()"/>                                           
                                                                </td>                                            
                                                            </tr>
                                                            <tr height="7px"></tr>
                                                            <tr>
                                                                <td ><input name="Copy_to_Owner" title="Copy to Owner"  type="button" class='buttonView'  id="Copy_to_Owner" value="<   Copy" style="cursor: pointer" onclick="Copy_Owner()"/>                                           
                                                                </td>                                            
                                                            </tr>
                                                            <tr height="7px"></tr>
                                                            <tr>
                                                                <td ><input name="Move_Back_to_Owner" title="Move Back to Owner"  type="button" class="buttonView"   id="Move_Back_to_Owner" value="<<   Move" style="cursor: pointer" onclick="Move_to_Owner()"  />                                           
                                                                </td>                                            
                                                            </tr>
                                                            
                           								 </table>
                                  						</td>
                                                        <td align="left" width="08%"></td>
                                                        <td width="02%" ></td>
                                                        <td align="left" width="28%" style="vertical-align:top">                                                         
                                                        <div  id="emptasks" style="width:90%" >
                                                 				<!--<select name="ownertasks" size="15" class="" id="ownertasks" style="width:275px" >
                                                                    <option></option>                                
                                                                </select> -->
                                                            </div>
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
                    <?php include ('../footer.php') ?>
                </div>
            </td>
        </tr>
    </table>
  
</form>    
</body>
</html> 
