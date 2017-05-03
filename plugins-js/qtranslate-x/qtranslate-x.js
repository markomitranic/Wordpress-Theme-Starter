jQuery(document).ready(function() {
	// qTranslate language menu is awful, this is an idiotic way to circumvent it. Inline!
	$('.menu-language-switcher-container').hide();
	var srpski = $('#menu-item-162 a').attr('href');
	var engleski = $('#menu-item-163 a').attr('href');

	$('.lang-nav li:nth-child(1) a').attr('href', srpski);
	$('.lang-nav li:nth-child(2) a').attr('href', engleski);

	// Check what menu item should get the class
	if (document.documentElement.lang == "en-US") {
		$('.lang-nav li:nth-child(1)').removeClass('active');
		$('.lang-nav li:nth-child(2)').addClass('active');
	}
});