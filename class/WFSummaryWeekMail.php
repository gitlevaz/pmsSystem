<?php

	session_start();

    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database       //  connection file to the mysql database
    include ("sql_sysusers.php");          //  sql commands for the access controls
    include ("sql_project.php");           //  sql commands for the access controls
    include ("sql_task.php");              //  sql commands for the access controles
    include ("accesscontrole.php");        //  sql commands for the access controles
    include ("sql_empdetails.php");        //  connection file to the mysql database
    require_once("class.phpmailer.php");    //	
	require_once("class.SMTP.php");
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	
	function getGROUPNAMEDIV($str_dbconnect,$strGrpCode) {

		$Group	=	0;

		$_SelectQuery 	= 	"SELECT * FROM tbl_projectgroups WHERE GrpCode = '$strGrpCode'" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$Group	=	$_myrowRes["Group"];
		}

		return $Group ;

	}
	
	function getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$_EmpCode) {

        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        $_EmpName   =   "";

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName   =   $_myrowRes['FirstName']. " " .$_myrowRes['LastName'];
        }

        return $_EmpName ;

    }
	
	function ConvertMinutes2Hours($Minutes)
	{
	    if ($Minutes < 0)
	    {
	        $Min = Abs($Minutes);
	    }
	    else
	    {
	        $Min = $Minutes;
	    }
	    $iHours = Floor($Min / 60);
	    $Minutes = ($Min - ($iHours * 60)) / 100;
	    $tHours = $iHours + $Minutes;
	    if ($Minutes < 0)
	    {
	        $tHours = $tHours * (-1);
	    }
	    $aHours = explode(".", $tHours);
	    $iHours = $aHours[0];
	    if (empty($aHours[1]))
	    {
	        $aHours[1] = "00";
	    }
	    $Minutes = $aHours[1];
	    if (strlen($Minutes) < 2)
	    {
	        $Minutes = $Minutes ."0";
	    }
	    $tHours = $iHours .":". $Minutes;
	    return $tHours;
	}
	
	function getWFUPDATEMAILSUMMARY($str_dbconnect,Country, $Department){
        
        $HTML = "";
		
		$TotalMin_Allocated = 0;
		$TotalMin_Utilized1 = 0;$TotalMin_Utilized2 = 0;$TotalMin_Utilized3 = 0;$TotalMin_Utilized4 = 0;$TotalMin_Utilized5 = 0;$TotalMin_Utilized6 = 0;$TotalMin_Utilized7 = 0;
		
		$timezone = "Asia/Colombo";	
		
		//$Country = $_SESSION["LogCountry"];
			
		if($Country == "SL"){
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US"){
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI"){
			$timezone = "Asia/Bangkok";
		}	
		if($Country == "UK"){
		$timezone = "Europe/London";
		}	
	
		if($Country == "MLD"){
			$timezone = "Indian/Maldives";
		}
if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		if($Country == "FIJI"){
			$timezone = "Pacific/Fiji";	
		}
		date_default_timezone_set($timezone);
		$today_date  = date("Y-m-d");
        $prev_date  = date("Y-m-d",strtotime('-6 days'));		
		$day1 = date("l jS \of F Y",strtotime($prev_date));
		$day2 = date("l jS \of F Y",strtotime($prev_date."+1 day"));
		$day3 = date("l jS \of F Y",strtotime($prev_date."+2 day"));
		$day4 = date("l jS \of F Y",strtotime($prev_date."+3 day"));
		$day5 = date("l jS \of F Y",strtotime($prev_date."+4 day"));
		$day6 = date("l jS \of F Y",strtotime($prev_date."+5 day"));
		$day7 = date("l jS \of F Y",strtotime($prev_date."+6 day"));
		
		$day11 = date("l",strtotime($prev_date));
		$day22 = date("l",strtotime($prev_date."+1 day"));
		$day33 = date("l",strtotime($prev_date."+2 day"));
		$day44 = date("l",strtotime($prev_date."+3 day"));
		$day55 = date("l",strtotime($prev_date."+4 day"));
		$day66 = date("l",strtotime($prev_date."+5 day"));
		$day77 = date("l",strtotime($prev_date."+6 day"));
		//$today_date  = "2011-12-14";
        
        $_EmpName    =   "";
        $_DesCode    =   "";
		
		/*$_SelectQuery 	=   "SELECT * FROM tbl_projectgroups ORDER BY Country" or die(mysqli_error($str_dbconnect));
        $_DeptSet 		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
		
		$HTML .= "<html>";
        $HTML .= "<head>";
        $HTML .= "<style type=\"text/css\">
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
        </style>";
        
        $HTML .= "</head>";
        $HTML .= "<body>";
		$HTML .= "</br>";
		
		/*$HTML .= "<center><h1><b>Daily Work Flow : </b>".$today_date."</h1></center></br>";
        $HTML .= "<center><h2><b>W/F Usre : </b>".$_EmpName ."</h2></center></br>";
        $HTML .= "</br></br>" ;
		
		$HTML .= "</br>".$_DptRes['Country']. "-" . $_DptRes['GrpCode'] ."</br>" ;*/
		$HTML .= "<left>";
		$HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width=\"30%\" border=\"1px\">"; 			
			$HTML .= "<tr>";
				$HTML .= "<td style='background-color:#daffca' align='center'>";
					$HTML .= "COMPLETED";
				$HTML .= "</td>";
				$HTML .= "<td style='background-color:#ffcaca' align='center'>";
					$HTML .= "NOT COMPLETED";
				$HTML .= "</td>";
				$HTML .= "<td style='background-color:#cae8ff' align='center'>";
					$HTML .= "NOT APPLICABLE";
				$HTML .= "</td>";
			$HTML .= "</tr>";
		$HTML .= "</table>";
		$HTML .= "</left>";
		
		$HTML .= "</br></br>";
		/*width=\"100%\" style=\"background-color: #FFE7A1\"*/
        $HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width='1200px' border=\"1px\">";
		$HTML .= "</tbody>";
        /*$HTML .= "<thead>";
        $HTML .= "<tr>";            
			$HTML .= "<th rowspan='2'>#No</th>";        
	        $HTML .= "<th rowspan='2' width='300px'>Task Name</th>";
	        $HTML .= "<th rowspan='2'>Start Time</th>";
			$HTML .= "<th rowspan='2'>End Time</th>";
			$HTML .= "<th colspan='3'>Task Status</th>";
	        $HTML .= "<th rowspan='2'>Notes & Attachments</th>";                                                
        $HTML .= "</tr>";
		$HTML .= "<tr>";
			$HTML .= "<th rowspan='2'>Done</th>";
	        $HTML .= "<th rowspan='2'>In Complete</th>";
			$HTML .= "<th rowspan='2'>N/A</th>";
		$HTML .= "</tr>";
        $HTML .= "</thead>";
        $HTML .= "<tbody>";*/
		
			        
					$CYes1 	= 0;
					$CNo1	= 0;
			        $CNA1	= 0;
					$CYes2 	= 0;
					$CNo2	= 0;
			        $CNA2	= 0;
					$CYes3 	= 0;
					$CNo3	= 0;
			        $CNA3	= 0;
					$CYes4 	= 0;
					$CNo4	= 0;
			        $CNA4	= 0;
					$CYes5 	= 0;
					$CNo5	= 0;
			        $CNA5	= 0;
					$CYes6 	= 0;
					$CNo6	= 0;
			        $CNA6	= 0;
					$CYes7 	= 0;
					$CNo7	= 0;
			        $CNA7	= 0;
		
		$DepartmentN	= 	getGROUPNAMEDIV($str_dbconnect,$Department);
		
		$OLDCountry		=	"";
		$OLDDeprtment	=	"";
		$OLDEmployee	=	"";
		//".$Department."
		//$_SelectQuery 	=   "SELECT DISTINCT * FROM tbl_workflowupdate WHERE wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$Country."' AND `report_Dept` = 'DPT/4')AND `wk_owner`='$Employee'  AND `crt_date` between '".$prev_date."' AND '".$today_date."' GROUP BY `wk_id` ORDER BY `wk_owner`,`wk_id`" or die(mysqli_error($str_dbconnect));
		//$_SelectQuery 	=   "SELECT DISTINCT * FROM tbl_projectgroups where Country ='".$Country."'" or die(mysqli_error($str_dbconnect));
		
		$_SelectQuery 		=   "SELECT DISTINCT wk_owner FROM tbl_workflowupdate WHERE wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$Country."' AND `report_Dept` = '".$Department."') AND `crt_date` between '".$prev_date."' AND '".$today_date."' GROUP BY `wk_id` ORDER BY `wk_owner`" or die(mysqli_error($str_dbconnect));
        $_ResultSet		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
	    $num_rows 		= 	mysqli_num_rows($_ResultSet);
		
		$Lastupdate		=	"";
		
		if($num_rows != 0){
		   
	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {										
				$Employee = $_myrowRes['wk_owner'];				
				
				$EMPNAME = getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$Employee);				
				if(($OLDEmployee != $Employee && $OLDEmployee != "")){				
					
					$HTML .= "<tr>"; 
							$HTML .= "<td colspan='6'>";
								$HTML .= "<font color='Red' size='2'>Summary Total For Daily Task - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes1;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo1;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA1;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes2;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo2;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA2;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes3;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo3;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA3;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes4;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo4;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA4;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes5;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo5;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA5;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes6;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo6;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA6;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CYes7;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNo7;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= $CNA7;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
					$HTML .= "</tr>";
					
					$TotalTask1 = $CYes1 + $CNo1 + $CNA1;
					$TotalTask2 = $CYes2 + $CNo2 + $CNA2;
					$TotalTask3 = $CYes3 + $CNo3 + $CNA3;
					$TotalTask4 = $CYes4 + $CNo4 + $CNA4;
					$TotalTask5 = $CYes5 + $CNo5 + $CNA5;
					$TotalTask6 = $CYes6 + $CNo6 + $CNA6;
					$TotalTask7 = $CYes7 + $CNo7 + $CNA7;
					
					
					$HTML .= "<tr>"; 
							$HTML .= "<td colspan='6'>";
								$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio of - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes1 / $TotalTask1) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo1 / $TotalTask1) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA1 / $TotalTask1) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes2 / $TotalTask2) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo2 / $TotalTask2) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA2 / $TotalTask2) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes3 / $TotalTask3) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo3 / $TotalTask3) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA3 / $TotalTask3) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes4 / $TotalTask4) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo4 / $TotalTask4) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA4 / $TotalTask4) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes5 / $TotalTask5) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo5 / $TotalTask5) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA5 / $TotalTask5) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes6 / $TotalTask6) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo6 / $TotalTask6) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA6 / $TotalTask6) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CYes7 / $TotalTask7) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNo7 / $TotalTask7) * 100,0) ."%";
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= round(($CNA7 / $TotalTask7) * 100,0) ."%";;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= "";
							$HTML .= "</td>";
					$HTML .= "</tr>";	
					
					$HTML .= "<tr>"; 
						$HTML .= "<td colspan='9'>";
							$HTML .= "<font color='Red' size='2'>Total Time Allocated - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";						
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
					$HTML .= "</tr>";	
					
					$HTML .= "<tr>"; 
							$HTML .= "<td colspan='9'>";
								$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
							$HTML .= "</td>";						
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized1);
								$TotalMin_Utilized1 = 0;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized2);
								$TotalMin_Utilized2 = 0;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized3);
								$TotalMin_Utilized3 = 0;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized4);
								$TotalMin_Utilized4 = 0;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized5);
								$TotalMin_Utilized5 = 0;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized6);
								$TotalMin_Utilized6 = 0;
							$HTML .= "</td>";
							$HTML .= "<td align='center'>";
								$HTML .= ConvertMinutes2Hours($TotalMin_Utilized7);
								$TotalMin_Utilized7 = 0;
							$HTML .= "</td>";
					$HTML .= "</tr>";	
					$HTML .= "<tr>"; 
							
				$HTML .= "<td colspan='9' style='background-color:#daffca' align='center'>";
					$HTML .= "COMPLETED";
				$HTML .= "</td>";
				
					$HTML .= "</tr>";
					
						
					$Lastupdate	= "0";			
					
					$CYes1 	= 0;
					$CNo1	= 0;
			        $CNA1	= 0;
					$CYes2 	= 0;
					$CNo2	= 0;
			        $CNA2	= 0;
					$CYes3 	= 0;
					$CNo3	= 0;
			        $CNA3	= 0;
					$CYes4 	= 0;
					$CNo4	= 0;
			        $CNA4	= 0;
					$CYes5 	= 0;
					$CNo5	= 0;
			        $CNA5	= 0;
					$CYes6 	= 0;
					$CNo6	= 0;
			        $CNA6	= 0;
					$CYes7 	= 0;
					$CNo7	= 0;
			        $CNA7	= 0;
						
					
					$Lastupdate	=	"1";
					//echo "OLD EMPLOYEE : ".$OLDEmployee."</br>";
					//echo "Employee EMPLOYEE : ".$Employee."</br>";
				}	
				
				
				if(($OLDCountry != $Country || $OLDCountry == "") || ($OLDDeprtment != $Department || $OLDDeprtment == "") || ($OLDEmployee != $Employee || $OLDEmployee == "")){
					
					/*$HTML .= "<tr>";
						$HTML .= "<td colspan='8'>";
							//$HTML .= "<font color='Red' size='2'>Divsion : ".$Country. " | Department : ".$DepartmentN . " | Employee : ".$EMPNAME."</font>" ;
							$HTML .= "&nbsp;";
						$HTML .= "</td>";	
					$HTML .= "</tr>";*/
					
					$HTML .= "</tbody>";
					$HTML .= "</table>";
					$HTML .= "</br></br>";
					$HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" width='3000px' border=\"1px\">";					
					$HTML .= "<thead style=\"border-bottom:1px\" style=\"border-bottom-color:#000000\">";
			        $HTML .= "<tr>";            
						$HTML .= "<th rowspan='3'>#No</th>";        
				        $HTML .= "<th rowspan='3' width='300px'>Task Name</th>";
				        $HTML .= "<th rowspan='3'>Schedule Time</th>";
						$HTML .= "<th rowspan='3'>Time Allocated</th>";
						$HTML .= "<th colspan='6'>".$day1."</th>";
						$HTML .= "<th colspan='6'>".$day2."</th>";
						$HTML .= "<th colspan='6'>".$day3."</th>";
						$HTML .= "<th colspan='6'>".$day4."</th>";
						$HTML .= "<th colspan='6'>".$day5."</th>"; 
						$HTML .= "<th colspan='6'>".$day6."</th>";
						$HTML .= "<th colspan='6'>".$day7."</th>";                                           
			        $HTML .= "</tr>";
					$HTML .= "<tr border=\"1px\">";
						$HTML .= "<th rowspan='3'>Actual Hrs Spent</th>"; 
						$HTML .= "<th rowspan='3'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='3'>Notes & Attachments</th>"; 
						$HTML .= "<th rowspan='3'>Actual Hrs Spent</th>"; 
						$HTML .= "<th rowspan='3'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='3'>Notes & Attachments</th>";
						$HTML .= "<th rowspan='3'>Actual Hrs Spent</th>"; 
						$HTML .= "<th rowspan='3'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='3'>Notes & Attachments</th>";
						$HTML .= "<th rowspan='3'>Actual Hrs Spent</th>"; 
						$HTML .= "<th rowspan='3'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='3'>Notes & Attachments</th>";
						$HTML .= "<th rowspan='3'>Actual Hrs Spent</th>"; 
						$HTML .= "<th rowspan='3'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='3'>Notes & Attachments</th>";
						$HTML .= "<th rowspan='3'>Actual Hrs Spent</th>"; 
						$HTML .= "<th rowspan='3'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='3'>Notes & Attachments</th>";
						$HTML .= "<th rowspan='3'>Actual Hrs Spent</th>"; 
						$HTML .= "<th rowspan='3'>Time Spent</th>";
						$HTML .= "<th colspan='3'>Task Status</th>";
				        $HTML .= "<th rowspan='3'>Notes & Attachments</th>"; 
					$HTML .= "</tr>";
					$HTML .= "<tr>";
						$HTML .= "<th rowspan='3'>Done</th>";
				        $HTML .= "<th rowspan='3'>In Complete</th>";
						$HTML .= "<th rowspan='3'>N/A</th>";
						$HTML .= "<th rowspan='3'>Done</th>";
				        $HTML .= "<th rowspan='3'>In Complete</th>";
						$HTML .= "<th rowspan='3'>N/A</th>";
						$HTML .= "<th rowspan='3'>Done</th>";
				        $HTML .= "<th rowspan='3'>In Complete</th>";
						$HTML .= "<th rowspan='3'>N/A</th>";
						$HTML .= "<th rowspan='3'>Done</th>";
				        $HTML .= "<th rowspan='3'>In Complete</th>";
						$HTML .= "<th rowspan='3'>N/A</th>";
						$HTML .= "<th rowspan='3'>Done</th>";
				        $HTML .= "<th rowspan='3'>In Complete</th>";
						$HTML .= "<th rowspan='3'>N/A</th>";
						$HTML .= "<th rowspan='3'>Done</th>";
				        $HTML .= "<th rowspan='3'>In Complete</th>";
						$HTML .= "<th rowspan='3'>N/A</th>";
						$HTML .= "<th rowspan='3'>Done</th>";
				        $HTML .= "<th rowspan='3'>In Complete</th>";
						$HTML .= "<th rowspan='3'>N/A</th>";
					$HTML .= "</tr>";
					$HTML .= "</thead>";
				    $HTML .= "<tbody>";
					
					$HTML .= "<tr>";
						$HTML .= "<td colspan='46' style=\"background-color: #FFE7A1\">";
							$HTML .= "<font color='Red' size='2'>Divsion : ".$Country. " | Department : ".$DepartmentN . " | Employee : ".$EMPNAME."</font>" ;
						$HTML .= "</td>";	
					$HTML .= "</tr>";
					
					$RowCount = 1;
				}	
								
					
				$OLDCountry 	= $Country;
				$OLDDeprtment 	= $Department;
				
				$_SelectQuery 	=   "SELECT DISTINCT * FROM tbl_workflowupdate WHERE wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$Country."' AND `report_Dept` = '".$Department."')AND `wk_owner`='".$Employee."'  AND `crt_date` between '".$prev_date."' AND '".$today_date."' GROUP BY `wk_name` ORDER BY `wk_owner`,`wk_id`" or die(mysqli_error($str_dbconnect));
				 $_ResultSet		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
				 
				while ($_myrowRes = mysqli_fetch_array($_ResultSet)){
				
					$workflowid = $_myrowRes['wk_id'];	
					$workflowname12 = $_myrowRes['wk_name'];			
					$BGCOLOR = "";
					
				//	if($_myrowRes['status'] == "Yes"){
//						$BGCOLOR = "#daffca";
//					}else if ($_myrowRes['status'] == "No"){
//						$BGCOLOR = "#ffcaca";	
//					}else{
//						$BGCOLOR = "#cae8ff";
//					}				
				//style='background-color:".$BGCOLOR."'
					$HTML .= "<tr >"; 
						$HTML .= "<td>";
							$HTML .= $RowCount ;
						$HTML .= "</td>";
						$RowCount = $RowCount + 1;
						$HTML .= "<td>";						
							$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
							$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $_myrowRes['start_time']."-".$_myrowRes['end_time'];
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$hours = 0;
							$minutes = 0;
							
							$datetime1 = new DateTime($_myrowRes['start_time']);
							$datetime2 = new DateTime($_myrowRes['end_time']);
							
							$interval = $datetime1->diff($datetime2);
							
							$hours   = $interval->format('%h');
							$minutes = $interval->format('%i');				
							
							$HTML .= $hours .":". $minutes;
							
							$TotalMin_Allocated = $TotalMin_Allocated + (($hours * 60) + $minutes );						
						$HTML .= "</td>";
						
													 
				 $today_date = date("Y-m-d");
						$_SelectQuery1 	=   "SELECT DISTINCT t.schedule,t.sched_time,w.* FROM tbl_workflow t JOIN tbl_workflowupdate w ON t.wk_id=w.wk_id WHERE w.wk_Owner='".$Employee."' and w.wk_name LIKE '%".$workflowname12."%' AND w.crt_date between '".$prev_date."' AND '".$today_date."' GROUP BY t.wk_id  ORDER BY w.crt_date,t.wk_id" or die(mysqli_error($str_dbconnect));
				 $_ResultSet1		=   mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
				 $yes1=0;$yes2=0;$yes3=0;$yes4=0;$yes5=0;$yes6=0;$yes7=0;
				 $no1=0;$no2=0;$no3=0;$no4=0;$no5=0;$no6=0;$no7=0;
				 $na1=0;$na2=0;$na3=0;$na4=0;$na5=0;$na6=0;$na7=0;
				 $totwk1=0;$totwk2=0;$totwk3=0;$totwk4=0;$totwk5=0;$totwk6=0;$totwk7=0;
				 $prtot1=0;$prtot2=0;$prtot3=0;$prtot4=0;$prtot5=0;$prtot6=0;$prtot7=0;
				 $TotalMin_Utilized[0]=0;$TotalMin_Utilized[1]=0;$TotalMin_Utilized[2]=0;$TotalMin_Utilized[3]=0;$TotalMin_Utilized[4]=0;$TotalMin_Utilized[5]=0;$TotalMin_Utilized[6]=0;
				 $CYes[0]=0; $CYes[1]=0; $CYes[2]=0; $CYes[3]=0; $CYes[4]=0; $CYes[5]=0; $CYes[6]=0;
				 $CNo[0]=0;$CNo[1]=0;$CNo[2]=0;$CNo[3]=0;$CNo[4]=0;$CNo[5]=0;$CNo[6]=0;
				 $CNA[0]=0;$CNA[1]=0;$CNA[2]=0;$CNA[3]=0;$CNA[4]=0;$CNA[5]=0;$CNA[6]=0;
				 $yes[0]=0; $yes[1]=0; $yes[2]=0; $yes[3]=0; $yes[4]=0; $yes[5]=0; $yes[6]=0;
				 $no[0]=0;$no[1]=0;$no[2]=0;$no[3]=0;$no[4]=0;$no[5]=0;$no[6]=0;
				 $na[0]=0;$na[1]=0;$na[2]=0;$na[3]=0;$na[4]=0;$na[5]=0;$na[6]=0;
				
				while ($_myrowRes = mysqli_fetch_array($_ResultSet1)){					
						$workid 	= $_myrowRes['wk_id'];	
						$wname		= $_myrowRes['wk_name'];					
					for($i=0;$i<7;$i++){	
						$sched 	= "";
						$schedtime  = "";
						$sttime		= "";			
						$timetaken	= "";	
						$crtdate	= "";	
						$status	    = "";		
						$workupdate = "";					
							$today_date = date("Y-m-d");
        					$prev_date  = date("Y-m-d",strtotime('-6 days'));		
							$preday=  date("Y-m-d",strtotime($prev_date."".$i." day"));							
							$_SelectQuery1 	=   "SELECT DISTINCT t.schedule,t.sched_time,w.* FROM tbl_workflow t JOIN tbl_workflowupdate w ON t.wk_id=w.wk_id WHERE  w.wk_name LIKE '%".$wname."%' AND w.crt_date ='".$preday."' GROUP BY t.wk_id  ORDER BY w.crt_date,t.wk_id" or die(mysqli_error($str_dbconnect));
							$_ResultSet1		=   mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
				 			$row = mysqli_fetch_array($_ResultSet1); 
							$num_results = mysqli_num_rows($_ResultSet1); 
							if ($num_results > 0){
								while ($_myrowRes = mysqli_fetch_array($_ResultSet1)){									
									$sched 		= $_myrowRes['schedule'];
									$schedtime  = $_myrowRes['sched_time'];
									$sttime		= $_myrowRes['start_time'];			
									$timetaken	= $_myrowRes['TimeTaken'];	
									$crtdate	= $_myrowRes['crt_date'];	
									$status	    = $_myrowRes['status'];		
									$workupdate = $_myrowRes['wk_update'];	
								}
								if($status == "Yes"){
									$BGCOLOR = "#daffca";
									$yes[$i]=$yes[$i]+1;
								}else if ($status == "No"){
									$BGCOLOR = "#ffcaca";$no[$i]=$no[$i]+1;	
								}else{
									$BGCOLOR = "#cae8ff";$na[$i]=$na[$i]+1;
								}
								$HTML .= "<td align='center' style='background-color:".$BGCOLOR."'>";
								$HTML .= $sttime." - ".$timetaken;
								$HTML .= "</td>";
								$HTML .= "<td align='center' style='background-color:".$BGCOLOR."'>";
								$hours = 0;
								$minutes = 0;
								$datetime1 = new DateTime($sttime);
								$datetime2 = new DateTime($timetaken);
								
								$interval = $datetime1->diff($datetime2);
								
								$hours   = $interval->format('%h');
								$minutes = $interval->format('%i');				
								
								$HTML .= $hours .":". $minutes;
								
										$TotalMin_Utilized[$i] = $TotalMin_Utilized[$i] + (($hours * 60) + $minutes );
								$HTML .= "</td>";
								if($status == "Yes"){
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";
										$CYes[$i] 	= $CYes[$i] + 1;
										$HTML .= $status;
									$HTML .= "</td>";
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";						
									$HTML .= "</td>";	
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";						
									$HTML .= "</td>";
								}else if($status == "No"){
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";						
									$HTML .= "</td>";
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";
										$CNo[$i]	= $CNo[$i] + 1;
										$HTML .=$status;						
									$HTML .= "</td>";	
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";						
									$HTML .= "</td>";
								}else{
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";						
									$HTML .= "</td>";
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";						
									$HTML .= "</td>";	
									$HTML .= "<td style='background-color:".$BGCOLOR."'>";
										$HTML .= $status;	
										$CNA[$i]	= $CNA[$i] + 1;					
									$HTML .= "</td>";
								}
								$HTML .= "<td style='background-color:".$BGCOLOR."'>";
									$HTML .= $workupdate. "</br>";
									$WorkFlowid = $workid;
									$_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
									$_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));				
									$num_rows = mysqli_num_rows($_ResultSetq);
									if($num_rows > 0){                            
										while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
											$HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
										}                                                    
									}else{
										//$HTML .= "There are no Attachments to Download";
									}						
								$HTML .= "</td>";								
							}else {
								
								$HTML .= "<td align='center' style='background-color:\"#ffffff\"'>";
								$HTML .= "</td>";
								$HTML .= "<td align='center' style='background-color:\"#ffffff\"'>";
								$HTML .= "</td>";								
								$HTML .= "<td style='background-color:\"#ffffff\"'>";
								$HTML .= "</td>";
								$HTML .= "<td style='background-color:\"#ffffff\"'>";						
								$HTML .= "</td>";	
								$HTML .= "<td style='background-color:\"#ffffff\"'>";						
								$HTML .= "</td>";								
								$HTML .= "<td style='background-color:\"#ffffff\"'>";						
								$HTML .= "</td>";				
							}
							$TotalMin_Utilized1= $TotalMin_Utilized1+$TotalMin_Utilized[0];$TotalMin_Utilized2= $TotalMin_Utilized2+$TotalMin_Utilized[1];	$TotalMin_Utilized3= $TotalMin_Utilized3+$TotalMin_Utilized[2];	$TotalMin_Utilized4= $TotalMin_Utilized4+$TotalMin_Utilized[3];	$TotalMin_Utilized5= $TotalMin_Utilized5+$TotalMin_Utilized[4];	$TotalMin_Utilized6= $TotalMin_Utilized6+$TotalMin_Utilized[5];	$TotalMin_Utilized7= $TotalMin_Utilized7+$TotalMin_Utilized[6];	
							$CYes1= $CYes1+$CYes[0];$CYes2= $CYes2+$CYes[1];$CYes3= $CYes3+$CYes[2];$CYes4= $CYes4+$CYes[3];$CYes5= $CYes5+$CYes[4];$CYes6=$CYes6+$CYes[5];$CYes7=$CYes7+$CYes[6];
							$CNo1= $CNo1+$CNo[0];$CNo2=$CNo2+$CNo[1];$CNo3= $CNo3+$CNo[2];$CNo4= $CNo4+$CNo[3];$CNo5= $CNo5+$CNo[4];$CNo6=$CNo6+$CNo[5];$CNo7=$CNo7+$CNo[6];	
							$CNA1= $CNA1+$CNA[0];$CNA2=$CNA2+$CNA[1];$CNA3=$CNA3+$CNA[2];$CNA4=$CNA4+$CNA[3];$CNA5= $CNA5+$CNA[4];$CNA6=$CNA6+$CNA[5];$CNA7=$CNA7+$CNA[6];		
							$yes1= $yes1+$yes[0];$yes2=$yes2+$yes[1];$yes3=$yes3+$yes[2];$yes4=$yes4+$yes[3];$yes5= $yes5+$yes[4];$yes6=$yes6+$yes[5];$yes7=$yes7+$yes[6];	
							$no1= $no1+$no[0];$no2=$no2+$no[1];$no3=$no3+$no[2];$no4=$no4+$no[3];$no5= $no5+$no[4];$no6=$no6+$no[5];$no7=$no7+$no[6];	
							$na1= $na1+$na[0];$na2=$na2+$na[1];$na3=$na3+$na[2];$na4=$na4+$na[3];$na5=$na5+$na[4];$na6=$na6+$na[5];$na7=$na7+$na[6];							
						}
						$HTML .= "</tr>";						
				}										
			}// end of workflow id while
				$OLDEmployee 	= $Employee;
				$totwk1= $yes1+$no1+$na1;$totwk2= $yes2+$no2+$na2;$totwk3= $yes3+$no3+$na3;$totwk4= $yes4+$no4+$na4;$totwk5= $yes5+$no5+$na5;$totwk6= $yes6+$no6+$na6; $totwk7= $yes7+$no7+$na7;
				$prtot1=round(($yes1/$totwk1) * 100,0) ."%";$prtot2=round(($yes2/$totwk2) * 100,0) ."%";$prtot3=round(($yes3/$totwk3) * 100,0) ."%";$prtot4=round(($yes4/$totwk4) * 100,0) ."%";$prtot5=round(($yes5/$totwk5) * 100,0) ."%";$prtot6=round(($yes6/$totwk6) * 100,0) ."%";$prtot7=round(($yes7/$totwk7) * 100,0) ."%";
	        }
			if($CYes1 != 0 || $CNo1 != 0 || $CNA1 != 0 || $CYes2 != 0 || $CNo2 != 0 || $CNA2 != 0 || $CYes3 != 0 || $CNo3 != 0 || $CNA3 != 0 || $CYes4 != 0 || $CNo4 != 0 || $CNA4 != 0 || $CYes5 != 0 || $CNo5 != 0 || $CNA5 != 0 || $CYes6 != 0 || $CNo6 != 0 || $CNA6 != 0 || $CYes7 != 0 || $CNo7 != 0 || $CNA7 != 0){
				
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='6'>";
							$HTML .= "<font color='Red' size='2'>Summary Total For Daily Task - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes1;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo1;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA1;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes2;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo2;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA2;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes3;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo3;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA3;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes4;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo4;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA4;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes5;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo5;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA5;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes6;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo6;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA6;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CYes7;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNo7;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= $CNA7;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
				$HTML .= "</tr>";	
				
				$TotalTask1 = $CYes1 + $CNo1 + $CNA1;
				$TotalTask2 = $CYes2 + $CNo2 + $CNA2;
				$TotalTask3 = $CYes3 + $CNo3 + $CNA3;
				$TotalTask4 = $CYes4 + $CNo4 + $CNA4;
				$TotalTask5 = $CYes5 + $CNo5 + $CNA5;
				$TotalTask6 = $CYes6 + $CNo6 + $CNA6;
				$TotalTask7 = $CYes7 + $CNo7 + $CNA7;
				
					
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='6'>";
							$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio of - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes1 / $TotalTask1) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo1 / $TotalTask1) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA1 / $TotalTask1) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes2 / $TotalTask2) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo2 / $TotalTask2) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA2 / $TotalTask2) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes3 / $TotalTask3) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo3 / $TotalTask3) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA3 / $TotalTask3) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes4 / $TotalTask4) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo4 / $TotalTask4) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA4 / $TotalTask4) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes5 / $TotalTask5) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo5 / $TotalTask5) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA5 / $TotalTask5) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes6 / $TotalTask6) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo6 / $TotalTask6) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA6 / $TotalTask6) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
						
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "<td>";
						$HTML .= "</td>";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CYes7 / $TotalTask7) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNo7 / $TotalTask7) * 100,0) ."%";
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= round(($CNA7 / $TotalTask7) * 100,0) ."%";;
						$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= "";
						$HTML .= "</td>";
				$HTML .= "</tr>";	
				
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='9'>";
							$HTML .= "<font color='Red' size='2'>Total Time Allocated - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";						
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
							$TotalMin_Allocated = 0;
						$HTML .= "</td>";
				$HTML .= "</tr>";	
				
				$HTML .= "<tr>"; 
						$HTML .= "<td colspan='9'>";
							$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F - ".getSELECTEDEMPLOYEFIRSTNAMEWF($str_dbconnect,$OLDEmployee)."</font>";
						$HTML .= "</td>";						
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized1);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized2);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized3);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized4);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized5);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized6);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
						
						$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";$HTML .= "<td>";						$HTML .= "</td>";$HTML .= "<td>";$HTML .= "</td>";
						$HTML .= "<td align='center'>";
							$HTML .= ConvertMinutes2Hours($TotalMin_Utilized7);
							$TotalMin_Utilized = 0;
						$HTML .= "</td>";
				$HTML .= "</tr>";								
			}// end of while Employee
					          
	        $HTML .= "</tbody>";
	        $HTML .= "</table>";  
	        $HTML .= "</body>";
	        $HTML .= "</html>";  
        }else{
			$HTML = "";	
		}
        return $HTML ;
		
    }
	
	$ProcessCountry = $_GET["Country"];
	
	$_SelectQuery 	=   "SELECT * FROM tbl_projectgroups WHERE Country = '$ProcessCountry'" or die(mysqli_error($str_dbconnect));
    $_DeptSet 		=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	$timezone = "Asia/Colombo";	
		
	$Country = $ProcessCountry;
		
	if($Country == "SL"){
		$timezone = "Asia/Colombo";	
	}
	
	if($Country == "US"){
		$timezone = "America/Los_Angeles";
	}
	
	if($Country == "TI"){
		$timezone = "Asia/Bangkok";
	}	

	if($Country == "UK"){
		$timezone = "Europe/London";
	}	
	
	if($Country == "MLD"){
		$timezone = "Indian/Maldives";
	}	
if($Country == "CN"){
			$timezone = "Asia/Hong_Kong";
		}
		if($Country == "AU"){
			$timezone = "Australia/Melbourne";	
		}
		if($Country == "FIJI"){
			$timezone = "Pacific/Fiji";	
		}
	date_default_timezone_set($timezone);
	
	$today_date  	= 	date("m-d-Y");
	//$today_date  = "2011-12-14";
	while($_DptRes = mysqli_fetch_array($_DeptSet)) {		
	
		// $mailer = new PHPMailer();
	    // $mailer->IsSMTP();
	    // $mailer->Host = '10.9.0.166:25';					//$mailer->Host = 'ssl://smtp.gmail.com:465';
	    // $mailer->SetLanguage("en", 'class/');								//$mailer->SetLanguage("en", '');
	    // $mailer->SMTPAuth = TRUE;
	    // $mailer->IsHTML = TRUE;
		// $mailer->Username = 'pms@eTeKnowledge.com';  // Change this to your gmail adress      $mailer->Username = 'info@tropicalfishofasia.com';
	    // $mailer->Password = 'pms@321';  					// Change this to your gmail password           $mailer->Password = 'info321';
	    // $mailer->From = 'pms@eTeKnowledge.com';  // This HAVE TO be your gmail adress            $mailer->From = 'info@tropicalfishofasia.com';	   
	    // $mailer->FromName = 'WORKFLOW'; // This is the from name in the email, you can put anything you like here	
		
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
				$mailer->SetFrom('pms@eteknowledge.com','WORKFLOW');
				$mail->CharSet = "text/html; charset=UTF-8;";
								
				//O365 Email Function END
		
		$HTML = getWFUPDATEMAILSUMMARY($str_dbconnect,_DptRes['Country'], $_DptRes['GrpCode']);  
		echo $HTML;
		//$WKOwner = Get_Supervior($str_dbconnect,$LogUserCode);
		
	    //$mailer->Body = $HTML;
		$mailer->Body =str_replace('"','\'',$HTML);
		  
	    $mailer->Subject = "Weekly W/F SUMMARY AS OF ".$today_date." DIV. -".$_DptRes['Country']." / DEPT. - ".getGROUPNAMEDIV($str_dbconnect,$_DptRes['GrpCode']);
	    
		$today_date  	= 	date("Y-m-d");
		//$mailer->AddAddress('thilina.dtr@gmail.com'); 
	//	$mailer->AddAddress('shameerap@cisintl.com');  // This is where you put the email adress of the person you want to mail
	    $mailer->AddBCC('pms@cisintl.com');
	    $mailer->AddBCC('ishankap@eteknowledge.com');
	  //  $mailer->AddCC('indikag@cisintl.com');
	//	$mailer->AddCC('piumit@cisintl.com');
	//	$mailer->AddCC('dilinif@cisintl.com');
	//	$mailer->AddCC('GermanH@Etropicalfish.com');		
	//	$mailer->AddCC('admin@cisintl.com');
	//	$mailer->AddCC('nilukab@cisintl.com');
	
		//$MailAddressDpt = "";
			
		//$DepartmentMails = getMailUSERFACILITIES($str_dbconnect,$_DptRes['GrpCode']);
       // while($_MailRes = mysqli_fetch_array($DepartmentMails)) {
         //   $EmpDpt =    $_MailRes['EmpCode'];
         //   $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

        //    $mailer->AddAddress($MailAddressDpt);  // This is where you put the email adress of the person you want to mail
			
      //  }
		
		$_SelectQuery 		=   "SELECT DISTINCT wk_owner FROM tbl_workflowupdate WHERE `crt_date` = '".$today_date."' AND 
								wk_id in (SELECT wk_id FROM tbl_workflow WHERE `report_div` = '".$_DptRes['Country']."' AND `report_Dept` = '".$_DptRes['GrpCode']."') ORDER BY `wk_owner`" or die(mysqli_error($str_dbconnect));
        $DepartmentMails	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
		//while($_MailRes = mysqli_fetch_array($DepartmentMails)) {
        //    $EmpDpt =    $_MailRes['wk_owner'];
        //    $MailAddressDpt = getSELECTEDEMPLOYEEMAIL($str_dbconnect,$EmpDpt);

         //   $mailer->AddCC($MailAddressDpt);  // This is where you put the email adress of the person you want to mail
			
       // }
		
		//if($HTML != ""){		
//		    if(!$mailer->Send())
//		    {
//		       echo "Message was not sent<br/ >";
//		       echo "Mailer Error: " . $mailer->ErrorInfo;
//		    }
//		    else
//		    {
//		       echo "Message has been sent";
//		    }
//		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>.: PMS :. | WorkFlow Weekly Summary Mail</title>
</head>
<body>
	<?php /*echo "Test";*/ ?>
	<input type="text" style="background-color"/>
    <?php ?>
</body>
</html>