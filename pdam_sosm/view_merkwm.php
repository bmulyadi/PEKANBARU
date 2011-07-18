<?php
	//var_dump($_POST);
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();

	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}

	$link	= new tulisDB();
	switch($_POST["proses"]){
		case "hapus":
			$que = "DELETE FROM tr_merk WHERE mer_kode='$mer_kode'";
			mysql_query($que) or die(salah_db(array(mysql_errno(),mysql_error(),$que),true));
			break;
	}
	$link->tutup();
	
	define("_KODE",$appl_kode);
	define("_NAMA",$appl_nama);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	if(!isset($_POST['appl_token'])){
		$appl_token	= date('ymdHis').getToken();
		define("_TKEN",$appl_token);
		tulisLog("change_log.csv",array(_KODE,0,"buka form pemeliharaan merk meter"),_LOG);
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
	$jml_perpage 	= 7;
	$limit_awal	 	= ($pg - 1) * $jml_perpage;
?>
<input type="hidden" class="next_page pref_page tambah kembali" name="appl_token" 	value="<?=_TKEN?>"/>
<input type="hidden" class="next_page pref_page tambah kembali" name="targetId" 	value="nyangberubah"/>
<input type="hidden" class="next_page pref_page tambah kembali" name="targetUrl" 	value="<?=_FILE?>"/>
<input type="hidden" class="next_page pref_page tambah kembali" name="appl_kode"	value="<?=_KODE?>"/>
<input type="hidden" class="next_page pref_page tambah kembali" name="appl_nama"	value="<?=_NAMA?>"/>
<input type="hidden" class="next_page pref_page tambah kembali" name="appl_file"	value="<?=_FILE?>"/>
<input type="hidden" class="next_page pref_page tambah kembali" name="appl_proc"	value="<?=_PROC?>"/>
<input type="hidden" class="next_page" name="pg" value="<?=$next_page?>"/>
<input type="hidden" class="pref_page" name="pg" value="<?=$pref_page?>"/>
<h2 class="title_form"><?=_NAMA?></h2>
<?php
	$link	= new bacaDB();
	switch($aksi){
		case "edit":
			$que4 	= "SELECT mer_kode,mer_ket FROM tr_merk WHERE mer_kode='$mer_kode'";
			$res4 	= mysql_query($que4) or die(salah_db(array(mysql_errno(),mysql_error(),$que4),true));
			$row4	= mysql_fetch_object($res4);
?>
<input type="hidden" class="simpan" name="aksi" value="edit"/>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="kembali" name="pg" value="<?=$back1?>"/>
<center>
<table style="width:300px">
	<tr>
		<td width="50px">Kode</td>
		<td width="250px">:
			<input type="hidden" class="simpan" name="old_kode" value="<?=$row4->mer_kode?>"/>
			<input type="text" class="simpan" name="mer_kode" value="<?=$row4->mer_kode?>" maxlength="2"/>
		</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:
			<input type="text" class="simpan" name="mer_ket" value="<?=$row4->mer_ket?>"/>
		</td>
	</tr>
	<tr class="table_cont_btm">
		<td id="errId" colspan="2" class="right">
			<input type="button" value="Simpan" onclick="simpan('simpan')"/>
			<input type="button" value="Kembali" onclick="buka('kembali')"/>
		</td>
	</tr>
</table>
<?php
			break;
		case "tambah":
?>
<input type="hidden" class="simpan" name="aksi" value="tambah"/>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="kembali" name="pg" value="<?=$back1?>"/>
<center>
<table style="width:300px">
	<tr>
		<td width="50px">Kode</td>
		<td width="250px">:
			<input type="text" class="simpan" name="mer_kode" maxlength="2"/>
		</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:
			<input type="text" class="simpan" name="mer_ket"/>
		</td>
	</tr>
	<tr class="table_cont_btm">
		<td id="errId" colspan="2" class="right">
			<input type="button" value="Simpan" onclick="simpan('simpan')"/>
			<input type="button" value="Kembali" onclick="buka('kembali')"/>
		</td>
	</tr>
</table>
<?php
			break;
		default:
			$que0 	= "SELECT mer_kode,mer_ket FROM tr_merk ORDER BY mer_kode LIMIT $limit_awal,$jml_perpage";
			$res0 	= mysql_query($que0) or die(salah_db(array(mysql_errno(),mysql_error(),$que0),true));
?>
<center>
<table style="width:500px">
<tr class="table_head">
	<td width="30px">No</td>
	<td width="50px">Kode</td>
	<td>Keterangan</td>
	<td width="50px">Atur</td>
</tr>
<?php
			$j = 0;
			for($i=1;$i<=$jml_perpage;$i++){
				if ($i%2==0){
					$kelas	= "table_cell2";
				}
				else{
					$kelas 	= "table_cell1";
				}
				if($row0 		= mysql_fetch_object($res0)){
					$mer_kode 	= $row0->mer_kode;
					$mer_ket	= $row0->mer_ket;
					$nomer		= ($limit_awal + $i) .".";
					$edit		= "<img src=\"images/edit.gif\"  border=\"0\" title=\"Detail\" onClick=\"buka('edit_$i')\"/>";
					$hapus		= "<img src=\"images/delete.gif\"  border=\"0\" title=\"Detail\" onClick=\"peringatan('hapus_$i')\"/>";
					$j++;
				}
				else{
					$mer_kode 	= null;
					$mer_ket	= null;
					$nomer		= null;
					$edit		= null;
					$hapus		= null;
				}
?>
	<tr class="<?=$kelas?>" style="height:27">
		<td class="right"><?=$nomer?></td>
		<td><?=$mer_kode?></td>
		<td><?=$mer_ket?></td>
		<td>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="targetUrl" 	value="<?=_FILE?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="targetId" 	value="nyangberubah"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_kode"	value="<?=_KODE?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_nama"	value="<?=_NAMA?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_file"	value="<?=_FILE?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_proc"	value="<?=_PROC?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_token" 	value="<?=_TKEN?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="mer_kode" 	value="<?=$mer_kode?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="pesan"	 	value="Hapus informasi wm merk <?=$mer_ket?>"/>
			<input type="hidden" class="edit_<?=$i?>" 	name="back1" 	value="<?=$pg?>"/>
			<input type="hidden" class="edit_<?=$i?>" 	name="aksi" 	value="edit"/>
			<input type="hidden" class="hapus_<?=$i?>" 	name="proses"	value="hapus"/>
			<input type="hidden" class="hapus_<?=$i?>" 	name="pg" 		value="<?=$pg?>"/>
			<?=$edit." ".$hapus?>
		</td>
	</tr>
<?php
			}
			if($j==$jml_perpage){
				$next_mess	= "<input type=\"button\" name=\"Submit\" value=\">>\" class=\"form_button\" onClick=\"buka('next_page')\"/>";
			}
?>
	<tr class="table_cont_btm">
		<td colspan="2">
			<span id="errMess"></span>
			<input type="hidden" class="tambah" name="aksi"	value="tambah"/>
			<input type="hidden" class="tambah" name="back1" value="<?=$pg?>"/>
			<input type="button" class="from_button" value="Tambah" onclick="buka('tambah')"/>
		</td>
		<td colspan="2" class="right"><?=$pref_mess." ".$next_mess?></td>
	</tr>	
</table>
</center>
<?php
	}
	$link->tutup();
?>