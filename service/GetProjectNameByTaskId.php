
<?php

 //$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 include ("../class/accesscontrole.php");
 $array = array();

    $query = "SELECT tsk.procode, taskcode ,proj.proname FROM tbl_task tsk inner join tbl_projects proj on tsk.procode=proj.procode WHERE tsk.taskcode = '".$_GET["TaskId"]."'";
 	    $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 	    $row=mysqli_fetch_assoc($Result);
		  array_push($array, $row);
 echo json_encode($array);
 
 

?>