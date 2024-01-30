<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Edit Work Flow
 * Last Update      :   06/10/2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database 
include ("../class/sql_wkflow.php");            //  connection file to the mysql database
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS - EDIT WORK FLOW ::.</title>
    
    <link href="../css/styleB.css" rel="stylesheet" type="text/css" />
    
    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    
    <script type="text/javascript" src="../jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>    
    
  
    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />
	
	<script type="text/javascript" src="jquerytimepicker/jquery.ui.timepicker.js?v=0.2.5"></script>
	<link rel="stylesheet" href="jquerytimepicker/jquery.ui.timepicker.css" type="text/css" />
  
    <script type="text/javascript">
								                        $(document).ready(function() {
								                            $('#timepicker_start').timepicker({
								                                showLeadingZero: true,
								                                onHourShow: tpStartOnHourShowCallback,
								                                onMinuteShow: tpStartOnMinuteShowCallback
								                            });
								                            $('#timepicker_end').timepicker({
								                                showLeadingZero: true,
								                                onHourShow: tpEndOnHourShowCallback,
								                                onMinuteShow: tpEndOnMinuteShowCallback
								                            });
								                        });
								
														
								                        function tpStartOnHourShowCallback(hour) {
								                            var tpEndHour = $('#timepicker_end').timepicker('getHour');
								                            // Check if proposed hour is prior or equal to selected end time hour
								                            if (hour <= tpEndHour) { return true; }
								                            // if hour did not match, it can not be selected
								                            return false;
								                        }
								                        function tpStartOnMinuteShowCallback(hour, minute) {
								                            var tpEndHour = $('#timepicker_end').timepicker('getHour');
								                            var tpEndMinute = $('#timepicker_end').timepicker('getMinute');
								                            // Check if proposed hour is prior to selected end time hour
								                            if (hour < tpEndHour) { return true; }
								                            // Check if proposed hour is equal to selected end time hour and minutes is prior
								                            if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
								                            // if minute did not match, it can not be selected
								                            return false;
								                        }
								
								                        function tpEndOnHourShowCallback(hour) {
								                            var tpStartHour = $('#timepicker_start').timepicker('getHour');
								                            // Check if proposed hour is after or equal to selected start time hour
								                            if (hour >= tpStartHour) { return true; }
								                            // if hour did not match, it can not be selected
								                            return false;
								                        }
								                        function tpEndOnMinuteShowCallback(hour, minute) {
								                            var tpStartHour = $('#timepicker_start').timepicker('getHour');
								                            var tpStartMinute = $('#timepicker_start').timepicker('getMinute');
								                            // Check if proposed hour is after selected start time hour
								                            if (hour > tpStartHour) { return true; }
								                            // Check if proposed hour is equal to selected start time hour and minutes is after
								                            if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
								                            // if minute did not match, it can not be selected
								                            return false;
								                        }
								                    </script> 
    
    <script>
		$(function() {
	            $( "input:submit", ".demo" ).button();
	            $( "input:button", ".demo" ).button();
		}); 
    </script>  
    <script type="text/javascript">	
			
		 function getKjr(){           
		 	kjrid = document.getElementById('kjrcode').value;			 	
            $.post('../class/sql_getKJRWorkFlow.php',{kjrdata : frm_EditWorkFlow.kjrcode.value},			
                function(output){ 						                 
                    $('#indicatorcode').html(output);
                }
            )            
        }
         function getIndicator(){           
		 	indid = document.getElementById('indicatorcode').value;			 	
            $.post('../class/sql_getKJRWorkFlow.php',{inddata : frm_EditWorkFlow.indicatorcode.value},			
                function(output){ 						                 
                    $('#subindicatorcode').html(output);
                }
            )            
        }
		function selectUser(){   
            var w = frm_EditWorkFlow.lstSysUsers.selectedIndex;
            
            $.post('get_Departments.php',{selectUser : frm_EditWorkFlow.lstSysUsers.value , UserName : frm_EditWorkFlow.lstSysUsers.options[w].text},
                function(output){                    
                    $('#lstFacUsers').html(output);
                    refreshList();
                }
            )            
        }
        
        function removeUser(){            
            $.post('get_Departments.php',{removeUser : frm_EditWorkFlow.lstFacUsers.value},
                function(output){                    
                    $('#lstFacUsers').html(output);   
                    refreshList();
                }
            )            
        }
        
        function getselectedWfalertpersons(){
            $.post('get_Departments.php',{getselectedWfalertpersons : frm_EditWorkFlow.lstcovSysUsers.value},
                function(output){                    
                    $('#lstFacUsers').html(output);  
                    refreshList(); 
                }
            ) 
        }

        function selectcoveringUser(){   
            var w = frm_EditWorkFlow.lstcovSysUsers.selectedIndex;
            
            $.post('get_Departments.php',{selectcoveringUser : frm_EditWorkFlow.lstcovSysUsers.value , UserName : frm_EditWorkFlow.lstcovSysUsers.options[w].text},
                function(output){                    
                    $('#lstcovFacUsers').html(output);
                    refreshList();
                }
            )            
        }

        function removecoveringUser(){            
            $.post('get_Departments.php',{removecoveringUser : frm_EditWorkFlow.lstcovFacUsers.value},
                function(output){                    
                    $('#lstcovFacUsers').html(output);   
                }
            )            
        }


        function getselectedcovpersons(){
            $.post('get_Departments.php',{getselectedcovpersons : frm_EditWorkFlow.lstcovSysUsers.value},
                function(output){                    
                    $('#lstcovFacUsers').html(output);  
                }
            ) 
        }

		 function getDepartments(){            		 
            $.post('get_Departments.php',{divid : frm_EditWorkFlow.cmbDiv.value, deptId : frm_EditWorkFlow.txtDpt.value },
                function(output){                   
                    $('#cmbDpt').html(output);
                }
            )            
        }
	</script> 
</head>
    <body>
      <?php  
	  function get_KJRDetails($str_dbconnect,$empno) {

   		$_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$empno'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $etf    =	$_myrowRes['EmpNIC'];
        }

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_kjr where etfno='$etf'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
	}
	  
	function getEMPLOYEEDETAILS($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' order by FirstName" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}	  
	  
	  
	  ?>
      
      
      
        
        <?php

           /*  $wkid    =   "";
			$wkname  =   "";
			$wkdes   =   "";
			$wkstime =   "";
			$wketime =   "";
			$wkcate = "";
			$wkkjr =  "";
			$wkkpi=  "";
			$wkact =   "";
			$wkrpowner =  "";
			$wkrpdiv =   "";
			$wkrpdept =  "";
			
			$wk_Owner =""; 
			$_GET['empCode']="";*/
            $_POST['kjrcode'] ="";
            $_POST['indicatorcode'] ="";
            $_POST['subindicatorcode'] = "";
            if(isset($_GET['id'])) 
            {					
                $wkid = $_GET['id'];
				$wk_Owner = $_GET['empCode'];
                $_SESSION["workflowid"]=$wkid;
                $_SESSION["Str_WKID"] = $wkid;
				$_SESSION["wk_Owner"]=$wk_Owner;
				$_SelectQuery   =  "SELECT * FROM tbl_workflow WHERE `wk_id` = '$wkid' AND `wk_Owner` = '$wk_Owner' " or die(mysqli_error($str_dbconnect));
                $_ResultSet      =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
					$_EmpCode = $_myrowRes['wk_Owner'];
					$wkname  =   $_myrowRes['wk_name'];
					$wkdes   =   $_myrowRes['WF_Desc'];
					$wkstime =   $_myrowRes['start_time'];
					$wketime =   $_myrowRes['end_time'];
					$wkcate =   $_myrowRes['catcode'];
					$wkkjr =   $_myrowRes['kjrid'];
					$wkkpi=   $_myrowRes['kpiid'];
					$wkact =   $_myrowRes['activityid'];
					$wkrpowner =   $_myrowRes['report_owner'];
					$wkrpdiv =   $_myrowRes['report_div'];
					$wkrpdept =   $_myrowRes['report_Dept'];
                }                 
            }             
			
			
            if (isset($_POST['btn_Update'])) {
				
				$wwkkid=$_SESSION["workflowid"];
				$wknm = $_POST['txtTaskName'];
				$wkdd = $_POST['txtTaskDesc'];
				$wkss = $_POST['timepicker_start'];
				$wkee = $_POST['timepicker_end'];
				$wwkcate= $_POST['cmbwfcat'];
                if($_POST['kjrcode'] && $_POST['indicatorcode']&& $_POST['subindicatorcode']){
                    $wwkkjr =   $_POST['kjrcode'];
				    $wwkkpi=   $_POST['indicatorcode'];
				    $wwkact =  $_POST['subindicatorcode'];
                }
				$wwkrpowner = $_POST['cmbReportOwner'];
				$wwkrpdiv =   $_POST['cmbDiv'];
				$wwkrpdept =  $_POST['cmbDpt'];
               
				$_SelectQuery 	=   "UPDATE tbl_workflow SET `wk_name` = '$wknm' , `WF_Desc` = '$wkdd', `start_time` = '$wkss', `end_time` = '$wkee' , `catcode` = '$wwkcate' , `kjrid` = '$wwkkjr', `kpiid` = '$wwkkpi', `activityid` = '$wwkact', `report_owner` = '$wwkrpowner', `report_div` = '$wwkrpdiv', `report_Dept` = '$wwkrpdept' WHERE  wk_id = '$wwkkid' " or die(mysqli_error($str_dbconnect));
				
				$che = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));				
                    //  $_SESSION["workflowid"]=$wwkkid;
                    //  $wkname  =  $wknm;
				    // 	$wkdes   =   $wkdd;
				    // 	$wkstime =   $wkss;
				    // 	$wketime =   $wkee;
					  $wkcate =   $wwkcate;
					//  $wkkjr =   $wwkkjr;
					//  $wkkpi=   $wwkkpi;
					//  $wkact =   $wwkact;
					  $wkrpowner =   $wwkrpowner;
					//  $wkrpdiv =   $wwkrpdiv;
                    //  $wkrpdept =   $wwkrpdept;
                }  
?>
       
 
<form id="frm_EditWorkFlow" name="frm_EditWorkFlow" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
    <table width="100%" cellpadding="0" cellspacing="0" >
        <tr>
            <td align="left">
                <div id="wrapper">
                    <table width="100%" cellpadding="0" cellspacing="0">                       
                        <tr>
                            <td align="left" style="width: 100%; vertical-align: top;">
                                <div id="right" >
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr style="height: 50px; background-color: #E0E0E0;">
                                            <td style="padding-left: 10px; font-size: 16px">
                                                <font color="#0066FF">Edit Work Flow</font> <font size="0">(Please Scroll Down To Update)</font>                                           
                                            </td>                                                                                             
                                        </tr> 
                                                                                  
                                        <tr align="center">                                                                                        
                                        </tr>
                                    </table>
                                    <br></br>                                    
                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>                                                
                                                <table width="100%" cellpadding="0" cellspacing="8px"> 
                                                <tr><div align="center" style="background-color:#00FA9A" >  
																 <?php 
                                                                 $che = "";
                                                                 if ($che!=""){
                                                                     echo "Successfully Updated";
                                                                 }
                                                                 ?>            
                                            			</div></tr> 
                                                <tr>
                                                        <td align="left">
                                                            W/F Number
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
															<label id="wnum" name="wnum" ><?php if (isset($_POST['btn_Update'])){echo $wwkkid;} else {echo $wkid;}?></label><input type="hidden" id="wnum" value="<?php echo $wkid;?>"><input type="hidden" id="enum" value="<?php echo $empid;?>">                       
                                                        </td>
                                                    </tr>
													<tr>                                         
                                                    <tr>
                                                        <td align="left">
                                                            W/F Name
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
															<textarea id="txtTaskName" name="txtTaskName" class="TextAreaStyle" cols="40" rows="4"><?php if (isset($_POST['btn_Update'])){echo $wknm;} else { echo $wkname;}?></textarea>                                                            
                                                        </td>
                                                    </tr>
													<tr>
                                                        <td align="left">
                                                            W/F Description
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
															<textarea id="txtTaskDesc" name="txtTaskDesc" cols="40" rows="4" class="TextAreaStyle"><?php if (isset($_POST['btn_Update'])){echo $wkdd;} else { echo $wkdes;}?></textarea>  
                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            W/F Category
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <select id="cmbwfcat" name="cmbwfcat" class="TextBoxStyle">
                                                                <?php
																/*if (isset($_POST['btn_Update'])){?> <option value="<?php echo $wwkcate; ?>" > <?php echo $wwkcate; ?> </option> <?php }  else       {  */                          
                                                                    $_ResultSet = getwfcategory($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {																		
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['catcode']; ?>"  <?php if ($_myrowRes['catcode'] == $wkcate) echo "selected" ?>> <?php echo $_myrowRes['category'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                    <td >
                                                        KJR Code
                                                    </td>
                                                    <td >:</td>
                                                    <td> 
                                                    
                                                        <select name="kjrcode" id="kjrcode" style="width:250px" class="TextBoxStyle"  onChange="getKjr();">    										<?php
																if (isset($_POST['btn_Update'])){?> <option value="<?php echo $wwkkjr; ?>" > <?php echo $wwkkjr; ?> </option> <?php }  else { ?>                  <?php                         
                                                        $_ResultSetKJRDetail = get_KJRDetails($str_dbconnect,$_EmpCode );													
									                        while ($myrowRes = mysqli_fetch_array($_ResultSetKJRDetail))
									                        {?>
                                                        <option value="<?php echo $myrowRes["KJRId"];?>"  <?php if ($_myrowRes['kjrid'] == $wkkjr) echo "selected=\"selected\";" ?> > <?php echo $myrowRes["Name"]." - ".$myrowRes["Description"]; ?></option> <?php }}?>                                                      
                                                        </select>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td > 		
                                                        KPI 
                                                    </td>
                                                    <td >:</td>
                                                    
                                                    <script type="text/javascript">
                                                            getKjr();
                                                     </script>
                                                     <td>                                                    
																
                                                     	<select id="indicatorcode" name="indicatorcode" style="width:250px" class="TextBoxStyle" onChange="getIndicator();">						</select>  
                                                          <input type="hidden" name="txtindicatorcode" id="txtindicatorcode" value=""></input>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td >
                                                        Activity 
                                                    </td>
                                                    <td >:</td>
                                                    
                                                    <script type="text/javascript">
                                                            getIndicator();
                                                     </script>
                                                     <td> 
                                                     	                                                     
                                                     	<select id="subindicatorcode" name="subindicatorcode" style="width:250px" class="TextBoxStyle" >						</select>    
                                                          <input type="hidden" name="txtindicatorcode" id="txtindicatorcode" value=""></input>                                                           
                                                    </td>
                                                </tr>      
                                                    <tr>
                                                        <td align="left">
                                                            Report Start Time
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <input type="text" class="TextBoxStyle" name="timepicker_start" id="timepicker_start" size="15" value="<?php if (isset($_POST['btn_Update'])){echo $wkss;} else { echo $wkstime;}?>"></input>                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            Report End Time
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <input type="text" class="TextBoxStyle" name="timepicker_end" id="timepicker_end" size="15" value="<?php if (isset($_POST['btn_Update'])){echo $wkee;} else { echo $wketime;}?>"></input>                            
                                                        </td>
                                                    </tr> 
                                                    <tr >
                                                        <td align="left">
                                                        Reporting Person
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <select id="cmbReportOwner" name="cmbReportOwner"  class="TextBoxStyle">
                                                                <?php
                                                                    #	Get Designation details ...................
                                                                    $_EmpCode       =   $_SESSION["LogEmpCode"];
                                                                    $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect) ;
                                                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                ?>
                                                                <option value="<?php echo $_myrowRes['EmpCode']; ?>"  <?php if ($_myrowRes['EmpCode'] == $wkrpowner) echo "selected" ?>> <?php echo $_myrowRes['FirstName']." ".$_myrowRes['LastName'] ; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                            <!-- <input type="hidden"  id="cmbReportOwner" name="cmbReportOwner" value="<?php echo $wkrpowner; ?>"> -->
                                                        </td>
                                                    </tr>  
                                                    <tr >
                                                        <td align="left">
                                                            Report Division
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left">
                                                            <select id="cmbDiv" name="cmbDiv" onchange="getDepartments()" class="TextBoxStyle">
                                                                <option id="0" selected="selected">Select Division</option>                                    
                                                                <option id="SL" value="SL" <?php if($wkrpdiv== "SL") { echo "selected='selected'"; }?>>SL</option>
                                                                <option id="US" value="US" <?php if($wkrpdiv== "US") { echo "selected='selected'"; }?>>US</option>
                                                                <option id="TI" value="TI" <?php if($wkrpdiv== "TI") { echo "selected='selected'"; }?>>TI &nbsp;&nbsp;</option>
																<option id="CN" value="CN" <?php if($wkrpdiv== "CN") { echo "selected='selected'"; }?>>CN &nbsp;&nbsp;</option>
																<option id="AU" value="AU" <?php if($wkrpdiv== "AU") { echo "selected='selected'"; }?>>AU &nbsp;&nbsp;</option>
                                                            </select>
                                                             <input type="hidden" name="txtDpt" id="txtDpt" value="<?php echo $wkrpdept; ?>"></input>
                                                        </td>
                                                    </tr>  
                                                    <tr >
                                                        <td align="left">
                                                            Report Departments
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>

                                                        <script type="text/javascript">
                                                            getDepartments();
                                                        </script>

                                                        <td align="left">
                                                            <select id="cmbDpt" name="cmbDpt" class="TextBoxStyle">
                                                                <option>Select Department</option>
                                                                  
                                                            </select>      
                                                           
                                                        </td>                                                       
                                                    </tr>  


                                                    <tr>
                                                        <td align="left">
                                                            covering person
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left"> 
                                                            <div class="demo">
                                                                <select name="lstcovSysUsers" size="10" id="lstcovSysUsers" style="width:160px" >                               
                                                                    <?php
                                                                        $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
                                                                        
                                                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                            ?>
                                                                            <option value="<?php echo $_myrowRes['EmpCode']; ?>"> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
                                                                    <?php } ?>
                                                                </select>

                                                                <input name="Save" class="demo" type="button"  id="Save" value=">" style="width: 40px; vertical-align: 500%; cursor: pointer" onclick="selectcoveringUser()"/>
                                                                <input name="Del"  class="demo" type="button"  id="Del" value="<" style="width: 40px; vertical-align: 500%; cursor: pointer;" onclick="removecoveringUser()"/>                                   

                                                                <script type="text/javascript">
                                                                     getselectedcovpersons();
                                                                </script>
                                                                <select name="lstcovFacUsers" size="10" class="" id="lstcovFacUsers" style="width:160px" >
                                                                    <option></option>                                
                                                                </select>     
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td align="left">
                                                            Work flow Alert List
                                                        </td>
                                                        <td >
                                                            :
                                                        </td>
                                                        <td align="left"> 
                                                            <div class="demo">
                                                                <select name="lstSysUsers" size="10" id="lstSysUsers" style="width:160px" >                               
                                                                    <?php
                                                                        $_ResultSet = getEMPLOYEEDETAILS($str_dbconnect);
                                                                        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                                            ?>
                                                                            <option value="<?php echo $_myrowRes['EmpCode']; ?>"> <?php echo $_myrowRes['FirstName'] . " " . $_myrowRes['LastName']; ?> </option>
                                                                    <?php } ?>
                                                                </select>

                                                                <input name="Save" class="demo" type="button"  id="Save" value=">" style="width: 40px; vertical-align: 500%; cursor: pointer" onclick="selectUser()"/>
                                                                <input name="Del"  class="demo" type="button"  id="Del" value="<" style="width: 40px; vertical-align: 500%; cursor: pointer;" onclick="removeUser()"/>                                   

                                                            <script type="text/javascript">
                                                                     getselectedWfalertpersons();
                                                                </script>
                                                                <select name="lstFacUsers" size="10" class="" id="lstFacUsers" style="width:160px" >
                                                                    <option></option>                                
                                                                </select>     
                                                            </div>
                                                        </td>
                                                    </tr>    

                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="demo">
                                                                <br></br>
                                                                <center>                            
                                                                <input type="submit"  value="Update"  id="btn_Update" name="btn_Update" /> 
                                                                                 
                                                                </center>
                                                            </div>                                                            
                                                        </td> 
                                                                                                       
                                                    </tr >
                                                </table>
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
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>            
        </tr>   
        <tr>            
        </tr>
    </table>
    <script>
        getWFDetails();
    </script>
    
</form> 
 <?php ?>   
</body>
</html> 
