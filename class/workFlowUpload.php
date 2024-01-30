<?php

// JQuery File Upload Plugin v1.4.1 by RonnieSan - (C)2009 Ronnie Garcia
function fileUploadNew($str_dbconnect,$file_name,$file_tmp_name,$file_type,$_Serial_Val,$Str_WKID){
/* if (!empty($_FILES)) { */
    /* 
        $_Serial_Val = 0;
        
        $_SelectQuery 	=   "SELECT * FROM tbl_serials WHERE `CompCode` = 'CIS' AND `Code` = '1052'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_Serial_Val    =	$_myrowRes['Serial'];
        }
        
        $_Serial_Val = $_Serial_Val + 1;
        
        $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = 'CIS' AND Code = '1052'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect)); */
    
        $Count = $_Serial_Val;
        
	/* $tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/'; */
	
	$UploadName = $file_name;
	//$targetFile = 'uploaded_imgC/'.$UploadName;

    $NewFileCode = $_SESSION["NewUPLCode"];
    
    //$UploadName = $_FILES['Filedata']['name'];
    
	$name = substr(strrchr($file_name,'.'),0);
	$info = pathinfo($file_name);
	$name =  basename($file_name,'.'.$info['extension']);
	
	$file_type = substr(strrchr($file_name,'.'),1);
    //$UploadFileType = substr($UploadName,strripos($UploadName,'.'),strlen($UploadName));
    
    //$NewFileName = $NewFileCode."-".$Count."".$UploadFileType;
	//$tempFile2 = '../files/Supreme%20Flora%20-%20Quotation.pdf'; 
    $NewFileName = $name."-".$NewFileCode."-".$Count.".".$file_type;
	$tempFile = $file_tmp_name;
    $_CrtBy         =	$_SESSION["LogEmpCode"];
    $Dte_CrtDate    = 	date("Y/m/d") ;
	$targetFile = '../workflow/files/'.$file_name;
	
    $_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`,`ParaCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$NewFileCode','$Str_WKID', '$UploadName', '$NewFileName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

    //$targetFile =  str_replace('//','/',$targetPath) . $NewFileName;

   // $_SESSION["UploadeFileCode"]   =   $_SESSION["UploadeFileCode"].":".$NewFileName;

	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
	
	

	/* // ftp settings
    $ftp_hostname = 'ftp2.tkse.lk'; // change this
    $ftp_username = 'PmsAdmin'; // change this
    $ftp_password = '8Gs8$nk4612'; // change this
    //$remote_dir = '/path/to/folder'; // change this
    //$src_file = $_FILES['srcfile']['name'];
	
    //upload file
    if ($file_name!='')
    {
		/* // remote file path
        $dst_file = $remote_dir . $src_file; 
        // connect ftp
        $ftpcon = ftp_connect($ftp_hostname) or die('Error connecting to ftp server...');
        
        // ftp login
        $ftplogin = ftp_login($ftpcon, $ftp_username, $ftp_password) or die('Error logging to ftp server...');
		ftp_pasv($ftpcon, true) or die("Passive mode failed");
        
        // ftp upload
        if (ftp_put($ftpcon, $targetFile, $tempFile, FTP_ASCII) or die('Error putting to ftp server...'))
            echo 'File uploaded successfully to FTP server!';
        else
            echo 'Error uploading file! Please try again later.';
        // close ftp stream
        ftp_close($ftpcon);
	}
	else
        echo "Go Back";
	 */

/* 
} */
}
/* 
  			switch ($_FILES['Filedata']['error'])
				{  	case 0:
						$msg = "No Error";
						break;
					case 1:
           				$msg = "The file is bigger than this PHP installation allows";
           				break;
   					case 2:
           				$msg = "The file is bigger than this form allows";
           				break;
    				case 3:
           				$msg = "Only part of the file was uploaded";
           				break;
    				case 4:
          		 		$msg = "No file was uploaded";
           				break;
					case 6:
          		 		$msg = "Missing a temporary folder";
           				break;
    				case 7:
          		 		$msg = "Failed to write file to disk";
           				break;
    				case 8:
          		 		$msg = "File upload stopped by extension";
           				break;
 					default:
						$msg = "unknown error ".$_FILES['Filedata']['error'];
						break;
				}

	$setupFile = "uploadVARresults.txt";
	$fh = fopen($setupFile, 'w');
	if ($fh) {
		$stringData = "path: ".$_GET['folder']."\n targetFile: ".$targetFile."\n Error: ".$_FILES['Filedata']['error']."\nError Info: ".$msg;
	}
	fwrite($fh, $stringData);
	fclose($fh);
	
	echo '1'; */

?>