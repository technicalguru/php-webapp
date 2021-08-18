
class SearchFilter {

	searchSubmit(domElement) {
		var filterForm = jQuery('#filterForm');
		if (filterForm.length == 0) {
			jQuery('#searchForm').submit();
		} else {
			jQuery('#filterForm input[name=search]').val(jQuery('#searchForm input[name=search]').val());
			filterForm.submit();
		}
	}

	filterSubmit(domElement) {
		var searchForm = jQuery('#searchForm');
		if (searchForm.length > 0) {
			jQuery('#filterForm input[name=search]').val(jQuery('#searchForm input[name=search]').val());
		}
		jQuery('#filterForm').submit();
	}
}
var searchFilter = new SearchFilter();

