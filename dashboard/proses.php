<?	require "../default.php";	require "../modul.inc.php";	$db_link	= konek_baca_db();
	switch($_GET['isi']){
		case 'kiri':
			$que0 	= "CALL set_dsml(@sts)";			$que6	= "CALL set_drd(@sts)";
			$que1 	= "SELECT @sts AS _sts";			mysql_query($que6);			$res1 = mysql_query($que1);			$row1 = mysql_fetch_object($res1);			if($row1->_sts==0){				$que3	= "SELECT *FROM tmp_pendapatan";				$que4	= "SELECT *FROM tmp_drd";			}			else{				$que3	= "SELECT *FROM ds_pendapatan";				$que4	= "SELECT *FROM ds_drd";			}
			mysql_query($que0);
			$res1 = mysql_query($que1);
			$row1 = mysql_fetch_object($res1);
			if($row1->_sts==0){				$que5	= "SELECT *FROM tmp_dsml";
			}			else{				$que5	= "SELECT *FROM ds_dsml";			}			$res3 = mysql_query($que3);			$res4 = mysql_query($que4);			$res5 = mysql_query($que5);			$rek_total_efek	= array(0);			while($row3=mysql_fetch_object($res3)){				if($row3->rek_bulan==1){					$rek_total_efes = $row3->rek_total;				}				$rek_total_efek[]	= $row3->rek_total;			}			$rek_total_efek	= array_sum($rek_total_efek);			$row4 			= mysql_fetch_object($res4);			$drd_lembar		= $row4->drd_lmbr;			$drd_uang		= $row4->drd_uang;			$efek			= 100*($rek_total_efek/$drd_uang);			$efes			= 100*($rek_total_efes/$drd_uang);			$row5			= mysql_fetch_object($res5);			$pel_jml		= $row5->pel_jml;			$sm_pakai		= $row5->sm_pakai;			$uangair		= $row5->uangair;			$dsml_jml		= $row5->dsml_jml;?><table>	<tr>		<th>DRD (Lembar/Rupiah)</th>		<th>Efesiensi (Persen/Rupiah)</th>		<th>Efektivitas (Persen/Rupiah)</th>	</tr>	<tr>		<td><?=number_format($drd_lembar,0,'.',',')?><br/>(<?=number_format($drd_uang,0,'.',',')?>)</td>		<td><?=number_format($efes,2,'.',',')?><br/>(<?=number_format($rek_total_efes,0,'.',',')?>)</td>		<td><?=number_format($efek,2,'.',',')?><br/>(<?=number_format($rek_total_efek,0,'.',',')?>)</td>	</tr>	<tr>		<td colspan="3"><hr/></td>	</tr>	<tr>		<th>Jumlah SL</th>		<th>Entry DSML</th>		<th>Proyeksi Uang Air (M3/Rupiah)</th>	</tr>	<tr>		<td><?=number_format($pel_jml,0,'.',',')?></td>		<td><?=number_format($dsml_jml,0,'.',',')?></td>		<td><?=number_format($sm_pakai,0,'.',',')?><br/>(<?=number_format($uangair,0,'.',',')?>)</td>	</tr></table><?php
			break;
		case 'kanan':			$que0 	= "CALL set_sopp(@sts)";			$que1 	= "SELECT @sts AS _sts";			mysql_query($que0);			$res1 = mysql_query($que1);			$row1 = mysql_fetch_object($res1);			if($row1->_sts==0)				$que2 	= "SELECT *FROM tmp_kasir ORDER BY rek_jml DESC,rek_total DESC";			else				$que2 	= "SELECT *FROM ds_kasir ORDER BY rek_jml DESC,rek_total DESC";			$res2 = mysql_query($que2);
?><table>
	<tr>
		<th width="30%">Nama Kasir</th>
		<th>Jumlah Rekening</th>
		<th>Jumlah Uang</th>		<th>Status Loket</th>
	</tr>
<?			$i					= 0;			$grand_rek_jml		= 0;			$grand_rek_total	= 0;			while($row1=mysql_fetch_object($res2)){				$class	= "odd";				if($i%2==0){					$class = "even";				}				$image_online	 = "images/offline.gif";				if($row1->tr_sts==1){					$sts_online++;					$image_online	 = "images/online.gif";				}?>	<tr class="<?=$class?>">
		<td class="left" valign="top"><?=$row1->kar_nama?></td>
		<td class="right" valign="top"><?=number_format($row1->rek_jml,0,'.',',')?></td>
		<td class="right" valign="top"><?=number_format($row1->rek_total,0,'.',',')?></td>		<td><img src="<?=$image_online?>" alt="Online"/></td>
	</tr>
<?				$grand_rek_jml		= $grand_rek_jml+$row1->rek_jml;				$grand_rek_total	= $grand_rek_total+$row1->rek_total;				$i++;
			}
?>	<tr>		<td colspan="4"><hr/></td>	</tr>	<tr>		<th>Grand Total</th>		<th class="right"><?=number_format($grand_rek_jml,0,'.',',')?></th>		<th class="right"><?=number_format($grand_rek_total,0,'.',',')?></th>		<th></th>	</tr>
</table>
<?			break;	}	mysql_close($db_link);?>
