<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sql_task
 *
 * @author Prajapriya
 */
 
  
class sql_task {
    //put your code here
}
function get_SerialTask($str_dbconnect,$str_Serial, $str_Description) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_Serial_Val    =	-1;

    $_SelectQuery   = 	"SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '$str_Serial'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_Serial_Val	=   $_myrowRes['Serial'];
    }

    if($_Serial_Val == -1)
    {
        $_SelectQuery 	=   "INSERT INTO tbl_serials (`CompCode`, `Code`, `Serial`, `Desription`) VALUES ('$_CompCode', '$str_Serial', '0', '$str_Description')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery 	=   "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '$str_Serial'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_Serial_Val    =	$_myrowRes['Serial'];
        }

    }

    $_Serial_Val = $_Serial_Val + 1;

    $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '$str_Serial'" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_Serial_Val;

}

function gettemporySerial($str_dbconnect) {

    $Str_TaskCode    = 	get_SerialTask($str_dbconnect,"1021", "TASK CATEGORY TEMPORY");
    $Str_TaskCode    = 	"TSK@".$Str_TaskCode;

    return $Str_TaskCode;
}

function get_TaskDetails($str_dbconnect,$Str_ProjectCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$Str_ProjectCode' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}
/* ................  KJR insertion 2013-07-24............. */
function get_KJRDetails($str_dbconnect,$empno) {
	
		$_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$empno'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $etf    =	$_myrowRes['EmpNIC'];
        }

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_kjr where etfno='$etf'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}


/* ....................................................... */

function get_TaskPrimaryUpdate($str_dbconnect,$Str_TaskCode, $StrCategoryCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {

        $num_AllTask    =   0;
        $num_AllActive  =   0;
        $num_AllCompleted   =   0;
        $num_AllWaiting = 0;

        $Str_ProCode    =	$_myrowRes["procode"];

    }

    $_SelectQuery       = 	    "SELECT * FROM tbl_task WHERE procode = '$Str_ProCode'" or die(mysqli_error($str_dbconnect));
    $RecordCount        =       mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    $num_AllTask        =       mysqli_num_rows($RecordCount);

    $_SelectQuery       = 	    "SELECT * FROM tbl_task WHERE procode = '$Str_ProCode' AND `taskstatus` <> 'C' AND `taskstatus` <> 'W'" or die(mysqli_error($str_dbconnect));
    $RecordCount        =       mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    $num_AllActive      =       mysqli_num_rows($RecordCount);

    $_SelectQuery       = 	    "SELECT * FROM tbl_task WHERE procode = '$Str_ProCode' AND `taskstatus` = 'C'" or die(mysqli_error($str_dbconnect));
    $RecordCount        =       mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    $num_AllCompleted   =       mysqli_num_rows($RecordCount);

    $_SelectQuery       = 	    "SELECT * FROM tbl_task WHERE procode = '$Str_ProCode' AND `taskstatus` = 'W'" or die(mysqli_error($str_dbconnect));
    $RecordCount        =       mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    $num_AllWaiting     =       mysqli_num_rows($RecordCount);

    if($StrCategoryCode == "Completed"){
        if($num_AllActive == 0){
            $_SelectQuery   = 	"UPDATE tbl_Projects SET `prostatus` = 'W' WHERE `procode` = '$Str_ProCode'";
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        }

        if($num_AllActive > 0){
            $_SelectQuery   = 	"UPDATE tbl_Projects SET `prostatus` = 'A' WHERE `procode` = '$Str_ProCode'";
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        }
    }

    if($StrCategoryCode == "Update"){
        $_SelectQuery   = 	"UPDATE tbl_Projects SET `prostatus` = 'A' WHERE `procode` = '$Str_ProCode'";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

    if($StrCategoryCode == "Approved"){
        if($num_AllTask == $num_AllCompleted){
            $_SelectQuery   = 	"UPDATE tbl_Projects SET `prostatus` = 'C' WHERE `procode` = '$Str_ProCode'";
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        }
    }

    if($StrCategoryCode == "Reject"){
        $_SelectQuery   = 	"UPDATE tbl_Projects SET `prostatus` = 'A' WHERE `procode` = '$Str_ProCode'";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

}

function get_TaskDetailsEmp($str_dbconnect,$Str_ProjectCode, $EmpCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$Str_ProjectCode' AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EmpCode') ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_TaskDetailsEmpPRINT($str_dbconnect,$Str_ProjectCode, $EmpCode, $_TskStatus) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   =   "";
    
    if($EmpCode != "ALL"){
        if($_TskStatus != "ALL"){
            $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = '$_TskStatus' AND procode = '$Str_ProjectCode' AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EmpCode') ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
        }else{
            $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$Str_ProjectCode' AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EmpCode') ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
        }
    }else{
        if($_TskStatus != "ALL"){
            $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = '$_TskStatus' AND procode = '$Str_ProjectCode' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
        }else{
            $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$Str_ProjectCode' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
        }
    }

    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

/* ................... Create by thilina on 2013-07-19 to find out the details of delayed tasks...............................*/
function get_TaskDelayDetails($str_dbconnect,$Dte_today,$Str_ProjectCode, $EmpCode) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_SelectQuery   =   "";   
	
	if($EmpCode != "ALL"){  
	$_SelectQuery   = 	"SELECT p.procode, p.proname,e.FirstName,e.LastName, t.taskcode, t.taskname, t.taskcrtdate, t.taskenddate, t.taskstatus, t.Precentage FROM tbl_task t INNER JOIN tbl_projects p INNER JOIN tbl_employee e ON t.procode=p.procode AND p.ProOwner=e.EmpCode  WHERE (t.taskstatus='I' OR t.taskstatus='A' OR t.taskstatus='W' OR t.taskstatus='H' OR t.taskstatus='S') AND t.taskenddate < '$Dte_today' ORDER BY t.taskenddate,sublevel, parent" or die(mysqli_error($str_dbconnect));      
			// $_SelectQuery   = 	"SELECT p.procode, p.proname,e.FirstName,e.LastName, t.taskcode, t.taskname, t.taskcrtdate, t.taskenddate, t.taskstatus, t.Precentage FROM tbl_task t INNER JOIN tbl_projects p INNER JOIN tbl_employee e ON t.procode=p.procode AND p.ProOwner=e.EmpCode  WHERE (t.taskstatus='I' OR t.taskstatus='A' OR t.taskstatus='W' OR t.taskstatus='H' OR t.taskstatus='S')AND p.procode = '$Str_ProjectCode' AND t.taskenddate < '$Dte_today' AND t.taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EmpCode') ORDER BY t.taskenddate,sublevel, parent" or die(mysqli_error($str_dbconnect));
           
    }else{
		$_SelectQuery   = 	"SELECT p.procode, p.proname,e.FirstName,e.LastName, t.taskcode, t.taskname, t.taskcrtdate, t.taskenddate, t.taskstatus, t.Precentage FROM tbl_task t INNER JOIN tbl_projects p INNER JOIN tbl_employee e ON t.procode=p.procode AND p.ProOwner=e.EmpCode  WHERE (t.taskstatus='I' OR t.taskstatus='A' OR t.taskstatus='W' OR t.taskstatus='H' OR t.taskstatus='S') AND t.taskenddate < '$Dte_today' ORDER BY t.taskenddate,sublevel, parent" or die(mysqli_error($str_dbconnect));
        // $_SelectQuery   = 	"SELECT p.procode, p.proname,e.FirstName,e.LastName, t.taskcode, t.taskname, t.taskcrtdate, t.taskenddate, t.taskstatus, t.Precentage FROM tbl_task t INNER JOIN tbl_projects p INNER JOIN tbl_employee e ON t.procode=p.procode AND p.ProOwner=e.EmpCode  WHERE (t.taskstatus='I' OR t.taskstatus='A' OR t.taskstatus='W' OR t.taskstatus='H' OR t.taskstatus='S')AND p.procode = '$Str_ProjectCode' AND t.taskenddate < '$Dte_today'  ORDER BY t.taskenddate,sublevel, parent" or die(mysqli_error($str_dbconnect));
    } 
   
           // $_SelectQuery   = 	"SELECT p.procode, p.proname,e.FirstName,e.LastName, t.taskcode, t.taskname, t.taskcrtdate, t.taskenddate, t.taskstatus, t.Precentage FROM tbl_task t INNER JOIN tbl_projects p INNER JOIN tbl_employee e ON t.procode=p.procode AND p.ProOwner=e.EmpCode  WHERE (t.taskstatus='I' OR t.taskstatus='A' OR t.taskstatus='W' OR t.taskstatus='H' OR t.taskstatus='S') AND t.taskenddate < '$Dte_today' ORDER BY t.taskenddate,sublevel, parent" or die(mysqli_error($str_dbconnect));
			    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    return $_ResultSet;
}

/* ............................................................................................................................ */

function get_TaskSubLevel($str_dbconnect,$Str_TaskCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskCode' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_TaskDetailsParent($str_dbconnect,$Str_taskCode, $Str_Sublevel) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE parent = '$Str_taskCode' AND sublevel = '$Str_Sublevel' ORDER BY parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_MaximumSub($str_dbconnect,$Str_ProjectCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT MAX(sublevel) FROM tbl_task WHERE procode = '$Str_ProjectCode' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function validate_taskunderparent($str_dbconnect,$Str_taskCode) {

    $_CompCode      =	$_SESSION["CompCode"];


    $_SelectQuery   = 	"SELECT COUNT(*) FROM tbl_task WHERE parent = '$Str_taskCode' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function create_Task($str_dbconnect,$Str_ProCode,$Str_ProCat,$Str_TaskName, $Str_TaskDescription, $Str_TaskParent, $Str_StartDate, $Str_EndDate, $Str_EstHours,$Str_Priority, $MailCC,$kjrcode,$indicaotrcode,$subindicatorcode,$ttcode,$filecount){
	
    $_CompCode      =   $_SESSION["CompCode"];
    $_CrtBy         =	$_SESSION["LogEmpCode"];
    $_UPLCode       =   $_SESSION["NewUPLCode"];
    $Dte_SysDate    = 	date("Y/m/d") ;

    $Str_TaskCode    = 	get_SerialTask($str_dbconnect,"1002", "TASK CODE");
    $Str_TaskCode    = 	"TSK/".$Str_TaskCode;

    $Str_SubLevel   =   0;

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskParent' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $Str_SubLevel    =	$_myrowRes["sublevel"];
    }

    $Str_SubLevel   =   $Str_SubLevel + 1;
    $Str_MailAddress    =   "";
    if($MailCC <> "") {
        for($a=0;$a<sizeof($MailCC);$a++){
             $Str_MailAddress .= $MailCC[$a]."-";
        }
    }
    
	 $allhours = $Str_EstHours;
	 //$allhours =  substr( $allhours,0,-6);
	 list($allhours,$mins,$secs)= split('[:]', $Str_EstHours);
	 $allhours = $allhours;
    $Str_EstHours = $Str_EstHours."00:00";
	$assi="";
	 //echo $epfno;

    $_SelectQuery   = 	"INSERT INTO tbl_task (`compcode`, `procode`, `taskcode`,`procat`, `parent`, `sublevel`, `taskname`, `TaskDetails`, `taskcrtdate`, `taskenddate`, `AllHours`, `assignuser`, `Priority`, `taskstatus`, `AssignBy`, `MailCCTo`,`KJRid`,`Indicatorid`,`SubIndicatorid`)VALUES ('$_CompCode', '$Str_ProCode', '$Str_TaskCode','$Str_proCode', '$Str_TaskParent', '$Str_SubLevel', '$Str_TaskName', '$Str_TaskDescription',  '$Str_StartDate', '$Str_EndDate', '$Str_EstHours', '', '$Str_Priority',  'I', '$_CrtBy', '$Str_MailAddress','$kjrcode','$indicaotrcode','$subindicatorcode')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


	if(0==$filecount)
	{	
	}
 	else 
	{
		if (1==$filecount)
		{
			$_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_TaskCode' WHERE `procode` = '$_UPLCode'";
			mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		}
		else
		{			
			for($x=1; $x<=$filecount; $x++)
			{
				$firsttempUPL = $_UPLCode;
				$_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_TaskCode' WHERE `procode` = '$firsttempUPL'";
				mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
				$_UPLCodeNumber = substr($_UPLCode,4);
				$_UPLCodeNumber = $_UPLCodeNumber+1;
				$_UPLCode = "UPL-".$_UPLCodeNumber;				
			}
		}
	}
    

    return $Str_TaskCode;
}

function UpdateTASKDETAILSKJRBase($str_dbconnect,$ttcode){

		$_CompCode    =	"";
		$Str_ProCode  =	"";
        $Str_TaskCode =	"";
        $Str_ProCat   = "";
		$Str_TaskParent    =	"";
		$Str_SubLevel    =	"";
		$Str_TaskName    =	"";
		$Str_TaskDescription    =	"";
		$Str_StartDate    =	"";
		$Str_EndDate    =	"";
		$allhours   =	"";
		$assi    =	"";
		$Str_Priority    =	"";
		$_CrtBy    =	"";
		$Str_MailAddress   =	"";
		$kjrcode    =	"";
		$indicaotrcode   =	"";
		$subindicatorcode    =	"";

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$ttcode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_CompCode    =	$_myrowRes["compcode"];
        $Str_ProCode  =	$_myrowRes["procode"];
        $Str_ProCat   = $_myrowRes["procat"];
		$Str_TaskCode =	$_myrowRes["taskcode"];
		$Str_TaskParent    =	$_myrowRes["parent"];
		$Str_SubLevel    =	$_myrowRes["sublevel"];
		$Str_TaskName    =	$_myrowRes["taskname"];
		$Str_TaskDescription    =	$_myrowRes["TaskDetails"];
		$Str_StartDate    =	$_myrowRes["taskcrtdate"];
		$Str_EndDate    =	$_myrowRes["taskenddate"];
		$allhours   =	$_myrowRes["AllHours"];
		$assi    =	"";
		$Str_Priority    =	$_myrowRes["Priority"];
		$_CrtBy    =	$_myrowRes["AssignBy"];
		$Str_MailAddress   =	$_myrowRes["MailCCTo"];
		$kjrcode    =	$_myrowRes["KJRid"];
		$indicaotrcode   =	$_myrowRes["Indicatorid"];
		$subindicatorcode    =	$_myrowRes["SubIndicatorid"];
		$_SelectQuery11   = 	"SELECT * FROM tbl_taskowners WHERE TaskCode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
   	    $_ResultSet11     =   mysqli_query($str_dbconnect,$_SelectQuery11) or die(mysqli_error($str_dbconnect));
        while($_myrowRes11 = mysqli_fetch_array($_ResultSet11)) {
       		$emp    =	$_myrowRes11["EmpCode"];
			$_SelectQuery1122   = 	"SELECT * FROM tbl_employee WHERE EmpCode = '$emp'" or die(mysqli_error($str_dbconnect));
			$_ResultSet1122     =   mysqli_query($str_dbconnect,$_SelectQuery1122) or die(mysqli_error($str_dbconnect));
			while($_myrowRes1122 = mysqli_fetch_array($_ResultSet1122)) {
				$epfno    =	$_myrowRes1122["EmpNIC"];				
			}
		//$client = new SoapClient("http://66.81.19.236/HRIMS/WEBService/PMSWFService.asmx?WSDL");

		$params = array( 'status'  => 'in','compcode'  =>  $_CompCode,'procode'  => $Str_ProCode,'taskcode'  => $Str_TaskCode,'parent'  => $Str_TaskParent,'sublevel'  => $Str_SubLevel,'taskname'  => $Str_TaskName,'TaskDetails'  => $Str_TaskDescription,'taskcrtdate'  => $Str_StartDate,'taskenddate'  => $Str_EndDate,'AllHours'  => $allhours,'assignuser'  => $assi,'Priority'  => $Str_Priority,'taskstatus'  => 'I','AssignBy'  => $_CrtBy,'Precentage'  => '0','MailCCTo'  => $Str_MailAddress,'KJRid'  => $kjrcode,'Indicatorid'  => $indicaotrcode,'SubIndicatorid'  => $subindicatorcode,'ETFNo'  => $epfno);
		//$result = $client->UpdatePMSTask($params)->UpdatePMSTaskResult;
		 //echo $result . "</Br>";
    	}
    }
	

}

function updateMain_Task($str_dbconnect,$Str_ProCode, $Str_TaskCode,  $Str_TaskName, $Str_ProCat,$Str_TaskDescription, $Str_TaskParent, $Str_StartDate, $Str_EndDate, $Str_EstHours, $Str_AssignUser, $Str_Priority, $MailCC){

    $_CompCode      =   $_SESSION["CompCode"];
    $_CrtBy         =	$_SESSION["LogEmpCode"];
    $_UPLCode       =   $_SESSION["NewUPLCode"];
    $Dte_SysDate    = 	date("Y/m/d") ;

   // $Str_TaskCode    = 	get_SerialTask($str_dbconnect,"1002", "TASK CODE");
    //$Str_TaskCode    = 	"TSK/".$Str_TaskCode;

    $Str_SubLevel   =   0;

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskParent' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $Str_SubLevel    =	$_myrowRes["sublevel"];
    }

    $Str_SubLevel   =   $Str_SubLevel + 1;
    $Str_MailAddress    =   "";
    if($MailCC <> "") {
        for($a=0;$a<sizeof($MailCC);$a++){
             $Str_MailAddress .= $MailCC[$a]."-";
        }
    }

    $Str_EstHours = $Str_EstHours."00:00";
    
    $_SelectQuery   = 	"UPDATE tbl_task SET `procat` = '$Str_ProCat',`parent` = '$Str_TaskParent', `sublevel` = '$Str_SubLevel', `taskname` = '$Str_TaskName', `TaskDetails` = '$Str_TaskDescription', `taskcrtdate` = '$Str_StartDate', `taskenddate` = '$Str_EndDate', `AllHours` = '$Str_EstHours', `Priority`= '$Str_Priority', `AssignBy` = '$_CrtBy', `MailCCTo` = '$Str_MailAddress'  WHERE `taskcode` = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_TaskCode' WHERE `procode` = '$_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $Str_TaskCode;
}

function DeleteMain_Task($str_dbconnect,$Str_TaskCode){

    $_CompCode      =   $_SESSION["CompCode"];
    $_CrtBy         =	$_SESSION["LogEmpCode"];
    $_UPLCode       =   $_SESSION["NewUPLCode"];


    $_SelectQuery   = 	"DELETE FROM  tbl_task WHERE `taskcode` = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_SelectQuery   = 	"DELETE FROM prodocumets WHERE `ParaCode` = '$Str_TaskCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_SelectQuery   = 	"DELETE FROM tbl_taskowners WHERE `TaskCode` = '$Str_TaskCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $Str_TaskCode;
}


function get_userTaskDetails($str_dbconnect) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_EmpCode       =   $_SESSION["LogEmpCode"];
/*
    echo "<script>";
    echo " alert('$_EmpCode'+8);";
    echo "</script>";*/

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$_EmpCode') ORDER BY `procode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_userprojecttaskDetails($str_dbconnect,$ProCode) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_EmpCode       =   $_SESSION["LogEmpCode"];
/*
    echo "<script>";
    echo " alert('$_EmpCode'+8);";
    echo "</script>";*/
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus <> 'C'  AND procode = '$ProCode' AND active = 1 AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$_EmpCode') ORDER BY `procode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_userprojecttaskDetailsUSER($str_dbconnect,$ProCode, $_EmpCode) {

    $_CompCode      =	$_SESSION["CompCode"];
//    $_EmpCode       =   $_SESSION["LogEmpCode"];
/*
    echo "<script>";
    echo " alert('$_EmpCode'+8);";
    echo "</script>";*/

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus <> 'C'  AND procode = '$ProCode' AND active = 1 AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$_EmpCode') ORDER BY `procode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_selectedTask($str_dbconnect,$Str_TaskCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_selectedTaskNAME($str_dbconnect,$Str_TaskCode) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_TaskName      =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_TaskName      =   $_myrowRes['taskname'];
    }

    return $_TaskName;
}

function getUpdatedate($str_dbconnect,$taskcode) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_TaskName      =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$taskcode' AND category='Task Completed'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_updatedate      =   $_myrowRes['UpdateDate'];		 
    }
    return  $_updatedate ;
}

function getRequestedBy($str_dbconnect,$taskcode) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_TaskName      =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_apptask WHERE TaskCode = '$taskcode' AND category='Task Completed'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_requested      =   $_myrowRes['crtusercode'];
		$_SelectQuery2   = 	"SELECT * FROM tbl_employee WHERE EmpCode = '$_requested'" or die(mysqli_error($str_dbconnect));
    	$_ResultSet2     =   mysqli_query($str_dbconnect,$_SelectQuery2) or die(mysqli_error($str_dbconnect));

		while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) {
			$_emp     =   $_myrowRes2['FirstName']." ".$_myrowRes2['LastName'];
		}
    }

    return  $_emp ;
}

function get_ApproveTaskDetails($str_dbconnect,$Category) {

    $_EmpCode       =   $_SESSION["LogEmpCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_apptask WHERE AppStat = 'A' AND `Category` = '$Category' AND `ProInit` = '$_EmpCode' " or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}


function get_USERApproveTaskDetails($str_dbconnect,$Category, $_EmpCode) {

//    $_EmpCode       =   $_SESSION["LogEmpCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_apptask WHERE AppStat = 'A' AND `Category` = '$Category' AND `ProInit` = '$_EmpCode' " or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

//.................. for the update of KJR ........................
function updateTaskStatusKJRBase($str_dbconnect,$_TaskCode, $_Priority,$Precentage,$empcode){
	
	$_SelectQuery1122   = 	"SELECT * FROM tbl_employee WHERE EmpCode = '$empcode'" or die(mysqli_error($str_dbconnect));
			$_ResultSet1122     =   mysqli_query($str_dbconnect,$_SelectQuery1122) or die(mysqli_error($str_dbconnect));
			while($_myrowRes1122 = mysqli_fetch_array($_ResultSet1122)) {
				$epfno    =	$_myrowRes1122["EmpNIC"];				
			}
			/*echo $epfno;echo "<br/>";
			echo $_TaskCode;echo "<br/>";
			echo $_Priority;echo "<br/>";
			echo $Precentage;echo "<br/>";*/	
			$_Priority1="Z";
//	$client = new SoapClient("http://66.81.19.236/HRIMSTest/WEBService/PMSWFService.asmx?WSDL");

	//	$params = array( 'status'  => $_Priority,'Precentage'  =>$Precentage,'ETFNo'  => $epfno,'taskCode'  =>$_TaskCode);
	//	$result = $client-> UpdatePercentageStatus($params)->UpdatePercentageStatusResult;
		 //echo $result;

// $client->UpdatePMSTask($params)->UpdatePMSTaskResult;
}

//..................................................................

function updateTaskStatus($str_dbconnect,$_TaskCode, $_Priority, $_TaskDescription, $Precentage, $Start, $End, $HoursSpent, $HrsRequest){

    $Dte_SysDate    = 	date("Y/m/d") ;
    $_EmpCode       =   $_SESSION["LogEmpCode"];

    $Str_UpdateCode    = 	get_SerialTask($str_dbconnect,"1030", "TASK UPDATE SERIALS");
    $Str_UpdateCode    = 	"UPD/".$Str_UpdateCode;

    $_SelectQuery   = 	"INSERT INTO tbl_taskupdates (`UpdateCode`, `taskcode`, `category`, `Note`, `Status`, `UpdateDate`, `SpentFrom`, `SpentTo`, `TotHors`, `HrsRequest`, `UpdateUser`,`up_status`)VALUES ('$Str_UpdateCode', '$_TaskCode', '$_Priority', '$_TaskDescription', 'A', '$Dte_SysDate', '$Start', '$End', '$HoursSpent', '$HrsRequest', '$_EmpCode','Open')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_SelectQuery   = 	"UPDATE tbl_task SET `Precentage` = '$Precentage' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_UPLCode       =   $_SESSION["NewUPLCode"];

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$_TaskCode', `FileName` = 'TSK' WHERE `procode` = '$_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_crtusercode   =   "";
    $_projectowner  =   "";
    $_projectInit   =   "";
    $_projeccode    =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode IN (SELECT procode FROM tbl_task WHERE active = 1 AND taskcode = '$_TaskCode')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_projeccode    =   $_myrowRes['procode'];
        $_crtusercode   =   $_myrowRes['crtusercode'];
        $_projectowner  =   $_myrowRes['ProOwner'];
        $_projectInit   =   $_myrowRes['ProInit'];
    }


    if($_Priority == "Task Completed"){
        $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'W' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery   = 	"INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ('$_TaskCode', '$_Priority', '$_EmpCode', '$_projectowner', '$_projectInit', 'A', '$Str_UpdateCode')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$_Priority123="W";
		updateTaskStatusKJRBase($str_dbconnect,$_TaskCode,$_Priority123,$Precentage, $_EmpCode);
    }

    if($_Priority == "Addl Hrs Request"){
        $_SelectQuery   = 	"INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ('$_TaskCode', '$_Priority', '$_EmpCode', '$_projectowner', '$_projectInit', 'A', '$Str_UpdateCode')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

    if($_Priority == "Task Started"){
        $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'A' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery   = 	"UPDATE tbl_projects SET `prostatus` = 'A' WHERE `procode` = '$_projeccode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$_Priority123="A";
		updateTaskStatusKJRBase($str_dbconnect,$_TaskCode,$_Priority123,$Precentage, $_EmpCode);
    }

}

function updateTaskStatusApprove($str_dbconnect,$_TaskCode, $_Priority, $_TaskDescription, $Precentage, $Start, $End, $HoursSpent, $HrsRequest){

    $Dte_SysDate    = 	date("Y/m/d") ;
    $_EmpCode       =   $_SESSION["LogEmpCode"];

    $Str_UpdateCode    = 	get_SerialTask($str_dbconnect,"1030", "TASK UPDATE SERIALS");
    $Str_UpdateCode    = 	"UPD/".$Str_UpdateCode;

    $_SelectQuery   = 	"INSERT INTO tbl_taskupdates (`UpdateCode`, `taskcode`, `category`, `Note`, `Status`, `UpdateDate`, `SpentFrom`, `SpentTo`, `TotHors`, `HrsRequest`)VALUES ('$Str_UpdateCode', '$_TaskCode', '$_Priority', '$_TaskDescription', 'A', '$Dte_SysDate', '$Start', '$End', '$HoursSpent', '$HrsRequest')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_SelectQuery   = 	"UPDATE tbl_task SET `Precentage` = '$Precentage' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_UPLCode       =   $_SESSION["NewUPLCode"];

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$_TaskCode', `FileName` = 'TSK' WHERE `procode` = '$_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_crtusercode   =   "";
    $_projectowner  =   "";
    $_projectInit   =   "";
    $_projeccode    =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE active = 1 AND procode IN (SELECT procode FROM tbl_task WHERE taskcode = '$_TaskCode')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_projeccode    =   $_myrowRes['procode'];
        $_crtusercode   =   $_myrowRes['crtusercode'];
        $_projectowner  =   $_myrowRes['ProOwner'];
        $_projectInit   =   $_myrowRes['ProInit'];
    }


    if($_Priority == "Task Completed"){
        $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'W' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery   = 	"INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ('$_TaskCode', '$_Priority', '$_EmpCode', '$_projectowner', '$_projectInit', 'A', '$Str_UpdateCode')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

    if($_Priority == "Addl Hrs Request"){
        $_SelectQuery   = 	"INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ('$_TaskCode', '$_Priority', '$_EmpCode', '$_projectowner', '$_projectInit', 'A', '$Str_UpdateCode')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

    if($_Priority == "REJECT"){
        $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'A' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery   = 	"UPDATE tbl_projects SET `prostatus` = 'A' WHERE `procode` = '$_projeccode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

}

function updateTaskComment($str_dbconnect,$_TaskCode, $_Priority, $_TaskDescription, $Precentage, $Start, $End, $HoursSpent, $HrsRequest){

    $Dte_SysDate    = 	date("Y/m/d") ;

    $Str_UpdateCode    = 	get_SerialTask($str_dbconnect,"1030", "TASK UPDATE SERIALS");
    $Str_UpdateCode    = 	"UPD/".$Str_UpdateCode;

    $_SelectQuery   = 	"INSERT INTO tbl_taskupdates (`UpdateCode`, `taskcode`, `category`, `Note`, `Status`, `UpdateDate`, `SpentFrom`, `SpentTo`, `TotHors`, `HrsRequest`)VALUES ('$Str_UpdateCode', '$_TaskCode', '$_Priority', '$_TaskDescription', 'A', '$Dte_SysDate', '$Start', '$End', '$HoursSpent', '$HrsRequest')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    //$_SelectQuery   = 	"UPDATE tbl_task SET `Precentage` = '$Precentage' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
    //mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_UPLCode       =   $_SESSION["NewUPLCode"];

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$_TaskCode', `FileName` = 'TSK' WHERE `procode` = '$_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_crtusercode   =   "";
    $_projectowner  =   "";
    $_projectInit   =   "";
    $_projeccode    =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE active = 1 AND procode IN (SELECT procode FROM tbl_task WHERE taskcode = '$_TaskCode')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_projeccode    =   $_myrowRes['procode'];
        $_crtusercode   =   $_myrowRes['crtusercode'];
        $_projectowner  =   $_myrowRes['ProOwner'];
        $_projectInit   =   $_myrowRes['ProInit'];
    }


    if($_Priority == "Task Completed"){
        $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'W' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery   = 	"INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ('$_TaskCode', '$_Priority', '$_crtusercode', '$_projectowner', '$_projectInit', 'A', '$Str_UpdateCode')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

    if($_Priority == "Addl Hrs Request"){
        $_SelectQuery   = 	"INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ('$_TaskCode', '$_Priority', '$_crtusercode', '$_projectowner', '$_projectInit', 'A', '$Str_UpdateCode')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }
   
    if($_Priority == "Task Started"){
        $_SelectQuery   = 	"UPDATE tbl_task SET `taskstatus` = 'A' WHERE `taskcode` = '$_TaskCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_SelectQuery   = 	"UPDATE tbl_projects SET `prostatus` = 'A' WHERE `procode` = '$_projeccode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

}

function updateTaskStatusDetails($str_dbconnect,$_TaskCode){

    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$_TaskCode' ORDER BY `UpdateDate` desc" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function GetTaskCompleteLast($str_dbconnect,$_TaskCode){

    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$_TaskCode' AND `category` = 'Task Completed' ORDER BY `UpdateDate` desc LIMIT 1" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function updateTaskStatusDetailsvsID($str_dbconnect,$_TaskCode, $_TaskID){

    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$_TaskCode' AND UpdateCode = '$_TaskID'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function getTaskStatusDetailsvsCategory($str_dbconnect,$_TaskCode, $_CategoryCode){

    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$_TaskCode' AND category = '$_CategoryCode'  ORDER BY `UpdateCode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function getTaskStatusDetailsvsCategoryEmp($str_dbconnect,$_TaskCode, $_CategoryCode, $_EmpCode){

    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$_TaskCode' AND category = '$_CategoryCode' AND taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$_EmpCode')  ORDER BY `UpdateCode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function getTaskStatusDetailsvsCategoryALL($str_dbconnect,$_TaskCode){

    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$_TaskCode' ORDER BY `UpdateCode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function getTaskCategoryInner($str_dbconnect,$_TaskCode, $_CategoryCode){
    $Str_InnerCount    =   0;
    $_SelectQuery   = 	"SELECT * FROM tbl_taskupdates WHERE taskcode = '$_TaskCode' AND category = '$_CategoryCode'  ORDER BY `UpdateCode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $Str_InnerCount    +=	1;
    }
    return $Str_InnerCount;
}

function GetProjectCreator($str_dbconnect,$projectcreator){
    $Str_InnerCount    =   0;
    $_SelectQuery   = 	"SELECT * FROM tbl_sysusers WHERE Id = '$projectcreator' " or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $empcode =$_myrowRes["EmpCode"];
		 $_SelectQuery2   = 	"SELECT * FROM tbl_employee WHERE EmpCode = '$empcode' " or die(mysqli_error($str_dbconnect));
    	 $_ResultSet2     =   mysqli_query($str_dbconnect,$_SelectQuery2) or die(mysqli_error($str_dbconnect));
		 while($_myrowRes2 = mysqli_fetch_array($_ResultSet2)) {
			  $empcode =$_myrowRes2["FirstName"]." ".$_myrowRes2["LastName"];
		}
    }
    return $empcode;
}

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

    function getEstimatedHours($str_dbconnect,$Str_TaskCode){
        $_CompCode      =	$_SESSION["CompCode"];
        $Str_Estimated  =   "0";
        $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $Str_Estimated    =	$_myrowRes["AllHours"];
        }

        return $Str_Estimated;

    }

    function getHoursSpent($str_dbconnect,$Str_TaskCode){
        $_CompCode      =	$_SESSION["CompCode"];
        $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`TotHors`))) As total FROM `tbl_taskupdates` WHERE taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
        $result1 = mysqli_query($str_dbconnect,$query1);
        $row = mysqli_fetch_assoc($result1);
        $Str_Spent = $row['total'];

        if ($Str_Spent == ""){
            $Str_Spent = "00:00:00";
        }
        
        return $Str_Spent ;
    }

    function getaddlHrsRequest($str_dbconnect,$Str_TaskCode){
        $_CompCode      =	$_SESSION["CompCode"];
        $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`HrsRequest`))) As total FROM `tbl_taskupdates` WHERE taskcode = '$Str_TaskCode' AND category = 'Addl Hrs Request'" or die(mysqli_error($str_dbconnect));
        $result1 = mysqli_query($str_dbconnect,$query1);
        $row = mysqli_fetch_assoc($result1);
        $Str_Spent = $row['total'];

        if ($Str_Spent == ""){
            $Str_Spent = "00:00:00";
        }

        return $Str_Spent ;
    }

    function getaddlHrsApproved($str_dbconnect,$Str_TaskCode){
        $_CompCode      =	$_SESSION["CompCode"];
        $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`Hrs Approved`))) As total FROM `tbl_taskupdates` WHERE taskcode = '$Str_TaskCode' AND category = 'Addl Hrs Request'" or die(mysqli_error($str_dbconnect));
        $result1 = mysqli_query($str_dbconnect,$query1);
        $row = mysqli_fetch_assoc($result1);
        $Str_Spent = $row['total'];

        if ($Str_Spent == ""){
            $Str_Spent = "00:00:00";
        }

        return $Str_Spent ;
    }

    function getTotalProjectEstimatedHours($str_dbconnect,$Str_ProCode){
        $_CompCode      =	$_SESSION["CompCode"];

        $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`AllHours`))) As total FROM `tbl_task` WHERE  `procode` = '$Str_ProCode'" or die(mysqli_error($str_dbconnect));
        $result1 = mysqli_query($str_dbconnect,$query1);
        $row = mysqli_fetch_assoc($result1);
        $Str_Spent = $row['total'];

        if ($Str_Spent == ""){
            $Str_Spent = "00:00:00";
        }

        return $Str_Spent ;

    }

    function getTotalProjectHoursSpent($str_dbconnect,$Str_ProCode){
        $_CompCode      =	$_SESSION["CompCode"];
        $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`TotHors`))) As total FROM `tbl_taskupdates` WHERE `taskcode` in (Select `taskcode` FROM `tbl_task` WHERE `procode` = '$Str_ProCode')" or die(mysqli_error($str_dbconnect));
        $result1 = mysqli_query($str_dbconnect,$query1);
        $row = mysqli_fetch_assoc($result1);
        $Str_Spent = $row['total'];

        if ($Str_Spent == ""){
            $Str_Spent = "00:00:00";
        }

        return $Str_Spent ;
    }

    function getTotalProjectaddlHrsApproved($str_dbconnect,$Str_ProCode){
        $_CompCode      =	$_SESSION["CompCode"];
        $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`Hrs Approved`))) As total FROM `tbl_taskupdates` WHERE category = 'Addl Hrs Request' AND `taskcode` in (Select `taskcode` FROM `tbl_task` WHERE `procode` = '$Str_ProCode')" or die(mysqli_error($str_dbconnect));
        $result1 = mysqli_query($str_dbconnect,$query1);
        $row = mysqli_fetch_assoc($result1);
        $Str_Spent = $row['total'];

        if ($Str_Spent == ""){
            $Str_Spent = "00:00:00";
        }

        return $Str_Spent ;
    }
    
    function get_selectedTaskPRONAME($str_dbconnect,$Str_TaskCode) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_TaskName      =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_TaskName      =   $_myrowRes['procode'];
    }

    return $_TaskName;
}

function removeDoc($str_dbconnect,$DocCode){
    
    $_SelectQuery   = 	"DELETE FROM prodocumets WHERE ProCode = '$DocCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    
}

function getTotalTaskEstimatedHours($str_dbconnect,$Str_TskCode){
    $_CompCode      =	$_SESSION["CompCode"];

    $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`AllHours`))) As total FROM `tbl_task` = '$Str_TskCode'" or die(mysqli_error($str_dbconnect));
    $result1 = mysqli_query($str_dbconnect,$query1);
    $row = mysqli_fetch_assoc($result1);
    $Str_Spent = $row['total'];

    if ($Str_Spent == ""){
        $Str_Spent = "00:00:00";
    }

    return $Str_Spent ;

}

function getTotalTaskHoursSpent($str_dbconnect,$Str_TskCode){
    $_CompCode      =	$_SESSION["CompCode"];
    $query1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`TotHors`))) As total FROM `tbl_taskupdates` WHERE `taskcode` = '$Str_TskCode'" or die(mysqli_error($str_dbconnect));
    $result1 = mysqli_query($str_dbconnect,$query1);
    $row = mysqli_fetch_assoc($result1);
    $Str_Spent = $row['total'];

    if ($Str_Spent == ""){
        $Str_Spent = "00:00:00";
    }

    return $Str_Spent ;
}

function get_NoOfTaskforEmp($str_dbconnect,$EMPCODE){
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode in (SELECT taskcode  FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfTaskforEmpTC($str_dbconnect,$EMPCODE){
    /*TASK COMPLETED*/
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'W' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function  get_NoOfTaskforEmpTI($str_dbconnect,$EMPCODE){
    /*TASK IN PROGRESS*/
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'A' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function   get_NoOfTaskforEmpCW($str_dbconnect,$EMPCODE){
    /*COMPLETE WAITING APPROVAL*/
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'C' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function   get_NoOfTaskforEmpTN($str_dbconnect,$EMPCODE){
    /*TASK NOT STARTED */
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'I' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}




function get_NoOfTaskforWF($str_dbconnect,$EMPCODE, $today_date){
    /*TASK NOT STARTED */
	$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EMPCODE'";	
    //$_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'I' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfTaskforWFYES($str_dbconnect,$EMPCODE, $today_date){
    /*TASK NOT STARTED */
	$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EMPCODE' AND `status` = 'Yes'";	
    //$_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'I' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfTaskforWFNO($str_dbconnect,$EMPCODE, $today_date){
    /*TASK NOT STARTED */
	$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EMPCODE' AND `status` = 'No'";	
    //$_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'I' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfTaskforWFNA($str_dbconnect,$EMPCODE, $today_date){
    /*TASK NOT STARTED */
	$_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$EMPCODE' AND `status` = 'N/A'";	
    //$_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskstatus = 'I' AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

?>
