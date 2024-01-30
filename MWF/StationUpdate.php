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
        <title>Station Update</title>  
		         
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
				/*window.location.href = "ScanQR.php";	*/
				
			}
			
			function ServiceList(MCID, MCNAME){
				window.location.href = "StationUpdate.php?MCID="+MCID+"&MCNAME="+MCNAME;				
			}
			
			$(function() {	
									
			    $("#btn_LogOut").click(function() {																				
					$.mobile.changePage( "index.php", { transition: "flip"} );								
					setTimeout(LogOut,1000);
			    });
				
				$("#backPageButton").click(function() {
					var Station_ID		=	ServiceUpdate.txt_StationCode.value;
					var Station_Name	=	ServiceUpdate.txt_Station.value;					
			        $.mobile.changePage("#page1", { transition: "flip"});
					setTimeout(ServiceList(Station_ID, Station_Name),1000);
			    });
				
				$("#EbackPageButton").click(function() {
					var Station_ID		=	ServiceUpdate.txt_StationCode.value;
					var Station_Name	=	ServiceUpdate.txt_Station.value;					
			        $.mobile.changePage("#page1", { transition: "flip"});
					setTimeout(ServiceList(Station_ID, Station_Name),1000);
			    });
								 
			});
			
			function PageBack(){
				$.mobile.changePage( "index.php", { transition: "flip"} );								
				setTimeout(LogOut,1000);	
			}
			
			function UpdateServices(){ 
				
				var Station_ID		=	ServiceUpdate.txt_StationCode.value;
				var Station_Name	=	ServiceUpdate.txt_Station.value;
				var TaskComletion 	= 	document.getElementsByName("radio-choice-b");	
				var TimeLog			=	ServiceUpdate.txt_StartTime.value;
				var UserComment		=	ServiceUpdate.txt_Comment.value;				
				var TaskID			=	ServiceUpdate.optTaskName.value;
				
				var Update_Cat	=	""
				
				if(TaskComletion[0].checked == true){
					Update_Cat = "S";	
				}else if(TaskComletion[1].checked == true){
					Update_Cat = "P";	
				} 
				
				 
	            
				$.post('class/jClass.php',{
					Command 		: 'UpdateStation', 
					Station_ID 		: Station_ID, 
					Station_Name 	: Station_Name, 
					Update_Cat 		: Update_Cat, 
					TimeLog			: TimeLog,
					UserComment		: UserComment,					
					TaskID			: TaskID					
					},
				    function(output){    
						alert(output);						               
				    	if(output == "SAVED"){
							$.mobile.changePage("#page2", { transition: "flip"});			
						}  	
						
						if(output == "NOT SAVED"){
							$.mobile.changePage("#page3", { transition: "flip"});			
						} 																		
				    }
				)  
        	}
			
			function StartTime(){
				var d = new Date();
				var H = d.getHours();
				var M = d.getMinutes();
				
				ServiceUpdate.txt_StartTime.value = H + ":" + M;
			}
			
			
		</script>	
		
		<style type="text/css">
			table {
		    color: black;
		    background: #fff;
		    border: 1px solid #b4b4b4;
		    font: bold 17px helvetica;
		    padding: 0;
		    margin-top:10px;
		    width: 100%;
		    -webkit-border-radius: 8px;
		}
		     
		table tr td {
		    color: #666;
		    border-bottom: 1px solid #b4b4b4;
		    border-right: 1px solid #b4b4b4;
		    padding: 10px 10px 10px 10px;
		    background-image: -webkit-linear-gradient(top, #fdfdfd, #eee);
		}
		         
		table tr td:last-child {
		    border-right: none;
		}
		
		table tr:last-child td {
		    border-bottom: none;
		}​
		</style>
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
				<!--<a id="btn_Back" class='ui-btn-left' data-icon='back' data-theme="a" <?php echo "onclick=\"ServiceList('".$MCID."', '".$MCNAME."')\" "; ?>>Back</a>			-->
                <h1>
                    station Update <?php echo $_SESSION["LogEmpName"]; ?>
                </h1>				
				<a id="btn_LogOut" class='ui-btn-right' data-icon='refresh' data-theme="a" >Logout</a>                
            </div>
            <div data-role="content">				
                <form action="" name="ServiceUpdate">
					<!--<div data-role="fieldcontain">	-->					
			         	<label for="name">Station Code</label>
			         	<input type="text" name="txt_StationCode" id="txt_StationCode" value="<?php echo $MCID; ?>" data-mini="true" readonly="readonly"/>
					<!--</div>-->
                    <!--<div data-role="fieldcontain">-->
			         	<label for="name">Station Name</label>
			         	<input type="text" name="txt_Station" id="txt_Station" value="<?php echo $MCNAME; ?>" data-mini="true" readonly="readonly"/>
					<!--</div>-->
					<!--<div data-role="fieldcontain">
						<label for="textarea">Station Name</label>
						<textarea cols="40" rows="8" name="txt_TaskName" id="textarea" data-mini="true" readonly="readonly"><?php echo $TaskDescription; ?></textarea>
					</div>	-->
					<!--<div data-role="fieldcontain">-->
			         	<label for="name">Task Name</label>
						<select name="optTaskName" id="optTaskName" class="TextBoxStyle">                                                    
                        <?php                                                            
                            $_ResultSetBox = GetStationwiseTask($str_dbconnect,$MCID);
                            while($_myrowResBox = mysqli_fetch_array($_ResultSetBox)) {
                        ?>
                            <option value="<?php echo $_myrowResBox['TaskID']; ?>"> <?php echo $_myrowResBox['TaskDescription'] ; ?> </option>
                        <?php } ?>						
                        </select>			         	
					<!--</div>-->
					<!--<div data-role="fieldcontain">-->
					    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true" >
					     	<legend>Station Update Type</legend>
					         	<input type="radio" name="radio-choice-b" onclick="StartTime()" id="radio-choice-c" value="S" <?php if($TaskComletion == "S") echo "checked='checked'" ?> width="50px" />
					         	<label for="radio-choice-c">Start</label>
					         	<!--<input type="radio" name="radio-choice-b" onclick="StartTime()" id="radio-choice-d" value="U" <?php if($TaskComletion == "U") echo "checked='checked'" ?> width="50px"/>
					         	<label for="radio-choice-d">Update</label>-->
					         	<input type="radio" name="radio-choice-b" onclick="StartTime()" id="radio-choice-e" value="P" <?php if($TaskComletion == "P") echo "checked='checked'" ?> width="50px" />
					         	<label for="radio-choice-e">Stop</label>
					    </fieldset>
					<!--</div>	-->				
					<!--<div data-role="fieldcontain">-->
			         	<label for="name">Time update</label>
			         	<input type="text" name="txt_StartTime" id="name" value="<?php echo $TaskStartTime; ?>" data-mini="true" readonly="readonly" />						
					<!--</div>	-->
					
					<!--<div data-role="fieldcontain">-->
			         	<label for="name">User Comment</label>
			         	<input type="text" name="txt_Comment" id="txt_Comment" value="<?php echo $TaskEndTime; ?>" data-mini="true" width="80px" />						
					<!--</div>-->
					<!--<div data-role="fieldcontain">
			         	<label for="name">Bag Count</label>
			         	<input type="text" name="txt_BagCount" id="txt_BagCount" value="<?php echo $TaskEndTime; ?>" data-mini="true" />						
					</div>
					
					<div data-role="fieldcontain">
			         	<label for="name">Box Count</label>
			         	<input type="text" name="txt_BoxCount" id="txt_BoxCount" value="<?php echo $TaskEndTime; ?>" data-mini="true" />						
					</div>	-->				
					<center>
						<a data-role="button" data-icon="delete" data-inline="true" <?php echo "onclick=\"ServiceList('".$MCID."', '".$MCNAME."')\" "; ?>>Cancel</a>
						<a data-role="button" data-icon="check" data-theme="b" data-inline="true" onclick="UpdateServices()">Save</a>
					</center>
					
					<div data-role="content">
			         	<center><h3>Time Update History</h3></center>
						<table align="center" >
							<tr>
								<td width="50px"><b>No#</b></td>
								<td width="150px"><b>Sub Task Name</b></td>
								<td width="100px"><b>Time Start</b></td>
								<td width="100px"><b>Time End</b></td>								
								<td width="150px"><b>Comments</b></td>								
							</tr>
						<?php
						
							$LogUserCode 		= 	$_SESSION["LogEmpCode"]; 
		
							$Country = $_SESSION["LogCountry"];
							$timezone = "Asia/Colombo";	
								
							if($Country == "SL"){
								$timezone = "Asia/Colombo";	
							}
							
							if($Country == "US"){
								$timezone = "America/Los_Angeles";
							}
							
							if($Country == "TI"){
								$timezone = "Asia/Bangkok";
							}		
							if($Country == "AU"){
								$timezone = "Australia/Melbourne";	
							}
							if($Country == "FIJI"){
								$timezone = "Pacific/Fiji";	
							}
							date_default_timezone_set($timezone);
							
					        $today_date  = date("Y-m-d");     
							
							$str_SelectQuery  = " SELECT TSL.Trn_ID, TSL.Station_ID, TSL.Station_Name, TSL.EmpCode, TSL.TimeLog, TSL.TimeLogEnd, TSL.TrnType, TSL.TaskID, TSL.UserComments, ";
							$str_SelectQuery .= " TSL.TrnDateTime, TSL.Status, TST.TaskID, TST.TaskDescription " ;
							$str_SelectQuery .= " FROM tbl_stationlog TSL " ;
							$str_SelectQuery .= " INNER JOIN tbl_StationTask TST " ;
							$str_SelectQuery .= " ON TST.TaskID = TSL.TaskID " ;
							$str_SelectQuery .= " WHERE TSL.TrnDateTime = '$today_date' AND TSL.Station_ID = '$MCID' AND TSL.EmpCode = '$LogUserCode' ORDER BY TSL.Trn_ID" or die(mysqli_error($str_dbconnect));
							
							/*$str_SelectQuery        = 	"SELECT * FROM tbl_stationlog WHERE TrnDateTime = '$today_date' AND Station_ID = '$MCID' AND EmpCode = '$LogUserCode'" or die(mysqli_error($str_dbconnect));*/
						    $str_ResultSet          =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));
							
							$Row_Count	=	0;
						    while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {						       
								
								$Trn_Cat = "";
								
								if($_myrowRes['TrnType'] == 'S'){
									$Trn_Cat = "Start";
								}else if($_myrowRes['TrnType'] == 'U'){
									$Trn_Cat = "Update";
								}else if($_myrowRes['TrnType'] == 'P'){
									$Trn_Cat = "Stop";
								}
								
								$Row_Count = $Row_Count + 1;								
								
								echo "<tr>";
								echo "<td>".$Row_Count."</td>";								
								echo "<td>".$_myrowRes['TaskDescription']."</td>";
								echo "<td align='center'>".$_myrowRes['TimeLog']."</td>";
								echo "<td align='center'>".$_myrowRes['TimeLogEnd']."</td>";
								echo "<td align='right'>".$_myrowRes['UserComments']."</td>";								
								echo "</tr>";
						    }
						?>							
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
		
		
		<!--Starting Page Two-->
        <div data-role="page" id="page3">         
            <div data-role="header" data-theme="a" data-position="fixed">    
               <h5>
                    :: Mobile Work Flow System ::
               </h5>                                               
            </div><!-- /header -->         
            
            <div data-role="content">  
                <form name="Error" id="Error"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;">
                            <label for="txt_userID" style="color:Red" >
                                You haven't Start Task to Stop<br/>
								Please Re-Try !!!
                            </label>						
                            						
                        </fieldset>
                    </div>
                    <a id="EbackPageButton" data-role="button">Back</a>   	
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