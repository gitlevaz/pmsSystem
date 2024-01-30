
<!--<!DOCTYPE html>-->
<!DOCTYPE html>  
<html> 
    <head>		
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>.:: MWF ::.</title>
		
		<link rel="stylesheet" href="jquery.mobile-1.2.0/jquery.mobile-1.0.min.css" />  
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery-1.6.4.min.js"></script>        
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery.mobile-1.0.min.js"></script>
         
		<!--<link rel="stylesheet" href="MyStyle/my.css" />    -->
		
		<script type="text/javascript"  language="javascript">	        
	        function Authonticate() {
	            window.location = "Home.php";
	            document.getElementById("msg").innerHTML = "Your allowed to Proceed";
	        }
			
	        function Error() {	            
				$.mobile.changePage("#page2");
			}
			
			$(function() {
			    $("#changePageButton").click(function() {
			        /*$.mobile.changePage("#page2");*/
					$.mobile.changePage("#page2");
			    });        
			});
			
    	</script>		
    </head>
    <body>		
        <!-- Home -->
        <div data-role="page" id="page1">			
            <div id="MWF_Header" data-theme="a" data-role="header">
                <h5>
                    :: Mobile Work Flow System ::
                </h5>
                <div align="center" style="width: 100%; height: 100px; position: relative; background-color: #fbfbfb; border: 0px solid #b8b8b8;background-image:url('images/Logo.png');background-size:288px;background-repeat:no-repeat;background-position:center;padding-top:25px;">
                    
                </div>
            </div>
            <div data-role="content">				
				<form name="Login" id="Login"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;">
                            <label for="txt_userID" style="width:100px;" >
                                User Code
                            </label>							
                            <input name="txt_userID" id="txt_userID" placeholder="" value="" type="password" />
							<br/><br/>
							<div  id="msg" align="center"></div>							
                        </fieldset>
                    </div>
                    <a id="changePageButton" data-role="button">Change Page!</a>   	
				 </form>
            </div>
            <div id="MWF_Footer" data-theme="a" data-role="footer" data-position="fixed">
                <h3>
                    Teknowledge &copy; 2012
                </h3>
            </div>
        </div>
		
		<!-- *********** Starting Page 2 ****************** -->
		
		<div data-role="page" id="Page2">			
            <div id="Error_Header" data-theme="b" data-role="header">
                <h5>
                    :: Mobile Work Flow System ::
                </h5>                
            </div>
            <div data-role="content">				
				<form name="Error" id="Error"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;">
                            <label for="txt_ErrorID" style="width:100px;" >
                                Invalid User Code, Please Try Again
                            </label>							
                            <!--<input name="txt_userID" id="txt_userID" placeholder="" value="" type="password" />-->
							<br/><br/>							
                        </fieldset>
                    </div>                    
				 </form>
            </div>
            <div id="Error_Footer" data-theme="b" data-role="footer" data-position="fixed">
                <h3>
                    Teknowledge &copy; 2012
                </h3>
            </div>
        </div>
   
    </body>
</html>