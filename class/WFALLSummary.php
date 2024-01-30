<?php
	
	
	session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("accesscontrole.php"); //  sql commands for the access controles
    include ("sql_empdetails.php"); //  connection file to the mysql database
    include ("sql_crtprocat.php");            //  connection file to the mysql database
    
    require_once("class.phpmailer.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database
    
    include ("sql_wkflow.php");            //  connection file to the mysql database
	
    include ("sql_sysusers.php");          //  sql commands for the access controls
    include ("sql_project.php");           //  sql commands for the access controls
    include ("sql_task.php");              //  sql commands for the access controles
   
    
    require_once("../class/class.phpmailer.php");    //
	require_once("../class/class.SMTP.php");


    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
    
	
	$path = "../";
	$Menue	= "UpdateWF";	
	
	$ProcessCountry = $_GET["Country"];
	
	//echo $ProcessCountry."</br>";
	
	$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' AND City = '$ProcessCountry'" or die(mysqli_error($str_dbconnect));
	$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
	
		$LogUserCode = $_myrowRes["EmpCode"];  
		$Country	 = $_myrowRes["Division"];
		
		//echo $LogUserCode."</br>";
		
		if ( validateLoading($str_dbconnect,$LogUserCode) < 1 ){ 
		
			//echo $LogUserCode." Got In</br>";
			            
	        Get_DailyWorkFlow($str_dbconnect,$LogUserCode, $Country);
	        Get_WeeklyWorkFlow($str_dbconnect,$LogUserCode, $Country);
	        Get_MonthlyWorkFlow($str_dbconnect,$LogUserCode, $Country);
	        Get_DailyEQFlow($str_dbconnect,$LogUserCode, $Country);
	        
	        updateSummary($str_dbconnect,$LogUserCode);	        
	    }
	}


function getGROUPNAMEDIV($str_dbconnect,$strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

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
	
	function getWFUPDATEMAILSUMMARY($str_dbconnect,Country, $Department){
        
        $HTML = "";
		
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
		if($Country == "FIJI"){
			$timezone = "Pacific/Fiji";	
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
        $HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width='700px' border=\"1px\">";
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
							wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$Country."' AND `report_Dept` = '".$Department."') ORDER BY `wk_owner`" or die(mysqli_error($str_dbconnect));
        $_ResultSet		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
	    $num_rows 		= 	mysqli_num_rows($_ResultSet);
		
		$Lastupdate		=	"";
		
		if($num_rows != 0){
		   
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {				
								
				$Employee = $_myrowRes['wk_owner'];				
				
				$EMPNAME = getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$Employee);
				
				if(($OLDEmployee != $Employee && $OLDEmployee != "")){				
					
					$HTML .= "<tr>"; 
							$HTML .= "<td colspan='4'>";
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
							$HTML .= "<td colspan='4'>";
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
					$HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width='700px' border=\"1px\">";
					
					$HTML .= "<thead>";
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
				    $HTML .= "<tbody>";
					
					$HTML .= "<tr>";
						$HTML .= "<td colspan='8' style=\"background-color: #FFE7A1\">";
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
						$HTML .= "[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'];
					$HTML .= "</td>";
					$HTML .= "<td>";
						$HTML .= $_myrowRes['start_time'];
					$HTML .= "</td>";
					$HTML .= "<td>";
						$HTML .= $_myrowRes['end_time'];
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
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        //$HTML .= "There are no Attachments to Download";
	                    }
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
						$HTML .= "<td colspan='4'>";
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
						$HTML .= "<td colspan='4'>";
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
		if($Country == "FIJI"){
			$timezone = "Pacific/Fiji";	
		}
	date_default_timezone_set($timezone);
	
	$today_date  	= 	date("m-d-Y");
	//$today_date  = "2011-12-14";
	while($_DptRes = mysqli_fetch_array($_DeptSet)) {		
	
		// $mailer = new PHPMailer();
	    // $mailer->IsSMTP();
	    // $mailer->Host = '10.9.0.166:25';					// $mailer->Host = 'ssl://smtp.gmail.com:465';
	    // $mailer->SetLanguage("en", 'class/');								//  $mailer->SetLanguage("en", '');
	    // $mailer->SMTPAuth = TRUE;
	    // $mailer->IsHTML = TRUE;
	    // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress    $mailer->Username = 'info@tropicalfishofasia.com';
	    // $mailer->Password = 'pms@321';  // Change this to your gmail password      $mailer->Password = 'info321';
	    // $mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress       $mailer->From = 'info@tropicalfishofasia.com';  
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
				$mail->CharSet = "text/html; charset=UTF-8;";
							
				//O365 Email Function END		
		
		$HTML = getWFUPDATEMAILSUMMARY($str_dbconnect,_DptRes['Country'], $_DptRes['GrpCode']);  
		
		//$WKOwner = Get_Supervior($str_dbconnect,$LogUserCode);
		
	    //$mailer->Body = $HTML;
		$mailer->Body =str_replace('"','\'',$HTML);	
		  
	    $mailer->Subject = "DAILY W/F SUMMARY AS OF ".$today_date." DIV. -".$_DptRes['Country']." / DEPT. - ".getGROUPNAMEDIV($str_dbconnect,$_DptRes['GrpCode']);
	    
		$today_date  	= 	date("Y-m-d");
		
		//$mailer->AddAddress('shameerap@cisintl.com');  // This is where you put the email adress of the person you want to mail
		$mailer->AddBCC('pms@cisintl.com');
	    /*$mailer->AddBCC('pms@cisintl.com');
	    $mailer->AddBCC('shameerap@cisintl.com');
	    $mailer->AddCC('indikag@cisintl.com');
		$mailer->AddCC('piumit@cisintl.com');
		$mailer->AddCC('admin@cisintl.com');
		$mailer->AddCC('nilukab@cisintl.com');
		//$MailAddressDpt = "";
			
		$DepartmentMails = getMailUSERFACILITIES($str_dbconnect,$_DptRes['GrpCode']);
        while($_MailRes = mysqli_fetch_array($DepartmentMails)) {
            $EmpDpt =    $_MailRes['EmpCode'];
            $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

            $mailer->AddAddress($MailAddressDpt);  // This is where you put the email adress of the person you want to mail
			
        }*/
		
		$_SelectQuery 		=   "SELECT DISTINCT wk_owner FROM tbl_workflowupdate WHERE `crt_date` = '".$today_date."' AND 
								wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$_DptRes['Country']."' AND `report_Dept` = '".$_DptRes['GrpCode']."') ORDER BY `wk_owner`" or die(mysqli_error($str_dbconnect));
        $DepartmentMails	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		while($_MailRes = mysqli_fetch_array($DepartmentMails)) {
            $EmpDpt =    $_MailRes['wk_owner'];
            $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

            $mailer->AddCC($MailAddressDpt);  // This is where you put the email adress of the person you want to mail
			
        }
		
		
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
								$mailer->AddCC($_myrowRes2['EMail']);
							}
						}						 
					}
					/*Adding Bcc Function on 2014-07-16 by thilina*/
					
		
		if($HTML != ""){		
		    if(!$mailer->Send())
		    {
		       /*echo "Message was not sent<br/ >";
		       echo "Mailer Error: " . $mailer->ErrorInfo;*/
		    }
		    else
		    {
		       /*echo "Message has been sent";*/
		    }
		}
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