<?
include "lib.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$appl_owner?> &bull; <?=$appl_name?></title>
<meta name="Keywords" content="informasi, pelanggan, air, water, pdam tirta raharja, kabupaten bandung" />
<meta name="Description" content="<?=$appl_desc?>" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="-1" />
<link rel="shortcut icon" href="favicon.ico" type="image/ico" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
<!--[if lt IE 8]>
    <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection" />
	<![endif]-->
<link href="typography.css" rel="stylesheet" type="text/css" media="screen, projection" />
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="getdata.js"></script>
<!--[if lte IE 7]>
    <script type="text/javascript" src="unitpngfix.js"></script>
<![endif]--> 
</head>
<body onload="init()">
<div class="container">
	<div class="span-24 header">
		<img style="width:84px height:50px;" src="<?=$appl_logo?>" alt="PDAM Tirta Raharja" /><br />
		<span id="load"><img src="images/tirta-load.gif" align="absmiddle"/></span>
	</div>
	<div class="span-24 content">
		<div id="container">
			<div id="content">
				<div id="nyangberubah" style="height:80%;padding:0px;text-align:center;width:100%;margin-top:0px;">
				</div>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
	<div class="span-24 footer">
		<p>Copyright <?=$year?> &copy; <a href="http://www.tirtasiak.co.id" title="PDAM Tirta Siak"><?=$appl_owner?></a>. Developed by <a href="http://www.jerbee.co.id" title="PT. Jerbee Indonesia"><?=$appl_developer?></a> | <em>Best viewed with Mozilla Firefox 3.x.x with 1024x768 resolution</em>.</p>
	</div>
</div>
<script>showStop();</script>
</body>
</html>