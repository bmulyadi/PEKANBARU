<?
	$applVersi		= "0.1";
	$applName 		= "TiraOS";
	$applTitle		= $applName."-v".$applVersi;
	$dbHost			= "192.168.5.210";
	$dbUser			= "admin_tirtasiak";
	$dbPass			= "pdam2011";
	$dbName			= "alir_info";
	$phpSelf		= $_SERVER["PHP_SELF"];
	$bulan			= array("1"=>"Januari","Februari","Maret","April","Mei","Juni",
						"Juli","Agustus","September","Oktober","November","Desember");
	$tanggal		= date("d")." ".$bulan[date("n")]." ".date("Y");
	/* client */
	$ipClient		= $_SERVER["REMOTE_ADDR"];
?>