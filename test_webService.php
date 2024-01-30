<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 

		$_CompCode    =	"CIS";
		$Str_ProCode  =	"PRO/1059";
		$Str_TaskCode =	"TSK/1870";
		$Str_TaskParent    =	"0";
		$Str_SubLevel    =	"1";
		$Str_TaskName    =	"Test By Shameera 06";
		$Str_TaskDescription    =	"Test By Shameera 06";
		$Str_StartDate    =	"2013-10-11";
		$Str_EndDate    =	"2013-10-11";
		$allhours   =	"0";
		$assi =	"";
		$Str_Priority    =	"None";
		$_CrtBy    =	"EMP/2";
		$Str_MailAddress   =	"shameerap@cisintl.com";
		$kjrcode    =	"0";
		$indicaotrcode   =	"0";
		$subindicatorcode    =	"0";
		$epfno = "98";


$client = new SoapClient("http://66.81.19.236/HRIMSTest/WEBService/PMSWFService.asmx?WSDL");

		$params = array( 'status'  => 'in','compcode'  =>  $_CompCode,'procode'  => $Str_ProCode,'taskcode'  => $Str_TaskCode,'parent'  => $Str_TaskParent,'sublevel'  => $Str_SubLevel,'taskname'  => $Str_TaskName,'TaskDetails'  => $Str_TaskDescription,'taskcrtdate'  => $Str_StartDate,'taskenddate'  => $Str_EndDate,'AllHours'  => $allhours,'assignuser'  => $assi,'Priority'  => $Str_Priority,'taskstatus'  => 'I','AssignBy'  => $_CrtBy,'Precentage'  => '0','MailCCTo'  => $Str_MailAddress,'KJRid'  => $kjrcode,'Indicatorid'  => $indicaotrcode,'SubIndicatorid'  => $subindicatorcode,'ETFNo'  => $epfno);
		$result = $client->UpdatePMSTask($params)->UpdatePMSTaskResult;
echo $result;
?>
</body>
</html>