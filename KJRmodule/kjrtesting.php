<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KGR Testing</title>
<script type="text/javascript">
function datakjrsend(){

           var cmd = "save";
		    var kjrid = "11";
			 var depid = "D11";
			  var desid = "D112";
			   var kjrname = "KJR11";
			    var des = "This is sample KJR11";
			newwindow=window.open('kjrdetails.php?cmd='+cmd+'&kjrid='+kjrid+'&depid='+depid+'&desid='+desid+'&kname='+kjrname+'&kdes='+des+'');
            if (window.focus) {newwindow.focus()}
				return false;
}
function dataindicatorsend(){

           var cmd = "upt";
		    var indid = "7";
			 var indname = "Indicator7";
			  var inddes = "This is Sample Indicator7 my friend";			  
			newwindow=window.open('indicatordetails.php?cmd='+cmd+'&indid='+indid+'&indname='+indname+'&inddes='+inddes+'');
            if (window.focus) {newwindow.focus()}
				return false;
}
function datasubindicatorsend(){

           var cmd = "upt";
		    var sid = "7";
			 var sname = "SubIndicator7";
			  var sdes = "This is Sample SubIndicator7";
			   var sindid = "7";
			   
			newwindow=window.open('subindicatordetails.php?cmd='+cmd+'&sid='+sid+'&sname='+sname+'&sdes='+sdes+'&sindid='+sindid+'');
            if (window.focus) {newwindow.focus()}
				return false;
}
function datakjrindicatorsend(){

           var cmd = "upt";
		    var cid = "6";
			 var kjrid = "4";
			  var indid = "6";
			   
			newwindow=window.open('kjrindicatordetails.php?cmd='+cmd+'&cid='+cid+'&kjrid='+kjrid+'&indid='+indid+'');
            if (window.focus) {newwindow.focus()}
				return false;
}


</script>
</head>

<body>
<input type="button" value="Send KJR Data" onclick="datakjrsend()"></br></br></br></br><input type="button" value="Send Indicator Data" onclick="dataindicatorsend()"></br></br></br></br><input type="button" value="Send SUBIndicator Data" onclick="datasubindicatorsend()"></br></br></br></br><input type="button" value="Send KJR and Indicator Data" onclick="datakjrindicatorsend()">
</body>
</html>