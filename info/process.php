<?php
	//var_dump($_POST);
	require "../default.php";
	require "../modul.inc.php";
	if($_POST['id1']>0){
		$db_link	= konek_baca_db();
		$f1 		= $_POST['id1'];
		$que0 		= "SELECT *FROM v_info_pelanggan WHERE pel_no='$f1'";
		$res0		= mysql_query($que0) or die(salah_db("../_data/error_db.csv",array(date('Y-m-d H:m:s'),$ipClient,mysql_errno(),mysql_error(),"Gagal query ".$que0),true));
		$row0 		= mysql_fetch_object($res0);
		if(isset($_POST['id3'])){
			$rek_jumlah = $_POST['id3'];
			$rek_total = $_POST['id4'];
		}
		else{
			$que2 = "SELECT *FROM v_resume_tunggakan WHERE pel_no='$f1'";
			$res2 = mysql_query($que2) or die(salah_db("../_data/error_db.csv",array(date('Y-m-d H:m:s'),$ipClient,mysql_errno(),mysql_error(),"Gagal query ".$que2),true));
			$row2 = mysql_fetch_object($res2);
			$rek_jumlah = $row2->rek_jumlah;
			$rek_total 	= $row2->rek_total;
		}
		
		$mess = NULL;
		$back = '<br /><a onclick="getTabData()"><img src="images/kembali.jpg" /></a>';
		$sts_nopel = true ;

		if (!$row0->pel_no){
			$mess = "<img src='images/logo-pdam.png' /><br /><br />Data Pelanggan Tidak Ada";
			$sts_nopel = false;
		}
		else{
			$rek_perpage = 9;
			if($rek_jumlah <= $rek_perpage){
				$jml_page = 1;
			}
			else if($rek_jumlah%$rek_perpage == 0){
				$jml_page = $rek_jumlah/$rek_perpage;
			}
			else{
				$jml_page = 1 + ($rek_jumlah-($rek_jumlah%$rek_perpage))/$rek_perpage;
			}
			
			if(isset($_POST['id2'])){
				$page = $_POST['id2'];
				$limitA = ($page-1) * $rek_perpage;
			}
			else{
				$page = 1;
				$limitA = 0;
			}
			$limitB = $rek_perpage;
			
			$que1 = "select * from v_drd where pel_no = '$f1' order by rek_tgl asc limit $limitA,$limitB";
			$res1 = mysql_query($que1) or die(salah_db("../_data/error_db.csv",array(date('Y-m-d H:m:s'),$ipClient,mysql_errno(),mysql_error(),"Gagal query ".$que1),true));
		}
		
		if ($sts_nopel) {
			$grand_tot = 0 ; 
?>
			<ajax-response>			
			<response type="element" id="nyangberubah">
				<input class="id1" type="hidden" value="<?=$row0->pel_no?>">
				<form name='form'>
			    <h1>Data Pelanggan</h1>
				<table width="100%" border="0">
					<tr class="form_cell" >
						<td width="20%">No. Pelanggan</td>
						<td  colspan="2">: <?=$row0->pel_no?></td>
					</tr>
					<tr class="form_cell" >
						<td>Nama</td>
						<td>: <?=$row0->pel_nama?></td>
						<td width="20%">Golongan</td>
						<td>: <?=$row0->gol_kode?></td>
					</tr>
					<tr class="form_cell" >
						<td>Alamat</td>
						<td>: <?=$row0->pel_alamat?></td>
						<td  >Rayon Pembacaan</td>
						<td>: <?=$row0->dkd_kd?></td>
					</tr>
					<tr class="form_cell" >
						<td >Status Pelanggan</td>
						<td >: <b><?=$row0->kps_ket?></b></td>
						<td  >Jumlah Rekening</td>
						<td>: <?=(int) $rek_jumlah?></td>
					</tr>
	 			</table>
				<hr/>
<?
				if($rek_jumlah==0){
					echo "<br/><br/><br/><div align=\"center\">";
					echo "<h2>Terima Kasih Telah Membayar Rekening Tepat Waktu</h2>";
					echo $back;
					echo "</div>";
				}
				else{
?>
					<div align="right" style="font-size:13pt">
						Halaman
<?
						for($k=1;$k<=$jml_page;$k++){
							if($k == $page){
?>
								<a style="color:#fff;font-size:16px;background:#1a5372;border:0 none;padding:5px;" onClick="next_page('<?=$k?>','<?=$rek_jumlah?>','<?=$rek_total?>')"><strong><?=$k?></strong></a>
<?
							}
							else{
?>
								<a style="color:#fff;font-size:14px;background:#46bfd0;border:1px solid #fff;padding:4px;" onClick="next_page('<?=$k?>','<?=$rek_jumlah?>','<?=$rek_total?>')"><?=$k?></a>
<?
							}
						}
?>
					</div>
					<table width="100%" align="center">
					<tr class="table_head" >
						<td width="1%" rowspan="2" valign="center">No.</td>
						<td width="7%" rowspan="2" valign="center">Bulan Tahun</td>
						<td colspan="3" >Stand Meter</td>
						<td width="20%" colspan="3" >Rincian Biaya</td>
						<td width="10%" rowspan="2" valign="center">Total</td>
					  </tr>
					<tr class="table_head">     	
						<td width="5%" >Lalu</td>
						<td width="5%" >Kini</td>
						<td width="5%" >Pemakaian</td>					    
						<td >Uang Air</td>
						<td >Beban Tetap</td>
						<td >Angsuran</td>
					</tr>	
<?php	
						$i= 1 ;
						while ($row1 = mysql_fetch_object($res1)){
							$class_nya = "table_cell1" ;
							if ($i%2== 0){
								$class_nya ="table_cell2";
							}
							
							$total_rek = $row1->rek_total ; 
							$beban_tetap  = $row1->rek_meter+$row1->rek_lain+$row1->rek_adm ; 						
							
							/* Cek Bulan */						
							$bln_proc = $row1->rek_bln * 1 ; 
							$bln_print = $bln_proc - 1 ;
							$thn_print = $row1->rek_thn ;
							if ($bln_print == 0 ){
								$bln_print = 12;
								$thn_print = $row1->rek_thn - 1;
							}
?>
							<tr class="<?=$class_nya?>" valign="top">
								<td align="center"><?=$i+$limitA?></td>
								<td ><?=$bulan[$bln_proc]?> <?=$row1->rek_thn?></td>
								<td align="right"><?= number_format(sprintf ("%d", $row1->rek_stanlalu ));?> </td> 
								<td align="right"><?= number_format(sprintf ("%d", $row1->rek_stankini ));?></td>
								<td align="right"><?= number_format(sprintf ("%d", $row1->pakai ));?></td>
								<td align="right"><?=number_format(sprintf("%d",$row1->rek_uangair))?></td>
								<td align="right"><?=number_format(sprintf("%d",$beban_tetap  ))?> </td>
								<td align="right"><?=number_format(sprintf("%d",$row1->rek_angsuran))?></td>
								<td align="right"><b><?=number_format(sprintf("%d",$total_rek))?></b></td>
							  </tr>
<?
							$i++;
						}
?>
						<tr class="table_head"> 
							<td colspan="7" align="left">
								<img src="images/kembali2.jpg" onclick="getTabData()"/>
							</td>
							<td align="right"> Grand Total :</td>				
							<td align="right" valign="center">
								<h2><?=number_format(sprintf("%d",$rek_total))?></h2>
							</td>
						</tr>
					</table>
					</form>
				</response>
				</ajax-response>
<?
			}
		}
		else{
?>
			<ajax-response>			
			<response type="element" id="nyangberubah">
			<br/><br/><br/><br/><br/>
			<div align="center">
				<h2>
					<?=$mess ?>
					<?=$back ?>
				</h2>
			</div>
			</response>
			</ajax-response>
<?
		}
	}
	else{
?>
	<h1 style="text-align:center;color:#28156e;">Informasi Pelanggan</h1>
		<div style="text-align:center;">
		<span style="font-size:14px;font-style:italic;">Masukkan nomor SL Anda untuk mendapatkan informasi pelanggan.</span><br /><br />
		<input style="text-align:center;width:330px;padding:6px;font-size:18px;border:1px solid #1A5372;" class="id1" type="text" size="6" maxlength="6">
		<!--<input type="button" name="Submit" value="Cari" class="form_button" onClick="find_data()"/>	</div>-->
		<!-- calculator Slices-->
		<center>
<table style="padding:0; margin-top:20px;border:0 none;border-collapse:collapse;">
	<tr>
		<td style="padding:0px;">
			<img src="images/7.png" width="90" height="90" alt="" onClick="entry_data(7)"></td>
		<td style="padding:0px;">

			<img src="images/8.png" width="85" height="90" alt="" onClick="entry_data(8)"></td>
		<td style="padding:0px;">
			<img src="images/9.png" width="85" height="90" alt="" onClick="entry_data(9)"></td>
		<td style="padding:0px;" rowspan="3">
			<img src="images/enter.png" width="90" height="260" alt="" onClick="find_data()"></td>
	</tr>
	<tr>
		<td style="padding:0px;">
			<img src="images/4.png" width="90" height="86" alt="" onClick="entry_data(4)"></td>

		<td style="padding:0px;">
			<img src="images/5.png" width="85" height="86" alt="" onClick="entry_data(5)"></td>
		<td style="padding:0px;">
			<img src="images/6.png" width="85" height="86" alt="" onClick="entry_data(6)"></td>
	</tr>
	<tr>
		<td style="padding:0px;" style="padding:0;">
			<img src="images/1.png" width="90" height="84" alt="" onClick="entry_data(1)"></td>
		<td style="padding:0px;">

			<img src="images/2.png" width="85" height="84" alt="" onClick="entry_data(2)"></td>
		<td style="padding:0px;">
			<img src="images/3.png" width="85" height="84" alt="" onClick="entry_data(3)"></td>
	</tr>
	<tr>
		<td style="padding:0px;" colspan="2">
			<img src="images/0.png" width="175" height="90" alt="" onClick="entry_data(0)"></td>
		<td style="padding:0px;" colspan="2">
			<img src="images/delete.png" width="175" height="90" alt="" onClick="entry_data('delete')"></td>

	</tr>
</table>

<!-- End Calculator -->
</center>
<?
	}
?>
