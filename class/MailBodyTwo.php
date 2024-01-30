<?php

//new lv
include ("sql_sysusers.php");          //  sql commands for the access controls
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

function getGROUPNAME2($str_dbconnect,$strGrpCode) {

    $Group	=	0;

    $_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

    $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $Group	=	$_myrowRes["Group"];
    }

    return $Group ;

}

function CreateMail($str_dbconnect,$ProjectCode, $ProjectName, $TaskCode, $TaskName, $TaskCategory, $TaskDescription, $CrtDate){

    $_DepartCode    = "";
    $_Department    = "";
    $_Division      = "";
	$_proCat		= "";
    $_ProCode       =   $ProjectCode;
    $_ProName       =   "";
    $_StartDate     =   "";
    $_crtusercode   =   "";
    $_crtdate       =   "";
    $_EndDate       =   "";
    $_prostatus     =   "";
    $_projectowner  =   "";
    $_projectInit   =   "";
    $_DownloadString = "";

    $_strSecOwner   =   "";
    $_strSupport    =   "";

    $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_ProCode);
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_ProName       =   $_myrowRes['proname'];
		$_proCat		=	$_myrowRes['proCat'];
        $_StartDate     =   $_myrowRes['startdate'];
        $_crtusercode   =   $_myrowRes['crtusercode'];
        $_crtdate       =   $_myrowRes['crtdate'];
        $_prostatus     =   $_myrowRes['prostatus'];
        $_EndDate       =   $_myrowRes['EndDate'];
        $_projectowner  =   $_myrowRes['ProOwner'];
        $_projectInit   =   $_myrowRes['ProInit'];
        $_Division      =   $_myrowRes['Division'];
        $_DepartCode    =   $_myrowRes['Department'];
        $_strSecOwner   =   $_myrowRes["SecOwner"];
        $_strSupport    =   $_myrowRes["Support"];
    }

    $_Department = getGROUPNAME2($str_dbconnect,$_DepartCode);

    $MailTitile =   "";
    $MailTitile =   "";

    $_downloadSet      = get_projectuploadupdates($str_dbconnect,$TaskCode) ;
    while($_DownloadRes = mysqli_fetch_array($_downloadSet)) {
       $_DownloadString .=  "<a href='https://pms.tkse.lk/files/".$_DownloadRes['SystemName']."'>".$_DownloadRes['SystemName']."</a><br>";
    }
    
    $TaskDescription = "";
    
    $_ResultSet3 = getTaskStatusDetailsvsCategoryALL($str_dbconnect,$TaskCode);
    while($_myrowRes3 = mysqli_fetch_array($_ResultSet3)) {
        $TaskDescription .=  $_myrowRes3['Note'] . " - " . $_myrowRes3['UpdateDate'] ."<Br/>";
    }

    $MessageBody    =   "<htmL>
                        <head>
                        <style type='text/css'>
                            table{
                                border-collapse:collapse;
                                border:1px solid black;
                                border-color: #000066;
                            }
                            th{
                                border:1px solid black;
                                border-color: #000066;
                                font-family: Century Gothic;
                                font-size: 11px;
                                color: #000099;
                                width: auto;
                            }
                            td{
                                border:1px solid black;
                                border-color: #000066;
                                font-family: Century Gothic;
                                font-size: 11px;
                                color: #000099;
                                width: auto;
                            }

                            a {font-family:Georgia,serif; font-size:11px}
                            a:link {color:blue;}
                            a:visited {color: #660066;}
                            a:hover {text-decoration: none; color: #ff9900;
                            font-weight:bold;}
                            a:active {color: red;text-decoration: none}

                        </style>
                        </head>
                        <body>
            <table border=’0’ cellspacing=’0’ cellpadding=’0’ style='font-family'>
                <tbody>
            <tr>
                <td valign=’top’ width=’680’ align='center' bgcolor='5b98e0' colspan='3'>
                    <font color='white'>- TASK DETAILS HAS BEEN UPDATED -</font>
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Update Status
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$TaskCategory."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Division - ".$_Division."
                    </b>
                </td>
                <td valign=’top’width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    <b>
                        Department - ".$_Department."
                    </b>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                   
                    <b>
                        Project Name
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$ProjectName."
                </td>
            </tr>        
				 <tr>
                <td valign=’top’ width=’160’>                   
                    <b>
                        Project Category
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$_proCat."
                </td>
            </tr>        
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Project Code
                    </b>
                </td>
                <td valign=’top’width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$ProjectCode."
                </td>
            </tr>            
            <tr>
                <td valign=’top’ width=’638’ colspan=’3’>                    
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Created Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_crtdate."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Due Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_EndDate."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        #of Hrs Assigned
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".getTotalTaskEstimatedHours($str_dbconnect,$TaskCode)."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        #of Hrs Spent
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".getTotalTaskHoursSpent($str_dbconnect,$TaskCode)."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Created by
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDSYSUSERNAME($str_dbconnect,$_crtusercode))."
                </td>
            </tr>
			 <tr>
                <td valign=’top’ width=’160’>                   
                    <b>
                        Task Owner
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"])."
                </td>
            </tr>
             <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Primary Owner
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectowner))."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Secondary Owner
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_strSecOwner))."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Supporter
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_strSupport))."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Initiated by
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectInit))."
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Task Code
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                    
                    ".$TaskCode."
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Task Name
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$TaskName."
                </td>
            </tr>            
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Notes
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$TaskDescription."
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Update Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>                   
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$CrtDate."
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
             <tr style='font-size: 8'>
                <td valign=’top’ width=’160’>
                    <b>
                        Documents to Download
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_DownloadString."
                </td>
            </tr>
            <tr >
                <td colspan='3' align='center' style='border-style: hidden;  border-color: transparent'>
                <a href='https://pms.tkse.lk/' class='myButton'>Click here to login to PMS</a>
                </td>
            </tr>
        </tbody>
    </table></body></html>
";

    return $MessageBody;

}

function CreateMailImpediment($str_dbconnect,$ProjectCode, $ProjectName, $TaskCode, $TaskName, $TaskCategory, $TaskDescription, $CrtDate){

    $_DepartCode    = "";
    $_Department    = "";
    $_Division      = "";

    $_ProCode       =   $ProjectCode;
    $_ProName       =   "";
    $_StartDate     =   "";
    $_crtusercode   =   "";
    $_crtdate       =   "";
    $_EndDate       =   "";
    $_prostatus     =   "";
    $_projectowner  =   "";
    $_projectInit   =   "";
    $_DownloadString = "";

    $_strSecOwner   =   "";
    $_strSupport    =   "";

    $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_ProCode);
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_ProName       =   $_myrowRes['proname'];
        $_StartDate     =   $_myrowRes['startdate'];
        $_crtusercode   =   $_myrowRes['crtusercode'];
        $_crtdate       =   $_myrowRes['crtdate'];
        $_prostatus     =   $_myrowRes['prostatus'];
        $_EndDate       =   $_myrowRes['EndDate'];
        $_projectowner  =   $_myrowRes['ProOwner'];
        $_projectInit   =   $_myrowRes['ProInit'];
        $_Division      =   $_myrowRes['Division'];
        $_DepartCode    =   $_myrowRes['Department'];
        $_strSecOwner   =   $_myrowRes["SecOwner"];
        $_strSupport    =   $_myrowRes["Support"];
    }

    $_Department = getGROUPNAME2($str_dbconnect,$_DepartCode);

    $MailTitile =   "";
    $MailTitile =   "";

    $_downloadSet      = get_projectuploadupdates($str_dbconnect,$TaskCode) ;
    while($_DownloadRes = mysqli_fetch_array($_downloadSet)) {
       $_DownloadString .=  "<a href='https://pms.tkse.lk/files/".$_myrowResq['FileName']."'>".$_myrowResq['FileName']."</a>";
    }
    
    $TaskDescription = "";
    
    $_ResultSet3 = getTaskStatusDetailsvsCategoryALL($str_dbconnect,$TaskCode);
    while($_myrowRes3 = mysqli_fetch_array($_ResultSet3)) {
        $TaskDescription .=  $_myrowRes3['Note'] . " - " . $_myrowRes3['UpdateDate'] ."<Br/>";
    }

    $MessageBody    =   "<htmL>
                        <head>
                        <style type='text/css'>
                            table{
                                border-collapse:collapse;
                                border:1px solid black;
                                border-color: #000066;
                            }
                            th{
                                border:1px solid black;
                                border-color: #000066;
                                font-family: Century Gothic;
                                font-size: 11px;
                                color: #000099;
                                width: auto;
                            }
                            td{
                                border:1px solid black;
                                border-color: #000066;
                                font-family: Century Gothic;
                                font-size: 11px;
                                color: #000099;
                                width: auto;
                            }

                            a {font-family:Georgia,serif; font-size:11px}
                            a:link {color:blue;}
                            a:visited {color: #660066;}
                            a:hover {text-decoration: none; color: #ff9900;
                            font-weight:bold;}
                            a:active {color: red;text-decoration: none}

                        </style>
                        </head>
                        <body>
            <table border='0' cellspacing='0' cellpadding='0' style='font-family'>
                <tbody>
            <tr>
                <td valign='top' width='680' align='center' bgcolor='#FF0000' colspan='3'>
                    <font color='white'>- Project Impediment Alert -</font>
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign='top' width='160'>                    
                    <b>
                        Update Status
                    </b>
                </td>
                <td valign='top' width='28'>                    
                </td>
                <td valign='top' width='451'>                   
                    ".$TaskCategory."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        Division - ".$_Division."
                    </b>
                </td>
                <td valign='top'width='28'>
                </td>
                <td valign='top' width='451'>
                    <b>
                        Department - ".$_Department."
                    </b>
                </td>
            </tr>
            <tr>
                <td valign='top' width='160'>                   
                    <b>
                        Project Name
                    </b>
                </td>
                <td valign='top' width='28'>                    
                </td>
                <td valign='top' width='451'>                   
                    ".$ProjectName."
                </td>
            </tr>            
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign='top' width='160'>                    
                    <b>
                        Project Code
                    </b>
                </td>
                <td valign='top'width='28'>                    
                </td>
                <td valign='top' width='451'>                   
                    ".$ProjectCode."
                </td>
            </tr>            
            <tr>
                <td valign='top' width='638' colspan='3'>                    
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        Created Date
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".$_crtdate."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        Due Date
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".$_EndDate."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        #of Hrs Assigned
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".getTotalTaskEstimatedHours($str_dbconnect,$TaskCode)."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        #of Hrs Spent
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".getTotalTaskHoursSpent($str_dbconnect,$TaskCode)."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        Created by
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".strtoupper(getSELECTEDSYSUSERNAME($str_dbconnect,$_crtusercode))."
                </td>
            </tr>
             <tr >
                <td valign='top' width='160'>
                    <b>
                        Project Primary Owner
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectowner))."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        Project Secondary Owner
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_strSecOwner))."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        Project Supporter
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_strSupport))."
                </td>
            </tr>
            <tr >
                <td valign='top' width='160'>
                    <b>
                        Project Initiated by
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectInit))."
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign='top' width='160'>                    
                    <b>
                        Task Code
                    </b>
                </td>
                <td valign='top' width='28'>                    
                </td>
                <td valign='top' width='451'>                    
                    ".$TaskCode."
                </td>
            </tr>
            <tr>
                <td valign='top' width='160'>                    
                    <b>
                        Task Name
                    </b>
                </td>
                <td valign='top' width='28'>                    
                </td>
                <td valign='top' width='451'>                   
                    ".$TaskName."
                </td>
            </tr>            
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign='top' width='160'>                    
                    <b>
                        Notes
                    </b>
                </td>
                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>                   
                    ".$TaskDescription."
                </td>
            </tr>
            <tr>
                <td valign='top' width='160'>                    
                    <b>
                        Update Date
                    </b>
                </td>
                <td valign='top' width='28'>                   
                </td>
                <td valign='top' width='451'>                   
                    ".$CrtDate."
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
             <tr style='font-size: 8'>
                <td valign='top' width='160'>
                    <b>
                        Documents to Download
                    </b>
                </td>

                <td valign='top' width='28'>
                </td>
                <td valign='top' width='451'>
                    ".$_DownloadString."
                </td>
            </tr>
            <tr >
                <td colspan='3' align='center' style='border-style: hidden;  border-color: transparent'>
                <a href='https://pms.tkse.lk' class='myButton'>Click here to login to PMS</a>
                </td>
            </tr>
        </tbody>
    </table></body></html>
";

    return $MessageBody;

}



function CreateMailApprove($ProjectCode, $ProjectName, $TaskCode, $TaskName, $TaskCategory, $TaskDescription, $CrtDate, $AppNote){

    $_DepartCode    = "";
    $_Department    = "";
    $_Division      = "";
	$proCat			= "";
    $_ProCode       =   $ProjectCode;
    $_ProName       =   "";
    $_StartDate     =   "";
    $_crtusercode   =   "";
    $_crtdate       =   "";
    $_EndDate       =   "";
    $_prostatus     =   "";
    $_projectowner  =   "";
    $_projectInit   =   "";
    $_DownloadString = "";

    $_strSecOwner   =   "";
    $_strSupport    =   "";

    $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_ProCode);
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_ProName       =   $_myrowRes['proname'];
		$proCat			= 	$_myrowRes['proCat'];
        $_StartDate     =   $_myrowRes['startdate'];
        $_crtusercode   =   $_myrowRes['crtusercode'];
        $_crtdate       =   $_myrowRes['crtdate'];
        $_prostatus     =   $_myrowRes['prostatus'];
        $_EndDate       =   $_myrowRes['EndDate'];
        $_projectowner  =   $_myrowRes['ProOwner'];
        $_projectInit   =   $_myrowRes['ProInit'];
        $_Division      =   $_myrowRes['Division'];
        $_DepartCode    =   $_myrowRes['Department'];
        $_strSecOwner   =   $_myrowRes["SecOwner"];
        $_strSupport    =   $_myrowRes["Support"];
    }

    $_Department = getGROUPNAME2($str_dbconnect,$_DepartCode);

    $MailTitile =   "";
    $MailTitile =   "";

    $_downloadSet      = get_projectuploadupdates($str_dbconnect,$TaskCode) ;
    while($_DownloadRes = mysqli_fetch_array($_downloadSet)) {
       $_DownloadString .=  "<a href='https://pms.tkse.lk/files/".$_DownloadRes['SystemName']."'>".$_DownloadRes['SystemName']."</a><br>";
    }
    
    $TaskDescription = "";
    
    $_ResultSet3 = getTaskStatusDetailsvsCategoryALL($str_dbconnect,$TaskCode);
    while($_myrowRes3 = mysqli_fetch_array($_ResultSet3)) {
        $TaskDescription .=  $_myrowRes3['Note'] . " - " . $_myrowRes3['UpdateDate'] ."<Br/>";
    }

    $MessageBody    =   "<htmL>
                        <head>
                        <style type='text/css'>
                            table{
                                border-collapse:collapse;
                                border:1px solid black;
                                border-color: #000066;
                            }
                            th{
                                border:1px solid black;
                                border-color: #000066;
                                font-family: Century Gothic;
                                font-size: 11px;
                                color: #000099;
                                width: auto;
                            }
                            td{
                                border:1px solid black;
                                border-color: #000066;
                                font-family: Century Gothic;
                                font-size: 11px;
                                color: #000099;
                                width: auto;
                            }

                            a {font-family:Georgia,serif; font-size:11px}
                            a:link {color:blue;}
                            a:visited {color: #660066;}
                            a:hover {text-decoration: none; color: #ff9900;
                            font-weight:bold;}
                            a:active {color: red;text-decoration: none}

                        </style>
                        </head>
                        <body>
            <table border=’0’ cellspacing=’0’ cellpadding=’0’ style='font-family'>
                <tbody>
            <tr>
                <td valign=’top’ width=’680’ align='center' bgcolor='5b98e0' colspan='3'>
                    <font color='white'>- TASK DETAILS HAS BEEN UPDATED -</font>
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Update Category
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$TaskCategory."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Division - ".$_Division."
                    </b>
                </td>
                <td valign=’top’width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    <b>
                        Department - ".$_Department."
                    </b>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                   
                    <b>
                        Project Name
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$ProjectName."
                </td>
            </tr>  
<tr>
                <td valign=’top’ width=’160’>                   
                    <b>
                        Project Category
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$proCat."
                </td>
            </tr>           			
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Project Code
                    </b>
                </td>
                <td valign=’top’width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$ProjectCode."
                </td>
            </tr>            
            <tr>
                <td valign=’top’ width=’638’ colspan=’3’>                    
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Created Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_crtdate."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Due Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_EndDate."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        #of Hrs Assigned
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".getTotalTaskEstimatedHours($str_dbconnect,$TaskCode)."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        #of Hrs Spent
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".getTotalTaskHoursSpent($str_dbconnect,$TaskCode)."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Created by
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDSYSUSERNAME($str_dbconnect,$_crtusercode))."
                </td>
            </tr>
             <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Primary Owner
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectowner))."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Secondary Owner
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_strSecOwner))."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Supporter
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_strSupport))."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project Initiated by
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectInit))."
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Task Code
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                    
                    ".$TaskCode."
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Task Name
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$TaskName."
                </td>
            </tr>            
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Notes
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$TaskDescription."
                </td>
            </tr>
            <tr>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Update Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>                   
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$CrtDate."
                </td>
            </tr>
			<tr style='font-size: 8'>
                <td valign=’top’ width=’160’>
                    <b>
                        Approve / Reject Spe. Note
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$AppNote."
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
             <tr style='font-size: 8'>
                <td valign=’top’ width=’160’>
                    <b>
                        Documents to Download
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_DownloadString."
                </td>
            </tr>
            <tr >
                <td colspan='3' align='center' style='border-style: hidden;  border-color: transparent'>
                <a href='https://pms.tkse.lk/' class='myButton'>Click here to login to PMS</a>
                </td>
            </tr>
        </tbody>
    </table></body></html>
";

    return $MessageBody;

}

?>