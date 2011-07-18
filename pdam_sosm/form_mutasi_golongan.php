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
<input type="hidden" class="balik_nama kembali" name="targetUrl" value="<?=_FILE?>"/>
<input type="hidden" class="balik_nama kembali simpan" name="targetId"  value="nyangberubah"/>
<input type="hidden" class="balik_nama kembali simpan" name="appl_kode" value="<?=_KODE?>"/>
<input type="hidden" class="balik_nama kembali simpan" name="appl_file" value="<?=_FILE?>"/>
<input type="hidden" class="balik_nama kembali simpan" name="appl_proc" value="<?=_PROC?>"/>
<input type="hidden" class="balik_nama kembali simpan" name="appl_nama" value="<?=_NAMA?>"/>
<?php
	if($proses=="detail"){
		/** koneksi database */
		require "model/tulisDB.php";
		require "modul.inc.php";
		$link 	= new bacaDB();
		$que	= "SELECT *FROM v_data_pelanggan WHERE pel_no='$pel_no'";
		$res	= mysql_query($que) or die(salah_db(array(mysql_errno(),mysql_error(),$que),true));
		$row	= mysql_fetch_object($res);
		//select
		$que2 	= "SELECT gol_kode,CONCAT('[',gol_kode,'] - ',gol_ket) FROM tr_gol WHERE gol_sts=1 ORDER BY gol_kode";
		$res2 	= mysql_query($que2) or die(salah_db(array(mysql_errno(),mysql_error(),$query),true));
		while($row2 = mysql_fetch_row($res2)){
			$kode2[] 	= $row2[0];
			$nilai2[] 	= $row2[1];
		}
		$param2 = array("kelas"=>"simpan","nama"=>"gol_kode","pilihan"=>$row->gol_kode,"status"=>"style=\"font-size: 9pt\""); 
		$link->tutup();
		//var_dump($result);
?>
<input type="hidden" class="simpan" name="targetUrl" 		value="<?=_PROC?>"/>
<input type="hidden" class="simpan" name="pel_no"			value="<?=$pel_no?>"/>
<input type='hidden' class='simpan' name='pel_nama_lama' 	value='<?=$row->pel_nama?>'/>
<input type='hidden' class='simpan' name='pel_alamat_lama' 	value='<?=$row->pel_alamat?>'/>
<input type='hidden' class='simpan' name='pel_kel_lama' 	value='<?=$row->pel_kel?>'/>
<input type='hidden' class='simpan' name='pel_kec_lama' 	value='<?=$row->pel_kec?>'/>
<input type='hidden' class='simpan' name='pel_kota_lama' 	value='<?=$row->pel_kota?>'/>
<input type='hidden' class='simpan' name='pel_telp_lama' 	value='<?=$row->pel_telp?>'/>
<input type='hidden' class='simpan' name='pel_hp_lama' 		value='<?=$row->pel_hp?>'/>
<table width='100%'>
	<tr class="table_head"> 				  				    
		<td colspan="2" align ="center" width="50%"><b>Data Pelanggan</b></td>
		<td colspan="2" align="center"><b>Update</b></td>
	</tr>
	<tr valign="top" class="table_cell1">
		<td width="25%" >No. Pelanggan</td><td>: <?=$row->pel_no?></td>
		<td width="25%" >No. Pelanggan</td><td>: <?=$row->pel_no?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >No. Water Meter</td><td>: <?=$row->pel_nowm?></td>
		<td width="25%" >No. Water Meter</td><td>: <?=$row->pel_nowm?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Kota Pelayanan</td><td>: <?=$row->kp_ket?></td>
		<td width="25%" >Kota Pelayanan</td><td>: <?=$row->kp_ket?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Nama Pelanggan</td><td>: <?=$row->pel_nama?></td>
		<td width="25%" >Nama Pelanggan</td><td>: <?=$row->pel_nama?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Alamat</td><td>: <?=$row->pel_alamat?></td>
		<td width="25%" >Alamat</td><td>: <?=$row->pel_alamat?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Kelurahan</td><td>: <?=$row->pel_kel?></td>
		<td width="25%" >Kelurahan</td><td>: <?=$row->pel_kel?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Kecamatan</td><td>: <?=$row->pel_kec?></td>
		<td width="25%" >Kecamatan</td><td>: <?=$row->pel_kec?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Kota</td><td>: <?=$row->pel_kota?></td>
		<td width="25%" >Kota</td><td>: <?=$row->pel_kota?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Telp</td><td>: <?=$row->pel_telp?></td>
		<td width="25%" >Telp</td><td>: <?=$row->pel_telp?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >HP</td><td>: <?=$row->pel_hp?></td>
		<td width="25%" >HP</td><td>: <?=$row->pel_hp?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Tgl. Pasang</td><td>: <?=$row->pel_psg?></td>
		<td width="25%" >Tgl. Pasang</td><td>: <?=$row->pel_psg?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Tgl. Aktif</td><td>: <?=$row->pel_aktif?></td>
		<td width="25%" >Tgl. Aktif</td><td>: <?=$row->pel_aktif?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Kode Golongan</td><td>: <?=$row->gol_kode?></td>
		<td width="25%" >Kode Golongan</td><td>: <?=sub_select($kode2,$nilai2,$param2)?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Kode Rayon</td><td>: <?=$row->dkd_kd?></td>
		<td width="25%" >Kode Rayon</td><td>: <?=$row->dkd_kd?></td>
	</tr>
	<tr class="table_cont_btm">
		<td colspan="2"></td>
		<td colspan="2">
			<span id="errId">
				<input type="submit" class="form_button" value="Simpan" onclick="simpan('simpan')"/>
				<input type="button" class="form_button" value="Batal" onclick="buka('kembali')"/>
			</span>
		</td>
	</tr>
</table>
<?php
	}
	else{
?>
<center>
	<b>Nomor Pelanggan :</b>
	<input type="text" class="balik_nama" name="pel_no" maxlength="6"/>
	<input type="hidden" class="balik_nama" name="proses" value="detail"/>
	<input type="hidden" class="balik_nama" name="cekUrl" value="periksa_sl.php"/>
	<input type="hidden" class="periksa" name="pel_no" value="1"/>
	<span id="errId"></span>
	<input type="button" class="form_button" value="Proses" onclick="periksa('balik_nama','periksa')"/>
</center>
<?php
	}
?>