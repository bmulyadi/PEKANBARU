<?
	include "lib.php";
	include "modul.inc.php";
	cek_pass();
	$token		= date('ymdHis').getToken();
	define("_TOKEN",$token);
	define("_NAME","TEST");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title><?=$application_name?></title>
	<link rel="shortcut icon" href="../favicon.ico" type="image/ico"/>
	<link href="css/calendar.css" rel="Stylesheet" type="text/css">
	<style type="text/css"><!--@import"css/style.css";--></style>
	<script type="text/javascript" src="js/prototype-1.6.0.3.js"></script>
	<script type="text/javascript" src="js/kontrol.js"></script>
	<!--[if lt IE 7]>
	<script src="js/chrome.js" type="text/JavaScript"></script>
	<![endif]-->
	<!--[if lte IE 7]>
    <script type="text/javascript" src="js/unitpngfix.js"></script>
	<![endif]--> 
	<!--[if lt IE 8]>
    <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection">
	<![endif]-->
</head>
<body onload="resize()" id="mainWin" style="height:100%">
<div class="container">
	<div class="span-24 header">
		<h1 class="app_title"><?=$appl_name?></h1>
		<div class="info">Tanggal: <?=$tanggal?>. Login sebagai <strong><?=_NAME?></strong> (IP Address: <?=_IP?>). <a href="logout.php">Logout</a></div>
	</div>
	<div class="span-24 menu">
		<div class="span-18">
			<ul id="navmenu-h">
				<li><a href="../"><img src="images/home.png" alt="Home" /></a></li>
				<? include "menu.inc.php";?>
			</ul>
		</div>
		<div class="span-6 loading last">
			<span id="load"><img src="images/tirta-load.gif" align="absmiddle"/></span>
		</div>
	</div>
	<div class="span-24 content" style="margin-top:5px;margin-bottom:5px;">
		<div id="container">
			<div id="content">
				<div id="nyangberubah" style="padding:5px;text-align:justify;overflow:auto;height:90%">
					<p style="padding:6px; font-size:14px;border-bottom : 1px dashed ;text-align:left;">
					Anda login sebagai <b><?=_NAME?></b>. Akses dari IP address <?=_IP?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="span-24 footer">
		<div id="contentbawah">
			Copyright &copy; 2006 - <?=$year?> &bull; <?=$appl_owner?> & <?=$appl_developer?> | <em>Best viewed with Mozilla Firefox 3.x.x with 1024x768 resolution</em>.
		</div>
	</div>
</div>
<script>$('load').style.display = 'none';</script>
</body>
</html>