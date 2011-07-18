<?php
	//var_dump($_POST);
	/** 	kode1 yang akan memindahkan semua nilai dalam array POST ke dalam */
	/*	variabel yang bersesuaian dengan masih kunci array */
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	/* akhir kode1 **/
	define("_KODE",$appl_kode);
	define("_NAMA",$appl_nama);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="lihat kembali" name="targetUrl" value="<?=_FILE?>"/>
<input type="hidden" class="lihat kembali" name="targetId"  value="nyangberubah"/>
<input type="hidden" class="lihat kembali" name="appl_kode" value="<?=_KODE?>"/>
<input type="hidden" class="lihat kembali" name="appl_file" value="<?=_FILE?>"/>
<input type="hidden" class="lihat kembali" name="appl_proc" value="<?=_PROC?>"/>
<input type="hidden" class="lihat kembali" name="appl_nama" value="<?=_NAMA?>"/>
<input type="hidden" class="transaksi tunggakan" 		name="targetUrl"	value="<?=_PROC?>"/>
<input type="hidden" class="transaksi tunggakan" 		name="targetId"  	value="tabel_transaksi"/>
<input type="hidden" class="transaksi tunggakan cetak" 	name="pel_no"  		value="<?=$pel_no?>"/>
<input type="hidden" class="transaksi" name="aksi"  value="transaksi"/>
<input type="hidden" class="tunggakan" name="aksi"  value="tunggakan"/>
<?php
	if($proses=="detail"){
		/** koneksi database */
		require "model/tulisDB.php";
		$link 	= new bacaDB();
		$que0	= "SELECT *FROM v_data_pelanggan WHERE pel_no='$pel_no'";
		$res0	= mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
		$row0	= mysql_fetch_object($res0);
		$link->tutup();
?>
<table>
	<tr>
		<td>No SL</td><td>: <?=$row0->pel_no?></td>
		<td>Golongan</td><td>: <?=$row0->gol_kode?></td>
	</tr>
	<tr>
		<td>Nama</td><td>: <?=$row0->pel_nama?></td>
		<td>Rayon</td><td>: <?=$row0->dkd_kd?></td>
	</tr>
	<tr>
		<td>Alamat</td><td>: <?=$row0->pel_alamat?></td>
		<td>Status</td><td>: <?=$row0->kps_ket?></td>
	</tr>
</table>
<table>
	<tr class="table_head">
		<td colspan="9">
			<input type="button" value="Tunggakan Rekening" onclick="buka('tunggakan')"/>
			<input type="button" value="Transaksi Terakhir" onclick="buka('transaksi')"/>
			<input type="button" value="Cetak" onclick="cetakin('cetak')"/>
			<input type="button" class="kembali" value="Kembali" onclick="buka('kembali')"/>
		</td>
	</tr>
</table>
<div id="tabel_transaksi"></div>
<?php
	}
	else{
?>
<center>
	<b>Nomor Pelanggan :</b>
	<input type="text" class="lihat" name="pel_no" maxlength="6"/>
	<input type="hidden" class="lihat" name="proses" value="detail"/>
	<input type="hidden" class="lihat" name="cekUrl" value="periksa_sl.php"/>
	<input type="hidden" class="periksa" name="pel_no" value="1"/>
	<span id="errId"></span>
	<input type="button" class="form_button" value="Proses" onclick="periksa('lihat','periksa')"/>
</center>
<?php
	}
?>