function WebAppUtils() {
}

// Format date and time
WebAppUtils.formatDateTime = function(timestamp) {
	var d = new Date(timestamp*1000);
	var rc = WebAppUtils.lpad(2, '0', d.getDate())+'.'+
	         WebAppUtils.lpad(2, '0', d.getMonth()+1)+'.'+
	         WebAppUtils.lpad(2, '0', d.getFullYear()-2000)+'&nbsp;'+
	         WebAppUtils.lpad(2, '0', d.getHours())+':'+
	         WebAppUtils.lpad(2, '0', d.getMinutes())+':'+
	         WebAppUtils.lpad(2, '0', d.getSeconds());
	return rc;
};

// Left-pad a string
WebAppUtils.lpad = function(len, pad, s) {
    var rc = String(s);
    while (rc.length < len) {
        rc = pad + rc;
    }
    return rc;
};

WebAppUtils.formatNumber = function(n, precision, decimalSeparator, thousandSeparator) {
	if (typeof decimalSeparator  == 'undefined') decimalSeparator  = '.';
	if (typeof thousandSeparator == 'undefined') thousandSeparator = ',';
	var s = n.toFixed(2).replace('.', decimalSeparator);
	return s;
};

// Test if string is empty
WebAppUtils.isEmpty = function(s) {
	return (0 === s.trim().length);
};

WebAppUtils.isInteger = function(value) {
    return /^\s*\d+\s*$/.test(value);
};

WebAppUtils.parseInt = function(value) {
	if (WebAppUtils.isInteger(value)) {
		return +value;
	}
	return false;
};

WebAppUtils.isEmail = function(value) {
	var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
	return pattern.test(value);
};

WebAppUtils.validateFields = function(path) {
	var rc = true;

	jQuery(path+' input,'+path+' textarea').each(function() {
		var c     = jQuery(this);
		var value = c.val();
		if (WebAppUtils.isEmpty(value) && c.attr('required') == 'required') {
			c.addClass('is-invalid');
			rc = false;
		} else if (c.attr('type') == 'email' && !WebAppUtils.isEmail(value)) {
			c.addClass('is-invalid');
			rc = false;
		} else {
			c.parent().removeClass('is-invalid');
		}
	});

	return rc;
};

WebAppUtils.encodeHtmlEntities = function(s) {
	var rc = s.replace(/[\u00A0-\u9999<>\&]/g, function(i) {
	   return '&#'+i.charCodeAt(0)+';';
	});
	return rc;
};
