<?php
	require "model/tulisDB.php";
	require "modul.inc.php";
	$link 	= new tulisDB();
	cek_pass();
	
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	if(strlen($pel_nama)>0 && strlen(pel_alamat)>0){
		$que0	= "CALL p_entry_pel($token,'$pel_no','$pel_nama','$gol_kode','$pel_alamat','$pel_kel','$pel_kec','$pel_kota','$pel_tlp','$pel_hp',@e_sts)";
		$que1	= "SELECT @e_sts AS reg_sts";
		mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
		$errorMess = "Data pelanggan telah disimpan";
		echo "<input type=\"submit\" class=\"form_button\" value=\"Cetak BA\"/>";
	}
	else{
		$errorMess = "Data belum lengkap";
		echo "<input type=\"submit\" class=\"form_button\" value=\"Simpan\" onclick=\"simpan('reg')\"/>";
	}
	$link->tutup();
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>
<input type="button" class="form_button" value="Kembali" onclick="buka('kembali')"/>