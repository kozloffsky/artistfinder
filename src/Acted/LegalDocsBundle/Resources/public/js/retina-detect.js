$(function () {
    "use strict";

    var retina = window.devicePixelRatio > 1;

    if(retina) {
        $('body').animate({'opacity': 1}, 800);
        $('body').css('display', 'block');
    } else {
        $('body').css('opacity', 1);
        $('body').css('display', 'block');
    }
});