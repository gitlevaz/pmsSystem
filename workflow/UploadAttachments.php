<?php

session_start();

include ("../connection/sqlconnection.php");
include ("uploadify/UploadUserAttachments.php");
include ("../class/sql_project.php");

                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database 
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>.:: PMS - UPLOAD DOCUMENTS ::.</title>
    
    <link href="../css/styleB.css" rel="stylesheet" type="text/css" />
    
    <!--    Loading Jquerry Plugin  -->
    <link type="text/css" href="../jQuerry/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    
    <script type="text/javascript" src="../jQuerry/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../jQuerry/js/jquery-ui-1.8.16.custom.min.js"></script>    
    
  
    <link type="text/css" href="../css/textstyles.css" rel="stylesheet" />
    
	<link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
	<link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
	<script type="text/javascript" src="../js/jquery.uploadify.js"></script>
    <script src="../js/jquery.validate.js" type="text/javascript"></script>
    
    <link rel="stylesheet" href="../uploadify/uploadify.css" type="text/css" />   
    <link rel="stylesheet" href="../css/uploadify.styling.css" type="text/css" />
    <script type="text/javascript" src="../js/jquery.uploadify.js"></script>
    <script type="text/javascript" src="../js/jquery.fileupload.js"></script> 
    <script type="text/javascript" src="../js/jquery.ui.widget.js"></script> 
  	<script type="text/javascript">

        var queueSize = 0;

        function startUpload(){
	
            var valdator = false;
            valdator = $("#frm_UploadDocuments").valid();			
            if(valdator != false){
                if (queueSize == 0) {
                    //alert("No Any Files to Upload!");
					document.getElementById('Div_Msg').innerHTML = '*** No Any Files to Upload ***';
                   // document.forms['frm_UploadDocuments'].action = "UploadDocuments.php?btn_Upload=btn_Upload";
//                    document.forms['frm_UploadDocuments'].submit();
                }						
			var workflowid = document.getElementById('hddWorkflowId').value;
                $('#fileUploadstyle').fileUploadStart();
            }
        }
//?workflowid='+workflowid+',empid='+empid+'
        $(document).ready(function() {
			var empid = document.getElementById('hddLogUser').value;
			var workflowid = document.getElementById('hddWorkflowId').value;
            $("#fileUploadstyle").fileUpload({
                'uploader': '../uploadify/uploader.swf',
                'cancelImg': '../uploadify/cancel.png',
                'script': '../uploadify/uploaddocument.php',
                'folder': 'files',
                'fileExt': '*.pdf;*.PDF;*.doc;*.DOC;*.docx;*.DOCX;*.xls;*.XLS;*.xlsx;*.XLSX;*.psd;*.PSD;*.ai;*.AI;*.zip;*.ZIP;*.rar;*.RAR;*.exe;*.EXE',
                'multi': true,
                'simUploadLimit': 1,
                'sizeLimit': 200000000,
                'displayData': 'speed',
                'width': 110,
                'height': 25,
				'scriptData'     : {'workflowid': workflowid , 'empid': empid},
                'onCancel': function (a, b, c, d) {
                    queueSize = d.fileCount;
                },
                'onClearQueue': function (a, b) {
                    queueSize = b.fileCount;
                },
                'onSelectOnce': function (a, b) {
                    queueSize = b.fileCount;
                },
                'onComplete'  : function(event, ID, fileObj, response, data) {
                    //alert('complete');
                    //alert('There are ' + data.fileCount + ' files remaining in the queue.');
                },
                'onAllComplete' : function(event,data) {
                    queueSize = 0;
					document.getElementById('Div_Msg').innerHTML = data.filesUploaded + ' files uploaded successfully';
                    //alert(data.filesUploaded + ' files uploaded successfully!');
                   // document.forms['frm_UploadDocuments'].action = "UploadDocuments.php?btnSave=btnSave";
//                    document.forms['frm_UploadDocuments'].submit();
                }}
            );
        });
</script>
  
    <script>
		$(function() {
	            $( "input:submit", ".demo" ).button();
	            $( "input:button", ".demo" ).button();
		}); 
    </script>  
   
</head>
    <body>
      <?php  
      if(isset($_GET['id'])){
        $_SESSION["aid"]= $_GET['id'];
        $aid = $_GET['id'];
      }
      
      if(isset($_POST["btn_Upload2"])){
          $Names = array_values(array_filter(array_map('trim', $_FILES['file']['name']))); 
          $TempNames = array_values(array_filter(array_map('trim', $_FILES['file']['tmp_name']))); 
          $Types = array_values(array_filter(array_map('trim', $_FILES['file']['type']))); 
          
          $filecount = sizeof($Names);
          if($filecount!=0){
              for($i=0;$i<$filecount;$i++){
                  fileUploadTaskNew($str_dbconnect,$Names[$i],$TempNames[$i],$Types[$i],$_SESSION["aid"]); 
              }  
          } 
          $_SESSION["aid"] = ""; 
          echo("<script>location.href = '../workflow/UpdateWorkFlow.php';</script>");
      }  

	  function get_KJRDetails($str_dbconnect,$empno) {

   		$_SelectQuery 	=   "SELECT * FROM tbl_employee WHERE `EmpCode` = '$empno'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $etf    =	$_myrowRes['EmpNIC'];
        }

    $_CompCode      =	$_SESSION["CompCode"];

    $_SelectQuery   = 	"SELECT * FROM tbl_kjr where etfno='$etf'" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    return $_ResultSet;
	}
	  
	function getEMPLOYEEDETAILS($str_dbconnect) {

		$_SelectQuery 	= 	"SELECT * FROM tbl_employee WHERE EmpSts = 'A' order by FirstName" or die(mysqli_error($str_dbconnect));

		$_ResultSet 	= mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


		return $_ResultSet ;

	}	  
	  
	  ?>
         
        
<form id="frm_UploadDocuments" name="frm_UploadDocuments" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
    <table width="100%" cellpadding="0" cellspacing="0" >
        <tr>
            <td align="left">
                <div id="wrapper">
                    <table width="100%" cellpadding="0" cellspacing="0">                       
                        <tr>
                            <td align="left" style="width: 100%; vertical-align: top;">
                                <div id="right" >
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr style="height: 50px; background-color: #E0E0E0;">
                                            <td style="padding-left: 10px; font-size: 16px">
                                                <font color="#0066FF">Upload Documents</font> - For the WorkFlow ( <?php echo $_SESSION["aid"];?> )                                           
                                            </td>                                                                                             
                                        </tr> 
                                                                                  
                                        <tr align="center">                                                                                        
                                        </tr>
                                    </table>
                                    <br></br>                                    
                                    <table width="98%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>                                                
                                                <table width="100%" cellpadding="0" cellspacing="8px"> 
                                                <tr>
                                                     <td>
                                                     	<div align="center" id="Div_Msg" style="font-size:16px; color:#FF0000;" >	</div>
                                                     </td>
                                                     <td></td>
                                                     <td></td>
                                                </tr> 
                                                <tr>
                                                        <!-- <td align="center">
                                                            Upload / Download - Task Documents
                                                        </td>
                                                        <td>
                                                            :
                                                        </td>
                                                          <td>
                                                            <div id="fileUploadstyle">You have a problem with your javascript</div>
                                                            <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()">Clear Queue</a>
                                    
                                                            <p></p>
                                                            
                                                   		 </td> -->
                                                            <td>
                                                    <input type="file" name="file[]" id="files" multiple>
								                        <hr width=100% size="1" color="" align="center">
                                                    </td>
                                                   </tr>    						
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="demo">
                                                                <br></br>
                                                                <center>                        
                                                                <input type="submit"  value="Upload"  id="btn_Upload2" name="btn_Upload2" />            
                                                                </center>
                                                            </div>                                                            
                                                        </td> 
                                                                                                       
                                                    </tr >
                                                </table>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                        <td colspan="2" style="width: 100%">
                                            <div id="footer">
                                                <?php include ('../footer.php') ?>
                                            </div>
                                        </td>
                                        </tr>
                                    </table>                                    
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>            
        </tr>   
        <tr>            
        </tr>
    </table>
    <script>
        getWFDetails();
    </script>
    
</form>    
</body>
</html> 
