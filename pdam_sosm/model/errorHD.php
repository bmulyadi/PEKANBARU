<?php
	class errorHD{
		function salahDB($pesan){
			$fileLOG	= "./_data/error_db.csv";
			$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKEN,_USER,_IP),$pesan);
			$pesan		= implode(";",$pesan)."\n";
			$openLOG	= fopen($fileLOG, 'a');
			fwrite($openLOG, $pesan);
			fclose($openLOG);
			header("Location: ./salah_pesan.php");
		}
	}
?>