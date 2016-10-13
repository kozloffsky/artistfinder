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
    }
});