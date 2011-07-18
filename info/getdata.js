	function init () {
		getTabData();
	}
	
	function getTabData(param) {
		var url = 'process.php';
		var rand = Math.random(9999);
		var pars = param + '&rand=' + rand;
		var myAjax = new Ajax.Request( url, {method: 'post', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	}
	
	function showLoad () {
		$('load').style.display = 'inline';
	}

	function showStop () {
		$('load').style.display = 'none';
	}

	function showResponse (originalRequest) {
		var newData = originalRequest.responseText;
		showStop();
		$('nyangberubah').innerHTML = newData;
	}
	
	function find_data(){ 
		var id1 = document.getElementsByClassName('id1');
	  	param = "id1=" + id1[0].value;
	 	getTabData(param);
	}
	
	function next_page(page,rek,uang){
		var id1 = document.getElementsByClassName('id1');
	  	param = "id1=" + id1[0].value + "&id2=" + page + "&id3=" + rek + "&id4=" + uang;
	 	getTabData(param);
	}
	
	function entry_data(nomor){
		var id1 = document.getElementsByClassName('id1');
		if (nomor == "delete"){
			param = null;			
		}
		else{
			param = id1[0].value + nomor;
		}
		document.getElementsByClassName('id1')[0].value = param;
	}