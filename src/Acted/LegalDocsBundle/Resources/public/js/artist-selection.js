$(function(){
    'use strict';

    var slider = $('.slider .list'),
        slide = slider.find('li'),
        btnNext = $('.tabs-block .btn-next'),
        btnNextFake = $('.btn-next-fake'),
        select = $('.artist-selection select'),
        tabs = $('.tab'),
        tabLi = $('.tabs-block .list li'),
        categoryli = $('.categories-list li'),
        activeClass = 'active',
        artistSeletion = $('.artist-selection'),
        footer = $('footer'),
        header = $('header'),
        sliderWidth;


    slider.bxSlider({
        adaptiveHeight: true,
        mode          : 'horizontal',
        nextSelector  : '#nextSlide',
        prevSelector  : '#prevSlide',
        pager         : false,
        infiniteLoop  : false,
        moveSlides    : 1,
        hideControlOnEnd: true,
        onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
            $('.active-slide').removeClass('active-slide');
            slide.eq(currentSlideHtmlObject).addClass('active-slide');
            sliderWidth = parseInt(slider.closest('.tabs-block').css('paddingLeft')) + slider.closest('.tabs-block').offset().left + slider.closest('.tabs-block').width();
            if(slide.eq(slide.length - 1).offset().left + slide.eq(slide.length - 1).width() <= sliderWidth){
                btnNext.addClass('hide');
                btnNextFake.addClass('active');
            } else {
                btnNext.removeClass('hide');
                btnNextFake.removeClass('active');
            }
        },
        onSliderLoad: function () {
            slide.eq(0).addClass('active-slide');
        }
    });

    function initialize() {
        // if ("undefined" !== typeof google) {
        //     var myLatlng = new google.maps.LatLng(-34.397, 150.644);
        //     var myOptions = {
        //         zoom: 8,
        //         center: myLatlng,
        //         disableDefaultUI: true,
        //         mapTypeId: google.maps.MapTypeId.ROADMAP
        //     };
        //     var map = new google.maps.Map(document.getElementById("map"), myOptions);
        //     var marker = new google.maps.Marker({
        //         position: new google.maps.LatLng(-34.397, 150.644)
        //     });
        //     marker.setMap(map);
        // }
    }

    initialize();

    $('.artist-selection select').each(function () {
        var placeholder = $(this).attr('data-placeholder');
        var $select2    = $(this).select2({
            placeholder            : placeholder || '',
            minimumResultsForSearch: -1
        });

        var className = $(this).attr('data-class');
        $select2.data('select2').$selection.addClass(className);
        $select2.data('select2').$results.addClass(className);
    });

    select.change(function(){
        var opt = $(this).find(':selected'),
            sel = opt.text(),
            subIndex = opt.index(),
            name = opt.closest('optgroup').attr('label'),
            index = opt.closest('optgroup').index(),
            dataTog = tabLi.eq(index).attr('data-toggle'),
            id = '#' + dataTog;

        if(name !== 'Add Event'){
            tabLi.removeClass(activeClass);
            tabLi.eq(index).addClass(activeClass);
            tabs.removeClass(activeClass);
            $(id).addClass(activeClass);
            $(id).find('.categories-list li').removeClass(activeClass);
            $(id).find('.categories-list li').eq(subIndex).addClass(activeClass);
            $(id).find('.category-tab').removeClass(activeClass);
            $(id).find('.category-tab').eq(subIndex).addClass(activeClass);
        }
    });


    categoryli.on({
        'click': function(){
            var cur = $(this),
                curText = cur.text();

            setMainHeight();

            $('#select2-tabs_type-container').text(curText);
        }
    });

    tabLi.on({
        'click': function(){
            var cur = $(this),
                curData = cur.attr('data-toggle'),
                categotyText = $('#'+curData).find('.categories-list li.active').text();

            $('#select2-tabs_type-container').text(categotyText);
        }
    });

    $(window).on({
        'load resize orientationchange': function(){
            setMainHeight();
        }
    });

    $('#datepicker').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    function setMainHeight(){
        var footerHeight = footer.outerHeight(),
            headerHeight = header.outerHeight(),
            diffHeight = $(window).height() - footerHeight - headerHeight;

        artistSeletion.css('min-height', diffHeight);
    }
});