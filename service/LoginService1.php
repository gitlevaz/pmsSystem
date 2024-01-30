<?php 
 $connection = include_once('../connection/mobilesqlconnection.php');
//$connection = include_once('../connection/previewconnection.php');
  include('../class/accesscontrole.php');
  $Password=$_GET['A'];
if ( $Password == "A")
{
echo 'true';
}
else
{
echo 'false';
}

?>
