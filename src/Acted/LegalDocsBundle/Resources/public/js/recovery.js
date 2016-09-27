$(function(){
    'use strict';

    var win = $(window),
        activeClass = 'active',
        promo = $('.promo-view'),
        recoveryForm = $('.recovery-form'),
        btn = recoveryForm.find('.btn'),
        btnShowPass = recoveryForm.find('.show-pass'),
        btnHidePass = recoveryForm.find('.hide-pass'),
        inputPass = recoveryForm.find('input[type="password"]'),
        notify = document.querySelectorAll('.notify-list li'),
        notifyLimit = recoveryForm.find('.notify-list .limit'),
        notifyUpperCase = recoveryForm.find('.notify-list .uppercase'),
        notifyNumber = recoveryForm.find('.notify-list .number'),
        arrNotify = [].slice.apply(notify),
        winHeight;

    var regPass = /([0-9])/;
    var regUpperChar = /([A-Z])/;
    var regLimit = /[a-zA-Z0-9@*#]{8,}/;


    win.on('load resize orientationchange', function () {
        winHeight = win.height();
        promo.css('min-height', winHeight + 'px');
    });


    recoveryForm.on({
        'input': function() {
            var cur = $(this);
            var curPass = cur.find('input[type="password"]');

            if(regUpperChar.test(curPass.val())){
                notifyUpperCase.addClass(activeClass);
            } else {
                notifyUpperCase.removeClass(activeClass);
            }
            if(regLimit.test(curPass.val())){
                notifyLimit.addClass(activeClass);
            } else {
                notifyLimit.removeClass(activeClass);
            }

            if(regPass.test(curPass.val())) {
                notifyNumber.addClass(activeClass);
            } else {
                notifyNumber.removeClass(activeClass);
            }

            if(arrNotify.every(function(item){return item.classList.contains(activeClass)})){
                btn.removeAttr('disabled');
            } else {
                btn.attr('disabled', 'disabled');
            }
        }
    });

    btnShowPass.on({
        'click': function (e) {
            e.preventDefault();
            var cur = $(this);
            if(cur.hasClass(activeClass)){
                cur.removeClass(activeClass);
                cur.find('.show').hide();
                cur.find('.hide').show();
                inputPass.attr('type', 'text');
                inputPass.css({
                    color: '#3d4248',
                    borderColor: '#3d4248'
                });
            } else {
                cur.addClass(activeClass);
                cur.find('.show').show();
                cur.find('.hide').hide();
                inputPass.attr('type', 'password');
                inputPass.css({
                    color: '#eee',
                    borderColor: '#eee'
                });
            }
            // cur.addClass(activeClass);
            // btnHidePass.removeClass(activeClass);
            // inputPass.attr('type', 'text');
            // inputPass.css({
            //     color: '#3d4248',
            //     borderColor: '#3d4248'
            // });
        }
    });

    // btnHidePass.on({
    //     'click': function (e) {
    //         e.preventDefault();
    //         $(this).addClass(activeClass);
    //         btnShowPass.removeClass(activeClass);
    //         inputPass.attr('type', 'password');
    //         inputPass.css({
    //             color: '#eee',
    //             borderColor: '#eee'
    //         });
    //     }
    // });

});