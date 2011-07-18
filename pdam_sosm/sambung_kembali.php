<?php
	include "modul.inc.php";
	include "model/tulisDB.php";
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	cek_pass();
	$link 	= new tulisDB();
	$j		= 0;
	$token	= date('ymdHis').getToken();
	for($i=0;$i<count($pel_no);$i++){
		if($pilih[$i]==1){
			$que1 = "CALL sopp_set_tps($token,'".$pel_no[$i]."',8,0,'".$ps_ket[$i]."','"._USER."')";
			mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
			$j++;
		}
	}
	$link->tutup();
	if($j>0){
		$mess = "$j SL telah disambung kembali";
	}
	else{
		$mess = "Tidak ada SL dipilih";
		echo "<input type=\"submit\" class=\"form_button\" value=\"Simpan\" onclick=\"simpan('sambung')\"/>";
	}
?>
<input id="errMess" type="hidden" value="<?=$mess?>"/>