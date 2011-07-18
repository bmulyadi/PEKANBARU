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

	$con0	= new bacaDB();
	$que0	= "SELECT IFNULL(MAX(tr_sts),0) AS tr_sts FROM tr_trans_log WHERE kar_id='"._USER."' AND DATE(tr_tgl)=CURDATE()";
	$res0	= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
	$row0	= mysql_fetch_object($res0);
	$tr_sts	= $row0->tr_sts;
	
	switch($tr_sts){
		case "0":
			$stsProc 	= "disabled";
			$mess 		= "Loket belum dibuka";
			break;
		case "2":
			$stsProc	= "disabled";
			$mess		= "Loket sudah ditutup";
			break;
	}

	$con0->tutup();
	/* pilihan bulan */
	for($i=0;$i<=12;$i++){
		$kode2[$i] 	= $i;
		$nilai2[$i]	= $bulan[$i];
	}
	$param2 = array("kelas"=>"batal","nama"=>"rek_bln","pilihan"=>date('m'),"status"=>"style=\"font-size: 9pt\" $stsProc");
?>
<h2 class="title_form"><?=_NAMA?></h2>
<span id="errId"></span>
<input type="hidden" class="batal" name="targetUrl" value="<?=_PROC?>"/>
<input type="hidden" class="batal" name="targetId"  value="nyangberubah"/>
<input type="hidden" class="batal" name="appl_kode" value="<?=_KODE?>"/>
<input type="hidden" class="batal" name="appl_nama" value="<?=_NAMA?>"/>
<input type="hidden" class="batal" name="appl_file" value="<?=_FILE?>"/>
<input type="hidden" class="batal" name="appl_proc" value="<?=_PROC?>"/>
<input type="hidden" class="batal" name="token" 	value="<?=_TOKN?>"/>
<input type="hidden" class="batal" name="cekUrl" 	value="periksa_pembayaran.php"/>
<table>
<tr valign="top" > 
	<td width="30%" class="form_title">No. Pelanggan</td>
	<td width="70%">:
		<input type="text" class="batal" name="pel_no" size="15" maxlength="6" <?=$stsProc?>/>
		<input type="hidden" class="cek" name="pel_no" value="1"/>
		<input type="hidden" class="cek" name="appl_kode" value="1"/>
		<input type="hidden" class="cek" name="rek_bln" value="1"/>
		<input type="hidden" class="cek" name="rek_thn" value="1"/>
	</td>
</tr>
<tr> 
	<td width="30%" class="form_title">Bulan - Tahun</td>
	<td width="70%">:
		<?=sub_select($kode2,$nilai2,$param2)?> - <input type="text" class="batal" name="rek_thn" size="4" maxlength="4" value="<?=date('Y')?>" <?=$stsProc?>/>
	</td>
</tr>
<tr>
	<td></td>
	<td class="spacer_tb left">
<?php
	if($mess){
		echo "<div id=\"pesan\">$mess</div>";
	}
	else{
		echo "<input $stsProc type=\"button\" value=\"Cek Rekening\" class=\"form_button\" onclick=\"periksa('batal','cek')\"/>";
	}
?>
	</td>
</tr>
</table>
