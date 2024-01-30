<?php
/*
 * Developer Name   :
 * Module Name      :
 * Last Update      :
 * Company Name     : Tropical Fish International (pvt) ltd
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.:: PMS CONTENT ::.</title>
    <link rel="stylesheet" href="css/content.css" type="text/css" />
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
</head>
    
<body>
    <div id="containerc">
        <div id="Centeredc">

            <div id="loading" style="position:absolute; width:100px; text-align:center; top:180px; left: 180px; height: 20px;">
                <img alt=""  src="images/Wait.gif" border=0/>
            </div>

            <script language="javascript" type="text/javascript">
                var ld=(document.all);
                var ns4=document.layers;
                var ns6=document.getElementById&&!document.all;
                var ie4=document.all;
                if (ns4)
                    ld=document.loading;
                else if (ns6)
                    ld=document.getElementById("loading").style;
                else if (ie4)
                    ld=document.all.loading.style;

                function init() {
                    if(ns4){ld.visibility="hidden";}
                    else if (ns6||ie4) ld.display="none";
                }

            </script>

            <div id="Div-Form_logo">
                <input type="button" title="Tropical Fish International (pvt) ltd" class="logo"/>
            </div>

            <div class="Application" align="left">
                    User Name : <?php echo $_SESSION["LogUserName"]; ?>
            </div>

            <div class="body">

               


            </div>
            
        </div>
    </div>
    
</body>
</html>