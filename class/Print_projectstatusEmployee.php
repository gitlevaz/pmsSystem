
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

        /* var H1 = 0;
        var H2 = 0;
        var H3 = 0;

        var M1 = 0;
        var M2 = 0;
        var M3 = 0; */

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

        /* var HH  = 0;
        var MM  =  0; */

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
    
    function DownloadFile(url){
        newwindow=window.open(url);
        if (window.focus) {newwindow.focus()}
                            return false;
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
    //include ("../class/MailBodyOne.php");           //  connection file to the mysql database
    //include ("../class/sql_crtprocat.php");    //  connection file to the mysql database
    
    /* $H1 = 0;
    $H2 = 0;
    $H3 = 0;

    $M1 = 0;
    $M2 = 0;
    $M3 = 0;

    $HH  = 0;
    $MM  =  0;
    $Precentage = 0; */

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

    function getGROUPMAIL($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpStat = 'A'" or die(mysqli_error($str_dbconnect));
		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;
	}

    function getTimeDiffRemaining( $timeA,$timeB,$timeC){

        /* $H1 = 0;
        $H2 = 0;
        $H3 = 0;

        $M1 = 0;
        $M2 = 0;
        $M3 = 0;

        $HH  = 0;
        $MM  =  0; */

        $time1 = $timeA . ':' ;
        $time2 = $timeB . ':' ;
        $time3 = $timeC . ':' ;

        
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

        $arrTime1  =   explode(':', $time1);
        $H1  =   floatval($arrTime1[0]);
        $M1  =   floatval($arrTime1[1]);

        $arrTime2  =   explode(':', $time2);
        $H2  =   floatval($arrTime2[0]);
        $M2  =   floatval($arrTime2[1]);

        $arrTime3  =   explode(':', $time3);
        $H3  =   floatval($arrTime3[0]);
        $M3  =   floatval($arrTime3[1]);

       if($M1 !=0 && $M2!=0 && $M3!=0 && $H1!=0 && $H2!=0 && $H3!=0) {
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

         //$Precentage = 0; 

        $Precentage = (($M1 / $M2) * 100);

        $answertime = round($Precentage,'2') . " %";

        if($answertime == ""){
            $answertime = "0 %";
        }

        return $answertime;}

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
     $projectCatagory = "";
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

    if(isset($_GET["catergory"])){
        $projectCatagory = $_GET["catergory"]; 
		
		
    }
    if(isset($_GET["empcode"]))
    {
        $_EMPCode       =   $_GET["empcode"];
    }

    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "R6") != 1 ) {
        $_EMPCode = $_SESSION["LogEmpCode"];
    }

    if(isset($_GET["proowner"]))
    {
        $_ProOwner       =   $_GET["proowner"];
    }

    if(isset($_GET["prostatus"]))
    {
        $_ProStatus       =   $_GET["prostatus"];
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
    
    if($_StartDate == "ALL"){
        $dateFromRange = "ALL";
    }else{
        $dateFromRange = $_StartDate;
    }
    
    if($_EndDate == "ALL"){
        $dateEndRange = "ALL";
    }else{
        $dateEndRange = $_EndDate;
    }
	if(isset($_GET["ProInit"]))
    {
        $_ProInit =   $_GET["ProInit"];
    }
	
/*
echo "<script>
    alert('".$_StartDate."'+'-74747');
</script>";
*/
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



    $_Title     =   "P/M - Status Summary Report as at ".$Dte_today." : ".$Dte_Time.".";
    $_SubTitle  =   "Div. - ".$_Division." / Dpt. - ".$_DepartCode." / Pro. Own. - ".$FilPOwnerName." / Emp. - ".$FilEmpName." / Pro. Sts. - ".GetStatusDesc($str_dbconnect,$_ProStatus)." / Tsk. Sts. - ".GetStatusDesc($str_dbconnect,$_TskStatus)." / From Date - ". $dateFromRange . " / End Date - " .$dateEndRange;
    /*
    $_DeparmentSet = getGROUPMAIL($str_dbconnect);
    while($_DeparmentRes = mysqli_fetch_array($_DeparmentSet)) {

        //$_EMPCode  =   $_DeparmentRes['EmpCode'];

        $_DepartCode = $_DeparmentRes['GrpCode'];
        $_Department = $_DeparmentRes['Group']. " AT ". $_DeparmentRes['Country'];

        $_Title =   "P/M - Status Summary Report as at ".$Dte_today." : ".$Dte_Time.".";

        $MailBody           =   "";
        $TitleEntered       =   0;*/
        
    $_ProjetSet = get_ProjectDetailsTaskEmployeePrint($str_dbconnect,$_EMPCode,$_ProOwner, $_Division, $_DepartCode,$dateFromRange,$dateEndRange,$_GET["catergory"],$_ProInit);
    while($_ProjectRes = mysqli_fetch_array($_ProjetSet)) {
    //  TAKING PROJECT DETAILS
    //if(isset($_SESSION['ProjectCode'])) {
        
        
    $ProStartDate = $_ProjectRes['startdate'];
    $ProEndDate = $_ProjectRes['EndDate'];
        
    //&& ($_StartDate == "" || $_StartDate <= $_ProjectRes['startdate']) && ($_EndDate == "" || $_EndDate >= $_ProjectRes['EndDate'])
    //&& ($_StartDate == "" || $_StartDate <= $ProStartDate) && ($_EndDate == "" || $_EndDate >= $ProEndDate)  
    if(($_ProOwner == "ALL" || $_ProjectRes['ProOwner'] == $_ProOwner) && ($_ProStatus == "ALL" || $_ProStatus == $_ProjectRes['prostatus'])){

        $_Count        += 1;
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
			$_pro_cat		=   $_myrowRes['proCat'];
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
        font-size: 10px;
        color: #000099;
        width: auto;
    }
    td{
        border:1px solid black;
        border-color: #000066;
        font-family: Century Gothic;
        font-size: 10px;
        color: #000099;
        width: auto;
    }
</style>
</head>
<body>
";
    if ($TitleEntered == 0)  {
        $MailBody           .="
        <table align='center' style='border-style: hidden;  border-color: transparent'>

            <tr style='border-style: hidden;  border-color: transparent' align='center'>
            <th>
                <p align='center'><font size='5'><u>".$_Title."</u></font> </p>
                <p align='center'><font size='3'>".$_SubTitle."</font> </p>
            </th>
            </tr>
        </table>
        <BR>
        <table width='100%'>
        <tr>
            <th >No</th>
            <th >Project Code</th>
            <th >Project Name</th>
			<th >Project Category</th>
            <th >Project Owner</th>
            <th >Task Code</th>
            <th >Task Name</th>
            <th >Task Owners</th>
			<th >Initiated By</th>
            <th >Task Status Updates</th>
            <th >Start Date</th>
            <th >End Date</th>
            <th >Project / Task Status</th>
            <th >% Completion</th>
            <th >Hrs Spent</th>
            <th >Hrs Remaining</th>
            <th >Attachments</th>
        </tr>
        ";
        $TitleEntered = 1;
    }
        /*$MailBody           .= "</br>
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
            " . $pro_ca ."
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
</table>";*/

$MailBody           .= "
    <tr>
        <td >".$_Count."</td>
        <td >".$_ProCode."</td>
        <td >".$_ProName."</td>
		<td >".$_pro_cat."</td>
        <td >".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectowner))."</td>
        <td >&nbsp</td>
        <td >&nbsp</td>
		<td >&nbsp</td>
		<td >".strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectInit))."</td>
        <td >&nbsp</td>		
        <td align='center'>".$_StartDate."</td>
        <td align='center'>".$_EndDate."</td>
        <td align='left'>".GetStatusDesc($str_dbconnect,$_TskStatus)."</td>  <!--updated from $_prostatus to $_TskStatus on 18/07/2013 -->
        <td align='center'>".getPrecentage($_TotHrsSpent,$_TotHrsEstimated,$_TotHrsApproved)."</td>
        <td align='center'>".$_TotHrsSpent."</td>
        <td align='center'>".getTimeDiffRemaining($_TotHrsSpent,$_TotHrsEstimated,$_TotHrsApproved)."</td>
        <td align='left'>";
        ?>
        <?php
        
            $_ResultSet      = get_projectuploadupdates($str_dbconnect,$_ProCode) ;
            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {                 
                $MailBody   .=  "<a href='../files/" . $_myrowRes['SystemName'] ."'>" .$_myrowRes['SystemName']."</a><br>";
            }
        $MailBody           .= "</td>
            </tr>
        ";


        $Sublelvelcount     = 0;
        $MaximumSubLevel    = 0;
        //******************** POINT TO CHECK EMPLOYEEEEEE ************************************
        $_ResultSet = get_TaskDetailsEmpPRINT($str_dbconnect,$_ProCode, $_EMPCode, $_TskStatus);
        while($_myrowRes = mysqli_fetch_array($_ResultSet))
        {
//
            if($_myrowRes['parent'] == 0){
    ?>
    <?php    $MailBody .= " <tr>
                    <td >&nbsp</td>
                    <td >&nbsp</td>
                    <td >&nbsp</td>
					 <td >&nbsp</td>
					<td >&nbsp</td>
                    <td >". $_myrowRes['taskcode'] ." </td>
                    <td >". $_myrowRes['taskname'] ." </td>
                    <td >"; ?>

                    <?php
                    $_TaskOwnerSet = getTASKTEAMEMPLOYEEDETAILS($str_dbconnect,$_myrowRes['taskcode'])   ;
                    while($_TaskOwnerRes = mysqli_fetch_array($_TaskOwnerSet)) {
                        $MailBody .= strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_TaskOwnerRes['EmpCode']))."</BR>";
                    }

                    $MailBody .= "</td>
					
					<td >&nbsp</td>
                    <td align='left'>";

                        $_TaskUpdateSet = getTaskStatusDetailsvsCategoryALL($str_dbconnect,$_myrowRes['taskcode'])    ;
                        while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                            $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- ".$_TaskUpdateRes['category']." On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                        }

                    $MailBody .= "</td>
                    <td  align='center'>". $_myrowRes['taskcrtdate'] ."</td>
					
                    <td  align='center'>". $_myrowRes['taskenddate'] ."</td>
                    <td  align='left'>". GetStatusDesc($str_dbconnect,$_myrowRes['taskstatus'])."</td>
                    <td  align='center'>".$_myrowRes['Precentage']."%"."</td>
                    <td align='center'>".getHoursSpent($str_dbconnect,$_myrowRes['taskcode'])."</td>
                    <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowRes['taskcode']),$_myrowRes['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowRes['taskcode']))."</td>                    
                    <td align='left'>";
                    ?>
                    <?php

                        $_ResultSet10      = get_projectuploadupdates($str_dbconnect,$_myrowRes['taskcode']) ;
                        while($_myrowRes10 = mysqli_fetch_array($_ResultSet10)) {       
                            $MailBody   .=  "<a href='../files/" . $_myrowRes10['SystemName'] ."'>" .$_myrowRes10['SystemName']."</a><br>";
                        }
                        $MailBody .= "</td>
                            </tr>
                        ";
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
                    <td >&nbsp</td>
                    <td >&nbsp</td>
                    <td >&nbsp</td>
			
                    <td >&nbsp</td>
			
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
                    <td align='left'>";

                        $_TaskUpdateSet = getTaskStatusDetailsvsCategoryALL($str_dbconnect,$_myrowsub['taskcode'])    ;
                        while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                            $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- ".$_TaskUpdateRes['category']." On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                        }

                    $MailBody .= "</td>
                    <td  align='center'>". $_myrowsub['taskcrtdate'] ."</td>
                    <td  align='center'>". $_myrowsub['taskenddate'] ."</td>
                    <td  align='left'>". GetStatusDesc($str_dbconnect,$_myrowsub['taskstatus'])."</td>
                    <td  align='center'>".$_myrowsub['Precentage']."%"."</td>
                    <td align='center'>".getHoursSpent($str_dbconnect,$_myrowsub['taskcode'])."</td>
                    <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowsub['taskcode']),$_myrowsub['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowsub['taskcode']))."</td>
                    <td align='left'>";
                    ?>
                    <?php

                        $_ResultSet10      = get_projectuploadupdates($str_dbconnect,$_myrowsub['taskcode']) ;
                        while($_myrowRes10 = mysqli_fetch_array($_ResultSet10)) {       
                            $MailBody   .=  "<a href='../files/" . $_myrowRes10['SystemName'] ."'>" .$_myrowRes10['SystemName']."</a><br>";
                        }
                        $MailBody .= "</td>
                            </tr>
                        ";
                    ?>                   
    <?php
                $_Resultsub1 = get_TaskDetailsParent($str_dbconnect,$_myrowsub['taskcode'], '3');
                while($_myrowsub1 = mysqli_fetch_array($_Resultsub1)){
    ?>
    <?php
                    $MailBody .= "<tr>
                        <td >&nbsp</td>
                        <td >&nbsp</td>
                        <td >&nbsp</td>
                        <td >&nbsp</td>
					   
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
                    <td align='left'>";

                        $_TaskUpdateSet = getTaskStatusDetailsvsCategoryALL($str_dbconnect,$_myrowsub1['taskcode'])    ;
                        while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                            $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- ".$_TaskUpdateRes['category']." On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                        }

                    $MailBody .= "</td>
                        <td align='center'>". $_myrowsub1['taskcrtdate'] ."</td>
                        <td align='center'>". $_myrowsub1['taskenddate'] ."</td>
                        <td align='left'>". GetStatusDesc($str_dbconnect,$_myrowsub1['taskstatus'])."</td>
                        <td align='center'>".$_myrowsub1['Precentage']."%"."</td>
                        <td align='center'>".getHoursSpent($str_dbconnect,$_myrowsub1['taskcode'])."</td>
                        <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowsub1['taskcode']),$_myrowsub1['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowsub1['taskcode']))."</td>
                        <td align='left'>";
                        ?>
                        <?php

                            $_ResultSet10      = get_projectuploadupdates($str_dbconnect,$_myrowsub1['taskcode']) ;
                            while($_myrowRes10 = mysqli_fetch_array($_ResultSet10)) {       
                                $MailBody   .=  "<a href='../files/" . $_myrowRes10['SystemName'] ."'>" .$_myrowRes10['SystemName']."</a><br>";
                            }
                            $MailBody .= "</td>
                                </tr>
                            ";
                        ?>                                    
                    
    <?php
                    $_Resultsub2 = get_TaskDetailsParent($str_dbconnect,$_myrowsub1['taskcode'], '4');
                    while($_myrowsub2 = mysqli_fetch_array($_Resultsub2)){
    ?>
    <?php
                        $MailBody .= "
                        <tr>
                            <td >&nbsp</td>
                            <td >&nbsp</td>
                            <td >&nbsp</td>
                            <td >&nbsp</td>
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
                            <td align='left'>";

                                $_TaskUpdateSet = getTaskStatusDetailsvsCategoryALL($str_dbconnect,$_myrowsub2['taskcode'])    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    $MailBody .= $_TaskUpdateRes['Note']." <font style='font-weight: bold;'>- ".$_TaskUpdateRes['category']." On : ".$_TaskUpdateRes['UpdateDate']."</font></BR>";
                                }

                            $MailBody .= "</td>
                            <td align='center'>". $_myrowsub2['taskcrtdate'] .".</td>
                            <td align='center'>". $_myrowsub2['taskenddate'] ."</td>
                            <td align='left'>". GetStatusDesc($str_dbconnect,$_myrowsub2['taskstatus'])."</td>
                            <td align='center'>".$_myrowsub2['Precentage']."%"."</td>
                            <td align='center'>".getHoursSpent($str_dbconnect,$_myrowsub2['taskcode'])."</td>
                            <td align='center'>".getTimeDiffRemaining(getHoursSpent($str_dbconnect,$_myrowsub2['taskcode']),$_myrowsub2['AllHours'],getaddlHrsApproved($str_dbconnect,$_myrowsub2['taskcode']))."</td>
                            <td align='left'>";
                            ?>
                            <?php

                                $_ResultSet10      = get_projectuploadupdates($str_dbconnect,$_myrowsub2['taskcode']) ;
                                while($_myrowRes10 = mysqli_fetch_array($_ResultSet10)) {       
                                    $MailBody   .=  "<a href='../files/" . $_myrowRes10['SystemName'] ."'>" .$_myrowRes10['SystemName']."</a><br>";
                                }
                                $MailBody .= "</td>
                                    </tr>
                                ";
                            ?>                                                          
                       
    <?php
                    }
                }
            }
            $Sublelvelcount ++ ;
        }

    ?>
    <?php
        $MailBody .= "<td colspan='17' bgcolor='#a9a9a9'>&nbsp</td>";
        }
    }
        $MailBody .= "
                    </table>
                    <br><br>
                    </body>
                    </html> " ;
    ?>
<?php
            /*
           if($MailBody != ""){

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
                $mailer->Body = $MailBody;
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
                *//*
                $mailer->AddAddress(getSELECTEDEMPLOYEEMAIL($str_dbconnect,$_EMPCode));  // This is where you put the email adress of the person you want to mail
                //$mailer->AddAddress('indikag@cisintl.com');
                //$mailer->AddCC('shameerap@cisintl.com');
                //$mailer->AddCC('chathurav@cisintl.com');
                $mailer->AddBCC('pms@cisintl.com');
                $mailer->AddBCC('indikag@cisintl.com');
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
           }*/

            echo $MailBody;
    /*}*/
?>