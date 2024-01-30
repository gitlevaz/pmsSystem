  <?php


 //$connection = include_once('../connection/connection.php');
// $connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
 // include ("../class/accesscontrole.php");
  
  
        $HTML = "";
        $today_date  = date("Y-m-d");
        $noOfLogings = "";
        $noOfWorkflows = "";
		$noOfTasks = "";
		
		
		$_SelectQuerysummary = "SELECT `LogType` , count(*) as count FROM `tbl_applicationlog` WHERE  
		 Date(`DateTime`)='$today_date' group by `LogType`";
		
        $_ResultSetsummary 	= mysqli_query($link,$_SelectQuerysummary) or die(mysqli_error($link));
		
		
		 while($_myrowRes = mysqli_fetch_array($_ResultSetsummary)) 
		{
			           
			
					if ($_myrowRes['LogType'] == "login")
                    {
                        $noOfLogings = $_myrowRes['count'];
                    }

                    if ($_myrowRes['LogType'] == "task")
                    {
                        $noOfTasks = $_myrowRes['count'];
                    }

                    if ($_myrowRes['LogType'] == "workflow")
                    {
                        $noOfWorkflows = $_myrowRes['count'];
                    }
			
		}

		    $_SelectQuery 	= "SELECT concat(emp.`FirstName`,' ',emp.`LastName`) as Name, app.`LogType` ,count(*) as count FROM `tbl_applicationlog` app INNER JOIN `tbl_employee` emp   on app.`LoggedUser` = emp.`EmpCode` WHERE Date(`DateTime`)= ' $today_date ' group by app.`LoggedUser`,app.LogType" or die(mysqli_error($link));
			
			$_ResultSet = mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));

			$_MailAdd   =   ""; 
	
		 
		
		$HTML .= "<html>";
        $HTML .= "<head>";
		$HTML .= "</head>";
        $HTML .= "<body>";		
		$HTML .= "<h3 align='center'>PMS mobile application usage Summary for the Date : $today_date</h3>";
		$HTML .= "<h3 align='center'>Summary</h3>";
		$HTML .= "<p align='center'><b> Login : </b> $noOfLogings &nbsp <b> WorkFlow : </b> $noOfWorkflows &nbsp <b> Task : </b> $noOfTasks </P>";
		$HTML .= "<table border=\"1\" style=\"border:1px solid black;font-size:12px;\" width=\"500px\" align='center'> <tr bgcolor='#F5BCA9'> "; 
		$HTML .= "<th align=\"center\" style=\"width:150px;\">Name</th>";
		$HTML .= "<th align=\"center\" style=\"width:150px;\">Action</th>";
		$HTML .= "<th align=\"center\" style=\"width:150px;\">Count</th>";
		$HTML .= "</tr>";
		
		
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
			
		$HTML .= "<tr bgcolor='#F6E3CE'>";
		$HTML .= "<td align='center' style=\"width:60px;\" >";
		$HTML .= $_myrowRes['Name'];
		$HTML .= "</td>";
		$HTML .= "<td align='center' style=\"width:60px;\" >";	
		$HTML .= $_myrowRes['LogType'];		
		$HTML .= "</td>";
		$HTML .= "<td align='center' style=\"width:60px;\" >";
		$HTML .= $_myrowRes['count'];
		$HTML .= "</td>";
		$HTML .= "</tr>";
		
		
			
        }
		 $HTML .= "</body>";
		 $HTML .= "</html>";  
		
		
		 $array = "[{";
	$array =$array.'"MailBody":"'  . str_replace('"',"'" ,$HTML).'"}]';
	echo $array;
         
		
?>

