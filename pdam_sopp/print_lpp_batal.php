<?php
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	$db_link 	= new bacaDB();
	$awal 		= $_GET['f1'];
	$akhir 		= $_GET['f2'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$application_name?></title>
<style type="text/css">
<!--@import"css/mainindex_print.css";-->
</style>
</head>
<body >
<?
	$head = array('No','Tanggal Validasi','Cetak Berita Acara','Tanggal Bayar','Kasir','Pemeriksa','Pelanggan','Bulan','Tahun','Total Pembatalan');
	$que0 = "SELECT a.* FROM v_lap_pembatalan a JOIN tm_pelanggan b ON(a.pel_no=b.pel_no) WHERE date(a.byr_upd_sts)>=str_to_date('$awal','%d-%m-%Y') AND date(a.byr_upd_sts)<=str_to_date('$akhir','%d-%m-%Y')";
	$res0 = mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
?>
<h4>Laporan Pembatalan Rekening</h4>
<hr/>
<table>
	<tr class="form_cell">
		<td>Tanggal Batal</td>
		<td>:</td>
		<td><?=$awal?> s/d <?=$akhir?></td>
	</tr>
</table>
<table width="100%">

	<tr class="table_head">
<?
	for($k=0; $k<count($head); $k++){
?>
		<td nowrap><?=$head[$k]?></td>
<?
	}
?>
	</tr>
<?
		for($i=0; $i<mysql_num_rows($res0); $i++){
			$row0 = mysql_fetch_row($res0);
			if($i%2 == 0){
				$class_nya = "class=\"table_cell1\"";
			}
			else{
				$class_nya = "class=\"table_cell1\"";
			}
?>
			<tr <?=$class_nya?>>
				<td style="text-align:right"><?=($i+1)?></td>
<?
				for($j=0; $j<mysql_num_fields($res0); $j++){
					if($j == 5){
						$val[$j] = $row0[$j];
						$jml[$j]++;
					}
					else if($j == 8){
						$val[$j] = number_format($row0[$j],0,",",".");
						$jml[$j] += $row0[$j];
					}
					else{
						$val[$j] = $row0[$j];
					}
?>
					<td nowrap align="right"><?=$val[$j]?></td>
<?
				}
				$val = NULL;
?>
			</tr>
<?
		}
		$db_link->tutup();
?>
	<tr class="table_head">
<?
		for($l=0; $l<count($head); $l++){
			if($l == 6){
				$val[$l] = number_format($jml[($l-1)],0,",",".");
			}
			else if($l == 9){
				$val[$l] = number_format($jml[($l-1)],0,",",".");
			}
?>
		<td nowrap align="right"><?=$val[$l]?></td>
<?
	}
?>
	</tr>
</table>

<script>
	window.print();
</script>
</body>
</html>