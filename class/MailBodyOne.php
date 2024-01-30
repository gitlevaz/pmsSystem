<?php

   // include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database       //  connection file to the mysql database
    include ("sql_sysusers.php");          //  sql commands for the access controls
    //include ("sql_project.php");           //  sql commands for the access controls
    //include ("sql_task.php");              //  sql commands for the access controles
    //include ("accesscontrole.php");        //  sql commands for the access controles
    //include ("sql_empdetails.php");        //  connection file to the mysql database
    //require_once("class.phpmailer.php");
    //include ("sql_crtprocat.php");         //  connection file to the mysql database
    //include ("MailBodyOne.php");           //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

#	Function to get User Group and Return Group Decription ..........................
function getGROUPNAME($str_dbconnect,$strGrpCode) {

    $Group	=	0;

    $_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

    $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $Group	=	$_myrowRes["Group"];
    }

    return $Group ;

}

function CreateMail($str_dbconnect,$ProjectCode, $ProjectName, $TaskCode, $TaskName, $TaskDescription, $StartDate, $EndDate, $EstimatedHours, $Priority, $Type, $str_ActionMemo){

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
    $_DownloadString    =   "";
    $Title      =   "";

    $_strSecOwner   =   "";
    $_strSupport    =   "";

    if($Type == "NEW"){
		if($str_ActionMemo == "on")
		{
			$Title      =   "NEW PMS / ACTION MEMO TASK HAS BEEN ASSIGNED";	
		}else{
			$Title      =   "NEW PMS TASK HAS BEEN ASSIGNED";		
		}        
    }else if($Type == "EDIT"){
        $Title      =   "FOLLOWING TASK DETAILS HAS CHANGED";
    }else if($Type == "REMOVE"){
        $Title      =   "FOLLOWING TASK DETAILS HAS REMOVED";
    }

    $_ResultSet = get_SelectedProjectDetails($str_dbconnect,$_ProCode);
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $_ProName       =   $_myrowRes['proname'];
		$_pro_Cat		=   $_myrowRes['proCat'];
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

    $_Department = getGROUPNAME($str_dbconnect,$_DepartCode);


    $_downloadSet      = get_projectupload($str_dbconnect,$TaskCode) ;
    while($_DownloadRes = mysqli_fetch_array($_downloadSet)) {
       $_DownloadString .=  "<a href='".$_SESSION["SERVERPATH"]."files/".$_DownloadRes['SystemName']."'>".$_DownloadRes['SystemName']."</a><br>";
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
                        <body >
            <table border=’0’ cellspacing=’0’ cellpadding=’0’ >
                <tbody>
            <tr >
                <td valign=’top’ align='center' bgcolor='5b98e0' colspan='3'>
                    <font color='white'>".$Title."</font>
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Division
                    </b>
                </td>
                <td valign=’top’width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_Division."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Department
                    </b>
                </td>
                <td valign=’top’width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_Department."
                </td>
            </tr>
            <tr >
                <td colspan='3' style='border-style: hidden;  border-color: transparent'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr >
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
            <tr >
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
			   <tr >
                <td valign=’top’ width=’160’>
                    <b>
                        Project category
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>
                    ".$_pro_Cat."
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
            <tr >
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
            <tr >
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
                <td valign=’top’ width=’160’>                    
                    <b>
                        Task Description
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$TaskDescription."
                </td>
            </tr>
            <tr >
                <td style='border-style: hidden;  border-color: transparent' colspan='3'>
                <p>&nbsp;</p>
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>                    
                    <b>
                        Start Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$StartDate."
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>                    
                    <b>
                        End Date
                    </b>
                </td>
                <td valign=’top’ width=’28’>                   
                </td>
                <td valign=’top’ width=’451’>                   
                    ".$EndDate."
                </td>
            </tr>
            <tr >
                <td style='border-style: hidden;  border-color: transparent' colspan='3'>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr >
                <td valign=’top’ width=’160’>                    
                    <b>
                        Estimated Hours
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                    
                    ".$EstimatedHours."
                </td>
            </tr>
            <tr style='font-size: 8'>
                <td valign=’top’ width=’160’>                    
                    <b>
                        Priority
                    </b>
                </td>
                <td valign=’top’ width=’28’>                    
                </td>
                <td valign=’top’ width=’451’>                    
                    ".$Priority."
                </td>
            </tr>
            <tr >
                <td style='border-style: hidden;  border-color: transparent' colspan='3'>
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
                <a href='http://www.etropicalfish.com/pms' class='myButton'>Click here to login to PMS</a>
                </td>
            </tr>
        </tbody>
    </table></body></html>
";

    return $MessageBody;

}

?>

