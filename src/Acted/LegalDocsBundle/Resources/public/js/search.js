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



    function selectBoxStyle() {
        $('select').each(function () {
            var white = $(this).attr('data-class') == 'selections-white';
            var placeholder = $(this).attr('data-placeholder');
            var $select2 = $(this).select2({
                placeholder: placeholder || '',
                minimumResultsForSearch: -1
            });

            if (white) {
                $select2.data('select2').$results.addClass('selections-white');
            }
        });
    }

    selectBoxStyle();

    function setTabsCorenersZ() {
        $('.results-menu>li').each(function (index) {
            var count = $('.results-menu>li').length;
            $(this).css('z-index', count - index);
        });
    }

    var slidersCount = $('.slider-wrapper').length;
    var panelWidth = 204;
    var sliderArea = $('.slider-block').width() - 80;
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

    function initTabs() {
        $('.tab').click(function () {
            $('.tab').removeClass('active');
            $(this).addClass('active');
            $('.tab-block').hide();
            var id = $(this).attr('data-toggle');
            $(id).show();
        });
    }

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

        //console.log(areaWidth,cardWidth,visibleCards,cardMargin);

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

    $('.profile-card').each(function(){
        var raiting = $(this).find('.raitingValRecomend').text();
        var raitingFull = raiting.toString().split(".")[0];
        var raitingDigits = raiting.toString().split(".")[1];
        var ratingstars = $(this).find('.user-rating .star');
        var getFullStars = $(ratingstars).slice(0, raitingFull);
        var getHalfStars = $(ratingstars).eq(raitingFull);
        $(getFullStars).children('.fill-star').css('width', '100%');
        $(getHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
    });

    $('#search-country').on('change',getSearchRegions);

    $('#country').on('change',chooseRegion);


    function getSearchRegions(){
        var selectedCountruOption = $(this).find('option:selected').val();
        $.ajax({
            type:'GET',
            url: '/geo/region?_format=json&country=' + selectedCountruOption,
            success:function(response){
                $('#search-region').empty();
                $(response).each(function(){
                    $('#search-region').append('<option value="'+ this.id +'" name="region">'+this.name+'</option>');
                    selectBoxStyle();
                });
            }
        })
    }

    function chooseRegion(){
        var selectedCountruOption = $(this).find('option:selected').val();
        $.ajax({
            type:'GET',
            url: '/geo/region?_format=json&country=' + selectedCountruOption,
            success:function(response){
                $('#region').empty();
                $(response).each(function(){
                    $('#region').append('<option value="'+ this.id +'" name="user_region">'+this.name+'</option>');
                    selectBoxStyle();
                });
            }
        })
    }

    $('#search-region, #region, #searchCategory input, #artistLocationSearch input').on('change', function(){
        var searchFormSerialize = $('#searchLoc, #eventLocationForm, #searchCategory, #artistLocationSearch').serialize()
        console.log(searchFormSerialize);
        getFilteredRes(searchFormSerialize)
    });

    function getFilteredRes(searchFormSerialize){
        $.ajax({
            type:'GET',
            url: '/batch/artist',
            data: searchFormSerialize,
            success: function(response){
                createNewFilterResults(response);
            }
        })
    }

    function createNewFilterResults(response){
        var t0 = performance.now(),
            tabContentBlock = $('.searchTabContent').clone();
        //$('.tab-content .row').empty();
        removeOldTabs();
        $('.tab-content .row').empty();
        loopSearchRes();
        function loopSearchRes(){
            for(var propt in response) {
                var searchCategoryId = propt,
                    searchCategoryName = $('#searchCategories label[for="search'+ searchCategoryId +'"]').text();
                console.log(searchCategoryId);
                $(tabContentBlock).attr('id', 'tab-'+propt)
                    .removeClass('searchTabContent')
                    .appendTo('.results-content > .container');

                $('.results-menu').append('<li data-toggle="#tab-'+searchCategoryId+'" class="tab">'+
                    '<a>'+searchCategoryName+'</a>'+
                    '</li>');
                //console.log(response[propt]);
                $(response[propt]).each(function(){
                    console.log(propt +'prop');
                    console.log(this)
                    var artistCategories = this.categories,
                        artistCatString = artistCategories.toString(),
                        artistBlockSearch = '<div class="profile-card categoriesCardsSearch mobile-horizontal">' +
                        '<div class="video-icon"></div>' +
                        '<img class="header" src="' + this.media.link + '"/>' +
                        '<p class="card-title">' + this.name + '</p>' +
                        '<div class="user-rating clearfix">' +
                        '<div class="stars">' +
                        '<div class="star">' +
                        '<div class="fill-star"></div>' +
                        '</div>' +
                        '<div class="star">' +
                        '<div class="fill-star"></div>' +
                        '</div>' +
                        '<div class="star">' +
                        '<div class="fill-star"></div>' +
                        '</div>' +
                        '<div class="star">' +
                        '<div class="fill-star"></div>' +
                        '</div>' +
                        '<div class="star">' +
                        '<div class="fill-star"></div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="rating">' + this.rating + '/5.0 (' + this.votes_count + ' Votes)</div>' +
                        '<span class="hidden catArtistRatingVal">' + this.rating + '</span>' +
                        '</div>' +
                        '<div class="location">' + this.country + ', ' + this.city + '</div>' +
                        '<div class="talents">' + artistCatString + '</div>' +
                        '<div class="controls">' +
                        '<div class="button-gradient blue filled">' +
                        '<button data-dismiss="modal" class="btn">Profile</button>' +
                        '</div>' +
                        '<div class="button-gradient blue ">' +
                        '<button data-dismiss="modal" class="btn">Ask a free quote</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $('#tab-'+ propt +' > .row').append(artistBlockSearch);
                    console.log(artistBlockSearch);
                    //console.log($('#tab-'+ propt +' .row'));
                });
            }
        };

        setArtistStarsCat();
        setTabsCorenersZ();
        //console.log('finish');
        initTabs();
        var t1 = performance.now();
        console.log("Call to doSomething took " + (t1 - t0) + " milliseconds.")
    }

    function setArtistStarsCat(){
        $('.categoriesCardsSearch').each(function(){
            var raiting = $(this).find('.catArtistRatingVal').text();
            var raitingFull = raiting.toString().split(".")[0];
            var raitingDigits = raiting.toString().split(".")[1];
            var ratingstars = $(this).find('.user-rating .star');
            var getFullStars = $(ratingstars).slice(0, raitingFull);
            var getHalfStars = $(ratingstars).eq(raitingFull);
            $(getFullStars).children('.fill-star').css('width', '100%');
            $(getHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
        });
    }

    function removeOldTabs(){
        $('.results-menu li').not('.recommendations').remove();
    }

});