<?php
	require "model/tulisDB.php";
	require "modul.inc.php";
	cek_pass();
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
	if(isset($_POST['token'])){
		define("_TOKN",$token);
	}
	else{
		define("_TOKN",date('ymdHis').getToken());
	}
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="kembali ganti_wm" 	name="targetUrl" value="<?=_FILE?>"/>
<input type="hidden" class="kembali ganti_wm" 	name="targetId"  value="nyangberubah"/>
<input type="hidden" class="kembali ganti_wm" 	name="appl_kode" value="<?=_KODE?>"/>
<input type="hidden" class="kembali ganti_wm" 	name="appl_file" value="<?=_FILE?>"/>
<input type="hidden" class="kembali ganti_wm" 	name="appl_proc" value="<?=_PROC?>"/>
<input type="hidden" class="kembali ganti_wm" 	name="appl_nama" value="<?=_NAMA?>"/>
<input type="hidden" class="ganti_wm simpan"	name="token" value="<?=_TOKN?>"/>
<?php
	if($proses=="detail"){
		/** koneksi database */
		$link 	= new bacaDB();
		$que	= "SELECT *FROM v_data_pelanggan WHERE pel_no='$pel_no'";
		$res	= mysql_query($que) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que)));
		$row	= mysql_fetch_object($res);
		/* ukuran meter */
		$param1 = array("kelas"=>"simpan","nama"=>"um_kode","pilihan"=>$row->um_kode,"status"=>"style=\"font-size: 9pt\""); 
		$que1 	= "SELECT um_kode,CONCAT(um_ukuran,' inch') FROM tr_ukuranmeter ORDER BY um_kode";
		$res1 	= mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
		while($row1 = mysql_fetch_row($res1)){
			$kode1[] 	= $row1[0];
			$nilai1[] 	= $row1[1];
		}
		/* merk meter */
		$param2 = array("kelas"=>"simpan","nama"=>"mer_kode","pilihan"=>$row->mer_kode,"status"=>"style=\"font-size: 9pt\""); 
		$que2 	= "SELECT mer_kode,mer_ket FROM tr_merk ORDER BY mer_kode";
		$res2 	= mysql_query($que2) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que2)));
		while($row2 = mysql_fetch_row($res2)){
			$kode2[] 	= $row2[0];
			$nilai2[] 	= $row2[1];
		}
		/* rayon */
		$param3 = array("kelas"=>"simpan","nama"=>"dkd_kd","pilihan"=>$row->dkd_kd,"status"=>"style=\"font-size: 9pt\""); 
		$que3 	= "SELECT dkd_kd,CONCAT('[',dkd_kd,'] ',dkd_jalan) FROM tr_dkd ORDER BY dkd_kd";
		$res3 	= mysql_query($que3) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que3)));
		while($row3 = mysql_fetch_row($res3)){
			$kode3[] 	= $row3[0];
			$nilai3[] 	= $row3[1];
		}
		$link->tutup();
?>
<input type="hidden" class="simpan" name="pel_no" value="<?=$pel_no?>"/>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<table class="table_info">
	<tr class="form_cell">
		<td width="150">No. Pelanggan</td><td>: <?=$row->pel_no?></td>
		<td></td>
	</tr>
	<tr class="form_cell">
		<td>Nama</td><td>: <?=preg_replace("[&]","-", $row->pel_nama)?></td>
		<td>Alamat</td><td>: <?=preg_replace ("[&]","-", $row->pel_alamat)?></td>
	</tr>
</table>
<hr/>
<table> 	 
	<tr class="table_head"> 				  				    
		<td width="40%"><b>WM LAMA</b></td>
		<td><b>WM BARU</b></td>
	</tr>
	<tr valign="top">  
		<td>
<?php
		$ganti_wm = 0;
		if($row->met_ada>0){
			$ganti_wm = 1;
?>		
			<table> 	 
				<tr>
					<td width="25%"><b>No. WM</b></td>
					<td>: <?=$row->pel_nowm?></td>
				</tr>
				<tr>
					<td><b>Ukuran</b></td>
					<td>: <?=$row->um_ket?></td>
				</tr>
				<tr>
					<td><b>Merk</b></td>
					<td>: <?=$row->mer_ket?></td>
				</tr>
				<tr>
					<td><b>Tgl. Ganti</b></td>
					<td>: <?=$row->pel_psg?></td>
				</tr>
				<tr>
					<td><b>Stand Lama</b></td>
					<td>: <?=$row->sm_lalu?></td>
				</tr>
			</table>
<?php
		}
?>
		</td>
		<td>
			<input type="hidden" class="simpan" name="ganti_wm" value="<?=$ganti_wm?>"/>
			<table>
				<tr>
					<td width="25%"><b>No. BA</b></td>
					<td>: <input type="text" class="simpan" name="ba_no" size="25" maxlength="100"/> *</td>
				</tr>
				<tr>
					<td><b>Ukuran</b></td>
					<td>: <?=sub_select($kode1,$nilai1,$param1)?></td>
				</tr>
				<tr>
					<td><b>Merk</b></td>
					<td>: <?=sub_select($kode2,$nilai2,$param2)?></td>
				</tr>
				<tr>
					<td><b>Rayon</b></td>
					<td>: <?=sub_select($kode3,$nilai3,$param3)?></td>
				</tr>
				<tr>
					<td><b>Tgl. Ganti</b></td>
					<td>: <input type="text" class="simpan" name="met_tgl" size="25" maxlength="10" value="<?=date('d/m/Y')?>"/><br/>* (Format: tanggal/bulan/tahun - 02/05/2009)</td>
				</tr>
				<tr>
					<td><b>Stand Angkat</b></td>
					<td>: <input type="text" class="simpan" name="stand_angkat" size="25" maxlength="9"/></td>
				</tr>
				<tr>
					<td><b>Stand Awal</b></td>
					<td>: <input type="text" class="simpan" name="stand_awal" size="25" maxlength="9"/> *</td>
				</tr>
				<tr>
					<td><b>No. WM baru</b></td>
					<td>: <input type="text" class="simpan" name="pel_nowm" size="25" maxlength="50"/> *</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="table_cont_btm">
		<td id="errId" colspan="2">
			<input type="submit" class="form_button" value="Simpan" onclick="simpan('simpan')"/>
			<input type="button" class="form_button" value="Batal" onclick="buka('kembali')"/>
		</td>
	</tr>
</table>
<?php
	}
	else{
?>
<center>
	<b>Nomor Pelanggan :</b>
	<input type="text" 		class="ganti_wm" name="pel_no" maxlength="6"/>
	<input type="hidden" 	class="ganti_wm" name="proses" value="detail"/>
	<input type="hidden" 	class="ganti_wm" name="cekUrl" value="periksa_wm.php"/>
	<input type="hidden" 	class="periksa" name="pel_no" value="1"/>
	<span id="errId"></span>
	<input type="button" class="form_button" value="Proses" onclick="periksa('ganti_wm','periksa')"/>
</center>
<?php
	}
?>