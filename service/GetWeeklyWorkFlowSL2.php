<?php
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
set_time_limit(1200);
$hasData = false;
//$showThursday_date = "11/03/2016";
//$showFriday_date = "10/28/2016";
$showThursday_date = date("m-d-Y", strtotime("previous thursday"));
$showFriday_date = date("m-d-Y", strtotime("-6 day", strtotime("previous thursday")));
$current_month_no = date("n");
$dueNo = 0;
$compNo = 0;
$compPrstg = 0;
$incompPrstg = 0;
$totDueNo = 0;
$totCompNo = 0;
$totCompPrstg = 0;
$totIncompPrstg = 0;

        $HTML = "";
        $HTML = "";
		$HTML = "";
        $HTML .= "<html>";
        $HTML .= "<head>";
        $HTML .= "</head>";
        $HTML .= "<body>";		
		$HTML .= "<h3 align=\"center\" style=\"font-family:calibri;\">SL-Workflow: Weekly status of workflow from $showFriday_date to $showThursday_date</h3>";
		$HTML .= "<p style=\"font-family:calibri;\"><b>Workflow Completion Status By Workflow Owner</b></p>";
		$HTML .= "<table border=\"1\" style=\"font-family:calibri;font-size:12px;white-space:nowrap\" width=\"500px;\"> <tr bgcolor='#62b1ff'> ";
		$HTML .= "<th align=\"center\" style=\"width:150px;\">Workflow Owner</th>";
		$HTML .= "<th align=\"center\" style=\"width:150px;\">No of Workflows Assigned</th>";
		$HTML .= "<th align=\"center\" style=\"width:150px;\">No of Workflows Completed</th>";
		$HTML .= "<th align=\"center\" style=\"width:150px;\">Workflow Completion %</th>";
		$HTML .= "<th align=\"center\" style=\"width:150px;\">Workflow Incompletion %</th>";
		$HTML .= "</tr>";
		
        $departmentSql = "SELECT `GrpCode`, `Group` FROM `tbl_projectgroups` WHERE Country = 'SL' ORDER BY `Group` ASC";
        $departmentResult = mysqli_query($link, $departmentSql) or die(mysqli_error($link));
		
		while($departmentRow = mysqli_fetch_assoc($departmentResult)) {
			$thCountDept = 1;
			$deptStr = "";
			$deptCode = "";
			
			$ownerSql = "SELECT emp.FirstName, emp.LastName, emp.EmpCode
			             FROM tbl_workflow wrk
                         INNER JOIN tbl_employee emp ON wrk.wk_Owner = emp.EmpCode
                         AND emp.Division = 'SL'
                         AND emp.DeptCode = '" . $departmentRow['GrpCode'] . "'
                         UNION 
                         SELECT emp.FirstName, emp.LastName, emp.EmpCode
                         FROM tbl_workflow wrk
                         INNER JOIN tbl_employee emp ON wrk.wk_Owner = emp.EmpCode
                         AND emp.Division = 'SL'
                         AND emp.DeptCode = '" . $departmentRow['GrpCode'] . "'
                         ORDER BY FirstName, LastName";
            $ownerResult = mysqli_query($link, $ownerSql) or die(mysqli_error($link));
			
			if(mysqli_num_rows($ownerResult) > 0)
			{
				$deptStr = $departmentRow['Group'];
				$deptCode = $departmentRow['GrpCode'];
			}
			
			while($ownerRow = mysqli_fetch_assoc($ownerResult)) {
				$ownDueNo = 0;
				$ownCompNo = 0;
 			    
				//$thursday_date  = new DateTime("2017-02-23");
                //$friday_date = new DateTime("2017-02-17");

				$thursday_date  = new DateTime(date("Y-m-d", strtotime("previous thursday")));
                $friday_date = new DateTime(date("Y-m-d", strtotime("-6 day", strtotime("previous thursday"))));
				
				for($i = $friday_date; $friday_date <= $thursday_date; $i->modify("+1 day"))
				{
					$day = $i->format("l");
					$today_date = $i->format("Y-m-d");
					$month_no = $i->format("n");
					$year_no = $i->format("Y");
					
					$currentMonthDueNo = 0;
					$currentMonthCompNo = 0;
					$previousMonthDueNo = 0;
					$previousMonthCompNo = 0;
					
				    $dueSql = "SELECT COUNT(*) AS dueNo FROM (
				           SELECT wrk.wk_id
				           FROM tbl_workflow wrk
				           WHERE wrk.sched_time = '" . $day . "'
				           AND wrk.wk_Owner = '" . $ownerRow['EmpCode'] . "'
				           UNION
				           SELECT wrk.wk_id
				           FROM tbl_workflow wrk
				           WHERE wrk.schedule = 'Daily'
				           AND wrk.wk_Owner = '" . $ownerRow['EmpCode'] . "'
				           ) x";
						   
				    $dueResult = mysqli_query($link, $dueSql) or die(mysqli_error($link,));
					$dueNo = mysqli_fetch_assoc($dueResult);
					
				    $compSql = "SELECT COUNT(*) AS compNo FROM (
				            SELECT upd.wk_id
				            FROM tbl_workflow wrk
						    INNER JOIN tbl_workflowupdate upd ON wrk.wk_id = upd.wk_id
				            WHERE wrk.sched_time = '" . $day . "'
				            AND upd.wk_Owner = '" . $ownerRow['EmpCode'] . "'
						    AND upd.crt_date = '" . $today_date . "'
							AND ( upd.status = 'Yes' OR upd.status = 'N/A')
				            UNION
				            SELECT upd.wk_id
				            FROM tbl_workflow wrk
						    INNER JOIN tbl_workflowupdate upd ON wrk.wk_id = upd.wk_id
				            WHERE wrk.schedule = 'Daily'
				            AND upd.wk_Owner = '" . $ownerRow['EmpCode'] . "'
						    AND upd.crt_date = '" . $today_date . "'
							AND ( upd.status = 'Yes' OR upd.status = 'N/A')
				            ) x";
							
				    $compResult = mysqli_query($link, $compSql) or die(mysqli_error($link,));
					$compNo = mysqli_fetch_assoc($compResult);
					
					if($dueNo['dueNo']!=0)
					{
						if($dueNo['dueNo'] > 0)
						{
							$dueNo['dueNo'] = 1;
						}
						else
						{
							$dueNo['dueNo'] = 0;			
						}
					
						if($compNo['compNo'] > 0)
						{
							$compNo['compNo'] = 1;
						}
						else
						{
							$compNo['compNo'] = 0;
						}
					
						$ownDueNo += $dueNo['dueNo'];					
						$ownCompNo += $compNo['compNo'];
						
						if($month_no==$current_month_no)
					    {
							$currentMonthDueNo += $dueNo['dueNo'];
							$currentMonthCompNo += $compNo['compNo'];
							
							$sqlSelect = "SELECT COUNT(*) AS selectCount FROM tbl_wfmonth 
						              WHERE FirstName='" . $ownerRow['FirstName'] . "'
									  AND LastName='" . $ownerRow['LastName'] . "'
									  AND Division='" . $deptCode . "'
									  AND MonthNo='" . $month_no . "'
									  AND YearNo='" . $year_no . "'";
									  
						    $sqlSelectResult = mysqli_query($link, $sqlSelect) or die(mysqli_error($link,));
							$selectCount = mysqli_fetch_assoc($sqlSelectResult);
							
							if($selectCount['selectCount'] == 0)
							{
								$sqlInsert = "INSERT INTO tbl_wfmonth (FirstName, LastName, Division, DueNo, CompletedNo, MonthNo, YearNo) VALUES
								             ('" . $ownerRow['FirstName'] . "', '" . $ownerRow['LastName'] . "', '" . $deptCode . "', '"
											 . $currentMonthDueNo . "', '" . $currentMonthCompNo . "', '" . $month_no . "', '" . $year_no . "' )";
								mysqli_query($link, $sqlInsert) or die(mysqli_error($link,));
							}
							else
							{
								$sqlSelectDue = "SELECT DueNo FROM tbl_wfmonth
						                     WHERE FirstName='" . $ownerRow['FirstName'] . "'
									         AND LastName='" . $ownerRow['LastName'] . "'
									         AND Division='" . $deptCode . "'
									         AND MonthNo='" . $month_no . "'
									         AND YearNo='" . $year_no . "'";
							
								$sqlSelectDueResult = mysqli_query($link, $sqlSelectDue) or die(mysqli_error($link,));
								$dueNoCount = mysqli_fetch_assoc($sqlSelectDueResult);
								$currentMonthDueNo += $dueNoCount['DueNo'];

								$sqlSelectComp = "SELECT CompletedNo FROM tbl_wfmonth
						                     WHERE FirstName='" . $ownerRow['FirstName'] . "'
									         AND LastName='" . $ownerRow['LastName'] . "'
									         AND Division='" . $deptCode . "'
									         AND MonthNo='" . $month_no . "'
									         AND YearNo='" . $year_no . "'";
										 
								$sqlSelectCompResult = mysqli_query($link, $sqlSelectComp) or die(mysqli_error($link,));
								$compNoCount = mysqli_fetch_assoc($sqlSelectCompResult);
								$currentMonthCompNo += $compNoCount['CompletedNo'];

								$sqlUpdate = "UPDATE tbl_wfmonth SET DueNo='" . $currentMonthDueNo . "' , CompletedNo='" . $currentMonthCompNo . "'
						                  WHERE FirstName='" . $ownerRow['FirstName'] . "'
									      AND LastName='" . $ownerRow['LastName'] . "'
									      AND Division='" . $deptCode . "'
									      AND MonthNo='" . $month_no . "'
									      AND YearNo='" . $year_no . "'";
								mysqli_query($link, $sqlUpdate) or die(mysqli_error($link,));
							}
						}							
						else
						{
							$previousMonthDueNo += $dueNo['dueNo'];
							$previousMonthCompNo += $compNo['compNo'];

							$sqlSelect = "SELECT COUNT(*) AS selectCount FROM tbl_wfmonth 
						              WHERE FirstName='" . $ownerRow['FirstName'] . "'
									  AND LastName='" . $ownerRow['LastName'] . "'
									  AND Division='" . $deptCode . "'
									  AND MonthNo='" . $month_no . "'
									  AND YearNo='" . $year_no . "'";
							$sqlSelectResult = mysqli_query($link, $sqlSelect) or die(mysqli_error($link,));
							$selectCount = mysqli_fetch_assoc($sqlSelectResult);

							if($selectCount['selectCount'] == 0)
							{
								$sqlInsert = "INSERT INTO tbl_wfmonth (FirstName, LastName, Division, DueNo, CompletedNo, MonthNo, YearNo) VALUES 
                                          ('" . $ownerRow['FirstName'] . "', '" . $ownerRow['LastName'] . "', '" . $deptCode . "', '"
                                          . $previousMonthDueNo . "', '" . $previousMonthCompNo . "', '" . $month_no . "', '" . $year_no . "' )";
								mysqli_query($link, $sqlInsert) or die(mysqli_error($link,));
							}
							else
							{
								$sqlSelectDue = "SELECT DueNo FROM tbl_wfmonth
						                     WHERE FirstName='" . $ownerRow['FirstName'] . "'
									         AND LastName='" . $ownerRow['LastName'] . "'
									         AND Division='" . $deptCode . "'
									         AND MonthNo='" . $month_no . "'
									         AND YearNo='" . $year_no . "'";
								$sqlSelectDueResult = mysqli_query($link, $sqlSelectDue) or die(mysqli_error($link,));
								$dueNoCount = mysqli_fetch_assoc($sqlSelectDueResult);
								$previousMonthDueNo += $dueNoCount['DueNo'];
								
								$sqlSelectComp = "SELECT CompletedNo FROM tbl_wfmonth
						                     WHERE FirstName='" . $ownerRow['FirstName'] . "'
									         AND LastName='" . $ownerRow['LastName'] . "'
									         AND Division='" . $deptCode . "'
									         AND MonthNo='" . $month_no . "'
									         AND YearNo='" . $year_no . "'";
								$sqlSelectCompResult = mysqli_query($link, $sqlSelectComp) or die(mysqli_error($link,));
								$compNoCount = mysqli_fetch_assoc($sqlSelectCompResult);
								$previousMonthCompNo += $compNoCount['CompletedNo'];
								
								$sqlUpdate = "UPDATE tbl_wfmonth SET DueNo='" . $previousMonthDueNo . "' , CompletedNo='" . $previousMonthCompNo . "'
						                  WHERE FirstName='" . $ownerRow['FirstName'] . "'
									      AND LastName='" . $ownerRow['LastName'] . "'
									      AND Division='" . $deptCode . "'
									      AND MonthNo='" . $month_no . "'
									      AND YearNo='" . $year_no . "'";
							    mysqli_query($link, $sqlUpdate) or die(mysqli_error($link,));
							}							
						}
					}			
				}	
	
                if($ownDueNo!=0)
				{
					$hasData = True;
					
					if($thCountDept == 1)
					{
						$thCountDept += 1;
						
						$HTML .= "<tr bgcolor='#b7edff'>";
						$HTML .= "<td align='left' colspan=\"5\"  style=\"width:60px;\" >";
						$HTML .= strtoupper($deptStr);
						$HTML .= "</td>";
						$HTML .= "</tr>";
					}
					
					$compPrstg = (($ownCompNo / $ownDueNo) * 100);
					$incompPrstg = ((($ownDueNo - $ownCompNo) / $ownDueNo) * 100);
			
					$HTML .= "<tr>";
					
					$HTML .= "<td align='center' style=\"width:60px;\" >";
					$HTML .= $ownerRow['FirstName'] . " " . $ownerRow['LastName'];
					$HTML .= "</td>";
				
					$HTML .= "<td align='center' style=\"width:60px;\" >";
					$HTML .= $ownDueNo;
					$HTML .= "</td>";
					
					$HTML .= "<td align='center' style=\"width:60px;\" >";
					$HTML .= $ownCompNo;
					$HTML .= "</td>";
					
					$HTML .= "<td align='center' style=\"width:60px;\" >";
					$HTML .= number_format((float)$compPrstg, 2, '.', '');
					$HTML .= "</td>";
					
					$HTML .= "<td align='center' style=\"width:60px;\" >";
					$HTML .= number_format((float)$incompPrstg, 2, '.', '');
					$HTML .= "</td>";
			
					$HTML .= "</tr>";
					
				    $totDueNo += $ownDueNo;		
				    $totCompNo += $ownCompNo;
				}
		    }			
		}
		
		if($totDueNo!=0)
		{
			$totCompPrstg = (($totCompNo / $totDueNo) * 100);
			$totIncompPrstg = ((($totDueNo - $totCompNo) / $totDueNo) * 100);			
	
			$HTML .= "<tr bgcolor='#ebf5ff'>";
				
			$HTML .= "<td align='center' style=\"width:60px;\">Total</td>";
				
			$HTML .= "<td align='center' style=\"width:60px;\" >";
			$HTML .= $totDueNo;
			$HTML .= "</td>";
				
			$HTML .= "<td align='center' style=\"width:60px;\" >";
			$HTML .= $totCompNo;
			$HTML .= "</td>";
				
			$HTML .= "<td align='center' style=\"width:60px;\" >";
			$HTML .= number_format((float)$totCompPrstg, 2, '.', '');
			$HTML .= "</td>";
				
			$HTML .= "<td align='center' style=\"width:60px;\" >";
			$HTML .= number_format((float)$totIncompPrstg, 2, '.', '');
			$HTML .= "</td>";
				
			$HTML .= "</tr>";	
		}
		
		$HTML .= "</table>";
		$HTML .= "</body>";
		$HTML .= "</html>";
		
		if($hasData)
		{
			$array = "[{";
			$array = $array.'"MailBody":"'  . str_replace('"',"'" ,$HTML).'"}]';
		}
		else
		{
			$array = "[{";
			$array = $array.'"MailBody":"'  . str_replace('"',"'" , "There are no workflows assigned for this week.").'"}]';
		}
		echo $array;	
?>