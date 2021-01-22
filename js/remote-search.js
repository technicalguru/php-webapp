$(document).ready(function() {
    let inputs = document.querySelectorAll('.remote-search');
	for (let i = 0; i < inputs.length; i++) {
		inputs[i].addEventListener('input', remoteSearch, false);
		$(inputs[i]).parent().on('shown.bs.dropdown', function () {
			if ($(event.target).val().length < 3) {
				$(event.target).next().dropdown('hide');
			}
		});
	}
	webApp.registerI18N(new I18N({
		'de' : {
			'searching': 'Suche...',
			'no_search_result': 'Nicht gefunden.',
		},
		'en' : {
			'searching': 'Searching...',
			'no_search_result': 'Nothing found.',
		},
	}));
});


function remoteSearch(e) {
	var searchPhrase = e.target.value;
	var domObject  = $(event.target);
	if (searchPhrase.length > 2) {
		var endpoint   = domObject.data('uri');
		var controller = new WebAppRemoteSearchController(domObject);
		webApp.GET(endpoint+'?search='+encodeURIComponent(e.target.value), controller);
	} else {
		domObject.dropdown('hide');
	}
}

function remoteSelected(dom) {
	var domObject = $(dom);
	var name      = domObject.data('name');
	var value     = domObject.data('value');
	var label     = domObject.data('label');
	if (typeof label === undefined) label = domObject.text();
	else label = decodeURIComponent(label);
	var html = '<span class="badge badge-primary" data-value="'+value+'">'+label+' <a href="#" onclick="deleteRemoteValue(this);return false;" data-value="'+value+'" data-name="'+name+'""><i class="fas fa-times-circle"></i></a></span>';
	html += '<input type="hidden" name="'+name+'[]" value="'+value+'">';
	$('#remote-search-values-'+name).append(html);
	$('#'+name+'-search').focus().val('');
}

function deleteRemoteValue(dom) {
	var domObject = $(dom);
	var name      = domObject.data('name');
	var value     = domObject.data('value');
	$('#remote-search-values-'+name).children().each(function() {
		if (($(this).data('value') == value) || ($(this).val() == value)) {
			$(this).remove();
		}
	});
	$('#'+name+'-search').focus().val('');
	
}

function WebAppRemoteSearchController(domObject) {
	this.domObject = domObject;
}

WebAppRemoteSearchController.prototype.beforeSend = function() {
	this.domObject.dropdown('show');
	this.domObject.next().html('<div class="dropdown-item-text">'+webApp.i18n('searching')+'</div>');
};

WebAppRemoteSearchController.prototype.done = function(ajaxParams, response, textStatus, jqXHR) {
	if (response.success) {
		if (this.domObject.val() == response.data.searchPhrase) {
			let html = '';
			let itemsFound = 0;
			let name = this.domObject.data('name');
			for (let i = 0; i < response.data.searchResult.length; i++) {
				let obj = response.data.searchResult[i];
				if (!this.isSelected(obj)) {
					itemsFound++;
					let shortLabel = (typeof obj.shortLabel === undefined) ? '' : ' data-label="'+encodeURIComponent(obj.shortLabel)+'"';
					html += '<a class="dropdown-item custom-control pl-3" data-value="'+obj.value+'" data-name="'+name+'"'+shortLabel+' onclick="remoteSelected(this);return false;">'+
								'<i class="fas fa-plus-circle text-success mr-2"></i>'+
								this.boldSearch(obj.label, response.data.searchPhrase)+
							'</a>';
				}
			}
			if (itemsFound > 0) {
				this.domObject.next().html(html);
			} else {
				this.domObject.next().html('<div class="dropdown-item-text"><i>'+webApp.i18n('no_search_result')+'</i></div>');
			}
		}
	}
};

WebAppRemoteSearchController.prototype.isSelected = function(obj) {
	var rc = false;
	$('#remote-search-values-'+this.domObject.data('name')).children().each(function() {
		if ($(this).data('value') == obj.value) {
			rc = true;
		}
	});
	return rc;
};

WebAppRemoteSearchController.prototype.boldSearch = function(s, needle) {
	let ls = s.toLowerCase();
	let rc = '';
	let parts = needle.toLowerCase().split(' ');
	for (let i = 0; i < parts.length; i++) {
		let pos = ls.search(parts[i]);
		if (pos >= 0) {
			s = s.substr(0, pos)+'<b>'+s.substr(pos, parts[i].length)+'</b>'+s.substr(pos+parts[i].length);
			ls = s.toLowerCase();
		}
	}
	return s;
};

WebAppRemoteSearchController.prototype.fail = function(ajaxParams, jqXHR, textStatus, errorThrown) {
};

