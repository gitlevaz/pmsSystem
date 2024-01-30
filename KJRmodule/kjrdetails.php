<?php 
include ('../connection/reportconnection.php');
//include ('../connection/sqlconnection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KJR Details</title>
</head>
<body>
<?php  
	 $_command    		=   "";
  	 $_kjrid     		=   "";
     $_departmentid     =   "";
     $_desisnationid    =   "";
     $_kjrname          =   "";
     $_description      =   "";
	 $_etfno      		=   "";
	 
	  if(isset($_GET["cmd"]))
    {
        $_command     =   $_GET["cmd"];
    }
	 if(isset($_GET["kjrid"]))
    {
        $_kjrid     =   $_GET["kjrid"];
    }
	 if(isset($_GET["depid"]))
    {
        $_departmentid     =   $_GET["depid"];
    }
	 if(isset($_GET["desid"]))
    {
        $_desisnationid     =   $_GET["desid"];
    }
	 if(isset($_GET["kname"]))
    {
        $_kjrname     =   $_GET["kname"];
    } 
	if(isset($_GET["kdes"]))
    {
        $_description     =   $_GET["kdes"];
    } 
	if(isset($_GET["etfno"]))
    {
        $_etfno     =   $_GET["etfno"];
    } 
	
	
	$obj = new Connection();
	$obj->Connect();
				
	if ($_command=="save"){
		if (($_kjrid=="")||($_departmentid=="")||($_desisnationid =="")||($_kjrname =="")||($_description=="")||($_etfno =="")){
			echo "Couldn't Insert... Check Your KJR Details";
		}
		else {
			$obj->insertKJR($_kjrid,$_departmentid,$_desisnationid,$_kjrname,$_description,$_etfno);
		}
	}
	else if ($_command=="upt"){
		if (($_kjrid=="")&&($_departmentid=="")&&($_desisnationid =="")&&($_kjrname =="")&&($_description=="")||($_etfno =="")){
			echo "Couldn't Update... Check Your KJR Details";
		}
		else {
			$obj->updateKJR($_kjrid,$_departmentid,$_desisnationid,$_kjrname,$_description,$_etfno);
		}
	}?>

<form name="kjrdetal" id="kjrdetai">
<table width="600" border="1">
  <tr>
    <th scope="row">KJR ID</th>
    <td><?php echo $_kjrid; ?></td>
  </tr>
  <tr>
    <th scope="row">Department ID</th>
    <td><?php echo $_departmentid; ?></td>
  </tr>
  <tr>
    <th scope="row">Designation ID</th>
    <td><?php echo $_desisnationid; ?></td>
  </tr>
  <tr>
    <th scope="row">KJR Name</th>
    <td><?php echo $_kjrname; ?></td>
  </tr>
  <tr>
    <th scope="row">Description</th>
    <td><?php echo $_description; ?></td>
  </tr>
</table>

</form>

    
</body>
</html>