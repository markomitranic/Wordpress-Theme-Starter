// This slider was created for graders.rs
// Marko Mitranic
// github.com/markomitranic

jQuery(document).ready(function ($) {

    setInterval(function () {
        moveRight();
    }, 4000);
  
	var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
    $('#thumbs img').on('click', function() {
        var selectedID = $(this).data("id");
        var currentID = $('.current').data("id");
        var difference = currentID - selectedID;

        for (var i = Math.abs(difference) - 1; i >= 0; i--) {         
            if (difference < 0) {
                moveRight(100);
            } else {
                moveLeft(100);
            }  
        }
    });

	$('#slider').css({ width: slideWidth, height: slideHeight });
	
	$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $('#slider ul li:last-child').prependTo('#slider ul');

    $('#slider ul li').removeClass("current");

    $('#slider ul li:nth-child(2)').addClass("current");

    function moveLeft(time) {
        var duration = time || 600;
        $('#slider ul').animate({
            left: + slideWidth
        }, duration, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul li').removeClass("current");
            $('#slider ul li:nth-child(2)').addClass("current");
            $('#slider ul').css('left', '');
        });
    };

    function moveRight(time) {
        var duration = time || 600;
        $('#slider ul').animate({
            left: - slideWidth
        }, duration, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul li').removeClass("current");
            $('#slider ul li:nth-child(2)').addClass("current");
            $('#slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
    });

    $('a.control_next').click(function () {
        moveRight();
    });

});    

