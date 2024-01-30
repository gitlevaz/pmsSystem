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
        <title>Sample Page</title>  
		         
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
				
				$("#btn_LogOut1").click(function() {																				
					$.mobile.changePage( "index.php", { transition: "flip"} );								
					setTimeout(LogOut,1000);
			    });
				
				$("#btn_Back").click(function() {																				
					$.mobile.changePage( "#page1", { transition: "flip"} );					
			    });
				
				$("#btn_Back1").click(function() {																				
					$.mobile.changePage( "#page1", { transition: "flip"} );					
			    });
				
				$("#ScanQRCode").click(function() {																				
					$.mobile.changePage("ScanQR.php", { transition: "slide"} );								
					setTimeout(ScanQRCode,2000);
			    });
								 
			});
			
			function ListEquipments(){				
				$.mobile.changePage("#page2", { transition: "flip"});		
			}
			
			function LabourHours(){				
				$.mobile.changePage("#page3", { transition: "flip"});		
			}
			
		</script>	
		
    </head>
    <body>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div id="MWF_Header" data-theme="a" data-role="header">				
                <h1>
                    Welcome <?php echo $_SESSION["LogEmpName"]; ?>
					<?php echo $_COOKIE["UserCode"]; ?>
                </h1>				
				<a id="btn_LogOut" class='ui-btn-right' data-icon='refresh' data-theme="a" >Logout</a>                
            </div>
            <div data-role="content">
                <form action="">
                    <ul data-role="listview" data-divider-theme="b" data-inset="true">
                    <li data-role="list-divider" role="heading" style="text-align:center">
                        Select Options
                    </li>
                    <li data-theme="c">
                        <a id="ScanQRCode" onclick="ScanQRCode()">
                            Scan QR Code
                        </a>						
                    </li>
                    <li data-theme="c">
                        <a id="ListEquipments" onclick="ListEquipments()">
                            List equipments for the Day
                        </a>
                    </li>
					<li data-theme="c">
                        <a id="Labour" onclick="LabourHours()">
                            Scheduled Labour Hours for the day
                        </a>
                    </li>
					<li data-theme="c">
                        <a id="UpdateMail" >
                            Send WF Update Mail
                        </a>
                    </li>
                </ul>				
                </form>
            </div>
            <div id="MWF_Footer" data-theme="a" data-role="footer" data-position="fixed">
                <h3>
                    Teknowledge &copy; 2012
                </h3>
            </div>
        </div>		
		
		
		<?php			
			
			$Country	=	"";			
			
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
	
			date_default_timezone_set($timezone);			
	        
	        $LogUserCode = $_SESSION["LogEmpCode"];        
	        $today_date  = date("Y-m-d");
			
			Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country);
			
		?>
		
		<!--Starting Page Two-->
        <div data-role="page" id="page2">         
            <div data-role="header" data-theme="a" data-position="fixed">  
				<a id="btn_Back" class='ui-btn-left' data-icon='back' data-theme="a">Back</a>  
               <h5>
                    :: Mobile Work Flow System ::
               </h5>  
			   <a id="btn_LogOut" class='ui-btn-right' data-icon='refresh' data-theme="a" >Logout</a>                                              
            </div><!-- /header -->         
            
            <div data-role="content">  
                <form name="Error" id="Error"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;">
							<?php
	                            
								$RowCount = 0;
	                            $BackColour = 	"";
								$ColorCode	=	"No";
								$WF_ID		=	"";	
								
								$_SelectQuery 	=   "SELECT DISTINCT eq_id FROM tbl_wkequip WHERE `wf_date` = '".$today_date."' AND `wf_emp` = '$LogUserCode'";        
	        					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	                            
	                            while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {						            
						            
						            $Equipment  = getEQList($str_dbconnect,$_myrowRes['eq_id']);
						            /*$EqMaint    = getEQMList($str_dbconnect,$_myrowRes['eq_id'], $_myrowRes['eq_type']);*/
									
									echo "<ul data-role='listview' data-theme='b' data-inset='true'>";
									echo "<li><a data-theme='d' >".$Equipment."</a></li>";
									echo "</ul>";
	                        ?>  
								
							<?php
								}
							?>
                        </fieldset>
                    </div>                       	
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
				<a id="btn_Back1" class='ui-btn-left' data-icon='back' data-theme="a">Back</a>  
               <h5>
                    :: Mobile Work Flow System ::
               </h5>  
			   <a id="btn_LogOut2" class='ui-btn-right' data-icon='refresh' data-theme="a" >Logout</a>                                              
            </div><!-- /header -->         
            
            <div data-role="content">  
                <form name="page3" id="page3"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;">
							<?php
								echo "<ul data-role='listview' data-theme='b' data-inset='true'>";
								echo "<li><a data-theme='d' >B1 : Bagging Station [9:00 - 11:00]</a></li>";
								echo "</ul>";
								
								echo "<ul data-role='listview' data-theme='b' data-inset='true'>";
								echo "<li><a data-theme='d' >P1 : Packing Station [11:10 - 13:30]</a></li>";
								echo "</ul>";
								
								echo "<ul data-role='listview' data-theme='b' data-inset='true'>";
								echo "<li><a data-theme='d' >C1 : Clipping Station [13:35 - 14:30]</a></li>";
								echo "</ul>";
							?>	
                        </fieldset>
                    </div>                       	
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