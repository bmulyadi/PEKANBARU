<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();

	if(isset($_SESSION['tgl_denda'])){
		$_SESSION['tgl_denda'] = $tgl_denda;
	}
	
	define("_ALOG",$_SESSION['aktif_log']);
	define("_TOKN",$token);
	define("_KODE",$appl_kode);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	define("_NAMA",$appl_nama);
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="kembali noRek" 	name="targetId" 	value="nyangberubah"/>
<input type="hidden" class="kembali noRek" 	name="appl_file" 	value="<?=_FILE?>"/>
<input type="hidden" class="kembali noRek" 	name="appl_kode" 	value="<?=_KODE?>"/>
<input type="hidden" class="kembali noRek" 	name="appl_nama" 	value="<?=_NAMA?>"/>
<input type="hidden" class="kembali noRek" 	name="appl_proc" 	value="<?=_PROC?>"/>
<input type="hidden" class="kembali" 		name="targetUrl" 	value="<?=_FILE?>"/>
<?php
	switch($appl){
		case "dibayar":
			$con0 = new tulisDB();
			for($i=0;$i<$ulangan;$i++){
				if($pilih[$i] == 1){
					$noRekDibayar[] = $noRek[$i];
					$rekLog[]		= array($noRek[$i],$rekBayar[$i]);
					$logMess[]		= array($pel_no,"Bayar rekening ".$bulan[abs(substr($noRek[$i],4,2))]." ".substr($noRek[$i],0,4));
				}
			}
			$noREK	= implode(",",$noRekDibayar);
			$que0 	= "CALL sopp_bayar_rek(@e_sts,'$token','$noResi','P','$bayar','$dibayar','$pel_no','$noREK','"._USER."','"._IP."')";
			$que1	= "CALL sopp_kps('$token','$pel_no','"._USER."',@k_sts)";
			$que2	= "SELECT @e_sts AS byr_sts";
			mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
			for($i=0;$i<count($rekLog);$i++){
				//errorHD::rekLOG($rekLog[$i]);
				//errorHD::tulisLOG($logMess[$i]);
			}
			mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
			$res2	= mysql_query($que2) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que2)));
			$row2	= mysql_fetch_object($res2);
			if($row2->byr_sts>0){
				$logMess = "Transaksi selesai";
?>
<h3>Klik tombol CETAK REKENING untuk mencetak rekening</h3>
<input type="hidden" class="rekening" name="byr_no" value="<?=_TOKN?>"/>
<input type="hidden" class="rekening" name="targetUrl" value="print_rekening.php"/>
<input type="button" value="Cetak Rekening" class="form_button" onclick="cetakin('rekening')"/>
&nbsp;<input type="button" value="Selesai" class="form_button" onclick="buka('kembali')"/>
<?php
			}
			else{
				$logMess = "Transaksi gagal diproses";
?>
<h3><?=$logMess?></h3>
<input type="button" value="Kembali" class="form_button" onclick="buka('kembali')"/>
<?php
			}
			//errorHD::tulisLOG(array($pel_no,$logMess),_ALOG);
			$con0->tutup();
			break;
		case "buka":
			$db_link 	= new bacaDB();
			$kodeResi	= substr($noResi,0,1);
			$que1		= "SELECT *,getDenda(pel_no,rek_gol,rek_bln,rek_thn) AS denda,getMaterai(rek_total+getDenda(pel_no,rek_gol,rek_bln,rek_thn)) AS materai FROM tm_rekening WHERE pel_no='$pel_no' AND rek_sts=1 AND rek_byr_sts=0 ORDER BY rek_thn,rek_bln";
			$res1		= mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
			$rekening	= false;
			$grandTotal = array(0);
			while($row1 = mysql_fetch_array($res1)){
				$pel_no		= $row1['pel_no'];
				$pel_nama	= $row1['pel_nama'];
				$pel_alamat	= $row1['pel_alamat'];
				$dkd_kd		= $row1['dkd_kd'];
				if($row1['rek_byr_sts']==0){
					$rekening	= true;
					$kunci		= array_keys($row1);
					for($j=0;$j<count($kunci);$j++){
						$dataField[$kunci[$j]] = $row1[$kunci[$j]];
					}
					$grandTotal[]			= $row1['rek_total']+$row1['denda']+$row1['materai'];
					$dataField['rek_bayar']	= $row1['rek_total']+$row1['denda']+$row1['materai'];
					$dataField['rek_beban'] = $row1['rek_meter']+$row1['rek_adm'];
					$data[]					= $dataField;	
				}
			}
?>
<input type="hidden" class="noRek"	 		name="targetUrl" 	value="<?=_PROC?>"/>
<input type="hidden" class="noRek" 			name="noResi" 		value="<?=$noResi?>"/>
<input type="hidden" class="noRek" 			name="appl" 		value="dibayar"/>
<input type="hidden" class="noRek print" 	name="pel_no" 		value="<?=$pel_no?>"/>
<input type="hidden" class="noRek print"	name="token" 		value="<?=_TOKN?>"/>
<input type="hidden" class="print" 			name="targetUrl" 	value="print_daftar_tunggakan.php"/>
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
<?php
			if($rekening){
?>
<table class="table_info">
	<tr class="table_head"> 
		<td colspan="3" align="left">
			<input type="button" class="form_button" value="Batal" onclick="buka('kembali')"/>
			<input type="button" class="form_button" value="Cetak Tagihan" onclick="cetakin('print')"/>
		</td>			
		<td align="left">No Resi Rekening Terakhir : <?=$noResi?></td>
		<td align="right">Grand Total :</td>				
		<td align="right" valign="center"><b><?=number_format(sprintf("%d",array_sum($grandTotal)))?></b></td>
		<td align="center">
			<input type="button" value="Bayar" class="form_button" onClick="peringatan('kalkulator')"/> 
		</td>				
	</tr>
	<tr class="table_validator"> 
		<td width="10">No</td>
		<td width="100">Bulan/Tahun</td>
		<td width="250">Rincian Perhitungan Biaya Air</td>
		<td width="250">Rincian Biaya</td>
		<td width="100">Biaya Lain </td>				    
		<td width="100">Total</td>
		<td></td>
	</tr>
<?php
				for($i=0;$i<count($data);$i++){
					$class_nya 		= "table_cell1";
					if ($i%2==0){
						$class_nya 	= "table_cell2";
					}
?>
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
				<tr><td align="right">Denda</td><td align="right">: <?=number_format(sprintf("%d",$data[$i]['denda']))?></td></tr>
				<tr><td align="right">Materai</td><td align="right">: <?=number_format(sprintf("%d",$data[$i]['materai']))?></td></tr>
			</table>
		</td>
		<td></td>						    
		<td align="right"><b><?=number_format(sprintf("%d",$data[$i]['rek_bayar']))?></b></td>
		<td align="center">
			<input type="hidden" class="noRek" name="noRek[<?=$i?>]" value="<?=$data[$i]['rek_nomor']?>"/>
			<input type="hidden" class="noRek" name="rekBayar[<?=$i?>]" value="<?=$data[$i]['rek_bayar']?>"/>
			<input id="total_<?=$i?>" type="hidden" value="<?=$data[$i]['rek_bayar']?>"/>
			<input id="pilih_<?=$i?>" type="hidden" class="noRek" name="pilih[<?=$i?>]" value="0"/>
			<input type="checkbox" class="pilih" onclick="pilihin('<?=$i?>')"/>
		</td>
	</tr>
<?		
				}
?>					   				   
	<tr class="table_head"> 
		<td colspan="3" align="left">
			<input type="hidden" class="noRek" name="ulangan" value="<?=$i?>"/>
			<input type="button" class="form_button" value="Batal" onclick="buka('kembali')"/>
			<input type="button" class="form_button" value="Cetak Tagihan" onclick="cetakin('print')"/>
		</td>			
		<td align="left">No Resi Rekening Terakhir : <?=$noResi?></td>
		<td align="right">Grand Total :</td>				
		<td align="right" valign="top"><b><?=number_format(sprintf("%d",array_sum($grandTotal)))?></b></td>
		<td align="center">
			<input id="bayar" type="hidden" class="noRek kalkulator" name="bayar" value="0"/>
			<input type="hidden" class="kalkulator" name="targetUrl" value="kalkulator.php"/>
			<input type="button" value="Bayar" class="form_button" onClick="peringatan('kalkulator')"/> 
		</td>				
	</tr>
</table>
<?php
				//errorHD::tulisLOG(array($pel_no,"Ditemukan tunggakan ".array_sum($grandTotal)),_ALOG);
			}
			$db_link->tutup();		
			break;
	}
?>