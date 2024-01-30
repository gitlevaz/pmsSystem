<?php	
	session_start();
	
	include ("..\connection\sqlconnection.php");   //  connection file to the mysql database
	include ("..\class\accesscontrole.php");       //  sql commands for the access controles
	include ("..\class\sql_wkflow.php");	
	
	 mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">     
	<head>  
		
	  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
      
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Task Update</title>  
		         
        <link rel="stylesheet" href="jquery.mobile-1.2.0/jquery.mobile-1.0.min.css" />  
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery-1.6.4.min.js"></script>        
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery.mobile-1.0.min.js"></script>		
		
		
		<script type="text/javascript">		
		
			function StartTime(){
				var d = new Date();
				var H = d.getHours();
				var M = d.getMinutes();
				
				ServiceUpdate.txt_StartTime.value = H + ":" + M;
			}
			
			function StopTime(){
				var d = new Date();
				var H = d.getHours();
				var M = d.getMinutes();
				
				ServiceUpdate.txt_EndTime.value = H + ":" + M;
			}
				
			
			function LogOut(){
				window.location.href = "index.php";				
			}	
			
			function ScanQRCode(){
				window.location.href = "ScanQR.php";	
				
			}
			
			function ServiceList(MCID, MCNAME){
				window.location.href = "ServiceList.php?MCID="+MCID+"&MCNAME="+MCNAME;				
			}
			
			$(function() {	
									
			    $("#btn_LogOut").click(function() {																				
					$.mobile.changePage( "index.php", { transition: "flip"} );								
					setTimeout(LogOut,1000);
			    });
				
				$("#backPageButton").click(function() {
			        $.mobile.changePage("#page1", { transition: "flip"});
			    });
								 
			});
			
			function PageBack(){
				$.mobile.changePage( "index.php", { transition: "flip"} );								
				setTimeout(LogOut,1000);	
			}
			
			function UpdateServices(){ 
			
				var WF_ID			=	ServiceUpdate.txt_TaskCode.value;				
				var TaskComletion 	= 	document.getElementsByName("radio-choice-b");	
				var TaskStartTime	=	ServiceUpdate.txt_StartTime.value;
				var TaskEndTime		=	ServiceUpdate.txt_EndTime.value;
				var UserNote		=	ServiceUpdate.txt_UserNote.value;
				
				var TaskStatus	=	""
				
				if(TaskComletion[0].checked == true){
					TaskStatus = "Yes";	
				}else if(TaskComletion[1].checked == true){
					TaskStatus = "No";	
				}else if(TaskComletion[2].checked == true){
					TaskStatus = "N/A";	
				} 
				 
	           
				$.post('class/jClass.php',{
					Command : 'UpdateService', 
					WF_ID : WF_ID, 
					TaskStatus : TaskStatus, 
					TaskStartTime : TaskStartTime, 
					TaskEndTime : TaskEndTime, 
					UserNote : UserNote
					},
				    function(output){    							               
				    	if(output == "SAVED"){
							$.mobile.changePage("#page2", { transition: "flip"});			
						}  																			
				    }
				)  
        	}
			
			
		</script>	
		
    </head>
    <body>
	<?php
			
			$WF_ID		=	"";				
			$Country	=	"";
			
			$MCID		=	"";
			$MCNAME		=	"";
			
			if(isset($_GET["WF_ID"])){
				$WF_ID =	$_GET["WF_ID"]; 		
			}
			
			if(isset($_GET["MCID"])){
				$MCID =	$_GET["MCID"]; 		
			}
			
			if(isset($_GET["MCNAME"])){
				$MCNAME =	$_GET["MCNAME"]; 		
			}
			
			echo $MCID." ".$MCNAME;
			
			$timezone = "Asia/Colombo";			
			$Country = $_SESSION["LogCountry"];
				
			if($Country == "SL"){
				$timezone = "Asia/Colombo";	
			}
			
			if($Country == "US"){
				$timezone = "America/Los_Angeles";
			}
			
			if($Country == "TI"){
				$timezone = "Asia/Bangkok";
			}
			if($Country == "CN"){
				$timezone = "Asia/Hong_Kong";
			}
			if($Country == "AU"){
				$timezone = "Australia/Melbourne";	
			}
			if($Country == "FIJI"){
				$timezone = "Pacific/Fiji";	
			}
			date_default_timezone_set($timezone);			
	        
	        $LogUserCode = $_SESSION["LogEmpCode"];        
	        $today_date  = date("Y-m-d");
			
			
			$Scheduled_Time		=	"";
			$TaskDescription	=	"";
			$TaskComletion		=	"";
			$TaskStartTime		=	"";
			$TaskEndTime		=	"";
			$UserNote			=	"";
			
			if($WF_ID != ""){				
			
				$_ResultSet 	=   getEQUpdateList($str_dbconnect,$WF_ID, $LogUserCode, $today_date);	                            
	            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
	                
					$Scheduled_Time		=	$_myrowRes['start_time'] .' - '.$_myrowRes['end_time'];
					$TaskDescription	=	$_myrowRes['wk_name'];
					$TaskComletion		=	$_myrowRes['status'];
					$TaskStartTime		=	$_myrowRes['StartTime'];
					$TaskEndTime		=	$_myrowRes['TimeTaken'];
					$UserNote			=	$_myrowRes['wk_update'];   
					             
				}
			}
			
		?>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div id="MWF_Header" data-theme="a" data-role="header">	
				<a id="btn_Back" class='ui-btn-left' data-icon='back' data-theme="a" <?php echo "onclick=\"ServiceList('".$MCID."', '".$MCNAME."')\" "; ?>>Back</a>			
                <h1>
                    Welcome <?php echo $_SESSION["LogEmpName"]; ?>
                </h1>				
				<a id="btn_LogOut" class='ui-btn-right' data-icon='refresh' data-theme="a" >Logout</a>                
            </div>
            <div data-role="content">
                <form action="" name="ServiceUpdate">
					<div data-role="fieldcontain">
			         	<label for="name">Task Code</label>
			         	<input type="text" name="txt_TaskCode" id="name" value="<?php echo $WF_ID; ?>" data-mini="true" readonly="readonly"/>
					</div>
                    <div data-role="fieldcontain">
			         	<label for="name">Scheduled Time</label>
			         	<input type="text" name="txt_ScheduledTime" id="name" value="<?php echo $Scheduled_Time; ?>" data-mini="true" readonly="readonly"/>
					</div>
					<div data-role="fieldcontain">
						<label for="textarea">Task Description</label>
						<textarea cols="40" rows="8" name="txt_TaskName" id="textarea" data-mini="true" readonly="readonly"><?php echo $TaskDescription; ?></textarea>
					</div>	
					<div data-role="fieldcontain">
					    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
					     	<legend>Task Completion Status</legend>
					         	<input type="radio" name="radio-choice-b" id="radio-choice-c" value="Yes" <?php if($TaskComletion == "Yes") echo "checked='checked'" ?> />
					         	<label for="radio-choice-c">Yes</label>
					         	<input type="radio" name="radio-choice-b" id="radio-choice-d" value="No" <?php if($TaskComletion == "No") echo "checked='checked'" ?> />
					         	<label for="radio-choice-d">No</label>
					         	<input type="radio" name="radio-choice-b" id="radio-choice-e" value="N/A" <?php if($TaskComletion == "N/A") echo "checked='checked'" ?> />
					         	<label for="radio-choice-e">N/A</label>
					    </fieldset>
					</div>
					<div data-role="fieldcontain">
					    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
					     	<legend>Task Start / Stop</legend>
					         	<input type="radio" name="TaskStartStop" id="TaskStart" value="Yes" <?php if($TaskComletion == "Yes") echo "checked='checked'" ?> onclick="StartTime()"/>
					         	<label for="TaskStart">Start</label>
					         	<input type="radio" name="TaskStartStop" id="TaskStop" value="No" <?php if($TaskComletion == "") echo "checked='checked'" ?> onclick="StopTime()" />
					         	<label for="TaskStop">Stop</label>					         	
					    </fieldset>
					</div>
					<div data-role="fieldcontain">
			         	<label for="name">Strat Time</label>
			         	<input type="text" name="txt_StartTime" id="name" value="<?php echo $TaskStartTime; ?>" data-mini="true" readonly="readonly" />						
					</div>	
					<div data-role="fieldcontain">
			         	<label for="name">End Time</label>
			         	<input type="text" name="txt_EndTime" id="name" value="<?php echo $TaskEndTime; ?>" data-mini="true" readonly="readonly"/>						
					</div>
					<div data-role="fieldcontain">
						<label for="textarea">User Review Notes</label>
						<textarea cols="40" rows="8" name="txt_UserNote" id="textarea" data-mini="true"><?php echo $UserNote; ?></textarea>
					</div>
					
					<center>
						<a data-role="button" data-icon="delete" data-inline="true" <?php echo "onclick=\"ServiceList('".$MCID."', '".$MCNAME."')\" "; ?>>Cancel</a>
						<a data-role="button" data-icon="check" data-theme="b" data-inline="true" onclick="UpdateServices()">Save</a>
					</center>
					
					<div data-role="fieldcontain">
			         	<center><h3>Time Update History</h3></center>
						
						<table align="center" border="1px">
							<tr>
								<td>No#</td>
								<td>Start Time</td>
								<td>End Time</td>
								<td>User Note</td>
							</tr>
							<tr>
								<td>01</td>
								<td>09:00</td>
								<td>10.30</td>
								<td>Started to work and left the Station</td>
							</tr>
							<tr>
								<td>02</td>
								<td>11.30</td>
								<td>13.00</td>
								<td>Stop working for lunch </td>
							</tr>
							<tr>
								<td>03</td>
								<td>14.00</td>
								<td></td>
								<td>Back To Station</td>
							</tr>
						</table>
					</div>
					
                </form>
            </div>
            <div id="MWF_Footer" data-theme="a" data-role="footer" data-position="fixed">
                <h3>
                    Teknowledge &copy; 2012
                </h3>
            </div>
        </div>
		
		<!--Starting Page Two-->
        <div data-role="page" id="page2">         
            <div data-role="header" data-theme="a" data-position="fixed">    
               <h5>
                    :: Mobile Work Flow System ::
               </h5>                                               
            </div><!-- /header -->         
            
            <div data-role="content">  
                <form name="Error" id="Error"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;">
                            <label for="txt_userID" >
                                Service Details Updated<br/>
								Successfully !!!
                            </label>						
                            						
                        </fieldset>
                    </div>
                    <a id="backPageButton" data-role="button">Back</a>   	
				 </form>
            </div><!-- /content -->         
            
            <div data-role="footer" data-theme="a" data-position="fixed">
				<h3>
                    Teknowledge &copy; 2012
                </h3>         
            </div><!-- /fotoer --> 
        </div><!-- /page -->
    </body>
</html>