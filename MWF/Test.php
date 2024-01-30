
<!DOCTYPE html> 
<html> 
	<head> 		
	  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
      
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>.::Test::.</title>
		<link rel="stylesheet" href="jquery.mobile-1.2.0/jquery.mobile-1.0.min.css" />  
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery-1.6.4.min.js"></script>        
        <script type="text/javascript" src="jquery.mobile-1.2.0/jquery.mobile-1.0.min.js"></script>
				
		<script type="text/javascript">			
			/*$.mobile.loading( 'show', {
					text: 'foo',
					textVisible: true,
					theme: 'z',
					html: ""
				});*/
			$(function() {	
			
				
														
			    $("#Login").bind("click", function(event) {
			        $.mobile.changePage( "index.php", { transition: "flip"} );					
			    });  				
			});	
			
		</script>
		
    </head>   
    <body>              
        <div data-role="page" id="page6" data-dom-cache="true" data-fetch='always'>					
            <div  data-theme="a" data-role="header">
                <h5>
                    :: Mobile Work Flow System ::
                </h5>                
            </div>
            <div data-role="content">				
				<form name="Tet" id="Test"  method="post" action="">		              
                    <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" style="text-align:center;">
                            											
                        </fieldset>
                    </div>
                    <a id="Login" data-role="button">Login</a>   	
				 </form>
            </div>
            <div data-theme="a" data-role="footer" data-position="fixed">
                <h3>
                    Teknowledge &copy; 2012
                </h3>
            </div>
        </div> 

    </body>
</html>​