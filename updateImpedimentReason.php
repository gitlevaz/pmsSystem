<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Update Impediment
 * Last Update      :   06/10/2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization //  connection file to the mysql database 
include ("class/sql_task.php");  
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS - Update Impediment ::.</title>
    
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
</head>
    <body>
        
        <?php
		 	$taskid = "";
			$emp = "";
			$today = "";
            $wkid    =   "";
			$wkname  =   "";
			$wkdes   =   "";
			$wkstime =   "";
			$wketime =   "";
			$status = "";
			
            if(isset($_GET['taskid'])) 
            { 
                $taskid = $_GET['taskid'];
				$emp = $_GET['empcode'];
				$today = $_GET['today'];
				 $status = $_GET['stt'];				
				$_SESSION["status"]=$status;				
				$_SESSION["taskid"]=$taskid;
				$_SESSION["emp"]=$emp;
				$_SESSION["today"]=$today;
				           
            } 
			 /*if(isset($_GET['stt'])) 
            { 
               
				           
            }    */         
			            
			
			
            if (isset($_POST['btn_Update'])) {
				$ttaskid =$_SESSION["taskid"];
				$eemp= $_SESSION["emp"];
				$ttoday=$_SESSION["today"];
				$reas = $_POST["txtImpediment"];
				$Dte_StartDate  = date("Y-m-d");
				
				 $Str_UpdateCode    = 	get_SerialTask($str_dbconnect,"1030", "TASK UPDATE SERIALS");
    			$Str_UpdateCode    = 	"UPD/".$Str_UpdateCode;
				
				if($_SESSION["status"]=="") 
				{ 
					$_SelectQuery12 	=   "INSERT INTO tbl_taskupdates (`UpdateCode`, `taskcode`, `category`, `Note`,`Status`,`UpdateDate`,`UpdateUser`,`up_status`)VALUES ('$Str_UpdateCode', '$ttaskid', 'Impediment', '$reas', 'A', '$Dte_StartDate', '$eemp', 'Open')" or die(mysqli_error($str_dbconnect));            
        $che = mysqli_query($str_dbconnect,$_SelectQuery12) or die(mysqli_error($str_dbconnect));
		
				$_SESSION["taskid"]="";
				$_SESSION["emp"]="";
				$_SESSION["today"]="";
				$_SESSION["status"]="";
				
				} 
				else{
					$_SelectQuery 	=   "UPDATE tbl_impedimenttask SET `im_status` = 'C'  WHERE  TaskCode = '$ttaskid' and EmpCode='$eemp' and create_date='$ttoday' " or die(mysqli_error($str_dbconnect));            
        $che = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$_SelectQuery1 	=   "INSERT INTO tbl_taskupdates (`UpdateCode`, `taskcode`, `category`, `Note`,`Status`,`UpdateDate`,`UpdateUser`,`up_status`)VALUES ('$Str_UpdateCode', '$ttaskid', 'Impediment', '$reas', 'A', '$Dte_StartDate', '$eemp', 'Close')" or die(mysqli_error($str_dbconnect));            
        $che = mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
		
				$_SESSION["taskid"]="";
				$_SESSION["emp"]="";
				$_SESSION["today"]="";
				$_SESSION["status"]="";
					
				}  
				
				
				
				
            }  
?>
        
        
<form id="frm_UpdateImpediment" name="frm_UpdateImpediment" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
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
                                                <font color="#0066FF">Update Impediment</font>                                              
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
                                                <tr>
                                                        <td align="left">
                                                            Task Code
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
															<label id="tcode" name="tcode" ><?php if (isset($_POST['btn_Update'])){echo $ttaskid;} else {echo $taskid;}?></label><input type="hidden" id="wnum" value=""><input type="hidden" id="enum" value="">                       
                                                        </td>
                                                    </tr>
													<tr>                                         
                                                    <tr>
                                                        <td align="left">
                                                           Reason For Impediment
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td align="left">
															<textarea id="txtImpediment" name="txtImpediment" class="TextAreaStyle" cols="40" rows="4"><?php if (isset($_POST['btn_Update'])){echo $reas;} ?></textarea>                                                            
                                                        </td>
                                                    </tr>																									
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="demo">
                                                                <br></br>
                                                                <center>                            
                                                                <input type="submit"  value="Update"  id="btn_Update" name="btn_Update" />                                                                </center>
                                                            </div>
                                                            <div align="center" style="background-color:#F00" >  
																 <?php 
                                                                 if ($che!=""){
                                                                     echo "Successfully Updated";
                                                                 }
                                                                 ?>            
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
</body>
</html> 
