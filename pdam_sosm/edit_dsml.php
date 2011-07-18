<?php
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	/** kode1 yang akan memindahkan semua nilai dalam array POST ke dalam */
	/*	variabel yang bersesuaian dengan masih kunci array */
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	
	define("_KODE",$appl_kode);
	define("_NAMA",$appl_nama);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	define("_TOKEN",$appl_token);
	for($i=0;$i<count($pel_no);$i++){
		if($ubah[$i]==1){
			$que[] = "CALL p_entry_dsml('$pel_no[$i]',$sm_lalu[$i],$sm_kini[$i],'"._USER."',$kwm_kd[$i],$kl_kd[$i],$pilihan[$i],'none')";
			if($pilihan[$i]==1){
				$pesan 	= "validasi data";
				$mess[]	= array($pel_no[$i],$wmmr_id[$i],$pesan);
			}
			else{
				$pesan 	= "data manual";
				$mess[]	= array($pel_no[$i],'0',$pesan);
			}
		}
	}
	$link = new tulisDB();
	for($i=0;$i<count($que);$i++){
		tulisLog("query.csv",array($que[$i]),_LOG);
		tulisLog("change_log.csv",$mess[$i],_LOG);
		mysql_query($que[$i]) or die(salah_db(array(mysql_errno(),mysql_error(),$que[$i]),true));
	}
	$link->tutup();
	if($i>0){
		$errorMess = "$i data DSML telah disimpan";
	}
	else{
		$errorMess = "Tidak ada perubahan data DSML";
	}
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>