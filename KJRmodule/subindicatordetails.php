<?php 
include ('../connection/reportconnection.php');
//include ('../connection/sqlconnection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SUBIndicator Details</title>
</head>
<body>
<?php  
	 $_command    		=   "";
  	 $_subindicatorid     	=   "";
     $_subindicatorname    =   "";
     $_subindicatordescription  =   "";
	 $_indicatorid     	=   "";
	 
	  if(isset($_GET["cmd"]))
    {
        $_command     =   $_GET["cmd"];
    }
	 if(isset($_GET["subid"]))
    {
        $_subindicatorid     =   $_GET["subid"];
    }
	 if(isset($_GET["sname"]))
    {
        $_subindicatorname     =   $_GET["sname"];
    }
	 if(isset($_GET["sdes"]))
    {
         $_subindicatordescription  =   $_GET["sdes"];
    }
	 if(isset($_GET["indid"]))
    {
         $_indicatorid  =   $_GET["indid"];
    } 
	
	
	$obj = new Connection();
	$obj->Connect();
				
	if ($_command=="save"){
		if (($_subindicatorid=="")||($_subindicatorname=="")||($_subindicatordescription =="")||($_indicatorid=="")){
			echo "Couldn't Insert... Check Your SUBIndicator Details";
		}
		else {
			$obj->insertSubIndicator($_subindicatorid,$_subindicatorname,$_subindicatordescription,$_indicatorid);
		}
	}
	else if ($_command=="upt"){
		if (($_subindicatorid=="")&&($_subindicatorname=="")&&($_subindicatordescription =="")&&($_indicatorid=="")){
			echo "Couldn't Update... Check Your SUBIndicator Details";
		}
		else {
			$obj->updateSubIndicator($_subindicatorid,$_subindicatorname,$_subindicatordescription,$_indicatorid);
		}
	}?>

<form name="subindicatordetail" id="subindicatordetail">
<table width="600" border="1">
  <tr>
    <th scope="row">SUB Indicator ID</th>
    <td><?php echo $_subindicatorid; ?></td>
  </tr>
  <tr>
    <th scope="row">SUB Indicator Name</th>
    <td><?php echo $_subindicatorname; ?></td>
  </tr>
  <tr>
    <th scope="row">SUB Indicator Description</th>
    <td><?php echo $_subindicatordescription; ?></td>
  </tr> 
   <tr>
    <th scope="row">Indicator ID</th>
    <td><?php echo $_indicatorid; ?></td>
  </tr>   
</table>

</form>

    
</body>
</html>