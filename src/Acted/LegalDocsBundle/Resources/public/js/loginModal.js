function activateModal(){
    $('#activateProfileModal').modal('show');
}
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
    });

    $('#loginBtn').on('click',function(event) {
        event.preventDefault();
        var customerValues = $('.login-form').serialize();
        $.ajax({
            type: "POST",
            url: '/login_check',
            data: customerValues,
            success: function(response){
                $('#errorLogIn').hide();
                var userData = JSON.stringify(response);
                localStorage.setItem("user", userData);
                var quote = localStorage.getItem('quoteRequest');
                if(quote && response.role == "ROLE_CLIENT"){
                    $.ajax({
                        type:'POST',
                        url:'/event/create',
                        data: quote + '&user='+ response.userId,
                        beforeSend: function () {
                            $('#loadSpinner').fadeIn(500);
                        },
                        complete: function () {
                            $('#loadSpinner').fadeOut(500);
                        },
                        success: function(){
                            localStorage.removeItem('quoteRequest');
                            $('#loginModal').modal('hide');
                            $('#offerSuccess').modal('show');
                            setTimeout(function(){
                                window.location.replace(window.location.href);
                            }, 2000);
                        },
                        error: function(response){
                            console.log(response.responseJSON)
                            $('#userInformation').text()
                            $('#loadSpinner').fadeOut(500);
                            $('#loginModal').modal('hide');
                            $('#freeQuoteModal').modal('show');
                            $('#requestQuoteForm input').attr('style', '');
                            $('#quoteRequestSecond .errorCat').text('').hide();
                            $('#requestQuoteForm .errorCat').text('').hide();
                            $.each(response.responseJSON, function(key, value) {
                                $('#requestQuoteForm input[name='+key+']').attr('style', 'border-color: #ff735a !important');
                                if(key == 'performance'){
                                    $('#quoteRequestSecond .errorCat').text(value).show();
                                }
                                if(key == 'number_of_guests'){
                                    $('#requestQuoteForm .errorCat').text(value).show();
                                }
                            });
                        }
                    })
                } else if (quote && response.role == "ROLE_ARTIST"){
                    localStorage.removeItem('quoteRequest');
                    $('#loginModal').modal('hide');
                    $('#offerErrorModal').modal('show');
                    setTimeout(function(){
                        window.location.replace(window.location.href);
                    }, 2500);
                } else {
                    window.location.replace(window.location.href);
                }
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