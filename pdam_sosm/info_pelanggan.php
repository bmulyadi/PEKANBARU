<?php
	/** kode1 yang akan memindahkan semua nilai dalam array POST ke dalam */
	/*	variabel yang bersesuaian dengan masih kunci array */
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	/** koneksi database */
	require "model/tulisDB.php";
	require "lib.php";
	$link 	= new bacaDB();
	switch($aksi){
		case "transaksi":
			$que1	= "SELECT *FROM seed_lpp WHERE pel_no='$pel_no' ORDER BY byr_tgl DESC LIMIT 1";
			$res1	= mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
			$row1	= mysql_fetch_object($res1);
			if(mysql_num_rows($res1)>0){
?>
<table class="table_info">
	<tr class="table_validator">
		<td rowspan="2" class="center">Bulan/Tahun</td>
		<td rowspan="2" class="center">Tanggal Bayar</td>
		<td colspan="3" class="center">Stand Meter</td>
		<td colspan="4" class="center">Rincian Biaya</td>
		<td rowspan="2" class="center">Total</td>
	</tr>
	<tr class="table_validator">
		<td class="center">Lalu</td>
		<td class="center">Kini</td>
		<td class="center">Pakai</td>
		<td class="center">Uang Air</td>
		<td class="center">Beban Tetap</td>
		<td class="center">Denda</td>
		<td class="center">Materai</td>
	</tr>
	<tr class="table_validator">
		<td class="center"><?=$bulan[$row1->rek_bln]." ".$row1->rek_thn?></td>
		<td class="center"><?=$row1->byr_tgl?></td>
		<td class="center"><?=number_format($row1->rek_stanlalu)?></td>
		<td class="center"><?=number_format($row1->rek_stankini)?></td>
		<td class="center"><?=number_format(($row1->rek_stankini-$row1->rek_stanlalu))?></td>
		<td class="center"><?=number_format($row1->rek_uangair)?></td>
		<td class="center"><?=number_format(($row1->rek_meter+$row1->rek_adm))?></td>
		<td class="center"><?=number_format($row1->rek_denda)?></td>
		<td class="center"><?=number_format($row1->rek_materai)?></td>
		<td class="center"><?=number_format(($row1->rek_total+$row1->rek_denda+$row1->rek_materai))?></td>
	</tr>
</table>
<?php
			}
			break;
		case "tunggakan";
			$que1	= "SELECT *FROM sopp_drd WHERE pel_no='$pel_no'";
			$res1	= mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
			if(mysql_num_rows($res1)>0){
?>
<input type="hidden" class="cetak" name="targetUrl" value="print_tunggakan.php"/>
<input type="hidden" class="cetak" name="targetId"  value="prinin"/>
<table class="table_info">
	<tr class="table_validator">
		<td rowspan="2" class="center">No.</td>
		<td rowspan="2" class="center">Bulan/Tahun</td>
		<td colspan="3" class="center">Stand Meter</td>
		<td colspan="4" class="center">Rincian Biaya</td>
		<td rowspan="2" class="center">Total</td>
	</tr>
	<tr class="table_validator">
		<td class="center">Lalu</td>
		<td class="center">Kini</td>
		<td class="center">Pakai</td>
		<td class="center">Uang Air</td>
		<td class="center">Beban Tetap</td>
		<td class="center">Denda</td>
		<td class="center">Materai</td>
	</tr>
<?php
			$i = 0;
			while($row1	= mysql_fetch_object($res1)){
				$i++;
				$rek_uangair[$i]	= $row1->rek_uangair;
				$rek_beban[$i]		= $row1->rek_meter+$row1->rek_adm;
				$rek_denda[$i]		= $row1->rek_denda;
				$rek_materai[$i]	= $row1->rek_materai;
				$total[$i]			= $row1->rek_total+$row1->rek_denda+$row1->rek_materai;
				$kelasnya 			= "table_cell1";
				if (bcmod($i,2)== 0){
					$kelasnya ="table_cell2";
				}
?>
	<tr class="<?=$kelasnya?>">
		<td class="right"><?=$i?></td>
		<td class="right"><?=$bulan[$row1->rek_bln]." ".$row1->rek_thn?></td>
		<td class="right"><?=number_format($row1->rek_stanlalu)?></td>
		<td class="right"><?=number_format($row1->rek_stankini)?></td>
		<td class="right"><?=number_format(($row1->rek_stankini-$row1->rek_stanlalu))?></td>
		<td class="right"><?=number_format($rek_uangair[$i])?></td>
		<td class="right"><?=number_format($rek_beban[$i])?></td>
		<td class="right"><?=number_format($rek_denda[$i])?></td>
		<td class="right"><?=number_format($rek_materai[$i])?></td>
		<td class="right"><?=number_format($total[$i])?></td>
	</tr>
<?php
			}
?>
	<tr class="table_head">
		<td class="right" colspan="5"></td>
		<td class="right"><?=number_format(array_sum($rek_uangair))?></td>
		<td class="right"><?=number_format(array_sum($rek_beban))?></td>
		<td class="right"><?=number_format(array_sum($rek_denda))?></td>
		<td class="right"><?=number_format(array_sum($rek_materai))?></td>
		<td class="right"><?=number_format(array_sum($total))?></td>
	</tr>
</table>
<?php
			}
			break;
	}
	$link->tutup();
?>