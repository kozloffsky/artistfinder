$(function () {
    var loginFormValidation = $(".login-form").validate();

    $('.forgot-password').click(function () {
        $('.form-block').hide();
        $('.recovery-form').show();
        $('.login-modal .modal-title').html('Password recovery');
    });

    $('#loginModal').on('hidden.bs.modal', function (e) {
        $('.form-block').hide();
        $('.login-form').show();
        $('.login-modal .modal-title').html('Log In');
    })

    $('#loginBtn').on('click',function(event) {
        event.preventDefault();
        var customerValues = $('.login-form').serialize();
        $.ajax({
            type: "POST",
            url: '/login_check',
            data: customerValues,
            success: function(){
                $('#errorLogIn').hide();
                window.location.replace(window.location.href);
            },
            error: function(response){
                var responseTextLogIn = response.responseJSON;
                console.log(responseTextLogIn.error);
                $('#errorLogIn').text(responseTextLogIn.error);
                $('#errorLogIn').css('display', 'block');
            }
        })
    });
});