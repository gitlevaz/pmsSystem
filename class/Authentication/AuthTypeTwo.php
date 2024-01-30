<?php
echo $_SESSION["LogUserGroup"];
       //Auth for Admins and Managers
       if($_SESSION["LogUserGroup"]!="SADM" && $_SESSION["LogUserGroup"]!="MNG" ){
        echo '<script>alert("User doesn\'t have access privileges")</script>';
        echo("<script>location.href = '../Home.php';</script>");
}
?>