<?
	# Versi Aplikasi
	$appl_ver = "2.3" ;
	# Nama Aplikasi
	$appl_name = "Informasi Pelanggan" ;
	# Deskripsi Aplikasi
	$appl_desc = "Informasi Tagihan Pelanggan PDAM Tirta Siak" ;
	# Owner Aplikasi
	$appl_owner = "PDAM Tirta Siak";
	# Pengembang Aplikasi
	$appl_developer = "PT. Jerbee Indonesia";
	# Nama Lengkap Aplikasi
	$application_name = $appl_owner." &bull; ".$appl_name." (Release: V".$appl_ver.")";
	# Logo Aplikasi
	$appl_logo = "images/logo-pdam-kecil.png";

	$phpSelf		= $_SERVER['PHP_SELF'];
	$ipClient		= $_SERVER['REMOTE_ADDR'];
	# Mangrupaning Tatanggalan
	$hari 			= array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Every Day");
	$bulan 			= array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$tanggal		= date('d-m-Y');
	$today = getdate(); 
	$month = date("m");
	$mday = date("d"); 
	$year = $today[year]; 
	$hday = date("w");

	$tgl_sekarang="$mday/$month/$year";
	$tgl_entry = "$year-$month-$mday";
	
?>

