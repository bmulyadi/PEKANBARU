<?php
	define("DBW_HOST",$dbHost);
	define("DBW_USER",$dbUser);
	define("DBW_PASS",$dbPass);
	define("DBW_NAME",$dbName);
	define("DBR_HOST",$dbHost);
	define("DBR_USER",$dbUser);
	define("DBR_PASS",$dbPass);
	define("DBR_NAME",$dbName);
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
			return true;
		}
	}
	function konek_tulis_db(){
		$db_link = mysql_connect(DBW_HOST,DBW_USER,DBW_PASS) or die(salah_db(array(mysql_errno(),mysql_error(),DBW_HOST),true));
		mysql_select_db(DBW_NAME,$db_link) or die(salah_db(array(mysql_errno(),mysql_error(),DBW_NAME),true));
		return $db_link;
	}
	function konek_baca_db(){
		$db_link = mysql_connect(DBR_HOST,DBR_USER,DBR_PASS) or die(salah_db(array(mysql_errno(),mysql_error(),DBR_HOST),true));
		mysql_select_db(DBR_NAME,$db_link) or die(salah_db(array(mysql_errno(),mysql_error(),DBR_NAME),true));
		return $db_link;
	}
	function konek_mon_db(){
		$db_link = mysql_connect(DBR_HOST,DBR_USER,DBR_PASS) or die(salah_db(array(mysql_errno(),mysql_error(),DBR_HOST),true));
		return $db_link;
	}
	function tutup_db($db_link){
		mysql_close($db_link);
		return true;
	}
	function getToken(){
		$acak	= mt_rand(1,99999);
		return str_repeat('0',5-strlen($acak)).$acak;
	}
	function tulis_log($file_log,$pesan,$aktif_log){
		$file_log		= _DIRLOG.$file_log;
		if($aktif_log){
			$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKEN,_USER,_IP),$pesan);
			$pesan		= implode(";",$pesan)."\n";
			$open_log	= fopen($file_log, 'a');
			fwrite($open_log, $pesan);
			fclose($open_log);
			return $aktif_log;
		}
		else{
			return $aktif_log;
		}
	}
	function salah_db($pesan,$aktif_log){
		$file_log	= _DIRLOG."error_db.csv";
		$pesan		= array_merge(array(date('Y-m-d H:i:s'),_TOKEN,_USER,_IP),$pesan);
		$pesan		= implode(";",$pesan)."\n";
		$open_log	= fopen($file_log, 'a');
		fwrite($open_log, $pesan);
		fclose($open_log);
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
	
	/* Konversi dari angka ke text */
	function n2c( $nAngkaNumeric ) /* Numeric to Character*/
	{ 
		
		$stringAngka = $nAngkaNumeric; 
		return cMilyar( $stringAngka ); 
	} 

	function cMilyar( $strAngka ) 
	{ 
		$nLenAngka = strlen($strAngka); 
		$nHasil       = floor($nLenAngka / 3); 
		$nSisa     = $nLenAngka - ($nHasil*3); 
		if( $nLenAngka <= 9) return(cJutaan($strAngka)); 
		if( $nSisa == 0 ) $nSisa = 3; 
		$cRetVal = num2char(substr($strAngka, 0, $nSisa), 1, $strAngka); 
		if( $cRetVal == '' ) 
		{ 
			if( substr($strAngka, 0, $nSisa) != '000' ) 
				$cRetVal = $cRetVal.'milyar '; 
		} 
		else 
		{ 
			$cRetVal = $cRetVal.'milyar '; 
		} 
		$cRetVal = $cRetVal.cJutaan(substr($strAngka, strlen($strAngka)-9, 9)); 
		return $cRetVal; 
	} 

	function cJutaan( $strAngka ) 
	{ 
		$nLenAngka = strlen($strAngka); 
		$nHasil       = floor($nLenAngka / 3); 
		$nSisa     = $nLenAngka - ($nHasil*3); 
		if( $nLenAngka <= 6) return(cRibuan($strAngka)); 
		if( $nSisa == 0 ) $nSisa = 3; 
		$cRetVal = num2char(substr($strAngka, 0, $nSisa), 1, $strAngka); 
		if( $cRetVal == '' ) 
		{ 
			if( substr($strAngka, 0, $nSisa) != '000' ) 
				$cRetVal = $cRetVal.'juta '; 
		} 
		else 
		{ 
			$cRetVal = $cRetVal.'juta '; 
		} 
		$cRetVal = $cRetVal.cRibuan(substr($strAngka, strlen($strAngka)-6, 6)); 
		return $cRetVal; 
	} 

	function cRibuan( $strAngka ) 
	{ 
		$nLenAngka = strlen($strAngka); 
		$nHasil       = floor($nLenAngka / 3); 
		$nSisa     = $nLenAngka - ($nHasil*3); 
		if( $nLenAngka <= 3) return(num2char($strAngka, 0, $strAngka)); 
		if( $nSisa == 0 ) $nSisa = 3; 
		$cRetVal = num2char(substr($strAngka, 0, $nSisa), 0, $strAngka); 
		if( $cRetVal == '' ) 
		{ 
			if( substr($strAngka, 0, $nSisa) != '000' ) 
				$cRetVal = $cRetVal.'ribu '; 
		} 
		else 
		{ 
			$cRetVal = $cRetVal.'ribu '; 
		} 

		$cRetVal = $cRetVal.num2char(substr($strAngka, strlen($strAngka)-3, 3), 1, $strAngka); 
		return $cRetVal; 
	} 
	function num2char( $strNumber, $boolJuta, $strAsli ) 
	{ 
		$acKataKata = array("", "se", "dua", "tiga ", "empat ", "lima ", "enam ","tujuh ", "delapan ", "sembilan "); 
		$strString = $strNumber; 
		$iPanjangStr = 0; 
		$strKataRatus = 'z'; 
		if( strlen( $strString ) == 3 ) 
		{ 
			$nAngkaRatus = intval( substr($strString, 0, 1) ); 
			if( $nAngkaRatus == 0){$strRatus = '';} 
			else{$strRatus = 'ratus ';} 
			$strKataRatus = $acKataKata[$nAngkaRatus].$strRatus; 
			$strString = substr($strString, strlen($strString)-2, 2); 
		} 

		$strKataPuluh = 'z'; 
		$iPanjangStr = strlen($strString); 
		if( $iPanjangStr <= 2 ) 
		{ 
			$nAngkaL = intval(substr($strString, 0, 1)); 
			$nAngkaR = intval(substr($strString, strlen($strString)-1, 1)); 

			if( $nAngkaL == 0){$strPuluh = ''; } 
			else{$strPuluh = 'puluh ';} 

			if( $nAngkaL > 0 ) 
			{ 
				if( $iPanjangStr == 2 ) 
				{ 
					if( ($nAngkaL == 1) && ($nAngkaR != 0) ) 
					{ 
						$strKataPuluh = $acKataKata[$nAngkaR].'belas '; 
					} 
					else 
					{ 
						if( $nAngkaR == 1 ){$strTemp = 'satu ';} 
						else{$strTemp = $acKataKata[$nAngkaR];} 
						$strKataPuluh = $acKataKata[$nAngkaL].$strPuluh.$strTemp; 
					} 
				} 
			} 

			if( $strKataPuluh == 'z' ) 
			{ 
				if( $nAngkaR == 1 ) 
				{ 
						if( ($boolJuta == 0) && (strlen($strAsli) > 1) ) 
						{$strTemp = 'se'; } 
						else{$strTemp = 'satu '; } 
				} 
				else { $strTemp = $acKataKata[$nAngkaR]; } 
				$strKataPuluh = $strTemp; 
			} 
		} 		
		if( $strKataRatus != 'z' ){$strRetVal = $strKataRatus;} 
			else{$strRetVal = '';} 
		$strRetVal = $strRetVal.$strKataPuluh; 
		return $strRetVal; 
	} 
	/* End of : Konversi dari angka ke text */
?>
