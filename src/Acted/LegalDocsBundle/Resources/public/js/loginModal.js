$(function () {
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
            success: function(response){
                console.log(response)
                //alert('ffffff');
            },
            error: function(){
                //alert('dddd')
            }
        })
    });
});