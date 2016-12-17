/**
 * Created by pavel on 09.08.16.
 */
function activateModal(){
    $('#activateProfileModal').modal('show');
}
$(function () {
    var loginFormValidation = $(".login-form").validate();

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
                var tempUserToken = response.tempUserToken;
                var quote = localStorage.getItem('quoteRequest');
                if(quote && response.role == "ROLE_CLIENT" && tempUserToken.length > 2){
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
                            // setTimeout(function(){
                            //     window.location.replace(window.location.href);
                            // }, 2000);
                        },
                        error: function(response){
                            console.log(response.responseJSON);
                            $('#userInformation').text();
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
                } else if (quote && response.role == "ROLE_ARTIST" && tempUserToken.length > 2){
                    localStorage.removeItem('quoteRequest');
                    $('#loginModal').modal('hide');
                    $('#offerErrorModal').modal('show');
                    // setTimeout(function(){
                    //     window.location.replace(window.location.href);
                    // }, 2500);
                } else {
                    // console.log(response)
                    // if (response.tempUserToken.length > 0){
                    //     var redirectUrl = window.location.protocol + "//" + window.location.host + '/resend_token/reset/' + tempUserToken;
                    //     window.location.replace(redirectUrl);
                }

                window.location.reload();
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