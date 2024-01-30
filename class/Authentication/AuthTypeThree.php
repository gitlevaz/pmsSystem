<?php
echo $_SESSION["LogUserGroup"];
        //Auth for Admins,Managers and Users 
        if($_SESSION["LogUserGroup"]!="SADM" && $_SESSION["LogUserGroup"]!="MNG" && $_SESSION["LogUserGroup"]!="USR"){
            echo '<script>alert("User doesn\'t have access privileges")</script>';
            echo("<script>location.href = '../../Home.php';</script>");
        }
?>