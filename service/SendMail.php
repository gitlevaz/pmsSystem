<?php
 $connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php"); 
  require_once("../class/class.phpmailer.php");
  $EmpCode = $_GET["EmpCode"];
  $ProjCode = $_GET["ProjCode"];
  $TaskCode = $_GET["TaskCode"];
  
 //PHPMailer Object
 $mail = new PHPMailer;
 $mail->IsSMTP();
 $mail->Host = '10.9.0.166:25';	// $mailer->Host = '10.0.0.237';

 $mail->SMTPAuth = TRUE;

 $mail->IsHTML = TRUE; //Send HTML or Plain Text email
 $mail->Username = 'pms@cisintl.com'; // Change this to your gmail adress $mailer->Username = 'pms@cisintl.com';
 $mail->Password = 'info321'; // Change this to your gmail password $mailer->Password = 'info321'; 
 
 $query = "SELECT EMail , CONCAT_WS(' ', FirstName, LastName) as EmployeeName FROM tbl_employee WHERE EmpCode='$EmpCode'";       
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);


 $mail->From = "dhanukao@cisintl.com";  // This HAVE TO be your gmail adress
 $mail->FromName = 'PMS - '.$row["EmployeeName"]; // This is the from name in the email, you can put anything you like here
 
 $query1 = "select emp.EMail,  CONCAT_WS(' ', emp.FirstName, emp.LastName) as ProjIntiatorName,progrp.Group,proj.Division from tbl_projects proj inner join  tbl_employee emp on proj.ProInit=emp.EmpCode inner join  tbl_projectgroups progrp on proj.Department=progrp.GrpCode WHERE proj.procode='$ProjCode'";        
 $Result1=mysqli_query($link,$query1) or die(mysqli_error($link));
 $row1=mysqli_fetch_assoc($Result1);

  
 $mail->AddAddress("dhanukao@cisintl.com"); //To address 
 
 $query2 = "SELECT taskname FROM tbl_task WHERE taskcode ='$TaskCode'";        
 $Result2=mysqli_query($link,$query2) or die(mysqli_error($link));
 $row2=mysqli_fetch_assoc($Result2);

 $MailTitile = "TO : ".$row1["ProjIntiatorName"]." - TASK UPDATE- ".$row1["Division"]." ".$row1["Group"]." - ".$row2["taskname"];
 $mail->Subject = $MailTitile;
 
  $query3 = "SELECT Email FROM tbl_taskalert WHERE TaskCode ='$TaskCode'";
  $Result3=mysqli_query($link,$query3) or die(mysqli_error($link));
  $rows = array();
  while($r = mysqli_fetch_assoc($Result3))
   {
    $rows[] = $r;
   }
   
  foreach ($rows as $value) 
  {
	  //CC and BCC
	
	$ccmail=json_encode("dhanukao@cisintl.com");	 
    $mail->addCC($ccmail);
	//$ccmail=json_encode($value["Email"]);	 
    //$mail->addCC($ccmail);
   
  }
 
$mail->Body = "<i>Mail body in HTML</i>";
$mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Message has been sent successfully";
} 
?>