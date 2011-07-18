<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LAPORAN PENERIMAAN PENAGIHAN (LPP)</title>
</head>

<body>
<?php
	require "lib.php";
	require "modul.inc.php";
	require "model/tulisDB.php";
	cek_pass();
	$db_link 	= new bacaDB();
	$f1 		= $_GET['f1'];
	$f2 		= $_GET['f2'];
	$f6			= _USER;
	$sql		= "SELECT getName('$f6') AS kar_nama";
	$que		= mysql_query($sql) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$sql)));
	$row		= mysql_fetch_object($que);
	$kar_nama	= $row->kar_nama;
	$sql		= "SELECT IFNULL(b.kar_nama,'PT POS') AS kar_id,a.byr_tgl,a.kp_kode,
	getberjalan(a.byr_tgl,a.rek_bln,a.rek_thn) AS berjalan,
	a.kp_nama,a.rek_bln,a.rek_thn,a.bulan,a.byr_loket,a.pel_no ,a.pel_nama,a.rek_gol,
	a.rek_uangair ,a.rek_adm,a.rek_meter,a.rek_angsuran,a.rek_total,a.rek_denda,a.rek_materai,
	a.rek_byr_sts FROM sopp_lpp a LEFT JOIN tm_karyawan b ON (a.kar_id=b.kar_id)
	WHERE a.byr_tgl>=STR_TO_DATE('$f1','%d-%m-%Y') AND a.byr_tgl<=STR_TO_DATE('$f2','%d-%m-%Y') and a.kp_kode LIKE '%$f4%' and a.kar_id='$f6'
	ORDER BY a.kp_nama,a.byr_tgl,getberjalan(a.byr_tgl,a.rek_bln,a.rek_thn),a.rek_thn,a.rek_bln,a.pel_no";
	$que	= mysql_query($sql) or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),$sql)));
?>
<center>
	<b>
		LAPORAN PENERIMAAN PENAGIHAN (LPP)
		<br/>(RINCI PER PELAKSANA PENERIMA KAS)
	</b>
</center>
<br/>			
<font size = "2">Periode	: <?echo "$f1 SD $f2"?></font><br/>
<font size = "2">Penerima	: <?=strtoupper($kar_nama)?></font><br/>
<font size = "2"><?=strtoupper($f5)?></font><br/>
 	<table width="100%" bgcolor="black" border="0" cellpadding="1" cellspacing="1"> 
		<tr border="1">
			<th width="" bgcolor="#c0c0c0"><font size="2">KP</font></th>
		    <th width="" bgcolor="#c0c0c0"><font size="2">Bln/Thn</font></th>
		    <th width="" bgcolor="#c0c0c0"><font size="2">Loket</font></th>
			<th width="" bgcolor="#c0c0c0"><font size="2">No SL</font></th>
		    <th width="" bgcolor="#c0c0c0"><font size="2">Nama</font></th>
			<th width="" bgcolor="#c0c0c0"><font size="2">Gol</font></th>
		    <th width="" bgcolor="#c0c0c0"><font size="2">Uang Air</font></th>
		    <th width="" bgcolor="#c0c0c0"><font size="2">ADM</font></th>
		    <th width="" bgcolor="#c0c0c0"><font size="2">Meter</font></th>		
			<th width="" bgcolor="#c0c0c0"><font size="2">Angsuran</font></th>		
			<th width="" bgcolor="#c0c0c0"><font size="2">Nilai Rek</font></th>	
			<th width="" bgcolor="#c0c0c0"><font size="2">Denda</font></th>
			<th width="" bgcolor="#c0c0c0"><font size="2">Materai</font></th>	
			<th width="" bgcolor="#c0c0c0">Total</font></th>	
			<th width="" bgcolor="#c0c0c0"><font size="2">Ket</font></th>
		</tr>
<?
	if(mysql_num_rows($que)>0){
		$bulan = array("Sampai dengan bulan lalu","Bulan berjalan");
		while ($row = mysql_fetch_array($que)){
			$data[$row['kp_nama']][$row['byr_tgl']][$row['berjalan']][$row['rek_thn']][$row['rek_bln']][$row['pel_no']] = $row;
		}
		$kp_nama_key = array_keys($data);
		/* order by kp_nama */
		for($i=0;$i<count($data);$i++){
			$byr_tgl_val = $data[$kp_nama_key[$i]];
			$byr_tgl_key = array_keys($byr_tgl_val);
			/* order by byr_tgl */
			for($j=0;$j<count($byr_tgl_key);$j++){
				echo "<td colspan ='15' bgcolor='#ccFFcc' align='left'><font size='2'><b>Tanggal : ".$byr_tgl_key[$j]."</b></font></td>";
				$berjalan_val = $byr_tgl_val[$byr_tgl_key[$j]];
				$berjalan_key = array_keys($berjalan_val);
				/* order by berjalan */
				for($k=0;$k<count($berjalan_key);$k++){
					echo "<tr><td colspan='15' bgcolor='white'><font size='2'>".$bulan[$berjalan_key[$k]]."</font></td></tr>";
					$rek_thn_val = $berjalan_val[$berjalan_key[$k]];
					$rek_thn_key = array_keys($rek_thn_val);
					for($l=0;$l<count($rek_thn_key);$l++){
						$rek_bln_val = $rek_thn_val[$rek_thn_key[$l]];
						$rek_bln_key = array_keys($rek_bln_val);
						for($m=0;$m<count($rek_bln_key);$m++){
							$pel_no_val = $rek_bln_val[$rek_bln_key[$m]];
							$pel_no_key = array_keys($pel_no_val);
							for($n=0;$n<count($pel_no_key);$n++){
								$row0	= $pel_no_val[$pel_no_key[$n]];
								$total_akhir=$row0['rek_denda']+$row0['rek_total']+$row0['rek_materai'];
								$baris=$baris+1;
								$total_sep=$total_sep + $total_akhir;
								$uangair_tot[]	= $row0['rek_uangair'];
								$uangair_rek_kpl[]	= $row0['rek_uangair'];
								$uangair_rek_har[]	= $row0['rek_uangair'];
								$uangair_rek_bln[]	= $row0['rek_uangair'];
								
								$adm_tot[]	= $row0['rek_adm'];
								$adm_rek_kpl[]	= $row0['rek_adm'];
								$adm_rek_har[]	= $row0['rek_adm'];
								$adm_rek_bln[]	= $row0['rek_adm'];
								
								$meter_tot[]	= $row0['rek_meter'];
								$meter_rek_kpl[]	= $row0['rek_meter'];
								$meter_rek_har[]	= $row0['rek_meter'];
								$meter_rek_bln[]	= $row0['rek_meter'];
								
								$angsuran_tot[]	= $row0['rek_angsuran'];
								$angsuran_rek_kpl[]	= $row0['rek_angsuran'];
								$angsuran_rek_har[]	= $row0['rek_angsuran'];
								$angsuran_rek_bln[]	= $row0['rek_angsuran'];
								
								$total_tot[]	= $row0['rek_total'];
								$total_rek_kpl[]	= $row0['rek_total'];
								$total_rek_har[]	= $row0['rek_total'];
								$total_rek_bln[]	= $row0['rek_total'];
								
								$denda_tot[]		= $row0['rek_denda'];
								$denda_rek_kpl[]	= $row0['rek_denda'];
								$denda_rek_har[]	= $row0['rek_denda'];
								$denda_rek_bln[]	= $row0['rek_denda'];

								$materai_tot[]		= $row0['rek_materai'];
								$materai_rek_kpl[]	= $row0['rek_materai'];
								$materai_rek_har[]	= $row0['rek_materai'];
								$materai_rek_bln[]	= $row0['rek_materai'];
								
								
?>								<tr>
									<td bgcolor="white" align="center"><font size='2'><?=$row0['kp_nama']?></td>
									<td bgcolor="white" align="center"><font size='2'><?=$row0['bulan']?></td>
									<td bgcolor="white" align="center"><font size='2'><?=$row0['byr_loket']?></td>
									<td bgcolor="white" align="left"><font size='2'><?=$row0['pel_no']?></td>
									<td bgcolor="white" align="left"><font size='2'><?=$row0['pel_nama']?></td>
									<td bgcolor="white" align="center"><font size='2'><?=$row0['rek_gol']?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$row0['rek_uangair']))?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$row0['rek_adm']))?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$row0['rek_meter']))?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$row0['rek_angsuran']))?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$row0['rek_total']))?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$row0['rek_denda']))?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$row0['rek_materai']))?></td>
									<td bgcolor="white" align="right"><font size='2'><?=number_format(sprintf("%d",$total_akhir))?></td>
									<td bgcolor="white"></td>
								</tr>
<?							
							}
						}
					}
					$baris_hr=$baris_hr+$baris;
					$total_hr=$total_hr + $total_sep;
?>					<tr>
						<td bgcolor="#c0c0c0"></td>
						<td bgcolor="#c0c0c0"></td>
						<td bgcolor="#c0c0c0"></td>
						<td bgcolor="#c0c0c0" align="center"><font size='2'><?=number_format(sprintf("%d",$baris))?></td>
						<td bgcolor="#c0c0c0"></td>
						<td bgcolor="#c0c0c0"></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",array_sum($uangair_rek_bln)))?></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",array_sum($adm_rek_bln)))?></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",array_sum($meter_rek_bln)))?></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",array_sum($angsuran_rek_bln)))?></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",array_sum($total_rek_bln)))?></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",array_sum($denda_rek_bln)))?></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",array_sum($materai_rek_bln)))?></td>
						<td bgcolor="#c0c0c0" align="right"><font size='2'><?=number_format(sprintf("%d",$total_sep))?></td>
						<td bgcolor="#c0c0c0"></td>
					</tr>
<?
					$baris=null;
					$total_sep=null;
					$jml_rek_bln = null;
					$uangair_rek_bln=null;
					$adm_rek_bln=null;
					$meter_rek_bln=null;
					$angsuran_rek_bln=null;
					$total_rek_bln=null;
					$denda_rek_bln=null;
					$materai_rek_bln=null;
				}
				$total_kpl=$total_kpl+$total_hr;
				$baris_kpl=$baris_kpl+$baris_hr;
?>				<tr>
					<td colspan ="3" bgcolor="#c0c0c0"><font size='2'><b>Total Per Tanggal</b></font></td>
					<td bgcolor="#c0c0c0" align="center"><font size='2'><b><?=number_format(sprintf("%d",$baris_hr))?></td>
					<td bgcolor="#c0c0c0"></td>
					<td bgcolor="#c0c0c0"></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($uangair_rek_har)))?></b></font></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($adm_rek_har)))?></b></font></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($meter_rek_har)))?></b></font></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($angsuran_rek_har)))?></b></font></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($total_rek_har)))?></b></font></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($denda_rek_har)))?></b></font></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($materai_rek_har)))?></b></font></td>
					<td bgcolor="#c0c0c0" align="right"><font size='2'><b><?=number_format(sprintf("%d",$total_hr))?></b></font></td>
					<td bgcolor="#c0c0c0"></td>
				</tr>
<?
				$baris_hr=null;
				$total_hr=null;
				$jml_rek_har = null;
				$uangair_rek_har=null;
				$adm_rek_har=null;
				$meter_rek_har=null;
				$angsuran_rek_har=null;
				$denda_rek_har=null;
				$materai_rek_har=null;
				$total_rek_har=null;

			}
			$total_seluruh=$total_kpl+$total_seluruh;
			$baris_seluruh=$baris_kpl+$baris_seluruh;
			
?>			<tr>
				<td colspan ="3" bgcolor='#CC66FF'><font size='2'><b><?echo "Total Kopel : $row0[kp_nama]"?></font></td>
				<td bgcolor="#CC66FF" align="center"><font size='2'><b><?=number_format(sprintf("%d",$baris_kpl))?></td>
				<td bgcolor="#CC66FF"></td>
				<td bgcolor="#CC66FF"></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($uangair_rek_kpl)))?></font></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($adm_rek_kpl)))?></font></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($meter_rek_kpl)))?></font></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($angsuran_rek_kpl)))?></font></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($total_rek_kpl)))?></font></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($denda_rek_kpl)))?></font></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($materai_rek_kpl)))?></font></td>
				<td bgcolor="#CC66FF" align="right"><font size='2'><b><?=number_format(sprintf("%d",$total_kpl))?></b></font></td>
				<td bgcolor="#CC66FF"></td>
			</tr>
<?
			$baris_kpl=null;
			$total_kpl=null;
			$jml_rek_kpl = NULL;
			$uangair_rek_kpl=null;
			$adm_rek_kpl=null;
			$meter_rek_kpl=null;
			$angsuran_rek_kpl=null;
			$denda_rek_kpl=null;
			$materai_rek_kpl=null;
			$total_rek_kpl=null;
		}
?>
		<tr>
			<td colspan="3" bgcolor="#FFFF99"><font size='2'><b>GRANDTOTAL</b></font></td>
			<td bgcolor="#FFFF99" align="center"><font size='2'><b><?=number_format(sprintf("%d",$baris_seluruh))?></td>
			<td bgcolor="#FFFF99"></td>
			<td bgcolor="#FFFF99"></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($uangair_tot)))?></b></font></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($adm_tot)))?></b></font></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($meter_tot)))?></b></font></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($angsuran_tot)))?></b></font></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($total_tot)))?></b></font></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($denda_tot)))?></b></font></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",array_sum($materai_tot)))?></b></font></td>
			<td bgcolor="#FFFF99" align="right"><font size='2'><b><?=number_format(sprintf("%d",$total_seluruh))?></b></font></td>
			<td bgcolor="#FFFF99"></td>
		</tr>
<?
		$baris_seluruh=null;
		$total_seluruh=null;
		$jml_rek_tot = NULL;
		$uangair_rek_tot=null;
		$adm_rek_tot=null;
		$meter_rek_tot=null;
		$angsuran_rek_tot=null;
		$denda_rek_tot=null;
		$materai_rek_tot=null;
		$total_rek_tot=null;
	}
	$db_link->tutup();
?>
	</table>
<script>
	window.print();
</script>
</body>
</html>