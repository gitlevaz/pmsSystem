<?php

/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   All SQL Commands relevent to the Projects
 * Last Update      :   21-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

#   TO MAKE SERIAL
function get_Serial($str_dbconnect,$str_Serial, $str_Description) {

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

function get_TempSerial($str_dbconnect,$str_Serial, $str_Description) {

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

//  TO Create Project in the System var_dump($_SelectQuery); die();
function create_project($str_dbconnect,$Str_ProCat,$Str_ProName, $Dte_StartDate, $_strEMPCODE, $Dte_Enddate, $_strDptCode, $_strDivCode, $_strProInit, $_strSecOwner, $strSupport, $timepicker_start, $timepicker_end, $economic_value, $txtProPrio, $project_description, $kpis){
  
    $_CompCode      =   $_SESSION["CompCode"];
    $_CrtBy         =	$_SESSION["LogUserCode"];
    $Dte_CrtDate    = 	date("Y/m/d") ;

    $Str_ProCode    = 	get_Serial($str_dbconnect,"1001", "PROJECT CODE");
    $Str_ProCode    = 	"PRO/".$Str_ProCode;   

    $_SelectQuery   = 	"INSERT INTO tbl_projects (`compcode`, `procode`,`proCat`,`proname`, `startdate`, `crtusercode`, `crtdate`, `prostatus`, `ProOwner`, `EndDate`, `Department`, `Division`, `ProInit`, `SecOwner`, `Support`, `timepicker_start`, `timepicker_end`, `economic_value`, `txtProPrio`, `project_description`, `kpis`) VALUES 
    ('$_CompCode', '$Str_ProCode','".mysqli_real_escape_string($str_dbconnect,$Str_ProCat)."', '" . mysqli_real_escape_string($str_dbconnect,$Str_ProName) . "', '$Dte_StartDate', '$_CrtBy', '$Dte_CrtDate', 'I', '$_strEMPCODE', '$Dte_Enddate', '$_strDptCode', '$_strDivCode', '$_strProInit', '$_strSecOwner', '$strSupport', '$timepicker_start', '$timepicker_end', '$economic_value', '$txtProPrio', '$project_description', '$kpis')" or die(mysqli_error($str_dbconnect));
// var_dump( $_SelectQuery); die();
   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_UPLCode       =   $_SESSION["NewUPLCode"];

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_ProCode' WHERE `procode` = '$_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $Str_ProCode;
}

// function create_project($str_dbconnect,$Str_ProCat,$Str_ProName, $Dte_StartDate, $_strEMPCODE, $Dte_Enddate, $_strDptCode, $_strDivCode, $_strProInit, $_strSecOwner, $strSupport){
//     $_CompCode      =   $_SESSION["CompCode"];
//     $_CrtBy         =	$_SESSION["LogUserCode"];
//     $Dte_CrtDate    = 	date("Y/m/d") ;

//     $Str_ProCode    = 	get_Serial($str_dbconnect,"1001", "PROJECT CODE");
//     $Str_ProCode    = 	"PRO/".$Str_ProCode;   

//     $_SelectQuery   = 	"INSERT INTO tbl_projects (`compcode`, `procode`,`proCat`,`proname`, `startdate`, `crtusercode`, `crtdate`, `prostatus`, `ProOwner`, `EndDate`, `Department`, `Division`, `ProInit`, `SecOwner`, `Support`) VALUES ('$_CompCode', '$Str_ProCode','".mysqli_real_escape_string($str_dbconnect,$Str_ProCat)."', '" . mysqli_real_escape_string($str_dbconnect,$Str_ProName) . "', '$Dte_StartDate', '$_CrtBy', '$Dte_CrtDate', 'I', '$_strEMPCODE', '$Dte_Enddate', '$_strDptCode', '$_strDivCode', '$_strProInit', '$_strSecOwner', '$strSupport')" or die(mysqli_error($str_dbconnect));
//     mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

//     $_UPLCode       =   $_SESSION["NewUPLCode"];

//     $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_ProCode' WHERE `procode` = '$_UPLCode'";
//     mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

//     return $Str_ProCode;
// }

#	TO GET SELECTED CUSTOMER ALL THE DETAILS  projects
function get_ProjectDetails($str_dbconnect) {

    $_CompCode      =	$_SESSION["CompCode"];
    // wk_owner = 'EMP/995'
    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE  active = 1;" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_SelectedProjectDetails($str_dbconnect,$Str_ProjectCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode = '$Str_ProjectCode' AND active = 1 " or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function update_project($str_dbconnect,$Str_ProCode,$Str_ProCat,$Str_ProName, $Dte_StartDate, $_strEMPCODE, $Dte_Enddate, $_strDptCode, $_strDivCode, $_strProInit, $_strSecOwner, $strSupport, $timepicker_start, $timepicker_end, $economic_value, $txtProPrio, $project_description, $kpis){

    $_CompCode      =   $_SESSION["CompCode"];

    $_SelectQuery   = 	"UPDATE tbl_projects SET `procode` = '".$Str_ProCode."',`proCat` = '".$Str_ProCat."',`proname` = '" . mysqli_real_escape_string($str_dbconnect,$Str_ProName) . "', `startdate` = '$Dte_StartDate', `ProOwner` = '$_strEMPCODE', `EndDate` = '$Dte_Enddate', `Department` = '$_strDptCode', `Division` = '$_strDivCode', `ProInit` = '$_strProInit', `SecOwner` = '$_strSecOwner', `Support` = '$strSupport' 
                        , `timepicker_start` = '$timepicker_start' , `timepicker_end` = '$timepicker_end' , `economic_value` = '$economic_value' , `txtProPrio` = '$txtProPrio' , `project_description` = '$project_description' , `kpis` = '$kpis' WHERE `procode` = '$Str_ProCode' AND CompCode = '$_CompCode'" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    $_UPLCode       =   $_SESSION["NewUPLCode"];

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_ProCode' WHERE `procode` = '$_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
}

function delete_project($str_dbconnect,$Str_ProCode){

        $_CompCode      =   $_SESSION["CompCode"];
    
        // $_SelectQuery   = "DELETE FROM  tbl_projects where `procode` = '$Str_ProCode'" or die(mysqli_error($str_dbconnect));
        $_SelectQuery   = 	"UPDATE tbl_projects SET active = 0 where `procode` = '$Str_ProCode'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    
        $_UPLCode       =   $_SESSION["NewUPLCode"];
    
        // lev
        // $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_ProCode' WHERE `procode` = '$_UPLCode'";
        // mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }

function get_SelectedProjectName($str_dbconnect,$Str_ProjectCode) {
    $_CompCode      =	$_SESSION["CompCode"];
    $_ProjectName   =   "";
    
    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode = '$Str_ProjectCode' AND active = 1" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_ProjectName    =	$_myrowRes['proname'];
        $_Session["project_cat"] = $_myrowRes['proCat'];
    }

    return $_ProjectName ;
}

function get_SelectedProjectCatagory($str_dbconnect,$Str_ProjectCode) {

    $_CompCode      =	$_SESSION["CompCode"];
    $_ProjectName   =   "";
    $_ProjectCat   =   "";

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode = '$Str_ProjectCode' AND active = 1" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_ProjectCat    =	$_myrowRes['proCat'];
        $_Session["project_cat"] = $_myrowRes['proCat'];
    }


    return $_ProjectCat ;
}

function get_ActiveProjectDetails($str_dbconnect) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE prostatus <> 'C' AND active = 1 ORDER BY `procode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_ActiveProjectDetailsDepartment($str_dbconnect,$DeptCode) {

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE `prostatus` <> 'C' AND active = 1 AND `Department` = '$DeptCode' ORDER BY `procode`" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

#	TO GET SELECTED CUSTOMER ALL THE DETAILS
function get_ProjectDetailsTask($str_dbconnect) {

    $EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];
    // $_SelectTaskCodeQuery   = 	"SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'";
    // $_ResultTaskCodeSet     =   mysqli_query($str_dbconnect,$_SelectTaskCodeQuery) or die(mysqli_error($str_dbconnect));
    // $emp_TaskCode_s   = mysqli_fetch_assoc($_ResultTaskCodeSet)['TaskCode'];

   
    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode  IN 
    (SELECT DISTINCT procode FROM tbl_task WHERE
     taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog')) 
     OR ProOwner='$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
   
//    $_SelectQuery   = "SELECT * FROM tbl_projects WHERE procode  IN 
//     (SELECT DISTINCT procode FROM tbl_task WHERE
//      taskstatus <> 'C'  AND taskcode = '$taskcode') 
//      OR ProOwner='$EMPCodeLog'" or die(mysqli_error($str_dbconnect));

   //$_SelectQuery   = 	 $_SelectQuery   = 	"SELECT * FROM tbl_projects where ProOwner='$EMPCodeLog'";
     $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    return $_ResultSet;
}

#	TO GET SELECTED CUSTOMER ALL THE DETAILS
function get_ProjectCompletedApproved($str_dbconnect) {

    $EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode AND active = 1 IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus = 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'))" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_USERProjectDetailsTask($str_dbconnect,$EMPCodeLog) {
    // $EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];
    // $_SelectQuery   = 	"SELECT * FROM tbl_projects where ProOwner='$EMPCodeLog' AND active = 1 ";
    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus <> 'C' 
    AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'))" or die(mysqli_error($str_dbconnect));

    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_ProjectDetailsTaskEmployeePrint($str_dbconnect,$EMPCode,$_ProOwner, $_Division, $_DepartCode,$dateFromRange,$dateEndRange,$proCatt,$ProInit) {

    $EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   =   "SELECT *
FROM tbl_projects
WHERE ((startdate BETWEEN '$dateFromRange' AND '$dateEndRange') 
  Or ('$dateFromRange' ='ALL'  AND '$dateEndRange' = 'ALL' )
  Or (startdate >= '$dateFromRange' AND '$dateEndRange' = 'ALL' )
  Or ('$dateFromRange' = 'ALL' AND startdate <= '$dateEndRange' ))
	AND ((Division = '$_Division')   Or ('$_Division' = 'ALL')) 
	AND ((Department = '$_DepartCode') Or ('$_DepartCode' = 'ALL'))
	AND ((proCat = '$proCatt') 	or ('$proCatt' = 'ALL'))
	AND ((ProInit = '$ProInit') 	or ('$ProInit' = 'ALL'))
    AND ((procode in (SELECT procode FROM tbl_task WHERE taskcode in (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode ='$EMPCode'))) 	 or ('$EMPCode' = 'ALL'))

" or die(mysqli_error($str_dbconnect));

    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function get_ProjectDetailsTaskEmployee($str_dbconnect,$EMPCode) {

    $EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode AND active = 1 IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCode'))" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
}

function create_FileName($str_dbconnect){

    $Str_UPLCode    = 	get_TempSerial($str_dbconnect,"1020", "PROJECT TEMPORARY CODE UPLOAD");
    $Str_UPLCode    = 	"UPL-".$Str_UPLCode;

    return $Str_UPLCode;
}

function create_projectupload($str_dbconnect,$Str_UPLCode, $Str_FileName, $Str_SysName){

    $_CrtBy         =	$_SESSION["LogEmpCode"];
    $Dte_CrtDate    = 	date("Y/m/d") ;

    $_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_FileName', '$Str_SysName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

}

function update_projectupload($str_dbconnect,$Str_UPLCode, $Str_procode){

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_procode' WHERE `procode` = '$Str_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    
    echo "<script>";
    echo "alert('".$Str_UPLCode." File upload Successfully ".$Str_procode."');";
    echo "</script>";

}

function update_projectuploadTaskupdate1($str_dbconnect,$Str_UPLCode, $Str_procode, $Code){

    $_SelectQuery   = 	"UPDATE prodocumets SET `ParaCode` = '$Str_procode', `FileName` = '$Code' WHERE `procode` = '$Str_UPLCode'";
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    echo "<script>";
    echo "alert('".$Str_UPLCode." File upload Successfully ".$Str_procode."');";
    echo "</script>";


}

function get_projectupload($str_dbconnect,$Str_procode){
   
        $_SelectQuery   = 	"SELECT * FROM  prodocumets WHERE `ParaCode` = '$Str_procode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        return $_ResultSet;
     
}

function get_projectuploadunderTask($str_dbconnect,$Str_procode){

    $_SelectQuery   = 	"SELECT * FROM  prodocumets WHERE `ParaCode` IN (SELECT `taskcode` FROM tbl_task WHERE `procode` = '$Str_procode')" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;

}

function get_projectuploadupdates($str_dbconnect,$Str_procode){

    $_SelectQuery   = 	"SELECT * FROM  prodocumets WHERE `ParaCode` = '$Str_procode' " or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;

}

function browseTaskWFH($str_dbconnect,$LogUserCode, $sortby){
        
    $today_date  = date("Y-m-d");
    $_SelectQuery = "";
    
    if ($sortby == "NRM"){
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' order by `start_time`";
    }else if($sortby == "WFN"){
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'W%'  order by `start_time`";
    }else if($sortby == "EMO"){
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like 'E%'  order by `start_time`";
    }else{
        $_SelectQuery = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `catcode` = '$sortby'  order by `start_time`";
    }      
    
    $_ResultSet 	=  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    
    return $_ResultSet;
    
}

function ChangeProjectPriority($str_dbconnect,$ChngeProject, $Priority){
	
	$_SelectQuery   = 	"UPDATE tbl_Projects SET `Rate` = '$Priority' WHERE `procode` = '$ChngeProject'" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
}

function ChangeRate($str_dbconnect,$ChngeProject, $Priority ){		
	
	$EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];
	
	$_SelectQuery   = 	"SELECT * FROM tbl_ProPriority WHERE  ProCode = '$ChngeProject' AND EmpCode = '$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
	$_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

	while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
		$OrderByNumNow = $_myrowRes['OrderByNum'];
    }
	
	if($OrderByNumNow < $Priority ){	
		echo "<script type='text/javascript'>alert('Sorry! - You are only allowed to Advanced Priority!');</script>";	
	}else{		
		//echo "<script type='text/javascript'>alert('Priority - ".$OrderByNumNow." - .');
	
	    $_SelectQuery   = 	"SELECT * FROM tbl_ProPriority WHERE EmpCode = '$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
	    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		$num_rows 		= 	mysqli_num_rows($_ResultSet);
		
		$StartCount 	=	$Priority;
		
		//echo "<script type='text/javascript'>alert('Priority - ".$StartCount." - .');</script>";
		
		$OldProjectProject = "";
		
		for ($i=1; $i<=$OrderByNumNow; $i++){
					
			$Update = 0;
			$Update = $i + 1;
			
			$Project = "";
			
			
			
			$_SelectQuery   = 	"SELECT * FROM tbl_ProPriority WHERE OrderByNum = '$i' AND ProCode <> '$OldProjectProject' AND EmpCode = '$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
			$_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
			while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
				$Project = $_myrowRes['ProCode'];
		    }
			
			
			
			$_SelectQuery   = 	"UPDATE tbl_ProPriority SET OrderByNum = '$Update' WHERE ProCode = '$Project' AND EmpCode = '$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
			mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			
			$OldProjectProject = $Project;
				
	   	}
		
		$_SelectQuery   = 	"UPDATE tbl_ProPriority SET OrderByNum = '$Priority' WHERE ProCode = '$ChngeProject' AND EmpCode = '$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
	    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
	}
}

function getOrderByNumber($str_dbconnect,$Str_ProCode){

	$EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];
    $OrderBy = 0;
	$_SelectQuery   = 	"SELECT * FROM tbl_ProPriority WHERE procode = '$Str_ProCode' AND EmpCode = '$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
	$_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

	while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
		$OrderBy = $_myrowRes['OrderByNum'];
        
    }	
	
	return $OrderBy;
	
}

function SetupProOrderSequence($str_dbconnect){

	$LastUpdatePriority	=	0;
	
	$EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];
	
	$_SelectQuery   = 	"SELECT * FROM tbl_ProPriority WHERE EmpCode = '$EMPCodeLog'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	$num_rows_Priority 		= 	mysqli_num_rows($_ResultSet);
	
	/*$_SelectQuery   = 	"SELECT * FROM tbl_ProPriority WHERE EmpCode = '$EMPCodeLog' ORDER BY OrderByNum" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
		$LastUpdatePriority = $_myrowRes['OrderByNum'];
    }*/
	
	$_SelectQuery   		= 	"SELECT * FROM tbl_projects WHERE  active = 1 AND procode IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'))" or die(mysqli_error($str_dbconnect));
    $_ResultSet     		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	$num_rows_Projects 		= 	mysqli_num_rows($_ResultSet);
	
	//echo "<script type='text/javascript'>alert('".$num_rows."!');</script>";
	
	if($num_rows_Priority < 1){
		 
		 $OrderByNumX = 0;
		 
		 $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE active = 1 AND procode IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'))" or die(mysqli_error($str_dbconnect));
	     $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		 
		 while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
			
			$ProCodeX	=	$_myrowRes['procode'];
			$OrderByNumX	=	$OrderByNumX + 1;			
			
			$_SelectQuery   = 	"INSERT INTO tbl_ProPriority (`ProCode`, `OrderByNum`, `EmpCode`) VALUES ('$ProCodeX', '$OrderByNumX', '$EMPCodeLog')" or die(mysqli_error($str_dbconnect));
    		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			
	     }			
	}
	
	if($num_rows_Projects > $num_rows_Priority){
		
	     $OrderByNumX = $num_rows_Priority;
		 
		 $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE active = 1 AND procode NOT IN (SELECT ProCode FROM tbl_ProPriority WHERE EmpCode = '$EMPCodeLog') AND procode IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'))" or die(mysqli_error($str_dbconnect));
	     $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		 
		 while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
			
			$ProCodeX		=	$_myrowRes['procode'];
			$OrderByNumX	=	$OrderByNumX + 1;			
			
			$_SelectQuery   = 	"INSERT INTO tbl_ProPriority (`ProCode`, `OrderByNum`, `EmpCode`) VALUES ('$ProCodeX', '$OrderByNumX', '$EMPCodeLog')" or die(mysqli_error($str_dbconnect));
			mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			
	     }	
			
	}
	
}

/*function ChangeRate($str_dbconnect,$ChngeProject, $Priority ){
	
	$EMPCodeLog     =   $_SESSION["LogEmpCode"];
    $_CompCode      =	$_SESSION["CompCode"];
	
	$_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE  procode = '$ChngeProject'" or die(mysqli_error($str_dbconnect));
	$_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

	while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
		$OrderByNumNow = $_myrowRes['OrderByNum'];
    }
	
	if($OrderByNumNow < $Priority ){	
		echo "<script type='text/javascript'>alert('Sorry! - You are only allowed to Advanced Priority!');</script>";	
	}else{	
	
	    $_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE procode IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'))" or die(mysqli_error($str_dbconnect));
	    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		$num_rows 		= 	mysqli_num_rows($_ResultSet);
		
		$StartCount 	=	$Priority;
		
		$OldProjectProject = "";
		
		for ($i=1; $i<=$OrderByNumNow; $i++){
					
			$Update = 0;
			$Update = $i + 1;
			
			$Project = "";
			
			$_SelectQuery   = 	"SELECT * FROM tbl_projects WHERE OrderByNum = '$i' AND procode <> '$OldProjectProject' AND procode IN (SELECT DISTINCT procode FROM tbl_task WHERE taskstatus <> 'C'  AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$EMPCodeLog'))" or die(mysqli_error($str_dbconnect));
			$_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
			while($_myrowRes = mysqli_fetch_array($_ResultSet)) {	           
				$Project = $_myrowRes['procode'];
		    }
			
			$_SelectQuery   = 	"UPDATE tbl_projects SET OrderByNum = '$Update' WHERE procode = '$Project'" or die(mysqli_error($str_dbconnect));
			mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			
			$OldProjectProject = $Project;
				
	   	}
		
		$_SelectQuery   = 	"UPDATE tbl_projects SET OrderByNum = '$Priority' WHERE procode = '$ChngeProject'" or die(mysqli_error($str_dbconnect));
	    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));			
	}
}*/


?>
