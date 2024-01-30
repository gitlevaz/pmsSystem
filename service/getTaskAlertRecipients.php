<?php
 //$connection = include_once('../connection/sqlconnection.php');
 // $connection = include_once('../connection/previewconnection.php');
 $connection = include_once('../connection/mobilesqlconnection.php');
  include ("../class/accesscontrole.php"); 
 $String="";
 
 $ProjectQuery="SELECT 
(select EMail  from tbl_employee em inner join tbl_sysusers sys on em.EmpCode=sys.EmpCode where sys.Id = proj.crtusercode) as ProjectCreatedUser,
(select EMail  from tbl_employee where EmpCode = proj.ProOwner) as ProjectOwner,
(select EMail  from tbl_employee where EmpCode = proj.ProInit) as ProjectInitiator,
(select EMail  from tbl_employee where EmpCode = proj.SecOwner) as secondaryowner,
(select EMail  from tbl_employee where EmpCode = proj.Support) as projectsupport,
(select EMail  from tbl_employee where EmpCode = (SELECT EmpCode FROM tbl_sysusers WHERE  Id='proj.crtusercode')) as projectCreated
 FROM tbl_projects proj
 where proj.procode='".$_GET["ProjectCode"]."'";

 $ProjectResult=mysqli_query($link,$ProjectQuery) or die(mysqli_error($link));
 $Projectrow=mysqli_fetch_assoc($ProjectResult);
 $String=$String.$Projectrow["ProjectCreatedUser"]."-".$Projectrow["ProjectOwner"]."-".$Projectrow["ProjectInitiator"]."-".$Projectrow["secondaryowner"]."-".$Projectrow["projectsupport"]."-".$Projectrow["projectCreated"];
 
 
 $TaskOwnerQuery="select (select EMail  from tbl_employee where EmpCode = taskow.EmpCode)  as TaskOwner from tbl_taskowners taskow where taskow.TaskCode='".$_GET["TaskCode"]."'";
 $TaskOwnerResult=mysqli_query($link,$TaskOwnerQuery) or die(mysqli_error($link));
 $rows = array();
 while($r = mysqli_fetch_assoc($TaskOwnerResult))
 {
    $rows[] = $r;
 } 
  foreach ($rows as $value) 
  {
	 $String=$String."-".$value["TaskOwner"];
  }
  
  $TaskQuery="SELECT MailCCTo FROM tbl_task WHERE taskcode='".$_GET["TaskCode"]."'";
  $TaskResult=mysqli_query($link,$TaskQuery) or die(mysqli_error($link));
  $Taskrow=mysqli_fetch_assoc($TaskResult);
  
  $String=$String."-".$Taskrow["MailCCTo"];
  
  echo $String;
  ?>