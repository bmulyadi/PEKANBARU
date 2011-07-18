<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	
	if(strlen(trim($mer_kode))==0 or strlen(trim($mer_ket))==0){
		$errorMess 	= "Informasi merk wm belum lengkap";
	}
	else{
		require "model/tulisDB.php";
		require "modul.inc.php";
		$link 	= new bacaDB();
		$que0	= "SELECT *FROM tr_merk WHERE mer_kode='$mer_kode'";
		$que1	= "SELECT *FROM tr_merk WHERE mer_ket='$mer_ket'";
		$res0	= mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
		$res1	= mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
		$row0	= mysql_num_rows($res0);
		$row1	= mysql_num_rows($res1);
		$link->tutup();
		if($row0==1 and $mer_kode<>$old_kode){
			$errorMess 	= "Informasi kode wm telah terdaftar";
		}
		else if($row1==1){
			$errorMess 	= "Merk wm telah terdaftar";
		}
		else{
			$link 	= new tulisDB();
			if($aksi=="tambah"){
				$que2	= "INSERT INTO tr_merk(mer_kode,mer_ket) VALUES('$mer_kode','$mer_ket')";
			}
			else if($aksi=="edit"){
				$que2	= "UPDATE tr_merk SET mer_kode='$mer_kode',mer_ket='$mer_ket' WHERE mer_kode='$mer_kode'";
			}
			mysql_query($que2) or die(salah_db(array(mysql_errno(),mysql_error(),$que2),true));
			$link->tutup();
			$errorMess 	= "Informasi wm telah disimpan";
		}
	}
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>
<input type="button" value="Simpan" onclick="simpan('simpan')"/>
<input type="button" class="form_button" value="Kembali" onclick="buka('kembali')"/>