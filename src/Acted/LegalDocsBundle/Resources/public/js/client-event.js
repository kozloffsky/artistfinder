$(function(){

    $('.enable_toggler').on('click', function() {
        $(this).prop('readonly', false);
    });


    $('.enable_toggler').on('focusout', function() {
        $(this).prop('readonly', true);
    });


    $('select.enable_toggler').change(function() {
        if ($(this).hasClass('not-active_select')) {
        } else {
            $(this).addClass('not-active_select');
            console.log($('body'));
            $(this).blur();
        }
    });


    $('select.enable_toggler').focusin(function() {
        if ($(this).hasClass('not-active_select')) {
            $(this).removeClass('not-active_select');
        }
    })

    $('select.enable_toggler').focusout(function() {
        $(this).addClass('not-active_select');
    })


    $('.enable_toggler').keyup(function(e){
        var code = e.which;
        if (code==13) {
            $(this).prop('readonly', true);
        } else {}
    });

});