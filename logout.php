<?	
	require "default.php";
	require "modul.inc.php";
	session_start();
	$l_name		= $_SESSION['User_c'];
	$db_link	= konek_tulis_db();
	$que1		= "INSERT INTO user_login(ip,user_id,sts) VALUES('$ipClient','$l_name',2)";
	mysql_query($que1) or die(salah_db(array(mysql_errno(),mysql_error(),$que1),true));
	tutup_db($db_link);
	session_destroy();
	header("Location: ./");
?>
