<?php
	//cek_pass();
	$Group_c	= '000';
	require "model/tulisDB.php";
	$link		= new bacaDB();
	$query1 	= "SELECT *FROM v_menu_root";
	$result1 	= mysql_query($query1) or die(salah_db(array(mysql_errno(),mysql_error(),$query1),true));
	while ($menu_root = mysql_fetch_object($result1)){
		if ($Group_c == '000'){
			$query2	= "SELECT *FROM tm_aplikasi WHERE ga_kode = '$menu_root->appl_kode' AND appl_sts='0' ORDER BY appl_seq";
		}
		else{
			$query2 = "SELECT *FROM v_menu_grup WHERE ga_kode='$menu_root->appl_kode' AND grup_id='$Group_c' GROUP BY appl_kode";
		}
		$result2 = mysql_query ($query2) or die(salah_db(array(mysql_errno(),mysql_error(),$query2),true));
		if ( mysql_num_rows($result2) >0) {
			?> 
			<li>
			<a><?=$menu_root->appl_nama?></a>
			<ul>

			<?
			while ($menu_item = mysql_fetch_object($result2)){
				if(strlen($menu_item->appl_file)>3){
?>	
			<li>
				<input type="hidden" class="<?=$menu_item->appl_kode?>" name="targetUrl" value="<?=$menu_item->appl_file?>"/>
				<input type="hidden" class="<?=$menu_item->appl_kode?>" name="targetId" value="nyangberubah"/>
				<input type="hidden" class="<?=$menu_item->appl_kode?>" name="appl_kode" value="<?=$menu_item->appl_kode?>"/>
				<input type="hidden" class="<?=$menu_item->appl_kode?>" name="appl_nama" value="<?=$menu_item->appl_nama?>"/>
				<input type="hidden" class="<?=$menu_item->appl_kode?>" name="appl_file" value="<?=$menu_item->appl_file?>"/>
				<input type="hidden" class="<?=$menu_item->appl_kode?>" name="appl_proc" value="<?=$menu_item->appl_proc?>"/>
				<a class="tabs" onClick="buka('<?=$menu_item->appl_kode?>')"><?=$menu_item->appl_nama?> 
<?php
				}
				else{
			?>	
			<li><a><?=$menu_item->appl_nama?> 
			<?
				}
				if ($Group_c == '000'){
					$query3	= "SELECT *FROM tm_aplikasi WHERE ga_kode='$menu_item->appl_kode' AND appl_sts='0' ORDER BY appl_seq";
				}
				else{
					$query3 = "SELECT *FROM v_menu_item WHERE ga_kode='$menu_item->appl_kode' AND getmenu('$Group_c',appl_kode) = '1' GROUP BY appl_kode";
				}
				$result3 = mysql_query($query3) or die(salah_db(array(mysql_errno(),mysql_error(),$query3),true));
				
				if (mysql_num_rows($result3) > 0) {
				?>&raquo;</a><ul class="nav2"><?
					while ($menu_item1 = mysql_fetch_object($result3)){
					?>	
					<li>
						<input type="hidden" class="<?=$menu_item1->appl_kode?>" name="targetUrl" value="<?=$menu_item1->appl_file?>"/>
						<input type="hidden" class="<?=$menu_item1->appl_kode?>" name="targetId" value="nyangberubah"/>
						<input type="hidden" class="<?=$menu_item1->appl_kode?>" name="appl_kode" value="<?=$menu_item1->appl_kode?>"/>
						<input type="hidden" class="<?=$menu_item1->appl_kode?>" name="appl_nama" value="<?=$menu_item1->appl_nama?>"/>
						<input type="hidden" class="<?=$menu_item1->appl_kode?>" name="appl_file" value="<?=$menu_item1->appl_file?>"/>
						<input type="hidden" class="<?=$menu_item1->appl_kode?>" name="appl_proc" value="<?=$menu_item1->appl_proc?>"/>
						<a class="tabs" onClick="buka('<?=$menu_item1->appl_kode?>')"><?=$menu_item1->appl_nama?></a></li>	
					<? 
					}
					?></ul><?									
				}else{?></a><?}		
			
			?>
			</li>	
			<? 									
			}
	?>
	</ul>
	</li>	
	<? 			
					
		}							
	}
	$link->tutup();
?>