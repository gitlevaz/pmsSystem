  

<?php


/**
 * Created by JetBrains PhpStorm.
 * User: shameera
 * Date: 5/26/11
 * Time: 11:40 AM
 * To change this template use File | Settings | File Templates.
 */
    session_start();

    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database       //  connection file to the mysql database
    include ("../class/sql_sysusers.php");          //  sql commands for the access controls
    //include ("../class/sql_project.php");           //  sql commands for the access controls
    include ("../class/sql_wkflow.php");              //  sql commands for the access controles
    include ("../class/accesscontrole.php");        //  sql commands for the access controles
    include ("../class/sql_empdetails.php");        //  connection file to the mysql database
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    
    require_once("../class/class.phpmailer.php");
    
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

    function getGROUPMAIL($str_dbconnect) {

            $_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpStat = 'A'" or die(mysqli_error($str_dbconnect));
            $_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

            return $_ResultSet ;
    }

    $MailBody           =   "";
    $PageRoll           =   1;
    $TitleEntered       =   0;

    $Dte_today          = 	date("Y/m/d") ;
    $_PrintBy           =	$_SESSION["LogUserCode"];

    date_default_timezone_set('Asia/Colombo');
    $Dte_Time           = 	date("h:i:s a", time()) ;

     $_Division     =   "";
     $_DepartCode   =   "";
     $_Department   =   "";
     $_EMPCode      =   "";
     $_ProOwner     =   "";
     $_ProStatus    =   "";
     $_TskStatus    =   "";
     $_StartDate    =   "";
     $_EndDate      =   "";

    if(isset($_GET["division"]))
    {
        $_Division     =   $_GET["division"];
    }

    if(isset($_GET["department"]))
    {
        $_DepartCode    =   $_GET["department"];
    }

    if(isset($_GET["empcode"]))
    {
        $_EMPCode       =   $_GET["empcode"];
    }

    if(isset($_GET["tskstatus"]))
    {
        $_TskStatus       =   $_GET["tskstatus"];
    }

    if(isset($_GET["StartDate"]))
    {
        $_StartDate       =   $_GET["StartDate"];
    }

    if(isset($_GET["EndDate"]))
    {
        $_EndDate         =   $_GET["EndDate"];
    }

    $FilPOwnerName  =   "";

    if($_ProOwner != "ALL"){
        $FilPOwnerName = strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_ProOwner));
    }else{
        $FilPOwnerName = "ALL";
    }

    $_Count     =   0;
    $FilEmpName =   "";

    if($_EMPCode != "ALL"){
        $FilEmpName = strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_EMPCode));
    }else{
        $FilEmpName = "ALL";
    }



    $_Title     =   "W/F - Equipment Maintenance Summary Report as at ".$Dte_today." : ".$Dte_Time.".";
    $_SubTitle  =   "Equip. - ".$_Division." / Maintenance. - ".$_DepartCode." / W/F Owner - ".$FilEmpName." / W/F. Sts. - ".$_TskStatus;
    
    
    $MailBody           .= "
        <html>
        <head>
        <title>.:: PROJECT STATUS REPORT ::.</title>
        <style type='text/css'>
            body{
                font-family:sans serif;
                font-size:12px;
                color:#000066;
            }  
            table{
                border-collapse:collapse;
                border:1px solid black;
                border-color: #000066;
            }
            th{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 12px;
                color: #000099;
                width: auto;
            }
            td{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 12px;
                color: #000099;
                width: auto;
            }
        </style>
        </head>
        <body>
        ";
    
    $MailBody           .="
        <table align='center' style='border-style: hidden;  border-color: transparent'>

            <tr style='border-style: hidden;  border-color: transparent' align='center'>
            <th>
                <p align='center'><font size='5'><u>".$_Title."</u></font> </p>
                <p align='center'><font size='3'>".$_SubTitle."</font> </p>
            </th>
            </tr>
        </table>
        <BR>";
       
    
    if($_Division == "ALL"){
        $_DivisionCMD = "";
    }else{
        $_DivisionCMD = " AND t1.EqType  = '$_Division'";
    }
    
    if($_DepartCode == "ALL"){
        $_DepartCodeCMD = "";
    }else{
        $_DepartCodeCMD = " AND t1.Mtype = '$_DepartCode'";
    }
    
    if($_EMPCode == "ALL"){
        $_EMPCodeCMD = "";
    }else{
        $_EMPCodeCMD = " AND `t1.wk_Owner` = '$_EMPCode'";
    }
    
    if($_TskStatus == "ALL"){
        $_TskStatusCMD = "";
    }else{
        $_TskStatusCMD = " AND t1.status = '$_TskStatus'";
    }
    
    $NewDivition = "";
    $OldDivition = "";
    
    $Newdepartment = "";
    $OldDepartment = "";
    
    $NewEmployee = "";
    $OldEmployee = "";
    
    $HTML = "";
    $HTML1 = "";
    $HTML2 = "";
    
    $NewDate = "";
    $OldDate = "";
    
     $_RecordCount = 0;
    $_CreateDate  = "";
    
    //$MailBody .= "<Br/><Br/>W/F Create Date : ".$_CreateDate."<Br/><Br/>";            
            
    $MailBody .= "<table cellpadding=\"5px\" cellspacing=\"0\" width=\"100%\" border=\"1px\">";
    $MailBody .= "<thead style=\"background-color: #FFE7A1\">";
    $MailBody .= "<tr>";                    
    $MailBody .= "<th style=\"width:10%\">Time</th>";
    $MailBody .= "<th style=\"width:10%\">Task Status</th>";
    $MailBody .= "<th style=\"width:80%\">Task</th>";                                                
    $MailBody .= "</tr>";
    $MailBody .= "</thead>";
    $MailBody .= "<tbody>";
        
    $_SelectQuery   =   "SELECT t1.wk_id, t1.wk_owner, t1.wk_name, t1.start_time, t1.end_time, t1.wk_update, t1.crt_date, t1.status, t1.EqType, t1.Mtype 
                            FROM tbl_workflowupdate  AS t1 
                                WHERE t1.EqType <> '' AND  t1.crt_date >= '".$_StartDate."' AND t1.crt_date <= '".$_EndDate."' ".$_TskStatusCMD."".$_DivisionCMD."".$_DepartCodeCMD."".$_EMPCodeCMD." 
                                    GROUP BY t1.crt_date, t1.EqType, t1.Mtype, t1.wk_owner, t1.wk_id, t1.wk_name, t1.start_time, t1.end_time, t1.wk_update, t1.status 
                                    ORDER BY t1.crt_date";
    //$_ResultSet1     =   mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
    
    //echo $_SelectQuery;
    
    //$_SelectQuery   =   "SELECT `wk_id`,`wk_name`,`wk_Owner`,`schedule`,`sched_time`,`start_time`,`end_time`,`report_owner`,`report_div`,`report_Dept`,`crt_date`,`status`,`crt_by`,`auto_id` 
    //                        FROM tbl_workflow WHERE `status` = 'A' ".$_DivisionCMD."".$_DepartCodeCMD."".$_EMPCodeCMD." 
    //                            GROUP BY `report_div`, `report_Dept`, `wk_Owner`, `wk_id`,`wk_name`,`schedule`,`sched_time`,`start_time`,`end_time`,`report_owner`,`crt_date`,`status`,`crt_by`,`auto_id`"; 
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {    
        
        $_WFID  =   $_myrowRes['wk_id'];
        
        $OldDivition = $NewDivition;
        $NewDivition = $_myrowRes['EqType'];
        
                
        $OldDepartment = $Newdepartment;
        $Newdepartment = $_myrowRes['Mtype'];   
        
                
        $OldEmployee = $NewEmployee;
        $NewEmployee = $_myrowRes['wk_owner'];        
       
        $_CreateDate = $_myrowRes['crt_date'];
            
        $OldDate = $NewDate;
        $NewDate = $_myrowRes['crt_date'];
        
        if($OldDivition != ""){
        
            if($OldDate != $NewDate){  
                
                $MailBody .= "</tbody>";
                $MailBody .= "<thead style=\"background-color: #FFE7A1\">";
                $MailBody .= "<tr>";
                $MailBody .= "<th colspan=\"3\" align=\"left\">";
                    $MailBody .= "<font color=\"red\"><b>W/F Create Date : </b>".$NewDate." | </font><Br/> ";
                    $MailBody .= "<b>Equipment : </b>".getEQList($str_dbconnect,$NewDivition)." | ";
                    $MailBody .= "<b>Maintenance Type : </b>".getEQMListDetails($str_dbconnect,$NewDivition, $Newdepartment)." | ";
                    //$MailBody .= "dsfsdf". $NewDivition . " - " .$Newdepartment;
                    $MailBody .= "<b>W/F User : </b>".getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$NewEmployee)."<Br/>";
                $MailBody .= "</th>";
                $MailBody .= "</tr>";
                $MailBody .= "</thead>";

            }

            if($OldDivition != $NewDivition){
                $MailBody .= "</tbody>";
                $MailBody .= "<thead style=\"background-color: #FFE7A1\">";
                $MailBody .= "<tr>";
                $MailBody .= "<th colspan=\"3\" align=\"left\">";
                    $MailBody .= "<font color=\"red\"><b>W/F Create Date : </b>".$NewDate." | </font><Br/> ";
                    $MailBody .= "<b>Equipment : </b>".getEQList($str_dbconnect,$NewDivition)." | ";
                    $MailBody .= "<b>Maintenance Type : </b>".getEQMListDetails($str_dbconnect,$NewDivition, $Newdepartment)." | ";
                    //$MailBody .= "dsfsdf". $NewDivition . " - " .$Newdepartment;
                    $MailBody .= "<b>W/F User : </b>".getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$NewEmployee)."<Br/>";
                $MailBody .= "</th>";
                $MailBody .= "</tr>";
                $MailBody .= "</thead>";

            }

            if($OldDepartment != $Newdepartment){
                $MailBody .= "</tbody>";
                $MailBody .= "<thead style=\"background-color: #FFE7A1\">";
                $MailBody .= "<tr>";
                $MailBody .= "<th colspan=\"3\" align=\"left\">";
                    $MailBody .= "<font color=\"red\"><b>W/F Create Date : </b>".$NewDate." | </font><Br/> ";
                    $MailBody .= "<b>Equipment : </b>".getEQList($str_dbconnect,$NewDivition)." | ";
                    $MailBody .= "<b>Maintenance Type : </b>".getEQMListDetails($str_dbconnect,$NewDivition, $Newdepartment)." | ";
                    //$MailBody .= "dsfsdf". $NewDivition . " - " .$Newdepartment;
                    $MailBody .= "<b>W/F User : </b>".getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$NewEmployee)."<Br/>";
                $MailBody .= "</th>";
                $MailBody .= "</tr>";
                $MailBody .= "</thead>";
                $MailBody .= "<tbody>";
            }

            if($OldEmployee != $NewEmployee){
                $MailBody .= "</tbody>";
                $MailBody .= "<thead style=\"background-color: #FFE7A1\">";
                $MailBody .= "<tr>";
                $MailBody .= "<th colspan=\"3\" align=\"left\">";
                    $MailBody .= "<font color=\"red\"><b>W/F Create Date : </b>".$NewDate." | </font><Br/> ";
                    $MailBody .= "<b>Equipment : </b>".getEQList($str_dbconnect,$NewDivition)." | ";
                    $MailBody .= "<b>Maintenance Type : </b>".getEQMListDetails($str_dbconnect,$NewDivition, $Newdepartment)." | ";
                    //$MailBody .= "dsfsdf". $NewDivition . " - " .$Newdepartment;
                    $MailBody .= "<b>W/F User : </b>".getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$NewEmployee)."<Br/>";
                $MailBody .= "</th>";
                $MailBody .= "</tr>";
                $MailBody .= "</thead>";
                $MailBody .= "<tbody>";
            }
        
        }else{
            $MailBody .= "</tbody>";
            $MailBody .= "<thead style=\"background-color: #FFE7A1\">";
            $MailBody .= "<tr>";
            $MailBody .= "<th colspan=\"3\" align=\"left\">";
                $MailBody .= "<font color=\"red\"><b>W/F Create Date : </b>".$NewDate." | </font><Br/> ";
                $MailBody .= "<b>Equipment : </b>".getEQList($str_dbconnect,$NewDivition)." | ";
                $MailBody .= "<b>Maintenance Type : </b>".getEQMListDetails($str_dbconnect,$NewDivition, $Newdepartment)." | ";
                //$MailBody .= "dsfsdf". $NewDivition . " - " .$Newdepartment;
                $MailBody .= "<b>W/F User : </b>".getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$NewEmployee)."<Br/>";
            $MailBody .= "</th>";
            $MailBody .= "</tr>";
            $MailBody .= "</thead>";
        }
        
        $_RecordCount = $_RecordCount + 1;            


        $MailBody .= "<tr>";                                     
        $MailBody .= "<td rowspan=\"2\" width=\"10%\">";
        $MailBody .= $_myrowRes['start_time'] .' - '.$_myrowRes['end_time'];
        $MailBody .= "</td>";
        $MailBody .= "<td align=\"center\" width='10%'>";
        if($_myrowRes['status'] == "No"){
            $MailBody .= "<font color=\"red\"><b>".$_myrowRes['status']."</font></b>";     
        }else if($_myrowRes['status'] == "Yes"){
            $MailBody .= "<font color=\"green\"><b>".$_myrowRes['status']."</font></b>";     
        }else if($_myrowRes['status'] == "N/A"){
            $MailBody .= "<font color=\"meroon\"><b>".$_myrowRes['status']."</font></b>";     
        }else{
            $MailBody .= "<font color=\"grey\"><b>".$_myrowRes['status']."</font></b>";     
        }
        $MailBody .= "</td>";
        $MailBody .= "<td width='80%'>";
        $MailBody .= "<font color=\"#777777\">[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name']."</font>";
        $MailBody .= "</td>";
        $MailBody .= "</tr>";   
        $MailBody .= "<tr>";
        $MailBody .= "<td width=\"10%\"><b>W/F User Update :</b></td>";
        $MailBody .= "<td align=\"left\">";
        $MailBody .= "".$_myrowRes['wk_update']."-&nbsp;";
        $MailBody .= "</td>";                         
        $MailBody .= "</tr>";
        $MailBody .= "<tr>";
        $MailBody .= "<td width=\"10%\"><b>Attachments</b></td>";
        $MailBody .= "<td colspan=\"2\" align=\"left\" width='90%'>";  

                    $WorkFlowid = $_myrowRes['wk_id'];
                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
                    $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));

                    $num_rows = mysqli_num_rows($_ResultSetq);
                    if($num_rows > 0){                            
                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
                            $MailBody .= "<a href='files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
                        }                                                    
                    }else{
                        $MailBody .= "There are no Attachments to Download";
                    }

        $MailBody .= "</td>";                         
        $MailBody .= "</tr>";                                 
        
    }    
   
    $MailBody .= "</tbody>";
    $MailBody .= "</table><Br/>";            
        
    
    $MailBody .= "</body></html>";
    
    echo $MailBody;
    /*
    $mailer = new PHPMailer();
    $mailer->IsSMTP();
    $mailer->Host = 'ssl://smtp.gmail.com:465';
    $mailer->SetLanguage("en", 'class/');
    $mailer->SMTPAuth = TRUE;
    $mailer->IsHTML = TRUE;
    $mailer->Username = 'info@tropicalfishofasia.com'; // Change this to your gmail adress
    $mailer->Password = 'info321'; // Change this to your gmail password
    $mailer->From = 'info@tropicalfishofasia.com'; //$StrFromMail; // This HAVE TO be your gmail adress
    $mailer->FromName = 'Work Flow'; // This is the from name in the email, you can put anything you like here

    $mailer->Body = $MailBody;
    /* ----------------------------------------------------------------- */
    //$TskUser =  getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$LogUserCode);
    $today_date  = date("Y-m-d");

    $mailer->AddAddress('shameerap@cisintl.com');
    $mailer->AddCC('indikag@cisintl.com');
    $MailTitile = $_Title;
    $mailer->Subject = $MailBody;;
    /*$MailTitile = "TO : " . $TaskUsers . " - NEW TASK - " . $_Division . " " . $_Department . " - " . $Str_TaskName;


    $mailer->AddCC(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_ProOwner));
    $mailer->AddBCC('pms@cisintl.com');*//*
    if (!$mailer->Send()) {  
        $Message = "<b>W/F Updated & Mail Error : ". $mailer->ErrorInfo."</b><br/><br/>";                    
    }else{
        $Message = "<b>W/F Updated & Mail Sent</b></br>";
    }
    */
?>