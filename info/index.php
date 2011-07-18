<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$application_name?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/ico" />
<style type="text/css">
<!--
	@import"css/mainindex.css";
	.duit { text-align: right} 
	.resm { font-size: 10pt }
	h1 {font-size:20px;}
	input.form_button {
		background-color: #1a5372;
		color: #000;
		text-transform:uppercase;
		font-weight: bold;
		border:0 none;
		color:#fff;
		font-size:11px;
		padding:4px 7px;
	}	
-->
</style>
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript">
	function init () {
		resize();
		getTabData();
	}
	
	function getTabData(param) {
		var url = 'process.php';
		var rand = Math.random(9999);
		var pars = param + '&rand=' + rand;
		var myAjax = new Ajax.Request( url, {method: 'post', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	}
	
	function showLoad () {
		$('load').style.display = 'inline';
	}

	function showStop () {
		$('load').style.display = 'none';
	}

	function showResponse (originalRequest) {
		var newData = originalRequest.responseText;
		showStop();
		$('nyangberubah').innerHTML = newData;
	}
	
	function find_data(){ 
		var id1 = document.getElementsByClassName('id1');
	  	param = "id1=" + id1[0].value;
	 	getTabData(param);
	}
	
	function next_page(page,rek,uang){
		var id1 = document.getElementsByClassName('id1');
	  	param = "id1=" + id1[0].value + "&id2=" + page + "&id3=" + rek + "&id4=" + uang;
	 	getTabData(param);
	}
	
	function entry_data(nomor){
		var id1 = document.getElementsByClassName('id1');
		if (nomor == "delete"){
			param = null;			
		}
		else{
			param = id1[0].value + nomor;
		}
		document.getElementsByClassName('id1')[0].value = param;
	}
	function resize(){
		var dim = Element.getHeight('mainWin');
		var tin = dim - 157;
		//alert(tin);
		Element.setStyle('nyangberubah',({height: ''+tin+''}));
	}	
</script>
</head>

<body id="mainWin" onload="init()" style="height:100%;overflow:auto">

<div id="header"/>
<div id="site-name"/>
<div id="sitename">PT. Telkom Indonesia<br />
	<span id="load"><img src="images/tirta-load.gif" align="absmiddle"/></span>
</div>
</div>
</div>
<div id="container">
<div id="content">
	<div id="nyangberubah" style="padding:4px;text-align:justify;width:98%;margin-top:30px;overflow:auto">
	</div>
</div>
<div id="footer">
	<p>Supported by <a href="http://www.jerbee.co.id" title="PT. Jerbee Indonesia">Jerbee</a></p>
</div>
</div>
<script>showStop();</script>
</body>
</html>