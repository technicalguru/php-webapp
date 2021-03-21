function DynamicCheckEnable() {
}

DynamicCheckEnable.prototype.init = function() {
    jQuery('[data-role="dynamic-check-enable"]').on('click', function(evt) {
        dynamicCheckEnabler.clicked(this);
    }).each(function(index) {
		dynamicCheckEnabler.clicked(this);
	});
	
};

DynamicCheckEnable.prototype.clicked = function(domElement) {
	var checkbox   = jQuery(domElement);
	var checkGroup = checkbox.closest('.elem-by-check');
	var inputElem  = checkGroup.find('[data-role="dynamic-check-input"]');
	var inverse    = checkGroup.data('inverse');
	var checked    = checkbox.is(':checked');

	if (inverse == 'false') {
		this.setEnabled(inputElem, checked);
	} else {
		this.setEnabled(inputElem, !checked);
	}
};

DynamicCheckEnable.prototype.setEnabled = function(inputElem, isEnabled) {
	if (isEnabled) {
		inputElem.find('input,select,textarea').removeAttr('disabled');
	} else {
		inputElem.find('input,select,textarea').attr('disabled', 'disabled');
	}
};

var dynamicCheckEnabler = new DynamicCheckEnable();
dynamicCheckEnabler.init();

