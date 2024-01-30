<?php
//$connection = include_once('../connection/sqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
include ("../class/accesscontrole.php");

	$crt_by = str_replace("-", '/',$_GET["empCode"]);
    $crt_date = date("Y-m-d"); 	
	$wk_name = $_GET["taskName"];
    $wk_Owner = $crt_by;
    $schedule = $_GET["schedule"];
    $start_time = $_GET["startTime"];
    $end_time = $_GET["endTime"];
    $report_owner = str_replace("-", '/',$_GET["reportOwner"]);
    $report_div = $_GET["div"];
    $report_Dept = $_GET["dpt"];
    $wfcategory = $_GET["wfcat"];
	$WF_Desc = $_GET["taskDesc"];
    $FacCode = $_GET["taskID"];
	$newfilecode = $_GET["newfilecode"];
	$weeklydays=$_GET["weeklydays"];
	$monthlydays=$_GET["monthlydays"];
    

function createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc) 
{
	global $connection;
	
	$wk_name=str_replace("'", '"',$wk_name);
	$WF_Desc=str_replace("'", '"',$WF_Desc);
	
	    $_SelectQuery13 	=   "SELECT count(*) FROM tbl_workflow WHERE `wk_id` = '$wk_id' and crt_date='$crt_date'  ";
        $_ResultSet 	= mysqli_query($link,$_SelectQuery13) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
			 $count = $_myrowRes['count(*)'];
		}
	
	   // if($count == '0')
		//{
			
			 $_SelectQuery 	=   "INSERT INTO tbl_workflow (`wk_id`, `wk_name`, `wk_Owner`, `schedule`, `sched_time`, `start_time`, `end_time`, `report_owner`, `report_div`, `report_Dept`, `crt_date`, `status`, `crt_by`, `catcode`, `WF_Desc`)
                             VALUES ('$wk_id', '$wk_name', '$wk_Owner', '$schedule', '$sched_time', '$start_time', '$end_time', '$report_owner', '$report_div', '$report_Dept', '$crt_date', 'A', '$crt_by', '$wfcategory', '$WF_Desc')";
							 
        $insertStatus = mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
		
		$_SelectQuery12 	=   "SELECT * FROM tbl_workflow WHERE `wk_id` = '$wk_id'";
        $_ResultSet 	= mysqli_query($link,$_SelectQuery12) or die(mysqli_error($link));
        $Result1 = mysqli_num_rows($_ResultSet);
        while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		{
            
            $wwk_id    =	$_myrowRes['wk_id'];
            $wwk_Owner   = $_myrowRes['wk_Owner'];
            $wwk_name  = ($_myrowRes['wk_name']);
            $wstart_time = $_myrowRes['start_time'];
            $wend_time = $_myrowRes['end_time'];
            $wcatcode = $_myrowRes['catcode'];
            $wWf_Desc = ($_myrowRes['WF_Desc']);
			$wWFUser_cat = $_myrowRes['WFUser_cat'];
            
            
            $_SelectQuery34 	=   "INSERT INTO tbl_workflowupdate (`wk_id`, `wk_owner`, `wk_name`, `crt_date`, `start_time`, `end_time`, `status`, `catcode`, `Wf_Desc`, `WFUser_cat`)
                                    VALUES ('$wwk_id', '$wwk_Owner', '$wwk_name', '$crt_date', '$wstart_time', '$wend_time',  'No', '$wcatcode', '$wWf_Desc', '$wWFUser_cat')";
            
            $insertStatus1= mysqli_query($link, $_SelectQuery34) or die(mysqli_error($str_dbconnect$connection));
			 	if($insertStatus1 == 1)
					{
						echo 'Inserted';
					}
					else
					{
						echo 'Inserted';
					} 
            
        }
		//}
       
        
        if($schedule == "Weekly")
		{
            $_SelectQuery = "SELECT * FROM tbl_wfalert WHERE `FacCode` = '$FacCode'";
            $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
            $Result1 = mysqli_num_rows($_ResultSet);
            while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		    {               
                $_EmpCode     =	$_myrowRes['EmpCode'];
                
                $_SelectQuery =   "INSERT INTO tbl_wfalert (`FacCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$wk_id', '$_EmpCode', '', 'A')";
               mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
            }
        }
		else
		{
            $_SelectQuery = "UPDATE tbl_wfalert SET FacCode = '$wk_id' WHERE FacCode = '$FacCode'";
            mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
        }
    }


	
	if($schedule == "Daily")
		{ 
            $_Serial_Val    =   -1;
            $_CompCode      =   "CIS";

            $_SelectQuery   = "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
            $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
            $Result1 = mysqli_num_rows($_ResultSet);
            while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		    {
                $_Serial_Val =   $_myrowRes['Serial'];
            }

            $_Serial_Val = $_Serial_Val + 1;

            $_SelectQuery   = "UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
            mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection)); 

            $Str_WKID = "CWK/" . $_Serial_Val;
            $Str_UPLCode = $newfilecode;

            $_SelectQuery   = "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
            mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

            $wk_id = $Str_WKID;
			createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
			
			
        }
				
	if($schedule == "Weekly")
		{
           $items = explode(",", $weeklydays);
		    foreach($items as $item) 
			{
				$item = trim($item);
				echo $item;
				if( $item == "Sunday")
			    {
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }
                    $_Serial_Val = $_Serial_Val + 1;

                    $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
                    mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

                    $Str_WKID = "CWK/" . $_Serial_Val;
                    $Str_UPLCode = $newfilecode;
	
					$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		                {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$crt_by', '$crt_date')";
    						mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));									                     
                        }

                    $wk_id = $Str_WKID;
					$sched_time = "Sunday"; 
					$crt_date="0000-00-00";
                    createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                }
				
				if( $item == "Monday")
				{
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }
                    $_Serial_Val = $_Serial_Val + 1;

                    $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
                    mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

                    $Str_WKID = "CWK/" . $_Serial_Val;
                    $Str_UPLCode =$newfilecode;

					$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		                {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = "INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$crt_by', '$crt_date')";
    						 mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));	          
                        }

                    $wk_id = $Str_WKID;
                    $sched_time = "Monday";
					$crt_date="0000-00-00";
                    createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                 
				 }
			     
				if( $item == "Tuesday")
				{
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }
                    $_Serial_Val = $_Serial_Val + 1;

                    $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
                    mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

                    $Str_WKID = "CWK/" . $_Serial_Val;
                    $Str_UPLCode = $newfilecode ;
					
					$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		             {
                        $tFileName = $_myrowRes['FileName'];
					    $tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   ="INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$crt_by', '$crt_date')";
    						 mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));	        
                        }

                    $wk_id = $Str_WKID;
     
                    $sched_time = Tuesday;
					$crt_date="0000-00-00";
                    createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                 
				}					
					
				if( $item == "Wednesday")
				{
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }

                    $_Serial_Val = $_Serial_Val + 1;
                    $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
                    mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

                    $Str_WKID = "CWK/" . $_Serial_Val;
                    $Str_UPLCode = $newfilecode;
						
					$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = "INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$tCreateBy', '$tCreateDate')";
    						mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));		       
                    }	

                    $wk_id = $Str_WKID;
                    $sched_time = "Wednesday";
					$crt_date="0000-00-00";
                    createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                    
					
				}
					
				if($item == "Thursday")
				{

			
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }
                    $_Serial_Val = $_Serial_Val + 1;
                    $_SelectQuery   = "UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
                    mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

                    $Str_WKID = "CWK/" . $_Serial_Val;
                    $Str_UPLCode = $_SESSION["NewUPLCode"];
						
					$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = "INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$crt_by', '$crt_date')";
    						mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));	
                    }

                    $wk_id = $Str_WKID;
     
                    $sched_time = "Thursday";
					$crt_date="0000-00-00";
                    createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                    
					
				}
				
				if( $item == "Friday")
				{                       
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }
                    $_Serial_Val = $_Serial_Val + 1;
                    $_SelectQuery   ="UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
                    mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection)); 

                    $Str_WKID = "CWK/" . $_Serial_Val;
                    $Str_UPLCode = $newfilecode;
						
					$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		               {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = "INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$crt_by', '$crt_date')";
    						 mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection)); 	             
                        }	

                    $wk_id = $Str_WKID;
                    $sched_time ="Friday";
					$crt_date="0000-00-00";
                    createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                    
				
				}
                
				if( $item == "Saturday")
				{
                    $_Serial_Val    =   -1;
                    $_CompCode      =   "CIS";

                    $_SelectQuery   =  "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
                        $_Serial_Val =   $_myrowRes['Serial'];
                    }

                    $_Serial_Val = $_Serial_Val + 1;

                    $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
                    mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

                    $Str_WKID = "CWK/" . $_Serial_Val;
                    $Str_UPLCode = $newfilecode;
						
					$_SelectQuery   =  "SELECT * FROM prodocumets WHERE `ProCode` = '$Str_UPLCode' AND ParaCode = ''";
                    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
                    $Result1 = mysqli_num_rows($_ResultSet);
                    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
		            {
							$tFileName = $_myrowRes['FileName'];
							$tSystemName = $_myrowRes['SystemName'];
							$_SelectQuery   = "INSERT INTO prodocumets (`ProCode`, `ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$Str_UPLCode', '$Str_WKID', '$tFileName', '$tSystemName', '$crt_by', '$crt_date')";
    						mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));							                          
                    }

                    $wk_id = $Str_WKID;
     
                    $sched_time ="Saturday";
					$crt_date="0000-00-00";
                    createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
                    
					
				}
			
			}
		}
		
    if($schedule == "Monthly")
		{ 
				$items = explode(",", $monthlydays);
				$year= date("Y");
				$month=date("m");
				echo $year;
				echo $month;
				echo $monthlydays;
				foreach($items as $item) 
				{
					if($item != "" || null || '')
					{
						$item = trim($item);
					
					if( strlen($item) != 2)
					{
						$item="0".$item;
					}
					$crt_date=$year."-".$month."-".$item;
					
					$_Serial_Val    =   -1;
					$_CompCode      =   "CIS";

					$_SelectQuery   = "SELECT * FROM tbl_serials WHERE `CompCode` = '$_CompCode' AND `Code` = '1051'";
					$_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
					$Result1 = mysqli_num_rows($_ResultSet);
					while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
					{
						$_Serial_Val =   $_myrowRes['Serial'];
					}

					$_Serial_Val = $_Serial_Val + 1;

					$_SelectQuery   = "UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = '$_CompCode' AND Code = '1051'";
					mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection)); 

					$Str_WKID = "CWK/" . $_Serial_Val;
					$Str_UPLCode = $newfilecode;

					$_SelectQuery   = "UPDATE prodocumets SET `ParaCode` = '$Str_WKID' WHERE `procode` = '$Str_UPLCode'";
					mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));

					$wk_id = $Str_WKID;
					createworkflowwithview($str_dbconnect,$wk_id, $wk_name, $wk_Owner, $schedule, $sched_time, $start_time, $end_time, $report_owner, $report_div, $report_Dept, $crt_date, $crt_by, $FacCode, $wfcategory, $WF_Desc);
					
					
					}
					
					
				}
			
        }		
			   
		         
        $_SelectQuery 	= "DELETE FROM tbl_wfalert WHERE FacCode = '$FacCode'";
        mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
				
		$Str_UPLCode = $newfilecode;
		$_SelectQuery 	= "DELETE FROM prodocumets WHERE ProCode = '$Str_UPLCode' AND ParaCode = ''";
        mysqli_query($link, $_SelectQuery) or die(mysqli_error($str_dbconnect$connection));
		
		

?>


