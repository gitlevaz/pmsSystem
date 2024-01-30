<?php 
class Connection {
	public function Connect()
		{
			mysqli_connect("localhost","root","");
			mysqli_select_db($str_dbconnect,"cispms");
		}

function get_TaskDelayDetails($str_dbconnect,$procode,$Dte_today) {

   // $_CompCode      =	$_SESSION["CompCode"];
    $_SelectQuery   =   "";    
   
            $_SelectQuery   = 	"SELECT taskcode, taskname, taskcrtdate, taskenddate, taskstatus, Precentage, assignuser FROM tbl_task  WHERE (taskstatus='I' OR taskstatus='A' OR taskstatus='W' OR taskstatus='H' OR taskstatus='S') AND taskenddate < '$Dte_today' AND procode = '$procode' ORDER BY taskenddate" or die(mysqli_error($str_dbconnect));
			    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    return $_ResultSet;
}

function get_TaskDelayprojectDetails($Dte_today) {

    //$_CompCode      =	$_SESSION["CompCode"];
    $_SelectQuery   =   "";    
   
            $_SelectQuery   = 	"SELECT distinct p.procode, p.proname,p.procat,e.FirstName,e.LastName FROM tbl_task t INNER JOIN tbl_projects p INNER JOIN tbl_employee e ON t.procode=p.procode AND p.ProOwner=e.EmpCode  WHERE (t.taskstatus='I' OR t.taskstatus='A' OR t.taskstatus='W' OR t.taskstatus='H' OR t.taskstatus='S') AND t.taskenddate < '$Dte_today' ORDER BY t.taskenddate" or die(mysqli_error($str_dbconnect));
			    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    return $_ResultSet;
}

function getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_EmpCode) {

    $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_EmpName   =   "";

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_EmpName   =   $_myrowRes['FirstName']." ". $_myrowRes['LastName'];
    }

    return $_EmpName ;

}

function GetStatusDesc($str_dbconnect,$_tstatus) {

    $_SelectQuery 	=   "SELECT Status FROM tbl_systemstatus WHERE `StatusCode` = '$_tstatus'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_st   =   "";

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_st   =   $_myrowRes['Status'];
    }

    return $_st ;

}

function getDelayeddates($Str_enddate,$Dte_today){
        //$_CompCode      =	$_SESSION["CompCode"];
		$diff =round(abs(strtotime($Dte_today)-strtotime($Str_enddate))/86400);        
        return $diff ;
}
	
	function get_projectuploadupdates($str_dbconnect,$Str_procode){

    $_SelectQuery   = 	"SELECT * FROM  prodocumets WHERE `ParaCode` = '$Str_procode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;

}

function insertKJR($_kjrid,$_departmentid,$_desisnationid,$_kjrname,$_description,$_etfno){
	 $_SelectQuery   = 	"INSERT INTO tbl_kjr (`KJRId`, `DeptId`, `DesignationId`, `Name`, `Description`,`etfno`) VALUES ('$_kjrid', '$_departmentid', '$_desisnationid', '$_kjrname', '$_description','$_etfno')" or die(mysqli_error($str_dbconnect));
	 
     mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
       
}
	
function updateKJR($_kjrid,$_departmentid,$_desisnationid,$_kjrname,$_description,$_etfno){

  $_SelectQuery   = 	"UPDATE tbl_kjr SET `DeptId` = '$_departmentid',`DesignationId` = '$_desisnationid',`Name` = '$_kjrname',`Description` = '$_description' , `etfno`= '$_etfno' WHERE `KJRId` = '$_kjrid'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
}

function insertIndicator($_indicatorid,$_indicatorname,$_indicatordescription){
	 $_SelectQuery   = 	"INSERT INTO tbl_indicator (`IndicatorID`, `IndicatorName`, `Description`) VALUES ('$_indicatorid', '$_indicatorname', '$_indicatordescription')" or die(mysqli_error($str_dbconnect));
	 
     mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
       
}
	
function updateIndicator($_indicatorid,$_indicatorname,$_indicatordescription){

  $_SelectQuery   = 	"UPDATE tbl_indicator SET `IndicatorName` = '$_indicatorname',`Description` = '$_indicatordescription' WHERE `IndicatorID` = '$_indicatorid'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
}

function insertSubIndicator($_subindicatorid,$_subindicatorname,$_subindicatordescription,$_indicatorid){
	 $_SelectQuery   = 	"INSERT INTO tbl_indicatorsub (`SubIndId`, `SubIndName`, `Description`,`IndicatorId`) VALUES ('$_subindicatorid', '$_subindicatorname', '$_subindicatordescription','$_indicatorid')" or die(mysqli_error($str_dbconnect));
	 
     mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
       
}
	
function updateSubIndicator($_subindicatorid,$_subindicatorname,$_subindicatordescription,$_indicatorid){

  $_SelectQuery   = 	"UPDATE tbl_indicatorsub SET `SubIndName` = '$_subindicatorname',`Description` = '$_subindicatordescription' , `IndicatorId`='$_indicatorid'  WHERE `SubIndId` = '$_subindicatorid'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
}

function insertKjrIndicator($_cid,$_kjrid,$_indid){
	 $_SelectQuery   = 	"INSERT INTO tbl_kjr_indicator (`Code`, `KJRId`, `IndicatorId`) VALUES ('$_cid', '$_kjrid', '$_indid')" or die(mysqli_error($str_dbconnect));
	 
     mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
       
}
	
function updateKjrIndicator($_cid,$_kjrid,$_indid){

  $_SelectQuery   = 	"UPDATE tbl_kjr_indicator SET `KJRId` = '$_kjrid',`IndicatorId` = '$_indid' WHERE `Code` = '$_cid'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
}

function get_impedimentDetails123() {
		
	 $_SelectQuery 	=   "SELECT distinct * FROM tbl_impedimenttask WHERE  im_status='P' group by EmpCode " or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
return $_ResultSet;
}

function get_selectedTaskNAME123($Str_TaskCode) {

   
    $_TaskName      =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_task  WHERE active = 1 AND taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_TaskName      =   $_myrowRes['taskname'];
    }

    return $_TaskName;
}

function getSELECTEDEMPLOYENAME123($_EmpCode) {

    $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_EmpName   =   "";

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_EmpName   =   $_myrowRes['FirstName']." ". $_myrowRes['LastName'];
    }

    return $_EmpName ;

}
function getSELECTEDEMPLOYENAMEMail($_EmpCode) {

    $_SelectQuery 	=   "SELECT EMail FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
    $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_Empmail   =   "";

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_Empmail   =   $_myrowRes['EMail'];
    }

    return $_Empmail ;

}


}
?>