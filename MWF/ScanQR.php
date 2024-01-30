<?php	
	session_start();
	
	include ("..\connection\sqlconnection.php");   //  connection file to the mysql database
	include ("..\class\accesscontrole.php");       //  sql commands for the access controles	
?>

<!DOCTYPE html> 
<html>  
    <head>
        <meta name="description" content="QR Code scanner" />
	  	<meta name="keywords" content="qrcode,qr code,scanner,barcode,javascript" />
	  	<meta name="language" content="English" />
	  	<meta name="copyright" content="Lazar Laszlo (c) 2011" />
	  	<meta name="Revisit-After" content="1 Days"/>
	  	<meta name="robots" content="index, follow"/>
	  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
      
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Sample Page</title>  
		         
        <link rel="stylesheet" href="jquery.mobile-1.2.0/jquery.mobile-1.0.min.css" />  
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery-1.6.4.min.js"></script>        
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery.mobile-1.0.min.js"></script>
		
		<script type="text/javascript" src="webQR/llqrcode.js"></script>
		<script type="text/javascript" src="webQR/plusone.js"></script>
		<script type="text/javascript" src="webQR/webqr.js"></script>
		
		
		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-24451557-1']);
			_gaq.push(['_trackPageview']);
			
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);				
			})();
		
		</script>
		
		<style type="text/css">			
			img{
			    border:0;
			}
			#main{
			    margin: 15px auto;
			    background:white;
			    overflow: auto;
				width: 750px;
			}
			#header{
			    background:white;
			}
			#mainbody{
			    background: white;
			    width:100%;
				display:none;
			}
			#footer{
			    background:white;
			}
			#qrfile{
			    width:320px;
			    height:240px;
			}
			#v{
			    width:320px;
			    height:240px;
			}
			#qr-canvas{
			    display:none;
			}
			#iembedflash{
			    margin:0;
			    padding:0;
			}
			#mp1{
			    text-align:center;
			    font-size:25px;
			}
			#mp2{
			    text-align:center;
			    font-size:25px;
				color:red;
			}
			.selector{
				border: solid;
				border-width: 3px 3px 1px 3px;
			    margin:0;
			    padding:0;
			    cursor:pointer;
			    margin-bottom:-5px;
			}
			#outdiv
			{
			    width:320px;
			    height:240px;
				border: solid;
				border-width: 3px 3px 3px 3px;
			}
			#result{
			    border: solid;
				border-width: 1px 1px 1px 1px;
				padding:20px;
				width:70%;
			}
			
			#imghelp{
			    position:relative;
			    left:0px;
			    top:-160px;
			    z-index:100;
			    font:18px arial,sans-serif;
			    background:#f0f0f0;
				margin-left:35px;
				margin-right:35px;
				padding-top:10px;
				padding-bottom:10px;
				border-radius:20px;
			}
			p.helptext{
			    margin-top:54px;
			    font:18px arial,sans-serif;
			}
			p.helptext2{
			    margin-top:100px;
			    font:18px arial,sans-serif;
			}
			ul{
			    margin-bottom:0;
			    margin-right:40px;
			}
			li{
			    display:inline;
			    padding-right: 0.5em;
			    padding-left: 0.5em;
			    font-weight: bold;
			    border-right: 1px solid #333333;
			}
			li a{
			    text-decoration: none;
			    color: black;
			}
			
			#footer a{
				color: black;
			}
			.tsel{
			    padding:0;
			}
			
			#tooltip1 { 
			    position: relative; 
			    text-decoration: none;
			    font:15px arial,sans-serif;
			    text-align:center;
			    color:red;
			}
			#tooltip1 a {text-decoration: none; color:red;}
			#tooltip1 a span { display: none; color: #FFFFFF; }
			#tooltip1 a:hover span { text-decoration: none;display: block; position: absolute; width: 250px; background-color: #ddd; height: 50px; left: -10px; top: -10px; color: black; padding: 5px; }

		</style>
		
		<script type="text/javascript">	
			function Go2Home(){
				window.location.href = "Home.php";				
			}
			
			function ServiceList(MCID, MCNAME){
				window.location.href = "ServiceList.php?MCID="+MCID+"&MCNAME="+MCNAME;				
			}
			
			$(function() {	
												
			    $("#btn_Home").click(function() {																				
					$.mobile.changePage( "Home.php", { transition: "slide"} );								
					setTimeout(Go2Home,1000);
			    });								 
			});	
			
			function GotQR(QRCode){
				var mySplitResult = QRCode.split("@");
				var MCID 	= mySplitResult[1];	
				var MCNAME 	= mySplitResult[2];					
				
				$.mobile.changePage( "ServiceList.php", { transition: "pop"} );								
				setTimeout(ServiceList(MCID, MCNAME),1000);			
			}
			
		</script>	
		
    </head>
    <body onload="load()">       
		
		<div data-role="page" id="page1">         
            <div data-role="header" data-theme="a" data-position="">  
				<!--<a id="backPageButton" class='ui-btn-left' data-icon='back' data-theme="a" >Back</a>	-->			
                <h1>
                    Welcome <?php echo $_SESSION["LogEmpName"]; ?>
                </h1>
				<a id="btn_Home" class='ui-btn-right' data-icon='home' data-theme="a" >Home</a>
				                                              
            </div><!-- /header -->         
            
            <div data-role="content">  
                <form name="QRScan" id="QRScan"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;" align="middle">
										
							<table class="tsel" border="0" align="center">
								<tr>
									<td align="middle">
										<a data-role="button" id="webcamimg"  onclick="setwebcam()">Scan</a>										
									</td>
								`	<td align="middle">
										<a id="qrimg" data-role="button" onclick="setimg()">Upload</a>										
									</td>
								</tr>
								<tr><td colspan="2" align="center">
								<div id="outdiv">
									<p class="helptext2" >select webcam or image scanning</p>
								</div></td></tr>
							</table>
							<center>
								<div id="result"></div>
							</center>							
							<canvas id="qr-canvas" width="800" height="600"></canvas>             						
                        </fieldset>						
                    </div>                       	
				 </form>
            </div><!-- /content -->         
            
            <div data-role="footer" data-theme="a" data-position="">
				<h3>
                    Teknowledge &copy; 2012
                </h3>         
            </div><!-- /fotoer -->     
            
        </div><!-- /page --> 
    </body>
</html>