<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php"); 
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyA6zP4EK_ybh_mhMzTBE8FwVXqXF3XMr9A' );
//$registrationIds = array( $_GET['id'] );



 $query = "SELECT DeviceId FROM tbl_pushnotificationdevice WHERE EmployeeId='".$_GET["EmpCode"]."'";        
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $row=mysqli_fetch_assoc($Result);
 
$registrationIds = array($row["DeviceId"]);
//$registrationIds = array('APA91bHyJg03pKphUoOd-KuOh2rA8UAc3lwG_d7KbQ9qsXzXY60_UcA-jr_7taPOoN-qVSQ_SJCkTZjxnC7xU7RF3A_i4Ldmx_UtrZbBk5efUYQPXyIF-6yWIVaxWAx4xl49vGn4zsSp');
// prep the bundle
$msg = array
(
	'message' 	=> $_GET["Message"],
	'title'		=> $_GET["Title"],
	'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);
$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,                                      
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;
?>