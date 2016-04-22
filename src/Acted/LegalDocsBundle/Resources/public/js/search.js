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
        });
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
        $('.tab-content .row').empty();
        removeOldTabs();
        loopSearchRes();
        function loopSearchRes(){
            for(var propt in response) {
                var searchCategoryId = propt,
                    searchCategoryName = $('#searchCategories label[for="search'+ searchCategoryId +'"]').text(),
                    tabContentBlock = '<div id="tab-'+propt+'" class="tab-block tab-content" style="display: none; padding-bottom: 100px;">'+
                        '<div class="filters" id="'+propt+'">'+
                            '<form class="filtersCat">'+
                        '<select data-placeholder="Top rated" name="order">'+
                        '<option value="top_rated">Top rated</option>'+
                        '<option value="lowest_rated">Lowest rated</option>'+
                        '<option value="2">Lorem Ipsum</option>'+
                        '</select>'+
                        '<select data-palaceholder="Price" name="order">'+
                        //'<option value="">Price</option>'+
                        '<option value="cheapest">Cheapes</option>'+
                        '<option value="more_expensive">Most expensive</option>'+
                        '</select>'+
                        '<select data-palaceholder="Distance" name="distance">'+
                        '<option value="50">From 0 to 50km</option>'+
                        '<option value="200">From 50 to 200km</option>'+
                        '<option value="1000">From 200km to 1000km</option>'+
                        '</select>'+
                        '<div class="custom-checkbox">'+
                        '<input type="checkbox" name="range" id="only-video1">'+
                        '<label for="only-video1">Only artists with video</label>'+
                            '</form>'+
                        '</div>'+
                        '</div>'+
                    '<div class="row">'+
                    '</div>'+
                    '</div>';
                $(tabContentBlock).appendTo('.results-content > .container');

                $('.results-menu').append('<li data-toggle="#tab-'+searchCategoryId+'" class="tab">'+
                    '<a>'+searchCategoryName+'</a>'+
                    '</li>');
                loopArtistsInCat(response[propt], propt);
                createShowMoreBtn(propt);
            }
        };
        //setArtistStarsCat();
        setTabsCorenersZ();
        selectBoxStyle();
        //console.log('finish');
        initTabs();

        $('.filtersCat select').on('change', function(){
            var filtersCatSelectGroup = $('.filtersCat select');
            filtersCatSelectGroup.prop( "disabled", true );
            $(this).prop('disabled', false);
            var categoryFiltering = $(this).parents('.filters').attr('id');
            catFilteringSearch(categoryFiltering);
        });
    }

    function createShowMoreBtn(propt){
        var countCardsInCat = $('#tab-'+propt+' .row .categoriesCardsSearch').length;
        console.log(countCardsInCat);
        if (countCardsInCat == 15){
            $('#tab-'+propt+' .row').append('<div class="controls show-more">'+
                '<div class="button-gradient">'+
                '<button data-dismiss="modal" class="btn">Show more</button>'+
            '</div>'+
            '</div>');
        }
        $('#tab-'+propt+' .row .show-more').on('click',function(){
            catFilteringSearchInfinite(propt);
        });
    }

    function loopArtistsInCat(artists, propt) {
        console.log(artists)
        $(artists).each(function () {
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
            $('#tab-' + propt + ' > .row').append(artistBlockSearch);
        });
        setArtistStarsCat();
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

    function catFilteringSearch(categoryFiltering){
        var formsWithoutCat = $('#searchLoc, #eventLocationForm, #artistLocationSearch, #'+categoryFiltering+' .filtersCat').serialize();
        //var catFilteringSerialize = $('#'+categoryFiltering+' .filtersCat').serialize();
        $('.filtersCat select').prop( "disabled", false );
        console.log(categoryFiltering);
        $.ajax({
            type:'GET',
            url: '/artist',
            data: formsWithoutCat + '&categories%5B%5D=' + categoryFiltering,
            success: function(response){
                //console.log(response);
                $('#tab-'+categoryFiltering+' > .row .categoriesCardsSearch').remove();
                loopArtistsInCat(response,categoryFiltering);
            }
        });
    }

    $.fn.isVisible = function() {
        var rect = this[0].getBoundingClientRect();
        return (
            (rect.height > 0 || rect.width > 0) &&
            rect.bottom >= 0 &&
            rect.right >= 0 &&
            rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.left <= (window.innerWidth || document.documentElement.clientWidth)
        );
    };

    var infiniteScrollCheckPage = {};

    function catFilteringSearchInfinite(categoryFiltering){
        var formsWithoutCat = $('#searchLoc, #eventLocationForm, #artistLocationSearch').serialize(),
            countElementsReady = $('#tab-'+categoryFiltering+' > .row .categoriesCardsSearch').length,
            getCurrentPage = countElementsReady / 15,
            pageMath = Math.floor(getCurrentPage),
            pageNumberToLoad = pageMath + 1;
            console.log(infiniteScrollCheckPage);
        if (infiniteScrollCheckPage != pageNumberToLoad) {
            infiniteScrollCheckPage = pageNumberToLoad;
            console.log(infiniteScrollCheckPage);
            $.ajax({
                type: 'GET',
                url: '/artist',
                data: formsWithoutCat + '&categories%5B%5D=' + categoryFiltering + '&page=' + pageNumberToLoad,
                success: function (response) {
                    //console.log(response);
                    $('#tab-' + categoryFiltering + ' > .row .show-more').remove();
                    loopArtistsInCat(response, categoryFiltering);
                    startInfiniteScroll(categoryFiltering);
                }
            });
        }
    }

    function startInfiniteScroll(categoryFiltering){
        $(window).scroll(function() {
            if ($('.social-icons').isVisible()) {
                catFilteringSearchInfinite(categoryFiltering);
            }
            return false;
        });
    }

    function removeOldTabs(){
        $('.results-menu li').not('.recommendations').remove();
    }

});