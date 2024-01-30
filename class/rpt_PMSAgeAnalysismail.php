<?php 
include ('../connection/reportconnection.php');
//include ('../connection/sqlconnection.php');
require_once("../class/class.phpmailer.php");
require_once("../class/class.SMTP.php");
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--    Loading Jquerry Plugin  -->
<link type="text/css" href="../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<!-- **************** NEW GRID ***************** --><!-- **************** NEW GRID END ***************** -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
$(document).ready(function() {
        $('#example').dataTable(
			{iDisplayLength: 25,		
          	bProcessing: true, 
			sPaginationType: "full_numbers",         	
			aLengthMenu: [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]]}
		);
		
		$('#example2').dataTable(
			
		);
    } );
</script>

<title>Report</title>
</head>

<body style="font-family: verdana;font-size: 12px">

<?php 

$Dte_today          = 	date("Y-m-d") ;
date_default_timezone_set('Asia/Colombo');
$Dte_Time           = 	date("h:i:s a", time()) ;
$_Title     =   "P/M - Status Delay Report as at ".$Dte_today." : ".$Dte_Time."."; 
$MailContent = "";
$MailContent .= "<table align='center' style='border-style: hidden;  border-color: transparent'>";
            $MailContent .= "<tr style='border-style: hidden;  border-color: transparent' align='center'>";
          	$MailContent .= "<th>";
            $MailContent .= " <p align='center'><font size='5'><u>" . $_Title . "</u></font> </p>";                
            $MailContent .= "</th>";
            $MailContent .= " </tr>";
        	$MailContent .= "</table>";
        	$MailContent .= "<BR>";
        	$MailContent .= "<table width='2000px' cellpadding='0' cellspacing='0' border='1' class='display' id='example'  style='font-family: verdana;font-size: 12px'>";		
        	$MailContent .= "<thead>";
        	$MailContent .= "<tr>";
            $MailContent .= "<th width='50px'>No</th>";
            $MailContent .= "<th width='150px'>Project Code</th>";
            $MailContent .= "<th width='200px'>Project Name</th>";
            $MailContent .= "<th width='400px'>Project Owner</th>";             
            $MailContent .= "<th width='1200px' >Task Details</th>";          
         	$MailContent .= " </tr> ";         
        	$MailContent .= "</thead>";	 
		 	$ColourCode = 0;		 
			$obj = new Connection();
			$obj->Connect();
			$_ResultSet1 = $obj->get_TaskDelayprojectDetails($Dte_today);
			
			$count =1;
			$MailContent .= "<tbody> ";
        	while($_myrowRes11 = mysqli_fetch_array($_ResultSet1))
      		 {			
				if ($ColourCode == 0 ) {
				$Class = 'even gradeA' ;
				$ColourCode = 1 ;
				} elseif ($ColourCode == 1 ) {
					$Class = 'odd gradeA';
					$ColourCode = 0 ;
				}
			        $MailContent .= "<tr>";
                    $MailContent .= "<td > ". $count." </td>";
                    $MailContent .= "<td > ". $_myrowRes11['procode']."</td>";
                    $MailContent .= "<td >". $_myrowRes11['proname']."</td>";
                    $MailContent .= "<td >". $_myrowRes11['FirstName']. $_myrowRes11['LastName']."</td>";
         			$MailContent .= "<td> ";                             
        			$MailContent .= "<table width='1200px'  cellpadding='0' cellspacing='0' border='1' class='display' id='example2'  style='font-family: verdana;font-size: 12px ;'>";
        			$MailContent .= "<tr bgcolor='#000000' style='color:#FFF'>";
            		$MailContent .= "<th width='200px'>Task Code </th>";
            		$MailContent .= "<th width='400px'>Task Name</th>";
            		$MailContent .= "<th width='100px'>Task Owners</th>";          
            		$MailContent .= "<th width='50px'>Start Date</th>";
            		$MailContent .= "<th width='50px' >End Date</th>";
            		$MailContent .= "<th width='100px'>Project / Task Status</th>";
            		$MailContent .= "<th width='50px'>% Completion</th>";
            		$MailContent .= "<th width='50px'>Delayed Days</th> ";           
           			$MailContent .= " <th width='250px'>Attachments</th></font>";
        			$MailContent .= "</tr>";
	
		 		$_ResultSet = $obj->get_TaskDelayDetails($str_dbconnect,$_myrowRes11['procode'],$Dte_today);
         		while($_myrowRes = mysqli_fetch_array($_ResultSet))
        		{			
			
        			$MailContent .= "<tr>";               
                    $MailContent .= "<td >".$_myrowRes['taskcode']."</td>";
                    $MailContent .= " <td > ".$_myrowRes['taskname']."  </td>";
                    $MailContent .= " <td > ". $obj->getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_myrowRes['AssignBy'])." </td> ";                   
                    $MailContent .= "<td  align='center' > ". $_myrowRes['taskcrtdate']." </td>";
                    $MailContent .= " <td  align='center'> ". $_myrowRes['taskenddate']." </td>";
                    $MailContent .= "<td  align='left' > ". $obj->GetStatusDesc($str_dbconnect,$_myrowRes['taskstatus'])." </td>";
                    $MailContent .= "<td  align='center'> ". $_myrowRes['Precentage'].'%'."</td>";
                    $MailContent .= "<td align='center' bgcolor='#FF99FF'>".$obj->getDelayeddates($_myrowRes['taskenddate'],$Dte_today)." </td>";                    $MailContent .= "<td align='left'>";                  

                        $_ResultSet10      = $obj->get_projectuploadupdates($str_dbconnect,$_myrowRes['taskcode']) ;
                        while($_myrowRes10 = mysqli_fetch_array($_ResultSet10)) {     
                          	$MailContent .= " '<a href='../files/' ". $_myrowRes10['SystemName'] ."'>'" .$_myrowRes10['SystemName']."'</a><br>';";
                        }
                        $MailContent .= "</td>";
                        $MailContent .= "  </tr>";               
				}
				$count ++;
			
				$MailContent .= "</table>";
            	$MailContent .= "</td>";
            	$MailContent .= "</tr>";
            
		}
         $MailContent .= "</tbody>";
		$MailContent .= "</table>";
		//echo $MailContent;
		$MailContent1="Hii";
		// $mailer = new PHPMailer();
	    // $mailer->IsSMTP();
	    // $mailer->Host = '10.9.0.166:25';						// $mailer->Host = 'ssl://smtp.gmail.com:465';
	    // $mailer->SetLanguage("en", 'class/');									// $mailer->SetLanguage("en", '');
	    // $mailer->SMTPAuth = TRUE;
	    // $mailer->IsHTML = TRUE;
	    // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress		$mailer->Username = 'info@tropicalfishofasia.com';
	    // $mailer->Password = 'pms@321';  // Change this to your gmail password				$mailer->Password = 'info321';
	    // $mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress		$mailer->From = 'info@tropicalfishofasia.com';
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
		
		//$mailer->Body = $MailContent;
		$mailer->Body =str_replace('"','\'',$MailContent);
		$mailer->Subject = "P/M - Status Delay Report as at ".$Dte_today." : ".$Dte_Time.".";	    
		$today_date  	= 	date("Y-m-d");
		
		
	//	$mailer->AddAddress('thilinar@cisintl.com');  // This is where you put the email adress of the person you want to mail
	    $mailer->AddBCC('pms@cisintl.com');
	   // $mailer->AddBCC('shameerap@cisintl.com');
	    $mailer->AddCC('indikag@cisintl.com');
		//$mailer->AddCC('piumit@cisintl.com');
		$mailer->AddCC('dilinif@cisintl.com');
		$mailer->AddCC('GermanH@Etropicalfish.com');		
		$mailer->AddCC('admin@cisintl.com');
		$mailer->AddCC('nilukab@cisintl.com');
		
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
					
		
		
		if($MailContent != ""){		
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
?>
</body>
</html>