var Beer = {
	ajaxUrl : 'ajax.php',
	getRandom : function() {
		var self = this;
		var randomBeerDiv = document.getElementById('random_beer');
		randomBeerDiv.innerHTML = '<div class="col-md-12 text-center"><img src="static/img/spinner.gif" /></div>';
		var onSuccess = function(data) {
			randomBeerDiv.innerHTML = self.getBeerDiv(data);
		}
		var onFail = function() {
			randomBeerDiv.innerHTML = '<b>The random beer of the day could not be loaded. The script gave up trying to find an image that met the criteria, or the API is taking no more requests for the day.</b'; 
		}
		
		this.makeAjaxCall(onSuccess, onFail);	
	},
	getRandomFromBrewery : function(bid) {

	},
	getBeerDiv : function(data) {
		var div = '';
		div += '<div class="col-md-12"><b>' + data['name'] + '</b></div>';
		div += '<div class="col-md-2">';
		div += '<div><img src="' + data['labels']['icon'] + '" class="img-thumbnail" /></div>';
		div += '</div>';
		div += '<div class="col-md-10">' + data['description'] + '</div>';
		return div;
	},
	makeAjaxCall : function(success, fail) {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState != 4 || xhr.status != 200) return;
			var res = JSON.parse(xhr.responseText);
			if (res.hasOwnProperty('status') && res['status'] == 'success') {
				success(res['data']);
			} else {
				fail(); 
			}
		}
		xhr.open('GET', this.ajaxUrl);
		xhr.send();	
	}
}

