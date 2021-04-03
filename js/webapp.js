// A i18n helper class
class I18N {

	constructor(values) {
		this.values = values;
	}

	// Return the value in the given language or undefined
	translate(key, language) {
		if ((this.values[language] !== undefined) && (this.values[language][key] !== undefined)) {
			return this.values[language][key];
		}
		return undefined;
	}
}

class WebApp {

	constructor() {
		// The defaults
		this.language    = 'de';
		this.failedCalls = {};
		this.i18nValues  = Array();

		// Detect user language
		this.language = jQuery('body').attr('lang');
		if (this.language === undefined) this.language = 'de';
	}

	/** An AJAX call */
	ajax(ajaxParams, ajaxController) {
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
	}

	/** A standard REST HEAD call */
	HEAD(url, ajaxController, dataType) {
		if (typeof dataType == 'undefined') dataType = 'json';
		this.ajax(
			{
				type:     'HEAD',
				dataType: dataType,
				url:      url,
			},
			ajaxController
		);
	}

	/** A standard REST GET call */
	GET(url, ajaxController, dataType) {
		if (typeof dataType == 'undefined') dataType = 'json';
		this.ajax(
			{
				type:     'GET',
				dataType: dataType,
				url:      url,
			},
			ajaxController
		);
	}

	/** A standard REST PUT call */
	PUT(url, data, ajaxController) {
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
	POST(url, data, ajaxController) {
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
	}

	/** A standard REST PATCH call */
	PATCH(url, data, ajaxController) {
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
	}

	/** A standard REST DELETE call */
	DELETE(url, ajaxController) {
		this.ajax(
			{
				type:     'DELETE',
				dataType: 'json',
				url:      url,
			},
			ajaxController
		);
	}

	showSpinner(label) {
		if (typeof label === undefined) label = this.i18n('pleaseWait');
		jQuery('<div id="page-blocker" class="modal" tabindex="-1"><div class="vertical-center"><div class="spinner-border" role="status"><span class="sr-only">'+label+'</span></div></div></div><div id="page-blocker-backdrop" class="modal-backdrop show"></div>').appendTo('body');
		jQuery('#page-blocker').show();
	}

	hideSpinner() {
		jQuery('#page-blocker').remove();
		jQuery('#page-blocker-backdrop').remove();
	}

	// Register an I18N object for translations
	registerI18N(i18nObject) {
		this.i18nValues.push(i18nObject);
	}

	// translate a key for display
	i18n(key, defaultValue) {
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
	}

	// show an error
	error(title, message, callback) {
		this.message(title, '<div class="alert alert-danger">'+message+'</div>', callback);
	}

	// show a warning
	warning(title, message, callback) {
		this.message(title, '<div class="alert alert-warn">'+message+'</div>', callback);
	}

	// show a message
	message(title, body, callback) {
		var modal = new WebAppModal('webAppMessage');
		modal.setTitle(title);
		modal.setBody(body);
		modal.show();
		jQuery('#webAppMessage').on('hidden.bs.modal', function(evt) {
			modal.destroy();
			if (typeof callback == 'function') {
				callback();
			}
		});
	}
}
// Instantiate this class as singleton
var webApp = new WebApp();

/** A basic skeleton of a DomAjaxController
 ****************************************************************************************/
class WebAppAjaxController {

	constructor() {
	}

	beforeSend() {
	}

	done(ajaxParams, data, textStatus, jqXHR) {
	}

	fail(ajaxParams, jqXHR, textStatus, errorThrown) {
	}

}

/** A NULL version of a DomAjaxController
 ****************************************************************************************/
class WebAppDefaultAjaxController extends WebAppAjaxController  {

	constructor() {
		super();
	}

	beforeSend() {
		webApp.showSpinner();
	}

	done(ajaxParams, data, textStatus, jqXHR) {
		webApp.hideSpinner();
	}

	fail(ajaxParams, jqXHR, textStatus, errorThrown) {
		webApp.hideSpinner();
	}

}

/***************** Modals ************************/
class WebAppModal {

	constructor(id) {
		this.id  = id;
		jQuery('#'+id).remove();
		jQuery('<div id="'+this.id+'" class="modal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"></h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary close-button" data-dismiss="modal">'+webApp.i18n('close')+'</button></div></div></div></div>').appendTo('body');
		this.dom = jQuery('#'+id);
	}

	setStatic() {
		this.dom.data('backdrop', 'static');
	}
	 
	setHeader(content) {
		jQuery('#'+this.id+' .modal-header').html(content);
	}

	setTitle(title) {
		jQuery('#'+this.id+' .modal-title').html(title);
	}

	setBody(content) {
		jQuery('#'+this.id+' .modal-body').html(content);
	}

	setFooter(content) {
		jQuery('#'+this.id+' .modal-footer').html(content);
	}

	setCloseLabel(label) {
		jQuery('#'+this.id+' .close-button').html(label);
	}

	addButton(label, classes, onclick) {
		jQuery('#'+this.id+' .modal-footer').append('<button type="button" class="btn '+classes+'" onclick="'+onclick+'">'+label+'</button>');
	}

	show() {
		jQuery('#'+this.id).modal('show');
		var elems = jQuery('.modal-dialog .modal-body input,.modal-dialog .modal-body select');
		if (elems.length > 0) {
			elems[0].focus();
		}
	}

	hide() {
		jQuery('#'+this.id).modal('hide');
	}

	destroy() {
		jQuery('#'+this.id).modal('dispose');
		jQuery('#'+this.id).remove();
	}

	end() {
		this.hide();
		this.destroy();
	}

	key(evt) {
		if (evt.keyCode == 27) {
			// Escape, abort dialog
			this.end();
		} else if (evt.keyCode == 13) {
			// Enter, trigger submit
			jQuery('.modal-dialog .modal-footer .btn-primary')[0].click();
		}
	}

	addFormHandlers() {
		var modal = this;
		jQuery('.modal-dialog .modal-body')
			.on('keydown', function(evt) { modal.key(evt); })
			.on('keyup',   function(evt) { modal.key(evt); });
	}
}

class YesNoModal extends WebAppModal {

	constructor(id, title, body) {
		super(id);
		this.setTitle(title);
		this.setBody(body);
		this.addButton(webApp.i18n('yes'), 'btn-primary', '');
		this.setNoLabel(webApp.i18n('no'));
		jQuery('#'+this.id+' .btn-primary').on('click', jQuery.proxy(this.yesClicked, this));
		jQuery('#'+this.id+' .close-button').on('click', jQuery.proxy(this.noClicked, this));
	}

	setNoLabel(label) {
		this.setCloseLabel(label);
	}

	setYesLabel(label) {
		jQuery('#'+this.id+' .btn-primary').html(label);
	}

	yesClicked() {
		this.end();
	}

	noClicked() {
		this.end();
	}

}

webApp.registerI18N(new I18N({
	'de' : {
		'ok'       : 'OK',
		'close'    : 'Schließen',
		'cancel'   : 'Abbrechen',
		'yes'      : 'Ja',
		'no'       : 'Nein',
		'delete'   : 'Löschen',
		'continue' : 'Weiter...',
		'internal_error' : 'Interner Fehler',
		'error'    : 'Die Aufgabe konnte nicht erfolgreich ausgeführt werden.',
	},
	'en' : {
		'ok'       : 'OK',
		'close'    : 'Close',
		'cancel'   : 'Cancel',
		'yes'      : 'Yes',
		'no'       : 'No',
		'delete'   : 'Delete',
		'continue' : 'Proceed...',
		'internal_error' : 'Internal Error',
		'error'    : 'The task could not be executed successfully.',
	},
}));
