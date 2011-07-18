<?php
	require "model/tulisDB.php";
	require "modul.inc.php";
	cek_pass();
	$nilai			= $_POST;
	$kunci			= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	define("_TOKN",$token);
	if(strlen($ba_no)>0 && strlen($stand_awal)>0 && strlen($pel_nowm)>0){
		$link	= new tulisDB();
		$que0	= "CALL p_ganti_wm($token,'$pel_no','$pel_nowm','$dkd_kd','$ba_no',$um_kode,'$mer_kode','$met_tgl',".abs($stand_angkat).",$stand_awal,'"._USER."',$ganti_wm,@sts)";
		$que1	= "SELECT @sts AS ganti_sts";
		mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
		$errorMess 	= "Data telah disimpan";
		$link->tutup();
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>
<input type="submit" class="form_button" value="Cetak BA"/>
<input type="button" class="form_button" value="Kembali" onclick="buka('kembali')"/>
<?php
	}
	else{
		$errorMess = "Data entry belum lengkap";
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>
<input type="submit" class="form_button" value="Simpan" onclick="simpan('simpan')"/>
<input type="button" class="form_button" value="Batal" onclick="buka('kembali')"/>
<?php
	}
?>