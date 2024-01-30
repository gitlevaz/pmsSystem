<?php

//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');

  $strGrpCode = $_GET["Country"];
                
     $_SelectQuery   =  "SELECT * FROM tbl_projectgroups WHERE Country  = '$strGrpCode' AND GrpStat = 'A'";
     $_ResultSet     = mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
     $Result1 = mysqli_num_rows($_ResultSet);
		
        $rows = array();
        while($r = mysqli_fetch_assoc($_ResultSet)) 
		{
            $rows[] = $r;
        }
      echo json_encode($rows); 

 

?>