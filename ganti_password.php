<?php
	session_start();
	require 'default.php';
	if(isset($_POST['id']) AND isset($_SESSION['User_c'])){
		$kar_id		= $_SESSION['User_c'];
		$passOld	= $_POST['passOld'];
		$passNew	= $_POST['passNew'];
		$passRev	= $_POST['passRev'];
		$que 		= "SELECT kar_pass FROM tm_karyawan WHERE kar_id='$kar_id'";
		$con 		= mysql_connect($dbHost,$dbUser,$dbPass) or die(salah_db($file_name,$pesan.",terhubung ke ".$dbHost.",".mysql_error().",0"));
		mysql_select_db($dbName);
		$res = mysql_query($que);
		$row = mysql_fetch_object($res);
		if($row->kar_pass==md5($passOld)){
			if($passNew==$passRev AND $passNew!=NULL){
				$newPass 	= md5($passNew);
				$mess 		= "<h3>Ganti password berhasil</h3>";
				mysql_query("UPDATE tm_karyawan SET kar_pass='$newPass' WHERE kar_id='$kar_id'");
			}
			else{
				$mess = "<h3>Password baru tidak sesuai</h3>";
			}
		}
		else{
			$mess = "<h3>Password lama salah</h3>";
		}
	}
	mysql_close($con);
?>
<div id="kotak0">
	<h3><?=$mess?></h3>
	<div id="kotak1">
		<input type="hidden" class="params" name="id" value="103"/>
		<input type="hidden" class="params" name="file" value="ganti_password.php"/>
		Password Lama<br/>
		Password Baru<br/>
		Ulangi Password Baru<br/>
	</div>
	<div id="kotak2">
		: <input type="password" class="params" name="passOld"/><br/>
		: <input type="password" class="params" name="passNew"/><br/>
		: <input type="password" class="params" name="passRev"/><br/>
		<input class="tombol" type="button" value="Ganti" onClick="buka()"/>
		<input class="tombol" type="button" value="Tutup" onClick="tutup('kotak0')"/>
	</div>
</div>