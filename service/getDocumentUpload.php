
<?php

//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
//  $TaskCode = $_GET["TaskCode"];
 $progectCode = $_GET["ParaCode"];
 $taskCode = $_GET["taskcode"];

 if ($progectCode != null && $taskCode != null ){
//	 echo 'true';
	 $query = "SELECT ProCode, ParaCode, FileName, SystemName FROM prodocumets WHERE ParaCode ='$taskCode' or ParaCode ='$progectCode'  ORDER BY ProCode desc";
           
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 
 $rows = array();
 while($r = mysqli_fetch_assoc($Result)) {
    $rows[] = $r;
 }
}


 //if ($taskCode != null){

// $query = "SELECT ProCode, ParaCode, FileName, SystemName FROM prodocumets WHERE ParaCode ='$taskCode' ORDER BY ProCode desc";
           
// $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 
// $rows = array();
// while($r = mysqli_fetch_assoc($Result)) {
 //   $rows[] = $r;
//}
 //}
//SELECT     ProCode ,   ParaCode ,  FileName,  SystemName  FROM prodocumets WHERE  ParaCode  = '" + taskcode + "' ORDER BY  ProCode  desc";
          

   echo json_encode($rows);
   
  
?>