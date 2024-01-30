 
 <?php


$connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
 // include ("../class/accesscontrole.php");
  
  $employeeId = $_GET["EmpId"];
  $WorkflowTaskId = $_GET["WorkflowTaskId"];
  $reason = $_GET["reason"];
  
  
  
     $HTML = "";
        $today_date  = date("m-d-Y");
        
        $_EmpName    =   "";
        $_DesCode    =   "";
       
        $_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$employeeId'" or die(mysqli_error($link));
        $_ResultSet 	=   mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));

        $_MailAdd   =   "";

		
		
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName    =   $_myrowRes['FirstName']. " " . $_myrowRes['LastName'];
            $_DesCode    =   $_myrowRes['DesCode'];
        }
		   
        $HTML .= "<html>";
        $HTML .= "<head>";
        $HTML .= "<style type=\"text/css\">
            body{
                font-family:sans serif;
                font-size:12px;
                color:#000066;
            }            
            table{
                border-collapse:collapse;
                border:1px solid black;
                border-color: #000066;
            }
            th{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
            td{
                border:1px solid black;
                border-color: #000066;
                font-family: Century Gothic;
                font-size: 11px;
                color: #000099;
                width: auto;
            }
        </style>";
        
        $HTML .= "</head>";
        $HTML .= "<body>";
        
        $HTML .= "<center><h1><b>Remove Workflow Task </b></h1></center></br>";
        $HTML .= "<center><h2><b>W/F User : </b>".$_EmpName ."</h2></center></br>";
        $HTML .= "</br></br>" ;
		$HTML .= "<table cellpadding=\"5px\" cellspacing=\"0\" width=\"100%\" border=\"1px\">";
        $HTML .= "<thead>";
        $HTML .= "<tr>";                    
	        $HTML .= "<th rowspan='2' width='500px'>WorkFlow Id</th>";
	        $HTML .= "<th rowspan='2' width='100px'>WorkFlow Name</th>";
			$HTML .= "<th rowspan='2' width='100px'>Reason</th>";                                   
        $HTML .= "</tr>";
		 $HTML .= "</thead>";
        $HTML .= "<tbody>";
		
								
	    $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_id` = '$WorkflowTaskId' and wk_Owner='$employeeId'" or die(mysqli_error($link));
        $_ResultSet 	=   mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));

	        while ($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				
				$BGCOLOR = "";
					
				if($_myrowRes['status'] == "Yes"){
					$BGCOLOR = "#daffca";
				}else if ($_myrowRes['status'] == "No"){
					$BGCOLOR = "#ffcaca";	
				}else{
					$BGCOLOR = "#cae8ff";
				}		
					
				$HTML .= "<tr style='background-color:".$BGCOLOR."'>";				
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['wk_id'];
					$HTML .= "</td>";
					$HTML .= "<td width='100px'>";
						$HTML .= $_myrowRes['wk_name'];
					$HTML .= "</td>";	
					$HTML .= "<td width='100px'>";
						$HTML .= $reason;
					$HTML .= "</td>";					
				$HTML .= "</tr>";			
				
	        } 
				    			              
        $HTML .= "</tbody>";
        $HTML .= "</table>";  
        $HTML .= "</body>";
        $HTML .= "</html>";  
		
		
		 $array = "[{";
	$array =$array.'"MailBody":"'  . str_replace('"',"'" ,$HTML).'"}]';
	echo $array;
        
       
   
  
?>

