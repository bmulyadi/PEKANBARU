<?
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	define("_ALOG",$_SESSION['aktif_log']);
	define("_TOKN",$_GET['token']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$application_name?></title>
<style type="text/css">
<!--
	@import"css/mainindex_print.css";
-->
</style>
</head>
<body>
<?
	$db_link 	= new bacaDB();
	$pel_no		= $_GET['pel_no'];
	$que1		= "SELECT *,getDenda(pel_no,rek_gol,rek_bln,rek_thn) AS denda,getMaterai(rek_total+getDenda(pel_no,rek_gol,rek_bln,rek_thn)) AS materai FROM tm_rekening WHERE pel_no='$pel_no' AND rek_sts=1 AND rek_byr_sts=0 ORDER BY rek_thn,rek_bln";
	$res1		= mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
	$grandTotal = array(0);
	while($row1 = mysql_fetch_array($res1)){
		$info		= true;
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
			$grandTotal[]		= $row1['rek_total']+$row1['denda']+$row1['materai'];
			$dataField['rek_bayar']	= $row1['rek_total']+$row1['denda']+$row1['materai'];
			$dataField['rek_beban'] = $row1['rek_meter']+$row1['rek_adm'];
			$data[]			= $dataField;	
		}
	}
?>
<h2>Daftar Tagihan</h2>
<table class="table_info">
	<tr class="form_cell">
		<td width="150">No. Pelanggan</td><td>: <?=$pel_no?></td>
		<td>Alamat:</td><td>: <?=preg_replace("[&]","-", $pel_alamat)?></td>
	</tr>
	<tr class="form_cell">
		<td>Nama</td><td>: <?=preg_replace("[&]","-", $pel_nama)?></td>
		<td width="150">Rayon Pembacaan</td><td>: <?=$dkd_kd?></td>
	</tr>
</table>
<hr/>
<table width="100%">
	<tr class="table_head"> 
	    <td width="5%" rowspan="2" valign="top">Bulan/Tahun</td>
	    <td colspan="3">Stand Meter</td>
	    <td width="20%" colspan="5">Riancian Biaya</td>
	    <td width="10%" rowspan="2" valign="top">Total</td>
	</tr>
	<tr class="table_head">     	
	    <td width="5%">Lalu</td>
	    <td width="5%">Kini</td>
	    <td width="5%">Pemakaian</td>					    
	    <td>Uang Air</td>
	    <td>Beban Tetap</td>
	    <td>Angsuran</td>
	    <td>Denda</td>			    				    
	    <td>Materai</td>
	</tr>
<?php
	for($i=0;$i<count($data);$i++){
		$class_nya 		= "table_cell1";
		if ($i%2==0){
			$class_nya 	= "table_cell2";
		}
?>
	<tr class="<?=$class_nya?>">
		<td><?=$bulan[$data[$i]['rek_bln']]." ".$data[$i]['rek_thn']?></td>
		<td><?=number_format($data[$i]['rek_stanlalu'])?></td>
		<td><?=number_format($data[$i]['rek_stankini'])?></td>
		<td><?=number_format($data[$i]['rek_stankini']-$data['rek_stanlalu'])?></td>
		<td><?=number_format($data[$i]['rek_uangair'])?></td>
		<td><?=number_format($data[$i]['rek_beban'])?></td>
		<td><?=number_format($data[$i]['rek_angsuran'])?></td>
		<td><?=number_format($data[$i]['denda'])?></td>
		<td><?=number_format($data[$i]['materai'])?></td>
		<td><?=number_format($grandTotal[$i+1])?></td>
	</tr>
<?php
	}
	errorHD::tulisLOG(array($pel_no,"Cetak daftar tunggakan"),_ALOG);
	$db_link->tutup();
?>
	<tr class="table_head"> 
		<td colspan="9" align="right">Grand Total</td>				
		<td align="right"><b><?=number_format(sprintf("%d",array_sum($grandTotal)))?></b></td>
	</tr>
</table>
<P CLASS="breakhere">
<script>
	window.print();
</script>
</body>
</html>
