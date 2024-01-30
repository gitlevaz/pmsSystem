<?php


           /*  string Str_UPLCode = getSerialTask("1020", "PROJECT TEMPORARY CODE UPLOAD", "").ToString();
            Str_UPLCode = "UPL-" + Str_UPLCode;
            return Str_UPLCode; */

 // $connection = include_once('../connection/connection.php');
// $connection = include_once('../connection/previewconnection.php');
$connection = include_once('../connection/mobilesqlconnection.php');
  
    $Serial_Val = -1;
   $SelectQuery = "SELECT * FROM tbl_serials WHERE  Code = '1020'";
  
  $Result=mysqli_query($link,$SelectQuery) or die(mysqli_error($link));
	    $row=mysqli_fetch_assoc($Result);
		 $Serial_Val = $row['Serial'];
         
	  
 
 
 if($row != null)
 {
	 $Serial_Val = $Serial_Val + 1;
	
	 
 }
     else
            {
				
		
	$InsertFirstTime = "INSERT INTO tbl_serials (CompCode, Code, Serial, Desription) VALUES ('CIS', '1020', '0', 'PROJECT TEMPORARY CODE UPLOAD')";
               
	mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
	   
		
	    $query = "SELECT * FROM tbl_serials WHERE `Code` = '1020'";
      $Result=mysqli_query($link,$query) or die(mysqli_error($link));
	    $row=mysqli_fetch_assoc($Result);
	$Serial_Val = $row['Serial'];
			}
		  
		$UpdateSerials = "UPDATE tbl_serials SET Serial = '$Serial_Val' WHERE Code = '1020'";  
		
		mysqli_query($link, $UpdateSerials) or die(mysqli_error($link));

	  $Str_UPLCode = 'UPL-' .$Serial_Val;
            echo $Str_UPLCode; 
?>