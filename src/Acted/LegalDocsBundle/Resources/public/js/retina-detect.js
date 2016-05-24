$(function () {
    "use strict";

    var retina = window.devicePixelRatio > 1;

    console.log(retina)
    if(retina) {
        $("link[href*='css/styles.css']").attr('href', '/css/style-retina.css');
        $('body').animate({'opacity': 1}, 800);
        $('body').css('display', 'block');
    } else {
        $('body').css('opacity', 1);
        $('body').css('display', 'block');
    }

});