<?php

$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');

                
     $_SelectQuery   =  "SELECT * FROM wfcategory";
     $_ResultSet     = mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
     $Result1 = mysqli_num_rows($_ResultSet);
		
        $rows = array();
        while($r = mysqli_fetch_assoc($_ResultSet)) 
		{
            $rows[] = $r;
        }
      echo json_encode($rows); 

 

?>