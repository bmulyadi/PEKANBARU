		function lihat(url,param,Id){
			new Ajax.Request(url, {
				method: 'post', parameters: param,
				onLoad: $('load').show(),
				onComplete: function(transport) {
					$(Id).innerHTML = transport.responseText;
					setTimeout("stop()",577);
				}
			});
		}
		function buka(){
			var kembalian = getParams();
			lihat(kembalian[0],kembalian[2],'peringatan');
		}
		function getParams(){
			var	params	= document.getElementsByClassName('params');
			var prm		= params[0].name + '=' + params[0].value;
			for(i=1;i<params.length;i++){
				if(params[i].name=='file'){
					var url = params[i].value;
				}
				if(params[i].name=='batal'){
					var btl = params[i].value;
				}
				prm = prm + '&' + params[i].name + '=' + params[i].value;
			}
			return new Array(url,btl,prm);
		}
		function tutup(Id){
			$(Id).remove();
		}
		function tutupGantiKopel(Id,mess){
			$('kopel').innerHTML = mess;
			tutup(Id);
		}
		function stop(){
			$('load').hide();
		}