<?php

// JQuery File Upload Plugin v1.4.1 by RonnieSan - (C)2009 Ronnie Garcia
function fileUploadNew($str_dbconnect,$file_name,$file_tmp_name,$filecount){

    $Count = $filecount;
        
	$UploadName = $file_name;
	//$targetFile = 'uploaded_imgC/'.$UploadName;

    $NewFileCode = $_SESSION["NewUPLCode"];
    
    //$UploadName = $_FILES['Filedata']['name'];
    
	$name = substr(strrchr($file_name,'.'),0);
	$info = pathinfo($file_name);
	$name =  basename($file_name,'.'.$info['extension']);
	
	$file_type = substr(strrchr($file_name,'.'),1);
    
    $NewFileName = $name."-".$NewFileCode."-".$Count.".".$file_type;
	$tempFile = $file_tmp_name;
    $_CrtBy         =	$_SESSION["LogEmpCode"];
    $Dte_CrtDate    = 	date("Y/m/d") ;
	$targetFile = 'files/'.$file_name;
	
    /* $_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`,`ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$NewFileCode','$Str_WKID', '$UploadName', '$NewFileName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); */
	move_uploaded_file($tempFile,$targetFile);
	
}

?>