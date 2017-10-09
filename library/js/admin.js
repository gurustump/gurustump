/*
 * Admin Scripts File
 * Author: Matthew Stumphy
 *
 * Just any extra javascript to run in the admin area.
*/


jQuery(document).ready(function($) {
	toggleMetaboxes($);
	$('#page_template, #_gurustump_page_post_type').change(function() {
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
	if (pageTemplate == 'page-randomizer.php' ) {
		$('.cmb2-id--gurustump-page-randomizer').show();
	} else {
		$('.cmb2-id--gurustump-page-randomizer').hide();
	}
	if ($('#_gurustump_page_post_type').val() == '') {
		$('.cmb2-id--gurustump-page-post-type-heading, .cmb2-id--gurustump-page-post-type-description').hide();
	} else {
		$('.cmb2-id--gurustump-page-post-type-heading, .cmb2-id--gurustump-page-post-type-description').show();
	}
}