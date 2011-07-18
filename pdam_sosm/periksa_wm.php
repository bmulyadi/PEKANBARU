<?php
	$pel_no		= $_POST['pel_no'];
	if(strlen($pel_no)==6){
		require "model/tulisDB.php";
		$link 	= new bacaDB();
		$que	= "SELECT a.pel_no,ABS(IFNULL(b.pel_no,0)) AS sts_dsml FROM tm_pelanggan a LEFT JOIN v_dsml_berjalan b ON(a.pel_no=b.pel_no) WHERE a.pel_no='$pel_no'";
		$res	= mysql_query($que) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$que)));
		$row	= mysql_fetch_object($res);
		if(mysql_num_rows($res)==1 && $row->sts_dsml==0){
			$errorMess = false;
		}
		else if(mysql_num_rows($res)==1)
			$errorMess = "SL <b>$pel_no</b> tidak bisa ganti WM";
		else
			$errorMess = "SL <b>$pel_no</b> tidak ditemukan";
	}
	else{
		$errorMess	= "SL <b>$pel_no</b> tidak valid";
	}
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>