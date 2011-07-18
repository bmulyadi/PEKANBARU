<?
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
	$que1	= "SELECT sys_value FROM system_parameter WHERE sys_param = 'DENDA'";
	$res0	= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
	$res1	= mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
	$row0	= mysql_fetch_object($res0);
	$row1	= mysql_fetch_object($res1);
	$mess	= false;
	switch($row0->tr_sts){
		case "1":
			$stsLoket 	= "disabled";
			$mess 		= "Loket sudah dibuka";
			break;
		case "2":
			$stsLoket	= "disabled";
			$mess		= "Loket sudah ditutup";
			break;
	}
	$con0->tutup();
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="buka" name="targetUrl" value="<?=_PROC?>"/>
<table>
	<tr valign="top"> 
		<td colspan="2">
			<p style="padding:6px; font-size:14px;">
				Anda login sebagai <b><?=_NAME?></b><br/>
				Akses dari IP <?=_IP?>
			</p>
			<hr/>
		</td>
	</tr>
	<tr valign="top"> 
		<td width="30%" class="form_title">Tanggal Hari Ini</td>
		<td width="70%">:
			<input readonly type="text" name="tanggal" size="15" value="<?=date('d-m-Y')?>" <?=$stsLoket?>/>
		</td>
	</tr>
	<tr> 
		<td width="30%" class="form_title">Tanggal Denda</td>
		<td width="70%">:
			<input type="text" class="buka" name="denda" size="15" value="<?=$row1->sys_value?>" maxlength="2" <?=$stsLoket?>/>
		</td>
	</tr>            
	<tr>
		<td></td>
		<td id="errId" align="center" class="spacer_tb">
<?php
	if($mess){
		echo "<div id=\"pesan\">$mess</div>";
	}
	else{
		echo "<input $stsLoket type=\"button\" value=\"Proses\" class=\"form_button\" onclick=\"simpan('buka')\"/>";
	}
?>
		</td>
	</tr>
</table>