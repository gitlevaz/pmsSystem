<?php
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');

$hasData = False;
$today_date = date("Y-m-d", strtotime("-1 day"));
$day = date("l", strtotime("-1 day"));
$show_date = date("m-d-Y");
//$today_date = "2016-11-03";
//$day = "Thursday";
//$show_date = "03-11-2016";
$status = "";
$dueNo = "";
$compNo = "";
$compPrstg = "";
$incompPrstg = "";
$totDueNo = 0;
$totCompNo = 0;
$totCompPrstg = 0;
$totIncompPrstg = 0;

        $HTML = "";
        $HTML0 = "";
		$HTML1 = "";
        $HTML0 .= "<html>";
        $HTML0 .= "<head>";
        $HTML0 .= "</head>";
        $HTML0 .= "<body>";		
		$HTML0 .= "<h3 align=\"center\" style=\"font-family:calibri;\">SL-Workflow: Status of workflow for $show_date</h3>";
		$HTML0 .= "<p style=\"font-family:calibri;\"><b>Workflow Completion Status By Workflow Owner</b></p>";
		$HTML0 .= "<table border=\"1\" style=\"font-family:calibri;font-size:12px;white-space:nowrap\" width=\"500px;\"> <tr bgcolor='#62b1ff'> "; 
		$HTML0 .= "<th align=\"center\" style=\"width:150px;\">Workflow Owner</th>";
		$HTML0 .= "<th align=\"center\" style=\"width:150px;\">Status</th>";
		$HTML0 .= "</tr>";
		
        $departmentSql = "SELECT `GrpCode`, `Group` FROM `tbl_projectgroups` WHERE Country = 'SL' ORDER BY `Group` ASC";
        $departmentResult = mysqli_query($link, $departmentSql) or die(mysqli_error($link));
		
		$thCount = 1;
		while($departmentRow = mysqli_fetch_assoc($departmentResult)) {
			$thCountDept = 1;
			$trCountDept = 1;
			$deptStr = "";
			
			$deptDueNo = 0;
			$deptCompNo = 0;
			$deptTotDueNo = 0;
			$deptTotCompNo = 0;
			$deptTotCompPrstg = "";
			$deptTotIncompPrstg = "";
			
			$ownerSql = "SELECT emp.FirstName, emp.LastName, emp.EmpCode
			             FROM tbl_workflow wrk
                         INNER JOIN tbl_employee emp ON wrk.wk_Owner = emp.EmpCode
                         WHERE wrk.sched_time = '" . $day . "'
                         AND emp.Division = 'SL'
                         AND emp.DeptCode = '" . $departmentRow['GrpCode'] . "'
                         UNION 
                         SELECT emp.FirstName, emp.LastName, emp.EmpCode
                         FROM tbl_workflow wrk
                         INNER JOIN tbl_employee emp ON wrk.wk_Owner = emp.EmpCode
                         WHERE wrk.schedule = 'Daily'
                         AND emp.Division = 'SL'
                         AND emp.DeptCode = '" . $departmentRow['GrpCode'] . "'
                         ORDER BY FirstName, LastName";
            $ownerResult = mysqli_query($link, $ownerSql) or die(mysqli_error($link));
			
			if(mysqli_num_rows($ownerResult) > 0)
			{
				$deptStr = $departmentRow['Group'];
			}
			
			while($ownerRow = mysqli_fetch_assoc($ownerResult)) {				
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
			    
				$dueResult = mysqli_query($link, $dueSql) or die(mysqli_error($link));	
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
			    
				$compResult = mysqli_query($link, $compSql) or die(mysqli_error($link));
				$compNo = mysqli_fetch_assoc($compResult);
	
                if($dueNo['dueNo']!=0)
				{
					$hasData = True;
					
					if($thCountDept == 1)
					{
						$thCountDept += 1;
						
						$HTML0 .= "<tr bgcolor='#b7edff'>";
						$HTML0 .= "<td align='left' colspan=\"2\"  style=\"width:60px;\" >";
						$HTML0 .= strtoupper($deptStr);
						$HTML0 .= "</td>";
						$HTML0 .= "</tr>";
					}

					if($dueNo['dueNo'] > 0)
					{
						$dueNo['dueNo'] = 1;
						$deptDueNo = 1;
					}
					else
					{
						$dueNo['dueNo'] = 0;
						$deptDueNo = 0;					
					}
					
					if($compNo['compNo'] > 0)
					{
						$compNo['compNo'] = 1;
						$deptCompNo = 1;
						$status="Completed";
					}
					else
					{
						$compNo['compNo'] = 0;
						$deptCompNo = 0;
						$status = "Pending";
					}
					
					if($status == "Pending")
					{
						$HTML0 .= "<tr bgcolor='#FE2E2E'>";
					}
					else if($status == "Completed")
					{
						$HTML0 .= "<tr bgcolor='#2EFE2E'>";
					}
					
					
					$HTML0 .= "<td align='center' style=\"width:60px;\" >";
					$HTML0 .= $ownerRow['FirstName'] . " " . $ownerRow['LastName'];
					$HTML0 .= "</td>";
				
					$HTML0 .= "<td align='center' style=\"width:60px;\" >";
					$HTML0 .= $status;
					$HTML0 .= "</td>";					
					
					$HTML0 .= "</tr>";
					
				    $totDueNo += $dueNo['dueNo'];				
				    $totCompNo += $compNo['compNo'];
					
					$deptTotDueNo += $deptDueNo;
					$deptTotCompNo += $deptCompNo;
				}
		    }
			
			
			if($thCount == 1)
			{				
				if($deptTotDueNo!=0)
				{
					$thCount += 1;
					
					$HTML1 .= "<br><br>";
					$HTML1 .= "<p style=\"font-family:calibri;\"><b>Workflow Completion Status By Department</b></p>";
					$HTML1 .= "<table border=\"1\" style=\"font-family:calibri;font-size:12px;white-space:nowrap\" width=\"500px;\"> <tr bgcolor='#62b1ff'> ";
					$HTML1 .= "<th align=\"center\" style=\"width:150px;\">Department</th>";
					$HTML1 .= "<th align=\"center\" style=\"width:150px;\">No of Workflows Assigned</th>";
					$HTML1 .= "<th align=\"center\" style=\"width:150px;\">No of Workflows Completed</th>";
					$HTML1 .= "<th align=\"center\" style=\"width:150px;\">Workflow Completion %</th>";
					$HTML1 .= "<th align=\"center\" style=\"width:150px;\">Workflow Incompletion %</th>";
					$HTML1 .= "</tr>";
				}
			}
			
			if($trCountDept == 1)
			{
				$trCountDept += 1;
				
				if($deptTotDueNo!=0)
				{
					$deptTotCompPrstg = (($deptTotCompNo / $deptTotDueNo) * 100);
					$deptTotIncompPrstg = ((($deptTotDueNo - $deptTotCompNo) / $deptTotDueNo) * 100);
			
					$HTML1 .= "<tr>";
				
					$HTML1 .= "<td align='center' style=\"width:60px;\" >";
					$HTML1 .= $departmentRow['Group'];
					$HTML1 .= "</td>";
					
					$HTML1 .= "<td align='center' style=\"width:60px;\" >";
					$HTML1 .= $deptTotDueNo;
					$HTML1 .= "</td>";
				
					$HTML1 .= "<td align='center' style=\"width:60px;\" >";
					$HTML1 .= $deptTotCompNo;
					$HTML1 .= "</td>";
				
					$HTML1 .= "<td align='center' style=\"width:60px;\" >";
					$HTML1 .= number_format((float)$deptTotCompPrstg, 2, '.', '');
					$HTML1 .= "</td>";
				
					$HTML1 .= "<td align='center' style=\"width:60px;\" >";
					$HTML1 .= number_format((float)$deptTotIncompPrstg, 2, '.', '');
					$HTML1 .= "</td>";
				
					$HTML1 .= "</tr>";
				}
			}				
		}
		
		$HTML0 .= "</table>";
		
		if($totDueNo!=0)
		{
			$totCompPrstg = (($totCompNo / $totDueNo) * 100);
			$totIncompPrstg = ((($totDueNo - $totCompNo) / $totDueNo) * 100);			
	
			$HTML1 .= "<tr bgcolor= '#ebf5ff'>";
				
			$HTML1 .= "<td align='center' style=\"width:60px;\"><b>Total</b></td>";
				
			$HTML1 .= "<td align='center' style=\"width:60px;\" >";
			$HTML1 .= "<b>" . $totDueNo . "</b>";
			$HTML1 .= "</td>";
				
			$HTML1 .= "<td align='center' style=\"width:60px;\" >";
			$HTML1 .= "<b>" . $totCompNo . "</b>";
			$HTML1 .= "</td>";
				
			$HTML1 .= "<td align='center' style=\"width:60px;\" >";
			$HTML1 .= "<b>" . number_format((float)$totCompPrstg, 2, '.', '') . "</b>";
			$HTML1 .= "</td>";
				
			$HTML1 .= "<td align='center' style=\"width:60px;\" >";
			$HTML1 .= "<b>" . number_format((float)$totIncompPrstg, 2, '.', '') . "</b>";
			$HTML1 .= "</td>";
				
			$HTML1 .= "</tr>";	
		}
		
		$HTML1 .= "</table>";
		$HTML1 .= "</body>";
		$HTML1 .= "</html>";
		
		$HTML = $HTML0 . $HTML1;
		
		if($hasData)
		{
			$array = "[{";
			$array = $array.'"MailBody":"'  . str_replace('"',"'" ,$HTML).'"}]';
		}
		else
		{
			$array = "[{";
			$array = $array.'"MailBody":"'  . str_replace('"',"'" , "There are no workflows assigned for today.").'"}]';
		}
		echo $array;	
?>