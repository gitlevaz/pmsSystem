<?php  
//session_start();

/* if(($_SESSION["LogEmpCode"]== "")||($_SESSION["LogEmpCode"]== null))
{
 header("Location:index.php");
 exit();
} */

?>

<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript">
            function Go2HOME(path) {
                window.location.href = path + "Home.php"
                window.frames['SideBar'].changeColour("X");
            }

            function Exit(path) {
                window.location.href = path + "index.php"
                self.close();
            }


            function SessionLost(path) {
                window.location.href = path + "index.php"                
            }
        </script>
    </head>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0" style="padding-top: 15px; padding-left: 10px; padding-right: 20px">
            <tr>
                <td>
                    Project Management System - [3.0v]
                </td>
                <td align="right">
                    Logged As : <?php echo getSELECTEDEMPLOYENAME($str_dbconnect,$_SESSION["LogEmpCode"]) ?>                                          
                    | <a href="#" style="color: white" onclick="Go2HOME('<?php echo $path; ?>')">Go to Home</a>                                            
                    | <a href="#" style="color: white" onclick="Exit('<?php echo $path; ?>')">Log Out</a>
                </td>
            </tr>
        </table>
    </body>
</html>
