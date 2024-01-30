<?php 
  include ("connection/sqlconnection.php");   
                                                 //  Role Autherization //  connection file to the mysql database
    include ("class/sql_project.php"); //  sql commands for the access controles
    include ("class/sql_task.php"); //  sql commands for the access controles
	include ("class/sql_getKJR.php"); //  sql commands for get KJR Details
    include ("class/accesscontrole.php"); //  sql commands for the access controles
    include ("class/sql_empdetails.php"); //  connection file to the mysql database
    require_once("class/class.phpmailer.php");
		require_once("../class/class.SMTP.php");
    include ("class/MailBodyOne.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php 
$Str_ProCode = "PRO/1372";
$Str_TaskCode = "TSK/1952";
 					$_ResultSet = get_SelectedProjectDetails($str_dbconnect,$Str_ProCode);
                    while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                        $_Division = $_myrowRes['Division'];
                        $_DepartCode = $_myrowRes['Department'];
                        $_ProInit       =   $_myrowRes['ProInit'];
                        $_strSecOwner   =   $_myrowRes["SecOwner"];
                        $_strSupport    =   $_myrowRes["Support"];
						$_ProInitiator    =   $_myrowRes["ProInit"];
                        $_ProOwner      =  $_myrowRes['ProOwner'];
                        $_ProCrt        =  $_myrowRes['crtusercode'];
                    }

                    $_Department = getGROUPNAME($str_dbconnect,$_DepartCode);
					$DepartmentMails = getTASKUSERFACILITIES($str_dbconnect,$Str_TaskCode);
                    while ($_MailRes = mysqli_fetch_array($DepartmentMails)) {
                        $EmpDpt = $_MailRes['EmpCode'];
                        $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

                        if ($TaskUsers == "") {
                            $TaskUsers = getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                        } else {
                            $TaskUsers = $TaskUsers . "/" . getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$EmpDpt);
                        }

                     //   $mailer->AddAddress($MailAddressDpt); // This is where you put the email adress of the person you want to mail
                    }
					if($str_ActionMemo == "on"){
						$MailTitile = "TO : " . $TaskUsers . " - NEW PMS / ACTION MEMO TASK ASSIGNED - " . $_Division . " " . $_Department . " - " . $Str_TaskName;	
					}
					else{
						$MailTitile = "TO : " . $TaskUsers . " - NEW PMS TASK ASSIGNED - " . $_Division . " " . $_Department . " - " . $Str_TaskName;		
					}
                    
                    $mailer->Subject = $MailTitile;

                    if($_ProOwner != ""){
                         $CC1 =getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner);
                    }

                    if($_strSecOwner != ""){
                         $CC2 =getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSecOwner);
                    }

                    if($_strSupport != ""){
                         $CC3 =getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_strSupport);
                    }

                    if($_ProCrt != ""){
                         $CC4 =getEMPMAILviaUSerCode($str_dbconnect,$_ProCrt);
                    }
					if($_ProInitiator != ""){
                         $CC5 =getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProInitiator);
                    }



$MagBody= "This is a test mail    -".$MailAddressDpt." - ".$CC1." - ".$CC2." - ".$CC3." - ".$CC4." - ".$CC5;
$StrFromMail = "pms@eTeKnowledge.com";
					// $mailer = new PHPMailer();
                    // $mailer->IsSMTP();
                    // $mailer->Host = '10.9.0.166:25';			// $mailer->Host = 'ssl://smtp.gmail.com:465'; 10.9.0.165:25
                    // $mailer->SetLanguage("en", 'class/');				// $mailer->SetLanguage("en", 'class/'); 69.63.218.231:25
                    // $mailer->SMTPAuth = TRUE;
                    // $mailer->IsHTML = TRUE;
                    // $mailer->Username = 'pms@eTeKnowledge.com'; // Change this to your gmail adress   $mailer->Username = 'info@tropicalfishofasia.com';
                    // $mailer->Password = 'pms@321'; // Change this to your gmail password			$mailer->Password = 'info321';
                    // $mailer->From = $StrFromMail; // This HAVE TO be your gmail adress
                    // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                    // $mailer->Body = $MagBody;
					
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
				$mailer->SetFrom('pms@eteknowledge.com','Work Flow');
				$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =str_replace('"','\'',$MagBody);
				
	//O365 Email Function END			
                    /* ----------------------------------------------------------------- */

					//$mailer->AddAddress("thilina.dtr@gmail.com");
					/* Added by thilina - 2014-06-24 */
					 $_ResultSet = get_AllReportRecipients($str_dbconnect);
					while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
						$Emp_Mail 	= "";
						$Emp_Mail    = $_myrowRes['Email_Address'];
						 $mailer->AddBCC($Emp_Mail);
					}
				/* Added by thilina - 2014-06-24 */
					
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
					
					
                    if (!$mailer->Send()) {
                        //echo "Message was not sent<br/ >";
                        echo "Mailer Error: " . $mailer->ErrorInfo;
                    }
                    else
                    {
                        echo "Message has been sent";
                    }

?>


</body>
</html>