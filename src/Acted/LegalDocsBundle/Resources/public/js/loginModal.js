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
});