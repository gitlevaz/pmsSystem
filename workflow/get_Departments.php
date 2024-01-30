<?php    
    
    session_start();
    
    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
    include ("../class/sql_crtprocat.php");            //  connection file to the mysql database
    include ("../class/sql_empdetails.php"); //  connection file to the mysql database
    include ("../class/sql_wkflow.php"); //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
    
    if(isset($_POST['id'])){
        
        $id=$_POST['id'];		
        $_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$id);
        while($_myrowRes = mysqli_fetch_array($_DepartmentSet)) {
            $id = $_myrowRes['GrpCode'];
            $data = $_myrowRes['Group'];            
            echo '<option value="'.$id.'">'.$data.'</option>';
        }
    }	
	
	if(isset($_POST['divid'])){
        
        $id=$_POST['divid'];
		$deptId= $_POST['deptId']; 
        $_DepartmentSet = getSELECTEDDepartments($str_dbconnect,$id);
        while($_myrowRes = mysqli_fetch_array($_DepartmentSet)) {
            $id = $_myrowRes['GrpCode'];
            $data = $_myrowRes['Group'];   
			 if($id== $deptId) {
			 	echo '<option value="'.$id.'" selected>'.$data.'</option>';
			 }
			 else{         
            	echo '<option value="'.$id.'">'.$data.'</option>';	   //'if($id== $deptId) { echo "selected='selected'"; }'	
			 }	 
        }
    }
	
	if(isset($_POST['usertypelist']) && $_POST['usertypelist'] == "select"){
         
        $UserCode    = $_POST['usercode'];
       
         
        $_SelectQuery 	=   "SELECT * FROM tbl_wfusertypes WHERE `catstatus` = 'A' AND Wf_User = '$UserCode'";		
		$_DepartmentSet = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
		while($_myrowRes = mysqli_fetch_array($_DepartmentSet)) {
            $id = $_myrowRes['id'];
            $data = $_myrowRes['Description'];            
            echo '<option value="'.$id.'" >'.$data.'</option>';
        }      
         
     }
	 
	 if(isset($_POST['WFUserOld']) && $_POST['WFUserOld'] == "select"){
         
        $ActiveUser     = $_POST['ActiveUser'];
        $InactiveUser   = $_POST['InactiveUser'];
        
		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = '$ActiveUser' OR EmpSts = '$InactiveUser'" or die(mysqli_error($str_dbconnect));			
		$_DepartmentSet = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
		while($_myrowRes = mysqli_fetch_array($_DepartmentSet)) {  
			echo "<option value='".$_myrowRes['EmpCode']."'>".$_myrowRes['FirstName']." ".$_myrowRes['LastName']."</option>";			
        }      
         
     }
    
    if(isset($_POST['selectUser'])){
        $_UserName = "";
        
        $id=$_POST['selectUser'];
        $_UserName = $_POST['UserName'];
        
        $FacCode = $_SESSION["Str_WKID"];        
        
        $_SelectQuery 	= "INSERT INTO tbl_wfalert (`FacCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$FacCode', '$id', '$_UserName', 'A')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $_SelectQuery 	= "SELECT * FROM tbl_wfalert WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            $id = $_myrowRes['EmpCode'];
            $data = $_myrowRes['UserName'];            
            echo '<option value="'.$id.'">'.$data.'</option>';
        }
        
    }
    
    if(isset($_POST['removeUser'])){
        
        $_UserName = "";        
        $id=$_POST['removeUser'];
        
        $FacCode = $_SESSION["Str_WKID"];        
        
        $_SelectQuery 	= "DELETE FROM tbl_wfalert WHERE FacCode = '$FacCode' AND EmpCode = '$id'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        $_delete_recodes = "delete from tbl_workflow where wk_id = '$FacCode'";
		mysqli_query($str_dbconnect,$_delete_recodes) or die(mysqli_error($str_dbconnect));
		$_delete_work_flow = "delete from tbl_workflowupdate where wk_id ='$FacCode'";
		mysqli_query($str_dbconnect,$_delete_work_flow) or die(mysqli_error($str_dbconnect));
        $_SelectQuery 	= "SELECT * FROM tbl_wfalert WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            $id = $_myrowRes['EmpCode'];
            $data = $_myrowRes['UserName'];            
            echo '<option value="'.$id.'">'.$data.'</option>';
        }
        
    }
    

    if(isset($_POST['getselectedWfalertpersons'])){
        $_UserName = "";
        $id=$_POST['getselectedWfalertpersons'];
        // alert($_Owner);
        $FacCode = $_SESSION["Str_WKID"];  
        
        $_SelectQuery 	= "SELECT * FROM tbl_wfalert WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            $id = $_myrowRes['EmpCode'];
            $data = $_myrowRes['UserName'];            
            echo '<option value="'.$id.'">'.$data.'</option>';
        }
    }

    if(isset($_POST['selectcoveringUser'])){
        $_UserName = "";
        $isvalid=true;
        $id=$_POST['selectcoveringUser'];
        $_UserName = $_POST['UserName'];
        $_Owner = $_POST['Owner'];
        $FacCode = $_SESSION["Str_WKID"];  
        

        $_SelectQuery 	= "SELECT * FROM tbl_wfcoveringperson WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            if($id==$_myrowRes['EmpCode'])     {
                $isvalid=false;
            }           
        } 

        if($id==$_Owner){   
            $isvalid=false; 
        }

        $_SelectQuery11   =  "SELECT * FROM tbl_workflow WHERE `wk_id` = '$FacCode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet      =  mysqli_query($str_dbconnect,$_SelectQuery11) or die(mysqli_error($str_dbconnect));
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            if($id==$_myrowRes['wk_Owner']){
            
                $isvalid=false; 
            }
        }
       
        if($isvalid){
            $_SelectQuery 	= "INSERT INTO tbl_wfcoveringperson (`FacCode`, `EmpCode`, `UserName`, `GrpCode`) VALUES ('$FacCode', '$id', '$_UserName', 'A')" or die(mysqli_error($str_dbconnect));
            mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));            
        }  

        $_SelectQuery 	= "SELECT * FROM tbl_wfcoveringperson WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
            $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
                
            while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
                $id = $_myrowRes['EmpCode'];
                $data = $_myrowRes['UserName'];            
                echo '<option value="'.$id.'">'.$data.'</option>';
            } 
    }

    if(isset($_POST['removecoveringUser'])){
        echo '<script>console.log("Your stuff here")</script>';
        $_UserName = "";        
        $id=$_POST['removecoveringUser'];
        
        $FacCode = $_SESSION["Str_WKID"];        
        
        $_SelectQuery 	= "DELETE FROM tbl_wfcoveringperson WHERE FacCode = '$FacCode' AND EmpCode = '$id'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        $_SelectQuery 	= "SELECT * FROM tbl_wfcoveringperson WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            $id = $_myrowRes['EmpCode'];
            $data = $_myrowRes['UserName'];            
            echo '<option value="'.$id.'">'.$data.'</option>';
        }
        
    }

    if(isset($_POST['getselectedcovpersons'])){
        $_UserName = "";
        $id=$_POST['getselectedcovpersons'];
        // alert($_Owner);
        $FacCode = $_SESSION["Str_WKID"];  
        
        $_SelectQuery 	= "SELECT * FROM tbl_wfcoveringperson WHERE FacCode = '$FacCode'" or die(mysqli_error($str_dbconnect));
            $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
                
            while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
                $id = $_myrowRes['EmpCode'];
                $data = $_myrowRes['UserName'];            
                echo '<option value="'.$id.'">'.$data.'</option>';
            } 
    }

    if(isset($_POST['refresh'])){
        
        
    }
    
    if(isset($_POST['wfuser'])){
        
        $id=$_POST['wfuser'];       
        gettable($str_dbconnect,$id);
        
        /*echo "<link type=\"text/css\" href=\"../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css\" rel=\"stylesheet\" />";	
        echo "<script type=\"text/javascript\" src=\"../jQuerry/js/jquery-1.6.2.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"../jQuerry/js/jquery-ui-1.8.16.custom.min.js\"></script>";
        
        echo "<link rel=\"stylesheet\" href=\"css/slider.css\" type=\"text/css\"/>";
        echo "<link href=\"css/textstyles.css\" rel=\"stylesheet\" type=\"text/css\"/>";
        
        echo "<style type=\"text/css\" title=\"currentStyle\">";
        echo "@import \"../media/css/demo_page.css\";";
        echo "@import \"../media/css/demo_table.css\";";
        echo "</style>";    
        echo "<script type=\"text/javascript\" language=\"javascript\" src=\"../media/js/jquery.dataTables.js\"></script>";*/        
       
    }
	
    if(isset($_POST['wfOner'])){
        $id=$_POST['wfOner'];       
        gettableByOwner($str_dbconnect,$id);     
    }
    
	function gettable($str_dbconnect,$id){
		 echo "<script type=\"text/javascript\" language=\"javascript\">";
        echo "$(document).ready(function() {";
        echo "    $('#example10').dataTable();";
        echo "} );";
        echo "</script>"; 
        
        echo "<table width='100%' class='display' id='example10' cellpadding='0' cellspacing='0' border='0'>";
        echo "<thead >";
        echo "<tr>";
            echo "<th >Id</th>";
            echo "<th >Task Name</th>";
            echo "<th   align='center'>Schedule</th>";
			echo "<th   align='center'>Scheduled Time</th>";
            echo "<th   align='center'>Day</th>";
            echo "<th   align='center'>Edit</th>";
            echo "<th   align='center'>Delete</th>";                               
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        
        $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$id' order by wk_id";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $CurrentProCode =   "";
        $ColourCode = 0 ;
        $LoopCount = 0;
        $WorkFlowid = 0;
        //$id = 0;
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            if ($ColourCode == 0 ) {
                $Class = "even gradeA" ;
                $ColourCode = 1 ;
            } elseif ($ColourCode == 1 ) {
                $Class = "odd gradeA";
                $ColourCode = 0;
            }
            $WorkFlowid = $_myrowRes['wk_id'];
            echo "<tr class='".$Class."'>";
                echo "<td>".$_myrowRes['wk_id']."</td>";
                echo "<td align='left'>".$_myrowRes['wk_name']."<br/>";
				$_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
	            $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
	            
	            $num_rows = mysqli_num_rows($_ResultSetq);
	            if($num_rows > 0){
	                /*echo "<tr class='".$Class."'>";*/
	                    /*echo "<td ><b>Attachments :</b></td>";
	                    echo "<td colspan='5'>";*/
	                        while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
	                            echo "<a href='files/".$_myrowResq['FileName']."'>".$_myrowResq['FileName']."</a> ";                           
	                        }
	                    /*echo "</td>";
	                echo "</tr>";  */
	            }
				echo "</td>";
                echo "<td align='center'>".$_myrowRes['schedule']."</td>";
				echo "<td align='center'>".$_myrowRes['start_time']." - ".$_myrowRes['end_time']."</td>";
                if($_myrowRes['schedule'] != "Daily"){
                    echo "<td align='center'>".$_myrowRes['sched_time']."</td>";
                }else{
                    echo "<td align='center'>-</td>";
                }            

                echo "<td align=\"center\"><input type=\"button\" value=\" Edit \" onclick=\"OpenEditWindow('".$WorkFlowid."', '".$id."');\"/></td>";         
				echo "<td align=\"center\"><input type=\"checkbox\" id=\" delall[]\" name=\" delall[]\" value='".$_myrowRes['wk_id']."'\" /></td>";                
            echo "</tr>";             
            
        }
        echo "<td align=\"center\"><input type=\"button\" id=\" delche\" name=\" delche\" value=\"Delete\" onClick=\" delcheck('".$WorkFlowid."', '".$id."')\"/></td>";
        echo "</tbody>";
        echo "</table>";
		
	}
    

    function gettableByOwner($str_dbconnect,$id){
        echo "<script type=\"text/javascript\" language=\"javascript\">";
       echo "$(document).ready(function() {";
       echo "    $('#example10').dataTable();";
       echo "} );";
       echo "</script>"; 
       
       echo "<table width='100%' class='display' id='example10' cellpadding='0' cellspacing='0' border='0'>";
       echo "<thead >";
       echo "<tr>";
           echo "<th >Id</th>";
           echo "<th >Task Name</th>";
           echo "<th   align='center'>Schedule</th>";
           echo "<th   align='center'>Scheduled Time</th>";
           echo "<th   align='center'>Day</th>";
           echo "<th   align='center'>Reported Owner</th>";                       
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";
       
       
       $_SelectQuery 	=   "SELECT * FROM tbl_workflow WHERE `wk_Owner` = '$id' order by wk_id";       
       $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
       
       $CurrentProCode =   "";
       $ColourCode = 0 ;
       $LoopCount = 0;
       $WorkFlowid = 0;
       //$id = 0;
       
       while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
           if ($ColourCode == 0 ) {
               $Class = "even gradeA" ;
               $ColourCode = 1 ;
           } elseif ($ColourCode == 1 ) {
               $Class = "odd gradeA";
               $ColourCode = 0;
           }
           $WorkFlowid = $_myrowRes['wk_id'];
           echo "<tr class='".$Class."'>";
               echo "<td>".$_myrowRes['wk_id']."</td>";
               echo "<td align='left'>".$_myrowRes['wk_name']."<br/>";
               $_SelectQueryq   =   "SELECT * FROM prodocumets WHERE `ParaCode` = '$WorkFlowid'";
               $_ResultSetq 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
               
               $num_rows = mysqli_num_rows($_ResultSetq);
               if($num_rows > 0){
                           while($_myrowResq = mysqli_fetch_array($_ResultSetq)) {                
                               echo "<a href='files/".$_myrowResq['FileName']."'>".$_myrowResq['FileName']."</a>  ";                           
                           }
               }
               echo "</td>";
               echo "<td align='center'>".$_myrowRes['schedule']."</td>";
               echo "<td align='center'>".$_myrowRes['start_time']." - ".$_myrowRes['end_time']."</td>";
               if($_myrowRes['schedule'] != "Daily"){
                   echo "<td align='center'>".$_myrowRes['sched_time']."</td>";
               }else{
                   echo "<td align='center'>-</td>";
               }            

               $_SelectQueryq   =   "SELECT * FROM tbl_employee WHERE `EmpCode` = '".$_myrowRes['report_owner']."' ";

               $_ResultSetE 	=   mysqli_query($str_dbconnect,$_SelectQueryq) or die(mysqli_error($str_dbconnect));
              
               $num_rows = mysqli_num_rows($_ResultSetE);
               if($num_rows > 0){
                
                           while($_myrowResq = mysqli_fetch_array($_ResultSetE)) {               
                            echo "<td align='center'>".$_myrowResq['FirstName']."  ".$_myrowResq['LastName']." </td>";                  
                           }
               }
                              
           echo "</tr>";             
           
       }
     
       echo "</tbody>";
       echo "</table>";
       
   }
   
     if(isset($_POST['delcheck'])){        
       
			$che=$_POST['delcheck'];
			$wk_Owner=$_POST['wk_Owner'];			
			$_SelectQuerydel  ="DELETE FROM tbl_workflow WHERE wk_id = '$che' AND `wk_Owner` = '$wk_Owner' ";
    		mysqli_query($str_dbconnect,$_SelectQuerydel) or die(mysqli_error($str_dbconnect));
			$_delete_w = "DELETE FROM tbl_workflowupdate  where wk_id = '$che' " ;
				mysqli_query($str_dbconnect,$_delete_w);
}

if(isset($_POST['wname'])){
        
        $id=$_POST['wname'];       
   		gettable($str_dbconnect,$id);       
    }
    
		
	
    
    if(isset($_POST['cmd']) && $_POST['cmd'] == "get"){
        
        $count = 0;
        
        echo "<link type=\"text/css\" href=\"../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css\" rel=\"stylesheet\" />";	
        echo "<script type=\"text/javascript\" src=\"../jQuerry/js/jquery-1.6.2.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"../jQuerry/js/jquery-ui-1.8.16.custom.min.js\"></script>";
        
        echo "<link rel=\"stylesheet\" href=\"css/slider.css\" type=\"text/css\"/>";
        echo "<link href=\"css/textstyles.css\" rel=\"stylesheet\" type=\"text/css\"/>";
        
        echo "<style type=\"text/css\" title=\"currentStyle\">";
        echo "@import \"../media/css/demo_page.css\";";
        echo "@import \"../media/css/demo_table.css\";";
        echo "</style>";    
        echo "<script type=\"text/javascript\" language=\"javascript\" src=\"../media/js/jquery.dataTables.js\"></script>";
        
        echo "<script type=\"text/javascript\" language=\"javascript\">";
        echo "$(document).ready(function() {";
        echo "    $('#example10').dataTable();";
        echo "} );";
        echo "</script>"; 
        
        echo "<table width='100%' class='display' id='example10' cellpadding='0' cellspacing='0' border='0'>";
        echo "<thead>";
        echo "<tr >";
            echo "<th >No</th>";
            echo "<th >Equipment Id</th>";
            echo "<th >Equipment Name</th>";       
            echo "<th ></th>"; 
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_Equipments WHERE `status` = 'A'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $CurrentProCode =   "";
        $ColourCode = 0 ;
        $LoopCount = 0;
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            if ($ColourCode == 0 ) {
                $Class = "even gradeA" ;
                $ColourCode = 1 ;
            } elseif ($ColourCode == 1 ) {
                $Class = "odd gradeA";
                $ColourCode = 0;
            }
            $count = $count + 1;
            echo "<tr id='".$_myrowRes['eq_code']."' class='".$Class."'>";
                echo "<td >".$count."</td>";
                echo "<td >".$_myrowRes['eq_code']."</td>";
                echo "<td >".$_myrowRes['eq_name']."</td>";
                echo "<td style='cursor: pointer' align='center'><img src='../images/close.png' /></td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
    }
    
	if(isset($_POST['usertype']) && $_POST['usertype'] == "get"){
        
        $count = 0;
		$UserCode    = $_POST['usercode'];
        
		
		
        echo "<link type=\"text/css\" href=\"../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css\" rel=\"stylesheet\" />";	
        echo "<script type=\"text/javascript\" src=\"../jQuerry/js/jquery-1.6.2.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"../jQuerry/js/jquery-ui-1.8.16.custom.min.js\"></script>";
        
        echo "<link rel=\"stylesheet\" href=\"css/slider.css\" type=\"text/css\"/>";
        echo "<link href=\"css/textstyles.css\" rel=\"stylesheet\" type=\"text/css\"/>";
        
        echo "<style type=\"text/css\" title=\"currentStyle\">";
        echo "@import \"../media/css/demo_page.css\";";
        echo "@import \"../media/css/demo_table.css\";";
        echo "</style>";    
        echo "<script type=\"text/javascript\" language=\"javascript\" src=\"../media/js/jquery.dataTables.js\"></script>";
        
        echo "<script type=\"text/javascript\" language=\"javascript\">";
        echo "$(document).ready(function() {";
        echo "    $('#example10').dataTable();";
        echo "} );";
        echo "</script>"; 
        
        echo "<table width='100%' class='display' id='example10' cellpadding='0' cellspacing='0' border='0'>";
        echo "<thead>";
        echo "<tr >";
            echo "<th >No</th>";            
            echo "<th >Decription</th>";       
            echo "<th ></th>"; 
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_wfusertypes WHERE `catstatus` = 'A' AND `Wf_User` = '$UserCode'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $CurrentProCode =   "";
        $ColourCode = 0 ;
        $LoopCount = 0;
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            if ($ColourCode == 0 ) {
                $Class = "even gradeA" ;
                $ColourCode = 1 ;
            } elseif ($ColourCode == 1 ) {
                $Class = "odd gradeA";
                $ColourCode = 0;
            }
			$userid = $_myrowRes['Wf_User'];
			$des =$_myrowRes['Description'];
			
            $count = $count + 1;
            echo "<tr id='".$_myrowRes['id']."' class='".$Class."'>";
                echo "<td >".$count."</td>";
                /*echo "<td >".$_myrowRes['eq_code']."</td>";*/
                echo "<td >".$_myrowRes['Description']."</td>";
                echo "<td align=\"center\"><input type=\"button\" value=\" Delete \" class=\"buttonView\" onclick=\"DeleteUserstatus('".$userid."','".$des."');\"/></td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
    }
    
     if(isset($_POST['cmd']) && $_POST['cmd'] == "insert"){
         
        $eq_code    = $_POST['eqid'];
        $eq_name    = $_POST['eqtype'];
         
        $_SelectQuery 	=   "INSERT INTO tbl_Equipments (`eq_code` , `eq_name` , `status` )
                                            VALUES ('$eq_code','$eq_name','A')";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));        
         
     }
	 
	 if(isset($_POST['usertype']) && $_POST['usertype'] == "insert"){
         
        $UserCode    = $_POST['usercode'];
        $Desc    = $_POST['desc'];
         
        $_SelectQuery 	=   "INSERT INTO tbl_wfusertypes (`Wf_User` , `Description` , `catstatus` )
                                            VALUES ('$UserCode','$Desc','A')";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));        
         
     }
	 
	 if(isset($_POST['usertype']) && $_POST['usertype'] == "del"){
         
        $UserCode    = $_POST['usercode'];
        $Desc    = $_POST['descode'];
         
        $_SelectQuery 	=   "delete from tbl_wfusertypes WHERE `Wf_User` = '$UserCode' AND `Description`='$Desc' AND `catstatus`='A'";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));        
         
     }
	 
	 
	 if(isset($_POST['wftaskmcat']) && $_POST['wftaskmcat'] != ""){
        $Code    = $_POST['wftaskid'];
        $Cat     = $_POST['wftaskmcat'];
         
        $_SelectQuery 	=   "UPDATE tbl_workflow SET `WFUser_cat` = '$Cat' WHERE `wk_id` = '$Code'";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); 
		
		echo "Details Updated Successfully";      
         
     }
      
     
     if(isset($_POST['Mtcmd']) && $_POST['Mtcmd'] == "get"){
        
        $count = 0;
        $id=$_POST['mtid'];       
        
        echo "<table  class='table' border='1px'>";
        echo "<thead class='ui-widget-header ui-corner-all'>";
        echo "<tr >";
            echo "<th >No</th>";
            echo "<th >Mt. Id</th>";
            echo "<th >Maintenance Type</th>";  
            echo "<th >Category</th>";  
            echo "<th >Schedule</th>"; 
            echo "<th >Start Time</th>";
            echo "<th >End Time</th>";  
            echo "<th ></th>"; 
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_eqMList WHERE `status` = 'A' AND eq_id = '$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $count = $count + 1;
            echo "<tr id='".$_myrowRes['eq_id']."' class='ui-widget-content ui-corner-all'>";
                echo "<td >".$count."</td>";
                echo "<td >".$_myrowRes['mt_id']."</td>";
                echo "<td >".$_myrowRes['mt_type']."</td>";
                echo "<td >".getwfcatogorybyName($str_dbconnect,$_myrowRes['catcode'])."</td>";
                echo "<td align='center' >".$_myrowRes['Schedule']."</td>";
                echo "<td align='center' >".$_myrowRes['TimeStart']."</td>";
                echo "<td align='center' >".$_myrowRes['TimeEnd']."</td>";
                echo "<td style=\"cursor: pointer\" align=\"center\"><img src=\"../images/close.png\" onclick=\"deleteMT('".$_myrowRes['eq_id']."','".$_myrowRes['mt_id']."');\"/></td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
    }
    
    function GetEquipmentType($EqID, $MID){
        
        $MTNAME = "";
        
        $_SelectQuery 	=   "SELECT * FROM tbl_eqMList WHERE `status` = 'A' AND eq_id = '$EqID' AND `mt_id` = '$MID'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $MTNAME = $_myrowRes['mt_type'];
        }
        
        return $MTNAME;
    }
    
    if(isset($_POST['Mtcmd']) && $_POST['Mtcmd'] == "insert"){
         
        $eq_code    = $_POST['eqid'];
        $mt_code    = $_POST['mttid'];
        $mt_name    = $_POST['mttype'];
        $mtSced     = $_POST['mtSced'];
        $mtStart    = $_POST['mtStart'];
        $mtEnd      = $_POST['mtEnd'];
        $wfcat      = $_POST['wfcat'];
         
        $_SelectQuery 	=   "INSERT INTO tbl_eqmlist (`eq_id`, `mt_id` , `mt_type` , `Schedule`, `TimeStart`, `TimeEnd`, `status`, `catcode` )
                                            VALUES ('$eq_code','$mt_code', '$mt_name', '$mtSced', '$mtStart', '$mtEnd', 'A', '$wfcat')";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));        
         
     }
     
     if(isset($_POST['Mtcmd']) && $_POST['Mtcmd'] == "delete"){
         
        $eq_code    = $_POST['eqid'];
        $mt_code    = $_POST['mttid'];        
         
        $_SelectQuery 	=   "UPDATE tbl_eqmlist SET `status` = 'D'  WHERE  `eq_id` = '$eq_code' AND `mt_id` = '$mt_code'";
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));        
         
     }
     
     if(isset($_POST['Sccmd']) && $_POST['Sccmd'] == "load"){
        $id=$_POST['mtid'];       
        
        $_SelectQuery 	=   "SELECT * FROM tbl_eqMList WHERE `status` = 'A' AND eq_id = '$id'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $id     = $_myrowRes['mt_id'];
            $data   = $_myrowRes['mt_type'];        
             echo '<option value="'.$id.'">'.$data.'</option>';
            
        }       
        
    }
    
    if(isset($_POST['Schcmd']) && $_POST['Schcmd'] == "insert"){
        
        $eqid       = $_POST['eqid'];
        /*$mttid      = $_POST['mttid'];
        $wfdate     = $_POST['wfdate'];
        $starttime  = $_POST['starttime'];
        $endtime    = $_POST['endtime'];
        $emp        = $_POST['emp'];*/
        
        $pieces = explode("@", $eqid);
        
        
        foreach ($pieces as &$value) {
            
            $count = 0;
            $EQ_Serial = "";

            $EQ_Serial = get_TempSerial($str_dbconnect,"1053", "EQ_Serial");
            $EQ_Serial = "EQ/". $EQ_Serial;
        
            $datavalue = explode("/", $value);
            
            $eq_code = $datavalue[0];
            $mt_code = $datavalue[1];
            
            $_SelectQuery66 	=   "SELECT * FROM tbl_eqmlist WHERE  `eq_id` = '$eq_code' AND `mt_id` = '$mt_code'";
            $_ResultSet66 = mysqli_query($str_dbconnect,$_SelectQuery66) or die(mysqli_error($str_dbconnect)); 
            
            while($_myrowRes66 = mysqli_fetch_array($_ResultSet66)) {            
                $starttime     = $_myrowRes66['TimeStart'];
                $endtime   = $_myrowRes66['TimeEnd'];
                $wfcat      = $_myrowRes66['catcode'];
            }  
            
            $_SelectQuery 	=   "INSERT INTO tbl_wkequip (`eq_id`, `eq_type`, `wf_date`, `start_time`, `end_time`, `wf_emp`, `status`, `eq_ser`, `catcode`)
                VALUES ('$datavalue[0]', '$datavalue[1]', '$datavalue[2]', '$starttime', '$endtime', '', 'A', '$EQ_Serial', '$wfcat')";
            $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
            
        }
        /*
        $_SelectQuery 	=   "INSERT INTO tbl_wkequip (`eq_id`, `eq_type`, `wf_date`, `start_time`, `end_time`, `wf_emp`, `status`, `eq_ser`)
                VALUES ('$eqid', '$mttid', '$wfdate', '$starttime', '$endtime', '$emp', 'A', '$EQ_Serial')";
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));*/
        
    }
    
    function AddDate ($date){
        //$date = "1998-08-14";
        $newdate = strtotime ( '+1 day' , strtotime ( $date ) ) ;
        $newdate = date ( 'Y-m-d' , $newdate );
        return $newdate;
    }
    
    if(isset($_POST['Schcmd']) && $_POST['Schcmd'] == "load"){
        
        $eqid       = $_POST['eqid'];
        //$mttid      = $_POST['mttid'];        
        $date1      = $_POST['Fromdate'];
        $date2      = $_POST['Todate']; 

        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
        $_SelectQuery 	=   "SELECT * FROM tbl_eqMList WHERE `status` = 'A' AND eq_id = '$eqid'";       
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $days = $days + 1;
        
        echo "<table  class='table' width='100%' style='border-bottom: 0px; border-left: 0px; border-right: 0px; border-top: 0px; padding: 0 0 0 0px'>";
        echo "<thead class='ui-widget-header ui-corner-all'>";
        echo "<tr >";
            echo "<th >No</th>";
            echo "<th colspan='".$days."' align='left'>Details</th>";
        echo "</tr>";            
        echo "</thead>";
        echo "<tbody>";  
        
        $count = 0;    
       
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            
            $count = $count + 1;
            echo "<tr class='ui-widget-content ui-corner-all'>";
                echo "<td >".$count."</td>";
                echo "<td colspan='".$days."' align='left'>";
                echo $_myrowRes['mt_type'];               
                echo " <b> - ".$_myrowRes['Schedule']."</b>";
                echo "</td>";
            echo "</tr>";
            echo "<tr class='ui-widget-content ui-corner-all' colspan='".$days."'>";
            $i=1;
            $NewDate = $date1;
            echo "<td></td>";
            while($i <= $days)
            {
                if($i == "1"){
                    $NewDate;
                }else{
                    $NewDate = AddDate($NewDate);
                }                        
                //substr($NewDate,-2,2)
                echo "<td >";
                echo substr($NewDate,-2,2);
                echo "</br>";
                //echo date($NewDate,'l');
                echo "<Font color='Red'>".date('D',strtotime($NewDate))."</Font>";
                echo "</br>";
                echo "<input type=\"checkbox\" id= \"".$_myrowRes['eq_id'].$_myrowRes['mt_id'].$NewDate."\" name= \"".$_myrowRes['eq_id'].$_myrowRes['mt_id'].$NewDate."\" onclick=\"checkbox('".$_myrowRes['eq_id']."','".$_myrowRes['mt_id']."','".$NewDate."');\"></input>";
                echo "</td>";
                //echo "The number is " . $i . "<br />";
              $i++;
            }    
            echo "</tr>";
        }
        
        $TotCol = $days + 1;
        
        echo "<tr class='ui-widget-content ui-corner-all' >";
        echo "<td colspan='".$TotCol."'>***</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</Br>";
        echo "</Br>";      
        
        
        $CurrentMonth = date('n',strtotime($date1));
        $MonthDiffer = 12 - $CurrentMonth;
        
        $i = $CurrentMonth + 1;        
        $array = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
        
        echo "<table  class='table' border='0' width='100%' style='border-bottom: 0px; border-left: 0px; border-right: 0px; border-top: 0px; padding: 0 0 0 0px'>";
        echo "<thead class='ui-widget-header ui-corner-all'>";
        echo "<tr>";
            echo "<th  colspan='".$MonthDiffer."'>Replicate Above Shedule to Following Months</th>";            
        echo "</tr>";            
        echo "</thead>";
        echo "<tbody>";  
        
        echo "<tr class='ui-widget-content ui-corner-all'>";
        while($i <= 12){
            
           echo "<td>";
                echo $array[$i - 1];
                echo "</Br>";
                if(isset($_myrowRes['eq_id'],$_myrowRes['eq_id'],$_myrowRes['mt_id'],$_myrowRes['eq_id'],$_myrowRes['mt_id'])){
                    echo "<input type=\"checkbox\" id= \"".$_myrowRes['eq_id'].$_myrowRes['mt_id']."@".$i."\" name= \"".$_myrowRes['eq_id'].$_myrowRes['mt_id']."@".$i."\" onclick=\"checkboxR('".$_myrowRes['eq_id']."','".$_myrowRes['mt_id']."','"."@".$i."');\"></input>"; 
                }             
           echo "</td>";           
        
            $i++;
        } 
        echo "</tr>";
        echo "<tr>";
            echo "<td class='ui-widget-content ui-corner-all'  colspan='".$MonthDiffer."'>***</th>";            
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</Br>";
        echo "</Br>";
    }
    
    if(isset($_POST['Schcmd']) && $_POST['Schcmd'] == "loadEmpData"){
        
        
        $datasetvalue = "";
        $eqid       = $_POST['eqid'];/*
        $mttid      = $_POST['mttid'];
        $wfdate     = $_POST['wfdate'];
        $starttime  = $_POST['starttime'];
        $endtime    = $_POST['endtime'];
        $emp        = $_POST['emp'];*/
        $Fromdate   = $_POST['Fromdate'];
        $Todate     = $_POST['Todate'];        
        
        echo "<table  class='table' border='1px'>";
        echo "<thead class='ui-widget-header ui-corner-all'>";
        echo "<tr >";
            echo "<th >No</th>";
            echo "<th >Date</th>";
            echo "<th >Start Time</th>";     
            echo "<th >End Time</th>";  
            echo "<th >Employee</th>";    
            echo "<th ></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        /*'AND eq_type = '$mttid' '*/
        
        $_SelectQuery 	=   "SELECT * FROM tbl_wkequip WHERE eq_id = '$eqid' AND wf_date >= '".$Fromdate."' AND wf_date <= '".$Todate."'  ORDER BY wf_date, start_time";
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        $count = 0;
        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $count = $count + 1;
            $datasetvalue .= $_myrowRes['eq_ser']."@";
            echo "<tr class='ui-widget-content ui-corner-all'>";                
                echo "<td >".$count."</td>";  
                echo "<td colspan='5' align='left'>".GetEquipmentType($_myrowRes['eq_id'], $_myrowRes['eq_type'])."</td>";  
            echo "</tr>";
            echo "<tr class='ui-widget-content ui-corner-all'>";
                echo "<td ></td>"; 
                echo "<td >".$_myrowRes['wf_date']."</td>";
                echo "<td >".$_myrowRes['start_time']."</td>";
                echo "<td >".$_myrowRes['end_time']."</td>";
                echo "<td align='left' style='padding-left:5px;'>";
                    echo "<select id='".$_myrowRes['eq_ser']."' name='".$_myrowRes['eq_ser']."' class='Div-TxtStyleNormal'>";  
                    echo "<option value='Please'>Please Select</option>";
                    $_ResultSet5 = getEMPLOYEEDETAILS($str_dbconnect) ;
                    while($_myrowRes5 = mysqli_fetch_array($_ResultSet5)) {                                
                        echo "<option value='".$_myrowRes5['EmpCode']."'";
                        if($_myrowRes5['EmpCode'] == $_myrowRes['wf_emp']){echo "selected='selected'";}
                        echo ">".$_myrowRes5['FirstName'].' '.$_myrowRes5['LastName']."</option>";                               
                    } 
                    echo "</select>";
                    //echo getSELECTEDEMPLOYEFIRSTNAME($str_dbconnect,$_myrowRes['wf_emp']);
                echo "</td>";
                echo "<td  style='cursor: pointer' align='center'><img src='../images/close.png' /></td>";
            echo "</tr>";
            
        }
        echo "<input type=\"hidden\" id=\"dataSet\" name=\"dataSet\" value=\"".$datasetvalue."\" size='100'>";
        echo "</tbody>";
        echo "</table>";
       
    }
    
     if(isset($_POST['Schcmd']) && $_POST['Schcmd'] == "updatewf"){
         
         $wfid       = $_POST['wfid'];
         $empcode    = $_POST['empcode'];
         
         $_SelectQuery 	=   "UPDATE tbl_wkequip SET `wf_emp` = '$empcode' WHERE `eq_ser` = '$wfid'";                
         mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
         
     }
?>