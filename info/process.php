<?php ob_start(); ?>
<?php
	if($_POST['id1']>0){
		$cont_bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$con=mysql_connect("202.69.105.82","root","pohodeui");
		mysql_select_db("pdam_info",$con);
		
		$f1 = $_POST['id1'];
		$que0 = "SELECT *FROM v_info_pelanggan WHERE pel_no='$f1'";
		$res0 = mysql_query ($que0) or die (mysql_error()." :: ".$que0);
		$row0 = mysql_fetch_object($res0);
		if(isset($_POST['id3'])){
			$rek_jumlah = $_POST['id3'];
			$rek_total = $_POST['id4'];
		}
		else{
			$que2 = "SELECT *FROM v_resume_tunggakan WHERE pel_no='$f1'";
			$res2 = mysql_query ($que2) or die (mysql_error()." :: ".$que2);
			$row2 = mysql_fetch_object($res2);
			$rek_jumlah = $row2->rek_jumlah;
			$rek_total = $row2->rek_total;
		}
		
		$mess = NULL;
		$back = '<br /><a style="position:relative;" onclick="getTabData()"><img src="images/kembali.png" /></a>';
		$sts_nopel = true ;

		if (!$row0->pel_no){
			$mess = "<img src=\"images/nihil.png\" alt=\"Data Pelanggan Tidak Ada\" /><br /><h2 class=\"warning\">Data Pelanggan Tidak Ada</h2>";
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
			$res1 = mysql_query ($que1) or die (mysql_error());
		}
		
		if ($sts_nopel) {
			$grand_tot = 0 ; 
?>
			<ajax-response>			
			<response type="element" id="nyangberubah">
			<input class="id1" type="hidden" value="<?=$row0->pel_no?>">
				<form name="form">
			    <h1>Data Pelanggan</h1>
				<table class="table_info">
					<tr class="table_validator">
						<td width="20%">No. Pelanggan</td>
						<td colspan="3" class="contentsub"> <strong><?=$row0->pel_no?></strong></td>
					</tr>
					<tr class="table_validator">
						<td>Nama</td>
						<td class="contentsub"> <?=$row0->pel_nama?></td>
						<td width="20%">Golongan</td>
						<td class="contentsub"> <?=$row0->gol_kode?></td>
					</tr>
					<tr class="table_validator">
						<td>Alamat</td>
						<td class="contentsub"> <?=$row0->pel_alamat?></td>
						<td>Rayon Pembacaan</td>
						<td class="contentsub"> <?=$row0->dkd_kd?></td>
					</tr>
					<tr class="table_validator">
						<td>Status Pelanggan</td>
						<td class="contentsub"> <b><?=$row0->kps_ket?></b></td>
						<td>Jumlah Rekening</td>
						<td class="contentsub"> <?=(int) $rek_jumlah?></td>
					</tr>
	 			</table>
<?
				if($rek_jumlah==0){
					echo "<div style=\"text-align:center\">";
					echo "<img src=\"images/thx.png\" alt=\"Terima Kasih\" /><br /><h2 class=\"thx\">Terima Kasih Telah Membayar Rekening Tepat Waktu</h2>";
					echo $back;
					echo "</div>";
				}
				else{
?>
					<div style="text-align:right;font-size:14px;padding-right:1px;">
						Halaman
<?
						for($k=1;$k<=$jml_page;$k++){
							if($k == $page){
?>
								<a style="style:color:#fff;font-size:18px;background:#3c3c3c;border:0 none;padding:5px;" onClick="next_page('<?=$k?>','<?=$rek_jumlah?>','<?=$rek_total?>')"><strong><?=$k?></strong></a>
<?
							}
							else{
?>
								<a style="color:#fff;font-size:14px;padding:4px;cursor:pointer;" onClick="next_page('<?=$k?>','<?=$rek_jumlah?>','<?=$rek_total?>')"><?=$k?></a>
<?
							}
						}
?>
					</div>
					<table class="table_info center">
					<tr class="table_validator">
						<td class="center" width="1%" rowspan="2" valign="center">No.</td>
						<td class="center" width="7%" rowspan="2" valign="center">Bulan Tahun</td>
						<td class="center" colspan="3">Stand Meter</td>
						<td class="center" width="20%" colspan="3">Rincian Biaya</td>
						<td class="center" width="10%" rowspan="2" valign="center">Total</td>
					</tr>
					<tr class="table_validator">     	
						<td class="center" width="5%">Lalu</td>
						<td class="center" width="5%">Kini</td>
						<td class="center" width="5%">Pemakaian</td>					    
						<td class="center">Uang Air</td>
						<td class="center">Beban Tetap</td>
						<td class="center">Angsuran</td>
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
								<td class="center"><?=$i+$limitA?></td>
								<td><?=$cont_bulan[$bln_proc]?> <?=$row1->rek_thn?></td>
								<td class="right"><?= number_format(sprintf ("%d", $row1->rek_stanlalu ));?> </td> 
								<td class="right"><?= number_format(sprintf ("%d", $row1->rek_stankini ));?></td>
								<td class="right"><?= number_format(sprintf ("%d", $row1->pakai ));?></td>
								<td class="right"><?=number_format(sprintf("%d",$row1->rek_uangair))?></td>
								<td class="right"><?=number_format(sprintf("%d",$beban_tetap  ))?> </td>
								<td class="right"><?=number_format(sprintf("%d",$row1->rek_angsuran))?></td>
								<td class="right"><b><?=number_format(sprintf("%d",$total_rek))?></b></td>
							  </tr>
<?
							$i++;
						}
?>
						<tr class="table_head"> 
							<td colspan="7" class="left">
								<img src="images/kembali.png" onclick="getTabData()" />
							</td>
							<td class="right"> <strong>Grand Total</strong></td>				
							<td class="right" style="vertical-align:center">
								<span class="grandtotal"><?=number_format(sprintf("%d",$rek_total))?></span>
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
			<div class="center">
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
<div style="text-align:center;margin:0 auto;padding:0">
<h1 class="judul">Informasi Pelanggan</h1>
		<span class="help">Masukkan nomor SL Anda untuk mendapatkan informasi pelanggan.</span><br />
		<input class="id1" type="text" size="6" maxlength="6" />
		<!-- calculator Slices-->
<center>
<table style="width:400px;padding:0; margin-top:10px;border:0 none;border-collapse:collapse;">
	<tr>
		<td style="padding:0px;">
			<img src="images/7.png" style="width:98px;height:99px;" alt="7" onClick="entry_data(7)"></td>
		<td style="padding:0px;">
			<img src="images/8.png" style="width:98px;height:99px;" alt="8" onClick="entry_data(8)"></td>
		<td style="padding:0px;">
			<img src="images/9.png" style="width:98px;height:99px;" alt="9" onClick="entry_data(9)"></td>
			<?php
    include_once 'replacePngTags.php';
    echo replacePngTags(ob_get_clean());
?>
		<td style="padding:0px;" rowspan="3">
			<img src="images/enter.png" style="position:relative;width:98px;height:299px" alt="Enter" onClick="find_data()"></td><?php ob_start(); ?>
	</tr>
	<tr>
		<td style="padding:0px;">
			<img src="images/4.png" style="width:98px;height:99px;" alt="4" onClick="entry_data(4)"></td>
		<td style="padding:0px;">
			<img src="images/5.png" style="width:98px;height:99px;" alt="5" onClick="entry_data(5)"></td>
		<td style="padding:0px;">
			<img src="images/6.png" style="width:98px;height:99px;" alt="6" onClick="entry_data(6)"></td>
	</tr>
	<tr>
		<td style="padding:0px;" style="padding:0;">
			<img src="images/1.png" style="width:98px;height:99px;" alt="1" onClick="entry_data(1)"></td>
		<td style="padding:0px;">
			<img src="images/2.png" style="width:98px;height:99px;" alt="2" onClick="entry_data(2)"></td>
		<td style="padding:0px;">
			<img src="images/3.png" style="width:98px;height:99px;" alt="3" onClick="entry_data(3)"></td>
	</tr>
	<tr>
		<td style="padding:0px;" colspan="2">
			<img src="images/0.png" style="width:198px;height:100px;" alt="0" onClick="entry_data(0)"></td>
		<td style="padding:0px;" colspan="2">
			<img src="images/clear.png" style="width:198px;height:100px;" alt="Clear" onClick="entry_data('delete')"></td>
	</tr>
</table>

<!-- End Calculator -->
</center>
</div>
<?
	}
	usleep(800000);
?>
<?php
    include_once 'replacePngTags.php';
    echo replacePngTags(ob_get_clean());
?>