<?
	$applVersi		= '0.1';
	$applName 		= 'DB Monitoring';
	$applTitle		= $applName.'-v'.$applVersi;
	$dbHost			= 'billdb01.telkompoint.com';
	$dbUser			= 'root';
	$dbPass			= 'jer#33';
	$dbName			= '';
	$phpSelf		= $_SERVER['PHP_SELF'];
	$bulan			= array('1'=>'Januari','Februari','Maret','April','Mei','Juni',
						'Juli','Agustus','September','Oktober','November','Desember');
	$tanggal		= date('d')." ".$bulan[date('n')]." ".date('Y');
	/* client */
	$ip_client		= $_SERVER['REMOTE_ADDR'];
	/* koneksi database */
	$con		= mysql_connect($dbHost,$dbUser,$dbPass) or die('Cant connect '.$dbHost);
	/*mysql_select_db($dbName);*/
?>