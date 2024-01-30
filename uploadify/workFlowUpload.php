<?php
session_start();

include ("../connection/sqlconnection.php");
                            //  Role Autherization //  connection file to the mysql database          //  connection file to the mysql database
mysqli_select_db($str_dbconnect,"$str_Database") or die("Unable to establish connection to the MySql database");

$Count = 0;
// JQuery File Upload Plugin v1.4.1 by RonnieSan - (C)2009 Ronnie Garcia
if (!empty($_FILES)) {
    
        $_Serial_Val = 0;
        
        $_SelectQuery 	=   "SELECT * FROM tbl_serials WHERE `CompCode` = 'CIS' AND `Code` = '1052'" or die(mysqli_error($str_dbconnect));
        $_ResultSet 	=   mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));

        while($_myrowRes = mysqli_fetch_array($_ResultSet)) {
            $_Serial_Val    =	$_myrowRes['Serial'];
        }
        
        $_Serial_Val = $_Serial_Val + 1;
        
        $_SelectQuery   = 	"UPDATE tbl_serials SET `Serial` = '$_Serial_Val' WHERE `CompCode` = 'CIS' AND Code = '1052'" or die(mysqli_error($str_dbconnect));
        mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));
    
        $Count = $_Serial_Val;
        
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';

    $NewFileCode = $_SESSION["NewUPLCode"];
    
    $UploadName = $_FILES['Filedata']['name'];
    
    $UploadFileType = substr($UploadName,strripos($UploadName,'.'),strlen($UploadName));
    
    $NewFileName = $NewFileCode."-".$Count."".$UploadFileType;

    $_CrtBy         =	$_SESSION["LogEmpCode"];
    $Dte_CrtDate    = 	date("Y/m/d") ;

    $_SelectQuery   = 	"INSERT INTO prodocumets (`ProCode`, `FileName`, `SystemName`, `CreatBy`, `CreatDate`) VALUES ('$NewFileCode', '$UploadName', '$NewFileName', '$_CrtBy', '$Dte_CrtDate')" or die(mysqli_error($str_dbconnect));
    mysqli_query($str_dbconnect,$_SelectQuery) or die(mysqli_error($str_dbconnect));


    $targetFile =  str_replace('//','/',$targetPath) . $NewFileName;

    $_SESSION["UploadeFileCode"]   =   $_SESSION["UploadeFileCode"].":".$NewFileName;

	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);

	move_uploaded_file($tempFile,$targetFile);

}

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
	
	echo '1';

?>