<?php

	// $connection = include_once('../connection/connection.php');
	// $connection = include_once('../connection/previewconnection.php');
	 $connection = include_once('../connection/mobilesqlconnection.php');
	 
	  $Serial_Val = -1;
   $SelectQuery = "SELECT * FROM tbl_serials WHERE  Code = '1052'";

	$Result=mysqli_query($link,$SelectQuery) or die(mysqli_error($link));
	    $row=mysqli_fetch_assoc($Result);
		 $Serial_Val = $row['Serial'];
		 
		 
	if($row != null)
			 {
				 $Serial_Val = $Serial_Val + 1;
				
				 
			 }
 
	else
            {				
		
				$InsertFirstTime = "INSERT INTO tbl_serials (CompCode, Code, Serial, Desription) VALUES ('CIS', '1052', '0', 'Work Flow File Serial')";
						   
				mysqli_query($link,$InsertFirstTime) or die(mysqli_error($link));
				   
					
					$query = "SELECT * FROM tbl_serials WHERE `Code` = '1052'";
				  $Result=mysqli_query($link,$query) or die(mysqli_error($link));
					$row=mysqli_fetch_assoc($Result);
				$Serial_Val = $row['Serial'];
				
			}
		 
		 $UpdateSerials = "UPDATE tbl_serials SET Serial = '$Serial_Val' WHERE Code = '1052'";
		 
		 mysqli_query($link, $UpdateSerials) or die(mysqli_error($link));

	  $Str_UPLCode = 'UPL-' .$Serial_Val;
            echo $Str_UPLCode; 
		 
		 
		 

?>