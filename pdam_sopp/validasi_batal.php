<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	define("_TOKN",$token);
	define("_KODE",$appl_kode);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	define("_NAMA",$appl_nama);
	
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	
	$db_link 	= new bacaDB();
	$que1		= "SELECT *FROM tm_rekening WHERE rek_nomor=$rek_nomor";
	$res1		= mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
	$grandTotal = array(0);
	while($row1 = mysql_fetch_array($res1)){
		$pel_no		= $row1['pel_no'];
		$pel_nama	= $row1['pel_nama'];
		$pel_alamat	= $row1['pel_alamat'];
		$dkd_kd		= $row1['dkd_kd'];
		$kunci		= array_keys($row1);
		for($j=0;$j<count($kunci);$j++){
			$dataField[$kunci[$j]] = $row1[$kunci[$j]];
		}
		$grandTotal[]			= $row1['rek_total']+$row1['rek_denda']+$row1['rek_materai'];
		$dataField['rek_bayar']	= $row1['rek_total']+$row1['rek_denda']+$row1['rek_materai'];
		$dataField['rek_beban'] = $row1['rek_meter']+$row1['rek_adm'];
		$data[]					= $dataField;	
	}
	$i = 0;
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="kembali" 	name="targetId" 	value="nyangberubah"/>
<input type="hidden" class="kembali" 	name="appl_file" 	value="<?=_FILE?>"/>
<input type="hidden" class="kembali" 	name="appl_kode" 	value="<?=_KODE?>"/>
<input type="hidden" class="kembali" 	name="appl_nama" 	value="<?=_NAMA?>"/>
<input type="hidden" class="kembali" 	name="appl_proc" 	value="<?=_PROC?>"/>
<input type="hidden" class="kembali" 	name="targetUrl" 	value="<?=_FILE?>"/>
<table class="table_info">
	<tr class="form_cell">
		<td width="150">No. Pelanggan</td><td>: <?=$pel_no?></td>
		<td>Alamat:</td><td>: <?=preg_replace ("[&]","-", $pel_alamat)?></td>
	</tr>
	<tr class="form_cell">
		<td>Nama</td><td>: <?=preg_replace("[&]","-", $pel_nama)?></td>
		<td width="150">Rayon Pembacaan</td><td>: <?=$dkd_kd?></td>
	</tr>
</table>
<hr/>
<table class="table_info">
	<tr class="table_validator"> 
		<td width="10">No</td>
		<td width="100">Bulan/Tahun</td>
		<td width="250">Rincian Perhitungan Biaya Air</td>
		<td width="250">Rincian Biaya</td>		    
		<td width="100">Total</td>
	</tr>
	<tr class="<?=$class_nya?>" valign="top"> 
		<td><?=($i+1)?></td>
		<td align="right"><?=$bulan[$data[$i]['rek_bln']]?> <?=$data[$i]['rek_thn']?></td>
		<td>
			<table class="<?=$class_nya?>" align="center" width="80%">
				<tr><td align="right">Golongan</td><td align="right">: <?=$data[$i]['rek_gol']?></td></tr>
				<tr><td align="right">Stand Kini</td><td align="right">: <?=number_format(sprintf("%d", $data[$i]['rek_stankini']))?></td></tr>
				<tr><td align="right">Stand Lalu</td><td class="spacer_b" align="right">: <?=number_format(sprintf("%d",$data[$i]['rek_stanlalu']))?></td></tr>
				<tr><td align="right">Pemakaian</td><td align="right">: <?=number_format(sprintf("%d",($data[$i]['rek_stankini']-$data[$i]['rek_stanlalu'])))?></td></tr>
			</table>
		</td>							    
		<td>
			<table class="<?=$class_nya?>" align="center" valign="top" width="100%">
				<tr><td width="150" align="right">Pemakaian Air</td><td align="right">: <?=number_format(sprintf("%d",$data[$i]['rek_uangair']))?></td></tr>
				<tr><td align="right">Beban Tetap</td><td align="right">: <?=number_format(sprintf("%d",$data[$i]['rek_beban']))?></td></tr>
				<tr><td align="right">Angsuran</td><td align="right">: <?=number_format(sprintf("%d",$data[$i]['rek_angsuran']))?></td></tr>
				<tr><td align="right">Denda</td><td align="right">: <?=number_format(sprintf("%d",$data[$i]['rek_denda']))?></td></tr>
				<tr><td align="right">Materai</td><td align="right">: <?=number_format(sprintf("%d",$data[$i]['rek_materai']))?></td></tr>
			</table>
		</td>					    
		<td align="right"><b><?=number_format(sprintf("%d",$data[$i]['rek_bayar']))?></b></td>
	</tr>
	<tr class="table_head">
		<td id="errId" colspan="3">
			<input type="hidden" class="batal" name="targetUrl" value="proses_batal.php"/>
			<input type="hidden" class="batal" name="rek_nomor" value="<?=$rek_nomor?>"/>
			<input type="hidden" class="batal" name="byr_no" value="<?=$byr_no?>"/>
			<input type="button" class="form_button" value="Batal" onclick="buka('kembali')"/>
			<input type="button" class="form_button" value="Validasi Pembatalan" onclick="simpan('batal')"/>
		</td>				
		<td colspan="2" valign="top"><b><?=number_format(sprintf("%d",array_sum($grandTotal)))?></b></td>
	</tr>
</table>