<?php

//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');

                
    // $_SelectQuery   =  "SELECT * FROM tbl_employee WHERE EmpSts = 'A' order by FirstName";
	$_SelectQuery   =  "SELECT * FROM tbl_employee e INNER JOIN tbl_sysusers s ON e.EmpCode = s.EmpCode WHERE e.EmpSts =  'A' AND s.UserStat =  'A' ORDER BY e.FirstName";
     $_ResultSet     = mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
     $Result1 = mysqli_num_rows($_ResultSet);
		
        $rows = array();
        while($r = mysqli_fetch_assoc($_ResultSet)) 
		{
            $rows[] = $r;
        }
      echo json_encode($rows); 

 

?>