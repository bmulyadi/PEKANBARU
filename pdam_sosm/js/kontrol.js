/** fungsi dasar */
function classToHash(opt){
	var param = new Hash();
	$A(document.getElementsByClassName(opt)).each(function(s){
		param.set(s.name,s.value);
	});
	return param;
}
function getSync(targetUrl,targetId,param){
	new Ajax.Request(targetUrl, {
		method: 'post',
		parameters: param,
		onComplete: function(response) {
			$(targetId).innerHTML = response.responseText;
			$('load').hide();
		}
	});
}
function getAsync(url,Id,param){
	new Ajax.Request(url, {
		asynchronous: false,
		method: 'post',
		parameters: param,
		onComplete: function(response) {
			$(Id).innerHTML = response.responseText;
		}
	});
}
function getErr(targetUrl,targetId,errParam){
	new Ajax.Request(targetUrl, {
		method: 'post',
		parameters: errParam,
		onComplete: function(response) {
			//$(targetId).innerHTML = response.responseText;
			$(targetId).insert(response.responseText);
		}
	});
}
/* **/
/** fungsi pengembangan */
function peringatan(opt){
	$('load').show();
	var param 		= classToHash(opt);
	var messParam	= new Hash();
	messParam.set('pesan',param.get('pesan'));
	messParam.set('kelas',opt);
	getErr('peringatan.php','nyangberubah',messParam);
}
function periksa(ent,cek){
	$('load').show();
	var errParam 	= new Hash();
	var entParam 	= classToHash(ent);
	var cekParam 	= classToHash(cek);
	var cekUrl		= entParam.get('cekUrl');
	//alert(entParam.inspect());
	cekParam.each(function(pair){
		errParam.set(pair.key,entParam.get(pair.key));
	});
	getAsync(cekUrl,'errId',errParam);
	var errMess = $('errMess').value;
	if(errMess){
		var messParam 	= 'pesan=' + errMess;
		getErr('pesan.php','mainWin',messParam);
	}
	else{
		var targetUrl 	= entParam.get('targetUrl');
		var targetId	= entParam.get('targetId');
		entParam.unset('targetUrl');
		entParam.unset('targetId');
		entParam.unset('cekUrl');
		//alert(entParam.inspect());
		getSync(targetUrl,targetId,entParam);
	}
}
function simpan(opt){
	$('load').show();
	var param 		= classToHash(opt);
	var targetUrl 	= param.get('targetUrl');
	//alert(param.inspect());
	param.unset('targetUrl');
	param.unset('targetId');
	getAsync(targetUrl,'errId',param);
	var errMess = $('errMess').value;
	if(errMess){
		var messParam 	= 'pesan=' + errMess;
		getErr('pesan.php','mainWin',messParam);
	}
}
function buka(opt){
	$('load').show();
	var param = new Hash();
	$A(document.getElementsByClassName(opt)).each(function(s){
		if(s.value.length > 0){
			param.set(s.name,s.value);
		}
	});
	//alert(param.inspect());
	var targetUrl 	= param.get('targetUrl');
	var targetId	= param.get('targetId');
	param.unset('targetUrl');
	param.unset('targetId');
	getSync(targetUrl,targetId,param);
}
function cetakin(opt){
	var param 		= classToHash(opt);
	var targetId 	= param.get('targetId');
	var targetUrl	= param.get('targetUrl');
	param.unset('targetId');
	param.unset('targetUrl');
	window.open(targetUrl + '?' +param.toQueryString(),targetId,'height=400,width=1024,scrollbars=1,toolbar=0,location=0,status=0,menubar=0,resizable=0');
	window.blur();
}
/* **/
/** fungsi tambahan */
function resize(){
	var dim = Element.getHeight('mainWin');
	var tin = dim - 147;
	Element.setStyle('nyangberubah',({height: ''+tin+''}));
}
function togel(opt){
	var sts = $('togel_' + opt).value;
	if(sts == 1){
		$('togel_' + opt).value=0;
		Effect.SlideUp(opt,{queue:{scope:'myscope', position:'end', limit: 1}});
		//$(opt).hide();
		//new Effect.Appear(opt);
	}
	else{
		$('togel_' + opt).value=1;
		Effect.SlideDown(opt,{queue:{scope:'myscope', position:'end', limit: 1}});
		//$(opt).show();
		//new Effect.Fade(opt);
	}
}
function pilihan(opt){
	if($('cek_'+opt).checked == true){
		$('pilih_'+opt).value = 1;
	}
	else{
		$('pilih_'+opt).value = 0;
	}
}
/* **/
/** fungsi khusus validasi dsml */
function pilihDsml(opt){
	setUbah(opt);
	var param = new Hash();
	$('cek_' + opt).checked 	= false;
	$('pilihan_' + opt).value	= 0;
	param.set("sm_lalu",$('sm_lalu_' + opt).value);
	param.set("sm_kini",$('sm_kini_' + opt).value);
	param.set("kl_kd",$('kl_kd_' + opt).value);
	param.set("kwm_kd",$('kwm_kd_' + opt).value);
	var pakai_kini						= param.get('sm_kini') - param.get('sm_lalu');
	var ket								= getKet(pakai_kini);
	$('pakai_kini_' + opt).innerHTML 	= param.get('sm_kini') - param.get('sm_lalu');
	$('ket_' + opt).innerHTML 			= ket;
}
function pilihWmmr(opt){
	setUbah(opt);
	var param 	= classToHash('wmmr_' + opt);
	var pilihan	= $('pilihan_' + opt).value;
	if(pilihan==1){
		$('pilihan_' + opt).value = 0;
	}
	if(pilihan==0){
		proses(opt,param);
	}
	//alert(param.inspect());
}
function proses(opt,param){
	$('pilihan_' + opt).value			= 1;
	$('kwm_kd_' + opt).value 			= param.get('kwm_kd');
	$('kl_kd_' + opt).value 			= param.get('kl_kd');
	$('sm_kini_' + opt).value 			= param.get('sm_kini');
	var pakai_kini						= param.get('sm_kini') - param.get('sm_lalu');
	var ket								= getKet(pakai_kini);
	$('pakai_kini_' + opt).innerHTML 	= param.get('sm_kini') - param.get('sm_lalu');
	$('ket_' + opt).innerHTML 			= ket;
}
function getKet(pakai){
	if(pakai>=50){
		return "Pemakaian >= 50";
	}
	else if(pakai<0){
		return "Pemakaian Negatif";
	}
	else if(pakai<=10){
		return "Pemakaian <= 10";
	}
	else{
		return "";
	}
}
function setMan(opt){
	setUbah(opt);
	$('cek_' + opt).checked 	= false;
	$('pilihan_' + opt).value	= 0;
}
function setUbah(opt){
	$('ubah_' + opt).value		= 1;
}
/* **/
