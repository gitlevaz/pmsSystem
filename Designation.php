<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
    session_start();
    include ("connection\sqlconnection.php");   //  connection file to the mysql database
    include ("class\sql_crtgroups.php");   //  connection file to the mysql database
	include ("class\sql_empdetails.php");
	include ("class\accesscontrole.php");  
    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");
	$path = "";
$Menue	= "Designation";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS DESIGNATION DETAILS ::.</title>
	
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <link href="css/textstyles.css" rel="stylesheet" type="text/css" />
    <link href="css/crtusergroup.css" rel="stylesheet" type="text/css" />

    <style type="text/css" title="currentStyle">
            @import "media/css/demo_page.css";
            @import "media/css/demo_table.css";
    </style>

    <script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.13.custom.css" type="text/css" />
    <!--<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />-->

	<link href="css/styleB.css" rel="stylesheet" type="text/css" /> 
    <script src="jQuerry/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jQuerry/development-bundle/ui/jquery.ui.button.js"></script>
    
    <script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>

    <script type="text/javascript" charset="utf-8">
       function getPageSize() {
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );
            parent.resizeIframeToFitContent(height);
        }

        $(document).ready(function() {
            $('#example').dataTable();
        } );
    </script>
     <script type="text/javascript" charset="utf-8">

        function getPageSize() {/*
            var body = document.body,
                html = document.documentElement;

            var height = Math.max( body.scrollHeight, body.offsetHeight,
                                   html.clientHeight, html.scrollHeight, html.offsetHeight );            
            parent.resizeIframeToFitContent(height);*/
        }
		
	/*	 function ValidateSave(){           
            document.forms[0].action = "Designation.php?&Save="SAVE"";
            document.forms[0].submit();
        }
		
		 function ValidateUpdate(){           
            document.forms[0].action = "Designation.php?&Update="UPDATE"";
            document.forms[0].submit();
        }
		 function ValidateDelete(){           
            document.forms[0].action = "Designation.php?&Delete="DELETE"";
            document.forms[0].submit();
        }*/

        function View(hlink){           
            document.forms[0].action = "Designation.php?&descode="+hlink+"";
            document.forms[0].submit();
        }
		
		$(window).load(function() { 
	         $('#preloader').fadeOut('slow', function() { $(this).remove(); }); 
	    });
		
		$(document).ready(function() {
	        $('#example').dataTable();
	    } );
    </script>

</head>
    <?php
		$Str_TempDesCode ="";
        $Str_DesignationCode    =   "";
        $Div_Error = "";
        $DesignationCode = "";
        $Designation = "";
        $Description = "";	
        
       	if (isset($_POST['btnSave'])) {
		
			$ErrorField = "";
			if(""==$_POST["txtDesignation"]){ $ErrorField = $ErrorField. " "."Designation"; }
			if(""==$_POST["txtDescription"]){ $ErrorField = $ErrorField. " , "."Description"; }
			
			if("" == $ErrorField)
			{
				$Result_Add = AddDesignationDetails($str_dbconnect,$_POST["hddDesignationCode"],$_POST["txtDesignation"],$_POST["txtDescription"]);
				if(1==$Result_Add)
				{			 
				 $Div_Error = "*** Designation Added Successfully" ;
				 }
				 else
				  {
				  $Div_Error = "*** Insertion Error. Please Check Data" ;
				 }
				 	
			}
			else 
			{
				$Div_Error = "*** Data Cannot be blank on " . $ErrorField ;
			}	
			$Str_DesignationCode    =   "";
					$DesignationCode = "";
					$Designation = "";
					$Description = "";		
					$boolean_Selected = "N";
			
					$DesignationCode = getNextDesignationCode($str_dbconnect);		 
        }
		
		else if (isset($_POST['btnUpdate'])) {
		
			$ErrorField = "";
				if(""==$_POST["txtDesignation"]){ $ErrorField =$ErrorField. " "."Designation"; }
				if(""==$_POST["txtDescription"]){ $ErrorField = $ErrorField." , "."Description"; }
				
				if("" == $ErrorField)
				{
					$Result_Update = UpdateDesignationDetails($str_dbconnect,$_POST["hddDesignationCode"],$_POST["txtDesignation"],$_POST["txtDescription"]);
					if(1==$Result_Update){		
						 $Div_Error = "*** Designation Updated Successfully";
					 }
					 else {
					  $Div_Error = "*** Update Error. Please Check Data";
					}
					
				}
				else 
				{
					 $Div_Error = "*** Data Cannot be blank on". $ErrorField;
				}	
				$Str_DesignationCode    =   "";
					$DesignationCode = "";
					$Designation = "";
					$Description = "";		
					$boolean_Selected = "N";
			
					$DesignationCode = getNextDesignationCode($str_dbconnect);
						
        }
		else if (isset($_POST['btnDelete'])) {
				$Result_Delete = DeleteDesignationDetails($str_dbconnect,$_POST["hddDesignationCode"]);
				if(1==$Result_Delete){		
					   $Div_Error = "*** Designation Deleted Successfully";
				 }
				 else {
				   $Div_Error = "*** Delete Error. Please Check Data";
				}
				$Str_DesignationCode    =   "";
				$DesignationCode = "";
				$Designation = "";
				$Description = "";		
				$boolean_Selected = "N";
		
				$DesignationCode = getNextDesignationCode($str_dbconnect);
				 
        }		
		
		else if (isset($_GET["descode"])) {
		
			$DesignationResultSet ="";		
			$DesignationResultSet = getSelectedDesignationDetails($str_dbconnect,$_GET["descode"]);		
		
			while($_myrowRes = mysqli_fetch_array($DesignationResultSet)) {
				$DesignationCode    =   $_myrowRes['DesCode'];
				$Designation  =   $_myrowRes['Designation'];
				$Description  =   $_myrowRes['Task'];
			}
			$boolean_Selected = "Y";
			$Str_TempDesCode = $DesignationCode;
        }
		
		else 
		{
			$Str_TempDesCode ="";
			$Str_DesignationCode    =   "";
			$Div_Error = "";
			$DesignationCode = "";
			$Designation = "";
			$Description = "";		
			$boolean_Selected = "N";
	
			$DesignationCode = getNextDesignationCode($str_dbconnect);
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
                                                <font color="#0066FF"><strong>Designation</strong> </font> <div id="Message_Info" style="margin-left:720px; color:#FF0000"  ><?php echo $Div_Error;?></div>                             
                                            </td>                                                                                           
                                        </tr>    
                                        <tr align="center">
                                        	                                                 
                                        </tr>
                                    </table>
                                    <br></br>  
									<table width="25%" cellpadding="0" cellspacing="0" align="right" style="padding-right:20px">
										<tr>
											<!--<td>  
                        						<input type="submit"  id="btnBack" name="btnBack" title="Go to Previous Page" class="buttonBack"  value="     " size="5"/>
                   							</td>
                   							<td> 
                        						<input type="submit" id="btnSearch" name="btnSearch" title="Search Project Details" class="buttonSearch" value="     " size="5" />
                    						</td>
                   							<td> 
                        						<input type="submit" id="btnAdd" name="btnAdd" title="Add New Project" class="buttonAdd" value="     " size="5"/>
                    						</td>
                   							<td> 
                        						<input type="submit" id="btnEdit" name="btnEdit" title="Edit Project" class="buttonEdit" value="     " size="10"/>
                    						</td>
                   							<td> 
                        						<input type="submit" id="btnDelete" name="btnDelete" title="Delete Current Project" class="buttonDel" value="     " size="10"/>
                    						</td>
                   							<td> 
                        						<input type="submit" id="btnPrint" name="btnPrint" title="Print Project Details" class="buttonPrint" value="     " size="10"/>
                   							</td>-->
                                            </tr>
									</table>  
                   							
<!--                    creating data entry Interface-->

                    <br><br><br>
                    
                    <legend ><strong>Create Designation</strong></legend><br/>
 									<table width="98%" cellpadding="0" cellspacing="8px" align="center">
                                        <tr>
                                            <td>
												<tr>
                                                    <td width="20%">Designation Code </td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input type="text" id="txtDesignationCode" name="txtDesignationCode" class="required ui-widget-content" size="20" value="<?php echo $DesignationCode;  ?>" readonly="readonly" />
                                                        <input type="hidden" id="hddDesignationCode" name="hddDesignationCode" class="required ui-widget-content" size="20" value="<?php echo $DesignationCode;  ?>" />
                        							</td>
                                                </tr> 
												<tr>
                                                    <td width="20%">Designation</td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input type="text" id="txtDesignation" name="txtDesignation" class="required ui-widget-content" size="40" value="<?php echo $Designation; ?>" />
                        							</td>
                                                </tr> 
												<tr>
                                                    <td width="20%">Description</td>
                                                    <td width="2%"></td>
                                                    <td>
                            							<input type="text" id="txtDescription" name="txtDescription" class="required ui-widget-content" size="60" value="<?php echo $Description; ?>" />
                       								</td>
                                                </tr>
                                                <tr height="12px"></tr>
												<tr>
													<td colspan="3" align="center">
                                                        <table width="60%" cellpadding="0" cellspacing="0">
                                                            <tr style="height: 50px; background-color: #E0E0E0;">
                                                                <td style="padding-left: 10px; font-size: 16px; border: solid 1px #000080" align="center">                    
                                                                    <input name="btnSave" id="btnSave" type="submit" style="width: 60px" value="Save"<?php  if("Y"==$boolean_Selected){ ?> disabled="disabled" <?php } ?>  />
                                                                    <input name="btnUpdate" id="btnUpdate" type="submit" style="width: 60px" value="Update" <?php  if("N"==$boolean_Selected){ ?> disabled="disabled" <?php } ?>  />
                                                                    <input name="btnDelete" id="btnDelete" type="submit" style="width: 60px" value="Delete" <?php  if("N"==$boolean_Selected){ ?> disabled="disabled" <?php } ?>  />
                                                                    <input name="btnCancel" id="btnCancel" type="reset" style="width: 60px" value="Cancel" <?php  if("Y"==$boolean_Selected){ ?> disabled="disabled" <?php } ?>/>
                   												</td>                                            
                                                            </tr>
                                                        </table>
                                                    </td>
												</tr>
                                              </td>
                                            </tr>
                                         </table><br/><br/><br/>
                
                                        <legend ><strong>Designation Summary</strong></legend><br/>
                                           <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" onmousemove ="getPageSize();">
                                                <thead>
                                                    <tr>
                                                        <th>Designation Code</th>
                                                        <th>Designation</th>
                                                        <th>Description</th>
                                                        <th>S</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $ColourCode = 0 ;
                                                        $LoopCount = 0;
                                                        $_ResultSet = getAllDesignationDetails($str_dbconnect);
                                                        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
                                                            if ($ColourCode == 0 ) {
                                                                $Class = "even gradeC" ;
                                                                $ColourCode = 1 ;
                                                            } elseif ($ColourCode == 1 ) {
                                                                $Class = "odd gradeC";
                                                                $ColourCode = 0 ;
                                                            }
                                                    ?>
                                                        <tr class="<?php echo $Class; ?>">
                                                            <td>
                                                                <?php
                                                                    echo $_myrowRes['DesCode'];
                                                                    $Str_DesignationCode = $_myrowRes['DesId'];
                                                                ?>
                                                            </td>
                                                            <td><?php echo $_myrowRes['Designation']; ?></td>
                                                            <td><?php echo $_myrowRes['Task']; ?></td>
                                                            <td>
                                                                <?php
                                                                    echo "<img src='toolbar/sml_zoom.png' width='12' height='12' style='cursor:pointer' alt='' onclick='View(\"$Str_DesignationCode\")'/>";
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $LoopCount = $LoopCount + 1;
                                                        }
                                                    ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Designation Code</th>
                                                            <th>Designation</th>
                                                            <th>Description</th>
                                                            <th>S</th>
                                                        </tr>
                                                    </tfoot>
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
                                           
                </form>
            </div>
    </body>
</html>