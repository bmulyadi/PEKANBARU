<script>$('load').hide();</script>
<div id="peringatan">
<div id="pesan">
<?php
	$nilai	= $_POST;
	$kunci	= array_keys($nilai);
	for($i=0;$i<count($kunci);$i++){
		$$kunci[$i]	= $nilai[$kunci[$i]];
	}
	if($bayar>0){
?>
	<table>
		<tr>
			<td>Total</td>
			<td>
				: <b><?=number_format($bayar,0,',','.')?></b>
				<input id="a" type="hidden" value="<?=$bayar?>"/>
			</td>
		</tr>
		<tr>
			<td>Dibayar</td>
			<td>:
				<input id="b" type="text" class="noRek" name="dibayar" value="<?=$bayar?>" onMouseOver="$('b').select()" onChange="$('c').innerHTML=$('b').value-$('a').value"/>
			</td>
		</tr>
		<tr>
			<td>Kembalian</td>
			<td>: <b><span id="c">0</span></b></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="button" class="form_button" value="Bayar" onClick="buka('noRek')"/>
				<input type="button" class="form_button" value="Batal" onClick="$('peringatan').remove()"/>
			</td>
		</tr>
	</table>
<?php
	}
	else{
?>
	Belum ada rekening dipilih<br/>
	<input type="button" class="form_button" value="Tutup" onClick="$('peringatan').remove()"/>
<?php
	}
?>
</div>
</div>