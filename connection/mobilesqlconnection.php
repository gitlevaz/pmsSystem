<?php

/*
 * Developer Name   :   Ruwanka Lewis
 * Module Name      :   SQL_Connection to the Database
 * Last Update      :   07-03-2016
 * Company Name     :   Tropical Fish International (pvt) ltd
 */
 

 $str_MySqlHost  =   "db3.tkse.lk";    //  Server Root
 $str_Database   =   "__TKSE_PMS";     //  Database Name
 $str_UserName   =   "TKSE_PMS";       //  DB User Name
 $str_Password   =   "Iyz83w8_2$6"; 


$link = mysqli_connect($str_MySqlHost, $str_UserName, $str_Password, $str_Database);
if (!$link) {
    die('Could not connect: ' .mysqli_error($str_dbconnect));
}

return $link;
mysqli_close($link);


/* $hostname_connection = "localhost";
$database_connection = "cispms";
$username_connection = "root";
$password_connection = ""; */

/* $connection = mysql_connect($str_MySqlHost, $str_UserName, $str_Password) or die (mysqli_error($str_dbconnect));  */

/* 
$str_MySqlHost  =   "localhost";    //  Server Root
$str_Database   =   "cispms";       //  Database Name
$str_UserName   =   "root";         //  DB User Name
$str_Password   =   "";     */         //  DB Password

//  Connection string to the MySQL Database
//$connection  = mysql_connect($str_MySqlHost, $str_UserName, $str_Password) or trigger_error(mysqli_error($str_dbconnect),E_USER_ERROR); 
//  Connection string to the MySQL Database
/* $str_dbconnect  = mysql_connect($str_MySqlHost, $str_UserName, $str_Password) or die (mysqli_error($str_dbconnect)); */

?>