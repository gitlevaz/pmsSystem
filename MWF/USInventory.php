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
        <title>Inventory Update</title>  
		         
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
				/*alert("sad");*/
				var Station_ID		=	ServiceUpdate.txt_ItemCode.value;
				var Station_Name	=	ServiceUpdate.txt_ItemName.value;
				var TaskComletion 	= 	document.getElementsByName("radio-choice-b");	
				var QTY				=	ServiceUpdate.txt_Qty.value;				
				
				var Update_Cat	=	""
				
				if(TaskComletion[0].checked == true){
					Update_Cat = "ADD";	
				}else if(TaskComletion[1].checked == true){
					Update_Cat = "REMOVE";	
				}else if(TaskComletion[2].checked == true){
					Update_Cat = "J";	
				}  
				/*alert("sads");*/
				window.location.href = "USInventory.php?MCID="+Station_ID+"&MCNAME="+Station_Name+"&Update_Cat="+Update_Cat+"&QTY="+QTY;	            
				/*alert("sadss");*/
        	}
			
			function StartTime(){
				var d = new Date();
				var H = d.getHours();
				var M = d.getMinutes();
				
				ServiceUpdate.txt_StartTime.value = H + ":" + M;
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
			
			
			if(isset($_GET["Update_Cat"])){
			
				$Update_Cat =	$_GET["Update_Cat"]; 
				$QTY 		=	$_GET["QTY"]; 
				
				$Testvar = file_get_contents("http://cis.etropicalfish.com/QRLiveInventory.aspx?CMD=".$Update_Cat."&IIC=".$MCID."&QTY=".$QTY."");
						
			}
			
			$Testvar = file_get_contents("http://cis.etropicalfish.com/QRLiveInventory.aspx?CMD=GET&IIC=".$MCID."&QTY=0");
			//echo $html;
			
			
			$pos 	 = strpos($Testvar, "@");
			$pos2    = strripos($Testvar, "@");
			
			$Answer	 =	"0";
			
			$Answer = substr($Testvar, $pos + 1, ($pos2-1) - $pos);			 
			
			/*echo "<script language='javascript' type='text/javascript'>alert('".$pos."');</script>";
			echo "<script language='javascript' type='text/javascript'>alert('".$pos2."');</script>";
			echo "<script language='javascript' type='text/javascript'>alert('".$Answer."');</script>";*/
			
			
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
                    Inventory Update : <?php echo $_SESSION["LogEmpName"]; ?>
                </h1>				
				<a id="btn_LogOut" class='ui-btn-right' data-icon='refresh' data-theme="a" >Logout</a>                
            </div>
            <div data-role="content">				
                <form action="" name="ServiceUpdate">
					<!--<div data-role="fieldcontain">-->						
			         	<label for="name">Item Code</label>
			         	<input type="text" name="txt_ItemCode" id="txt_ItemCode" value="<?php echo $MCID; ?>" data-mini="true" readonly="readonly"/>
					<!--</div>-->
                    <!--<div data-role="fieldcontain">-->
			         	<label for="name">Item Name</label>
			         	<input type="text" name="txt_ItemName" id="txt_ItemName" value="<?php echo $MCNAME; ?>" data-mini="true" readonly="readonly"/>
					<!--</div>	-->				
					<!--<div data-role="fieldcontain">-->
			         	<label for="name">Available Qty.</label>
			         	<input type="number" name="txt_AvbQty" id="txt_AvbQty" value="<?php echo $Answer; ?>" data-mini="true" width="80px" />						
					<!--</div>-->
					<!--<div data-role="fieldcontain">-->
			         	<label for="name">Quantity</label>
			         	<input type="number" name="txt_Qty" id="txt_Qty" value="<?php echo $TaskEndTime; ?>" data-mini="true" width="80px" pattern="[0-9]*" />						
					<!--</div>	-->	
					<!--<div data-role="fieldcontain">-->
					    <fieldset data-role="controlgroup" data-type="vertical" data-mini="true" >
					     	<legend>Inventory Update Type</legend>
					         	<input type="radio" name="radio-choice-b" onclick="StartTime()" id="radio-choice-c" value="S" <?php if($TaskComletion == "S") echo "checked='checked'" ?> width="50px" />
					         	<label for="radio-choice-c">Add</label>
					         	<input type="radio" name="radio-choice-b" onclick="StartTime()" id="radio-choice-d" value="U" <?php if($TaskComletion == "U") echo "checked='checked'" ?> width="50px"/>
					         	<label for="radio-choice-d">Withdraw</label>
					         	<input type="radio" name="radio-choice-b" onclick="StartTime()" id="radio-choice-e" value="P" <?php if($TaskComletion == "P") echo "checked='checked'" ?> width="50px" />
					         	<label for="radio-choice-e">Transfer</label>
					    </fieldset>
					<!--</div>	-->				
					<!--<div data-role="fieldcontain">-->
			         	<label for="name">Time update</label>
			         	<input type="text" name="txt_StartTime" id="name" value="<?php echo $TaskStartTime; ?>" data-mini="true" readonly="readonly" />						
					<!--</div>		-->			
												
					<center>
						<a data-role="button" data-icon="delete" data-inline="true" <?php echo "onclick=\"ServiceList('".$MCID."', '".$MCNAME."')\" "; ?>>Cancel</a>
						<a data-role="button" data-icon="check" data-theme="b" data-inline="true" onclick="UpdateServices()">Save</a>
					</center>				
					
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