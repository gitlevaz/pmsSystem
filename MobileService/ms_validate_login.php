<?php

	
	session_start();

    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database
    include ("accesscontrole.php"); //  sql commands for the access controles
    include ("sql_empdetails.php"); //  connection file to the mysql database
    include ("sql_crtprocat.php");            //  connection file to the mysql database

    require_once("class.phpmailer.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database

    include ("sql_wkflow.php");            //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");




?>
