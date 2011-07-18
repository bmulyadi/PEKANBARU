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
			$que 	= "DELETE FROM tm_karyawan WHERE kar_id='$kar_id'";
			mysql_query($que) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que)));
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
		tulisLog("change_log.csv",array(_KODE,0,"buka form daftar pengguna"),_LOG);
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
			$que4 	= "SELECT *FROM v_daftar_pengguna WHERE kar_id='$kar_id'";
			$res4 	= mysql_query($que4) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que4)));
			$row4	= mysql_fetch_object($res4);
			$que2 	= "SELECT kp_kode,kp_ket FROM tr_kota_pelayanan ORDER BY kp_kode";
			$res2 	= mysql_query($que2) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que2)));
			while($row2 = mysql_fetch_row($res2)){
				$kode2[] 	= $row2[0];
				$nilai2[] 	= $row2[1];
			}
			$param2 = array("kelas"=>"simpan","nama"=>"kp_kode","pilihan"=>$row4->kp_kode,"status"=>"style=\"font-size: 9pt\""); 
			$que3 	= "SELECT grup_id,grup_nama FROM tm_group ORDER BY grup_id";
			$res3 	= mysql_query($que3) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que3)));
			while($row3 = mysql_fetch_row($res3)){
				$kode3[] 	= $row3[0];
				$nilai3[] 	= $row3[1];
			}
			$param3 = array("kelas"=>"simpan","nama"=>"grup_id","pilihan"=>$row4->grup_id,"status"=>"style=\"font-size: 9pt\""); 
?>
<input type="hidden" class="simpan" name="aksi" value="edit"/>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="kembali" name="pg" value="<?=$back1?>"/>
<center>
<table style="width:450px">
	<tr>
		<td width="150px">ID</td>
		<td width="300px">:
			<input type="hidden" class="simpan" name="old_id" value="<?=$row4->kar_id?>"/>
			<input type="text" class="simpan" name="kar_id" value="<?=$row4->kar_id?>" size="30" maxlength="8"/>
		</td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:
			<input type="text" class="simpan" name="kar_nama" value="<?=$row4->kar_nama?>" size="30"/>
		</td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td>: <input type="text" class="simpan" name="kar_jabatan" value="<?=$row4->kar_jabatan?>" size="30"/></td>
	</tr>
	<tr>
		<td>Kota Pelayanan</td>
		<td>: <?=sub_select($kode2,$nilai2,$param2)?></td>
	</tr>
	<tr>
		<td>Grup</td>
		<td>: <?=sub_select($kode3,$nilai3,$param3)?></td>
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
			$que2 	= "SELECT kp_kode,kp_ket FROM tr_kota_pelayanan ORDER BY kp_kode";
			$res2 	= mysql_query($que2) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que2)));
			while($row2 = mysql_fetch_row($res2)){
				$kode2[] 	= $row2[0];
				$nilai2[] 	= $row2[1];
			}
			$param2 = array("kelas"=>"simpan","nama"=>"kp_kode","pilihan"=>$row4->kp_kode,"status"=>"style=\"font-size: 9pt\""); 
			$que3 	= "SELECT grup_id,grup_nama FROM tm_group ORDER BY grup_id";
			$res3 	= mysql_query($que3) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que3)));
			while($row3 = mysql_fetch_row($res3)){
				$kode3[] 	= $row3[0];
				$nilai3[] 	= $row3[1];
			}
			$param3 = array("kelas"=>"simpan","nama"=>"grup_id","pilihan"=>$row4->grup_id,"status"=>"style=\"font-size: 9pt\""); 
?>
<input type="hidden" class="simpan" name="aksi" value="tambah"/>
<input type="hidden" class="simpan" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="kembali" name="pg" value="<?=$back1?>"/>
<center>
<table style="width:450px">
	<tr>
		<td width="150px">ID</td>
		<td width="300px">:
			<input type="text" class="simpan" name="kar_id" size="30" maxlength="8"/>
		</td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:
			<input type="text" class="simpan" name="kar_nama" size="30"/>
		</td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td>: <input type="text" class="simpan" name="kar_jabatan" size="30"/></td>
	</tr>
	<tr>
		<td>Kota Pelayanan</td>
		<td>: <?=sub_select($kode2,$nilai2,$param2)?></td>
	</tr>
	<tr>
		<td>Grup</td>
		<td>: <?=sub_select($kode3,$nilai3,$param3)?></td>
	</tr>
	<tr class="table_cont_btm">
		<td id="errId" colspan="2" class="right">
			<input type="button" value="Simpan" onclick="simpan('simpan')"/>
			<input type="button" value="Kembali" onclick="buka('kembali')"/>
		</td>
	</tr>
</table>
</center>
<?php
			break;
		default:
			$que0 	= "SELECT *FROM v_daftar_pengguna LIMIT $limit_awal,$jml_perpage";
			$res0 	= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
?>
<center>
<table class="table_info">
<tr class="table_head">
	<td width="70px" class="center">ID</td>
	<td width="200px" class="center">Nama</td>
	<td width="200px" class="center">Jabatan</td>
	<td width="100px" class="center">Kota Pelayanan</td>
	<td class="center">Grup</td>
	<td width="50px" class="center">Atur</td>
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
					$kar_id 	= $row0->kar_id;
					$kar_nama	= $row0->kar_nama;
					$nomer		= ($limit_awal + $i) .".";
					$edit		= "<img src=\"images/edit.gif\"  border=\"0\" title=\"Detail\" onClick=\"buka('edit_$i')\"/>";
					$hapus		= "<img src=\"images/delete.gif\"  border=\"0\" title=\"Delete\" onClick=\"peringatan('hapus_$i')\"/>";
					$reset		= "<img src=\"images/icon-refresh.png\"  border=\"0\" title=\"Reset\" onClick=\"simpan('reset_$i')\"/>";
					$j++;
				}
				else{
					$kar_id 	= null;
					$kar_nama	= null;
					$nomer		= null;
					$edit		= null;
					$hapus		= null;
					$reset		= null;
				}
?>
	<tr class="<?=$kelas?>" style="height:27">
		<td class="right"><?=$kar_id?></td>
		<td><?=$kar_nama?></td>
		<td><?=$row0->kar_jabatan?></td>
		<td><?=$row0->kp_ket?></td>
		<td><?=$row0->grup_nama?></td>
		<td>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="targetUrl" 	value="<?=_FILE?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="targetId" 	value="nyangberubah"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_kode"	value="<?=_KODE?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_nama"	value="<?=_NAMA?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_file"	value="<?=_FILE?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_proc"	value="<?=_PROC?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="appl_token" 	value="<?=_TKEN?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="kar_id" 		value="<?=$kar_id?>"/>
			<input type="hidden" class="edit_<?=$i?> hapus_<?=$i?>" name="pesan"	 	value="Hapus informasi <?=$kar_nama?>"/>
			<input type="hidden" class="edit_<?=$i?>" 				name="back1" 		value="<?=$pg?>"/>
			<input type="hidden" class="edit_<?=$i?>" 				name="aksi" 		value="edit"/>
			<input type="hidden" class="hapus_<?=$i?>" 				name="proses"		value="hapus"/>
			<input type="hidden" class="hapus_<?=$i?>" 				name="pg" 		value="<?=$pg?>"/>
			<input type="hidden" class="reset_<?=$i?>" 				name="targetUrl" 	value="<?=_PROC?>"/>
			<input type="hidden" class="reset_<?=$i?>" 				name="targetId" 	value="0"/>
			<input type="hidden" class="reset_<?=$i?>" 				name="aksi" 		value="reset"/>
			<?=$edit." ".$reset." ".$hapus?>
		</td>
	</tr>
<?php
			}
			if($j==$jml_perpage){
				$next_mess	= "<input type=\"button\" name=\"Submit\" value=\">>\" class=\"form_button\" onClick=\"buka('next_page')\"/>";
			}
?>
	<tr class="table_cont_btm">
		<td colspan="4">
			<span id="errId"></span>
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
