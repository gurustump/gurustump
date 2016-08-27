/*
 * Admin Scripts File
 * Author: Matthew Stumphy
 *
 * Just any extra javascript to run in the admin area.
*/


jQuery(document).ready(function($) {
	toggleMetaboxes($);
	$('#page_template').change(function() {
		toggleMetaboxes($);
	});
});

function toggleMetaboxes($) {
	var pageTemplate = $('#page_template').val()
	if (pageTemplate == 'page-index.php' ) {
		$('.cmb2-id--gurustump-page-index-gallery, .cmb2-id--gurustump-page-submenu').show();
	} else {
		$('.cmb2-id--gurustump-page-index-gallery, .cmb2-id--gurustump-page-submenu').hide();
	}
}
