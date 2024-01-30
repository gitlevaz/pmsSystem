<?php 
require_once('nusoap/nusoap.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
function Sendparam() {
            var pageUrl = '<%=ResolveUrl("http://66.81.19.236/HRIMSTest/WEBService/PMSWFService.asmx")%>'
            $.ajax({
                type: "POST",
                url: pageUrl + "/Test" ,
                data: "{'tID':'123'}",
                contentType: "application/json; charset=utf-8",
				async:false,
                dataType: "json",
                success: OnSuccessGetFAImages,
                error: OnErrorGetFAImages
            });
        }

        function OnSuccessGetFAImages(response) {
            //FullyAnnotatedImageString = response.d;
           // GetNAImages();
		    alert(response.d);
        }

        function OnErrorGetFAImages(response, errorThrown) {
            alert(response.status + " " + response.statusText + " " + errorThrown);
        }
		
		
</script>


</head>

<body>
<?php 




		
if(isset($_POST['test123'])){
/*	$client = new SoapClient("http://66.81.19.236/HRIMSTest/WEBService/PMSWFService.asmx?WSDL");
	$paraId = '123';
$params = array( 'tID'  => $paraId);
$result = $client->Test($params)->TestResult;
echo $result;*/

$_CompCode = "CIS";
$Str_ProCode = "PRO/1205";
$Str_TaskCode = "TSK/1653";
$Str_TaskParent = "0";
$Str_SubLevel = "1";
 $Str_TaskName="This is Eight sample Task by Thilina";
 $Str_TaskDescription="<p>This is Eight sample Task by Thilina</p>";
$Str_StartDate="2013-08-02";
$Str_EndDate = "2013-08-09";
$Str_EstHours="64";
$Str_AssignUser="";
$Str_Priority="High";
$taskstatus="I";
$_CrtBy="EMP/2";
$Precentage="0";
$Str_MailAddress = "shameerap@cisintl.com-";
$kjrcode="1";
$indicaotrcode="2";
$subindicatorcode="3";

$client = new SoapClient("http://66.81.19.236/HRIMSTest/WEBService/PMSWFService.asmx?WSDL");
/*$params = array( 'status'  => 'in','compcode'  => $CompCode,'procode'  => $ProCode ,'taskcode'  => $taskcode,'parent'  => $parent,'sublevel'  =>$sublevel ,'taskname'  =>$taskname ,'TaskDetails'  => $TaskDetails,'taskcrtdate'  => $taskcrtdate,'taskenddate'  => $taskenddate,'AllHours'  => $AllHours,'assignuser'  => $assignuser,'Priority'  => $Priority,'taskstatus'  => $taskstatus,'AssignBy'  => $AssignBy,'Precentage'  => $Precentage,'MailCCTo'  => $MailCCTo,'KJRid'  => $KJRid,'Indicatorid'  => $Indicatorid,'SubIndicatorid'  => $SubIndicatorid);
$result = $client->UpdatePMSTask($params)->UpdatePMSTaskResult;*/
$params = array( 'status'  => 'in','compcode'  => $_CompCode,'procode'  => $Str_ProCode,'taskcode'  => $Str_TaskCode,'parent'  => $Str_TaskParent,'sublevel'  => $Str_SubLevel,'taskname'  => $Str_TaskName,'TaskDetails'  => $Str_TaskDescription,'taskcrtdate'  => $Str_StartDate,'taskenddate'  => $Str_EndDate,'AllHours'  => $Str_EstHours,'assignuser'  => $Str_AssignUser,'Priority'  => $Str_Priority,'taskstatus'  => 'I','AssignBy'  => $_CrtBy,'Precentage'  => '0','MailCCTo'  => $Str_MailAddress,'KJRid'  => $kjrcode,'Indicatorid'  => $indicaotrcode,'SubIndicatorid'  => $subindicatorcode);
$result = $client->UpdatePMSTask($params)->UpdatePMSTaskResult;
echo $result;
	
	
	//$data = array(
//    'name'     => $_POST['name'],
//    'lastname' => $_POST['last_name'],
//    'address'  => $_POST['address']
//  );  
//
//	$some_data = 123;
//  $curl = curl_init('http://207.232.87.236/HRIMSTest/WEBService/PMSWFService.asmx?op=Test');
//
//
//  curl_setopt($curl, CURLOPT_POST, 1); //Choosing the POST method
//  curl_setopt($curl, CURLOPT_URL, 'http://207.232.87.236/HRIMSTest/WEBService/PMSWFService.asmx?op=Test');  // Set the url path we want to call
//  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
//  curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);  // Insert the data
//
//  // Send the request
//  $result = curl_exec($curl);
//
//  // Free up the resources $curl is using
//  curl_close($curl);
//
//  echo $result;

//.....................................................................................................................................
	//$client = new nusoap_client('http://207.232.87.236/HRIMSTest/WEBService/PMSWFService.asmx?op=Test', 'wsdl','', '', '', '');
//	$client = new nusoap_client('http://207.232.87.236/HRIMSTest/WEBService/PMSWFService.asmx','','', '', '', '');
//	$err = $client->getError();
//	if ($err) {
//		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
//	}
//	$param = "123";
//	//$result = $client->call('Test', $param, '','', false, true);
//	$result = $client->call('Test', $param,'','','','');
//
//	if ($client->fault) {
//		echo '<h2>Fault</h2><pre>';
//		print_r($result);
//		echo '</pre>';
//	} else {
//		// Check for errors
//		$err = $client->getError();
//		if ($err) {
//			// Display the error
//			echo '<h2>Error</h2><pre>' . $err . '</pre>';
//		} else {
//			// Display the result
//			echo '<h2>Result</h2><pre>';
//			print_r($result);
//			echo '</pre>';
//		}
//	}
//.....................................................................................................................................

//.....................................................................................................................................
 //$client = new SoapClient("http://10.0.0.236/HRIMSTest/WEBService/PMSWFService.asmx?WSDL");
// $err = $client->getError();
//	if ($err) {
//		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
//	}
// $params->Param1 = '123';     
// $result = $client->Test($params);
// echo $result;

//......................................................................................................................................




}

?>
<form id="testfrm" name="testfrm"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="submit" id="test123" name="test123" value="Click me" ">
</form>
</body>
</html>