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
 	include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
   // include ("sql_crtprocat.php");            //  connection file to the mysql database
   // include ("sql_empdetails.php"); //  connection file to the mysql database
   // include ("sql_wkflow.php"); //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
  
class sql_taskuserview {
    //put your code here
}

if(isset($_POST["countrydata"]))
{
	$_SelectQuery="";
	$_country     = $_POST["countrydata"]; 
	$text = "Select Department";
	if($_country=="ALL"){
		$_SelectQuery   = 	"SELECT * FROM tbl_projectgroups" or die(mysqli_error($str_dbconnect));
	}
	if($_country!="ALL"){
		$_SelectQuery   = 	"SELECT * FROM tbl_projectgroups where Country = '$_country'" or die(mysqli_error($str_dbconnect));
	}    
    $_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	echo '<option >'.$text.'</option>';
	 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
	{ 
         $depid   = $myrowRes["GrpCode"];
		 $depname = $myrowRes["Group"];
		  echo '<option value="'.$depid.'" >'.$depname.'</option>';
		                               
	}  
}

if(isset($_POST["depdata"]))
{
	$_SelectQuery="";
	$_dep     = $_POST["depdata"]; 
	$text = "Select Employee";	
	
	$_SelectQuery   = 	"SELECT * FROM tbl_projects where Department = '$_dep' AND active = 1 group by ProOwner " or die(mysqli_error($str_dbconnect));	    
    $_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	echo '<option >'.$text.'</option>';
	 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
	{ 
         $empid   = $myrowRes["ProOwner"];
		 $_SelectQuery3   = 	"SELECT * FROM tbl_employee where EmpCode = '$empid' group by EmpCode " or die(mysqli_error($str_dbconnect));	    
    	 $_ResultSet3    =   mysqli_query($str_dbconnect,$_SelectQuery3) or die(mysqli_error($str_dbconnect));
		  while ($myrowRes3 = mysqli_fetch_array($_ResultSet3))
		  {
			   $empname   = $myrowRes3["FirstName"]." ".$myrowRes3["LastName"];
			   echo '<option value="'.$empid.'" >'.$empname.'</option>';
		  }		
		 
		                               
	}  
}




?>
