<?php

$str_MySqlHost  =   "localhost";    //  Server Root
$str_Database   =   "cispms";       //  Database Name
$str_UserName   =   "root";         //  DB User Name
$str_Password   =   "";             //  DB Password

//  Connection string to the MySQL Database
$str_dbconnect  = mysql_connect($str_MySqlHost, $str_UserName, $str_Password) or die (mysqli_error($str_dbconnect));
    
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
  
class sql_getKJRWorkFlow {
    //put your code here
}
if(isset($_POST["kjrdata"]))
{
	$_kjrintern     = $_POST["kjrdata"]; 
	 
	$indid = 0;
	$text = "Select KPI";
    $_SelectQuery   = 	"SELECT IndicatorId FROM tbl_kjr_indicator where KJRId = '$_kjrintern'" or die(mysqli_error($str_dbconnect));
    $_ResultSet11    =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	echo '<option >'.$text.'</option>';
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
	echo '<option >'.$text.'</option>';
	 while ($myrowRes = mysqli_fetch_array($_ResultSet11))
	{ 
         $indid = $myrowRes["SubIndId"];
		 $indname = $myrowRes["SubIndName"];
		 $inddes = $myrowRes["Description"];		           
         echo '<option value="'.$indid.'" >'.$indname.' - '.$inddes.'</option>';                                                                            
	}  
}



?>
