<?php

/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   SQL_Connection to the Database
 * Last Update      :   19-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

 $str_MySqlHost  =   "db3.tkse.lk";    //  Server Root
 $str_Database   =   "__TKSE_PMS";     //  Database Name
 $str_UserName   =   "TKSE_PMS";       //  DB User Name
 $str_Password   =   "Iyz83w8_2$6";    //  DB Password
 
 //  Connection string to the MySQL Database
 $str_dbconnect  = mysqli_connect($str_MySqlHost, $str_UserName, $str_Password) or die (mysqli_error($str_dbconnect));

function GetStatusDesc($str_dbconnect,$Status){

    $DescStatus     =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_SystemStatus WHERE StatusCode = '$Status'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $DescStatus    =	$_myrowRes["Status"];
    }
    return $DescStatus;
}

function get_NoOfProTaskforEmp($str_dbconnect,$EMPCODE, $procode){
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$procode'  AND active = 1 AND  taskcode in (SELECT taskcode  FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfProTaskforEmpTC($str_dbconnect,$EMPCODE, $procode){
    /*TASK COMPLETED*/
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$procode' AND taskstatus = 'C'  AND active = 1 AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfProTaskforEmpTI($EMPCODE, $procode){
    /*TASK IN PROGRESS*/
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$procode' AND taskstatus = 'A'  AND active = 1 AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfProTaskforEmpCW($str_dbconnect,$EMPCODE, $procode){
    /*COMPLETE WAITING APPROVAL*/
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$procode' AND taskstatus = 'W'  AND active = 1 AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}

function get_NoOfProTaskforEmpTN($str_dbconnect,$EMPCODE, $ProCode){
    /*TASK NOT STARTED */
    $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE procode = '$ProCode' AND taskstatus = 'I'  AND active = 1 AND taskcode  in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCODE')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $num_rows = mysqli_num_rows($_ResultSet);
    
    return $num_rows;
}


function GetProStatusDef($str_dbconnect,$ProCode, $Status){	
	
	$Total_Task = get_NoOfProTaskforEmp($str_dbconnect,$_SESSION["LogEmpCode"], $ProCode);
    $Task_Completed = get_NoOfProTaskforEmpTC($str_dbconnect,$_SESSION["LogEmpCode"], $ProCode);
    /*$TaskInProgress = get_NoOfProTaskforEmpTI($_SESSION["LogEmpCode"], $ProCode);*/
    $TaskPendApproval = get_NoOfProTaskforEmpCW($str_dbconnect,$_SESSION["LogEmpCode"], $ProCode);
    /*$TaskNotStarted = get_NoOfProTaskforEmpTN($str_dbconnect,$_SESSION["LogEmpCode"], $ProCode);*/
	
	
	if($Total_Task == $Task_Completed){
		$Status = "C";		
	}
	
	if($Total_Task == $TaskPendApproval){
		$Status = "C";		
	}	
	
	$DescStatus     =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_SystemStatus WHERE StatusCode = '$Status'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $DescStatus    =	$_myrowRes["Status"];
    }
    return $DescStatus;
	
	
}

 
 function get_TaskDelayprojectDetails($Dte_today) {
 
     //$_CompCode      =	$_SESSION["CompCode"];
     $_SelectQuery   =   "";    
    
             $_SelectQuery   = 	"SELECT distinct p.procode, p.proname,p.procat,e.FirstName,e.LastName FROM tbl_task t INNER JOIN tbl_projects p INNER JOIN tbl_employee e ON t.procode=p.procode AND p.ProOwner=e.EmpCode  WHERE (t.taskstatus='I' OR t.taskstatus='A' OR t.taskstatus='W' OR t.taskstatus='H' OR t.taskstatus='S') AND t.taskenddate < '$Dte_today' ORDER BY t.taskenddate" or die(mysqli_error($str_dbconnect));
                 $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
     return $_ResultSet;
 }
 

 function getDelayeddates($Str_enddate,$Dte_today){
         //$_CompCode      =	$_SESSION["CompCode"];
         $diff =round(abs(strtotime($Dte_today)-strtotime($Str_enddate))/86400);        
         return $diff ;
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
 
     $_SelectQuery   = 	"SELECT * FROM tbl_task WHERE taskcode = '$Str_TaskCode'" or die(mysqli_error($str_dbconnect));
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






?>
