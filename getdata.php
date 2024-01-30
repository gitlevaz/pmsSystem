<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shameera
 * Date: 7/24/11
 * Time: 11:58 AM
 * To change this template use File | Settings | File Templates.
 */


session_start();

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
include ("class/accesscontrole.php");       //  sql commands for the access controles
include ("class/sql_project.php");          //  sql commands for the access controles
include ("class/sql_task.php");             //  sql commands for the access controles

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");



    if(isset($_GET["type"]))
    {
        $Str_Type    = $_GET["type"];

        $_SelectQuery 	=   "INSERT INTO tbl_GPS (`data`) VALUES ('$Str_Type')" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    }


?>
