<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	define("_TOKN",$token);
	
	include "modul.inc.php";
	include "model/tulisDB.php";
	cek_pass();
	$stsLog		= $_SESSION['aktif_log'];
	$token		= new tulisDB();
	$syskey 	= strtoupper(substr($_POST['noResi'],0,1));
	$sysvalue	= substr($_POST['noResi'],1,6);
	$que0	 	= "INSERT INTO syskey(syskey,sysvalue,user_id) VALUES('$syskey','$sysvalue','"._USER."') ON DUPLICATE KEY UPDATE sysvalue='$sysvalue'";
	mysql_query($que0) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que0)));
	$noResi				= $syskey.str_repeat(0,6-strlen($sysvalue)).$sysvalue;
	$_SESSION['syskey']	= $syskey;
	if(mysql_affected_rows()>0){
		$mess = "Perubahan informasi resi telah disimpan";
	}
	else{
		$mess = "Tidak ada perubahan informasi resi";
	}
	//errorHD::tulisLOG(array($noResi,$mess),$stsLog);
	echo "<input type=\"hidden\" id=\"errMess\" value=\"$mess\"/>";
	echo "<input type=\"text\" class=\"bayar resi\" name=\"noResi\" size=\"15\" maxlength=\"7\" value=\"$noResi\"/>";
	echo "&nbsp;<input type=\"button\" class=\"form_button\" value=\"Set Resi\" onClick=\"simpan('resi')\"/>";
	$token->tutup();
?>