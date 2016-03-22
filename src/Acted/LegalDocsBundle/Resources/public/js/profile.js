$(function() {

    $('.header-background').appendTo('header');

    setRaitingStars();

    function setRaitingStars(){
        var raiting = $('#raitingVal').text();
        var raitingFull = raiting.toString().split(".")[0];
        var raitingDigits = raiting.toString().split(".")[1];
        var ratingstars = $('.user-rating .star');
        var getFullStars = $(ratingstars).slice(0,raitingFull);
        var getHalfStars = $(ratingstars).eq(raitingFull);
        $(getFullStars).children('.fill-star').css('width', '100%');
        $(getHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
        var feedbackStars = $('#feedbacks .star');
        var getFeedbackFullStars = $(feedbackStars).slice(0,raitingFull);
        var getFeedbackHalfStars = $(feedbackStars).eq(raitingFull);
        $(getFeedbackFullStars).children('.fill-star').css('width', '100%');
        $(getFeedbackHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
    }

    $(".navbar-nav li a").click(function(event) {
        $(".navbar-collapse").collapse('hide');
    });

    $('.bxslider').bxSlider({
        adaptiveHeight: true,
        mode: 'fade',
        pagerCustom: '#photo-pager',
        nextSelector: '#nextSlide',
        prevSelector: '#prevSlide',
        nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
        prevText: '<i class="left fa fa-3x fa-angle-left"></i>'
    });

    $('.bxVideoSlider').bxSlider({
        adaptiveHeight: true,
        mode: 'fade',
        useCSS: false,
        video:true,
        pagerCustom: '#video-pager',
        nextSelector: '#nextVideoSlide',
        prevSelector: '#prevVideoSlide',
        nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
        prevText: '<i class="left fa fa-3x fa-angle-left"></i>',
        onSliderLoad: function() {
            $('#section-video').hide();
        }
    });

    /*$('#video-pager img').each(function(){
        var videoThumbId = $(this).attr('id');
        getVideoThumbnails(videoThumbId)
    });

    function getVideoThumbnails(id){
        $.ajax({
            type:'GET',
            url: 'http://vimeo.com/api/v2/video/' + id + '.json',
            jsonp: 'callback',
            dataType: 'jsonp',
            success: function(data){
                var thumbnail_src = data[0].thumbnail_medium;
                var thumbs = document.getElementById(id);
                $(thumbs).attr('src', thumbnail_src);
            }
        });
    }*/

    function resizeThumbs() {
        $('.scale-thumb').each(function() {
            var height = $(this).width() * 0.69;
            $(this).height(height);
        });

        //Resize navbar-collapsed
        if($(window).width() < 992) {
            $('.navbar-collapse').css('max-height', $(window).height() - 70 + 'px');
        } else {
            $('.navbar-collapse').css('max-height', '340px');
        }
    }

    function changeHeaderColorOnScroll() {
        if($('body').scrollTop() > $('header').offset().top + 100) {
            $('.navbar').css('background-color', '#2228A3');
            $('.divider-vertical').css('background-color', 'rgba(24, 28, 127, 0.14)');
        } else  {
            $('.navbar').css('background-color', 'rgba(59,68,235, 0.33)');
            $('.divider-vertical').css('background-color', 'rgba(4, 6, 64, 0.14)');
        }
    }

    resizeThumbs();
    changeHeaderColorOnScroll();

    $( window ).resize($.throttle(250, resizeThumbs));
    $( window ).scroll($.throttle(100, changeHeaderColorOnScroll));

    $('a.anchor-scroll').click(function(){
        $('html, body').animate({
            scrollTop: ($( $.attr(this, 'href') ).offset().top - 72)
        }, 500);
        return false;
    });

    $('.media a.tab').click(function(){

        $('.media a.tab').removeClass('active');
        $('.media-content').hide();

        $($.attr(this, 'data-target')).show();

        $(this).addClass('active');

        resizeThumbs();
        return false;
    });

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

});

$('#editBiography').click(function(e) {
    e.stopPropagation();
    $('#biographyEditable').editable({
        type: 'textarea',
        success: function(response, newValue) {
            var slug = $('#slug').text();
            $.ajax({
                type: "PATCH",
                url: '/profile/' + slug + '/edit',
                data: {"profile[description]": newValue}
            });
        }
    });
});

/*$('#editUsername').click(function(e) {
    e.stopPropagation();
    $('#username').editable({
        type: 'text',
        success: function(response, newValue) {
            var slug = $('#slug').text();
            $.ajax({
                type: "PATCH",
                url: '/profile/' + slug + '/edit',
                data: {"artist[name]": newValue}
            });
        }
    });
});*/

$('.editOffer').click(function(e) {
    e.stopPropagation();
    var parentPerformance = $(this).parents('article')
    var performanceId = $(parentPerformance).children('.performanceId').text();
    $(parentPerformance).find('.perfomanceInfoEdiatable').editable({
        type: 'text',
        success: function(response, newValue) {
            $.ajax({
                type: "PATCH",
                url: '/profile/performance/' + performanceId + '/edit',
                data: {"performance[techRequirement]": newValue}
            });
        }
    });

    $(parentPerformance).find('.perfomanceTitleEdiatable').editable({
        type: 'text',
        success: function(response, newValue) {
            $.ajax({
                type: "PATCH",
                url: '/profile/performance/' + performanceId + '/edit',
                data: {"performance[title]": newValue}
            });
        }
    });
    $(parentPerformance).find('.imagePerformanceChange').fadeIn();
});

$('.deleteOffer').click(function(){
    console.log('ddddd')
    var parentPerformance = $(this).parents('article');
    var performanceId = $(parentPerformance).children('.performanceId').text();
    var slug = $('#slug').text();
    console.log(performanceId);
    deleteOffer(slug, performanceId, parentPerformance)
});

function deleteOffer(slug, performanceId, parentPerformance){
    $.ajax({
        type: "DELETE",
        url: '/profile/' + slug + '/performance/' + performanceId,
        success: function(){
            $(parentPerformance).remove();
        }
    })
}

$('#addNewPerformance').on('click', function(){
    var addNewBtn = $(this);
    var slug = $('#slug').text();
    var performanceCreateBlock = $('.emptyPerformance');
    var getNewBlockPerformance = $(performanceCreateBlock).clone();
    getNewBlockPerformance.insertBefore(addNewBtn).removeClass('emptyPerformance').fadeIn();
    $(getNewBlockPerformance).find('.perfomanceTitleEdiatable').editable({
        type: 'text',
        success: function (response, newValue) {
            $.ajax({
                type: "POST",
                url: '/profile/'+ slug +'/performance/new',
                data: {"performance[title]": newValue},
                success: function(responseText){
                    var newPerformanceId = responseText.performance.id;
                    $(getNewBlockPerformance).find('.performanceId').html(responseText.performance.id);
                    createNewPerformance(getNewBlockPerformance, newPerformanceId)
                }
            });
        }
    });
});

function createNewPerformance(getNewBlockPerformance, newPerformanceId){
    console.log(newPerformanceId);
    var imagesDropzoneAdd = $(getNewBlockPerformance).find('.imagePerformanceChange');
    imagesDropzoneAdd.attr('action', '/profile/performance/'+ newPerformanceId +'/media/new');
    imagesDropzoneAdd.fadeIn();
    $(imagesDropzoneAdd).each(function(){
        new Dropzone(this);
    });
    $(getNewBlockPerformance).find('.perfomanceInfoEdiatable').editable({
        type: 'text',
        success: function(response, newValue) {
            $.ajax({
                type: "PATCH",
                url: '/profile/performance/' + newPerformanceId + '/edit',
                data: {"performance[techRequirement]": newValue}
            });
        }
    });
}

$('#addNewInputVideo').click(function(){
    var targetToAddField = $('#section-video .videoAddForm');
    $(targetToAddField).append('<input type="text" class="form-control videoAdd">')
});

$('#sendNewVideo').click(function(){
    var slug = $('#slug').text();
    $('#section-video .videoAddForm input').each(function(){
        var videoLink = $(this).val();
        postNewVideo(slug, videoLink)
    })
});

function postNewVideo(slug, videoLink){
    $.ajax({
        type: "POST",
        url: '/profile/'+ slug +'/media/new',
        data: {"video": videoLink}
    })
}

$('#sendNewAudio').click(function(){
    var slug = $('#slug').text();
    $('#section-audio .audioAddForm input').each(function(){
        var audioLink = $(this).val();
        postNewAudio(slug, audioLink)
    })
});

function postNewAudio(slug, audioLink){
    $.ajax({
        type: "POST",
        url: '/profile/'+ slug +'/media/new',
        data: {"audio": audioLink}
    })
}

function avatarUpload() {
    var $uploadCropAvatar;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $uploadCropAvatar.croppie('bind', {
                    url: e.target.result
                });
                $('.upload-demo').addClass('ready');
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCropAvatar = $('#changeImageModal .changeImageContiner').croppie({
        viewport: {
            width: 213,
            height: 213,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        },
        exif: true
    });
    var AvatarCurrent = $('.avatarEditable .avatar').attr('src');
    $uploadCropAvatar.croppie('bind', {
        url: AvatarCurrent
    });

    $('#uploadAvatar').on('change', function () { readFile(this); });
    $('.upload-resultAvatar').on('click', function (ev) {
        $uploadCropAvatar.croppie('result', {
            type: 'canvas',
            size: 'original'
        }).then(function (resp) {
            $.ajax({
                type: "PATCH",
                url: '/user/edit',
                data: {"user[avatar]": resp}
            })
            $('.avatarEditable .avatar').attr('src', resp)
        });
    });
    return;
}

$('#editAvatar').on('click', function() {
    $('.changeImageContiner').empty()
    avatarUpload()
});


$('#editBackground').on('click', function() {
    $('.changeImageContiner').empty()
    userBackgroundUpload()
});

function userBackgroundUpload(){
    var $uploadCropBackground;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $uploadCropBackground.croppie('bind', {
                    url: e.target.result
                });
                $('.upload-demo').addClass('ready');
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCropBackground = $('#changeBgModal .changeImageContiner').croppie({
        viewport: {
            width: 300,
            height: 150
        },
        boundary: {
            width: 400,
            height: 300
        },
        exif: true
    });

    var backgroundCurrentSrc = $('#bgImageSrc').text();
    console.log(backgroundCurrentSrc);
    $uploadCropBackground.croppie('bind', {
        url: backgroundCurrentSrc
    });


    $('#uploadBg').on('change', function () { readFile(this); });
    $('.upload-resultBg').on('click', function (ev) {
        $uploadCropBackground.croppie('result', {
            type: 'canvas',
            size: 'original'
        }).then(function (resp) {
            $.ajax({
                type: "PATCH",
                url: '/user/edit',
                data: {"user[background]": resp}
            });
            $('.header-background').css('background-image', 'url(' + resp + ')');
        });
    });
    return;
}

function getCheckedCategories(){
    var selectedCat = [];
    $('.artistCategories input:checked').each(function() {
        selectedCat.push($(this).attr('name'));
    });
    console.log(selectedCat);
    var slug = $('#slug').text();
    sendSelectedCategories(selectedCat, slug)
}

$('#saveCategories').click('click', function(){
    getCheckedCategories();
});
function sendSelectedCategories(selectedCat, slug){
    $.ajax({
        type: "PATCH",
        url: '/profile/' + slug + '/edit',
        data: {"profile[categories]": selectedCat}
    })
}
$(document).on('ready ajaxComplete', function(){
    $('.price-list .pagination a').on('click', function(event){
        event.preventDefault();
        if ($(this).hasClass('pageArrows')){
            var paginationLink = $(this).attr('href');
            var pageRoute = paginationLink.slice(-1);
        } else {
            var pageRoute = $(this).text();
        }
        var pageBaseRoute = $('#slug').text();
        var paginationRoute = pageBaseRoute + '/performance?page=' + pageRoute;
        var paginationTarget = $(".price-list");
        getPagination(paginationRoute, paginationTarget);
    });

    $('.feedbacks .pagination a').on('click', function(event){
        event.preventDefault();
        if ($(this).hasClass('pageArrows')){
            var paginationLink = $(this).attr('href');
            var pageRoute = paginationLink.slice(-1);
        } else {
            var pageRoute = $(this).text();
        }
        var pageBaseRoute = $('#slug').text();
        var paginationRoute = pageBaseRoute + '/feedback?page=' + pageRoute;
        var paginationTarget = $(".feedbacksContainer");
        getPagination(paginationRoute, paginationTarget);
    });

    function getPagination(paginationRoute, paginationTarget){
        $.get(paginationRoute, function( data ) {
            $(paginationTarget).html(data);
        });
    }
});