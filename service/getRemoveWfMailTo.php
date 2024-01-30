	<?php 
	//$connection = include_once('../connection/sqlconnection.php');
    //$connection = include_once('../connection/previewconnection.php');
	$connection = include_once('../connection/mobilesqlconnection.php');
	include ("../class/accesscontrole.php");
	
    
	$worfflowId = $_GET["workflowId"];
	$workflowCategory =$_GET["workflowCategory"];
	$LogUserCode = $_GET["EmpCode"];
	
	$_MailAdd   =   "";
	$_SelectQuery = "";
	
	if($worfflowId!= null & $workflowCategory != null)
	{
		
		if($workflowCategory == 'USRWF')
		{
			$_SelectQuery = "SELECT * FROM `tbl_employee` where `EmpCode`='$LogUserCode'";
		}
		else
		{
			$_SelectQuery 	=   "SELECT E.`EMail` FROM `tbl_employee` E INNER JOIN `tbl_wfalert` WA on E.`EmpCode`= WA.`EmpCode` WHERE WA.`FacCode`='$worfflowId'";
			
		}
		
	
    $_ResultSet 	= mysqli_query($link,$_SelectQuery) or die(mysqli_error($link));
	$Result1 = mysqli_num_rows($_ResultSet);
    
    while($_myrowRes = mysqli_fetch_assoc($_ResultSet)) 
	{
		
        $_MailAdd    =   $_MailAdd.$_myrowRes['EMail'].",";
		
		
    }
	
	}
	
	 $_MailAdd = substr( $_MailAdd,0,-1);
     
	 $array = "[{";
	$array =$array.'"EmailTo":"'  . $_MailAdd.'"}]';
	echo $array;
	 
    return $array;
	

	?>