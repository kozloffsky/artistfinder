$(function() {
    $('.act-request-message').each(function() {
        var $element = $(this);
        var $toggler = $element.find('.show-more-btn');
        var $text = $element.find('.text');
        var text = $text.html();
        var $heading = $element.find('.title');

        var maxLength = 0;

        if($(window).width() < 768) {
            maxLength = parseInt($element.attr('data-max-chars-mobile'));
        } else {
            maxLength = parseInt($element.attr('data-max-chars-desktop'));
        }

        if(text.length > maxLength) {
            var newText = text.substring(0, maxLength - 3) + '...';
            $text.html(newText);

            $element.attr('data-full-text', text);
            $element.addClass('expandable');

            $toggler.click(function(e) {
                e.preventDefault();
               if(!$element.hasClass('opened')) {
                   $text.html( $element.attr('data-full-text'));
                   $element.addClass('opened');
                   $toggler.html('-hide');
               } else {
                   $element.removeClass('opened');
                   var newText = $element.attr('data-full-text').substring(0, maxLength - 3) + '...';
                   $text.html(newText);
                   $toggler.html('+more');
               }
            });
        } else {
            $toggler.hide();
        }
    });



});