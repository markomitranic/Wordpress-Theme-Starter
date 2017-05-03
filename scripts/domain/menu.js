jQuery(document).ready(function(){
(function($) {

	function triggerMenu() {
		$(this).toggleClass('checked');
		$('nav.header .main-navigation').toggleClass('open');
		$('main.body').toggleClass('menu-open');
	}
	$('nav.header .hamburger').on('click', triggerMenu);


})(jQuery);
});