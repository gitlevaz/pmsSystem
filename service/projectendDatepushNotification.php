  <?php
$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
 include ("../class/accesscontrole.php");
 $query="SELECT EmployeeId FROM tbl_pushnotificationdevice";
 $Result=mysqli_query($link,$query) or die(mysqli_error($link));
 $rows = array();
 while($r = mysqli_fetch_assoc($Result))
 {
    $rows[] = $r;	
 }
 
  foreach ($rows as $value) 
  {
	 
    $query="SELECT DISTINCT tsk.procode,tsk.taskcode,tsk.taskname,tsk.taskstatus,tsk.Precentage,DATE_FORMAT(tsk.taskcrtdate,'%m-%d-%Y') as taskStartDate,DATE_FORMAT(tsk.taskenddate,'%m-%d-%Y') as taskEndDate, tsk.AllHours,SEC_TO_TIME( SUM( TIME_TO_SEC(tskupd .TotHors))) as TotHors , proj.EndDate as projectEndDate FROM tbl_task tsk left join tbl_taskupdates tskupd on tsk.taskcode=tskupd.taskcode  inner join tbl_taskowners tskownr on tsk.taskcode=tskownr.TaskCode inner join tbl_projects proj on tsk.procode=proj.procode WHERE  tskownr.EmpCode = '".$value["EmployeeId"]."'  and tsk.taskstatus in ('A','I' ) group by tsk.taskcode";
    $Result=mysqli_query($link,$query) or die(mysqli_error($link));
    $rows = array();
    while($r = mysqli_fetch_assoc($Result))
    {
        $rows[] = $r;
    }

    foreach ($rows as $val) 
     {
		 $currentDate=Date('m-d-Y');
		 $currentDateArray=explode("-",$currentDate);
		 $currentSeconds= (int)$currentDateArray[0]*2629743 + (int)$currentDateArray[1]*86400 + (int)$currentDateArray[2]*31556926;
		 	
		 $taskendDateArray=explode("-",$val["taskEndDate"]);
		 $taskendDateSeconds= (int)$taskendDateArray[0]*2629743 + (int)$taskendDateArray[1]*86400 + (int)$taskendDateArray[2]*31556926;
		 
		 $cls_date = new DateTime($val["projectEndDate"]);
         $proDate = $cls_date->format('m-d-Y'); 
		 $projectendDateArray=explode("-",$proDate);
		 $projectendDateSeconds= (int)$projectendDateArray[0]*2629743 + (int)$projectendDateArray[1]*86400 + (int)$projectendDateArray[2]*31556926;
		
		
		 echo $value["EmployeeId"];
		 echo "<br>";		 
		 echo $val["taskcode"];
		 echo "<br>";
		 echo $currentDate;		 		 
		 echo "<br>";		 
		 echo $val["taskEndDate"];	
		 echo "<br>";
		 echo "<br>";		 
		 
		 /* echo $value["EmployeeId"];
		  echo "<br>";
		   echo $value["procode"];
		  echo "<br>";
		  echo $val["taskcode"];
		 echo "<br>";
		 echo $currentDate;		 		 
		 echo "<br>";	
         echo   $currentSeconds;		 		 
		 echo "<br>";		 
		 echo $val["taskEndDate"];
		 echo "<br>";
		 echo $taskendDateSeconds;
		 echo "<br>";
		 echo  $proDate;		 		 
		 echo "<br>";
		  echo  $projectendDateSeconds;		 		 
		 echo "<br>";
		
		if(intval($taskendDateSeconds) < intval( $currentSeconds) )
		{
			echo 'true';
		}
		else{
			echo 'false';
		}
		
 if( intval($projectendDateSeconds) >intval( $currentSeconds))
		{
			echo 'true';
		}
		else{
			echo 'false';
		} */   
		
		 
       /*  if( intval($taskendDateSeconds) < intval( $currentSeconds) && intval($projectendDateSeconds) >intval( $currentSeconds)  )
        { */
			 if( $currentDate ==  $val["taskEndDate"]  )
			 {
			define( 'API_ACCESS_KEY', 'AIzaSyA6zP4EK_ybh_mhMzTBE8FwVXqXF3XMr9A' );
			$query = "SELECT DeviceId FROM tbl_pushnotificationdevice WHERE EmployeeId='".$value["EmployeeId"]."'";        
			$Result=mysqli_query($link,$query) or die(mysqli_error($link));   
			$row=mysqli_fetch_assoc($Result);
            
			if($val["TotHors"] != null)		
			{
				$totalHoursSpentArray=explode(":",$val["TotHors"]);
			}
			else
			{
				$tolhours="00:00:00";
				$totalHoursSpentArray=explode(":",$tolhours);
			}
           // $totalHoursSpentArray=explode(":",$val["TotHors"]);
            $remainingHours= ((int)$val["AllHours"]*3600 - ( (int)$totalHoursSpentArray[0]*3600 + (int)$totalHoursSpentArray[1]*60+ (int)$totalHoursSpentArray[2]));
			//echo $remainingHours;			
 
            $sec_num = (int)$remainingHours; // don't forget the second param 
            $hours = floor((int)$sec_num / 3600);
            $minutes = floor(((int)$sec_num - ((int)$hours * 3600)) / 60); 
            $seconds = (int)$sec_num - ((int)$hours * 3600) - ((int)$minutes * 60); 

            /*if ($hours < 10) { $hours = "0".$hours; }
            if ($minutes < 10) { $minutes = "0".$minutes; }
            if ($seconds < 10) { $seconds = "0".$seconds; }*/
            $time = $hours.':'.$minutes;
			
            $Message=$val["taskcode"]."  ".$val["taskname"];
			$Title="Project Notification";
			$SubTitle="From:".$val["taskStartDate"]." To:".$val["taskEndDate"]." Remaining Time:  ". $time;
			$taskc=explode("/",$val["taskcode"]);
			
			$url="#,task,".$taskc[0]."-".$taskc[1].",".$val["Precentage"];
			
			
			
			$i=rand(1,100);
			$registrationIds = array($row["DeviceId"]);
			$msg = array
			(
				'message' 	=> $Message,
				'title'		=> $Title,
				'subtitle'	=> $SubTitle,
				'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
				'vibrate'	=> 1,
				'sound'		=> 1,
				'largeIcon'	=> 'large_icon',
				'smallIcon'	=> 'small_icon',
				'notId'=> $i
							 
			);
			$fields = array
			(
				'registration_ids' 	=> $registrationIds,
				'data'			=> $msg
			);
			 
			$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,                                      
				'Content-Type: application/json'
			);
			 
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch );
			curl_close( $ch );
			
			$json = json_decode($result);
            
			if($json->success == 1)			
			{
				//echo 'd';
				$empcode=$value["EmployeeId"];
				$Insert = "INSERT INTO tbl_pushnotificationmessage (EmpCode, Message ,Category,Url,Title,SubTitle) VALUES ('$empcode', '$Message','Project Wise','$url','$Title','$SubTitle')";                
	            $result=mysqli_query($link,$Insert) or die(mysqli_error($link));
				
			}
			echo $result;
        }

    }
    
  }
  

?>