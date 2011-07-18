<?php
	define("_IP",$_SERVER['REMOTE_ADDR']);
	define("_LOG",true);
	define("_DIRLOG","./_data/");
	function cek_pass(){
		session_start();
		if(!isset($_SESSION["User_c"])){
			header("Location: ../");
		}
		else{
			define("_USER",$_SESSION["User_c"]);
			define("_NAME",$_SESSION["Name_c"]);
			define("_GRUP",$_SESSION["Group_c"]);
			define("_stsLOG",$_SESSION['aktif_log']);
			return true;
		}
	}
	function getToken(){
		$acak	= mt_rand(1,99999);
		return str_repeat('0',5-strlen($acak)).$acak;
	}
	function tulisLog($fileLog,$pesan,$aktifLog){
		$fileLog		= _DIRLOG.$fileLog;
		if($aktifLog){
			$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKEN,_USER,_IP),$pesan);
			$pesan		= implode(";",$pesan)."\n";
			$openLog	= fopen($fileLog, 'a');
			fwrite($openLog, $pesan);
			fclose($openLog);
			return $aktifLog;
		}
		else{
			return $aktifLog;
		}
	}
	function salah_db($pesan,$aktifLog){
		$fileLog	= _DIRLOG."error_db.csv";
		$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKEN,_USER,_IP),$pesan);
		$pesan		= implode(";",$pesan)."\n";
		$openLog	= fopen($fileLog, 'a');
		fwrite($openLog, $pesan);
		fclose($openLog);
		header("Location: ./salah_pesan.php");
	}
	function open_csv($file_name){
		$handle	= fopen($file_name, "r");
		while(($data = fgetcsv($handle,7,"\N")) !== FALSE){
			$list[] = $data[0];
		}
		fclose($handle);
		return $list;
	}
	function tulis_csv($list,$file_name){
		$fp = fopen($file_name,"w");
		foreach ($list as $line) {
			fputcsv($fp, split("\n", $line));
		}
		fclose($fp);
	}
	function sub_select($kode,$nilai,$param){
		$hasil 		= "<select name='".$param["nama"]."' ".$param["status"]." class='".$param["kelas"]."'>";
		for($i=0;$i<count($kode);$i++){
			if($kode[$i]==$param["pilihan"]){
				$sts_select = "selected";
			}
			else{
				$sts_select	= "";
			}
			$hasil .= "<option value='".$kode[$i]."' ".$sts_select.">".$nilai[$i]."</option>";
		}	
		$hasil .= "</select>";
		return($hasil);
	}
?>