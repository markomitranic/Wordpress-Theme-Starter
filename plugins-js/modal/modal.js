var $window = $(window);
var $document = $(document);
$document.ready(function() {
    // DECLARATIONS
    var $body = $('body');

// Create and deploy a modal window.

    // Cache main elements
    var $curtain = $('#curtain');
    var $modal = $('#modal');
    var $modalExit = $('#exitModal');
    var $modalInner = $('#modal-inner');
    var $buttons = $(".modal-item-button");
    // Verify that the modal elements have not been added yet.
    if ($curtain) {
    	$curtain.appendTo($body);
    } else {
    	$curtain = $('<div></div>', {
    		'id'	:	'curtain'
    	}).appendTo($body);
    }
    $curtain.on('click', closePortfolioModal);
    if ($modal) {
    	$modal.appendTo($body);
    } else {
    	$modal = $('<div></div>', {
    		'id'	:	'modal'
    	}).appendTo($body);
    }
    if ($modalExit) {
    	$modalExit.appendTo($modal);
    } else {
    	$modalExit = $('<div></div>', {
    		'id'	:	'exitModal',
    		'class'	:	'unselectable',
    		'text'	:	'╳',
    	}).appendTo($modal);
    }
    $modalExit.on('click', closePortfolioModal);
    if ($modalInner) {
    	$modalInner.appendTo($modal);
    } else {
    	$modalInner = $('<div></div>', {
    		'id'	:	'modal-inner'
    	}).appendTo($modal);
    }

    $buttons.on('click', function(e){openPortfolioModal(e, $(this).attr('href'), $(this).data('modal'));});
    // Prepare dom, add the modal html to the right place in the body
    function openPortfolioModal(event, href, modalEnable) {
        if ($window.width() <= 768 || modalEnable !== 1) {
            return true;
        } else {
            switch(event.button) {
                case 1:
                return true;
                break;
          
                case 2:
                return true;
                break;
          
                default:
                event.preventDefault();
                break;
            }
            $curtain.fadeIn('fast', function() {
                $body.addClass('no-scroll');
                $modalInner.html('');
                $('<div></div>', {
                    'class' : 'loading unclickable',
                    'text' : 'Loading...'
                }).appendTo($modalInner);
                
                $modal.fadeIn('slow');
                $modalInner.load(href + '?modal=true');
            });
        }
    }
    function closePortfolioModal() {
        $modal.fadeOut('fast', function() {
            $modalInner.html('');
            $('<div></div>', {
                'class' : 'loading unclickable',
                'text' : 'Loading...'
            }).appendTo($modalInner);
            $curtain.fadeOut('fast');
            $body.removeClass('no-scroll');
        });
    }


});
