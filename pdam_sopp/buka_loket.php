<?php
	include "modul.inc.php";
	include "model/tulisDB.php";
	cek_pass();
	$link = new tulisDB();
	$que1 = "INSERT tr_trans_log(tr_tgl,tr_sts,tr_ip,kp_kode,kar_id,tr_note) VALUES(NOW(),'1','"._IP."','0','"._USER."','done')";
	mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
	$mess = false;
	if(mysql_affected_rows()>0){
		$mess = "Proses buka loket selesai";
	}
	$link->tutup();
?>
<input id="errMess" type="hidden" value="<?=$mess?>"/>