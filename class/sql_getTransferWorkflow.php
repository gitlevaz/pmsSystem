<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database 
include ("../class/sql_wkflow.php");
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
 
  
class sql_getTransferWorkflow {
    //put your code here
}
echo " <script type='text/javascript'' src='../jQuerry/js/jquery-1.6.2.min.js'></script>";
echo " <script type='text/javascript' src='../jQuerry/js/jquery-ui-1.8.16.custom.min.js'></script>";
echo " <script type='text/javascript' language='javascript' src='../media/js/jquery.dataTables.js'></script>";    
echo "<style type='text/css' title='currentStyle'>";
echo " @import '../media/css/demo_page.css'";
echo "@import '../media/css/demo_table.css'";
echo " </style>";
 


if(isset($_POST["empdata"]))
{
	$_empdata     = $_POST["empdata"]; 
	echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
    echo "        $('#example').dataTable();";
	//echo "        $('#empexample').dataTable();";
       echo " } )";
		echo "</script>";
	 //echo $_empdata;
	 $tt="";
	 $tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='example' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				 $_SelectQuery   = 	"SELECT distinct * FROM tbl_workflow where wk_Owner = '$_empdata' group by wk_id" or die(mysqli_error($str_dbconnect));
				$_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
    
}

if(isset($_POST["empeedata"]))
{
	$_empdata     = $_POST["empeedata"]; 
	echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
   // echo "        $('#example').dataTable();";
	echo "        $('#empexample').dataTable();";
       echo " } )";
		echo "</script>";
	 //echo $_empdata;
	 $tt="";
	 $tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='empexample' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				 $_SelectQuery   = 	"SELECT distinct * FROM tbl_workflow where wk_Owner = '$_empdata' group by wk_id" or die(mysqli_error($str_dbconnect));
				$_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
    
}

if(isset($_POST['eempdata22'])){
	$empName = $_POST['eempdata22'];
	echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
	echo "        $('#empexample').dataTable();";
	echo " } )";
	echo "</script>";
	$tt="";
	$tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='empexample' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				 $_SelectQuery2   ="SELECT distinct * FROM tbl_workflow where wk_Owner = '$empName' group by wk_id" or die(mysqli_error($str_dbconnect));
			$_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery2) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
			
 }
 
 if(isset($_POST['ownerdata22'])){  
			$ownerName = $_POST['ownerdata22'];
			echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
  echo "        $('#example').dataTable();";
	
       echo " } )";
		echo "</script>";			
			$tt="";
	 $tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='example' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				 $_SelectQuery2   ="SELECT distinct * FROM tbl_workflow where wk_Owner = '$ownerName' group by wk_id" or die(mysqli_error($str_dbconnect));
			$_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery2) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
			
 }
 
if(isset($_POST['copycheck'])){
	$empid  = "EMP/22";
	$workflowid=$_POST['copycheck'];
	$ownerName = $_POST['oownerdata1'];
    $empName = $_POST['eempdata1'];
	
	$_SelectQuery1 	= "SELECT * FROM tbl_workflow WHERE wk_Owner = '$ownerName' AND wk_id='$workflowid'" or die(mysqli_error($str_dbconnect));
	$_Result = mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
	while ($_myrowRes = mysqli_fetch_array($_Result)) {
		$wid 		 = $_myrowRes['wk_id'];
		$wname 		 = $_myrowRes['wk_name'];
		$wowner 	 = $_myrowRes['wk_Owner'];
		$shedule 	 = $_myrowRes['schedule'];
		$sheduletime = $_myrowRes['sched_time'];
		$sttime 	 = $_myrowRes['start_time'];
		$endtime 	 = $_myrowRes['end_time'];
		$reportowner = $_myrowRes['report_owner'];
		$reportdiv   = $_myrowRes['report_div'];
		$reportdept  = $_myrowRes['report_Dept'];
		$crtdate     = $_myrowRes['crt_date'];
		$status      = $_myrowRes['status'];
		$crtby       = $_myrowRes['crt_by'];
		$catcode     = $_myrowRes['catcode'];
		$wdes        = $_myrowRes['WF_Desc'];
		$wcat        = $_myrowRes['WFUser_cat'];
	}
	
	$wk_id = returnWorkflowID();
	
	$_SelectQuery 	= "INSERT INTO tbl_workflow (`wk_id`, `wk_name`, `wk_Owner`,					`schedule`,`sched_time`,`start_time`,`end_time`,`report_owner`,`report_div`,`report_Dept`,`crt_date`,`status`,`crt_by`,`catcode`,`WF_Desc`,`WFUser_cat`) VALUES ('$wk_id', '$wname', '$empName', '$shedule','$sheduletime','$sttime','$endtime','$reportowner','$reportdiv','$reportdept','$crtdate','$status','$logUser','$catcode','$wdes','$wcat')" or die(mysqli_error($str_dbconnect));
		
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	copyWorkflowAttachments($wid, $wk_id);
	copyWorkflowDocuments($wid, $wk_id);
 }


if(isset($_POST['mworkflowdata1'])){      
			
				$empName=$_POST['mworkflowdata1'];			
				
				
				echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
   // echo "        $('#example').dataTable();";
	echo "        $('#empexample').dataTable();";
       echo " } )";
		echo "</script>";
	 //echo $_empdata;
	 $tt="";
	 $tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='empexample' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				 $_SelectQuery21   = 	"SELECT distinct * FROM tbl_workflow where wk_Owner = '$empName' group by wk_id " or die(mysqli_error($str_dbconnect));
				$_ResultSet111    =   mysqli_query($str_dbconnect,$_SelectQuery21) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet111))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
    
			
 }
 
 if(isset($_POST['delcheck'])){      
			
				$workflowid=$_POST['delcheck'];
				$ownerName = $_POST['ownerdata1'];
				$empName = $_POST['empdata1'];
				
				$_SelectQuery 	= "UPDATE tbl_workflow set `wk_Owner`='$empName' where `wk_id` = '$workflowid' AND `wk_Owner`='$ownerName'" or die(mysqli_error($str_dbconnect));
				mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));					
 }

if(isset($_POST['flowdata1'])){      
			
				$ownerName=$_POST['flowdata1'];								
			
			
			echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
    echo "        $('#example').dataTable();";
	//echo "        $('#empexample').dataTable();";
       echo " } )";
		echo "</script>";
	 //echo $_empdata;
	 $tt="";
	 $tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='example' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				$_SelectQuery22   = "SELECT distinct * FROM tbl_workflow where wk_Owner = '$ownerName' group by wk_id" or die(mysqli_error($str_dbconnect));
			$_ResultSet112    =   mysqli_query($str_dbconnect,$_SelectQuery22) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet112))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
    
			
			
 }
 
if(isset($_POST['copycheckowner'])){
	$empid  = "EMP/22";
	$workflowid=$_POST['copycheckowner'];
	$ownerName = $_POST['odata1'];
	$empName = $_POST['edata1'];
	
	$_SelectQuery1 	= "SELECT * FROM tbl_workflow WHERE wk_Owner = '$empName' AND wk_id='$workflowid'" or die(mysqli_error($str_dbconnect));
	$_Result = mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
	while ($_myrowRes = mysqli_fetch_array($_Result)) {
		$wid 		 = $_myrowRes['wk_id'];
		$wname 		 = $_myrowRes['wk_name'];
		$wowner 	 = $_myrowRes['wk_Owner'];
		$shedule 	 = $_myrowRes['schedule'];
		$sheduletime = $_myrowRes['sched_time'];
		$sttime 	 = $_myrowRes['start_time'];
		$endtime 	 = $_myrowRes['end_time'];
		$reportowner = $_myrowRes['report_owner'];
		$reportdiv   = $_myrowRes['report_div'];
		$reportdept  = $_myrowRes['report_Dept'];
		$crtdate     = $_myrowRes['crt_date'];
		$status      = $_myrowRes['status'];
		$crtby       = $_myrowRes['crt_by'];
		$catcode     = $_myrowRes['catcode'];
		$wdes        = $_myrowRes['WF_Desc'];
		$wcat        = $_myrowRes['WFUser_cat'];
    }
	
	$wk_id = returnWorkflowID();	
	
	$_SelectQuery 	= "INSERT INTO tbl_workflow (`wk_id`, `wk_name`, `wk_Owner`, `schedule`,`sched_time`,`start_time`,`end_time`,`report_owner`,`report_div`,`report_Dept`,`crt_date`,`status`,`crt_by`,`catcode`,`WF_Desc`,`WFUser_cat`) VALUES ('$wk_id', '$wname', '$ownerName', '$shedule','$sheduletime','$sttime','$endtime','$reportowner','$reportdiv','$reportdept','$crtdate','$status','$empid','$catcode','$wdes','$wcat')" or die(mysqli_error($str_dbconnect));
	
	mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	copyWorkflowAttachments($wid, $wk_id);
	copyWorkflowDocuments($wid, $wk_id);
 }


if(isset($_POST['omwflowdata1'])){      
			
				$ownerName=$_POST['omwflowdata1'];			
				
				
				echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
    echo "        $('#example').dataTable();";
	//echo "        $('#empexample').dataTable();";
       echo " } )";
		echo "</script>";
	 //echo $_empdata;
	 $tt="";
	 $tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='example' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				$_SelectQuery24   = 	"SELECT distinct * FROM tbl_workflow where wk_Owner = '$ownerName' group by wk_id " or die(mysqli_error($str_dbconnect));
				$_ResultSet114    =   mysqli_query($str_dbconnect,$_SelectQuery24) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet114))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
 }
 
 if(isset($_POST['delcheckowner'])){      
			
				$workflowid=$_POST['delcheckowner'];
				$ownerName = $_POST['owdata1'];
				$empName = $_POST['epdata1'];
				
				$_SelectQuery 	= "UPDATE tbl_workflow set `wk_Owner`='$ownerName' where `wk_id` = '$workflowid' AND `wk_Owner`='$empName'" or die(mysqli_error($str_dbconnect));
				mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
				
 }
 

if(isset($_POST['checkmoveempdata'])){      
			
				$workflowid=$_POST['checkmoveempdata'];
				$ownerName = $_POST['checkmoveempownerdata'];
				$empName = $_POST['checkmoveempempdata'];			
			
				$_SelectQuery24   = 	"SELECT distinct * FROM tbl_workflow where wk_Owner = '$ownerName' group by wk_id " or die(mysqli_error($str_dbconnect));
				$_ResultSet114    =   mysqli_query($str_dbconnect,$_SelectQuery24) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet114))
				{        
						$wwwwid = $myrowRes['wk_id']; 
						$wwwwname = $myrowRes['wk_name'];                
						echo '<option value="'.$wwwwid.'" >'.$wwwwid." - ".$wwwwname.'</option>';                                                                                     
				}  
			
 }
 
 
 if(isset($_POST['checkmoveownerdata'])){      
	
				$empName = $_POST['checkmoveownerdata'];		
				
				echo "<script type='text/javascript' charset='utf-8'>";
    echo "    $(document).ready(function() {";
   // echo "        $('#example').dataTable();";
	echo "        $('#empexample').dataTable();";
       echo " } )";
		echo "</script>";
	 //echo $_empdata;
	 $tt="";
	 $tt.="<table cellpadding='0' cellspacing='0' border='0' class='display' id='empexample' onmousemove ='getPageSize();'>";
		$tt.="<thead>";
			$tt.="<tr>";
					$tt.="<th>Select</th>";
				$tt.="<th>Workflow Id</th>";
				$tt.="<th>Schedule</th>";
				$tt.="<th>Description</th>";
				
			$tt.="</tr>";
		$tt.="</thead>";
		$tt.="<tbody>";                                                                
				$ColourCode = 0 ;
				$LoopCount = 0;
				$_SelectQuery24   = 	"SELECT distinct * FROM tbl_workflow where wk_Owner = '$empName' group by wk_id " or die(mysqli_error($str_dbconnect));
				$_ResultSet114    =   mysqli_query($str_dbconnect,$_SelectQuery24) or die(mysqli_error($str_dbconnect));
				 while ($myrowRes = mysqli_fetch_array($_ResultSet114))
				{      
						if ($ColourCode == 0 ) {
						$Class = "even gradeC" ;
						$ColourCode = 1 ;
					} elseif ($ColourCode == 1 ) {
						$Class = "odd gradeC";
						$ColourCode = 0 ;
					}
				  
						$wid = $myrowRes['wk_id']; 
						$wname = $myrowRes['wk_name'];   
						$schedule = $myrowRes['schedule'];              
						//echo '<option value="'.$wid.'" >'.$wid." - ".$wname.'</option>';                                                                                                                             
						$tt.="<tr class='".$Class."'>";
							$tt.="<td><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$wid."'\" /></td>";
							$tt.="<td>".$wid."</td>";
							$tt.="<td>".$schedule."</td>";
							$tt.="<td class='left'>".$wname."</td>";                   
						$tt.="</tr>";                                                 
						$LoopCount = $LoopCount + 1;
				}
									  
		   $tt.=" </tbody>";
			$tt.="<tfoot>";
				$tt.="<tr>";
					$tt.="<th>Select</th>";
					$tt.="<th>Workflow</th>";
					$tt.="<th>Schedule</th>";
					$tt.="<th>Description</th>";
					
				$tt.="</tr>";
		   $tt.=" </tfoot>";
   $tt.=" </table>";
   echo $tt;
				
			
 }
 
 function returnWorkflowID(){
	 $_Serial_Val    =   -1;
	 $_CompCode      =   "CIS";
	 
	 $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'" or die(mysqli_error($str_dbconnect));
	 $_ResultSet     =  mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	 
	 while($_myrowRes = mysqli_fetch_array($_ResultSet))
	 {
		 $_Serial_Val =   $_myrowRes['Serial'];
     }
	 
	 $_Serial_Val = $_Serial_Val + 1;
	 
	 $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'" or die(mysqli_error($str_dbconnect));
	 mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	 
	 $Str_WKID = "WK/" . $_Serial_Val;
	 return $Str_WKID;
 }
 
 function copyWorkflowAttachments($oldWorkflowID, $newWorkflowID)
 {
	$empid  = "EMP/22";
	$_SelectQuery1 	= "SELECT * FROM workflowattachments WHERE ParaCode = '$oldWorkflowID'" or die(mysqli_error($str_dbconnect));
	$_Result = mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
	while ($_myrowRes = mysqli_fetch_array($_Result)) {
		$oldProCode = $_myrowRes['ProCode'];
		$paraCode   = $_myrowRes['ParaCode'];
		$fileName 	= $_myrowRes['FileName'];
		$systemName = $_myrowRes['SystemName'];
		$creatBy    = $_myrowRes['CreatBy'];
		
		$newProCode = create_FileName($str_dbconnect);
		$systemName = str_replace($oldProCode, $newProCode, $systemName);
		$Dte_CrtDate = date("Y/m/d") ;
		
		$_SelectQuery   = 	"INSERT INTO WorkflowAttachments (`ProCode`,`ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$newProCode','$newWorkflowID', '$fileName', '$systemName', '$empid', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
		
		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }	
 }
 
 function copyWorkflowDocuments($oldWorkflowID, $newWorkflowID)
 {
	$empid  = "EMP/22";
	$_SelectQuery1 	= "SELECT * FROM prodocumets WHERE ParaCode = '$oldWorkflowID'" or die(mysqli_error($str_dbconnect));
	$_Result = mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
	while ($_myrowRes = mysqli_fetch_array($_Result)) {
		$oldProCode = $_myrowRes['ProCode'];
		$paraCode   = $_myrowRes['ParaCode'];
		$fileName 	= $_myrowRes['FileName'];
		$systemName = $_myrowRes['SystemName'];
		$creatBy    = $_myrowRes['CreatBy'];
		
		$newProCode = create_FileName($str_dbconnect);
		$Dte_CrtDate = date("Y/m/d") ;
		
		$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`,`ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$newProCode','$newWorkflowID', '$fileName', '$systemName', '$empid', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
		
		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    }	
 }
?>
					
