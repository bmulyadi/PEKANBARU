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
<input type="hidden" class="next_page pref_page kembali loncat" name="appl_kode"	value="<?=$appl_kode?>"/>
<input type="hidden" class="next_page pref_page kembali loncat" name="appl_nama"	value="<?=$appl_nama?>"/>
<input type="hidden" class="next_page pref_page kembali loncat" name="appl_file"	value="<?=$appl_file?>"/>
<input type="hidden" class="next_page pref_page kembali loncat" name="appl_proc"	value="<?=$appl_proc?>"/>
<input type="hidden" class="next_page pref_page kembali loncat" name="appl_token" 	value="<?=$appl_token?>"/>
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
			$jml_perpage 	= 10;
			$limit_awal	 	= ($pg - 1) * $jml_perpage;
			$que0 = "SELECT *FROM v_dkd_jml WHERE dkd_kd='$dkd_kd'";
			$que1 = "SELECT *FROM v_siap_sambung WHERE dkd_kd='$dkd_kd'";
			$res0 = mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
			$res1 = mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
			$row0 = mysql_fetch_object($res0);
?>
<input type="hidden" class="next_page pref_page loncat" name="dkd_kd" value="<?=$dkd_kd?>"/>
<input type="hidden" class="next_page pref_page loncat" name="back" value="<?=$back?>"/>
<input type="hidden" class="next_page pref_page loncat" name="proses" value="detail"/>
<input type="hidden" class="sambung" name="targetUrl" value="<?=_PROC?>"/>
<table class="table_info">
	<tr class="table_head">
		<td colspan="3">Rayon DKD :[<?=$dkd_kd?>]-<?=$row0->dkd_jalan?></td> 
		<td>Jml Pelanggan : <?=$row0->jml?></td>
		<td>Tgl Catat : <?=$row0->dkd_tcatat?></td>
		<td>Hal : <?=$pg?></td>
	</tr>
	<tr class="table_validator">
		<td width="15" class="center">No SL</td>
		<td width="200" class="center">NAMA</td>
		<td width="10" class="center">Gol</td>
		<td width="120" class="center">Status Terakhir</td>
		<td width="120" class="center">Sambung Kembali</td>
		<td width="" class="center">Keterangan</td>
	</tr>
<?php
			for($i=0;$i<$jml_perpage;$i++){
				if($row1 = mysql_fetch_object($res1)){
					$pilih 	= "<input id=\"cek_$i\" type=\"checkbox\" onchange=\"pilihan('$i')\"/>";
					$ps_tgl	= $row1->ps_tgl."<br/>[Siap Sambung]";
				}
				else{
					$pilih 	= null;
					$ps_tgl	= null;
				}
				$class_nya 	= "table_cell1";
				if ($i%2== 0){
					$class_nya ="table_cell2";
				}
?>
	<tr class="<?=$class_nya?>">
		<td class="center"><?=$row1->pel_no?></td>
		<td class="left"><?=$row1->pel_nama?></td>
		<td class="center"><?=$row1->gol_kode?></td>
		<td class="center"><?=$ps_tgl?></td>
		<td class="center" height="40">
			<input type="hidden" class="sambung" name="pel_no[<?=$i?>]" value="<?=$row1->pel_no?>"/>
			<input id="pilih_<?=$i?>" type="hidden" class="sambung" name="pilih[<?=$i?>]" value="0"/>
			<?=$pilih?>
		</td>
		<td class="left"><input type="text" class="sambung" name="ps_ket[<?=$i?>]" value="<?=$row1->ps_ket?>" size="50" maxlength="100"/></td>
	</tr>
<?php
			}
?>
	<tr class="table_cont_btm">
		<td colspan="3">
			<input type="hidden" class="kembali" name="pg" value="<?=$back?>"/>
			<input type="button" class="form_button" value="Kembali" onclick="buka('kembali')"/>
			<span id="errId">
				<input type="submit" class="form_button" value="Simpan" onclick="simpan('sambung')"/>
			</span>
		</td>
		<td colspan="1"></td>
		<td colspan="2">
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
			$jml_perpage 	= 19;
			$limit_awal	 	= ($pg - 1) * $jml_perpage;
			$query 			= "SELECT a.*,count(b.pel_no) AS jml_ss FROM tr_dkd a JOIN tm_meter b ON(a.dkd_kd=b.dkd_kd) WHERE a.kp_kode='$kp_kode' AND b.met_sts=8 GROUP BY b.dkd_kd ORDER BY b.dkd_kd ASC LIMIT $limit_awal,$jml_perpage";
			$result 		= mysql_query($query) or die(salah_db(array(mysql_errno(),mysql_error(),$query),true));
			//echo $query;
?>
<table>
	<tr class="table_head"> 
		<td width="10%">Kode</td>
		<td width="7%">No Urut</td>    
		<td width="9%">Tgl Catat</td>        
		<td width="15%">Nama Petugas</td>
		<td width="30%">Jalan</td>
		<td width="15%">Jml Siap Sambung</td>
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
					$aksi = "<img class=\"button\" src=\"images/edit.gif\"  border=\"0\" title=\"Input DSML\" onClick=\"buka('detail_$i')\"/>";
				}
?>
				<tr valign="top" class="<?=$class_nya?>">  
					<td align="center" height="22px"><?=$row1->dkd_kd?></td>
					<td align="center"><?=$row1->dkd_no?></td>
					<td align="center"><?=$row1->dkd_tcatat?></td>
					<td><?=$row1->dkd_nama?></td>
					<td><?=$row1->dkd_jalan?></td>
					<td><?=$row1->jml_ss?></td>
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
		<td colspan="6">&nbsp;</td>
		<td><?=$pref_mess." ".$balik." ".$next_mess?></td>
	</tr>
</table>
<?
	}
	$link->tutup();
?>
<input class="next_page" type="hidden" name="pg" value="<?=($pg+1)?>"/>
<input class="pref_page" type="hidden" name="pg" value="<?=($pg-1)?>"/>