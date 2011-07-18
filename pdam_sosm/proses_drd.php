<?php
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	//var_dump($_POST);
	/** 	kode1 yang akan memindahkan semua nilai dalam array POST ke dalam */
	/*	variabel yang bersesuaian dengan masih kunci array */
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	if(!isset($kp_kode)){
		$kp_kode = $_SESSION['kp_kode'];
	}
	
	/* akhir kode1 **/
	define("_KODE",$appl_kode);
	define("_NAMA",$appl_nama);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	$rek_bln	= date('n');
	$rek_thn	= date('Y');
	
	/** koneksi database */
	$link 	= new bacaDB();
	$que2 	= "SELECT kp_kode,kp_ket,kp_db_nama FROM tr_kota_pelayanan ORDER BY kp_ket";
	$res2 	= mysql_query($que2) or die(salah_db(array(mysql_errno(),mysql_error(),$que2),true));
	while($row2 = mysql_fetch_row($res2)){
		$kode2[] 	= $row2[0];
		$nilai2[]	= $row2[1];
		if($row2[0]==$kp_kode){
			$db_nama	= $row2[2];
		}
	}
	$param2 = array("kelas"=>"drd","nama"=>"kp_kode","pilihan"=>$kp_kode,"status"=>"onchange=\"buka('drd')\"");
	$que3 	= "SELECT COUNT(rek_nomor) AS rek_jml,SUM(rek_total) AS rek_total FROM $db_nama.tm_drd_awal WHERE rek_bln=$rek_bln AND rek_thn=$rek_thn";
	$res3 	= mysql_query($que3) or die(salah_db(array(mysql_errno(),mysql_error(),$que3),true));
	if(mysql_num_rows($res3)>1){
		$pesan	= "Proses penerbitan telah dilakukan";
		$pesan .= "<br/>";
		$pesan .= "<br/>";
		$pesan .= "<br/>";
	}
	else{
		$pesan	= "Proses penerbitan belum dilakukan";
	}
	$link->tutup();
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="drd" name="targetUrl" value="<?=_FILE?>"/>
<input type="hidden" class="drd" name="targetId" value="nyangberubah"/>
<input type="hidden" class="drd" name="appl_kode" value="<?=_KODE?>"/>
<input type="hidden" class="drd" name="appl_file" value="<?=_FILE?>"/>
<input type="hidden" class="drd" name="appl_proc" value="<?=_PROC?>"/>
<input type="hidden" class="drd" name="appl_nama" value="<?=_NAMA?>"/>
<h3><?=$pesan?></h3>
<h3>Pilih Kota Pelayanan : <?=sub_select($kode2,$nilai2,$param2)?></h3>
<input type="button" class="form_button" value="Proses" onclick="buka('drd')"/>