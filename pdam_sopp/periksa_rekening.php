<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	define("_TOKN",$token);
	
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	$link 		= new bacaDB();
	$aksesLOG	= "./_data/akses.csv";
	$hasilLOG	= "./_data/hasil.csv";
	$pesan		= array("Periksa rekening untuk SL $pel_no");
	errorHD::tulisLOG($aksesLOG,$pesan);
	$logSts		= true;
	if(strlen($noResi)<2){
		$errorMess	= "Nomor resi $noResi tidak sesuai";
	}
	else if(strlen($pel_no)==0){
		$errorMess	= "Nomor SL $pel_no belum diisi";
	}
	else if(strlen($pel_no)==6){
		$que0	= "SELECT *FROM tm_pelanggan WHERE pel_no='$pel_no'";
		$res0	= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
		if(mysql_num_rows($res0)==1){
			$que1 = "SELECT COUNT(*) AS rek_jml FROM tm_rekening WHERE pel_no='$pel_no' AND rek_sts=1 AND rek_byr_sts=0";
			$res1 = mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
			$row1 = mysql_fetch_object($res1);
			if($row1->rek_jml>0){
				$errorMess	= false;
				$logSts		= false;
			}
			else{
				$errorMess 	= "Tidak ditemukan rekening tunggakan";
			}
		}
		else{
			$errorMess 	= "SL $pel_no tidak ditemukan";
		}
	}
	else{
		$errorMess	= "SL $pel_no tidak sesuai";
	}
	if($logSts){
		$logMess = $errorMess;
	}
	else{
		$logMess = "Ditemukan ".$row1->rek_jml." rekening tunggakan";
	}
	errorHD::tulisLOG($hasilLOG,array($logMess));
	$link->tutup();
?>
<input type="text" class="bayar resi" name="noResi" size="15" maxlength="20" value="<?=$noResi?>"/>
<input type="button" value="Set Resi" class="form_button"  onClick="simpan('resi')"/>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>