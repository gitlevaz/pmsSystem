<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
session_start();

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
include ("class/accesscontrole.php");       //  sql commands for the access controles
include ("class/sql_project.php");          //  sql commands for the access controles
include ("class/sql_task.php");             //  sql commands for the access controles
include ("class/sql_sysusers.php");          //  sql commands for the access controls

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

    <!-- **************** JQUERRY ****************** -->
    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />

    <script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>

	<script src="ui/jquery.ui.button.js"></script>

    <!-- ******************************************** -->
    <!-- **************** FLEX GRID ****************** -->
    <script type="text/javascript" language="javascript" src="js/flexigrid.js"></script>
    <script type="text/javascript" language="javascript" src="js/flexigrid.pack.js"></script>

    <link href="css/flexigrid.css" rel="stylesheet" type="text/css" /><!--
    <link href="css/flexigrid.pack.css" rel="stylesheet" type="text/css" />-->
    <!-- ************************************* -->

    <link rel="stylesheet" href="css/project.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" charset="utf-8">

        function getPageSize() {
            /*var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);*/
        }

        function View(hlink,hlinkID ){
            //alert(hlink+ " - " + hlinkID);
            document.forms[0].action = "ApproveTask.php?&taskcode="+hlink+"&taskid="+hlinkID+"&Page=Browse";
            document.forms[0].submit();
        }
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
        echo "self.location='ApproveTask.php';";
        echo "</script>";
    }
?>
<body onLoad="init()">
    <div id="container">

            <div id="loading" style="position:absolute; width:100px; text-align:center; top:180px; left: 180px; height: 20px;">
                <img alt=""  src="images/Wait.gif" border=0/>
            </div>

            <script language="javascript" type="text/javascript">
                var ld=(document.all);
                var ns4=document.layers;
                var ns6=document.getElementById&&!document.all;
                var ie4=document.all;
                if (ns4)
                    ld=document.loading;
                else if (ns6)
                    ld=document.getElementById("loading").style;
                else if (ie4)
                    ld=document.all.loading.style;

                function init() {
                    if(ns4){ld.visibility="hidden";}
                    else if (ns6||ie4) ld.display="none";
                }

            </script>
            


                <form name="frm_porject" id="frm_porject" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" class="cmxform">
                    <div id="Div-Form_Back" >
                        <input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack" onclick=""/>
                    </div>
                    <br><br><br>
                    <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px;">
                    <legend ><strong>Approvals for Additional Hours Requests</strong></legend>
                    <p>
                    <table cellpadding="0" cellspacing="0" border="0" class="flexme3" id="flexme3">
                        <tbody>
                            <?php
                                $CurrentProCode =   "";
                                $ColourCode = 0 ;
                                $LoopCount = 0;
                                $_ResultSet = get_ApproveTaskDetails($str_dbconnect,"Addl Hrs Request");
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                    if ($ColourCode == 0 ) {
                                        $Class = "even gradeC" ;
                                        $ColourCode = 1 ;
                                    } elseif ($ColourCode == 1 ) {
                                        $Class = "odd gradeC";
                                        $ColourCode = 0;
                                    }
                                    
                            ?>
                                <tr style="cursor: pointer">
                                    <td>
                                        <?php
                                            echo $_myrowRes['ID'];
                                            $Str_taskCode = $_myrowRes['TaskCode'];
                                            $Str_taskID = $_myrowRes['ID'];
                                        ?>
                                    </td>
                                    <td><?php echo $_myrowRes['TaskCode']; ?></td>
                                    <td><?php echo get_selectedTaskNAME($str_dbconnect,$_myrowRes['TaskCode']); ?></td>
                                    <td class="center"><?php echo getSELECTEDSYSUSERNAME($str_dbconnect,($_myrowRes['crtusercode'])); ?></td>
                                    <td class='center'>
                                        <?php 
                                            echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_taskCode\",\"$Str_taskID\")'/>";
                                        ?>
                                    </td>
                                </tr>
                            <?php
                                $LoopCount = $LoopCount + 1;
                                }
                            ?>                                
                            </tbody>
                    </table>
                    </p>
                    </fieldset>
                    <script type="text/javascript">
                        $(".flexme3").flexigrid({
                            url : false,
                            resizable: false,
                            nowrap : true,
                            colModel : [ {
                                display : 'Task ID',
                                name : 'code',
                                width : 80,
                                sortable : true,
                                align : 'center'
                            }, {
                                display : 'Task Code',
                                name : 'taskcode',
                                width : 80,
                                sortable : true,
                                align : 'left'
                            }, {
                                display : 'Task Name',
                                name : 'taskname',
                                width : 200,
                                sortable : true,
                                align : 'left'
                            }, {
                                display : 'Request By',
                                name : 'requestby',
                                width : 100,
                                sortable : true,
                                align : 'center'
                            }, {
                                display : 'View',
                                name : 'view',
                                width : 80,
                                sortable : true,
                                align : 'center'
                            }],
                            searchitems : [ {
                                display : 'Task Code',
                                name : 'code'
                            },{
                                display : 'Task Name',
                                name : 'taskname',
                                isdefault : true
                            },{
                                display : 'Task Code',
                                name : 'taskcode'
                            }],
                            usepager : true,
                            title : 'APPROVALS FOR ADDITIONAL HOUR REQUESTS',
                            useRp : true,
                            rp : 15,
                            showTableToggleBtn : true,
                            width : 800,
                            height : 200
                        });

                        function test(com, grid) {
                            if (com == 'Delete') {
                                confirm('Delete ' + $('.trSelected', grid).length + ' items?')
                            } else if (com == 'Add') {
                                alert('Add New Item');
                            }
                        }
                    </script>
                    <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px;">
                    <legend ><strong>Approvals for Task Completion</strong></legend>
                    <p>
                    <table cellpadding="0" cellspacing="0" border="0" class="flexme4" id="flexme4">
                        <tbody>
                            <?php
                                $CurrentProCode =   "";
                                $ColourCode = 0 ;
                                $LoopCount = 0;
                                $_ResultSet = get_ApproveTaskDetails($str_dbconnect,"Task Completed");
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                    if ($ColourCode == 0 ) {
                                        $Class = "even gradeC" ;
                                        $ColourCode = 1 ;
                                    } elseif ($ColourCode == 1 ) {
                                        $Class = "odd gradeC";
                                        $ColourCode = 0;
                                    }

                            ?>
                                <tr style="cursor: pointer">
                                    <td>
                                        <?php
                                            echo $_myrowRes['ID'];
                                            $Str_taskCode = $_myrowRes['TaskCode'];
                                            $Str_taskID = $_myrowRes['ID'];
                                        ?>
                                    </td>
                                    <td><?php echo $_myrowRes['TaskCode']; ?></td>
                                    <td><?php echo get_selectedTaskNAME($str_dbconnect,$_myrowRes['TaskCode']); ?></td>
                                    <td class="center"><?php echo getSELECTEDSYSUSERNAME($str_dbconnect,($_myrowRes['crtusercode'])); ?></td>
                                    <td class='center'>
                                        <?php
                                            echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_taskCode\",\"$Str_taskID\")'/>";
                                        ?>
                                    </td>
                                </tr>
                            <?php
                                $LoopCount = $LoopCount + 1;
                                }
                            ?>
                            </tbody>
                    </table>
                        </p>
                        </fieldset>
                    <script type="text/javascript">
                        $(".flexme4").flexigrid({
                            url : false,
                            resizable: false,
                            nowrap : true,
                            colModel : [ {
                                display : 'Task ID',
                                name : 'code',
                                width : 80,
                                sortable : true,
                                align : 'center'
                            }, {
                                display : 'Task Code',
                                name : 'taskcode',
                                width : 80,
                                sortable : true,
                                align : 'left'
                            }, {
                                display : 'Task Name',
                                name : 'taskname',
                                width : 200,
                                sortable : true,
                                align : 'left'
                            }, {
                                display : 'Request By',
                                name : 'requestby',
                                width : 100,
                                sortable : true,
                                align : 'center'
                            }, {
                                display : 'View',
                                name : 'view',
                                width : 80,
                                sortable : true,
                                align : 'center'
                            }],
                            searchitems : [ {
                                display : 'Task Code',
                                name : 'code'
                            },{
                                display : 'Task Name',
                                name : 'taskname',
                                isdefault : true
                            },{
                                display : 'Task Code',
                                name : 'taskcode'
                            }],
                            usepager : true,
                            title : 'APPROVALS FOR TASK COMPLETION',
                            useRp : true,
                            rp : 15,
                            showTableToggleBtn : true,
                            width : 800,
                            height : 200
                        });

                        function test(com, grid) {
                            if (com == 'Delete') {
                                confirm('Delete ' + $('.trSelected', grid).length + ' items?')
                            } else if (com == 'Add') {
                                alert('Add New Item');
                            }
                        }
                    </script>
                </form>
            </div>

</body>
</html>
