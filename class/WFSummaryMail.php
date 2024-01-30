<?php 
echo '<script>console.log("Test")</script>';
?>
<?php

	session_start();
	
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database       //  connection file to the mysql database
    include ("../class/sql_sysusers.php");          //  sql commands for the access controls
    include ("../class/sql_project.php");           //  sql commands for the access controls
    include ("../class/sql_task.php");              //  sql commands for the access controles
    include ("../class/accesscontrole.php");        //  sql commands for the access controles
    include ("../class/sql_empdetails.php");        //  connection file to the mysql database
    require_once("../class/class.phpmailer.php");    //
	require_once("../class/class.SMTP.php");
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	

	function getGROUPNAMEDIV($str_dbconnect,$strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}
	
	function getCoveringPerson($str_dbconnect,$wk_id) {
		$covring='';
		$_SelectQuery 	= 	"SELECT * FROM `tbl_wfcoveringperson` WHERE `FacCode`='$wk_id'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$covring	=	$_myrowRes["UserName"]." , ".$covring;
		}

		return $covring ;
	}

	function getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$_EmpCode) {

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_EmpName   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName   =   $_myrowRes['FirstName']. " " .$_myrowRes['LastName'];
        }

        return $_EmpName ;

    }
	
	function ConvertMinutes2Hours($Minutes)
	{
	    if ($Minutes < 0)
	    {
	        $Min = Abs($Minutes);
	    }
	    else
	    {
	        $Min = $Minutes;
	    }
	    $iHours = Floor($Min / 60);
	    $Minutes = ($Min - ($iHours * 60)) / 100;
	    $tHours = $iHours + $Minutes;
	    if ($Minutes < 0)
	    {
	        $tHours = $tHours * (-1);
	    }
	    $aHours = explode(".", $tHours);
	    $iHours = $aHours[0];
	    if (empty($aHours[1]))
	    {
	        $aHours[1] = "00";
	    }
	    $Minutes = $aHours[1];
	    if (strlen($Minutes) < 2)
	    {
	        $Minutes = $Minutes ."0";
	    }
	    $tHours = $iHours .":". $Minutes;
	    return $tHours;
	}
	
	function getWFUPDATEMAILSUMMARY($str_dbconnect,$Country,$Department){
		// $Country='SL';
        // $Department='DPT/4';
		$HTML = "";
		
		$TotalMin_Allocated = 0;
		$TotalMin_Utilized = 0;
		
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}

		if($Country == "UK"){
			$timezone = "Europe/London";
		}	
	
		if($Country == "MLD"){
			$timezone = "Indian/Maldives";
		}	

		if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}

		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		date_default_timezone_set($timezone);
		
        $today_date  = date("Y-m-d");
		//$today_date  = "2011-12-14";
        
        $_EmpName    =   "";
        $_DesCode    =   "";
		
		/*$_SelectQuery 	=   "SELECT * FROM tbl_projectgroups ORDER BY Country" or die(mysqli_error($str_dbconnect));
        $_DeptSet 		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
		
		$HTML .= "<html>";
        $HTML .= "<head>";
        $HTML .= "<style type=\"text/css\">
            body{
                font-family:sans serif;
                font-size:12px;
                color:#000066;
            }            
            table{
                border-collapse:collapse;
                border:1px solid black;
                border-color: #000066;
            }
            th{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
            td{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
        </style>";
        
        $HTML .= "</head>";
        $HTML .= "<body>";
		$HTML .= "</br>";
		
		/*$HTML .= "<center><h1><b>Daily Work Flow : </b>".$today_date."</h1></center></br>";
        $HTML .= "<center><h2><b>W/F Usre : </b>".$_EmpName ."</h2></center></br>";
        $HTML .= "</br></br>" ;
		
		$HTML .= "</br>".$_DptRes['Country']. "-" . $_DptRes['GrpCode'] ."</br>" ;*/
		$HTML .= "<left>";
		$HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width=\"30%\" border=\"1px\">"; 			
			$HTML .= "<tr>";
				$HTML .= "<td style='background-color:#daffca' align='center'>";
					$HTML .= "COMPLETED";
				$HTML .= "</td>";
				$HTML .= "<td style='background-color:#ffcaca' align='center'>";
					$HTML .= "NOT COMPLETED";
				$HTML .= "</td>";
				$HTML .= "<td style='background-color:#cae8ff' align='center'>";
					$HTML .= "NOT APPLICABLE";
				$HTML .= "</td>";
			$HTML .= "</tr>";
		$HTML .= "</table>";
		$HTML .= "</left>";
		
		$HTML .= "</br></br>";
		/*width=\"100%\" style=\"background-color: #FFE7A1\"*/
        $HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width='1200px' border=\"1px\">";
		$HTML .= "</tbody>";
        /*$HTML .= "<thead>";
        $HTML .= "<tr>";            
			$HTML .= "<th rowspan='2'>#No</th>";        
	        $HTML .= "<th rowspan='2' width='300px'>Task Name</th>";
	        $HTML .= "<th rowspan='2'>Start Time</th>";
			$HTML .= "<th rowspan='2'>End Time</th>";
			$HTML .= "<th colspan='3'>Task Status</th>";
	        $HTML .= "<th rowspan='2'>Notes & Attachments</th>";                                                
        $HTML .= "</tr>";
		$HTML .= "<tr>";
			$HTML .= "<th rowspan='2'>Done</th>";
	        $HTML .= "<th rowspan='2'>In Complete</th>";
			$HTML .= "<th rowspan='2'>N/A</th>";
		$HTML .= "</tr>";
        $HTML .= "</thead>";
        $HTML .= "<tbody>";*/
		
			        
		$CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;	
		
		$DepartmentN	= 	getGROUPNAMEDIV($str_dbconnect,$Department);

		$OLDCountry		=	"";
		$OLDDeprtment	=	"";
		$OLDEmployee	=	"";
		
		$_SelectQuery 	=   "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '".$today_date."' AND 
							`wk_id` in (SELECT `wk_id` FROM tbl_workflow WHERE `report_div` = '".$Country."' AND `report_Dept` = '".$Department."') ORDER BY `wk_owner`" or die(mysqli_error($str_dbconnect));
        $_ResultSet		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
	    $num_rows 		= 	mysqli_num_rows($_ResultSet);
		
		$Lastupdate		=	"";
		
		if($num_rows != 0){
		   
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {				
								
				$Employee = $_myrowRes['wk_owner'];				
				
				$EMPNAME = getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$Employee);
				echo "<br/> ".$DepartmentN. " - " .$EMPNAME;
				if(($OLDEmployee != $Employee && $OLDEmployee != "")){				
					
					$HTML .= "<tr>"; 
							$HTML .= "<td colspan='6'>";
								$HTML .= "<font color='Red' size='2'>Summary Total For Daily Task - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
					$HTML .= "</tr>";
					
					$TotalTask = $CYes + $CNo + $CNA;
					
					$HTML .= "<tr>"; 
							$HTML .= "<td colspan='6'>";
								$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio of - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
					$HTML .= "</tr>";	
					
					$HTML .= "<tr>"; 
						$HTML .= "<td colspan='9'>";
							$HTML .= "<font color='Red' size='2'>Total Time Allocated - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";						
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
					$HTML .= "</tr>";	
					
					$HTML .= "<tr>"; 
							$HTML .= "<td colspan='9'>";
								$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
							$HTML .= "</td>";						
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
								$TotalMin_Utilized = 0;
							$HTML .= "</td>";
					$HTML .= "</tr>";							
					
					$Lastupdate	= "0";			
					
					$CYes 	= 0;
					$CNo	= 0;
			        $CNA	= 0;	
					
					$Lastupdate	=	"1";
					echo "OLD EMPLOYEE : ".$OLDEmployee."</br>";
					echo "Employee EMPLOYEE : ".$Employee."</br>";
				}	
				
				
				if(($OLDCountry != $Country || $OLDCountry == "") || ($OLDDeprtment != $Department || $OLDDeprtment == "") || ($OLDEmployee != $Employee || $OLDEmployee == "")){
					
					/*$HTML .= "<tr>";
						$HTML .= "<td colspan='8'>";
							//$HTML .= "<font color='Red' size='2'>Divsion : ".$Country. " | Department : ".$DepartmentN . " | Employee : ".$EMPNAME."</font>" ;
							$HTML .= "&nbsp;";
						$HTML .= "</td>";	
					$HTML .= "</tr>";*/
					
					$HTML .= "</tbody>";
					$HTML .= "</table>";
					$HTML .= "</br></br>";
					$HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width='1200px' border=\"1px\">";
					
					$HTML .= "<thead>";
			        $HTML .= "<tr>";            
						$HTML .= "<th rowspan='2'>#No</th>";        
				        $HTML .= "<th rowspan='2' width='300px'>Task Name</th>";
				        $HTML .= "<th rowspan='2'>Schedule Time</th>";
						$HTML .= "<th rowspan='2'>Time Allocated</th>";
						$HTML .= "<th rowspan='2'>Actual Hrs Spent</th>";
						$HTML .= "<th rowspan='2'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='2'>Workflow Attachments By Creator</th>";  
						$HTML .= "<th rowspan='2'>Updated Workflow Attachments By User / Supervisor #</th>"; 
						$HTML .= "<th rowspan='2'>Covering Person</th>";                                              
			        $HTML .= "</tr>";
					$HTML .= "<tr>";
						$HTML .= "<th rowspan='2'>Done</th>";
				        $HTML .= "<th rowspan='2'>In Complete</th>";
						$HTML .= "<th rowspan='2'>N/A</th>";
					$HTML .= "</tr>";
					$HTML .= "</thead>";
				    $HTML .= "<tbody>";
					
					$HTML .= "<tr>";
						$HTML .= "<td colspan='12' style=\"background-color: #FFE7A1\">";
							$HTML .= "<font color='Red' size='2'>Divsion : ".$Country. " | Department : ".$DepartmentN . " | Employee : ".$EMPNAME."</font>" ;
						$HTML .= "</td>";	
					$HTML .= "</tr>";
					
					$RowCount = 1;
				}	
				
				$OLDCountry 	= $Country;
				$OLDDeprtment 	= $Department;
				
				
				$BGCOLOR = "";
				
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}				
				
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";
						$HTML .= $RowCount ;
					$HTML .= "</td>";
					$RowCount = $RowCount + 1;
					$HTML .= "<td>";						
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td align='center'>";
						$HTML .= $_myrowRes['start_time']."-".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td align='center'>";
						$hours = 0;
						$minutes = 0;
						
						$datetime1 = new DateTime($_myrowRes['start_time']);
						$datetime2 = new DateTime($_myrowRes['end_time']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Allocated = $TotalMin_Allocated + (($hours * 60) + $minutes );						
					$HTML .= "</td>";
					
					$HTML .= "<td align='center'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";
					$HTML .= "<td align='center'>";
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            $HTML .= "<a href='https://pms.tkse.lk/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        //$HTML .= "There are no Attachments to Download";
	                    }
					$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM WorkflowAttachments WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            $HTML .= "<a href='https://pms.tkse.lk/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        //$HTML .= "There are no Attachments to Download";
	                    }
					$HTML .= "</td>";
					$HTML .= "<td> ";
					$HTML .= getCoveringPerson($str_dbconnect,$_myrowRes['wk_id']);
					
				$HTML .= "</td>";
				$HTML .= "</tr>";	
				
				/*if(($OLDEmployee != $Employee && $OLDEmployee != "")){					
						$HTML .= "<tr>"; 
								$HTML .= "<td colspan='4'>";
									$HTML .= "<font color='Red' size='2'>Summary Total For Daily Task</font>";
								$HTML .= "</td>";
								$HTML .= "<td>";
									$HTML .= $CYes;
								$HTML .= "</td>";
								$HTML .= "<td>";
									$HTML .= $CNo;
								$HTML .= "</td>";
								$HTML .= "<td>";
									$HTML .= $CNA;
								$HTML .= "</td>";
								$HTML .= "<td>";
									$HTML .= "";
								$HTML .= "</td>";
						$HTML .= "</tr>";					
					
					$Lastupdate	= "0";
				}	*/			
				$OLDEmployee 	= $Employee;				
	        }
			if($CYes != 0 || $CNo != 0 || $CNA != 0){
				
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='7'>";
							$HTML .= "<font color='Red' size='2'>Summary Total For Daily Task - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
				$HTML .= "</tr>";	
				
				$TotalTask = $CYes + $CNo + $CNA;
					
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='7'>";
							$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio of - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
				$HTML .= "</tr>";	
				
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='11'>";
							$HTML .= "<font color='Red' size='2'>Total Time Allocated - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";						
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
				$HTML .= "</tr>";	
				
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='11'>";
							$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";						
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
				$HTML .= "</tr>";	
											
			}
					          
	        $HTML .= "</tbody>";
	        $HTML .= "</table>";  
	        $HTML .= "</body>";
	        $HTML .= "</html>";  
        }else{
			$HTML = "";	
		}
        return $HTML ;
		
    }
	
	$ProcessCountry = $_GET["Country"];

	$_SelectQuery 	=   "SELECT * FROM tbl_projectgroups WHERE Country = '$ProcessCountry'" or die(mysqli_error($str_dbconnect));
    $_DeptSet 		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	$timezone = "Asia/Colombo";	
		
	$Country = $ProcessCountry;
		
	if($Country == "SL"){
		$timezone = "Asia/Colombo";	
	}
	
	if($Country == "US"){
		$timezone = "America/Los_Angeles";
	}
	
	if($Country == "TI"){
		$timezone = "Asia/Bangkok";
	}	
	if($Country == "UK"){
		$timezone = "Europe/London";
	}	
	
	if($Country == "MLD"){
		$timezone = "Indian/Maldives";
	}	
if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
	date_default_timezone_set($timezone);
	
	$today_date  	= 	date("m-d-Y");
	//$today_date  = "2011-12-14";
	echo $today_date;
	$count=0;
	$num_rows 		= 	mysqli_num_rows($_DeptSet);
	echo "department set .$num_rows.</Br>";
	while($_DptRes = mysqli_fetch_array($_DeptSet)) {	
		$count=$count+1;
		echo ".$count. done</Br>";	
		// $mailer = new PHPMailer();
	    // $mailer->IsSMTP();
	    // $mailer->Host = '10.9.0.166:25';             // $mailer->Host = 'ssl://smtp.gmail.com:465';  //69.63.218.231:25 //  10.9.0.165:25
	    // $mailer->SetLanguage("en", 'class/');							// $mailer->SetLanguage("en", '');
	    // $mailer->SMTPAuth = TRUE;
	    // $mailer->IsHTML = TRUE;
	    // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress      $mailer->Username = 'info@tropicalfishofasia.com';
		// $mailer->Password = 'pms@321';  // Change this to your gmail password      $mailer->Password = 'info321';
	    // $mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress        $mailer->From = 'info@tropicalfishofasia.com'; 
	    // $mailer->FromName = 'WORKFLOW'; // This is the from name in the email, you can put anything you like here	
		
		//O365 Email Function Start
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','WORKFLOW');
								
				//O365 Email Function END			
		
		echo $_DptRes['GrpCode'];
		
		$HTML = getWFUPDATEMAILSUMMARY($str_dbconnect,$_DptRes['Country'], $_DptRes['GrpCode']);  
		
		//$WKOwner = Get_Supervior($str_dbconnect,$LogUserCode);
		
	    //$mailer->Body = $HTML;
		$mailer->Body =str_replace('"','\'',$HTML);
		//echo $HTML;
		
		$mailer->Subject = "DAILY W/F SUMMARY AS OF ".$today_date." DIV. -".$_DptRes['Country']." / DEPT. - ".getGROUPNAMEDIV($str_dbconnect,$_DptRes['GrpCode']);
	    
		$today_date  	= 	date("Y-m-d");
		
		echo "Sendimg Mail";
		$mailer->AddAddress('raveenl@eteknowledge.com');
		//$mailer->AddAddress('shameerap@cisintl.com');  // This is where you put the email adress of the person you want to mail
	    //$mailer->AddBCC('ITmgt@cisintl.com');
		// $mailer->AddBCC('kishanij@eteknowledge.com');
		//$mailer->AddBCC('dhanukao@eteknowledge.com');
		//$mailer->AddBCC('ishankap@eteknowledge.com');
		//$mailer->AddBCC('umeshr@eteknowledge.com');
		//$mailer->AddBCC('chamarar@cisintl.com');
	    //$mailer->AddCC('prajapriya@gmail.com');
		//$mailer->AddCC('dilinif@cisintl.com');
		//$mailer->AddCC('GermanH@Etropicalfish.com');		
		//$mailer->AddCC('admin@cisintl.com');
		//$mailer->AddCC('nilukab@cisintl.com');
		$MailAddressDpt = "";
	
	
		$DepartmentMails = getMailUSERFACILITIES($str_dbconnect,$_DptRes['GrpCode']);
        while($_MailRes = mysqli_fetch_array($DepartmentMails)) {
            $EmpDpt =    $_MailRes['EmpCode'];
            $MailAddressDpt = getSELECTEDACTIVEEMPLOYEEMAIL($str_dbconnect,$EmpDpt);
			// $mailer->AddAddress('ishankap@eteknowledge.com');
          // $mailer->AddAddress($MailAddressDpt);  // This is where you put the email adress of the person you want to mail
        }
		/*
		$_SelectQuery 		=   "SELECT DISTINCT wk_owner FROM tbl_workflowupdate WHERE `crt_date` = '".$today_date."' AND 
								wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$_DptRes['Country']."' AND `report_Dept` = '".$_DptRes['GrpCode']."') ORDER BY `wk_owner`" or die(mysqli_error($str_dbconnect));
        $DepartmentMails	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		while($_MailRes = mysqli_fetch_array($DepartmentMails)) {
            $EmpDpt =    $_MailRes['wk_owner'];
            //$MailAddressDpt = getSELECTEDACTIVEEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

           //$mailer->AddCC($MailAddressDpt);  // This is where you put the email adress of the person you want to mail
        }
		*/
		echo "BCC Function";
		
			/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='WORKFLOW' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
					$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {						
						if($_SESSION["LogEmpCode"]==$_myrowRes['OwnerEmpCode'])
						{
						$loggedUser = $_myrowRes['OwnerEmpCode'];
							$_SelectQuery = "";
							$_SelectQuery 	=   "SELECT DISTINCT b.BccEmpCode,e.EMail FROM tbl_emailbccgroup b JOIN tbl_employee e ON b.BccEmpCode=e.EmpCode WHERE OwnerEmpCode='$loggedUser' AND Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
							$_ResultSet2 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
							while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) 
							{
								//$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
		echo "Over";			
		
		if($HTML != ""){		
		    if(!$mailer->Send())
		    {
		       echo "Message was not sent<br/ >";
		       echo "Mailer Error: " . $mailer->ErrorInfo;
		    }
		    else
		    {
		       echo "Message has been sent";
		    }
		}
		
		echo "Mail Connection Completed";
	
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>.: PMS :. | Employee Details</title>
</head>
<body>
	<?php /*echo "Test";*/ ?>
	<input type="text" style="background-color"/>
</body>
</html>
