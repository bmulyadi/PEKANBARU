<?php
	//var_dump($_POST);
	require "modul.inc.php";
	cek_pass();
	$kp_kode	= 10;
	$appl_token	= date('ymdHis').getToken();
	/** kode1 yang akan memindahkan semua nilai dalam array POST ke dalam */
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
	define("_TOKEN",$appl_token);
	/** koneksi database */
	require "model/tulisDB.php";
	$link 	= new bacaDB();
?>
<span id="proses"></span>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="next_page pref_page kembali simpan loncat" name="appl_kode"	value="<?=$appl_kode?>"/>
<input type="hidden" class="next_page pref_page kembali simpan loncat" name="appl_nama"	value="<?=$appl_nama?>"/>
<input type="hidden" class="next_page pref_page kembali simpan loncat" name="appl_file"	value="<?=$appl_file?>"/>
<input type="hidden" class="next_page pref_page kembali simpan loncat" name="appl_proc"	value="<?=$appl_proc?>"/>
<input type="hidden" class="next_page pref_page kembali simpan loncat" name="appl_token" 	value="<?=$appl_token?>"/>
<input type="hidden" class="next_page pref_page kembali loncat" name="targetUrl" 	value="<?=_FILE?>"/>
<input type="hidden" class="next_page pref_page kembali loncat" name="targetId" 	value="nyangberubah"/>
<?php
	switch ($proses){
		case "detail":
			if(isset($_POST['pg']) and $_POST['pg']>1){
				$next_page 	= $pg + 1;
				$pref_page 	= $pg - 1;
				$pref_mess	= "<input type=\"button\" name=\"Submit\" value=\"<<\" class=\"form_button\" onClick=\"buka('pref_page')\"/>";
				
			}
			else{
				$pg 		= 1;
				$next_page 	= 2;
				$pref_page 	= 1;
			}
			$jml_perpage 	= 25;
			$limit_awal	 	= ($pg - 1) * $jml_perpage;
			$que0 = "select *from v_dkd_jml where dkd_kd='$dkd_kd'";
			$res0 = mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
			$row0 = mysql_fetch_object($res0);
?>
<input type="hidden" class="next_page pref_page loncat" name="dkd_kd" value="<?=$dkd_kd?>"/>
<input type="hidden" class="next_page pref_page loncat" name="back" value="<?=$back?>"/>
<input type="hidden" class="next_page pref_page loncat" name="proses" value="detail"/>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="simpan" name="targetId" value="proses"/>
<?
			$que1 = "SELECT *FROM v_tab54 WHERE dkd_kd='$dkd_kd' ORDER BY pel_no LIMIT $limit_awal,$jml_perpage";
			$res1 = mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
			$que2 = "SELECT kwm_kd,UPPER(kwm_ket) FROM tr_kondisi_wm ORDER BY kwm_kd";
			$res2 = mysql_query($que2) or die(salah_db(array(mysql_errno(),mysql_error(),$query),true));
			while($row2 = mysql_fetch_row($res2)){
				$kode2[] 	= $row2[0];
				$nilai2[]	= $row2[1];
			}
			$que3 = "SELECT kl_kd,UPPER(kl_ket) FROM tr_kondisi_lingkungan ORDER BY kl_kd";
			$res3 = mysql_query($que3) or die(salah_db(array(mysql_errno(),mysql_error(),$query),true));
			while($row3 = mysql_fetch_row($res3)){
				$kode3[] 	= $row3[0];
				$nilai3[]	= $row3[1];
			}
?>
<table class="table_info">
	<tr class="table_head">
		<td colspan="8">Rayon DKD :[<?=$dkd_kd?>]-<?=$row0->dkd_jalan?></td> 
		<td colspan="2">Jml Pelanggan : <?=$row0->jml?></td>
		<td>Tgl Catat : <?=$row0->dkd_tcatat?></td>
		<td>Hal : <?=$pg?></td>
	</tr>
	<tr class="table_validator">
		<td width="10" rowspan="2">No.</td>
		<td width="15" rowspan="2" width="60">No. SL</td>	
		<td width="200" rowspan="2">Nama</td>
		<td width="300" rowspan="2">Alamat</td>
		<td colspan="5" class="center">Stand Meter</td>
		<td colspan="2" class="center">Kode Abnormal</td>
		<td width="50" rowspan="2" class="center">Ket</td>
	</tr>
	<tr class="table_validator">
		<td width="70" class="center">Lalu</td>
		<td width="70" class="center">WMMR</td>
		<td width="70" class="center">Kini</td>
		<td width="70" class="center">Pakai Lalu</td>
		<td width="70" class="center">Pakai Kini</td>
		<td width="120" class="center">WM</td>
		<td width="120" class="center">Lingkungan</td>
	</tr>		
<?php
			$j = 0;
			for($i=0;$i<$jml_perpage;$i++){
			//while ($row1 = mysql_fetch_object($res1)){
				$class_nya 	= "table_cell1";
				if ($i%2== 0){
					$class_nya ="table_cell2";
				}
				if($row1 = mysql_fetch_object($res1)){
					$nomer		= $i+1+($pg-1)*$jml_perpage.".";
					$pilihan	= 0;
					$ubah		= 0;
					$status 	= "disabled";
					if($row1->sm_dsml){
						$sm_kini 	= $row1->sm_dsml;
						$kwm_kd 	= $row1->kwm_dsml;
						$kl_kd 		= $row1->kl_dsml;
					}
					else if($row1->sm_wmmr){
						$sm_kini	= $row1->sm_wmmr;
						$kwm_kd 	= $row1->kwm_wmmr;
						$kl_kd 		= $row1->kl_wmmr;
						$status 	= "checked=\"TRUE\"";
						$pilihan	= 1;
						$ubah		= 1;
					}
					if($sm_kini){
						$pakai_kini = $sm_kini-$row1->sm_lalu;
						if($pakai_kini>=50){
							$ket = ">= 50";
						}
						else if($pakai_kini<0){
							$ket = "Negatif";
						}
						else if($pakai_kini<=10){
							$ket = "<= 10";
						}
						else{
							$ket = "";
						}
					}
					else{
						$ket 	= "Belum diisi";
						$ubah	= 0;
					}
					$param2 	= array("kelas"=>"simpan","nama"=>"kwm_kd[$i]","pilihan"=>$kwm_kd,"status"=>"id=\"kwm_kd_$i\" onchange=\"setMan($i)\" style=\"font-size: 9pt\"");
					$param3 	= array("kelas"=>"simpan","nama"=>"kl_kd[$i]","pilihan"=>$kl_kd,"status"=>"id=\"kl_kd_$i\" onchange=\"setMan($i)\" style=\"font-size: 9pt\"");
					$j++;
?>
	<tr class="<?=$class_nya?>" >
		<td align="right" height="40"><?=$nomer?></td>
		<td>
			<?=$row1->pel_no?>
		</td>
		<td>
			<?=$row1->pel_nama?>
		</td>
		<td>
			<?=$row1->pel_alamat?>
		</td>
		<td style="text-align:right">
			<?=$row1->sm_lalu?>
		</td>
		<td style="text-align:right">
			<?=$row1->sm_wmmr?>
			<input id="sm_lalu_<?=$i?>" type="hidden" class="wmmr_<?=$i?>" name="sm_lalu" value="<?=$row1->sm_lalu?>"/>
			<input type="hidden" class="wmmr_<?=$i?>" name="sm_kini" value="<?=$row1->sm_wmmr?>"/>
			<input type="hidden" class="wmmr_<?=$i?>" name="kwm_kd" value="<?=$row1->kwm_wmmr?>"/>
			<input type="hidden" class="wmmr_<?=$i?>" name="kl_kd" value="<?=$row1->kl_wmmr?>"/>
			<input id="pilihan_<?=$i?>" type="hidden" class="simpan" name="pilihan[<?=$i?>]" value="<?=$pilihan?>"/>
			<input id="cek_<?=$i?>" type="checkbox" <?=$status?> onChange="pilihWmmr('<?=$i?>')" style="vertical-align:middle"/>
		</td>
		<td style="text-align:right">
			<input type="hidden" class="simpan" name="pel_no[<?=$i?>]" value="<?=$row1->pel_no?>"/>
			<input type="hidden" class="simpan" name="sm_lalu[<?=$i?>]" value="<?=$row1->sm_lalu?>"/>
			<input id="ubah_<?=$i?>" type="hidden" class="simpan" name="ubah[<?=$i?>]" value="<?=$ubah?>"/>
			<input id="sm_kini_<?=$i?>" type="text" class="simpan" name="sm_kini[<?=$i?>]" size="4" style="font-size: 9pt" value="<?=$sm_kini?>" onChange="pilihDsml('<?=$i?>')"/>
		</td>
		<td style="text-align:right"><?=$row1->pakai_lalu?></td>
		<td align="center"><span id="pakai_kini_<?=$i?>"><?=$pakai_kini?></span></td>
		<td align="center" width="180"><?=sub_select($kode2,$nilai2,$param2)?></td>
		<td align="center" width="180"><?=sub_select($kode3,$nilai3,$param3)?></td>
		<td>
			<span id="ket_<?=$i?>"><?=$ket?></span>
		</td>
	</tr>
<?
				$sm_kini	= NULL;
				$pakai_kini	= NULL;
				$kwm_kd 	= NULL;
				$kl_kd 		= NULL;
				$status 	= NULL;
				$ket 		= NULL;
				}
				else{
					$nomer = null;
?>
	<tr class="<?=$class_nya?>" >
		<td align="right" height="40">&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		<td style="text-align:right"></td>
		<td style="text-align:right"></td>
		<td style="text-align:right"></td>
		<td style="text-align:right"><?=$row1->pakai_lalu?></td>
		<td align="center"></td>
		<td align="center" width="180"></td>
		<td align="center" width="180"></td>
		<td></td>
	</tr>
<?
				}
			}
			if($j>($jml_perpage-1)){
				$next_mess	= "<input type=\"button\" name=\"Submit\" value=\">>\" class=\"form_button\" onClick=\"buka('next_page')\"/>";
			}
?>	
	<tr class="table_cont_btm">
		<td colspan="6">
			<input type="hidden" class="kembali" name="pg" value="<?=$back?>"/>
			<input type="button" class="form_button" value="Kembali" onclick="buka('kembali')"/>
			<span id="errId">
				<input type="submit" class="form_button" value="Simpan" onclick="simpan('simpan')"/>
			</span>
		</td>
		<td colspan="3"></td>
		<td colspan="3">
			<?=$pref_mess?>
			<input type="text" size="4" class="loncat" name="pg" value="<?=$pg?>" style="text-align:right;font-size:9pt"/>
			<input type="submit" class="form_button" value="Loncat" onclick="buka('loncat')"/>
			<?=$next_mess?>
		</td>
	</tr>
</table>
<?
			break;
		default:
			if(isset($_POST['pg']) and $_POST['pg']>1){
				$next_page 	= $pg + 1;
				$pref_page 	= $pg - 1;
				$pref_mess	= "<input type=\"button\" name=\"Submit\" value=\"<<\" class=\"form_button\" onClick=\"buka('pref_page')\"/>";
				
			}
			else{
				$pg 		= 1;
				$next_page 	= 2;
				$pref_page 	= 1;
			}
			$jml_perpage 	= 20;
			$limit_awal	 	= ($pg - 1) * $jml_perpage;
			$query 			= "SELECT * FROM tr_dkd where kp_kode = '$kp_kode' ORDER BY dkd_kd ASC LIMIT $limit_awal,$jml_perpage";
			$result 		= mysql_query($query) or die(salah_db(array(mysql_errno(),mysql_error(),$query),true));
?>
<span id="errId"></span>
<input type="hidden" class="cek" name="dkd_kd" value="1"/>
<table>
	<tr class="table_head"> 
		<td width="10%">Kode</td>
		<td width="7%">No Urut</td>    
		<td width="9%">Tgl Catat</td>        
		<td width="20%">Nama Petugas</td>
		<td width="40%">Jalan</td>
		<td width="15%">Manage</td>
	</tr>  
<?php
			$j=1;
			for($i=0;$i<$jml_perpage;$i++){
				$row1 		= mysql_fetch_object($result);
				$class_nya 	= "table_cell1" ;
				if($i%2==0){
					$class_nya ="table_cell2";
				}
				if($row1->dkd_kd){
					$j++;
					$aksi = "<img class=\"button\" src=\"images/edit.gif\"  border=\"0\" title=\"Input DSML\" onClick=\"periksa('detail_$i','cek')\"/>";
				}
?>
				<tr valign="top" class="<?=$class_nya?>">  
					<td align="center" height="22px"><?=$row1->dkd_kd?></td>
					<td align="center"><?=$row1->dkd_no?></td>
					<td align="center"><?=$row1->dkd_tcatat?></td>
					<td><?=$row1->dkd_nama?></td>
					<td><?=$row1->dkd_jalan?></td>
					<td align="center">
						<?=$aksi?>
						<input class="detail_<?=$i?>" type="hidden" name="targetUrl" 	value="<?=_FILE?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="targetId" 	value="nyangberubah"/>
						<input class="detail_<?=$i?>" type="hidden" name="proses" 		value="detail"/>
						<input class="detail_<?=$i?>" type="hidden" name="dkd_kd" 		value="<?=$row1->dkd_kd?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="appl_kode"	value="<?=$appl_kode?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="appl_nama"	value="<?=$appl_nama?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="appl_file"	value="<?=$appl_file?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="appl_proc"	value="<?=$appl_proc?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="appl_token" 	value="<?=$appl_token?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="back"		 	value="<?=$pg?>"/>
						<input class="detail_<?=$i?>" type="hidden" name="cekUrl"	 	value="periksa_rayon.php"/>
					</td>
				</tr>
<?php
				$row1	= null;
				$aksi	= null;
			}
			if($j>($jml_perpage-1)){
				$next_mess	= "<input type=\"button\" name=\"Submit\" value=\">>\" class=\"form_button\" onClick=\"buka('next_page')\"/>";
			}
?>	
	<tr class="table_cont_btm">
		<td colspan="5"></td>
		<td><?=$pref_mess." ".$balik." ".$next_mess?></td>
	</tr>
</table>
<?
	}
	$link->tutup();
?>
<input class="next_page" type="hidden" name="pg" value="<?=($pg+1)?>"/>
<input class="pref_page" type="hidden" name="pg" value="<?=($pg-1)?>"/>