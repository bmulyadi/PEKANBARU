<?php
	//var_dump($_POST);
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	$kp_kode	= 10;

	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	
	define("_KODE",$appl_kode);
	define("_NAMA",$appl_nama);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	if(!isset($_POST['appl_token'])){
		$appl_token	= date('ymdHis').getToken();
		define("_TKEN",$appl_token);
		tulisLog("change_log.csv",array(_KODE,0,"buka form data pelanggan"),_LOG);
	}
	else{
		define("_TKEN",$appl_token);
	}
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
?>
<input type="hidden" class="next_page pref_page kembali simpan" name="appl_token" 	value="<?=_TKEN?>"/>
<input type="hidden" class="next_page pref_page kembali simpan" name="targetId" 	value="nyangberubah"/>
<input type="hidden" class="next_page pref_page kembali" 		name="targetUrl" 	value="<?=_FILE?>"/>
<input type="hidden" class="next_page pref_page kembali" 		name="appl_kode"	value="<?=_KODE?>"/>
<input type="hidden" class="next_page pref_page kembali" 		name="appl_nama"	value="<?=_NAMA?>"/>
<input type="hidden" class="next_page pref_page kembali" 		name="appl_file"	value="<?=_FILE?>"/>
<input type="hidden" class="next_page pref_page kembali" 		name="appl_proc"	value="<?=_PROC?>"/>
<input type="hidden" class="next_page" name="pg" value="<?=$next_page?>"/>
<input type="hidden" class="pref_page" name="pg" value="<?=$pref_page?>"/>
<h2 class="title_form"><?=_NAMA?></h2>
<?php
	$link	= new bacaDB();
	$form	= false;
	switch($_POST["aksi"]){
		case "proses":
			/** koneksi database */
			$que	= "SELECT *FROM v_data_pelanggan WHERE pel_no='$pel_no'";
			$res	= mysql_query($que) or die(salah_db(array(mysql_errno(),mysql_error(),$que),true));
			$row	= mysql_fetch_object($res);
?>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="kembali" name="aksi" 	value="detail"/>
<input type="hidden" class="kembali" name="dkd_kd" 	value="<?=$row->dkd_kd?>"/>
<input type="hidden" class="kembali" name="back1"	value="<?=$back1?>"/>
<input type="hidden" class="kembali" name="pg" 		value="<?=$back2?>"/>
<table width='100%'>
	<tr class="table_head"> 				  				    
		<td colspan="2" align ="center" width="50%"><b>Data Pelanggan</b></td>
		<td colspan="2" align="center"><b>Update</b></td>
	</tr>
	<tr valign="top" class="table_cell1">
		<td width="25%" >No. Pelanggan</td><td>: <?=$row->pel_no?></td>
		<td width="25%" >No. Pelanggan</td><td>: <?=$row->pel_no?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >No. Water Meter</td><td>: <?=$row->pel_nowm?></td>
		<td width="25%" >No. Water Meter</td><td>: <?=$row->pel_nowm?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Kota Pelayanan</td><td>: <?=$row->kp_ket?></td>
		<td width="25%" >Kota Pelayanan</td><td>: <?=$row->kp_ket?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Nama Pelanggan</td><td>: <?=$row->pel_nama?></td>
		<td width="25%" >Nama Pelanggan</td><td>: <?=$row->pel_nama?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Alamat</td><td>: <?=$row->pel_alamat?></td>
		<td width="25%" >Alamat</td><td>: <input style="font-size: 8pt" type="text" name='pel_alamat' class='simpan' value='<?=$row->pel_alamat?>'></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Kelurahan</td><td>: <?=$row->pel_kel?></td>
		<td width="25%" >Kelurahan</td><td>: <input style="font-size: 8pt" type="text" name='pel_kel' class='simpan' value='<?=$row->pel_kel?>'></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Kecamatan</td><td>: <?=$row->pel_kec?></td>
		<td width="25%" >Kecamatan</td><td>: <input style="font-size: 8pt" type="text" name='pel_kec' class='simpan' value='<?=$row->pel_kec?>'></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Kota</td><td>: <?=$row->pel_kota?></td>
		<td width="25%" >Kota</td><td>: <input style="font-size: 8pt" type="text" name='pel_kota' class='simpan' value='<?=$row->pel_kota?>'></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Telp</td><td>: <?=$row->pel_telp?></td>
		<td width="25%" >Telp</td><td>: <input style="font-size: 8pt" type="text" name='pel_telp' class='simpan' value='<?=$row->pel_telp?>'></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >HP</td><td>: <?=$row->pel_hp?></td>
		<td width="25%" >HP</td><td>: <input style="font-size: 8pt" type="text" name='pel_hp' class='simpan' value='<?=$row->pel_hp?>'></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Tgl. Pasang</td><td>: <?=$row->pel_psg?></td>
		<td width="25%" >Tgl. Pasang</td><td>: <?=$row->pel_psg?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Tgl. Aktif</td><td>: <?=$row->pel_aktif?></td>
		<td width="25%" >Tgl. Aktif</td><td>: <?=$row->pel_aktif?></td>
	</tr>
	<tr height="30px" class="table_cell1">
		<td width="25%" >Kode Golongan</td><td>: <?=$row->gol_kode?></td>
		<td width="25%" >Kode Golongan</td><td>: <?=$row->gol_kode?></td>
	</tr>
	<tr height="30px" class="table_cell2">
		<td width="25%" >Kode Rayon</td><td>: <?=$row->dkd_kd?></td>
		<td width="25%" >Kode Rayon</td><td>: <?=$row->dkd_kd?></td>
	</tr>
	<tr class="table_cont_btm">
		<td colspan="2"></td>
		<td colspan="2">
			<span id="errId">
				<input type="submit" class="form_button" value="Simpan" onclick="simpan('simpan')"/>
				<input type="button" class="form_button" value="Batal" onclick="buka('kembali')"/>
			</span>
		</td>
	</tr>
</table>
<?php
			break;
		case "detail":
			$form	= true;
?>
			<input type="hidden" class="kembali" name="pg" value="<?=$back1?>"/>
<?php
			$balik	= "<input type=\"button\" name=\"Submit\" value=\"Kembali\" class=\"form_button\" onClick=\"buka('kembali')\"/>";
			$titel	= array("No","No SL","Nama","Gol","Status","Alamat","Detail");
			$lebar	= array("5%","5%","20%","5%","15%","45%","5%");
			$posisi	= array("right","right","left","right","left","left","center");
			$nomer	= count($titel);
			$que0	= "SELECT *FROM v_data_pelanggan WHERE dkd_kd='$dkd_kd' ORDER BY met_sts DESC,pel_no LIMIT $limit_awal,$jml_perpage";
			$res0 	= mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
			while($row0 = mysql_fetch_object($res0)){
				$limit_awal++;
				$dkd_kd	= $row0->dkd_kd;
				$pel_no	= $row0->pel_no;
?>
				<input type="hidden" class="<?=$pel_no?>" name="targetUrl" 	value="<?=_FILE?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="targetId" 	value="nyangberubah"/>
				<input type="hidden" class="<?=$pel_no?>" name="appl_kode"	value="<?=_KODE?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="appl_nama"	value="<?=_NAMA?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="appl_file"	value="<?=_FILE?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="appl_proc"	value="<?=_PROC?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="appl_token" value="<?=_TKEN?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="aksi" 		value="proses"/>
				<input type="hidden" class="<?=$pel_no?>" name="back1" 		value="<?=$back1?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="back2" 		value="<?=$pg?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="dkd_kd" 	value="<?=$dkd_kd?>"/>
				<input type="hidden" class="<?=$pel_no?>" name="pel_no" 	value="<?=$pel_no?>"/>
<?php
				$atur	= "<img src=\"images/edit.gif\"  border=\"0\" title=\"Edit\" onClick=\"buka('$pel_no')\"/>";
				$isi[] 	= array($limit_awal,$pel_no,$row0->pel_nama,$row0->gol_kode,$row0->kps_ket,$row0->pel_alamat,$atur);
				$mess	= "Rayon $dkd_kd";
			}
?>
<input type="hidden" class="next_page pref_page" name="aksi" value="detail"/>
<input type="hidden" class="next_page pref_page" name="dkd_kd" value="<?=$dkd_kd?>"/>
<input type="hidden" class="next_page pref_page" name="back1" value="<?=$back1?>"/>
<?php
			break;
		default:
			$form	= true;
			$titel	= array("No","Rayon","Pembaca","Jalan","Detail");
			$lebar	= array("5%","15%","20%","55%","5%");
			$posisi	= array("right","right","left","left","center");
			$nomer	= count($titel);
			$que0 	= "SELECT dkd_kd,dkd_pembaca,dkd_jalan FROM tr_dkd WHERE kp_kode='$kp_kode' ORDER BY dkd_kd LIMIT $limit_awal,$jml_perpage";
			$res0 	= mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
			while($row0 = mysql_fetch_object($res0)){
				$limit_awal++;
?>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="targetUrl" 	value="<?=_FILE?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="targetId" 	value="nyangberubah"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="appl_kode"	value="<?=_KODE?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="appl_nama"	value="<?=_NAMA?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="appl_file"	value="<?=_FILE?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="appl_proc"	value="<?=_PROC?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="appl_token" 	value="<?=_TKEN?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="aksi" 		value="detail"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="dkd_kd" 		value="<?=$row0->dkd_kd?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="back1" 		value="<?=$pg?>"/>
				<input type="hidden" class="<?=$row0->dkd_kd?>" name="cekUrl" 		value="periksa_rayon.php"/>
<?php
				$atur	= "<img src=\"images/edit.gif\"  border=\"0\" title=\"Detail\" onClick=\"periksa('$row0->dkd_kd','periksa')\"/>";
				$isi[] 	= array($limit_awal,$row0->dkd_kd,$row0->dkd_pembaca,$row0->dkd_jalan,$atur);
			}
?>
			<input type="hidden" class="periksa" name="dkd_kd" value="1"/>
			<span id="errId"></span>
<?php
	}
	if($form){
?>
<table width="100%" align="center">
<?php
	if(count($isi)>0){
		echo "<tr class=\"table_head\">";
		for($i=0;$i<$nomer;$i++){
			echo "<td width=\"$lebar[$i]\">$titel[$i]</td>";
		}
		echo "</tr>";
	}
	for($j=0;$j<count($isi);$j++){
		$class_nya 	= "table_cell1";
		if ($j%2==0){
			$class_nya ="table_cell2";
		}
		echo "<tr class=\"$class_nya\">";
		for($k=0;$k<$nomer;$k++){
			echo "<td align=\"$posisi[$k]\">".$isi[$j][$k]."</td>";
		}
		echo "</tr>";
	}
	if($j>($jml_perpage-1)){
		$next_mess	= "<input type=\"button\" name=\"Submit\" value=\">>\" class=\"form_button\" onClick=\"buka('next_page')\"/>";
	}
?>
	<tr class="table_cont_btm">
		<td colspan="3"></td>
		<td class="right" colspan="<?=($nomer-3)?>" align="right"><?=$pref_mess." ".$balik." ".$next_mess?></td>
	</tr>	
</table>
<?php
	}
	$link->tutup();
?>