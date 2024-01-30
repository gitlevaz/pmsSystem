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
 	//include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database    
   // include ("sql_crtprocat.php");            //  connection file to the mysql database
   // include ("sql_empdetails.php"); //  connection file to the mysql database
   // include ("sql_wkflow.php"); //  connection file to the mysql database
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
  
class sql_getKJR {
    //put your code here
}

if(isset($_POST["wfuser"]))
{
	
	$empno    = $_POST["wfuser"]; 

	$etf = 0;
	$text = "Select KJR";
	
		$_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$empno'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $etf    =	$_myrowRes['EmpNIC'];
        }
		
		 $_SelectQuery   = 	"SELECT * FROM tbl_kjr where etfno='$etf'" or die(mysqli_error($str_dbconnect));
    	 $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));		
   
	 echo '<option value="0" >'.$text.'</option>';
	 while ($myrowRes = mysqli_fetch_array($_ResultSet))
	{ 
         $kjrid   = $myrowRes["KJRId"];
		 $kjrname = $myrowRes["Name"];
		 $kjrdes  = $myrowRes["Description"];     
         echo '<option value="'.$kjrid.'" >'.$kjrname.' - '.$kjrdes.'</option>';
                                                                                                    
	}  
}



if(isset($_POST["kjrdata"]))
{
	$_kjrintern     = $_POST["kjrdata"]; 
	 
	$indid = 0;
	$text = "Select KPI";
    $_SelectQuery   = 	"SELECT IndicatorId FROM tbl_kjr_indicator where KJRId = '$_kjrintern'" or die(mysqli_error($str_dbconnect));
    $_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	echo '<option value="0" >'.$text.'</option>';
	 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
	{ 
         $indid = $myrowRes["IndicatorId"];
		  $_SelectQuery1   = 	"SELECT * FROM tbl_indicator where IndicatorID = '$indid'" or die(mysqli_error($str_dbconnect));
   $_ResultSet    =   mysqli_query($str_dbconnect,$_SelectQuery1) or die(mysqli_error($str_dbconnect));
    while($_myrowRes1 = mysqli_fetch_array($_ResultSet)) {
            $id = $_myrowRes1['IndicatorID'];
			 $name = $_myrowRes1['IndicatorName'];
			  $des = $_myrowRes1['Description'];
           // $name = $_myrowRes1['IndicatorName'];            
            echo '<option value="'.$id.'" >'.$name.' - '.$des.'</option>';
        }   
		                                                                                                 
	}  
}

if(isset($_POST["inddata"]))
{
	$_indintern     = $_POST["inddata"]; 
	 
	$indid = 0;
	$text = "Select Activity";
    $_SelectQuery   = 	"SELECT * FROM tbl_indicatorsub where IndicatorId = '$_indintern'" or die(mysqli_error($str_dbconnect));
    $_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	echo '<option value="0" >'.$text.'</option>';
	 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
	{ 
         $indid = $myrowRes["SubIndId"];
		 $indname = $myrowRes["SubIndName"];
		 $inddes = $myrowRes["Description"];		           
         echo '<option value="'.$indid.'" >'.$indname.' - '.$inddes.'</option>';                                                                            
	}  
}


?>
