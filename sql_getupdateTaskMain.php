<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sql_task
 *
 * @author Prajapriya
 */
 	include("../connection/sqlconnection.php"); //  connection file to the mysql database    
   // include ("sql_crtprocat.php");            //  connection file to the mysql database
   // include ("sql_empdetails.php"); //  connection file to the mysql database
   // include ("sql_wkflow.php"); //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
  
class sql_getupdateTaskMain {
    //put your code here
}

if(isset($_POST["taskdata"])){    
        
		$tid = $_POST["taskdata"];
		$eid=$_POST["empdata"];
		$Dte_StartDate  = $_POST["todaydata"];
		$uu = $_POST["loguserdata"];		
		$_SelectQuery 	= "UPDATE tbl_impedimenttask set `im_status`='C' WHERE EmpCode = '$eid' and TaskCode='$tid'" or die(mysqli_error($str_dbconnect));
        $_result = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
      	if (1==$_result){
		 
		  $us=0;
		  	$_SelectQuery 	= "SELECT * FROM tbl_impedimenttask WHERE TaskCode='$tid' and `im_status`='P' " or die(mysqli_error($str_dbconnect));
        	$_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));             
       		 while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
           	 $us=1;           
        	}
			if(1==$us){
				$_SelectQuery 	= "UPDATE tbl_taskupdates set `up_status`='Close' WHERE taskcode='$tid' and `category`='Impediment'" or die(mysqli_error($str_dbconnect));
        		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
			}
		   echo "1";
	  }      
	  else{
		  echo "0";
	  }
}

if(isset($_POST["selectUser"])){
        
        $Dte_StartDate  = date("Y-m-d");
        $id=$_POST["selectUser"];
		$tid = $_POST["task"];
		$uu = $_POST["loguser"];
		
		
		
		$_SelectQuery 	= "SELECT FirstName,LastName FROM tbl_employee WHERE EmpCode = '$id'" or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            $user = $_myrowRes['FirstName']." ".$_myrowRes['LastName'];           
        }
		$_SelectQuery 	= 	"INSERT INTO tbl_impedimenttask (`TaskCode`, `EmpCode`, `UserName`,`im_status`,`create_date`,`created_by`) VALUES ('$tid', '$id', '$user','P','$Dte_StartDate','$uu')" or die(mysqli_error($str_dbconnect));

		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));      
        
       
        $_SelectQuery 	= "SELECT * FROM tbl_impedimenttask WHERE TaskCode='$tid' and im_status='P' " or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            $id = $_myrowRes['EmpCode'];
            $data = $_myrowRes['UserName'];            
            echo '<option value="'.$id.'">'.$data.'</option>';
        }
		//echo $id."".$tid;
        
   }
   
   
   if(isset($_POST['removeUser'])){
        
            
        $id=$_POST['removeUser'];
		$tid = $_POST["task"];       
        $_SelectQuery 	= "DELETE FROM tbl_impedimenttask WHERE EmpCode = '$id' and TaskCode='$tid' and im_status='P'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
        
        $_SelectQuery 	= "SELECT * FROM tbl_impedimenttask WHERE TaskCode='$tid' and im_status='P'" or die(mysqli_error($str_dbconnect));
        $_FacilityUSERS = mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
             
        while ($_myrowRes = mysqli_fetch_array($_FacilityUSERS)) {        
            $id = $_myrowRes['EmpCode'];
            $data = $_myrowRes['UserName'];            
            echo '<option value="'.$id.'">'.$data.'</option>';
        }
        
    }
	
	
	 function getSELECTEDEMPLOYEFIRSTNAMEIMPEDIMENT($str_dbconnect,$_TaskCode) {

        $_SelectQuery 	=   "SELECT UserName FROM tbl_impedimenttask WHERE `TaskCode` = '$_TaskCode' and im_status='P'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$_EmpName = "";
		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName  .=  $_myrowRes['UserName'].',';
        }
        return $_EmpName ;

    }
	
	function getImpedimentEMPLOYEESMAIL($str_dbconnect,$Str_TaskCode) {

	 $_SelectQuery 	=   "SELECT EmpCode FROM tbl_impedimenttask WHERE `TaskCode` = '$Str_TaskCode' and im_status='P'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpCode  = $_myrowRes['EmpCode'];
			$_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$_EmpCode'" or die(mysqli_error($str_dbconnect));
   			 $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    		$_MailAdd   =   "";    
			while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
				$_MailAdd    =   $_MailAdd.";".$_myrowRes['EMail'];
			}
			
        } 
		$_MailAdd2='nilupulse@gmail.com'.','.'harshadilupkumara.kumara@gmail.com'.','.'thilina.dtr@gmail.com';
		$_MailAdd3="harshadilupkumara.kumara@gmail.com";
		$_MailAdd4="thilina.dtr@gmail.com";
     $_MailAdd1= $_MailAdd2.",".$_MailAdd3.",".$_MailAdd4;
return $_MailAdd2;
}

function get_impedimentDetails($str_dbconnect,$Str_EmpCode) {
		
	 $_SelectQuery 	=   "SELECT distinct * FROM tbl_impedimenttask WHERE `EmpCode` = '$Str_EmpCode' and im_status='P' group by TaskCode " or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		
return $_ResultSet;
}

function getTASKUSERS123($str_dbconnect,$_FacCode) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpCode NOT IN (SELECT EmpCode FROM tbl_taskowners WHERE TaskCode = '$_FacCode') order by FirstName" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

		return $_ResultSet ;

	}
	

function get_empname($str_dbconnect,$namecode) {

    $_SelectQuery 	=   "SELECT FirstName,LastName FROM tbl_employee WHERE `EmpCode` = '$namecode'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		$_EmpName = "";
		while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_EmpName  =  $_myrowRes['FirstName'].' '.$_myrowRes['LastName'];
        }
        return $_EmpName ;

}


?>
