<?php
function fileUploadTaskNew($str_dbconnect,$file_name,$file_tmp_name,$file_type){
if (!empty($_FILES)) {
 	$usereid=$_SESSION['LogUserCode'];
	$empid= $_SESSION["LogEmpCode"];
	$TaskCode = $_SESSION["TaskCode"];
    $DocId= $TaskCode.$empid ;

	//$tempFile = $_FILES['Filedata']['tmp_name'];
	$tempFile = $file_tmp_name;
	//$targetFile = '../files/'.$file_name;
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	
	$NewFileCode = create_FileName($str_dbconnect);
	$tempFilecode = substr($NewFileCode,4);
	$tempFilecode = $tempFilecode-1;
	$NewFileCode = "UPL-".$tempFilecode;
	//$empid = substr($tempempid,0,-18);
	$NewFileCode2 = "UPL-".$tempFilecode."-".$_SESSION["LogEmpCode"];
    /*$NewFileCode = $_SESSION["NewUPLCode"];*/

    $NewFileName = $NewFileCode."-".$file_name;
	//$_CrtBy         =	$_SESSION["LogEmpCode"];
    $Dte_CrtDate    = 	date("Y/m/d");
	

	$_SelectQuery   = 	"SELECT * FROM tbl_task WHERE active = 1 AND AssignBy = '$empid' ORDER BY sublevel, parent" or die(mysqli_error($str_dbconnect));
    $_ResultSet     =   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
        $Str_SubLevel    =	$_myrowRes["sublevel"];
    }

    $_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`,`ParaCode`, `FileName`, `SystemName`, `CreatBy`,`CreatEmp`, `CreatDate`,`active`)
	 VALUES ('$NewFileCode','$DocId', '$tempFile', '$NewFileName','$usereid', '$empid', '$Dte_CrtDate',1)" 
	 or die(mysqli_error($str_dbconnect));

	//  var_dump($_SelectQuery ); die(); 
	 

	//  INSERT INTO prodocumets (`ProCode`,`ParaCode`, `FileName`, `SystemName`, `CreatBy`,`CreatEmp`, `CreatDate`,`active`)
	//   VALUES ('UPL-83834','', '/Applications/XAMPP/xamppfiles/temp/phptSKiAf', 'UPL-83834-dwddwdw.docx','USR/1040', 
	//   'EMP/995', '2023/11/30',9)

    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
	
	//$targetFile =  str_replace('//','/',$targetPath) . $NewFileName;
	$targetFile = 'files/'.$NewFileName;
	
    $_SESSION["UploadeFileCode"]   =   $_SESSION["UploadeFileCode"].":".$NewFileName;

	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	move_uploaded_file($tempFile,$targetFile);

}
}

function fileUploadProjectNew($str_dbconnect,$file_name,$file_tmp_name,$file_type, $Str_ProCode){

	if (!empty($_FILES)) {
	
		 $usereid=$_SESSION['LogUserCode'];
		$empid= $_SESSION["LogEmpCode"];
		$TaskCode = $_SESSION["TaskCode"];
	
		//$tempFile = $_FILES['Filedata']['tmp_name'];
		$tempFile = $file_tmp_name;
		//$targetFile = '../files/'.$file_name;
		//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
		
		$NewFileCode = create_FileName($str_dbconnect);
		$tempFilecode = substr($NewFileCode,4);
		$tempFilecode = $tempFilecode-1;
		$NewFileCode = "UPL-".$tempFilecode;
		//$empid = substr($tempempid,0,-18);
		$NewFileCode2 = "UPL-".$tempFilecode."-".$_SESSION["LogEmpCode"];
		/*$NewFileCode = $_SESSION["NewUPLCode"];*/
	
		$NewFileName = $NewFileCode."-".$file_name;
		//$_CrtBy         =	$_SESSION["LogEmpCode"];
		$Dte_CrtDate    = 	date("Y/m/d");
	
		$_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`,`ParaCode`, `FileName`, `SystemName`, `CreatBy`,`CreatEmp`, `CreatDate`,`active`)
		 VALUES ('$NewFileCode','$Str_ProCode', '$tempFile', '$NewFileName','$usereid', '$empid', '$Dte_CrtDate',1)" 
		 or die(mysqli_error($str_dbconnect));
	
		mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
		//$targetFile =  str_replace('//','/',$targetPath) . $NewFileName;
		$targetFile = 'files/'.$NewFileName;
		
		$_SESSION["UploadeFileCode"]   =   $_SESSION["UploadeFileCode"].":".$NewFileName;
	
		move_uploaded_file($tempFile,$targetFile);
	
	}
	}

?>


