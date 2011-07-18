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
	var targetUrl	= param.get('targetUrl');
	param.unset('targetUrl');
	getErr(targetUrl,'nyangberubah',param);
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
		var entParam 	= classToHash(ent);
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
	param.unset('targetUrl');
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
/* **/
/** fungsi pembayaran */
function pilihin(opt){
	var pilih 	= document.getElementsByClassName('pilih');
	var j		= opt;
	var total	= 0;
	if(pilih[opt].checked == true){
		j	= parseInt(opt) + 1;
	}
	for(i=0;i<pilih.length;i++){
		if(i<j){
			$('pilih_' + i).value 	= 1;
			var total				= parseInt(total) + parseInt($F('total_' + i));
			pilih[i].checked 		= true;
		}
		else{
			$('pilih_' + i).value 	= 0;
			pilih[i].checked 		= false;
		}
	}
	$('bayar').value = total;
}
/* **/