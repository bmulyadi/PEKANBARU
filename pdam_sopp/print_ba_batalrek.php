<?php
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$application_name?></title>
<style type="text/css"><!--@import"css/mainindex_print.css";--></style>
</head>
<body>
<?php
		$rek_nomor	= $_GET['rek_nomor'];
		$byr_no		= $_GET['byr_no'];
		$token		= $_GET['token'];
		$stsLog		= $_SESSION['aktif_log'];
		$db_link	= new tulisDB();
		$que7 		= "CALL sopp_batal_rek($token,'$rek_nomor','$byr_no','"._USER."',0,@sts)";
		mysql_query($que7) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que7)));
		$que6 		= "SELECT *FROM tm_rekening WHERE rek_nomor='$rek_nomor'";
		$res6 		= mysql_query($que6) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que6)));
		$row6 		= mysql_fetch_object($res6);
		$rek_total		= $row6->rek_total+$row6->rek_denda+$row6->rek_materai;
		$beban_tetap	= $row6->rek_adm+$row6->rek_meter;
		define("_TOKN",$token);
		errorHD::tulisLOG(array($row6->pel_no,"Cetak berita acara pembatalan rekening ".$bulan[$row6->rek_bln]." ".$row6->rek_thn),$stsLog);
		$db_link->tutup();
?>
<table>
	<tr class="form_cell">
		<td align="Center"><img src="images/logo.png"><b>Berita Acara Pembatalan Pembayaran Rekening</b></td>
	</tr>
	<tr class="form_cell">
		<td align="left">Pada Hari ini Tanggal, <?=$tanggal?>. Telah batalkan pembayaran rekening Atas Nama :</td>
	</tr>
	<tr>
		<td>
			<!-- Rek Kiri -->
			<table align="Center" border="0">
				<tr class="form_cell"><td width="100">No. Pelanggan</td><td >: <span class="nopel" id="<?=$row6->pel_no?>"> <?=$row6->pel_no?></span></td> </tr>
				<tr class="form_cell"><td>Nama</td><td >: <span class="nopel" id="<?=$row6->pel_no?>"> <?=$row6->pel_nama?></span></td> </tr>
				<tr class="form_cell"><td>Golongan</td><td>: <?=$row6->rek_gol?></td></tr>
				<tr class="form_cell"><td></td></tr>
				<tr class="form_cell"><td>Rekening Bulan </td><td>: <?=$bulan[$row6->rek_bln]?> <?=$row6->rek_thn?></td></tr>
				<tr class="form_cell"><td>Pemakaian Air</td><td>: <?=number_format(sprintf("%d",$row6->rek_uangair))?> </td></tr>
				<tr class="form_cell"><td>Beban Tetap</td><td>: <?=number_format(sprintf("%d",$beban_tetap))?></td></tr>
				<tr class="form_cell"><td>Angsuran</td><td>: <?=number_format(sprintf("%d",$row6->rek_angsuran))?></td></tr>
				<tr class="form_cell"><td>Denda</td><td>: <?=number_format(sprintf("%d",$row6->rek_denda))?></td></tr>
				<tr class="form_cell"><td>Materai</td><td>: <?=number_format(sprintf("%d",$row6->rek_materai))?></td></tr>
				<tr class="spacer_b" ><td>&nbsp;</td></tr>
				<tr class="form_cell"><td>Total </td><td>:<b><?=number_format(sprintf("%d",$rek_total))?></b></td></tr>
			</table>
		</td>
	</tr>
	<tr class="form_cell"><td align="left">Demikian berita acara ini di buat, untuk di pergunakan sebagaimana mestinya</td></tr>
	<tr class="form_cell"><td align="left">Bandung,<?=$tanggal?></td></tr>
	<tr class="form_cell">
		<td align="left">
			<table>
				<tr  class="form_cell">
					<td align="center"><b>KAS</b></td>
					<td align="center"><b>Pelanggan</b></td>
				</tr>
				<tr>
					<td align="center"><br/><br/><br/><br/><b>(<?=$_SESSION['Name_c']?>)</b></td>
					<td align="center"><br/><br/><br/><br/><b>(<?=$row6->pel_nama?>)</b></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
	<script>
		window.print();
	</script>
</html>