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
include ("class\sql_empdetails.php"); 

mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
$path = "";
$Menue	= "SystemUsers";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS SYSTEM USER DETAILS ::.</title>

    <!-- **************** JQUERRY ****************** -->
    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link href="css/styleB.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

    <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>

    <!-- ******************************************** -->
    <!-- **************** FLEX GRID ****************** -->
    <!--<script type="text/javascript" language="javascript" src="js/flexigrid.js"></script>
    <script type="text/javascript" language="javascript" src="js/flexigrid.pack.js"></script>-->

    <!--<link href="css/flexigrid.css" rel="stylesheet" type="text/css" />
    <link href="css/flexigrid.pack.css" rel="stylesheet" type="text/css" />-->
    <!-- ************************************* -->

    <link rel="stylesheet" href="css/project.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />

	<style type="text/css" title="currentStyle">
        @import "media/css/demo_page.css";
        @import "media/css/demo_table.css";
</style>    
<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
        /*$('#flexme3').dataTable(
			{iDisplayLength: 25,		
          	bProcessing: true, 
			sPaginationType: "full_numbers",         	
			aLengthMenu: [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]]}
		);
		
		$('#flexme3').dataTable(
			
		);*/
    } );
</script>

<script type="text/javascript" charset="utf-8">

function getPageSize() {
    /*var body = document.body,
        html = document.documentElement;

    var height = Math.max( body.scrollHeight, body.offsetHeight,
                           html.clientHeight, html.scrollHeight, html.offsetHeight );            
    parent.resizeIframeToFitContent(height);*/
}

function View(hlink){           
    document.forms[0].action = "crtsystemuser-view.php?&usercode="+hlink+"";
    document.forms[0].submit();
}
</script>

<script type="text/javascript" charset="utf-8">     

$(window).load(function() { 
     $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
});

$(document).ready(function() {
    $('#flexme3').dataTable();
    $('#btnAdd').click(function(){
        document.forms[0].action = "crtsystemuser.php";
    document.forms[0].submit();
    });
} );


</script>
</head>
<?php
if(isset($_POST['btnBack'])) {        
echo "<script>";
echo "self.location='crtsystemuser.php';";
echo "</script>";
}
?>
<body><div id="preloader"></div>
<div id="container">

<form name="frm_porject" id="frm_porject" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" class="cmxform">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td align="left">
        <div id="wrapper">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2" style="width: 100%;">
                        <div id="header">                                    
                            <!--Header-->
                            <?php include('Header.php'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <!--border-left: 2px solid #063794; border-right: 2px solid #063794-->
                    <td style="width: 220px; height: auto; background-color: #599b83" align="left" valign="top" id="leftBottom">
                        <div id="left" style="background-color: transparent">                                   
                            <div id="leftTop">                                        
                                <div class="menu" id="MenuListNav">
                                    <?php include('Menu.php'); ?>
                                </div>
                            </div>
                        </div> 
                    </td>
                    <td align="left" style="width: 100%; vertical-align: top;">
                        <div id="right" >
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr style="height: 50px; background-color: #E0E0E0;">
                                        <td style="padding-left: 10px; font-size: 16px">
                                            <font color="#0066FF"><strong>System User Details</strong></font>                              
                                        </td>                                            
                                    </tr>    
                                    <tr align="center">
                                                                                         
                                    </tr>
                                </table>                                    
                            <br></br>  
                            <table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
                                <tr>
                                    <td>             
                <input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack" onclick=""/>
                                    </td>
                                </tr>
                            </table>   
                            
                            <table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
                                <tr>
                                    <!-- <td>                    
                                        <input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="" size="5"/>
                                       </td> -->
                                    <!-- <td>
                                            <input type="submit" id="btnSearch" name="btnSearch" title="Search Project Details" class="buttonSearch" value="" size="5" />
                                    </td> -->
                                    <td>
                                        <input  id="btnAdd" name="btnAdd" title="Add New Project" class="buttonAdd" value="" size="5"/>
                                    </td>
                                    <!-- <td>
                                        <input type="submit" id="btnEdit" name="btnEdit" title="Edit Project" class="buttonEdit" value=""  size="10"/>
                                    </td> -->
                                    <!-- <td> 
                                        <input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Project" class="buttonDel" value="" size="10"/>
                                    </td> -->
                                    <td>
                                        <input type="submit" id="btnPrint" name="btnPrint" title="Print Project Details" class="buttonPrint" value="" size="10"/>
                                    </td>
                                 </tr>
                            </table> 

            <br><br><br> 
            <legend ><strong>System User Details</strong></legend>
                           
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="flexme3" >
                <thead>
                    <tr >
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Employee Code</th>
                        <th>Group</th>
                        <th>Status</th>
                        <th>Create User</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>                 
                    <?php
                        $CurrentProCode =   "";
                        $ColourCode = 0 ;
                        $LoopCount = 0;
                        $_ResultSet = getUSER_DETAILS($str_dbconnect);
                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                            if ($ColourCode == 0 ) {
                                $Class = "even gradeC" ;
                                $ColourCode = 1 ;
                            } elseif ($ColourCode == 1 ) {
                                $Class = "odd gradeC";
                                $ColourCode = 0 ;
                            }

                            if ($CurrentProCode <> $_myrowRes['Id']){
                                $CurrentProCode = $_myrowRes['Id'];
                    ?>

                    <?php
                            }

                    ?>
                        <tr class="<?php echo $Class; ?>">
                            <td>
                                <?php
                                    echo $_myrowRes['Id'];
                                    $Str_taskCode = $_myrowRes['Id'];
                                ?>
                            </td>
                            <td><?php echo $_myrowRes['User_name']; ?></td>
                            <td><?php echo $_myrowRes['EmpCode']; ?></td>
                            <td ><?php echo $_myrowRes['UserGroup']; ?></td>
                            <td ><?php echo $_myrowRes['UserStat']; ?></td>
                            <td ><?php echo $_myrowRes['created_by']; ?></td>
                            <td >
                                <?php 
                                    echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_taskCode\")'/>";
                                ?>
                            </td>
                        </tr>
                    <?php
                        $LoopCount = $LoopCount + 1;
                        }
                    ?>                                
                    </tbody>
            </table>
          </div>
        </td>
       </tr>
      </table>
     </div>
    </td>
   </tr>
   <tr>
        <td colspan="2" style="width: 100%">
            <div id="footer">
                <?php include ('footer.php') ?>
            </div >
        </td>
    </tr>
  </table>
            
                
            <!--<script type="text/javascript">
                $(".flexme3").flexigrid({
                    url : false,
                    resizable: false,
                    nowrap : true,
                    colModel : [ {
                        display : 'ID',
                        name : 'code',
                        width : 80,
                        sortable : true,
                        align : 'center'
                    }, {
                        display : 'User Name',
                        name : 'username',
                        width : 200,
                        sortable : true,
                        align : 'left'
                    }, {
                        display : 'Employee Code',
                        name : 'empcode',
                        width : 80,
                        sortable : true,
                        align : 'center'
                    }, {
                        display : 'Group',
                        name : 'group',
                        width : 80,
                        sortable : true,
                        align : 'center'
                    }, {
                        display : 'Status',
                        name : 'status',
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
                        display : 'ID',
                        name : 'code'
                    },{
                        display : 'User Name',
                        name : 'username',
                        isdefault : true
                    },{
                        display : 'Status',
                        name : 'status',
                        isdefault : true
                    }],
                    usepager : true,
                    title : 'SYSTEM USER DETAILS',
                    useRp : true,
                    rp : 15,
                    showTableToggleBtn : true,
                    width : 800,
                    height : 800
                });

                function test(com, grid) {
                    if (com == 'Delete') {
                        confirm('Delete ' + $('.trSelected', grid).length + ' items?')
                    } else if (com == 'Add') {
                        alert('Add New Item');
                    }
                }
            </script>-->
        </form>
    </div>
</body>
</html>
