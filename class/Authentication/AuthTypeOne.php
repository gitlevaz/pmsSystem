<?php
echo $_SESSION["LogUserGroup"];
        //Auth for Admins
        if($_SESSION["LogUserGroup"]="SADM"){
            echo '<script>alert("User doesn\'t have access privileges")</script>';
            echo("<script>location.href = '../../Home.php';</script>");
    }
        
?>