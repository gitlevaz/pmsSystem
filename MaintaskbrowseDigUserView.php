<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
session_start();

include ("connection\sqlconnection.php");   //  connection file to the mysql database
include ("class\accesscontrole.php");       //  sql commands for the access controles
include ("class\sql_project.php");          //  sql commands for the access controles
include ("class\sql_task.php");             //  sql commands for the access controles

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$Menue	= "UserView";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

    <!-- **************** JQUERRY ****************** -->
    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />

    <!-- ******************************************** -->
    <!-- **************** FLEX GRID ******************
    <script type="text/javascript" language="javascript" src="js/flexigrid.js"></script>
    <script type="text/javascript" language="javascript" src="js/flexigrid.pack.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->
<!--
    <script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
    

	<script src="ui/jquery.ui.button.js"></script>


    <link href="css/flexigrid.css" rel="stylesheet" type="text/css" />
    <link href="css/flexigrid.pack.css" rel="stylesheet" type="text/css" /> -->
    <!-- ************************************* -->

    <link rel="stylesheet" href="css/project.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />

    <style type="text/css" title="currentStyle">
            @import "media/css/demo_page.css";
            @import "media/css/demo_table.css";
    </style>

    <script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>

    <script type="text/javascript" charset="utf-8">

        function getPageSize() {
            /*var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);*/
        }

        function View(hlink){           
            document.forms[0].action = "updateTaskMain.php?&taskcode="+hlink+"";
            document.forms[0].submit();
        }

        function updateTask(TaskCode,hlink){
            //alert("asdasd");
            Comment = document.getElementById(TaskCode).value;
            alert(Comment);
            document.forms[0].action = "MaintaskbrowseDigUserView.php?&procode="+hlink+"&TaskCode="+TaskCode+"&Comment="+Comment+"";
            document.forms[0].submit();
        }

        $(document).ready(function() {
            $('#example5').dataTable();
        } );
    </script>

    <style type="text/css">
        body { font-size: 70%; font-family: "Lucida Sans" }
        label { display: inline-block; width: 200px; }
        legend { padding: 0.5em; }
        fieldset fieldset label { display: block; }
        #commentForm { width: 500px; }
        #commentForm label { width: 250px; }
        #commentForm label.error, #commentForm button.submit { margin-left: 253px; }
        #signupForm { width: 670px; }
        #signupForm label.error {
            margin-left: 10px;
            width: auto;
            display: inline;
        }
        #newsletter_topics label.error {
            display: none;
            margin-left: 103px;
        }

    </style>

</head>
<?php
    if(isset($_POST['btnBack'])) {        
        echo "<script>";
        echo "self.location='Mainprojectbrowse.php';";
        echo "</script>";
    }

    if(isset($_GET["procode"]))
    {
        $Str_ProCode    = $_GET["procode"];
        $_SESSION["MainProCode"] = $Str_ProCode;

        if(isset($_GET["TaskCode"]))
        {
            $TaskCode   =   $_GET["TaskCode"];
            $Comment    =   $_GET["Comment"];

            updateTaskComment($str_dbconnect,$TaskCode, "Task Update", $Comment,  "", "00:00","00;00", "00:00", "00:00");
            get_TaskPrimaryUpdate($str_dbconnect,$TaskCode, "Update");

        }
    }
?>
<body>
    <div id="container">

                <form name="frm_porject" id="frm_porject" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" class="cmxform">
                    <!--<br><br><br>
                    <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px;">
                    <legend ><strong>Task Updates</strong></legend>

                    <p>-->
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example5">
                        <thead>
                            <tr>
                                <th>Task Code</th>
                                <th>Task Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $_strEMPCODE = $_SESSION["Fake_EmpCode"];
                                $CurrentProCode =   "";
                                $ColourCode = 0 ;
                                $LoopCount = 0;
                                $_ResultSet = get_userprojecttaskDetailsUSER($str_dbconnect,$Str_ProCode, $_strEMPCODE);
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                    if ($ColourCode == 0 ) {
                                        $Class = "gradeX" ;
                                        $ColourCode = 1 ;
                                    } elseif ($ColourCode == 1 ) {
                                        $Class = "gradeX";
                                        $ColourCode = 0 ;
                                    }

                                    if ($CurrentProCode <> $_myrowRes['procode']){
                                        $CurrentProCode = $_myrowRes['procode'];
                            ?>
                                <!--
                               <tr>
                                   <td  colspan="6" align="center" class="<?php echo $Class; ?>"><font style="font-weight: bold;"> *** <?php echo get_SelectedProjectName($str_dbconnect,$CurrentProCode);?> ***</font></td>
                               </tr>
                                -->
                            <?php
                                    }

                            ?>
                                <tr style="cursor: pointer" class="<?php echo $Class; ?>">
                                    <td>
                                        <?php
                                            echo $_myrowRes['taskcode'];
                                            $Str_taskCode = $_myrowRes['taskcode'];
                                        ?>
                                    </td>
                                    <td><?php echo $_myrowRes['taskname']; ?></td>
                                    <td ><?php echo $_myrowRes['taskcrtdate']; ?></td>
                                    <td ><?php echo $_myrowRes['taskenddate']; ?></td>
                                    <td ><?php echo GetStatusDesc($str_dbconnect,$_myrowRes['taskstatus']); ?></td>
                                    <td >
                                        <?php 
                                            //echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_taskCode\")'/>";

                                        ?>
                                        <input name="<?php echo $Str_taskCode; ?>" id="<?php echo $Str_taskCode; ?>" size="30"/>
                                        <?php
                                            //echo "<input type='button' name='update' id='update' value='Update' onclick='update(\"$Str_taskCode\",\"$CurrentProCode\")'/>"
                                        ?>
                                        <input type="button" name="update" id="update" value="Update" onclick="updateTask('<?php echo $Str_taskCode; ?>','<?php echo $CurrentProCode; ?>')"/>
                                    </td>
                                </tr>
                            <?php
                                $LoopCount = $LoopCount + 1;
                                }
                            ?>                                
                            </tbody>
                    </table>

                </form>
            </div>
</body>
</html>
