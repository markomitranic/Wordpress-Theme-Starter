jQuery(document).ready(function() {
    (function($) {

        $('ul.frontpage-slider').slick({
            dots: false,
            infinite: true,
            speed: 1500,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 2500,
            slidesToShow: 1,
            centerMode: false,
            variableWidth: false,
            pauseOnHover: false,
            fade: true,
            cssEase: 'linear',
        });

        $(window).resize(function() {
            $('ul.frontpage-slider').slick('resize');
        });

        $(window).on('orientationchange', function() {
            $('ul.frontpage-slider').slick('resize');
        });

    })(jQuery);
});
