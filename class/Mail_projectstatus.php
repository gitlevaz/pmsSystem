
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
    include ("../class/sql_project.php");           //  sql commands for the access controls
    include ("../class/sql_task.php");              //  sql commands for the access controles
    include ("../class/accesscontrole.php");        //  sql commands for the access controles
    include ("../class/sql_empdetails.php");        //  connection file to the mysql database
    //include ("../class/class.phpmailer.php");       //  connection file to the mysql database
    require_once("../class/class.phpmailer.php");
	require_once("../class/class.SMTP.php");
    //include ("../class/sql_crtprocat.php");    //  connection file to the mysql database
    //include ("../class/MailBodyOne.php");           //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

    $MailBody           =   "";
    $PageRoll           =   1;
    $TitleEntered       =   0;

    $_DepartCode    = "";
    $_Department    = "";
    $_Division      = "";
    $_Title         = "";

    function getTimeDiffRemaining( $timeA,$timeB,$timeC){
        $time1 = $timeA . ':' ;
        $time2 = $timeB . ':' ;
        $time3 = $timeC . ':' ;

        $H1 = 0;
        $H2 = 0;
        $H3 = 0;

        $M1 = 0;
        $M2 = 0;
        $M3 = 0;

        $arrTime1  =   explode(':', $time1);
        $H1  =   floatval($arrTime1[0]);
        $M1  =   floatval($arrTime1[1]);

        $arrTime2  =   explode(':', $time2);
        $H2  =   floatval($arrTime2[0]);
        $M2  =   floatval($arrTime2[1]);

        $arrTime3  =   explode(':', $time3);
        $H3  =   floatval($arrTime3[0]);
        $M3  =   floatval($arrTime3[1]);

        $H2 = $H2 + $H3;
        $M2 = $M2 + $M3;

        if($M2 > 60) {
            $M2 = $M2 - 60;
            $H2 = $H2 + 1;
        }

        $HH  = 0;
        $MM  =  0;

        $HH  =  $H2 - $H1;

        if($M2 < $M1 ){
            $MM = ($M2 + 60) - $M1;

            $HH = $HH - 1;
        }else{
            $MM = $M2 - $M1;
        }
        $answertime = $HH . ':' . $MM . ':00';

        return $answertime;
    }

    function getGROUPNAMEMAIL($strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}

    function getPrecentage( $timeA,$timeB,$timeC){

        $time1 = $timeA . ':' ;
        $time2 = $timeB . ':' ;
        $time3 = $timeC . ':' ;

        $H1 = 0;
        $H2 = 0;
        $H3 = 0;

        $M1 = 0;
        $M2 = 0;
        $M3 = 0;

        $arrTime1  =   explode(':', $time1);
        $H1  =   floatval($arrTime1[0]);
        $M1  =   floatval($arrTime1[1]);

        $arrTime2  =   explode(':', $time2);
        $H2  =   floatval($arrTime2[0]);
        $M2  =   floatval($arrTime2[1]);

        $arrTime3  =   explode(':', $time3);
        $H3  =   floatval($arrTime3[0]);
        $M3  =   floatval($arrTime3[1]);

        $H2 = $H2 + $H3;
        $M2 = $M2 + $M3;

        if($M2 > 60) {
            $M2 = $M2 - 60;
            $H2 = $H2 + 1;
        }

        $H1 = $H1 * 60;
        $M1 = $M1 + $H1;

        $H2 = $H2 * 60;
        $M2 = $M2 + $H2;

        $Precentage = 0;

        $Precentage = (($M1 / $M2) * 100);

        $answertime = round($Precentage,'2') . " %";

        if($answertime == ""){
            $answertime = "0 %";
        }
        
        return $answertime;

    }

    $_ProjetSet = get_ActiveProjectDetails($str_dbconnect);
    while($_ProjectRes = mysqli_fetch_array($_ProjetSet)) {
    //  TAKING PROJECT DETAILS
    //if(isset($_SESSION['ProjectCode'])) {
        
        $_ProCode       =   $_ProjectRes['procode'];
        $_ProName       =   "";
        $_StartDate     =   "";
        $_crtusercode   =   "";
        $_crtdate       =   "";
        $_EndDate       =   "";
        $_prostatus     =   "";
        $_projectowner  =   "";
        $_projectInit   =   "";

        $_TotHrsSpent       =   "00:00:00";
        $_TotHrsApproved    =   "00:00:00";
        $_TotHrsEstimated   =   "00:00:00";

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
        }
    //}

    $_Department = getGROUPNAMEMAIL($_DepartCode);

    $Dte_today          = 	date("Y/m/d") ;
    $_PrintBy           =	$_SESSION["LogUserCode"];

    date_default_timezone_set('Asia/Colombo');
    $Dte_Time           = 	date("h:i:s a", time()) ;

    $_TotHrsSpent       =   getTotalProjectHoursSpent($str_dbconnect,$_ProCode);
    $_TotHrsEstimated   =   getTotalProjectEstimatedHours($str_dbconnect,$_ProCode);
    $_TotHrsApproved    =   getTotalProjectaddlHrsApproved($str_dbconnect,$_ProCode);

    //$_Title =   " - PROJECT STATUS REPORT : ".strtoupper($_Division)."/".strtoupper($_Department)." as at ".$Dte_today." : ".$Dte_Time." - ";
    $_Title =   "P/M - (STATUS REPORT) as at ".$Dte_today." : ".$Dte_Time.".";

    if ($PageRoll == 1) {
        $_PageBGColour      =   "#EAEBFF";
        $PageRoll = 0;
    }else {
        $_PageBGColour      =   "#e9eff2";
        $PageRoll = 1;
    }
    $MailBody           .= "


<html>
<head>
<title>.:: PROJECT STATUS REPORT ::.</title>
<style type='text/css'>/*
    .TableinnerA {
        font-family: Century Gothic;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        color: #000099;
    }
    .TableHeading {
        font-family: Century Gothic;
        font-size: 24px;
        font-weight: bold;
        text-decoration: underline;
        color: #000099;
    }*/
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
</style>
</head>
<body>
";
    if ($TitleEntered == 0)  {
        $MailBody           .="
        <table   align='center' style='border-style: hidden;  border-color: transparent'>

            <tr style='border-style: hidden;  border-color: transparent' align='center' class='TableHeading'>
            <th>
                <p align='center'><font size='5'>".$_Title."</font> </p>
            </th>
            </tr>
        </table>";
        $TitleEntered = 1;
    }
        $MailBody           .= "</br>
<table   align='left' style='border-style: hidden;  border-color: transparent' >
    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Code</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
             ". $_ProCode . "
        </td>
    </tr>
    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Name</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            " . $_ProName ."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Create Date</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            ". $_crtdate ."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Create By</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            ". strtoupper(getSELECTEDSYSUSERNAME($str_dbconnect,$_crtusercode)) ."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Owner</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectowner))."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Initiated By</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td   align='left' style='border-style: hidden;  border-color: transparent'>
            ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectInit))."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Start Date</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td   align='left' style='border-style: hidden;  border-color: transparent'>
            ". $_StartDate ."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Deadline</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            ".$_EndDate."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Completion %</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td   align='left' style='border-style: hidden;  border-color: transparent'>".getPrecentage($_TotHrsSpent,$_TotHrsEstimated,$_TotHrsApproved)."</td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Total Hrs Spent</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td   align='left' style='border-style: hidden;  border-color: transparent'>
            ".$_TotHrsSpent."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Total Hrs Remaining</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td   align='left' style='border-style: hidden;  border-color: transparent'>".getTimeDiffRemaining($_TotHrsSpent,$_TotHrsEstimated,$_TotHrsApproved)."</td>
    </tr>
</table>";

$MailBody           .= "</br></br></br></br></br></br></br></br></br></br></br></br>
<table  bgcolor='".$_PageBGColour."' width='2500px'>
    <tr>
        <th rowspan='2' >Task Code</th>
        <th rowspan='2' >Milestones / Sub-Projects</th>
        <th rowspan='2' >Task Owner</th>
        <th rowspan='2' >Date Started</th>
        <th rowspan='2' >Due Date</th>
        <th rowspan='2' align='center'>Percentage Completed</th>
        <th rowspan='2' >Stage Summary</th>
        <th rowspan='2' >Impediments</th>
        <th rowspan='2' >Pending Approvals</th>
        <th rowspan='2' >Amount Required</th>
        <th rowspan='2' >Amount Paid</th>
        <th rowspan='2' >Balance</th>
        <th rowspan='1' colspan='5' align='center'>Hours Summary</th>
    </tr>
    <tr>
        <th >Hrs Estimated @ Start</th>
        <th >Addl Hrs Requested</th>
        <th >Addl hrs approved</th>
        <th >Total Hrs  Spent</th>
        <th >Total hrs remaning</th>
    </tr>
";


        $Sublelvelcount     = '0';
        $MaximumSubLevel    = '0';

        $_ResultSet = get_TaskDetails($str_dbconnect,$_ProCode);
        while($_myrowRes = mysqli_fetch_array($_ResultSet))
        {
//
            if($_myrowRes['parent'] == '0'){
    ?>
    <?php    $MailBody .= " <tr>
                    <td > ". $_myrowRes['taskcode'] ." </td>
                    <td >". $_myrowRes['taskname'] ." </td>
                    <td >". strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowRes['assignuser'])) ."</td>
                    <td  align='center'>". $_myrowRes['taskcrtdate'] ."</td>
                    <td  align='center'>". $_myrowRes['taskenddate'] ."</td>
                    <td  align='center'>".$_myrowRes['Precentage']."%"."</td>
                    <td >"; ?>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowRes['taskcode'], 'Task Update')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                            }
                        ?>
                    <?php
                        $MailBody .= "</td>
                        <td >";
                    ?>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowRes['taskcode'], 'Impediment')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                            }
                        ?>
                    <?php
                        $MailBody .= "
                        </td>
                        <td >";
                    ?>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowRes['taskcode'], 'Approval')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                               $MailBody .=  $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                            }
                        ?>
                    <?php $MailBody .= "
                        </td>
                        <td  align='right'>0.00</td>
                        <td  align='right'>0.00</td>
                        <td  align='right'>0.00</td>
                        <td align='center'>". $_myrowRes['AllHours'] ."</td>
                        <td align='center'>".getaddlHrsRequest($str_dbconnect,$_myrowRes['taskcode'])."</td>
                        <td align='center'>".getaddlHrsApproved($str_dbconnect,$_myrowRes['taskcode'])."</td>
                        <td align='center'>".getHoursSpent($str_dbconnect,$_myrowRes['taskcode'])."</td>
                        <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowRes['taskcode']),$_myrowRes['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowRes['taskcode']))."</td>
                        </tr> ";

                    ?>
    <?php
            }
    ?>
    <?php
            $_Resultsub = get_TaskDetailsParent($str_dbconnect,$_myrowRes['taskcode'], '2');
            while($_myrowsub = mysqli_fetch_array($_Resultsub)){
    ?>
    <?php       $MailBody .= "
                <tr>
                    <td>". $_myrowsub['taskcode']."</td>
                    <td style='padding-left: 20'>". $_myrowsub['taskname'] ."</td>
                    <td >". strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowsub['assignuser']))."</td>
                    <td align='center'>". $_myrowsub['taskcrtdate'] ."</td>
                    <td align='center'>". $_myrowsub['taskenddate'] ."</td>
                    <td align='center'>".$_myrowsub['Precentage']."%"."</td>
                    <td >  " ;
    ?>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub['taskcode'], 'Task Update')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                            }
                        ?>
            <?php
                $MailBody .= "
                    </td>
                    <td > ";
            ?>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub['taskcode'], 'Impediment')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                            }
                        ?>
            <?php
                $MailBody .= "
                    </td>
                    <td > ";
            ?>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub['taskcode'], 'Approval')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                            }
                        ?>
            <?php
                    $MailBody .= "
                    </td>
                    <td  align='right'>0.00</td>
                    <td  align='right'>0.00</td>
                    <td  align='right'>0.00</td>
                    <td align='center'>". $_myrowsub['AllHours'] ."</td>
                    <td align='center'>".getaddlHrsRequest($str_dbconnect,$_myrowsub['taskcode'])."</td>
                    <td align='center'>".getaddlHrsApproved($str_dbconnect,$_myrowsub['taskcode'])."</td>
                    <td align='center'>".getHoursSpent($str_dbconnect,$_myrowsub['taskcode'])."</td>
                    <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowsub['taskcode']),$_myrowsub['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowsub['taskcode']))."</td>
                </tr>";
            ?>
    <?php
                $_Resultsub1 = get_TaskDetailsParent($str_dbconnect,$_myrowsub['taskcode'], '3');
                while($_myrowsub1 = mysqli_fetch_array($_Resultsub1)){
    ?>
    <?php
                    $MailBody .= "<tr>
                        <td>". $_myrowsub1['taskcode']."</td>
                        <td style='padding-left: 40'>". $_myrowsub1['taskname'] ."</td>
                        <td >". strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowsub1['assignuser']))."</td>
                        <td align='center'>". $_myrowsub1['taskcrtdate'] ."</td>
                        <td align='center'>". $_myrowsub1['taskenddate'] ."</td>
                        <td align='center'>".$_myrowsub1['Precentage']."%"."</td>
                        <td > ";
    ?>
                            <?php
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Task Update')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                }
                            ?>
                        <?php
                $MailBody .= "
                    </td>
                    <td > ";
            ?>
                            <?php
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Impediment')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                }
                            ?>
                        <?php
                $MailBody .= "
                    </td>
                    <td > ";
            ?>
                            <?php
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Approval')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                }
                            ?>
   <?php
                        $MailBody .= "
                        </td>
                            <td  align='right'>0.00</td>
                            <td  align='right'>0.00</td>
                            <td  align='right'>0.00</td>
                            <td align='center'>". $_myrowsub1['AllHours'] ."</td>
                            <td align='center'>".getaddlHrsRequest($str_dbconnect,$_myrowsub1['taskcode'])."</td>
                            <td align='center'>".getaddlHrsApproved($str_dbconnect,$_myrowsub1['taskcode'])."</td>
                            <td align='center'>".getHoursSpent($str_dbconnect,$_myrowsub1['taskcode'])."</td>
                            <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowsub1['taskcode']),$_myrowsub1['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowsub1['taskcode']))."</td>
                        </tr>";
    ?>
    <?php
                    $_Resultsub2 = get_TaskDetailsParent($str_dbconnect,$_myrowsub1['taskcode'], '4');
                    while($_myrowsub2 = mysqli_fetch_array($_Resultsub2)){
    ?>
    <?php
                        $MailBody .= "
                        <tr>
                            <td>". $_myrowsub2['taskcode']."</td>
                            <td style='padding-left: 60'>". $_myrowsub2['taskname'] ."</td>
                            <td >". strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowsub2['assignuser']))."</td>
                            <td align='center'>". $_myrowsub2['taskcrtdate'] .".</td>
                            <td align='center'>". $_myrowsub2['taskenddate'] ."</td>
                            <td align='center'>".$_myrowsub2['Precentage']."%"."</td>
                            <td >";
    ?>
                                <?php
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Task Update')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                    }
                                ?>
                            <?php
                $MailBody .= "
                    </td>
                    <td > ";
            ?>
                                <?php
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Impediment')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                    }
                                ?>
                            <?php
                $MailBody .= "
                    </td>
                    <td > ";
            ?>
                                <?php
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Approval')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                    }
                                ?>
    <?php
                            $MailBody .= "</td>
                                <td  align='right'>0.00</td>
                                <td  align='right'>0.00</td>
                                <td  align='right'>0.00</td>
                                <td align='center'>". $_myrowsub2['AllHours'] ."</td>
                                <td align='center'>".getaddlHrsRequest($str_dbconnect,$_myrowsub2['taskcode'])."</td>
                                <td align='center'>".getaddlHrsApproved($str_dbconnect,$_myrowsub2['taskcode'])."</td>
                                <td align='center'>".getHoursSpent($str_dbconnect,$_myrowsub2['taskcode'])."</td>
                                <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowsub2['taskcode']),$_myrowsub2['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowsub2['taskcode']))."</td>
                            </tr>";
    ?>
    <?php
                    }
                }
            }
            $Sublelvelcount ++ ;
        }

    ?>
    <?php

        $MailBody .= "
                    </table>
                    <br><br>
                    </body>
                    </html> " ;

    }
    ?>
<?php

/*
                $mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'outbounds10.obsmtp.com';
                $mailer->SetLanguage('en', '');
                $mailer->SMTPAuth = TRUE;
                $mailer->SMTPSecure = 'ssl';
                $mailer->Port       = 587;
                $mailer->Username = 'info@tropicalfishofasia.com';  // Change this to your gmail adress
                $mailer->Passwosrd = 'info@321';  // Change this to your gmail password
                $mailer->From = 'info@tropicalfishofasia.com';
                $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here*/

                // $mailer = new PHPMailer();
                // $mailer->IsSMTP();
                // $mailer->Host = '10.9.0.166:25';			//$mailer->Host = 'ssl://smtp.gmail.com:465';
                // $mailer->SetLanguage("en", 'class/');						//$mailer->SetLanguage("en", '');
                // $mailer->SMTPAuth = TRUE;
                // $mailer->IsHTML = TRUE;
                // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress      $mailer->Username = 'info@tropicalfishofasia.com'; 
                // $mailer->Password = 'pms@321';  // Change this to your gmail password          $mailer->Password = 'info321';
                // $mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress       $mailer->From = 'info@tropicalfishofasia.com';
                // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
                // $mailer->Body = $MailBody;
				
					//O365 Email Function Start
				$mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'smtp.office365.com';
                $mailer->SetLanguage("en", 'class/');					
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML(true);//
                $mailer->Username = 'pms@eteknowledge.com';
                $mailer->Password = 'Cissmp@456';
                $mailer->Port = 587;
				$mailer->SetFrom('pms@eteknowledge.com','PMS');
				$mail->CharSet = "text/html; charset=UTF-8;";
				$mailer->Body =str_replace('"','\'',$MailBody);				
				//O365 Email Function END		
				
                //$mailer->Body = CreateReportForMail($Str_ProCode);
                $mailer->Subject = $_Title;
                $mailer->AddAddress('shameerap@cisintl.com');  // This is where you put the email adress of the person you want to mail
                $mailer->AddBCC('pms@cisintl.com');
                //$mailer->AddBCC('shameerap@cisintl.com');
                //$mailer->AddCC();

                if(!$mailer->Send())
                {
                   echo "Message was not sent<br/ >";
                   echo "Mailer Error: " . $mailer->ErrorInfo;
                }
                else
                {
                   echo "Message has been sent";
                }


?>