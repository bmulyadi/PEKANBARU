<?php
	include 'default.php';
	include '../modul.inc.php';
	$con	= konek_mon_db();
	$que 	= 'SHOW FULL PROCESSLIST';
	$res 	= mysql_query($que);
	$i		= 0;
	while($row 	= mysql_fetch_assoc($res)){
		$key = array_keys($row);
		for($j=0;$j<count($key);$j++){
			$data[$row['Id']][$key[$j]] = $row[$key[$j]];
			$id[$row['Id']]				= $row['Command'];
		}
		$i++;
	}
	asort($id);
	$idKey = array_keys($id);
	echo '<table>';
	for($k=0;$k<count($idKey);$k++){
		echo '<tr><td>'.$data[$idKey[$k]]['Host'].'</td><td width=150>'.$data[$idKey[$k]]['User'].'</td><td width=77>'.$data[$idKey[$k]]['Id'].'</td><td width=100>'.$data[$idKey[$k]]['State'].'</td><td width=50>'.$data[$idKey[$k]]['db'].'</td><td width=50>'.$data[$idKey[$k]]['Time'].'</td><td width=1000>'.$data[$idKey[$k]]['Info'].'</td><td>'.$data[$idKey[$k]]['Id'].'</td></tr>';
	}
	echo '</table>';
	mysql_close($con);
?>