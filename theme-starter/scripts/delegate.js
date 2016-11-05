var $window = $(window);
var $document = $(document);
$document.ready(function() {
    // DECLARATIONS
    var $body = $('body');


});





// =========================================================================
// ------------------------------- SNIPPETS --------------------------------
// =========================================================================


// Resize Images height to aspect ratio.

    // $window.resize(function() {
    //     $categoryImageBox.css('height', $categoryImageBox.width() * 0.7);
    // });
    // $categoryImageBox.css('height', $categoryImageBox.width() * 0.7);



// Header menu toggle on pixel scroll

    // var $headerMenu = $('#header-menu');
    // var $hamburgerBtn = $('#hamburger-button');
    // var $categoriesMenu = $('#header-categories');
    // toggleMenu();
    // $document.on('scroll', toggleMenu);
    // function toggleMenu() {
    //     var scrollTop = $document.scrollTop();
    //     if (scrollTop <= 1) {
    //         $headerMenu.addClass('hidden');
    //         $hamburgerBtn.addClass('hidden');
    //     } else if (scrollTop > 1) {
    //         $headerMenu.removeClass('hidden');
    //         $hamburgerBtn.removeClass('hidden');
    //     }
    //     if (scrollTop <= 200) {
    //         $categoriesMenu.addClass('hidden');
    //     } else if (scrollTop > 200) {
    //         $categoriesMenu.removeClass('hidden');
    //     }
    // }


// Scroll is animated and disabled while first scroll happens

    // if ($document.scrollTop() < windowHeight) {
    //     $document.on('scroll', firstScroll);    
    // }
    // $hero.on('click', function() {
    //     firstScroll();
    // });
    // $arrow.on('click', function() {
    //     firstScroll();
    // });
    
    // function firstScroll(e) {
    //     disable_scroll();
    //     $document.off('scroll', firstScroll);
    //     $("html, body").animate({
    //         scrollTop: windowHeight - 100
    //     }, {
    //         duration: 1500,
    //         complete: function() {
    //             enable_scroll();
    //         }
    //     });
    // }
    // // A cool library for scroll disabling on all devices.
    // // left: 37, up: 38, right: 39, down: 40,
    // // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    // var keys = [37, 38, 39, 40];
    // function preventDefault(e) {
    //   e = e || window.event;
    //   if (e.preventDefault)
    //       e.preventDefault();
    //   e.returnValue = false;  
    // }
    // function keydown(e) {
    //     for (var i = keys.length; i--;) {
    //         if (e.keyCode === keys[i]) {
    //             preventDefault(e);
    //             return;
    //         }
    //     }
    // }
    // function wheel(e) {
    //   preventDefault(e);
    // }
    // function disable_scroll() {
    //   if (window.addEventListener) {
    //       window.addEventListener('DOMMouseScroll', wheel, false);
    //   }
    //   window.onmousewheel = document.onmousewheel = wheel;
    //   document.onkeydown = keydown;
    // }
    // function enable_scroll() {
    //     if (window.removeEventListener) {
    //         window.removeEventListener('DOMMouseScroll', wheel, false);
    //     }
    //     window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
    // }




