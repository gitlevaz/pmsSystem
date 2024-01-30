<?php



    include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database    //  connection file to the mysql database
    include ("../class/accesscontrole.php"); //  sql commands for the access controles
    //include ("sql_empdetails.php"); //  connection file to the mysql database
    //include ("sql_crtprocat.php");            //  connection file to the mysql database

    //require_once("class.phpmailer.php");
    #include ("../class/MailBodyOne.php"); //  connection file to the mysql database

    //include ("sql_wkflow.php");            //  connection file to the mysql database

    mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

		if(isset($_GET['Command']) && isset($_GET['UserName']) && isset($_GET['Password']) && $_GET['Command'] == "ValidateLogin"){

		//	echo("");

        $_UserName				= 	$_GET['UserName'];
				$_Password				= 	encode5t($_GET['Password']);

				$_result = "";

				$str_SelectQuery        = 	"SELECT * FROM tbl_sysusers WHERE User_name = '$_UserName' AND User_password = '$_Password'" or die(mysqli_error($str_dbconnect));
		    $str_ResultSet          =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));

		    while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {

						if($_result != ""){$_result .= ",";}

						$_result .= '[{"userId" : "' . $_myrowRes['Id'] . '",';
						$_result .= '"userName" : "' . $_myrowRes['User_name'] . '",';
						$_result .= '"employeeCode" : "' . $_myrowRes['EmpCode'] . '",';
						$_result .= '"userStatus" : "' . $_myrowRes['UserStat'] . '"}]';
		    }

				echo($_result);
		}

		if(isset($_GET['Command']) && $_GET['Command'] == "ActiveProjectsByTaskOwner" && isset($_GET['employeeCode'])){

			$_employeeCode = $_GET['employeeCode'];
			$_result = "[";

			$str_SelectQuery    = 	"SELECT * FROM tbl_projects WHERE procode IN (SELECT DISTINCT procode FROM tbl_task WHERE taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$_employeeCode'))" or die(mysqli_error($str_dbconnect));
			$str_ResultSet     =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));

			  while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {

					if($_result != "["){$_result .= ",";}

					$_result .= '{"projectId" : "' . $_myrowRes['id'] . '",';
					$_result .= '"companyCode" : "' . $_myrowRes['compcode'] . '",';
					$_result .= '"projectCode" : "' . $_myrowRes['procode'] . '",';
					$_result .= '"projectName" : "' . $_myrowRes['proname'] . '",';
					$_result .= '"startDate" : "' . $_myrowRes['startdate'] . '",';
					$_result .= '"projectStatus" : "' . $_myrowRes['prostatus'] . '"}';

			}

			$_result .= "]";

			echo($_result);


		}
		
		
		if(isset($_GET['Command']) && $_GET['Command'] == "TaskListUnderProjectByTaskOwner" && isset($_GET['employeeCode']) && isset($_GET['projectCode'])){

			$_employeeCode = $_GET['employeeCode'];
			$_projectCode = $_GET['projectCode'];
			$_result = "[";

			$str_SelectQuery    = 	"SELECT * FROM tbl_task WHERE procode = '$_projectCode' AND taskcode IN (SELECT TaskCode FROM tbl_taskowners WHERE EmpCode = '$_employeeCode') ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
			$str_ResultSet     =   mysqli_query($str_dbconnect,$str_SelectQuery) or die(mysqli_error($str_dbconnect));

			  while($_myrowRes = mysqli_fetch_array($str_ResultSet)) {

					if($_result != "["){$_result .= ",";}
					
					$_result .= '{"companyCode" : "' . $_myrowRes['compcode'] . '",';
					$_result .= '"projectCode" : "' . $_myrowRes['procode'] . '",';
					$_result .= '"taskCode" : "' . $_myrowRes['taskcode'] . '",';
					$_result .= '"taskName" : "' . $_myrowRes['taskname'] . '",';
					$_result .= '"taskDetails" : "' . $_myrowRes['TaskDetails'] . '",';
					$_result .= '"taskStatus" : "' . $_myrowRes['taskstatus'] . '"}';

			}

			$_result .= "]";

			echo($_result);


		}
		
		 

			//echo("Shameera Prajapriya");
?>
