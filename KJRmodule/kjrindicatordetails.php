<?php 
include ('../connection/reportconnection.php');
//include ('../connection/sqlconnection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KJR and Indicator Details</title>
</head>
<body>
<?php  
	 $_command    		=   "";
  	 $_kjrid     	=   "";
     $_cid    =   "";
     $_indid  =   "";
	
	 
	  if(isset($_GET["cmd"]))
    {
        $_command     =   $_GET["cmd"];
    }
	 if(isset($_GET["cid"]))
    {
        $_cid     =   $_GET["cid"];
    }
	 if(isset($_GET["kjrid"]))
    {
        $_kjrid     =   $_GET["kjrid"];
    }
	 if(isset($_GET["indid"]))
    {
         $_indid  =   $_GET["indid"];
    }
	
	
	$obj = new Connection();
	$obj->Connect();
				
	if ($_command=="save"){
		if (($_cid=="")||($_kjrid=="")||($_indid =="")){
			echo "Couldn't Insert... Check Your KJR and Indicator Details";
		}
		else {
			$obj->insertKjrIndicator($_cid,$_kjrid,$_indid);
		}
	}
	else if ($_command=="upt"){
		if (($_cid=="")&&($_kjrid=="")&&($_indid =="")){
			echo "Couldn't Update... Check Your KJR and Indicator Details";
		}
		else {
			$obj->updateKjrIndicator($_cid,$_kjrid,$_indid);
		}
	}?>

<form name="kjrindicatordetail" id="kjrindicatordetail">
<table width="600" border="1">
  <tr>
    <th scope="row">Code</th>
    <td><?php echo $_cid; ?></td>
  </tr>
  <tr>
    <th scope="row">KJR Id</th>
    <td><?php echo $_kjrid; ?></td>
  </tr>
  <tr>
    <th scope="row">Indicator Id</th>
    <td><?php echo $_indid; ?></td>
  </tr> 
   
</table>
</form>

    
</body>
</html>