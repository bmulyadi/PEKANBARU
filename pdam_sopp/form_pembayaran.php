<?php
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
	if(isset($_POST['token'])){
		$token	= $_POST['token'];
		define("_TOKN",$token);
	}
	else{
		$token	= date('ymdHis').getToken();
		define("_TOKN",$token);
	}
	$con0	= new bacaDB();
	$que0	= "SELECT IFNULL(MAX(tr_sts),0) AS tr_sts FROM tr_trans_log WHERE kar_id='"._USER."' AND DATE(tr_tgl)=CURDATE()";
	$res0	= mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
	$row0	= mysql_fetch_object($res0);
	$tr_sts	= $row0->tr_sts;
	if(isset($_SESSION['tgl_denda'])){
		$denda = $_SESSION['tgl_denda'];
	}
	else{
		$que1	= "SELECT sys_value FROM system_parameter WHERE sys_param = 'DENDA'";
		$res1 	= mysql_query($que1) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que1)));
		$row1	= mysql_fetch_object($res1);
		$denda	= $row1->sys_value;
	}
	if(isset($_SESSION['syskey'])){
		$syskey = $_SESSION['syskey'];
	}
	else{
		$syskey = 'A';
	}
	$que2 	= "SELECT CONCAT(syskey,REPEAT(0,6-LENGTH(sysvalue)),sysvalue) AS noResi FROM syskey WHERE user_id='"._USER."' AND syskey='$syskey' LIMIT 1";
	$res2	= mysql_query($que2) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que2)));
	$row2 	= mysql_fetch_object($res2);
	$noResi = $row2->noResi;
	$mess	= false;
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
?>
<h2 class="title_form"><?=_NAMA?></h2>
<input type="hidden" class="bayar" name="targetUrl" 	value="<?=_PROC?>"/>
<input type="hidden" class="bayar" name="targetId"  	value="nyangberubah"/>
<input type="hidden" class="bayar" name="appl_kode" 	value="<?=_KODE?>"/>
<input type="hidden" class="bayar" name="appl_nama" 	value="<?=_NAMA?>"/>
<input type="hidden" class="bayar" name="appl_file" 	value="<?=_FILE?>"/>
<input type="hidden" class="bayar" name="appl_proc" 	value="<?=_PROC?>"/>
<input type="hidden" class="bayar" name="appl" 			value="buka"/>
<input type="hidden" class="bayar" name="cekUrl" 		value="periksa_rekening.php"/>
<input type="hidden" class="bayar resi" name="token" 	value="<?=$token?>"/>
<input type="hidden" class="resi" name="targetUrl" 		value="set_resi.php">
<table style="width:500px">
	<tr> 
		<td width="40%" class="form_title">No. Pelanggan</td>
		<td width="60%">:
			<input class="bayar" type="text" name="pel_no" size="15" maxlength="6" <?=$stsProc?>/>
			<input class="cek" type="hidden" name="pel_no" value="1"/>
			<input class="cek" type="hidden" name="noResi" value="1"/>
			<input class="cek" type="hidden" name="token" value="1"/>
		</td>
	</tr>                   
	<tr> 
		<td width="30%" class="form_title">No. Resi Rekening Terakhir</td>
		<td width="70%">:
			<span id="errId">
				<input type="text" class="bayar resi" name="noResi" size="15" maxlength="7" value="<?=$noResi?>" <?=$stsProc?>/>
				<input type="button" <?=$stsProc?> value="Set Resi" class="form_button"  onClick="simpan('resi')"/>
			</span>
		</td>
	</tr>                   
	<tr> 
		<td width="30%" class="form_title">Tanggal Denda</td>
		<td width="70%">:
			<input readonly type="text" size="15" maxlength="2" class="bayar" name="tgl_denda" value="<?=$denda?>" <?=$stsProc?>/>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
<?php
	if($mess){
		echo "<div id=\"pesan\">$mess</div>";
	}
	else{
		echo "<input $stsProc type=\"button\" value=\"Cek Rekening\" class=\"form_button\" onclick=\"periksa('bayar','cek')\"/>";
	}
?>
		</td>
	</tr>
</table>
