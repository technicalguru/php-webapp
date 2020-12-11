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
var rsWebApp = new WebApp();

/** A basic skeleton of a DomAjaxController
 ****************************************************************************************/
function WebAppAjaxController() {
}

WebAppAjaxController.prototype.beforeSend = function() {
};

WebAppAjaxController.prototype.done = function(ajaxParams, data, textStatus, jqXHR) {
};

WebAppAjaxController.prototype.fail = function(ajaxParams, jqXHR, textStatus, errorThrown) {
};


