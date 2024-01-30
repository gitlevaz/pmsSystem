
<?php


/**
 * Created by JetBrains PhpStorm.
 * User: shameera
 * Date: 5/26/11
 * Time: 11:40 AM
 * To change this template use File | Settings | File Templates.
 */
    session_start();

    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database       //  connection file to the mysql database
    include ("../class/sql_sysusers.php");          //  sql commands for the access controls
    include ("../class/sql_project.php");           //  sql commands for the access controls
    include ("../class/sql_task.php");              //  sql commands for the access controles
    include ("../class/accesscontrole.php");        //  sql commands for the access controles
    include ("../class/sql_empdetails.php");        //  connection file to the mysql database
    //include ("../class/class.phpmailer.php");       //  connection file to the mysql database
    require_once("../class/class.phpmailer.php");
    //include ("../class/sql_crtprocat.php");    //  connection file to the mysql database
    //include ("../class/MailBodyOne.php");           //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

    $MailBody           =   "Test Mail";
    $PageRoll           =   1;
    $TitleEntered       =   0;

    $_DepartCode    = "";
    $_Department    = "";
    $_Division      = "";
    $_Title         = "";

                $mailer = new PHPMailer();
                $mailer->IsSMTP();
                //$mailer->Host = '10.9.0.166:25';			//$mailer->Host = 'ssl://smtp.gmail.com:465';
				$mailer->Host = '66.81.19.237/ews/exchange.asmx';
                $mailer->SetLanguage("en", 'class/');						//$mailer->SetLanguage("en", '');
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML = TRUE;
				$mailer->Username = 'shameerap@cisintl.com';  // Change this to your gmail adress      $mailer->Username = 'info@tropicalfishofasia.com'; 
                $mailer->Password = 'iits2009';  // Change this to your gmail password          $mailer->Password = 'info321';
                $mailer->From = 'shameerap@cisintl.com';  // This HAVE TO be your gmail adress       $mailer->From = 'info@tropicalfishofasia.com';
                //$mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress      $mailer->Username = 'info@tropicalfishofasia.com'; 
                //$mailer->Password = 'pms@321';  // Change this to your gmail password          $mailer->Password = 'info321';
                //$mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress       $mailer->From = 'info@tropicalfishofasia.com';
                //$mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                $mailer->Body = $MailBody;
                //$mailer->Body = CreateReportForMail($Str_ProCode);
                $mailer->Subject = $_Title;
                $mailer->AddAddress('shameerap@eteknowledge.com');  // This is where you put the email adress of the person you want to mail
				$mailer->AddAddress('osandar@eteknowledge.com');  // This is where you put the email adress of the person you want to mail
                $mailer->AddBCC('pms@cisintl.com');
                //$mailer->AddBCC('shameerap@cisintl.com');
                //$mailer->AddCC();

                if(!$mailer->Send())
                {
                   echo "Message was not sent<br/ >";
                   echo "Mailer Error: " . $mailer->ErrorInfo;
                }
                else
                {
                   echo "Message has been sent";
                }


?>