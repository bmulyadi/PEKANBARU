<?
	session_start();
	require "default.php";
	require "modul.inc.php";
	if(isset($_POST['Submit'])){
		$l_name	= $_POST['username'];
		$l_pass	= md5($_POST['input_pass']);
		$con 	= konek_tulis_db();
		$que0 	= "SELECT a.kar_id,a.kar_nama,a.kar_pass,a.grup_id,IFNULL(c.grup_nama,'Administrator') AS grup_nama FROM tm_karyawan a LEFT JOIN tm_group c ON(a.grup_id=c.grup_id) WHERE a.kar_id = '$l_name'";
		$res0 	= mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
		$row0 	= mysql_fetch_object($res0);
		if(mysql_num_rows($res0) == 1 and $l_name == $row0->kar_id and $l_pass == $row0->kar_pass){
			$que1						= "INSERT INTO user_login(ip,user_id,sts) VALUES('$ipClient','$l_name',1)";
			mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
			$_SESSION['User_c']			= $l_name;
			$_SESSION['Name_c']			= $row0->kar_nama;
			$_SESSION['Group_c']		= $row0->grup_id;
			$_SESSION['grup_nama']		= $row0->grup_nama;
			$_SESSION['aktif_log']		= true;
			header("Location: ./");
		}
		else{
			$que1	= "INSERT INTO user_login(ip,user_id,sts) VALUES('$ipClient','$l_name',0)";
			mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
			$mess	= "Login gagal";
		}
		mysql_close($con);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>SOPP PDAM &bull; PDAM Tirta Siak Pekanbaru</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/ShowHide.css" media="screen">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">  
	<script type="text/javascript" src="js/prototype-1.6.0.3.js"></script>
	<script type="text/javascript" src="js/kontrol.js"></script>
	<script type="text/javascript" src="js/ShowHide.js"></script>
	<!--[if lt IE 7]>
	<script type="text/javascript" src="js/unitpngfix.js"></script>
	<![endif]-->
	<style>
	<!--
		#pesana{
			padding: 2px;
			border: solid 1px red;
			background-color: #f5f0b8;
			color: black; font-family: verdana,tahoma,arial; font-weight: bold;
			text-align: center;
		}
	-->
	</style>
</head>
<body>
  <div id="load"></div>
  <div id="peringatan"></div>
  <div class="container">
	<div class="span-24 header"><h1>PDAM Tirta Siak Pekanbaru</h1></div>
	<div class="span-24 wrapper">
		<div class="span-1">&nbsp;</div>
<?
	if(isset($_SESSION['User_c'])){
		$mess 	= "Anda login sebagai <strong>".$_SESSION['Name_c']."</strong>";
		$mess  .= " (<a href='logout.php'>Logout</a>)<br />";
		$mess  .= "Hak akses <strong>".$_SESSION['grup_nama']."</strong><br />";
		$mess  .= "Dari IP [".$_SERVER['REMOTE_ADDR']."]<br />";
?>
		<div class="span-7 userinfo">
			<h2>Info Pengguna</h2>
				<em><script type="text/javascript" src="js/waktos.js"></script></em><br />
				<?=$mess?>
				<div class="iconraktop"><img src="images/icons/icon_change_password.png" onclick="lihat('ganti_password.php','','peringatan')" /><br />Ganti Password</div>
		</div>
<?
	}
	else{
?>
		<div class="span-7 userinfo">
			<h2>Selamat Datang</h2>
			<form name='form_login' method='POST' action="./" style="padding:0px 15px;">
			<p>
			Gunakan nama user & password yang valid untuk mengakses aplikasi ini. [<?=$ipClient?>]<br/>
			<?php if($mess){ ?>
			<div id="pesana"><?=$mess?></div>
			<?php } ?>
			<!--<img src="images/lcd.png" alt="" class=""/>-->
			<br /><label>User ID:</label><br />
			<input type="text" name="username" size="15" class="form_cell"><br />
			<label>Password:</label><br />
			<input type="password" name="input_pass" size="15" class="form_cell" ><br />
			<input type="submit" class="form_button" name="Submit" value="Login" class="form_button">

		</p>

	</form>

		</div>
<?
	}
?>
		<div class="span-14 userinfo">
			<h2>Aplikasi Online</h2>
			<div class="iconrak"><a href="./dashboard/"><img src="images/icons/icon_dashboard.png"/></a><br />Dashboard</div> 
<!--<div class="iconrak"><a href="./sosm/"><img src="images/icons/icon_sosm.png" /></a><br />S O S M</div>-->
<div class="iconrak"><a href="./info/"><img src="images/icons/icon_info.png" /></a><br />Info Pelanggan</div>
<div class="iconrak"><a href="./pdam_sopp/"><img src="images/icons/icon_kasir.png" /></a><br />Kasir SOPP</div>
<div class="iconrak"><a href="./pdam_sosm/"><img src="images/icons/icon_cabang.png" /></a><br />Administrasi</div>
		</div>
		<div class="span-1 last">&nbsp;</div>
	</div>
		<div class="span-24 footer last">
		<div class="span-1">&nbsp;</div>
		<div class="span-22">
				<div id="footer">
				<p><span style="float:left">Copyright &copy; 2011 <a href="http://www.tirtasiak.co.id/">PDAM Tirta Siak</a> & <a href="http://www.jerbee.co.id/">PT. Jerbee Indonesia</a>. All Rights Reserved</a></span><img style="float:right" src="images/supported_by.png" /></p>
				</div>
		</div>
		<div class="span-1 last">&nbsp;</div>
	</div>
  </div>
 </body>
	<script>stop();</script>
</html>
