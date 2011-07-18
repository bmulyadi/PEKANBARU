<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Online Dashboard PDAM Tirta Raharja</title>
<meta name="description" content="Online Dashboard PDAM Tirta Raharja" />
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script type="text/javascript" src="js/prototype-1.6.0.3.js"></script>
<script type="text/javascript" src="js/crawler.js"></script>
<script type="text/javascript">
function init(){
	var url = 'proses.php?isi=kiri';
	new Ajax.Request(url, {
		onComplete: function(transport) {
			$('container_left').innerHTML = transport.responseText;
		}
	});
	var url = 'proses.php?isi=kanan';
	new Ajax.Request(url, {
		onComplete: function(transport) {
			$('container_right').innerHTML = transport.responseText;
		}
	});
}
window.setInterval("init()", 5000);
</script>
</head>
<body onload="init()">
<div id="header"><img class="logo" src="images/logo_pdam.png" alt="PDAM Tirta Raharja" /> <img class="dashboard" src="images/dashboard_text.png" alt="Online Dashboard" /></div>
<div id="container">
<div id="topnewsticker"></div>
<div id="content">
<div id="container_left"></div>
<div id="container_right"></div>
<div id="clearing1">&nbsp;</div>
</div>
<div id="clearing2">&nbsp;</div>
</body>
</html>
