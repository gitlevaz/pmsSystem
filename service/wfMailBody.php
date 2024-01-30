	<?php 
  $connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
	include ("../class/accesscontrole.php");
	include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database     
    $LogUserCode = $_GET["EmpCode"];
	$Country = $_GET["Country"];
	$timezone = "Asia/Colombo";	
	$_Query = ""; 
	 $array = array();
	
	 mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	 function getCoveringPerson($str_dbconnect,$wk_id) {
		
		$covring='';
		$_SelectQuery 	= 	"SELECT * FROM `tbl_wfcoveringperson` WHERE `FacCode`='$wk_id'" or die(mysqli_error($link));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($link));

		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			$covring	=	$_myrowRes["UserName"]." , ".$covring;
		}

		return $covring ;
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
	
		if($Country == "SL")
		{
			$timezone = "Asia/Colombo";	
		}
		
		if($Country == "US")
		{
			$timezone = "America/Los_Angeles";
		}
		
		if($Country == "TI")
		{
			$timezone = "Asia/Bangkok";
		}		

	date_default_timezone_set($timezone);
	
	$HTML = "";
    $today_date  = date("Y-m-d");
	
    $_EmpName    =   "";
    $_DesCode    =   "";
        
	$_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$LogUserCode'";

    $_ResultSet 	=   mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));

    $_MailAdd   =   "";

        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            $_EmpName    =   $_myrowRes['FirstName']. " " . $_myrowRes['LastName'];
            $_DesCode    =   $_myrowRes['DesCode'];
        }
		
	$TotalMin_Allocated = 0;
	$TotalMin_Utilized = 0;
        
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
        
        $HTML .= "<center><h1><b>Daily Work Flow : </b>".$today_date."</h1></center></br>";
        $HTML .= "<center><h2><b>W/F User : </b>".$_EmpName ."</h2></center></br>";
        $HTML .= "</br></br>" ;
		
		$HTML .= "<left>";
		$HTML .= "<table cellpadding=\"0px\" cellspacing=\"0\" border=\"1px\">"; 			
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
       
		$HTML .= "</br>" ;
		
        $HTML .= "<table cellpadding=\"5px\" cellspacing=\"0\" width=\"1200px\" border=\"1px\">";
        $HTML .= "<thead>";
        $HTML .= "<tr>";                    
	        $HTML .= "<th rowspan='2' width='500px'>Task Name</th>";
	        $HTML .= "<th rowspan='2' width='100px'>Scheduled Time</th>";
			$HTML .= "<th rowspan='2' width='100px'>Time Allocated</th>";
			$HTML .= "<th rowspan='2' width='100px'>Actual Task Completion Time</th>";	
			$HTML .= "<th rowspan='2' width='100px'>Time Spent</th>";
			$HTML .= "<th colspan='3'>Task Status</th>";
			$HTML .= "<th rowspan='2'>Notes & Attachments</th>";       
			$HTML .= "<th rowspan='2'>Covering Person</th>";                                           
        $HTML .= "</tr>";
		$HTML .= "<tr>";
			$HTML .= "<th rowspan='2'>Done</th>";
	        $HTML .= "<th rowspan='2'>In Complete</th>";
			$HTML .= "<th rowspan='2'>N/A</th>";
		$HTML .= "</tr>";
        $HTML .= "</thead>";
        $HTML .= "<tbody>";
        
		$CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0;
		
			$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='10' align='center' style='font-size:+16px'><b>"." Daily W/F Tasks"."</b></td>";		        
			$HTML .= "</tr>";
			
			$_UserTypeID ="WK";	
			
            $_Query = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like '$_UserTypeID%' order by `start_time`";
			
            $_ResultSet1 	=  mysqli_query($link,$_Query) or die(mysqli_error($link));	
            $Result1 = mysqli_num_rows($_ResultSet1);
						
	        while ($_myrowRes = mysqli_fetch_assoc($_ResultSet1)) 
			{
				
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
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
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    $_ResultSetq 	=   mysqli_query($link,$_SelectQueryq) or die(mysqli_error($link));	
	
	                    $num_rows = mysqli_num_rows($_ResultSetq );
						
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_assoc($_ResultSetq)) 
							{                
	                            $HTML .= "<a href='https://pms.tkse.lk/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";
					
					$HTML .= "<td>";
					$HTML .= getCoveringPerson($str_dbconnect,$_myrowRes['wk_id']);
					$HTML .= "</td>";
				$HTML .= "</tr>";			
				
	        } 
		 
				
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
					
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
			
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
				
			$HTML .= "</td>";
			$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";
		
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
			$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
		$HTML .= "</tr>";
		/* $CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0;	 */
		$HTML .= "<tr height='16px'>";	
		$HTML .= "</tr>";
		$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='10' align='center' style='font-size:+16px'><b>"."W/F Tasks of Staff Report"."</b></td>";	
					        
			$HTML .= "</tr>";
			
			$_UserTypeID ="EMP";
                    
            $_Query = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like '$_UserTypeID%' order by `start_time`";
			
            $_ResultSet 	=  mysqli_query($link,$_Query) or die(mysqli_error($link));	
            $Result1 = mysqli_num_rows($_ResultSet);
			
	     
			
	        while ($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
			{
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
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
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
						
	                    $_ResultSetq 	=   mysqli_query($link,$_SelectQueryq) or die(mysqli_error($link));	
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_assoc($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";

				$HTML .= "</tr>";			
				
	        }			
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
				$HTML .= "";
			$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
					
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
				$HTML .= "";
			$HTML .= "</td>";
		$HTML .= "</tr>";
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
			$HTML .= "</td>";
			$HTML .= "<td>";
			$HTML .= "";
		$HTML .= "</td>";
		$HTML .= "</tr>";
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
			$HTML .= "<td>";
			$HTML .= "";
		$HTML .= "</td>";
		$HTML .= "</tr>";
		/* $CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0; */
		$HTML .= "<tr height='16px'>";	
		$HTML .= "</tr>";
		$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='10' align='center' style='font-size:+16px'><b>"."W/F Tasks to Revisit"."</b></td>";		        
			$HTML .= "</tr>";
			
			$_UserTypeID ="RE";			
	        
			$_Query = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like '$_UserTypeID%' order by `start_time`";
			
            $_ResultSet 	=  mysqli_query($link,$_Query) or die(mysqli_error($link));	
            $Result1 = mysqli_num_rows($_ResultSet);
			
	     
			
	        while ($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
			{
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
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
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    
	                    $_ResultSetq 	=   mysqli_query($link,$_SelectQueryq) or die(mysqli_error($link));
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0)
						{                            
	                        while($_myrowResq = mysqli_fetch_assoc($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";
					$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "</tr>";			
				
	        }			
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
				$HTML .= "";
			$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
					
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
				$HTML .= "";
			$HTML .= "</td>";
		$HTML .= "</tr>";
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
			$HTML .= "</td>";
			$HTML .= "<td>";
			$HTML .= "";
		$HTML .= "</td>";
		$HTML .= "</tr>";
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
			$HTML .= "<td>";
			$HTML .= "";
		$HTML .= "</td>";
		$HTML .= "</tr>";
		/* $CYes 	= 0;
		$CNo	= 0;
        $CNA	= 0;
		
		$TimeSpent = 0;
		$TimeAprox = 0; */	
		$HTML .= "<tr height='16px'>";	
		$HTML .= "</tr>";
		$HTML .= "<tr style='background-color:#ffc000'>";
				$HTML .= "<td colspan='10' align='center' style='font-size:+16px'><b>"."Non Scheduled Tasks for the Day"."</b></td>";		        
			$HTML .= "</tr>";
			
			$_UserTypeID ="CWK";			
	       
		   $_Query = "SELECT * FROM tbl_workflowupdate WHERE `crt_date` = '$today_date' AND `wk_owner` = '$LogUserCode' AND `wk_id` like '$_UserTypeID%' order by `start_time`";
			
            $_ResultSet 	=  mysqli_query($link,$_Query) or die(mysqli_error($link));	
            $Result1 = mysqli_num_rows($_ResultSet);
			
	     
			
	        while ($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
			{
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>"; 
					$HTML .= "<td>";					
						$HTML .= "<b>[".$_myrowRes['wk_id']. "] - " . $_myrowRes['wk_name'] . "</b><br/><br/>";                                                    
						$HTML .="<font color='#383d7d'><b>Description : </b><i>". $_myrowRes['Wf_Desc']."</i></font>";
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['start_time']." - ".$_myrowRes['end_time'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px' align='center'>";
					
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
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['StartTime']." - ".$_myrowRes['TimeTaken'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
					
						$hours = 0;
						$minutes = 0;
						$datetime1 = new DateTime($_myrowRes['StartTime']);
						$datetime2 = new DateTime($_myrowRes['TimeTaken']);
						
						$interval = $datetime1->diff($datetime2);
						
						$hours   = $interval->format('%h');
						$minutes = $interval->format('%i');				
						
						$HTML .= $hours .":". $minutes;
						
						$TotalMin_Utilized = $TotalMin_Utilized + (($hours * 60) + $minutes );
					$HTML .= "</td>";			
					
					if($_myrowRes['status'] == "Yes"){
						$HTML .= "<td>";
							$CYes 	= $CYes + 1;
							$HTML .= $_myrowRes['status'];
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else if($_myrowRes['status'] == "No"){
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";
							$CNo	= $CNo + 1;
							$HTML .= $_myrowRes['status'];						
						$HTML .= "</td>";	
						$HTML .= "<td>";						
						$HTML .= "</td>";
					}else{
						$HTML .= "<td>";						
						$HTML .= "</td>";
						$HTML .= "<td>";						
						$HTML .= "</td>";	
						$HTML .= "<td>";
							$HTML .= $_myrowRes['status'];	
							$CNA	= $CNA + 1;					
						$HTML .= "</td>";
					}
					$HTML .= "<td>";
						$HTML .= $_myrowRes['wk_update']. "</br>";
						$WorkFlowid = $_myrowRes['wk_id'];
	                    $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	                    
						$_ResultSetq 	=   mysqli_query($link,$_SelectQueryq) or die(mysqli_error($link));
	
	                    $num_rows = mysqli_num_rows($_ResultSetq);
	                    if($num_rows > 0){                            
	                        while($_myrowResq = mysqli_fetch_assoc($_ResultSetq)) {                
	                            $HTML .= "<a href='http://74.205.57.65:86/PMS/workflow/files/".$_myrowResq['SystemName']."'>".$_myrowResq['FileName']."</a> |";                           
	                        }                                                    
	                    }else{
	                        $HTML .= "&nbsp;";
	                    }
					$HTML .= "</td>";
					$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "</tr>";			
				
	        }			
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<b><font color='Red' size='2'><h5>Summary Total For Daily Task</b></font></h5>";
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CYes;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNo;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= $CNA;
				$HTML .= "</td>";
				$HTML .= "<td>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
				$HTML .= "";
			$HTML .= "</td>";
		$HTML .= "</tr>";	
		
		$TotalTask = $CYes + $CNo + $CNA;
					
		$HTML .= "<tr>"; 
				$HTML .= "<td colspan='5'>";
					$HTML .= "<font color='Red' size='2'>Daily Task Completed Ratio </font>";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CYes / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNo / $TotalTask) * 100,0) ."%";
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= round(($CNA / $TotalTask) * 100,0) ."%";;
				$HTML .= "</td>";
				$HTML .= "<td align='center'>";
					$HTML .= "";
				$HTML .= "</td>";
				$HTML .= "<td>";
				$HTML .= "";
			$HTML .= "</td>";
		$HTML .= "</tr>";
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Time Allocated</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Allocated);
			$HTML .= "</td>";
			$HTML .= "<td>";
			$HTML .= "";
		$HTML .= "</td>";
		$HTML .= "</tr>";
		$TotalTimeCal = $TimeAprox + $TimeSpent;
		$HTML .= "<tr>"; 
			$HTML .= "<td colspan='8'>";
				$HTML .= "<font color='Red' size='2'>Total Hours Spent to Complete W/F</font>";
			$HTML .= "</td>";				
			$HTML .= "<td align='center'>";
				$HTML .= ConvertMinutes2Hours($TotalMin_Utilized);
			$HTML .= "</td>";
			$HTML .= "<td>";
			$HTML .= "";
		$HTML .= "</td>";
		$HTML .= "</tr>";			    			              
        $HTML .= "</tbody>";
        $HTML .= "</table>";  
        $HTML .= "</body>";
        $HTML .= "</html>";  
        
       // echo $HTML ;
 //array_push($array, $HTML);
 //echo json_encode($array);
 $array = "[{";
	$array =$array.'"MailBody":"'  . str_replace('"',"'" ,$HTML).'"}]';
	echo $array;
			
			
	?>