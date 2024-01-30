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
include ("class/sql_empdetails.php");        //  connection file to the mysql database
include ("class/sql_sysusers.php");          //  sql commands for the access controls
include ("class/sql_task.php");             //  sql commands for the access controles

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

    <!-- **************** JQUERRY ************************-->
    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>

    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />

    <!-- ************************************************* -->
    <!-- **************** FLEX GRID **********************
    <script type="text/javascript" language="javascript" src="js/flexigrid.js"></script>
    <script type="text/javascript" language="javascript" src="js/flexigrid.pack.js"></script>

    <link href="css/flexigrid.css" rel="stylesheet" type="text/css"/>
    <link href="css/flexigrid.pack.css" rel="stylesheet" type="text/css"/>-->
    <!-- ************************************************* -->
    
    <link rel="stylesheet" href="css/project.css" type="text/css"/>
    <link rel="stylesheet" href="css/slider.css" type="text/css"/>
    <link href="css/textstyles.css" rel="stylesheet" type="text/css"/>

    <script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
    <script src="ui/jquery.ui.dialog.js"></script>

    <!-- **************** NEW GRID ***************** -->

    <style type="text/css" title="currentStyle">
            @import "media/css/demo_page.css";
            @import "media/css/demo_table.css";
    </style>
    
    <script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>

    <!-- **************** NEW GRID END ***************** -->

    <script type="text/javascript" charset="utf-8">

        function getPageSize() {
            /*
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);*/
        }

        function View(hlink){           
            document.forms[0].action = "Maintaskbrowse.php?&procode="+hlink+"";
            document.forms[0].submit();
        }

        function Approve(hlink,hlinkID ){
            //alert(hlink+ " - " + hlinkID);
            document.forms[0].action = "ApproveTask.php?&taskcode="+hlink+"&taskid="+hlinkID+"&Page=Main";
            document.forms[0].submit();
        }

        function toggle() {
             if( document.getElementById("hidethis").style.display=='none' ){
               document.getElementById("hidethis").style.display = '';
             }else{
               document.getElementById("hidethis").style.display = 'none';
             }
        }

        

    </script>

    <style type="text/css">
        body { font-size: 65%; font-family: "Lucida Sans" }
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

    <script type="text/javascript">
        function showDialog(hlink){
           $("#divId").dialog("open");
           $("#modalIframeId").attr("src","MaintaskbrowseDig.php?&procode="+hlink+"");
           return false;
        }

        $(document).ready(function() {
           $("#divId").dialog({
                   autoOpen: false,
                   modal: true,
                   height: 1030,
                   width: 800
               });
        });

        function fnFormatDetails ( oTable, nTr, hlink )
        {
            //sOut += "<tr><td><iframe width='750px' src='MaintaskbrowseDig.php?&procode="+aData[1]+"'> </td></tr>";

            var aData = oTable.fnGetData( nTr );
            var sOut = "<table border='0'>";
            sOut += "<tr><td><iframe width='750px' style='border: none' src='MaintaskbrowseDig.php?&procode="+aData[1]+"'> </td></tr>";
            sOut += "</table>";
            
            return sOut;
        }

        $(document).ready(function() {
            /*
             * Insert a 'details' column to the table
             */
            var nCloneTh = document.createElement( 'th' );
            var nCloneTd = document.createElement( 'td' );
            nCloneTd.innerHTML = '<img src="images/details_open.png">';
            nCloneTd.className = "center";

            $('#example thead tr').each( function () {
                this.insertBefore( nCloneTh, this.childNodes[0] );
            } );

            $('#example tbody tr').each( function () {
                this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
            } );

            /*
             * Initialse DataTables, with no sorting on the 'details' column
             */
            var oTable = $('#example').dataTable( {
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 0 ] }
                ],
                "aaSorting": [[1, 'asc']]
            });

            /* Add event listener for opening and closing details
             * Note that the indicator for showing which row is open is not controlled by DataTables,
             * rather it is done here
             */
            $('#example tbody td img').live('click', function () {
                var nTr = this.parentNode.parentNode;
                if ( this.src.match('details_close') )
                {
                    /* This row is already open - close it */
                    this.src = "images/details_open.png";
                    oTable.fnClose( nTr );
                }
                else
                {
                    /* Open this row */
                    this.src = "images/details_close.png";
                    oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr, 'PRO/62' ), 'details' );
                }
            } );
        } );

        /*
        $(document).ready(function() {
            $('#example').dataTable();
        } );
        */
        $(document).ready(function() {
            $('#example1').dataTable();
        } );

        $(document).ready(function() {
            $('#example2').dataTable();
        } );
  </script>

    
</head>
<?php
    if(isset($_POST['btnBack'])) {        
        echo "<script>";
        echo " self.location='project.php';";
        echo "</script>";
    }
?>
<body onLoad="init()">
    <div id="containerc">
        <div id="Centeredc">

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
            <!--
            <div id="Div-Form_logo">
                <input type="button" title="Tropical Fish International (pvt) ltd" class="logo"/>
            </div>
            <div class="Application" align="left">
                    User Name : <?php echo $_SESSION["LogUserName"]; ?>
            </div>
            -->

            <form name="frm_porject" id="frm_porject" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" class="cmxform">


                <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px; overflow: auto; width: 79%  ">
                <legend ><strong>Things To Do</strong></legend>
                    <br>
                        <div id="divId" title=".:: Task Details ::.">
                            <iframe id="modalIframeId" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto" title="Task Details">Your browser does not suppr</iframe>
                        </div>
                    <br>

                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
                        <thead>
                            <tr>
                                <th>Project Code</th>
                                <th>Project Name</th>
                                <th>Start Date</th>
                                <th>Create User</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Attachments</th>
                                <th>Comments</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $ColourCode = 0 ;
                                $LoopCount = 0;
                                $_ResultSet = get_ProjectDetailsTask($str_dbconnect);
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                    if ($ColourCode == 0 ) {
                                        $Class = "even gradeA" ;
                                        $ColourCode = 1 ;
                                    } elseif ($ColourCode == 1 ) {
                                        $Class = "odd gradeA";
                                        $ColourCode = 0 ;
                                    }

                                    $Str_ProCode = $_myrowRes['procode'];
                            ?>

                                <tr  class="<?php echo $Class; ?>">
                                    <!--
                                    <td style="width: 10px">
                                        <?php
                                            echo "<input type='button' name='view' value='[+]' style='cursor:pointer; width: 20px' onclick='return showDialog(\"$Str_ProCode\")'/>";
                                        ?>
                                    </td>-->
                                    <td>
                                        <?php
                                            echo $_myrowRes['procode'];
                                            $Str_ProCode = $_myrowRes['procode'];
                                        ?>
                                    </td>
                                    <td><?php echo $_myrowRes['proname']; ?></td>
                                    <td ><?php echo $_myrowRes['startdate']; ?></td>
                                    <td ><?php echo getSELECTEDSYSUSERNAME($str_dbconnect,($_myrowRes['crtusercode'])); ?></td>
                                    <td ><?php echo GetStatusDesc($str_dbconnect,$_myrowRes['prostatus']); ?></td>
                                    <td >
                                        <?php
                                            echo "<input type='button' name='view' value='VIEW' style='cursor:pointer; width: 40px' onclick='return View(\"$Str_ProCode\")'/>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $_ProjectSet      = get_projectupload($str_dbconnect,$Str_ProCode) ;
                                            while($_ProjectRes = mysqli_fetch_array($_ProjectSet)) {
                                        ?>
                                            <a href="files/<?php echo $_ProjectRes['SystemName'] ; ?>"><?php echo $_ProjectRes['SystemName'] ; ?></a><br>
                                        <?php } ?>
                                    </td>
                                    <td >
                                        <input name="<?php echo $Str_taskCode; ?>" id="<?php echo $Str_taskCode; ?>" size="20"/><br><br>
                                     </td>
                                     <td>
                                        <input type="button" name="update" id="update" value="Save" onclick="updateTask('<?php echo $Str_taskCode; ?>','<?php echo $CurrentProCode; ?>')"/>
                                     </td>
                                     <td>
                                        <input type="button" name="vupdate" id="vupdate" value="Comm."/>
                                    </td>
                                    
                                </tr>
                                    
                            <?php
                                $LoopCount = $LoopCount + 1;
                                }
                            ?>
                                
                        </tbody>

                    </table>
                    <br>
                </fieldset>

                <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px; overflow: auto; width: 800px  ">
                <legend ><strong>Pending Approvals Project Completed</strong></legend>
                    <br>
                    <p>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
                        <thead>
                            <tr>
                                <th>Project Code</th>
                                <th>Task Code</th>
                                <th>Task Name</th>
                                <th>Request By</th>
                                <th>Attachments</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $CurrentProCode =   "";
                                $ColourCode = 0 ;
                                $LoopCount = 0;
                                $_ResultSet = get_ApproveTaskDetails($str_dbconnect,"Task Completed");
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                    if ($ColourCode == 0 ) {
                                        $Class = "gradeA" ;
                                        $ColourCode = 1 ;
                                    } elseif ($ColourCode == 1 ) {
                                        $Class = "gradeA";
                                        $ColourCode = 0;
                                    }

                                    $Str_taskCode = $_myrowRes['TaskCode'];
                                    $Str_taskID = $_myrowRes['ID'];

                            ?>
                                    <tr style="cursor: pointer" onclick="Approve('<?php echo $Str_taskCode; ?>','<?php echo$Str_taskID; ?>')" class="<?php echo $Class; ?>">
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
                                        <td>
                                        <?php        
                                            $_ResultSet      = get_projectuploadupdates($str_dbconnect,$_ProCode) ;
                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {                 
                                                echo  "<a href='../files/" . $_myrowRes['SystemName'] ."'>" .$_myrowRes['SystemName']."</a><br>";
                                            }
                                            
                                            $_ResultSet      = get_projectuploadupdates($str_dbconnect,$Str_taskCode) ;
                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {                 
                                                echo  "<a href='../files/" . $_myrowRes['SystemName'] ."'>" .$_myrowRes['SystemName']."</a><br>";
                                            }
                                         ?>
                                        </td>
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


                <fieldset class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px; overflow: auto; width: 800px  ">
                <legend ><strong>Pending Approvals Addl. Hours Request</strong></legend>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
                        <thead>
                            <tr>
                                <th>Project Code</th>
                                <th>Task Code</th>
                                <th>Task Name</th>
                                <th>Request By</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $CurrentProCode =   "";
                                $ColourCode = 0 ;
                                $LoopCount = 0;
                                $_ResultSet = get_ApproveTaskDetails($str_dbconnect,"Addl Hrs Request");
                                while($_myrowRes = mysqli_fetch_array($_ResultSet)){
                                    if ($ColourCode == 0 ) {
                                        $Class = "gradeA" ;
                                        $ColourCode = 1 ;
                                    } elseif ($ColourCode == 1 ) {
                                        $Class = "gradeA";
                                        $ColourCode = 0;
                                    }

                                    $Str_taskCode = $_myrowRes['TaskCode'];
                                    $Str_taskID = $_myrowRes['ID'];

                            ?>
                                <tr style="cursor: pointer" onclick="Approve('<?php echo $Str_taskCode; ?>','<?php echo$Str_taskID; ?>')" class="<?php echo $Class; ?>">
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
                                    <td>
                                        <?php        
                                            $_ResultSet      = get_projectuploadupdates($str_dbconnect,$_ProCode) ;
                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {                 
                                                echo  "<a href='../files/" . $_myrowRes['SystemName'] ."'>" .$_myrowRes['SystemName']."</a><br>";
                                            }

                                            $_ResultSet      = get_projectuploadupdates($str_dbconnect,$Str_taskCode) ;
                                            while($_myrowRes = mysqli_fetch_array($_ResultSet)) {                 
                                                echo  "<a href='../files/" . $_myrowRes['SystemName'] ."'>" .$_myrowRes['SystemName']."</a><br>";
                                            }
                                         ?>
                                        </td>
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
                    <br>
                </fieldset>

            </form>
        </div>
    </div>
</body>
</html>
