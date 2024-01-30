<?php 
include ('../connection/reportconnection.php');
//include ('../connection/sqlconnection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Indicator Details</title>
</head>
<body>
<?php  
	 $_command    		=   "";
  	 $_indicatorid     	=   "";
     $_indicatorname    =   "";
     $_indicatordescription  =   "";
	 
	  if(isset($_GET["cmd"]))
    {
        $_command     =   $_GET["cmd"];
    }
	 if(isset($_GET["indid"]))
    {
        $_indicatorid     =   $_GET["indid"];
    }
	 if(isset($_GET["indname"]))
    {
        $_indicatorname     =   $_GET["indname"];
    }
	 if(isset($_GET["inddes"]))
    {
         $_indicatordescription  =   $_GET["inddes"];
    }
	 
	
	
	$obj = new Connection();
	$obj->Connect();
				
	if ($_command=="save"){
		if (($_indicatorid=="")||($_indicatorname=="")||($_indicatordescription =="")){
			echo "Couldn't Insert... Check Your Indicator Details";
		}
		else {
			$obj->insertIndicator($_indicatorid,$_indicatorname,$_indicatordescription);
		}
	}
	else if ($_command=="upt"){
		if (($_indicatorid=="")&&($_indicatorname=="")&&($_indicatordescription =="")){
			echo "Couldn't Update... Check Your Indicator Details";
		}
		else {
			$obj->updateIndicator($_indicatorid,$_indicatorname,$_indicatordescription);
		}
	}?>

<form name="indicatordetail" id="indicatordetail">
<table width="600" border="1">
  <tr>
    <th scope="row">Indicator ID</th>
    <td><?php echo $_indicatorid; ?></td>
  </tr>
  <tr>
    <th scope="row">Indicator Name</th>
    <td><?php echo $_indicatorname; ?></td>
  </tr>
  <tr>
    <th scope="row">Indicator Description</th>
    <td><?php echo $_indicatordescription; ?></td>
  </tr>  
</table>

</form>

    
</body>
</html>