$(function () {

    InitializeAccordions();

    $('.categories-menu>li>a').click(function () {
        $(this).focus();
        var block = $(this).attr('data-toggle').replace('#', '');

        $('.categories-menu>li>a').removeClass('active');
        $('.categories-block').each(function() {
            if(block == $(this).attr('id')) {
                $(this).toggleClass('open');
            } else  {
                $(this).removeClass('open');
            }
        });

        var id = $(this).attr('data-toggle');
        $(this).addClass('active');
    });

    $('select').each(function () {
        var white = $(this).attr('data-class') == 'selections-white';
        var placeholder = $(this).attr('data-placeholder');
        var $select2 = $(this).select2({
            placeholder            : placeholder || '',
            minimumResultsForSearch: -1
        });

        if (white) {
            $select2.data('select2').$results.addClass('selections-white');
        }
    });

    $('.results-menu>li').each(function (index) {
        var count = $('.results-menu>li').length;
        $(this).css('z-index', count - index);
    });

    var slidersCount = $('.slider-wrapper').length;
    var panelWidth = 153;
    var sliderArea = $('.slider-block').width() - 70;
    var visiblePanels = parseInt(sliderArea/panelWidth);
    var margin = (sliderArea - panelWidth * visiblePanels) / visiblePanels;

    $('.slider-wrapper').bxSlider({
        slideWidth : panelWidth,
        minSlides  : 1,
        maxSlides  : 5,
        slideMargin: margin + 1,
        pager      : false,
        controls   : true,
        nextText   : '<i class="fa fa-2x fa-angle-right"></i>',
        prevText   : '<i class="fa fa-2x fa-angle-left"></i>',
        moveSlides : 1,
        infiniteLoop: false,
        onSliderLoad: function() {
            var viewportsCount = $('.bx-viewport').length;
            if(slidersCount == viewportsCount) {
                $('.bx-viewport').css('padding-left', margin/2+'px');
            }
        }
    });

    $('.tab').click(function () {
        $('.tab').removeClass('active');
        $(this).addClass('active');
        $('.tab-block').hide();
        var id = $(this).attr('data-toggle');
        $(id).show();
    });

    $('.header-block input').focus(function () {
        $(this).data('placeholder', $(this).attr('placeholder'))
            .attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).data('placeholder'));
    });

    function InitializeAccordions() {
        if ($(window).width() < 767) {
            $('.categories-menu li a').each(function () {
                var toggleBlockId = $(this).attr('data-toggle');
                $(toggleBlockId).removeClass('open').insertAfter(this);
            });

        }
    }

    resizeCards();

    function resizeCards () {
        var areaWidth = $('.tab-block').width();
        var cardWidth = $('.profile-card.mobile-horizontal').width();
        var visibleCards = parseInt(areaWidth / cardWidth);
        var cardMargin = (areaWidth - cardWidth * visibleCards) / visibleCards;

        console.log(areaWidth,cardWidth,visibleCards,cardMargin);

        $('.profile-card.mobile-horizontal').each(function() {
            $(this).css({
                'margin-left' : cardMargin/2 + 'px',
                'margin-right' : cardMargin/2 + 'px'
            })
        });
    }

    $(window).resize(function() {
        setTimeout(function() {
            resizeCards();
        }, 100);
    });
});