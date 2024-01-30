<?php
/*
 * Developer Name   :   P.H.S. Prajapriya
 * Module Name      :   Home Page for the All Controles
 * Last Update      :   19-04-2011
 * Company Name     :   Tropical Fish International (pvt) ltd
 */

session_start();

if(!isset($_SESSION["LogUserName"]) || !isset($_SESSION["CompCode"])){
    echo "<script type='text/javascript'>";
    echo "self.SessionLost();"; 
    echo "</script>";
}

//  importing all neccessary clasess

include ("connection/sqlconnection.php");   
                                                 //  Role Autherization   //  connection file to the mysql database
include ("class/accesscontrole.php");       //  sql commands for the access controles
include ("class/sql_empdetails.php");        //  connection file to the mysql database
include ("class/sql_project.php");          //  sql commands for the access controles
include ("class/sql_sysusers.php");          //  sql commands for the access controls
include ("class/sql_task.php");             //  sql commands for the access controles
 
          //  connection file to the mysql database
//  connecting the mysql database
mysqli_select_db($str_dbconnect,"$str_Database") or die ("Unable to establish connection to the MySql database");

$path = "";
$Menue	= "Home";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>.:: PMS 3.0v ::.</title>
<meta charset="utf-8" />

<link href="css/styleB.css" rel="stylesheet" type="text/css" />

<!--    Loading Jquerry Plugin  -->
<link type="text/css" href="jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="jQuerry/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>

<!--<script type="text/javascript" src="jQuerry/jRating.jquery.js"></script>-->
<link rel="stylesheet" href="Rating/jRating.jquery.css" type="text/css" />

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

<script type="text/javascript" src="charts/jscharts.js"></script>

<style type="text/css">
	/*body {margin:15px;font-family:Arial;font-size:13px}*/
	a img{border:0}
	.datasSent, .serverResponse{margin-top:20px;width:470px;height:73px;border:1px solid #F0F0F0;background-color:#F8F8F8;padding:10px;float:left;margin-right:10px}
	.datasSent{width:200px;position:fixed;left:680px;top:0}
	.serverResponse{position:fixed;left:680px;top:100px}
	.datasSent p, .serverResponse p {font-style:italic;font-size:12px}
	.exemple{margin-top:15px;}
	.clr{clear:both}
	pre {margin:0;padding:0}
	/*.notice {background-color:#F4F4F4;color:#666;border:1px solid #CECECE;padding:10px;font-weight:bold;width:600px;font-size:12px;margin-top:10px}*/
</style>

<!-- JRating -->
<script type="text/javascript" src="JqueryRating/jquery.rating.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="JqueryRating/jquery.rating.css" />

<script>
    
    $(function() {
        $( "input:submit, a, button", ".button" ).button();
        $( "a", ".button" ).click(function() { return false; });
    });

    function PleaseWait(){
        $( "#loading" ).dialog({
            height: 140,
            modal: true,
            closeOnEscape: false
        });        
    }
    
    function unloadPleaseWait(){       
       $("#loading").dialog("close");       
    }

    $(document).ready(function(){ 
       $( "#loading" ).dialog({
            height: 140,
            modal: true,
            closeOnEscape: false
        });            
    });
    
    $(function() {
        $( "#accordion" ).accordion({
            collapsible: true,
            autoHeight: false,
            navigation: true
        });
    });
    
    function fnFormatDetails ( oTable, nTr, hlink ){
        var aData = oTable.fnGetData( nTr );
        var sOut = "<table border='0'>";
        sOut += "<tr><td><center><iframe width='800px' style='border: none;' src='MaintaskbrowseDig.php?&procode="+aData[3]+"'></center> </td></tr>";
        sOut += "</table>";
        return sOut;
    }

    $(document).ready(function() {
	
		/*$('.basic').jRating();*/
		
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
    
    $(document).ready(function() {
        $('#example1').dataTable();
    } );

    $(document).ready(function() {
        $('#example2').dataTable();
    } );
	
	$(document).ready(function() {
        $('#example3').dataTable();
    } );
    
    $(window).load(function() { 
         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
    }); 
	
	
		    
</script>

</head>
<body>
<div id="preloader"></div>

<form name="frm_Home" id="frm_Home" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

	<?php		
		if(isset($_GET["procode"]) && $_GET["procode"] != "" ){
			$Procode		= 	$_GET["procode"];				
		}	
		
	?>   
	
	<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">
				<table width="100%" cellpadding="0" cellspacing="0">
                    <tr style="height: 50px; background-color: #E0E0E0;">
                        <td style="padding-left: 10px; font-size: 16px">
                            List of Attachments Under Project <?php echo  $Procode; ?>                                             													
                        </td>                                            
                    </tr>    
                    <tr align="center">
                                                                     
                    </tr>
                </table>
				</BR></bR>
				<table width="100%" cellpadding="0" cellspacing="0">                    
                    <tr align="justify">
                    	<?php
																							
							$ProDocCount = 0;
							
                            $_ProjectSet      = get_projectupload($str_dbconnect,$Procode) ;
                            while($_ProjectRes = mysqli_fetch_array($_ProjectSet)) {
							
								$ProDocCount = $ProDocCount + 1;															
							
                        ?>
                        		<a href="files/<?php echo $_ProjectRes['SystemName'] ; ?>"><?php echo $_ProjectRes['SystemName'] ; ?></a><font color="Red"> | </font>  
                        <?php 
																																 																						
							} 
						?>

                        <?php																							
                            $_ProjectSet      = get_projectuploadunderTask($str_dbconnect,$Procode) ;
                            while($_ProjectRes = mysqli_fetch_array($_ProjectSet)) {
							
								$ProDocCount = $ProDocCount + 1;
                        ?>							
                            	<a href="files/<?php echo $_ProjectRes['SystemName'] ; ?>"><?php echo $_ProjectRes['SystemName'] ; ?></a><font color="Red"> | </font> 
                        <?php	
						 	}						 																					 
						?>
						                                              
                    </tr>
                </table>
			</td>
		</tr>
	</table>			
	
</form>
</body>
</html> 