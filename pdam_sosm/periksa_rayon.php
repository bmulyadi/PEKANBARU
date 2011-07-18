<?php
	$dkd_kd	= $_POST['dkd_kd'];
	require "model/tulisDB.php";
	require "modul.inc.php";
	$link 	= new bacaDB();
	$que	= "SELECT COUNT(*) AS dkd_jml FROM v_data_pelanggan WHERE dkd_kd='$dkd_kd' AND met_sts<=5";
	$res 	= mysql_query($que) or die(salah_db(array(mysql_errno(),mysql_error(),$que),true));
	$row	= mysql_fetch_object($res);
	if($row->dkd_jml>0)
		$errorMess = false;
	else
		$errorMess = "Rayon $dkd_kd tidak memiliki SL aktif";
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>