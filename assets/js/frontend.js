jQuery(document).ready(function($) {
	$('.ez_item-third').hover(function () {
		$('.ez_item_title_reveal', this).stop(true, true).slideDown("normal");
    }, function () {
		$('.ez_item_title_reveal', this).stop(true, true).slideUp("fast");
	});
	$('a.lightbox').nivoLightbox();
});
