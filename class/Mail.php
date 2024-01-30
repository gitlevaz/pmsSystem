
<?php

include "libmail.php";

function Mailto() {

    echo "<script>";
    echo "alert('sfdsfs');";
    echo "</script>";
   
    $m= new Mail; // create the mail
    $m->From( "nelumw@cisintl.com" );
    $m->To( "shameerap@cisintl.com" );
    $m->Subject( "the subject of the mail" );
    $m->Body( "Hello\nThis is a test of the Mail component" );	// set the body
    $m->Cc( "someone@somewhere.fr");
    $m->Bcc( "someoneelse@somewhere.fr");
    $m->Priority(4) ;	// set the priority to Low
    $m->Attach( "/home/leo/toto.gif", "image/gif", "inline" ) ;	// attach a file of type image/gif to be displayed in the message if possible
    $m->Send();	// send the mail
    echo "Mail was sent:<br><pre>", $m->Get(), "</pre>";

}
?>


