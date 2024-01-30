<?php

    error_reporting(E_ALL & ~E_NOTICE);

   // set up DB
   $conn = mysql_connect("localhost", "root", "");
   mysqli_select_db($str_dbconnect,"cispms");

   // include and create object
   include("inc/jqgrid_dist.php");
   $g = new jqgrid();

   // set few params
   $grid["caption"] = "Sample Grid";
   $g->set_options($grid);

   // set database table for CRUD operations
   $g->table = "tbl_projects";

   // subqueries are also supported now (v1.2)
   //$g->select_command = "SELECT * FROM tbl_projects";

   // render grid
   $out = $g->render("list1");

   //echo $out;

    

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS PROJECT DETAILS ::.</title>

    <link rel="stylesheet" type="text/css" media="screen" href="js/themes/redmond/jquery-ui-1.8.2.custom.css"></link>
	<link rel="stylesheet" type="text/css" media="screen" href="js/jqgrid/css/ui.jqgrid.css"></link>

    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>

	<script src="js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script src="js/themes/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>

    
</head>

<body>

    <div id="container">

            <?php

                ?>

            <div style="margin:10px; overflow: auto; width: 700px">
                <?php echo $out?>
            </div>


    </div>

</body>

</html>