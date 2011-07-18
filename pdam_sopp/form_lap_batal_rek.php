<?
	include "lib.php";
	include "modul.inc.php";
	include "model/tulisDB.php";
	cek_pass();

	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	define("_KODE",$appl_kode);
	define("_NAMA",$appl_nama);
	define("_FILE",$appl_file);
	define("_PROC",$appl_proc);
	define("_TOKN",date('ymdHis').getToken());
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="fld" name="targetUrl" value="print_lpp_batal.php">
<table width="500" align="center">
	<tr>
		<td width="40%" class="form_title right">Tanggal</td>
		<td width="60%">:
			<input <?=$sts_wr_key?> class="fld" type="text" name="f1" size="15" maxlength="20" value="<?=$tanggal ?>"> SD
			<input <?=$sts_wr_key?> class="fld" type="text" name="f2" size="15" maxlength="20" value="<?=$tanggal ?>">
		</td>
	</tr>
	<tr> 
		<td></td>
		<td class="left">
			<input type="button" name="Submit" value="Laporan" class="form_button" onClick="cetakin('fld')"/>
		</td>
	</tr>
</form>
