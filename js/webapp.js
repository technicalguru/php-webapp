// A i18n helper class
function I18N(values) {
	this.values = values;
}

// Return the value in the given language or undefined
I18N.prototype.translate = function(key, language) {
	if ((this.values[language] !== undefined) && (this.values[language][key] !== undefined)) {
		return this.values[language][key];
	}
	return undefined;
}

// Constructor
function WebApp() {
	// The defaults
	this.language = 'de';
	this.failedCalls = {};
	this.i18nValues = Array();

	// Detect user language
	this.language = jQuery('body').attr('lang');
	if (this.language === undefined) this.language = 'de';
}

/** An AJAX call */
WebApp.prototype.ajax = function(ajaxParams, ajaxController) {
	// Perform the AJAX call
	ajaxParams['beforeSend'] = function() {
		ajaxController.beforeSend();
	};
	$.ajax(ajaxParams)
		.done(function(data, textStatus, jqXHR) {
			ajaxController.done(ajaxParams, data, textStatus, jqXHR);
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			ajaxController.fail(ajaxParams, jqXHR, textStatus, errorThrown);
		});
};

/** A standard REST HEAD call */
WebApp.prototype.HEAD = function(url, ajaxController, dataType) {
	if (typeof dataType == 'undefined') dataType = 'json';
	this.ajax(
		{
			type:     'HEAD',
			dataType: dataType,
			url:      url,
		},
		ajaxController
	);
};

/** A standard REST GET call */
WebApp.prototype.GET = function(url, ajaxController, dataType) {
	if (typeof dataType == 'undefined') dataType = 'json';
	this.ajax(
		{
			type:     'GET',
			dataType: dataType,
			url:      url,
		},
		ajaxController
	);
};

/** A standard REST PUT call */
WebApp.prototype.PUT = function(url, data, ajaxController) {
	this.ajax(
		{
			type:        'PUT',
			dataType:    'json',
			url:         url,
			contentType: 'application/json; charset=utf-8',
			data:        JSON.stringify(data)
		},
		ajaxController
	);
}

/** A standard REST POST call */
WebApp.prototype.POST = function(url, data, ajaxController) {
	this.ajax(
		{
			type:        'POST',
			dataType:    'json',
			url:         url,
			contentType: 'application/json; charset=utf-8',
			data:        JSON.stringify(data)
		},
		ajaxController
	);
};

/** A standard REST PATCH call */
WebApp.prototype.PATCH = function(url, data, ajaxController) {
	this.ajax(
		{
			type:        'PATCH',
			dataType:    'json',
			url:         url,
			contentType: 'application/json; charset=utf-8',
			data:        JSON.stringify(data)
		},
		ajaxController
	);
};

/** A standard REST DELETE call */
WebApp.prototype.DELETE = function(url, ajaxController) {
	this.ajax(
		{
			type:     'DELETE',
			dataType: 'json',
			url:      url,
		},
		ajaxController
	);
};

WebApp.prototype.showSpinner = function(label) {
	if (typeof label === undefined) label = this.i18n('pleaseWait');
	jQuery('<div id="page-blocker" class="modal" tabindex="-1"><div class="vertical-center"><div class="spinner-border" role="status"><span class="sr-only">'+label+'</span></div></div></div><div id="page-blocker-backdrop" class="modal-backdrop show"></div>').appendTo('body');
	jQuery('#page-blocker').show();
};

WebApp.prototype.hideSpinner = function() {
	jQuery('#page-blocker').remove();
	jQuery('#page-blocker-backdrop').remove();
};

// Register an I18N object for translations
WebApp.prototype.registerI18N = function(i18nObject) {
	this.i18nValues.push(i18nObject);
};

// translate a key for display
WebApp.prototype.i18n = function(key, defaultValue) {
	if (defaultValue === undefined) defaultValue = '';
	var rc = defaultValue;
	var webAppThis = this;
	$.each(this.i18nValues, function(index, value) {
		var x = value.translate(key, webAppThis.language);
		if (x !== undefined) {
			rc = x;
			return false;
		}
	});
	return rc;
};

// Instantiate this class as singleton
var webApp = new WebApp();

/** A basic skeleton of a DomAjaxController
 ****************************************************************************************/
function WebAppAjaxController() {
}

WebAppAjaxController.prototype.beforeSend = function() {
	webApp.showSpinner();
};

WebAppAjaxController.prototype.done = function(ajaxParams, data, textStatus, jqXHR) {
	webApp.hideSpinner();
};

WebAppAjaxController.prototype.fail = function(ajaxParams, jqXHR, textStatus, errorThrown) {
	webApp.hideSpinner();
};

/** A NULL version of a DomAjaxController
 ****************************************************************************************/
function WebAppNullAjaxController() {
}

WebAppNullAjaxController.prototype.beforeSend = function() {
};

WebAppNullAjaxController.prototype.done = function(ajaxParams, data, textStatus, jqXHR) {
};

WebAppNullAjaxController.prototype.fail = function(ajaxParams, jqXHR, textStatus, errorThrown) {
};

/***************** Modals ************************/
function WebAppModal(id) {
	this.id  = id;
	jQuery('#'+id).remove();
	jQuery('<div id="'+this.id+'" class="modal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"></h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary close-button" data-dismiss="modal">'+webApp.i18n('close')+'</button></div></div></div></div>').appendTo('body');
	this.dom = jQuery('#'+id);
}

WebAppModal.prototype.setStatic = function() {
	this.dom.data('backdrop', 'static');
};
 
WebAppModal.prototype.setHeader = function(content) {
	jQuery('#'+this.id+' .modal-header').html(content);
};

WebAppModal.prototype.setTitle = function(title) {
	jQuery('#'+this.id+' .modal-title').html(title);
};

WebAppModal.prototype.setBody = function(content) {
	jQuery('#'+this.id+' .modal-body').html(content);
};

WebAppModal.prototype.setFooter = function(content) {
	jQuery('#'+this.id+' .modal-footer').html(content);
};

WebAppModal.prototype.setCloseLabel = function(label) {
	jQuery('#'+this.id+' .close-button').html(label);
};

WebAppModal.prototype.addButton = function(label, classes, onclick) {
	jQuery('#'+this.id+' .modal-footer').append('<button type="button" class="btn '+classes+'" onclick="'+onclick+'">'+label+'</button>');
};

WebAppModal.prototype.show = function() {
	jQuery('#'+this.id).modal('show');
};

WebAppModal.prototype.hide = function() {
	jQuery('#'+this.id).hide();
};

WebAppModal.prototype.destroy = function() {
	jQuery('#'+this.id).remove();
};

webApp.registerI18N(new I18N({
	'de' : {
		'ok'       : 'OK',
		'close'    : 'Schließen',
		'cancel'   : 'Abbrechen',
		'yes'      : 'Ja',
		'no'       : 'Nein',
		'delete'   : 'Löschen',
		'continue' : 'Weiter...',
	},
	'en' : {
		'ok'       : 'OK',
		'close'    : 'Close',
		'cancel'   : 'Cancel',
		'yes'      : 'Yes',
		'no'       : 'No',
		'delete'   : 'Delete',
		'continue' : 'Proceed...',
	},
}));
