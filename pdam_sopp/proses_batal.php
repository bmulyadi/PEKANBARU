<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	define("_TOKN",$token);
	
	include "modul.inc.php";
	include "model/tulisDB.php";
	cek_pass();
	$stsLog	= $_SESSION['aktif_log'];
	$token	= new tulisDB();
	$que0	= "CALL sopp_batal_rek('none','$rek_nomor','$byr_no','"._USER."',1,@sts)";
	$que1	= "SELECT @sts AS sts";
	mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
	$res1	= mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
	$row1	= mysql_fetch_object($res1);
	if($row1->sts==1){
		$mlog	= "Validasi batal rekening selesai";
	}
	else{
		$mlog	= "Validasi batal rekening gagal";
	}
	errorHD::tulisLOG(array($rek_nomor,$byr_no,$mlog),$stsLog);
	echo "<input type=\"hidden\" id=\"errMess\" value=\"$mlog\"/>";
	echo "<input type=\"button\" class=\"form_button\" value=\"Kembali\" onclick=\"buka('kembali')\"/>";
	$token->tutup();
?>