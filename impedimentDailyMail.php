<?php 
include ('connection/reportconnection.php');
//include ('connection/sqlconnection.php');
require_once("class/class.phpmailer.php");  
require_once("class/class.SMTP.php");
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styleB.css" rel="stylesheet" type="text/css" />
<!--    Loading Jquerry Plugin  -->
<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<link rel="stylesheet" href="css/project.css" type="text/css"/>
<link rel="stylesheet" href="css/slider.css" type="text/css"/>
<link href="css/textstyles.css" rel="stylesheet" type="text/css"/>
<!-- **************** NEW GRID ***************** --><!-- **************** NEW GRID END ***************** -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" title="currentStyle">
        @import "media/css/demo_page.css";
        @import "media/css/demo_table.css";
</style>
<script src="ui/jquery.ui.core.js"></script>
<script src="ui/jquery.ui.widget.js"></script>
<script src="ui/jquery.ui.dialog.js"></script>
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
$obj = new Connection();
$obj->Connect();
$_ResultSet = $obj->get_impedimentDetails123();
while($_myrowRes = mysqli_fetch_array($_ResultSet)){	
$Dte_today          = 	date("Y-m-d") ;
date_default_timezone_set('Asia/Colombo');
$Dte_Time           = 	date("h:i:s a", time()) ;
$_Title     =   "P/M - Impediment Report as at ".$Dte_today." : ".$Dte_Time."."; 
$MailContent = "";
			$MailContent .= "<table align='center' style='border-style: hidden;  border-color: transparent'>";
            $MailContent .= "<tr style='border-style: hidden;  border-color: transparent' align='center'>";
          	$MailContent .= "<th>";
            $MailContent .= " <p align='center'><font size='5'><u>" . $_Title . "</u></font> </p>";                
            $MailContent .= "</th>";
            $MailContent .= " </tr>";
        	$MailContent .= "</table>";
        	$MailContent .= "<BR>";
			$MailContent .= "<table cellpadding='0' cellspacing='0' border='1' class='display' id='example2' width='1000px' style='font-family: verdana;font-size: 12px'>";
            $MailContent .= "<thead width='900px' align='left'>";
          	$MailContent .= "<tr align='left'>";
            $MailContent .= "<th width='100px'>Create Date</th>";                
            $MailContent .= "<th width='100px'>Task Code</th>";
            $MailContent .= "<th width='300px'>Task Name</th>";
        	$MailContent .= "<th width='200px'>From</th>";
        	$MailContent .= "<th width='200px'>Impedimented By</th>";
        	$MailContent .= "</tr>";		
        	$MailContent .= "</thead>";
        	$MailContent .= "<tbody width='900px' align='left'>";
			$CurrentProCode = "";
			$ColourCode = 0;
				if ($ColourCode == 0 ) {
					$Class = "gradeA";
					$ColourCode = 1 ;
				} elseif ($ColourCode == 1 ) {
					$Class = "gradeA";
					$ColourCode = 0;
				}				
            $MailContent .= "<tr style='cursor: pointer' align='left' bgcolor='#66CCCC'>";
            $MailContent .= "<td width='100px'>".$_myrowRes['create_date']." </td>";			
            $MailContent .= "<td width='100px'>".$_myrowRes['TaskCode']."</td>";  
			$MailContent .= "<td width='300px>". $obj->get_selectedTaskNAME123($_myrowRes['TaskCode'])."</td> ";            
            $MailContent .= "<td width='300px>". $obj->get_selectedTaskNAME123($_myrowRes['TaskCode'])."</td> ";          
         	$MailContent .= "<td width='200px'>".$obj->getSELECTEDEMPLOYENAME123($_myrowRes['created_by'])."</td>"; 
			$MailContent .= "<td width='200px'>".$_myrowRes['UserName']."</td>";		 	
            $MailContent .= "</tr>";           
			$MailContent .= " </tbody>";
			$MailContent .= "</table>";
			echo $MailContent;
	
			// $mailer = new PHPMailer();
			// $mailer->IsSMTP();
			// $mailer->Host = '10.9.0.166:25';				//$mailer->Host = 'ssl://smtp.gmail.com:465';
			// $mailer->SetLanguage("en", 'class/');							// $mailer->SetLanguage("en", '');
			// $mailer->SMTPAuth = TRUE;
			// $mailer->IsHTML = TRUE;
			// //$mailer->Username = 'info@tropicalfishofasia.com';  // Change this to your gmail adress
			// //$mailer->Password = 'info321';  // Change this to your gmail password
			// //$mailer->From = 'info@tropicalfishofasia.com';  // This HAVE TO be your gmail adress
			// $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress		$mailer->Username = 'info@tropicalfishofasia.com';
	        // $mailer->Password = 'pms@321';  // Change this to your gmail password						$mailer->Password = 'info321';
		    // $mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress		$mailer->From = 'info@tropicalfishofasia.com';
			// $mailer->FromName = 'Impediment'; // This is the from name in the email, you can put anything you like here	
			// $mailer->Body = $MailContent;
			
			//O365 Email Function Start
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','PMS');
				$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =str_replace('"','\'',$MailContent);
				
			//O365 Email Function END	
			
			$mailer->Subject = "P/M - Impediment Report as at ".$Dte_today." : ".$Dte_Time.".";	    
			$today_date  	= 	date("Y-m-d");
		
			$mail =  $obj->getSELECTEDEMPLOYENAMEMail($_myrowRes['EmpCode']);
			//echo $mail;
			$mailer->AddAddress($mail);
			//$mailer->AddAddress('thilinar@cisintl.com');  // This is where you put the email adress of the person you want to mail
			//$mailer->AddBCC('pms@cisintl.com');
			//$mailer->AddBCC('shameerap@cisintl.com');
			//$mailer->AddCC('indikag@cisintl.com');
			//$mailer->AddCC('piumit@cisintl.com');
			//$mailer->AddCC('dilinif@cisintl.com');
			//$mailer->AddCC('GermanH@Etropicalfish.com');		
			//$mailer->AddCC('admin@cisintl.com');
			//$mailer->AddCC('nilukab@cisintl.com');
			
				/*Adding Bcc Function on 2014-07-16 by thilina*/
					$_SelectQuery ="";
					$_SelectQuery 	=   "SELECT DISTINCT OwnerEmpCode FROM tbl_emailbccgroup WHERE Category='PMS' AND EmailBccStatus='A'" or die(mysqli_error($str_dbconnect));
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
	}
?>
</body>
</html>