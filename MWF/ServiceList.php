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
        <title>Service List</title>  
		         
        <link rel="stylesheet" href="jquery.mobile-1.2.0/jquery.mobile-1.0.min.css" />  
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery-1.6.4.min.js"></script>        
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery.mobile-1.0.min.js"></script>
		
		<script type="text/javascript">			
			
			function LogOut(){
				window.location.href = "index.php";				
			}	
			
			function ScanQRCode(){
				window.location.href = "ScanQR.php";				
			}
			
			$(function() {	
									
			    $("#btn_LogOut").click(function() {																				
					$.mobile.changePage( "index.php", { transition: "flip"} );								
					setTimeout(LogOut,1000);
			    });	
				
				$("#btn_Back").click(function() {
			        $.mobile.changePage("ScanQR.php", { transition: "slide"} );	
					setTimeout(ScanQRCode,1000);
			    });
								 
			});
			
			function TransmitServices(WF_ID, MCID, MCNAME){
				/*$.mobile.changePage("page1", { transition: "flip"} );	*/							
				setTimeout(ServiceUpodate(WF_ID, MCID, MCNAME),1000);		
			}
			
			function ServiceUpodate(WF_ID, MCID, MCNAME){
				window.location.href = "UpdateTask.php?WF_ID=" + WF_ID + "&MCID=" + MCID + "&MCNAME=" + MCNAME;			
			}
			
		</script>	
		
    </head>
    <body>
		
		<?php
			
			$MCID		=	"";
			$MCNAME		=	"";
			$Country	=	"";
			
			if(isset($_GET["MCID"])){
				$MCID =	$_GET["MCID"]; 		
			}
			
			if(isset($_GET["MCNAME"])){
				$MCNAME =	$_GET["MCNAME"]; 		
			}
			
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
			
			Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country);
			
		?>
		
        <!-- Home -->
        <div data-role="page" id="page1">
            <div id="MWF_Header" data-theme="a" data-role="header">	
				<a id="btn_Back" class='ui-btn-left' data-icon='back' data-theme="a">Back</a>					
                <h1>
                    Welcome <?php echo $_SESSION["LogEmpName"]; ?>
                </h1>				
								
				<a id="btn_LogOut" class='ui-btn-right' data-icon='refresh' data-theme="a" >Logout</a>                
            </div>
            <div data-role="content">
                <form action="">
					<div data-role="fieldcontain">
						<table align="center" width="100%" style="font-size:12px">
							<tr>
								<td align="left">Machine ID</td>
								<td>:</td>
								<td align="left"><?php echo $MCID; ?></td>
							</tr>
							<tr>
								<td align="left">Machine Name</td>
								<td>:</td>
								<td align="left"><?php echo $MCNAME; ?></td>
							</tr>
							<tr>
								<td align="left">Date</td>
								<td>:</td>
								<td align="left"><?php echo $today_date; ?></td>
							</tr>
							<tr>
								<td align="left">Country</td>
								<td>:</td>
								<td align="left"><?php echo $Country; ?></td>
							</tr>
							<tr>
								<td colspan="3" align="center">
									<br/>
									<b><U>TASK UPDATE LEGEND</U></b>
								</td>								
							</tr>
							<tr>
								<td colspan="3" align="center">
									<a data-role="button" data-inline="true" data-mini="true">Pending</a>
									<a data-role="button" data-inline="true" data-theme="b" data-mini="true">Completed</a>
									<a data-role="button" data-inline="true" data-theme="a" data-mini="true">N/A</a>
								</td>								
							</tr>
						</table>
					</div>
					
					<div data-role="fieldcontain">
	                    
							<?php
	                            
								$RowCount = 0;
	                            $BackColour = 	"";
								$ColorCode	=	"No";
								$WF_ID		=	"";	
								
								$_SelectQuery 	=   "SELECT * FROM tbl_wkequip WHERE `wf_date` = '".$today_date."' AND `wf_emp` = '$LogUserCode' AND `eq_id` = '$MCID'";        
	        					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	                            
	                            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
	
	                                $ColorCode	=	getEQUpdateStatus($str_dbconnect,$_myrowRes['eq_ser'], $LogUserCode, $today_date);	
									$WF_ID		=	$_myrowRes['eq_ser'];
									
	                                if($ColorCode == "Yes"){
	                                    $BackColour = "b";
	                                }
	
	                                if($ColorCode == "No"){
	                                    $BackColour = "c";
	                                }
									
									if($ColorCode == "N/A"){
	                                    $BackColour = "a";
	                                }
									
									$RowCount = $RowCount + 1;
									
									$EquipmentID  = $_myrowRes['eq_id'];
						            $EqMaintID = $_myrowRes['eq_type'];
						            
						            
						            $Equipment  = getEQList($str_dbconnect,$_myrowRes['eq_id']);
						            $EqMaint    = getEQMList($str_dbconnect,$_myrowRes['eq_id'], $_myrowRes['eq_type']);
						                    
						            $wk_name  = $EqMaint." : [".$_myrowRes['start_time']." - ".$_myrowRes['end_time']."]";
									
									echo "<ul data-role='listview' data-theme='".$BackColour."' data-inset='true'>";
									echo "<li><a data-theme='d' onclick=\"TransmitServices('".$WF_ID."','".$MCID."','".$MCNAME."')\">".$wk_name."</a></li>";
									echo "</ul>";
	                        ?>  
								
							<?php
								}
							?>
	                	
					</div>
                </form>
            </div>
            <div id="MWF_Footer" data-theme="a" data-role="footer" data-position="fixed">
                <h3>
                    Teknowledge &copy; 2012
                </h3>
            </div>
        </div>
		
    </body>
</html>