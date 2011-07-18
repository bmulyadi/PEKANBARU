<?php
	$pel_no		= $_POST['pel_no'];
	if(strlen($pel_no)==6){
		require "model/tulisDB.php";
		$link 	= new bacaDB();
		$que	= "SELECT *FROM v_data_pelanggan WHERE pel_no='$pel_no'";
		$res	= mysql_query($que) or die(salah_db(array(mysql_errno(),mysql_error(),$que),true));
		if(mysql_num_rows($res)==1)
			$errorMess = false;
		else
			$errorMess = "SL <b>$pel_no</b> tidak ditemukan";
	}
	else{
		$errorMess	= "SL <b>$pel_no</b> tidak valid";
	}
?>
<input id="errMess" type="hidden" value="<?=$errorMess?>"/>