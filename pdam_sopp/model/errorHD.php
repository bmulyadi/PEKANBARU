<?php
	class errorHD{
		function salahDB($pesan){
			$fileLOG	= "./_data/error_db.csv";
			$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKN,_USER,_IP),$pesan);
			$pesan		= implode(";",$pesan)."\n";
			$openLOG	= fopen($fileLOG, 'a');
			fwrite($openLOG, $pesan);
			fclose($openLOG);
			header("Location: ./salah_pesan.php");
		}
		function tulisLOG($fileLOG,$pesan){
			if(_stsLOG){
				$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKN,_USER,_IP),$pesan);
				$pesan		= implode(";",$pesan)."\n";
				$openLOG	= fopen($fileLOG, 'a');
				fwrite($openLOG, $pesan);
				fclose($openLOG);
			}
		}
		function pelLOG($pesan){
			$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKN,_USER,_IP),$pesan);
			$pesan		= implode(";",$pesan)."\n";
			$openLOG	= fopen(_pelLOG, 'a');
			fwrite($openLOG, $pesan);
			fclose($openLOG);
		}
		function rekLOG($pesan){
			$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKN,_USER,_IP),$pesan);
			$pesan		= implode(";",$pesan)."\n";
			$openLOG	= fopen(_rekLOG, 'a');
			fwrite($openLOG, $pesan);
			fclose($openLOG);
		}
	}
?>