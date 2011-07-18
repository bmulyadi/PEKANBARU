<?php
	require "lib.php";
	require "../modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	$db_link 	= new bacaDB();
	$byr0 		= $_GET['byr_no'];
	$que0 		= "SELECT *FROM sopp_rekening WHERE byr_no='$byr0'";
	$res0 		= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
?>
<html>
<head>
	<title><?=$application_name?></title>
	<link rel="stylesheet" type="text/css" href="css/mainindex_print.css"/>
</head>
<body>
<?php
	while($row0 = mysql_fetch_object($res0)){
?>
		<table border="0" width="100%">
				<tbody><tr class="spacer_b">
				<td align="left" width="20%"><img src="images/logo.png" border="0">  </td>

				<td class="title_rek2008" align="right" valign="middle" width="80%">  BUKTI PEMBAYARAN </td>
 
				</tr>
 
				<tr>
				<td align="left" valign="top" width="30%">
				
				<!-- Rek Kiri -->
					<!--<img src="images/logorekening.gif" border="0">-->
						<table>
 					 	<tbody><tr class="form_cell"><td><b>Yth. Bapak/Ibu <?=$row0->pel_nama?></b></td></tr>

						<tr class="form_cell"><td><?=$row0->pel_alamat?></td></tr>
					 	<tr class="form_cell"><td><br><hr>* <b><i>Pemberitahuan</i></b><br>Dengan ini kami informasikan bahwa terhitung mulai bulan juli 2009 untuk pembayaran rekening air PDAM Tirta Raharja dapat dilakukan di loket pelayanan <b><i>PT.POS Indonesia </i></b><i><i>terdekat, dengan dikenakan biaya Administrasi PT.POS sebesar Rp.2000,- <br><br><i>Web : http://www.tirtaraharja.co.id<br>e-mail : pdam@tirtaraharja.co.id<br>SMS : (022)70 600 666</i></i></i></td></tr>

					 	<tr class="form_cell"><td align="center"><hr><b>Profesional, Handal, Menuju Pelayanan Prima</b></td></tr>

					 	</tbody></table>		
					 	
				</td>
				
				
				<td align="center" valign="top">
				<!-- Rek Kanan-->
						

						<table border="0" width="100%">
						<tbody><tr>
							<td class="table_head_rek2008" width="20%">Nomor Pelanggan</td>
							<td class="table_head_rek2008" width="20%">Golongan </td>

							<td class="table_head_rek2008" width="20%">Rayon Pembacaan </td>
							<td class="table_head_rek2008" width="20%">Tagihan Bulan </td>
							<td class="prn_moto_head" width="20%">Copy Rekening</td>

							 
						</tr>
						<tr class="table_cell2_rek2008">
							<td class="table_cell2_rek2008"><?=$row0->pel_no?></td>

							<td class="table_cell2_rek2008"><?=$row0->rek_gol?></td>
							<td class="table_cell2_rek2008"><?=$row0->dkd_kd?></td>
							<td class="table_cell2_rek2008"><?=$bulan[$row0->rek_bln]?> <?=$row0->rek_thn?></td>
						</tr>
						<tr>
							<td class="table_title_rek2008" colspan="5">RINCIAN PERHITUNGAN BIAYA AIR</td>
						</tr>

						<tr>
							<td class="table_head_rek2008" width="20%">Tanggal Pencatatan</td>
							<td class="table_head_rek2008" width="20%">Lalu </td>
							<td class="table_head_rek2008" width="20%">Kini</td>
							<td class="table_head_rek2008" width="20%">Pemakaian</td>
							<td class="table_head_rek2008" width="20%">Total Rp. </td>

						</tr>
						<tr class="table_cell2_rek2008">
							<td class="table_cell2_rek2008"><?=$row0->tgl_baca?></td>
							<td class="table_cell2_rek2008"><?=number_format($row0->rek_stanlalu,0,',','.')?></td>
							<td class="table_cell2_rek2008"><?=number_format($row0->rek_stankini,0,',','.')?></td>
							<td class="table_cell2_rek2008"><?=number_format($row0->rek_stankini-$row0->rek_stanlalu,0,',','.')?></td>
							<td class="table_cell2_rek2008"><?=number_format($row0->byr_total,0,',','.')?></td>

						</tr> 
						<tr>
							<td class="table_title_rek2008" colspan="5">RINGKASAN BIAYA</td>
 

						</tr>
 						<tr>
 							<td colspan="5">
								<table class="" valign="top" align="center" width="75%">
								<tbody><tr class="form_cell"><td align="right" width="150">Pemakaian Air :</td><td align="right"><?=number_format($row0->rek_uangair,0,',','.')?></td></tr>

								<tr class="form_cell"><td align="right">Beban Tetap   :</td><td align="right"><?=number_format($row0->rek_adm+$row0->rek_meter,0,',','.')?></td></tr>
								<tr class="form_cell"><td align="right">Angsuran   :</td><td align="right"><?=number_format($row0->rek_angsuran,0,',','.')?></td></tr>
								<tr class="form_cell"><td align="right">Denda         :</td><td align="right"><?=number_format($row0->rek_denda,0,',','.')?></td></tr>
								<tr class="form_cell"><td align="right">Materai       :</td><td  class="spacer_b" align="right"><?=number_format($row0->rek_materai,0,',','.')?></td></tr>
								
								<tr class="form_cell"><td align="right">Total Bulan Ini :</td><td align="right"><b><?=number_format($row0->byr_total,0,',','.')?></b></td></tr>		
								</tbody></table>

							</td>

						</tr>	
						<tr class="form_cell">
							<td class="table_head_rek2008">Terbilang :</td>
							<td colspan="4" class="table_head_rek2008">
								<?=strtoupper(n2c($row0->byr_total))?>
							</td>
						</tr>
				 		<tr class="form_cell">
							<td colspan="5">
<?
	//tulis_log('../_data/token_log.csv',array(date('Y-m-d H:i:s'),$token,$ipClient,USER_C,8,$row0->pel_no.','.$row0->rek_nomor.','.$row0->byr_no.','.$row0->byr_total),true);
?>
							</td>
						</tr>
					 	</tbody></table>
					 						
	 
 
						
				</td>
				
				</tr>

						<tr>
							<td class="prn_footer" colspan="3" align="center">
							[<?=date('d-m-Y H:m')?>|<?=$ipClient?>|<?=_USER?>]
							<br/>Rekening ini di buat oleh komputer, tanda tangan pejabat PDAM tidak di perlukan dan sebagai bukti pembayaran yang sah
						</td>
						</tr>
				
				</tbody></table>
			<p class="breakhere"></p>
<?
	}
	$db_link->tutup();
?>
<script>
	window.print();
</script>
</p></body></html>
