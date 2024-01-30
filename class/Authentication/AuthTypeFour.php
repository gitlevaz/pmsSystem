<?php
echo $_SESSION["LogUserGroup"];
       //Auth for Admins,Managers, Users and Task Delegate
       if($_SESSION["LogUserGroup"]!="SADM" && $_SESSION["LogUserGroup"]!="MNG" && $_SESSION["LogUserGroup"]!="USR" && $_SESSION["LogUserGroup"]!="TSKD" ){
        echo '<script>alert("User doesn\'t have access privileges")</script>';
        echo("<script>location.href = '../../PMS/Home.php';</script>");
}
?>