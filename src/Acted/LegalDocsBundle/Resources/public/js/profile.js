$(function() {

    $('.header-background').appendTo('header');

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

    $('#video-pager img').each(function(){
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
    }

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