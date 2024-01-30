<script type='text/javascript' charset='utf-8'>

    function getHours( Startdate, EndDate ){
        t1	= Startdate ;
        t2	= EndDate ;

        var one_day=1000*60*60*24;
        //Here we need to split the inputed dates to convert them into standard format for furter execution

        var x = t1.split('-');
        var y = t2.split('-');

        //date format(Fullyear,month,date)

        var date1=new Date(x[0],(x[1]-1),x[2]);
        //alert(date1);
        var date2=new Date(y[0],(y[1]-1),y[2])

        var month1=x[1]-1;
        var month2=y[1]-1;

        //Calculate difference between the two dates, and convert to days

        Diff    =   Math.ceil((date2.getTime()-date1.getTime())/(one_day));
        //_Diff gives the diffrence between the two dates.
        //alert(Diff);
        Hours       = ((Diff + 1) * 8);
        //alert(Hours);
        return Hours;
    }

    function getTimeDiffRemaining( timeA,timeB,timeC){
        //alert(timeA + " - " +  timeB);
        //var tottime = SumOfMinutes(timeB, timeC);
        var time1 = timeA + ":" ;
        var time2 = timeB + ":" ;
        var time3 = timeC + ":" ;

        var H1 = 0;
        var H2 = 0;
        var H3 = 0;

        var M1 = 0;
        var M2 = 0;
        var M3 = 0;

        var arrTime1  =   time1.split(":");
        H1  =   parseFloat(arrTime1[0]);
        M1  =   parseFloat(arrTime1[1]);

        var arrTime2  =   time2.split(":");
        H2  =   parseFloat(arrTime2[0]);
        M2  =   parseFloat(arrTime2[1]);

        var arrTime3  =   time3.split(":");
        H3  =   parseFloat(arrTime3[0]);
        M3  =   parseFloat(arrTime3[1]);

        H2 = H2 + H3;
        M2 = M2 + M3;

        if(M2 > 60) {
            M2 = M2 - 60;
            H2 = H2 + 1;
        }

        var HH  = 0;
        var MM  =  0;

        HH  =  H2 - H1;

        if(M2 < M1 ){
            MM = (M2 + 60) - M1;

            HH = HH - 1;
        }else{
            MM = M2 - M1;
        }
        var answertime = HH + ":" + MM + ":00";

        return answertime;
    }

</script>

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
    //include ("../class/MailBodyOne.php");           //  connection file to the mysql database
    //include ("../class/sql_crtprocat.php");    //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

    function getEMPMAIL($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;
	}

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

    $MailBody           =   "";
    $PageRoll           =   1;
    $TitleEntered       =   0;

    $Dte_today          = 	date("Y/m/d") ;
    $_PrintBy           =	$_SESSION["LogUserCode"];

    date_default_timezone_set('Asia/Colombo');
    $Dte_Time           = 	date("h:i:s a", time()) ;

     $_DepartCode = "";
     $_Department = "";
     $_EMPCode    =   "";

    $_DeparmentSet = getEMPMAIL($str_dbconnect);
    while($_DeparmentRes = mysqli_fetch_array($_DeparmentSet)) {

        $_EMPCode  =   $_DeparmentRes['EmpCode'];

        //$_DepartCode = $_DeparmentRes['GrpCode'];
        ///$_Department = $_DeparmentRes['Group']. " AT ". $_DeparmentRes['Country'];

        $_Title =   "P/M - Status Summary Report as at ".$Dte_today." : ".$Dte_Time.".";

        $MailBody           =   "";
        $TitleEntered       =   0;
        
    $_ProjetSet = get_ProjectDetailsTaskEmployee($str_dbconnect,$_EMPCode);
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



    $_TotHrsSpent       =   getTotalProjectHoursSpent($str_dbconnect,$_ProCode);
    $_TotHrsEstimated   =   getTotalProjectEstimatedHours($str_dbconnect,$_ProCode);
    $_TotHrsApproved    =   getTotalProjectaddlHrsApproved($str_dbconnect,$_ProCode);

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
        <table class='TableinnerA'  align='center' style='border-style: hidden;  border-color: transparent' bgcolor='".$_PageBGColour."'>

            <tr style='border-style: hidden;  border-color: transparent' align='center' class='TableHeading'>
            <th>
                <p align='center'><font size='5'>".$_Title."</font> </p>
            </th>
            </tr>
        </table> ";
        $TitleEntered = 1;
    }
        $MailBody           .= "</br>
<table align='left' style='border-style: hidden;  border-color: transparent'>
    <tr style='border-style: hidden;  border-color: transparent'>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Code</font>
        </td>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
             ". $_ProCode . "
        </td>
    </tr>
    <tr style='border-style: hidden;  border-color: transparent'>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Name</font>
        </td>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
            " . $_ProName ."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Create Date</font>
        </td>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td align='left' style='border-style: hidden;  border-color: transparent'>
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
        <td   align='left' style='border-style: hidden;  border-color: transparent'>
            ".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectowner))."
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Initiate By</font>
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
        <td   align='left' style='border-style: hidden;  border-color: transparent'>
            ".$_EndDate."
        </td>
    </tr>

     <tr style='border-style: hidden;  border-color: transparent'>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Status</font>
        </td>
        <td  align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td   align='left' style='border-style: hidden;  border-color: transparent'>
            ".GetStatusDesc($str_dbconnect,$_prostatus)."
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

    <table width='2500px' bgcolor='".$_PageBGColour."'>
    <tr>
        <th rowspan='2' >Task Code</th>
        <th rowspan='2' >Milestones / Sub-Projects</th>
        <th rowspan='2' >Task Owner</th>
        <th rowspan='2' >Date Started</th>
        <th rowspan='2' >Due Date</th>
        <th rowspan='2' >Task Status</th>
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

        $_ResultSet = get_TaskDetailsEmp($str_dbconnect,$_ProCode, $_EMPCode);
        while($_myrowRes = mysqli_fetch_array($_ResultSet))
        {
//
            if($_myrowRes['parent'] == '0'){
    ?>
    <?php    $MailBody .= " <tr>
                    <td > ". $_myrowRes['taskcode'] ." </td>
                    <td >". $_myrowRes['taskname'] ." </td>
                    <td >"; ?>

                    <?php
                    $_TaskOwnerSet = getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_myrowRes['taskcode'])   ;
                    while($_TaskOwnerRes = mysqli_fetch_array($_TaskOwnerSet)) {
                        $MailBody .= strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_TaskOwnerRes['EmpCode']))."</BR>";
                    }
                    ?>

                    <?php
                    $MailBody .= "</td>
                    <td  align='center'>". $_myrowRes['taskcrtdate'] ."</td>
                    <td  align='center'>". $_myrowRes['taskenddate'] ."</td>
                    <td  align='center'>".GetStatusDesc($str_dbconnect,$_myrowRes['taskstatus'])."</td>
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
                    <td >"; ?>

                    <?php
                    $_TaskOwnerSet = getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_myrowsub['taskcode'])   ;
                    while($_TaskOwnerRes = mysqli_fetch_array($_TaskOwnerSet)) {
                        $MailBody .= strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_TaskOwnerRes['EmpCode']))."</BR>";
                    }
                    ?>

                    <?php
                    $MailBody .= "</td>
                    <td  align='center'>". $_myrowsub['taskcrtdate'] ."</td>
                    <td  align='center'>". $_myrowsub['taskenddate'] ."</td>
                    <td  align='center'>".GetStatusDesc($str_dbconnect,$_myrowsub['taskstatus'])."</td>
                    <td  align='center'>".$_myrowsub['Precentage']."%"."</td>
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
                        <td >"; ?>

                    <?php
                    $_TaskOwnerSet = getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_myrowsub1['taskcode'])   ;
                    while($_TaskOwnerRes = mysqli_fetch_array($_TaskOwnerSet)) {
                        $MailBody .= strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_TaskOwnerRes['EmpCode']))."</BR>";
                    }
                    ?>

                    <?php
                    $MailBody .= "</td>
                        <td align='center'>". $_myrowsub1['taskcrtdate'] ."</td>
                        <td align='center'>". $_myrowsub1['taskenddate'] ."</td>
                        <td  align='center'>".GetStatusDesc($str_dbconnect,$_myrowsub1['taskstatus'])."</td>
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
                        $MailBody .= "</td>
                        <td >";
                    ?>
                            <?php
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Impediment')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                }
                            ?>
                       <?php
                        $MailBody .= "</td>
                        <td >";
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
                            <td >"; ?>

                            <?php
                            $_TaskOwnerSet = getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_myrowsub2['taskcode'])   ;
                            while($_TaskOwnerRes = mysqli_fetch_array($_TaskOwnerSet)) {
                                $MailBody .= strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_TaskOwnerRes['EmpCode']))."</BR>";
                            }
                            ?>

                            <?php
                            $MailBody .= "</td>
                            <td align='center'>". $_myrowsub2['taskcrtdate'] .".</td>
                            <td align='center'>". $_myrowsub2['taskenddate'] ."</td>
                            <td  align='center'>".GetStatusDesc($str_dbconnect,$_myrowsub2['taskstatus'])."</td>
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
                        $MailBody .= "</td>
                        <td >";
                    ?>
                                <?php
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Impediment')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- Updated On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                    }
                                ?>
                            <?php
                        $MailBody .= "</td>
                        <td >";
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

           if($MailBody != ""){
/*
                //$mailer = new PHPMailer();
                $mailer = new PHPMailer();
                $mailer->IsSMTP();
                $mailer->Host = 'ssl://smtp.gmail.com:465';
                //$mailer->Host = '207.232.87.235';
                $mailer->SetLanguage("en", 'class/');
                $mailer->SMTPAuth = TRUE;
                $mailer->IsHTML = TRUE;
                $mailer->Username = 'info@tropicalfishofasia.com';  // Change this to your gmail adress
                $mailer->Password = 'info321';  // Change this to your gmail password
                $mailer->From = 'info@tropicalfishofasia.com';  // This HAVE TO be your gmail adress
                $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here
				*/
				
				// $mailer = new PHPMailer();
	    // $mailer->IsSMTP();
	    // $mailer->Host = '10.9.0.166:25';             // $mailer->Host = 'ssl://smtp.gmail.com:465';  //69.63.218.231:25 //  10.9.0.165:25
	    // $mailer->SetLanguage("en", 'class/');							// $mailer->SetLanguage("en", '');
	    // $mailer->SMTPAuth = TRUE;
	    // $mailer->IsHTML = TRUE;
	    // $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress      $mailer->Username = 'info@tropicalfishofasia.com';
		// $mailer->Password = 'pms@321';  // Change this to your gmail password      $mailer->Password = 'info321';
	    // $mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress        $mailer->From = 'info@tropicalfishofasia.com'; 
	    // $mailer->FromName = 'PMS'; // This is the from name in the email, you can put anything you like here	
				
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
						
				//O365 Email Function END			
				
                //$mailer->Body = $MailBody;
				$mailer->Body =str_replace('"','\'',$MailBody);		
                //$mailer->Body = CreateReportForMail($Str_ProCode);
                $mailer->Subject = strtoupper(getSELECTEDEMPLOYEFIRSTNAMEONLY($str_dbconnect,$_EMPCode))." : ".$_Title;

                $MailAddressDpt =   "";
                $EmpDpt         =   "";

                /*
                $DepartmentMails = getMailUSERFACILITIES($str_dbconnect,$_DepartCode);
                while($_MailRes = mysqli_fetch_array($DepartmentMails)) {
                    $EmpDpt =    $_MailRes['EmpCode'];
                    $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

                    $mailer->AddAddress($MailAddressDpt);  // This is where you put the email adress of the person you want to mail
                }
                */
                //$mailer->AddAddress(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_EMPCode));  // This is where you put the email adress of the person you want to mail
                //$mailer->AddAddress('indikag@cisintl.com');
                $mailer->AddCC('shameerap@cisintl.com');
                $mailer->AddCC('chalanim@cisintl.com');
                $mailer->AddBCC('pms@cisintl.com');
                //$mailer->AddBCC('indikag@cisintl.com');
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
           }
    }
?>