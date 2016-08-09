/**
 * Created by pavel on 09.08.16.
 */
$(function () {

    checkAvatar();

    function checkAvatar() {
        $('img.avatar , img.avatarImg').each(function(){
            var imageSrc = $(this).attr('src');
            if(imageSrc != undefined) {
                console.log(imageSrc.length);
                if (imageSrc.length <= 1) {
                    $(this).attr('src', '/assets/images/noAvatar.png');
                }
            }
        })
    }

    $('.homeSearchStart').on('click',function () {
        var searchEntered = $(homeSearchInput).val();
        if (searchEntered.length >= 1) {
            localStorage.setItem("search", searchEntered);
        }
    });
    checkIfUserForcedLogin();

    function checkIfUserForcedLogin(){
        var currentUrl = window.location.href ;
        var matchesUrl = currentUrl.split('/');
        console.log(matchesUrl[3])
        if (matchesUrl[3] == '?login_form'){
            $('#loginModal').modal('show');
        }
    }

    $("#homeSearchInput").keypress(function(e) {
        if (e.keyCode == 13) {
            $('.homeSearchStart button').trigger('click');
        }
    });

    $('#logOut').on('click',function(){
        localStorage.removeItem('user');
    });
});
