<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');

$mailStr = "";	
$mailId = $_GET["MailID"];
$mailType = $_GET["MailType"];
$mailSql = "SELECT mail_address FROM tbl_mailinformationheader h join tbl_mailinformationdetail d ON h.mail_id = d.mail_id " .
	       "WHERE h.mail_id='" . $mailId . "'  AND d.mail_id='" . $mailId . "' AND d.mail_recepient_type='" . $mailType . "'";
					  
$mailResult = mysqli_query($link,$mailSql) or die(mysqli_error($link));
		
while($mailRow = mysqli_fetch_assoc($mailResult)) {
	$mailStr .= $mailRow['mail_address'] . ",";
}

$array = "[{";
$array = $array.'"MailBody":"'  . $mailStr .'"}]';
echo $array;

?>