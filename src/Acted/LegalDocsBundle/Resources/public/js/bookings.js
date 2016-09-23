$(function(){
    'use strict';

    $('select').each(function () {
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

});