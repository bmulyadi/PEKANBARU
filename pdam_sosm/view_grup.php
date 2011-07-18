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

	switch($_POST["proses"]){
		case "hapus":
			$link	= new tulisDB();
			$que0 	= "DELETE FROM tm_group WHERE grup_id='$grup_id'";
			mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
			$link->tutup();
			break;
	}
	
	define("_KODE",$appl_kode);
	define("_NAMA",$appl_nama);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	if(!isset($_POST['appl_token'])){
		$appl_token	= date('ymdHis').getToken();
		define("_TKEN",$appl_token);
		tulisLog("change_log.csv",array(_KODE,0,"buka form grup pengguna"),_LOG);
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
		case "add":
			$que1 = "SELECT appl_kode,appl_file,appl_nama FROM tm_aplikasi WHERE ga_kode='0'";
			$res1 = mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
?>
<b>Pengaturan hak akses untuk grup <?=$grup_nama?></b>
<div>
<?php
			while($row1 = mysql_fetch_object($res1)){
				$appl_kode 	= $row1->appl_kode;
				$appl_nama 	= $row1->appl_nama;
				if(strlen($row1->appl_file)<4){
?>
<input type="hidden" class="buka_<?=$appl_kode?>" name="targetUrl" 	value="<?=_PROC?>"/>
<input type="hidden" class="buka_<?=$appl_kode?>" name="targetId" 	value="kotak_<?=$appl_kode?>"/>
<input type="hidden" class="buka_<?=$appl_kode?>" name="ga_kode"	value="<?=$appl_kode?>"/>
<input type="hidden" class="buka_<?=$appl_kode?>" name="ga_nama"	value="<?=$appl_nama?>"/>
<input type="hidden" class="buka_<?=$appl_kode?>" name="grup_id"	value="<?=$grup_id?>"/>
<input type="hidden" class="buka_<?=$appl_kode?>" name="grup_nama"	value="<?=$grup_nama?>"/>
<input type="hidden" class="buka_<?=$appl_kode?>" name="aksi" 		value="list"/>
<div id="kotak_<?=$appl_kode?>" style="text-align:left;font-weight:bold"/>
	<img src="./images/searchbox.png" onclick="buka('buka_<?=$appl_kode?>')"/>
	<?=$appl_nama?>
</div>
<?php
				}
				else{
?>
	<?=$appl_nama?><br/>
<?php
				}
			}
?>
</div>
<input type="hidden" class="kembali" name="pg" value="<?=$back1?>"/>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="simpan" name="aksi" value="simpan"/>
<span id="errId"></span>
<span style="margin-left:60px">
	<input type="button" value="Kembali" onclick="buka('kembali')"/>
	<input type="button" value="Simpan" onclick="simpan('simpan')"/>
</span>
<?php
			break;
		case "edit":
			$que4 	= "SELECT grup_id,grup_nama FROM tm_group WHERE grup_id='$grup_id'";
			$res4 	= mysql_query($que4) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que4)));
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
			<input type="hidden" class="simpan" name="old_id" value="<?=$row4->grup_id?>"/>
			<input type="text" class="simpan" name="grup_id" value="<?=$row4->grup_id?>" size="25" maxlength="7"/>
		</td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:
			<input type="text" class="simpan" name="grup_nama" value="<?=$row4->grup_nama?>" size="25"/>
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
			<input type="text" class="simpan" name="grup_id" size="25" maxlength="7"/>
		</td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:
			<input type="text" class="simpan" name="grup_nama" size="25"/>
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
			$que0 	= "SELECT grup_id,grup_nama FROM tm_group WHERE grup_id<>'000' ORDER BY grup_id LIMIT $limit_awal,$jml_perpage";
			$res0 	= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
?>
<center>
<table class="table_info" style="width:950px">
	<tr class="table_head">
		<td width="100px">Kode</td>
		<td width="300px">Nama</td>
		<td width="450px">Aplikasi</td>
		<td width="100px">Atur</td>
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
					$grup_id 	= $row0->grup_id;
					$grup_nama	= $row0->grup_nama;
					$edit		= "<img src=\"images/edit.gif\"  border=\"0\" title=\"Detail\" onClick=\"buka('edit_$i')\"/>";
					$hapus		= "<img src=\"images/delete.gif\"  border=\"0\" title=\"Detail\" onClick=\"peringatan('hapus_$i')\"/>";
					$detail		= "<img src=\"images/searchbox.png\" onclick=\"buka('buka_$i')\"/>";
					$appl		= "<img src=\"images/add.gif\" onclick=\"buka('add_appl_$i')\"/>";
					$j++;
				}
				else{
					$grup_id 	= null;
					$grup_nama	= null;
					$edit		= null;
					$hapus		= null;
					$detail		= null;
					$appl		= null;
				}
?>
	<tr class="<?=$kelas?>" style="height:27">
		<td style="vertical-align:top"><?=$grup_id?></td>
		<td style="vertical-align:top"><?=$grup_nama?></td>
		<td>
			<input type="hidden" class="buka_<?=$i?>" name="targetUrl" 	value="edit_grup.php"/>
			<input type="hidden" class="buka_<?=$i?>" name="targetId" 	value="aplikasi_<?=$i?>"/>
			<input type="hidden" class="buka_<?=$i?>" name="grup_id"	value="<?=$grup_id?>"/>
			<input type="hidden" class="buka_<?=$i?>" name="aksi" 		value="detail"/>
			<div id="aplikasi_<?=$i?>" style="text-align:right"/><?=$detail?></div>
		</td>
		<td>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="targetUrl" 	value="<?=_FILE?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="targetId" 	value="nyangberubah"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="appl_kode"	value="<?=_KODE?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="appl_nama"	value="<?=_NAMA?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="appl_file"	value="<?=_FILE?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="appl_proc"	value="<?=_PROC?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="appl_token" 	value="<?=_TKEN?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="grup_id" 		value="<?=$grup_id?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?> hapus_<?=$i?>" 	name="pesan"	 	value="Hapus grup <?=$grup_nama?>"/>
			<input type="hidden" class="add_appl_<?=$i?> edit_<?=$i?>"					name="back1" 		value="<?=$pg?>"/>
			<input type="hidden" class="add_appl_<?=$i?>" 	name="aksi" 		value="add"/>
			<input type="hidden" class="add_appl_<?=$i?>" 	name="grup_nama" 	value="<?=$grup_nama?>"/>
			<input type="hidden" class="edit_<?=$i?>" 		name="aksi" 		value="edit"/>
			<input type="hidden" class="hapus_<?=$i?>" 		name="proses"		value="hapus"/>
			<input type="hidden" class="hapus_<?=$i?>" 		name="pg" 			value="<?=$pg?>"/>
			<?=$appl." ".$edit." ".$hapus?>
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
