function init(){
	var url = 'monitoring.php';
	lihat(url,'','isi');
}
function lihat(url,param,Id){
	new Ajax.Request(url, {
		method: 'post', parameters: param,
		onComplete: function(transport) {
			$(Id).innerHTML = transport.responseText;
		}
	});
}
window.setInterval("init()", 1000);