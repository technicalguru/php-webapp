$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields"]');
            new_field_group = container.children().filter('.form-inline:first-child')[0].outerHTML;
			var newId = dfNum;
			dfNum++;
			new_field_group = new_field_group.replaceAll('IDNUM', 'new-'+newId);
            container.append(new_field_group);
            container.children().filter('.form-inline:last-child').children().each(function(){
                $(this).show();
            });
        }
    );
});
var dfNum = 1;
