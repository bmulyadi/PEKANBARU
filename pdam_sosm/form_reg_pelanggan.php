<?php
	require "model/tulisDB.php";
	require "modul.inc.php";
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
	define("_TOKN",date('ymdHis').getToken());
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="kembali" name="targetId" 	value="nyangberubah"/>
<input type="hidden" class="kembali" name="targetUrl" 	value="<?=_FILE?>"/>
<input type="hidden" class="kembali" name="appl_nama"	value="<?=_NAMA?>"/>
<input type="hidden" class="kembali" name="appl_file"	value="<?=_FILE?>"/>
<input type="hidden" class="kembali" name="appl_proc"	value="<?=_PROC?>"/>
<input type="hidden" class="kembali simpan" name="appl_kode" value="<?=_KODE?>"/>
<?php
	/** koneksi database */
	$link 	= new bacaDB();
	cek_pass();
	$que	= "SELECT getSL('10') AS pel_no";
	$res	= mysql_query($que) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que)));
	$row	= mysql_fetch_object($res);
	//select
	$que2 	= "SELECT gol_kode,CONCAT('[',gol_kode,'] - ',gol_ket) FROM tr_gol WHERE gol_sts=1 ORDER BY gol_kode";
	$res2 	= mysql_query($que2) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que2)));
	while($row2 = mysql_fetch_row($res2)){
		$kode2[] 	= $row2[0];
		$nilai2[] 	= $row2[1];
	}
	$param2 = array("kelas"=>"reg","nama"=>"gol_kode","pilihan"=>"1C","status"=>"style=\"font-size: 9pt\""); 
	$link->tutup();
	$pel_no	= $row->pel_no;
?>
<input type="hidden" class="reg" name="targetUrl" 	value="<?=_PROC?>"/>
<input type="hidden" class="reg" name="token" 		value="<?=_TOKN?>"/>
<input type="hidden" class="reg" name="pel_no" 		value="<?=$pel_no?>"/>
<table>
	<tr class="table_head"> 				  				    
		<td colspan="2"><b>Data Pelanggan</b></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%">No. Pelanggan</td><td>: <?=$pel_no?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%">Nama Pelanggan</td><td>: <input type="text" class="reg" name="pel_nama"/> *</td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%">Alamat</td><td>: <input type="text" class="reg" name="pel_alamat"/> *</td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%">Kelurahan</td><td>: <input type="text" class="reg" name="pel_kel"/></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%">Kecamatan</td><td>: <input type="text" class="reg" name="pel_kec"/></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%">Kota</td><td>: <input type="text" class="reg" name="pel_kota"/></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%">Telp</td><td>: <input type="text" class="reg" name="pel_telp"/></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%">HP</td><td>: <input type="text" class="reg" name="pel_hp"/></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%">Kode Golongan</td><td>: <?=sub_select($kode2,$nilai2,$param2)?></td>
	</tr>
	<tr class="table_cont_btm">
		<td id="errId" colspan="2">
			<input type="submit" class="form_button" value="Simpan" onclick="simpan('reg')"/>
		</td>
	</tr>
</table>