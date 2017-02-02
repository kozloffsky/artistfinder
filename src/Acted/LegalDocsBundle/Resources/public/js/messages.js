$(function () {
    $('.messages select').each(function () {
        var white       = $(this).attr('data-class') == 'selections-white';
        var placeholder = $(this).attr('data-placeholder');
        var $select2    = $(this).select2({
            placeholder            : placeholder || '',
            minimumResultsForSearch: -1
        });

        if (white) {
            $select2.data('select2').$results.addClass('selections-white');
        }
    });

    if ($(window).width() < 768) {
        $('.dialog-section').each(function () {
            var $element  = $(this);
            var $messageSection = $element.find('.wrap');
            var $controls = $element.find('.controls-mobile');

            var redirectUrl = $element.attr('data-href');
            var duration    = $element.attr('data-longtap-duration');

            $element.on("taphold", {duration: duration}, function () {
                    $controls.toggleClass('opened')
            });

            $messageSection.on('click', function() {
               window.location = redirectUrl;
            });
        });

        $('.messages .dialog-section')
            .on("swipeleft", function(){
                $(this).animate(
                    { left: -160 }, // what we are animating
                    {
                        duration: 'fast', // how fast we are animating
                        easing: 'swing', // the type of easing
                        complete: function() { // the callback

                        }
                    }
                );
            })
            .on("swiperight", function(){
                $(this).animate(
                    { left: 0 }, // what we are animating
                    {
                        duration: 'fast', // how fast we are animating
                        easing: 'swing', // the type of easing
                        complete: function() { // the callback

                        }
                    }
                );
            });
    }
});