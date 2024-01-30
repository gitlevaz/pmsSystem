<?php


//$connection = include_once('../connection/sqlconnection.php');
 //$connection = include_once('../connection/previewconnection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php");

 $query = "SELECT        id,   compcode,    procode ,   proname ,        DATE_FORMAT(startdate ,'%m-%d-%Y') as  startdate ,   (select CONCAT_WS(' ', FirstName, LastName) as crtusercode  from tbl_sysusers Ut , tbl_employee tE where  Id = crtusercode and Ut .EmpCode= tE.EmpCode ) as crtusercode ,        crtdate ,   prostatus  ,        DATE_FORMAT(EndDate , '%m-%d-%Y') as EndDate , (select `Group` from tbl_projectgroups where GrpCode = Department ) as Department,      Division ,        (select CONCAT_WS(' ' , FirstName, LastName) as crtusercode from tbl_employee where EmpCode = ProInit) as ProInit ,(select CONCAT_WS( ' ', FirstName, LastName ) as crtusercode from tbl_employee where EmpCode = SecOwner ) as SecOwner , (select  CONCAT_WS(' ', FirstName, LastName) as Support from tbl_employee where EmpCode = Support) as Support ,       OrderByNum ,        Rate,(select CONCAT_WS( ' ', FirstName, LastName ) as crtusercode from tbl_employee where EmpCode = ProOwner ) as ProOwner FROM tbl_projects WHERE procode = '".$_GET["ProId"]."' ";

 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
  $row=mysqli_fetch_assoc($Result);
     echo json_encode($row);
   
  
?>

