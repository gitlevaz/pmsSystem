<?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include ("../class/accesscontrole.php");
 

   //$Str_UpdateCode = $_GET["Str_UpdateCode"];   
   $TaskCode = $_GET["TaskCode"];
 //  $TaskCode = str_replace('"', '', $TaskCode);
   $Priority = $_GET["Priority"];
   $TaskDescription = $_GET["TaskDescription"];
   $Start = $_GET["Start"];
   $HoursSpent = $_GET["HoursSpent"];
   $HrsRequest = $_GET["HrsRequest"];
   $EmpCode = $_GET["EmpCode"];
   $End = $_GET["End"];
   $Precentage = $_GET["Precentage"];
   $newFileCode = $_GET["newFileCode"];
   
   if ($TaskCode!=null &&  $Priority!= null && $TaskDescription!=null && $Start !=null &&  $HoursSpent!=null &&  $HrsRequest!=null && $EmpCode!= null && $End!=null && $Precentage!=null)
   {
	   
	  
  $SelectQuery = "SELECT * FROM tbl_serials WHERE CompCode = 'CIS' AND Code = '1030'";
  
   $Result=mysqli_query($link,$SelectQuery) or die(mysqli_error($link));
   
   $row=mysqli_fetch_assoc($Result);
   
   if($row == null)
   {
	   $InsertFirstTime = "INSERT INTO tbl_serials (CompCode, Code, Serial, Desription) VALUES ('CIS', '1030', '0', 'TASK UPDATE SERIALS')";
               
	   mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
	  
   }
   
	  if($row > 0)
	  {		//  string Str_UpdateCode = "UPD/" + Str_UpdateCodeint;
		  $getSerial = $row['Serial'] + 1;
		  
		$Str_UpdateCode  = "UPD/" .$getSerial;
		  
		$UpdateSerials = "UPDATE tbl_serials SET Serial = '$getSerial' WHERE CompCode = 'CIS' AND Code = '1030'";  
		
		mysqli_query($link, $UpdateSerials) or die(mysqli_error($link));
		
	  }
	  // write update 
	  
	                $SelectQuery2 = "SELECT * FROM tbl_taskupdates WHERE UpdateCode = '$Str_UpdateCode'"; 
	                   $Result2=mysqli_query($link,$SelectQuery) or die(mysqli_error($link));
   
                          $row2=mysqli_fetch_assoc($Result2);
   
 //   echo  json_encode($row2);
    if($row2 > 0)
	  {
		  $query2 = "INSERT INTO tbl_taskupdates (`UpdateCode`, `taskcode`, `category`, `Note`, `Status`, `UpdateDate`, `SpentFrom`, `SpentTo`, `TotHors`, `HrsRequest`,`Hrs Approved`, `UpdateUser`,`up_status`)VALUES ('$Str_UpdateCode', '$TaskCode', '$Priority', '$TaskDescription', 'A', '".Date("Y-m-d H:m:s")."', '$Start', '$End', '$HoursSpent', '$HrsRequest','00:00:00', '$EmpCode','Open')";

	         mysqli_query($link, $query2) or die (mysqli_error($str_dbconnect$connection));
		 
	  }
	  
	  /* if($row2 > 0)
	
      {	
           $updatequery2 = "UPDATE tbl_taskupdates SET `taskcode`= '$TaskCode', `category`= '$Priority' , `Note`= '$TaskDescription', `Status`= 'A', `UpdateDate`= '".Date("Y-m-d H:m:s")."', `SpentFrom`='$Start', `SpentTo`='$End', `TotHors`= '$HoursSpent', `HrsRequest`='$HrsRequest',`Hrs Approved`= '00:00:00', `UpdateUser`= '$EmpCode',`up_status`= 'Open' WHERE UpdateCode = '$Str_UpdateCode'";

	         mysqli_query($link, $updatequery2) or die (mysqli_error($str_dbconnect$connection));
   echo 'test2';
	  } */
      
	
			$query3 = "UPDATE tbl_task SET Precentage = '$Precentage' WHERE taskcode = '$TaskCode'";
			
			   mysqli_query($link, $query3) or die (mysqli_error($str_dbconnect$connection));
			   
	 
	   
			$query4 = "UPDATE prodocumets SET ParaCode = '$TaskCode', FileName = 'TSK' WHERE procode = '$newFileCode'";
			  
			  mysqli_query($link, $query4) or die (mysqli_error($str_dbconnect$connection));
			   echo 'true';
	  //  $query = "SELECT * FROM tbl_projects WHERE procode IN (SELECT procode FROM tbl_task WHERE taskcode = '" + TaskCode + "')";
		     //echo " $TaskCode";
						 
					$queryS1 = "SELECT procode,crtusercode,ProOwner,ProInit FROM tbl_projects WHERE procode IN (SELECT procode FROM tbl_task WHERE taskcode = '$TaskCode')";
					
						$Result1 = mysqli_query($link, $queryS1) or die (mysqli_error($str_dbconnect$connection));
							$row1=mysqli_fetch_assoc($Result1);
								$totalRows=mysqli_num_rows($Result1);
								
		if ($row1 > 0 ) {
    // output data of each row
    /* 
        echo  $row1['procode'] ;
		 echo  $row1['crtusercode'] ;
		  echo  $row1['ProOwner'] ;
		   echo  $row1['ProInit'] ;
		    */
         $projeccode = $row1['procode'] ;
		 $crtusercode = $row1['crtusercode'] ;
		 $temp1 = $row1['ProOwner'] ;
		 $projectowner = (string)$temp1; 
		 $temp2 = $row1['ProInit'];
		 $projectInit = (string)$temp2;
		//	echo ('.$projeccode["procode"].');
	 //echo "true";
		}
		
		
		
			   $queryS2 = "SELECT crtusercode FROM tbl_projects WHERE procode IN (SELECT procode FROM tbl_task WHERE taskcode =  '$TaskCode')";
				$crtusercode = mysqli_query($link, $queryS2) or die (mysqli_error($str_dbconnect$connection));
		
			   $queryS3 = "SELECT ProOwner FROM tbl_projects WHERE procode IN (SELECT procode FROM tbl_task WHERE taskcode =  '$TaskCode')";
				$projectowner = mysqli_query($link, $queryS3) or die (mysqli_error($str_dbconnect$connection));
				
			   $queryS5 = "SELECT ProInit FROM tbl_projects WHERE procode IN (SELECT procode FROM tbl_task WHERE taskcode =  '$TaskCode')";
				$projectInit = mysqli_query($link, $queryS5) or die (mysqli_error($str_dbconnect$connection));
				 
	
                if ($Priority == "Completed")
                {
                    $query = "UPDATE tbl_task SET taskstatus = 'W' WHERE taskcode =  '$TaskCode' ";
                     mysqli_query($link, $query) or die (mysqli_error($str_dbconnect$connection));

                    $query = "INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ( '$TaskCode', '$Priority', '$EmpCode', String'$projectowner', String'$projectInit', 'A', '$Str_UpdateCode')";
                     mysqli_query($link, $query) or die (mysqli_error($str_dbconnect$connection));
					 
					 //updateTaskStatusKJRBase($str_dbconnect,TaskCode, Priority123, Precentage, EmpCode);
					 
                    $Priority123 = "W";
					$query ="SELECT * FROM tbl_employee WHERE EmpCode = '$EmpCode' ";
					  $Result = mysqli_query($link, $query) or die (mysqli_error($str_dbconnect$connection));
					  $row=mysqli_fetch_assoc($Result); 
					  
					  $query ="SELECT EmpNIC FROM tbl_employee WHERE EmpCode = '$EmpCode' ";
					   $EmpNIC = mysqli_query($link, $query) or die (mysqli_error($str_dbconnect$connection));
					
					  if (row != 0)
            {
               
            //    cl.UpdatePercentageStatus(_Priority, Precentage, epfno, _TaskCode); call function in  http://66.81.19.236/HRIMSTest/WEBService/PMSWFService.asmx?WSDL
            }
                    
			

                }

                if ($Priority == "")
                {
					
                      $query = "INSERT INTO tbl_apptask (`TaskCode`, `Category`, `crtusercode`, `ProOwner`, `ProInit`, `AppStat`, `ID`)VALUES ('$TaskCode', '$Priority', '$EmpCode', 'test', 'test', 'A', '$Str_UpdateCode')";

						mysqli_query($link,$query) or die (mysqli_error($str_dbconnect$connection));
						echo 'True';
                }

                if ($Priority == "Inprogress")
                {
                    $query = "UPDATE tbl_task SET `taskstatus` = 'A' WHERE `taskcode` = $TaskCode";
                       mysqli_query($link, $query) or die (mysqli_error($str_dbconnect$connection));
					   
                     $query = "UPDATE tbl_projects SET `prostatus` = 'A' WHERE `procode` = $projeccode ";
                       mysqli_query($link, $query) or die (mysqli_error($str_dbconnect$connection));
					echo 'True';
         
   }
   }
  try {
             /* string Priority123 = "A";
                    updateTaskStatusKJRBase($str_dbconnect,TaskCode, Priority123, Precentage, EmpCode); */
                }
				
  
  Catch(Exception $e) {
	  echo 'Caught exception: ',  $e->getMessage(), "\n";
    echo 'False';
}
  
?>