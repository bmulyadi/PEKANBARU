<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	define("_TOKN",$token);
	define("_KODE",$appl_kode);
	
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	$stsLog	= $_SESSION['aktif_log'];
	$link 	= new bacaDB();
	if(strlen($pel_no)==6){
		$que0	= "SELECT *FROM tm_pelanggan WHERE pel_no='$pel_no'";
		$res0	= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
		if(mysql_num_rows($res0)==1){
			switch(_KODE){
				case "tab15":
					/* validasi pembatalan rekening */
					$que1 = "SELECT c.sts AS batal_sts,a.byr_tgl,a.byr_no,b.rek_nomor FROM tm_pembayaran a JOIN tm_rekening b ON(a.rek_nomor=b.rek_nomor) JOIN tm_pembatalan c ON(a.rek_nomor=c.rek_nomor) WHERE a.byr_sts=1 AND b.pel_no='$pel_no' AND rek_bln='$rek_bln' AND rek_thn='$rek_thn' AND b.rek_sts=1 AND b.rek_byr_sts<>0 AND c.sts=0";
					$mes1 = "Belum cetak berita acara";
					$mes2 = "Belum cetak berita acara";
					break;
				case "tab14":
					/* validasi copy rekening */
					$que1 = "SELECT PERIOD_DIFF(DATE_FORMAT(NOW(),'%Y%m'),DATE_FORMAT(a.byr_tgl,'%Y%m')) AS batal_sts,a.byr_tgl,a.byr_no,b.rek_nomor FROM tm_pembayaran a JOIN tm_rekening b ON(a.rek_nomor=b.rek_nomor) WHERE a.byr_sts=1 AND b.pel_no='$pel_no' AND rek_bln='$rek_bln' AND rek_thn='$rek_thn' AND b.rek_sts=1 AND b.rek_byr_sts<>0";
					$mes1 = "Rekening belum dibayar";
					$mes2 = "Rekening tidak bisa dicopy";
					break;
				case "tab13":
					/* cetak berita acara pembatalan */
					$que1 = "SELECT DATEDIFF(NOW(),a.byr_tgl) AS batal_sts,a.byr_tgl,a.byr_no,b.rek_nomor FROM tm_pembayaran a JOIN tm_rekening b ON(a.rek_nomor=b.rek_nomor) WHERE a.byr_sts=1 AND b.pel_no='$pel_no' AND rek_bln='$rek_bln' AND rek_thn='$rek_thn' AND b.rek_sts=1 AND b.rek_byr_sts<>0";
					$mes1 = "Rekening belum dibayar";
					$mes2 = "Rekening tidak bisa dibatalkan";
					break;
			}
			$res1 = mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
			$row1 = mysql_fetch_object($res1);
			if(mysql_num_rows($res1)==0){
				$errorMess = $mes1;
			}
			else if($row1->batal_sts<>0){
				$errorMess = $mes2;
			}
			else{
				$errorMess = false;
			}
		}
		else{
			$errorMess = "SL $pel_no tidak ditemukan";
		}
	}
	else{
		$errorMess	= "SL $pel_no tidak valid";
	}
	$link->tutup();
?>
<input type="hidden" class="batal" name="byr_no" value="<?=$row1->byr_no?>"/>
<input type="hidden" class="batal" name="rek_nomor" value="<?=$row1->rek_nomor?>"/>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>
