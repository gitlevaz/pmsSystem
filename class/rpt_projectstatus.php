<link rel="stylesheet" href="../css/textstyles.css" type="text/css" />
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
    //include ("../class/accesscontrole.php");        //  sql commands for the access controles
    include ("../class/sql_empdetails.php");        //  connection file to the mysql database
    include ("../class/class.phpmailer.php");       //  connection file to the mysql database
    //include ("../class/MailBodyOne.php");           //  connection file to the mysql database
    //include ("../class/sql_crtprocat.php");    //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

    function getGROUPNAMECAT($str_dbconnect,$strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}
    //  TAKING PROJECT DETAILS
    if(isset($_GET["ProCode"])) {

        $_ProCode       =   $_GET["ProCode"];
        $_ProName       =   "";
        $_StartDate     =   "";
        $_crtusercode   =   "";
        $_crtdate       =   "";
        $_EndDate       =   "";
        $_prostatus     =   "";
        $_projectowner  =   "";
        $_projectInit   =   "";

        $_DepartCode    = "";
        $_Department    = "";
        $_Division      = "";
        $_Title         = "";

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
            $_DepartCode    =   $_myrowRes['Department'];
            $_Division      =   $_myrowRes['Division'];
        }
    }

    $_Department = getGROUPNAMECAT($str_dbconnect,$_DepartCode);

    $Dte_today          = 	date("Y/m/d") ;

    date_default_timezone_set('Asia/Colombo');
    $Dte_Time           = 	date("h:i:s a", time()) ;

    $_PrintBy           =	$_SESSION["LogUserCode"];

    $_Title =   " - PROJECT STATUS REPORT : ".strtoupper($_Division)."/".strtoupper($_Department)." as at ".$Dte_today." : ".$Dte_Time." - ";

    $_TotHrsSpent       =   getTotalProjectHoursSpent($str_dbconnect,$_ProCode);
    $_TotHrsEstimated   =   getTotalProjectEstimatedHours($str_dbconnect,$_ProCode);
    $_TotHrsApproved    =   getTotalProjectaddlHrsApproved($str_dbconnect,$_ProCode);
 ?>

<html>
<head>
<title>.:: PROJECT STATUS REPORT ::.</title>
<style type="text/css">
    .Tableinner {
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
    }
    table{
        border-collapse:collapse;
        background-color: #e9eff2;
    }
    table, td, th{
        border:1px solid black;
        border-color: #000066;
    }
</style>

     <script type='text/javascript' charset='utf-8'>

        function getHours( Startdate, EndDate ){
            //alert(Startdate + " - " +  EndDate);
            t1	= Startdate ;
            t2	= EndDate ;

            var one_day=1000*60*60*24;
            //Here we need to split the inputed dates to convert them into standard format for furter execution

            var x = t1.split("-");
            var y = t2.split("-");
            //alert(x + "-" + y);
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

    function roundNumber(num, dec) {
        var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
        return result;
    }

    function getPrecentage( timeA,timeB,timeC){
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
        //alert(H1 + "-" + M1);
        H1 = H1 * 60;
        M1 = M1 + H1;
        //alert(H2 + "-" + M2);
        H2 = H2 * 60;
        M2 = M2 + H2;

        var Precentage = 0;

        Precentage = ((M1 / M2) * 100);

        var answertime = roundNumber(Precentage,'2') + " %";

        return answertime;
    }

    </script>
</head>
<body>

<table width='3260' class='Tableinner'  align='center' style='border-style: hidden;  border-color: transparent' >

    <tr style='border-style: hidden;  border-color: transparent' align='center' class='TableHeading'>
        <th>
            <p align='center'> <?php echo $_Title; ?> </p>
        </th>
    </tr>
</table>
</br>
<table width='3260' class='Tableinner'  align='center' style='border-style: hidden;  border-color: transparent'>
    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'> Project Code </font>
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            <?php echo $_ProCode; ?>
        </td>
    </tr>
    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'> Project Name </font>
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            <?php echo $_ProName; ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'> Create Date </font>
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            <?php echo $_crtdate; ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'> Create By </font>
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            <?php echo strtoupper(getSELECTEDSYSUSERNAME($str_dbconnect,$_crtusercode)); ?>
        </td>
    </tr>

     <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Owner</font>
        </td>
        <td width='10' align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  width='1000' align='left' style='border-style: hidden;  border-color: transparent'>
            <?php echo strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectowner)); ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Initiated By</font>
        </td>
        <td width='10' align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  width='1000' align='left' style='border-style: hidden;  border-color: transparent'>
            <?php echo strtoupper(getSELECTEDEMPLOYENAME($str_dbconnect,$_projectInit)); ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'> Project Start Date </font>
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td style='border-style: hidden;  border-color: transparent'>
            <?php echo $_StartDate; ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Deadline</font>
        </td>
        <td width='10' align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  width='1000' align='left' style='border-style: hidden;  border-color: transparent'>
            <?php echo $_EndDate; ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Project Completion %</font>
        </td>
        <td width='10' align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  width='1000' align='left' style='border-style: hidden;  border-color: transparent'>
            <?php
                echo "<SCRIPT LANGUAGE='javascript'> document.write(getPrecentage('".$_TotHrsSpent."','".$_TotHrsEstimated."','".$_TotHrsApproved."'));</SCRIPT>";
             ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Total Hrs Spent</font>
        </td>
        <td width='10' align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  width='1000' align='left' style='border-style: hidden;  border-color: transparent'>
            <?php echo $_TotHrsSpent; ?>
        </td>
    </tr>

    <tr style='border-style: hidden;  border-color: transparent'>
        <td width='200' align='left' style='border-style: hidden;  border-color: transparent'>
            <font style='font-weight: bold;'>Total Hrs Remaining</font>
        </td>
        <td width='10' align='left' style='border-style: hidden;  border-color: transparent'>
            :
        </td>
        <td  width='1000' align='left' style='border-style: hidden;  border-color: transparent'>
             <?php
                echo "<SCRIPT LANGUAGE='javascript'> document.write(getTimeDiffRemaining('".$_TotHrsSpent."','".$_TotHrsEstimated."','".$_TotHrsApproved."'));</SCRIPT>";
             ?>
        </td>
    </tr>
    
</table>
</br>
<table width='3260' class='Tableinner'>
    <tr>
        <th rowspan="2"width='80'>Task Code</th>
        <th rowspan="2" width='400'>Milestones / Sub-Projects</th>
        <th rowspan="2" width='100'>Task Owner</th>
        <th rowspan="2" width='80'>Date Started</th>
        <th rowspan="2" width='80'>Due Date</th>
        <th rowspan="2" width='80' align='center'>Percentage Completed</th>
        <th rowspan="2" width='600'>Stage Summary</th>
        <th rowspan="2" width='600'>Impediments</th>
        <th rowspan="2" width='600'>Pending Approvals</th>
        <th rowspan="2" width='100'>Amount Required</th>
        <th rowspan="2" width='100'>Amount Paid</th>
        <th rowspan="2" width='100'>Balance</th>
        <th rowspan="1" colspan="5" align='center'>Hours Summary</th>
    </tr>
    <tr>
        <th width='80'>Hrs Estimated @ Start</th>
        <th width='80'>Addl Hrs Requested</th>
        <th width='80'>Addl hrs approved</th>
        <th width='80'>Total Hrs  Spent</th>
        <th width='80'>Total hrs remaning</th>
        <th width='80'>Attachments</th>
    </tr>

    <?php

        $Sublelvelcount     = '0';
        $MaximumSubLevel    = '0';

        $_ResultSet = get_TaskDetails($str_dbconnect,$_SESSION['ProjectCode']);
        while($_myrowRes = mysqli_fetch_array($_ResultSet))
        {
//
            if($_myrowRes['parent'] == '0'){
    ?>
                <tr>
                    <td width='80'><?php echo $_myrowRes['taskcode']; ?></td>
                    <td width='400'><?php echo $_myrowRes['taskname'] ; ?></td>
                    <td width='100'><?php echo strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowRes['assignuser'])); ?></td>
                    <td width='80' align='center'><?php echo $_myrowRes['taskcrtdate'] ; ?></td>
                    <td width='80' align='center'><?php echo $_myrowRes['taskenddate'] ; ?></td>
                    <td width='80' align='center'><?php echo $_myrowRes['Precentage']."%" ; ?></td>
                    <td width='600'>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowRes['taskcode'], 'Task Started')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowRes['taskcode'], 'Task Update')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                        ?>
                    </td>
                    <td width='600'>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowRes['taskcode'], 'Impediment')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                        ?>
                    </td>
                    <td width='600'>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowRes['taskcode'], 'Approval')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                        ?>
                    </td>
                    <td width='100' align='right'>0.00</td>
                    <td width='100' align='right'>0.00</td>
                    <td width='100' align='right'>0.00</td>
                    <td width='80' align='center'><?php echo $_myrowRes['AllHours'] ; ?></td>
                    <td width='80' align='center'><?php echo getaddlHrsRequest($str_dbconnect,$_myrowRes['taskcode']) ; ?></td>
                    <td width='80' align='center'><?php echo getaddlHrsApproved($str_dbconnect,$_myrowRes['taskcode']) ; ?></td>
                    <td width='80' align='center'><?php echo getHoursSpent($str_dbconnect,$_myrowRes['taskcode']) ; ?></td>
                    <td width='80' align='center'>
                        <?php
                            echo "<SCRIPT LANGUAGE='javascript'> document.write(getTimeDiffRemaining('".getHoursSpent($str_dbconnect,$_myrowRes['taskcode'])."','".$_myrowRes['AllHours']."','".getaddlHrsApproved($str_dbconnect,$_myrowRes['taskcode'])."'));</SCRIPT>";
                         ?>
                    </td>
                </tr>
    <?php
            }
    ?>
    <?php
            $_Resultsub = get_TaskDetailsParent($str_dbconnect,$_myrowRes['taskcode'], '2');
            while($_myrowsub = mysqli_fetch_array($_Resultsub)){
    ?>
                <tr>
                    <td><?php echo $_myrowsub['taskcode']; ?></td>
                    <td style='padding-left: 20'><?php echo $_myrowsub['taskname'] ; ?></td>
                    <td width='100'><?php echo strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowsub['assignuser'])); ?></td>
                    <td width='80' align='center'><?php echo $_myrowsub['taskcrtdate'] ; ?></td>
                    <td width='80' align='center'><?php echo $_myrowsub['taskenddate'] ; ?></td>
                    <td width='80' align='center'><?php echo $_myrowsub['Precentage']."%" ; ?></td>
                    <td width='600'>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub['taskcode'], 'Task Started')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub['taskcode'], 'Task Update')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                        ?>
                    </td>
                    <td width='600'>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub['taskcode'], 'Impediment')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                        ?>
                    </td>
                    <td width='600'>
                        <?php
                            $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub['taskcode'], 'Approval')    ;
                            while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                            }
                        ?>
                    </td>
                    <td width='100' align='right'>0.00</td>
                    <td width='100' align='right'>0.00</td>
                    <td width='100' align='right'>0.00</td>
                    <td width='80' align='center'><?php echo $_myrowsub['AllHours'] ; ?></td>
                    <td width='80' align='center'><?php echo getaddlHrsRequest($str_dbconnect,$_myrowsub['taskcode']) ; ?></td>
                    <td width='80' align='center'><?php echo getaddlHrsApproved($str_dbconnect,$_myrowsub['taskcode']) ; ?></td>
                    <td width='80' align='center'><?php echo getHoursSpent($str_dbconnect,$_myrowsub['taskcode']) ; ?></td>
                    <td width='80' align='center'>
                        <?php
                            echo "<SCRIPT LANGUAGE='javascript'> document.write(getTimeDiffRemaining('".getHoursSpent($str_dbconnect,$_myrowsub['taskcode'])."','".$_myrowsub['AllHours']."','".getaddlHrsApproved($str_dbconnect,$_myrowsub['taskcode'])."'));</SCRIPT>";
                         ?>
                    </td>
                    <td>
                        <?php
                            $ItemCount = 0;
                            $_ResultSet      = get_projectupload($str_dbconnect,$_myrowsub['taskcode']) ;
                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                $ItemCount += 1;
                            //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                        ?>
                           <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>
                        <?php }
                            if($ItemCount == 0) {
                                echo "* No Documents Attached"  ;
                            }
                        ?>
                           
                       <?php
                            $_ResultSet      = get_projectuploadupdates($str_dbconnect,$_myrowsub['taskcode']) ;
                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                        ?>
                                    <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>

                        <?php } ?>
                    </td>
                </tr>
    <?php
                $_Resultsub1 = get_TaskDetailsParent($str_dbconnect,$_myrowsub['taskcode'], '3');
                while($_myrowsub1 = mysqli_fetch_array($_Resultsub1)){
    ?>
                    <tr>
                        <td><?php echo $_myrowsub1['taskcode']; ?></td>
                        <td style='padding-left: 40'><?php echo $_myrowsub1['taskname'] ; ?></td>
                        <td width='100'><?php echo strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowsub1['assignuser'])); ?></td>
                        <td width='80' align='center'><?php echo $_myrowsub1['taskcrtdate'] ; ?></td>
                        <td width='80' align='center'><?php echo $_myrowsub1['taskenddate'] ; ?></td>
                        <td width='80' align='center'><?php echo $_myrowsub1['Precentage']."%" ; ?></td>
                        <td width='600'>
                            <?php
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Task Started')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                }
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Task Update')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                }
                            ?>
                        </td>
                        <td width='600'>
                            <?php
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Impediment')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                }
                            ?>
                        </td>
                        <td width='600'>
                            <?php
                                $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub1['taskcode'], 'Approval')    ;
                                while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                    echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                }
                            ?>
                        </td>
                        <td width='100' align='right'>0.00</td>
                        <td width='100' align='right'>0.00</td>
                        <td width='100' align='right'>0.00</td>
                        <td width='80' align='center'><?php echo $_myrowsub1['AllHours'] ; ?></td>
                        <td width='80' align='center'><?php echo getaddlHrsRequest($str_dbconnect,$_myrowsub1['taskcode']) ; ?></td>
                        <td width='80' align='center'><?php echo getaddlHrsApproved($str_dbconnect,$_myrowsub1['taskcode']) ; ?></td>
                        <td width='80' align='center'><?php echo getHoursSpent($str_dbconnect,$_myrowsub1['taskcode']) ; ?></td>
                        <td width='80' align='center'>
                        <?php
                            echo "<SCRIPT LANGUAGE='javascript'> document.write(getTimeDiffRemaining('".getHoursSpent($str_dbconnect,$_myrowsub1['taskcode'])."','".$_myrowsub1['AllHours']."','".getaddlHrsApproved($str_dbconnect,$_myrowsub1['taskcode'])."'));</SCRIPT>";
                         ?>
                        </td>
                        <td>
                            <?php
                                $ItemCount = 0;
                                $_ResultSet      = get_projectupload($str_dbconnect,$_myrowsub1['taskcode']) ;
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                    $ItemCount += 1;
                                //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                            ?>
                               <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>
                            <?php }
                                if($ItemCount == 0) {
                                    echo "* No Documents Attached"  ;
                                }
                            ?>

                           <?php
                                $_ResultSet      = get_projectuploadupdates($str_dbconnect,$_myrowsub1['taskcode']) ;
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                            ?>
                                        <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>

                            <?php } ?>
                        </td>
                    </tr>
    <?php
                    $_Resultsub2 = get_TaskDetailsParent($str_dbconnect,$_myrowsub1['taskcode'], '4');
                    while($_myrowsub2 = mysqli_fetch_array($_Resultsub2)){
    ?>
                        <tr>
                            <td><?php echo $_myrowsub2['taskcode']; ?></td>
                            <td style='padding-left: 60'><?php echo $_myrowsub2['taskname'] ; ?></td>
                            <td width='100'><?php echo strtoupper(getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowsub2['assignuser'])); ?></td>
                            <td width='80' align='center'><?php echo $_myrowsub2['taskcrtdate'] ; ?></td>
                            <td width='80' align='center'><?php echo $_myrowsub2['taskenddate'] ; ?></td>
                            <td width='80' align='center'><?php echo $_myrowsub2['Precentage']."%" ; ?></td>
                            <td width='600'>
                                <?php
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Task Started')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                    }
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Task Update')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                    }
                                ?>
                            </td>
                            <td width='600'>
                                <?php
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Impediment')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                    }
                                ?>
                            </td>
                            <td width='600'>
                                <?php
                                    $_TaskUpdateSet = getTaskStatusDetailsvsCategory($str_dbconnect,$_myrowsub2['taskcode'], 'Approval')    ;
                                    while($_TaskUpdateRes = mysqli_fetch_array($_TaskUpdateSet)) {
                                        echo $_TaskUpdateRes['Note'].' <font style=\'font-weight: bold;\'>- Updated On : '.$_TaskUpdateRes['UpdateDate'].'</font></BR>';
                                    }
                                ?>
                            </td>
                            <td width='100' align='right'>0.00</td>
                            <td width='100' align='right'>0.00</td>
                            <td width='100' align='right'>0.00</td>
                            <td width='80' align='center'><?php echo $_myrowsub2['AllHours'] ; ?></td>
                            <td width='80' align='center'><?php echo getaddlHrsRequest($str_dbconnect,$_myrowsub2['taskcode']) ; ?></td>
                            <td width='80' align='center'><?php echo getaddlHrsApproved($str_dbconnect,$_myrowsub2['taskcode']) ; ?></td>
                            <td width='80' align='center'><?php echo getHoursSpent($str_dbconnect,$_myrowsub2['taskcode']) ; ?></td>
                            <td width='80' align='center'>
                            <?php
                                echo "<SCRIPT LANGUAGE='javascript'> document.write(getTimeDiffRemaining('".getHoursSpent($str_dbconnect,$_myrowsub2['taskcode'])."','".$_myrowsub2['AllHours']."','".getaddlHrsApproved($str_dbconnect,$_myrowsub2['taskcode'])."'));</SCRIPT>";
                             ?>
                            </td>
                            <td>
                                <?php
                                    $ItemCount = 0;
                                    $_ResultSet      = get_projectupload($str_dbconnect,$_myrowsub2['taskcode']) ;
                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                        $ItemCount += 1;
                                    //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                                ?>
                                   <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>
                                <?php }
                                    if($ItemCount == 0) {
                                        echo "* No Documents Attached"  ;
                                    }
                                ?>

                               <?php
                                    $_ResultSet      = get_projectuploadupdates($str_dbconnect,$_myrowsub2['taskcode']) ;
                                    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                    //echo "<option value='".$_myrowRes['SystemName']."' ondblclick='Download(dsfsdf)'>".$_myrowRes['SystemName']."</option>";
                                ?>
                                            <a href="files/<?php echo $_myrowRes['SystemName'] ; ?>"><?php echo $_myrowRes['SystemName'] ; ?></a><br>

                                <?php } ?>
                            </td>
                        </tr>
    <?php
                    }
                }
            }
            $Sublelvelcount ++ ;
        }
    ?>

</table>
</body>
</html>
 
