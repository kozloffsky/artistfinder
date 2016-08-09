/**
 * Created by pavel on 09.08.16.
 */
$(function(){
    'use strict';

    $('#passwordRecoveryForm').on('click', function(e)  {
        e.preventDefault();
        var passwordValue = $('#password').val();
        var tokenVal = $('#currentToken').text();
        $('.recoveryFormSub #password_first, .recoveryFormSub #password_second').val(passwordValue);
        var recoveryPasswordVal = $('.recoveryFormSub form').serialize();
        sendNewPassword(recoveryPasswordVal, tokenVal);
    });


    function sendNewPassword(recoveryPasswordVal, tokenVal){
        $.ajax({
            type: "POST",
            url: '/resetting/reset/' + tokenVal,
            data: recoveryPasswordVal,
            success: function(){
                document.location.href="/";
            }
        })
    }

});