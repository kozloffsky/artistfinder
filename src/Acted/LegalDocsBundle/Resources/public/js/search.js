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

    $('.search select').each(function () {
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

    var blocksToShow = '';

    function getNumOfBlocksToShow(){
        var windowWidth = window.innerWidth;
        //console.log(windowWidth)
        if(windowWidth <= 991 && windowWidth >= 839){
            blocksToShow = 16;
        } else {
            blocksToShow = 15;
        }
    }
    getNumOfBlocksToShow();

    $('.header-background').appendTo('header.search');

    function selectBoxStyle() {
        $('.search select').each(function () {
            var white = $(this).attr('data-class') == 'selections-white';
            var placeholder = $(this).attr('data-placeholder');
            var $select2 = $(this).select2({
                placeholder: placeholder,
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
    };

    initSLiderRec();
    function initSLiderRec() {
        var retina = window.devicePixelRatio > 1;

        if(retina) {
            var panelWidth = 155;
            var margin = 25;
        } else {
            var panelWidth = 204;
            var margin = 11;
            /*var sliderArea = $('.container').width() - 70;
            console.log(sliderArea)
            var visiblePanels = parseInt(sliderArea/panelWidth);
            console.log(visiblePanels)
            var margin = (sliderArea - panelWidth * visiblePanels) / visiblePanels;*/

        }

        var countSlidersRecommended = $('.recommendationsTabContent .bx-viewport').length;
        //console.log(countSlidersRecommended)
        var slidersCount = $('.searchRecomendationWrapper').length;
        if(countSlidersRecommended == 0) {
            $('.searchRecomendationWrapper').bxSlider({
                slideWidth: panelWidth,
                minSlides: 1,
                maxSlides: 5,
                slideMargin: margin+ 2,
                pager: false,
                controls: true,
                nextText: '<i class="fa fa-2x fa-angle-right"></i>',
                prevText: '<i class="fa fa-2x fa-angle-left"></i>',
                moveSlides: 1,
                infiniteLoop: false,
                onSliderLoad: function () {
                    var viewportsCount = $('.recommendationsTabContent .bx-viewport').length;
                    if (slidersCount == viewportsCount) {
                        $('.recommendationsTabContent .bx-viewport').css('padding-left', margin / 2 + 'px');
                    }
                }
            });
        }
    }

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

    getRecStarts();

    function getRecStarts() {
        $('.profile-card').each(function () {
            var raiting = $(this).find('.raitingValRecomend').text();
            var raitingFull = raiting.toString().split(".")[0];
            var raitingDigits = raiting.toString().split(".")[1];
            var ratingstars = $(this).find('.user-rating .star');
            var getFullStars = $(ratingstars).slice(0, raitingFull);
            var getHalfStars = $(ratingstars).eq(raitingFull);
            $(getFullStars).children('.fill-star').css('width', '100%');
            $(getHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
        });
    }

    $('#search-country').on('change',getSearchRegions);

    $('.search input, .search select').on('change', function(){
        checkUserPosition()
    });

    function checkUserPosition(){
        var cityChosen = $('#eventLocationForm #region').val();
        //console.log(cityChosen)
        if(!cityChosen){
                $('.results select[name="distance"]').prop('disabled', true);
                $('#range-near').prop('disabled', true);
                $('label[for="range-near"]').css('opacity','0.7');
            } else {
                $('.results select[name="distance"]').prop('disabled', false);
                $('#range-near').prop('disabled', false);
                $('label[for="range-near"]').css('opacity','1');
            }
    }

    $('#country').on('change', function(){
        var selectedCountruOption = $(this).find('option:selected').val();
        chooseCity(selectedCountruOption);
    });

    $(document).ready(function() {
        var selectedCountruOption = $('#country').find('option:selected').val();
        chooseCity(selectedCountruOption);
    });

    function getSearchRegions(){
        var selectedCountruOption = $(this).find('option:selected').val();
        $.ajax({
            type:'GET',
            url: '/geo/region?_format=json&country=' + selectedCountruOption,
            success:function(response){
                $('#search-region').empty();
                $('#search-region').append('<option value="" name="region">select a region</option>');
                $(response).each(function(){
                    $('#search-region').append('<option value="'+ this.id +'" name="region">'+this.name+'</option>');
                    selectBoxStyle();
                });
            }
        });
       }

    function chooseCity(selectedCountruOption){
        if(selectedCountruOption) {
            $.ajax({
                type: 'GET',
                url: '/geo/city?_format=json&country=' + selectedCountruOption,
                success: function (response) {
                    $('#region').empty();
                    $('#region').append('<option value="" name="user_city">select a city</option>');
                    $(response).each(function () {
                        $('#region').append('<option value="' + this.id + '" name="user_city">' + this.name + '</option>');
                        selectBoxStyle();
                    });
                    checkUserPosition();
                }
            })
        }
    }

    $('.searchFormStart').on('click',function (e) {
        e.preventDefault();
        var searchFormSerialize = $('#searchLoc, #eventLocationForm, #searchCategory, #artistLocationSearch').serialize();
        //console.log(searchFormSerialize);
        getFilteredRes(searchFormSerialize)
        $('html,body').animate({
            scrollTop: $('.results').offset().top
        });
    });

    $('#search-region, #region, #searchCategory input, #artistLocationSearch input').on('change', function(){
        var searchFormSerialize = $('#searchLoc, #eventLocationForm, #searchCategory, #artistLocationSearch').serialize();
        //console.log(searchFormSerialize);
        getFilteredRes(searchFormSerialize);
    });

    function getFilteredRes(searchFormSerialize, searchResMain){
        $.ajax({
            type:'GET',
            url: '/batch/artist',
            data: searchFormSerialize + '&limit=' +blocksToShow,
            success: function(response){
                var checkedCategoriesFind = $('#searchCategory input:checkbox:checked').length;
                //console.log(checkedCategoriesFind);
                if(checkedCategoriesFind > 0 && !searchResMain) {
                    createNewFilterResults(response);
                } else {
                    searchResultMainCategories(response);
                }
            }
        })
    }

    $('#recomendedFilter select').on('change', function(){
        var filtersCatSelectGroup = $('#recomendedFilter select');
        //console.log(this.id);
        if (this.id == 'recFilterRating') {
            $('#recomendedFilter #recFilterPrice').prop("disabled", true);
        } else if (this.id == 'recFilterRating'){
            $('#recomendedFilter #recFilterRating').prop("disabled", true);
        }
        var recommendedCatFiltering = $('#recommendedCat, #recomendedFilter, #eventLocationForm').serialize();
        filtersCatSelectGroup.prop( "disabled", false );
        filterRecomended(recommendedCatFiltering);
    });

    $('#recomendedFilter input:checkbox').on('change', function(){
        $('#recomendedFilter select').prop( "disabled", true );
        var recommendedCatFiltering = $('#recommendedCat, #recomendedFilter, #eventLocationForm').serialize();
        $('#recomendedFilter select').prop( "disabled", false );
        filterRecomended(recommendedCatFiltering);
    });

/**/
    $('#recomendedFilterSearch select').on('change', function(){
        var filtersCatSelectGroup = $('#recomendedFilterSearch select');
        //console.log(this.id);
        var searchResTabMain = true;
        if (this.id == 'recFilterRating') {
            $('#recomendedFilterSearch #recFilterPrice').prop("disabled", true);
        } else if (this.id == 'recFilterRating'){
            $('#recomendedFilterSearch #recFilterRating').prop("disabled", true);
        }
        var searchAllCat = $('#searchLoc, #eventLocationForm, #artistLocationSearch, #recomendedFilterSearch').serialize()
        filtersCatSelectGroup.prop( "disabled", false );
        getFilteredRes(searchAllCat, searchResTabMain)
    });

    $('#recomendedFilterSearch input:checkbox').on('change', function(){
        //console.log('fgdgdfgfsdgf')
        var searchResTabMain = true;
        $('#recomendedFilter select').prop( "disabled", true );
        var searchAllCat = $('#searchLoc, #eventLocationForm, #artistLocationSearch, #recomendedFilterSearch').serialize()
        $('#recomendedFilter select').prop( "disabled", false );
        getFilteredRes(searchAllCat, searchResTabMain)
    });
/**/
    $('.catSearchResNew .filtersCat select').on('change mouseover', function(){
        var filtersCatSelectGroup = $('.filtersCat select');
        filtersCatSelectGroup.prop( "disabled", true );
        $(this).prop('disabled', false);
        var categoryFiltering = $(this).parents('.filters').attr('id');
        var mainCatS = true;
        catFilteringSearch(categoryFiltering, mainCatS);
    });

    $('.catSearchResNew .filtersCat input:checkbox').on('change', function(){
        var categoryFiltering = $(this).parents('.filters').attr('id');
        var mainCatS = true;
        catFilteringSearch(categoryFiltering, mainCatS);
    });

    function filterRecomended(recommendedCatFiltering){
        //console.log(recommendedCatFiltering)
        $.ajax({
            type:'GET',
            url: '/batch/artist',
            data: recommendedCatFiltering + '&recommended=1',
            success: function(response){
                recomendedSearchRes(response)
            }
        })
    }

    function searchResultMainCategories(response){
        //console.log(response);
        $('.SearchResultTab').remove();
        $('<li data-toggle="#tab-SearchResultTabContent" class="tab SearchResultTab tab recommendations">'+
            '<a>Search result</a>'+
            '<div class="deleteTabBlock"><span class="hidden">SearchResultTabContent</span><i class="fa fa-times-circle-o" aria-hidden="true"></i></div>'+
            '</li>').insertAfter('.results-menu .recommendations');
        $('.SearchResultTabContent .slider').remove();
        var searchResultTab = true;
        var searchResLength = [];
        loopSearchRes();
        function loopSearchRes(){
            for(var propt in response) {
                var elementsInCatCount = response[propt].length;
                searchResLength.push(elementsInCatCount);
                if(elementsInCatCount != 0) {
                    var searchCategoryId = propt,
                        searchCategoryName = $('.categories-menu a[data-toggle="#' + searchCategoryId + '"]').text(),
                        tabContentBlockRec = '<div class="slider">' +
                            '<h2 class="title" style="margin-top: 0px">' + searchCategoryName + '</h2>' +
                            '<div class="slider-block">' +
                            '<div class="slider-wrapper searchSearchResultWrapper" id="searchResWrapper' + searchCategoryId + '">' +
                            '</div>';
                    $(tabContentBlockRec).appendTo('#tab-SearchResultTabContent');
                    loopREcomendedArtistsInCat(response[propt], propt, searchResultTab);
                }
            }
        };
        var totalCategories = 0;
        $.each(searchResLength,function() {
            totalCategories += this;
        });
        //console.log(totalCategories)
        if(totalCategories == 0){
            var searchCat = 'SearchResultTabContent'
            noResInCat(searchCat);
        } else {
            $('#tab-SearchResultTabContent > .row .no-res-block').remove();
        }
        getRecStarts();
        checkUserPosition();
        setTabsCorenersZ();
        //console.log('finish');
        initTabs();
        //$('.recomendedFilter select').prop('disabled',false);
        initSLiderSearchRes();
        selectBoxStyle();

        $('.tab').removeClass('active');
        $('.SearchResultTab').addClass('active');
        $('.tab-block').hide();
        $('.SearchResultTabContent').show();
    }

    function recomendedSearchRes(response){
        //console.log(response);
        $('.recommendations .slider').remove();
        loopSearchRes();
        function loopSearchRes(){
            for(var propt in response) {
                var elementsInCatCount = response[propt].length;
                if (elementsInCatCount != 0) {
                    var searchCategoryId = propt,
                        searchCategoryName = $('#mainCategoryList').find('#' + searchCategoryId).text(),
                        tabContentBlockRec = '<div class="slider">' +
                            '<h2 class="title" style="margin-top: 0px">' + searchCategoryName + '</h2>' +
                            '<div class="slider-block">' +
                            '<div class="slider-wrapper searchRecomendationWrapper" id="searchRecWrapper' + searchCategoryId + '">' +
                            '</div>';
                    $(tabContentBlockRec).appendTo('.recommendationsTabContent');
                    loopREcomendedArtistsInCat(response[propt], propt);
                }
            }
        };

        getRecStarts();
        initSLiderRec();
        checkUserPosition();
        //$('.recomendedFilter select').prop('disabled',false);
    }

    function loopREcomendedArtistsInCat(artists, propt, searchResultTab){
        $(artists).each(function () {
            var artistCategories = this.categories,
                artistCatString = artistCategories.toString();
            //console.log(this.media.link);
            if(this.search_image){
                var imageSearchProf = '<img class="header" src="' + this.search_image + '"/>';
            } else{
                var imageSearchProf = '<img class="header" src="/media/cache/small' + this.media.link + '"/>';
            }
            if (this.video_media){
                var artistBlockSearch = '<div class=" profile-card bordered">' +
                    '<div class="video-icon"></div>' +
                    imageSearchProf +
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
                    '<span class="hidden raitingValRecomend">' + this.rating + '</span>' +
                    '</div>' +
                    '<div class="location">' + this.country + ', ' + this.city + '</div>' +
                    '<div class="talents">' + artistCatString + '</div>' +
                    '<div class="controls">' +
                    '<div class="button-gradient blue filled">' +
                    '<button data-dismiss="modal" class="btn"><a href="/profile/' + this.slug + '">Profile</a></button>' +
                    '</div>' +
                    '<div class="button-gradient blue ">' +
                    '<button data-dismiss="modal" class="btn askQuoteFromSearch" value="' + this.slug + '">Ask a free quote</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            } else {
                var artistBlockSearch = '<div class=" profile-card bordered">' +
                    imageSearchProf +
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
                    '<span class="hidden raitingValRecomend">' + this.rating + '</span>' +
                    '</div>' +
                    '<div class="location">' + this.country + ', ' + this.city + '</div>' +
                    '<div class="talents">' + artistCatString + '</div>' +
                    '<div class="controls">' +
                    '<div class="button-gradient blue filled">' +
                    '<button data-dismiss="modal" class="btn"><a href="/profile/' + this.slug + '">Profile</a></button>' +
                    '</div>' +
                    '<div class="button-gradient blue ">' +
                    '<button data-dismiss="modal" class="btn askQuoteFromSearch" value="' + this.slug + '">Ask a free quote</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }
            if (searchResultTab){
                $('#searchResWrapper'+propt+'').append(artistBlockSearch);
            } else {
                $('#searchRecWrapper'+propt+'').append(artistBlockSearch);
            }
            checkUserPosition();
        });
        preventAskQuoteFromArtist();
    }

    function createNewFilterResults(response){
        $('.tab-content .row').empty();
        removeOldTabs();
        loopSearchRes();
        function loopSearchRes(){
            for(var propt in response) {
                //$('#tab-'+propt+'').remove();
                var searchCategoryId = propt,
                    searchCategoryName = $('#searchCategories label[for="search'+ searchCategoryId +'"]').text(),
                    tabContentBlock = '<div id="tab-'+propt+'" class="tab-block tab-content" style="display: none; padding-bottom: 100px;">'+
                        '<div class="filters" id="'+propt+'">'+
                            '<form class="filtersCat">'+
                        '<select data-placeholder="Top rated" name="order">'+
                        '<option value="" disabled selected hidden>Rating</option>'+
                        '<option value="top_rated">Top rated</option>'+
                        '<option value="lowest_rated">Lowest rated</option>'+
                        '</select>'+
                        '<select data-palaceholder="Price" name="order">'+
                        '<option value="" disabled selected hidden>Price</option>'+
                        '<option value="cheapest">Cheapest</option>'+
                        '<option value="more_expensive">Most expensive</option>'+
                        '</select>'+
                        '<select data-palaceholder="Distance" name="distance">'+
                        '<option value="any">Any</option>'+
                        '<option value="80">From 0 to 50 miles</option>'+
                        '<option value="160">From 0 to 100 miles</option>'+
                        '<option value="321">From 0 to 200 miles</option>'+
                        '</select>'+
                        '<div class="custom-checkbox">'+
                        '<input type="checkbox" name="with_video" value="1" id="only-video'+propt+'">'+
                        '<label for="only-video'+propt+'">Only artists with video</label>'+
                            '</form>'+
                        '</div>'+
                        '</div>'+
                    '<div class="row">'+
                    '</div>'+
                    '</div>';

                var checkIfTabExist = $('#tab-'+propt+'').length;
                //console.log(checkIfTabExist)
                if(checkIfTabExist == 0) {
                    $(tabContentBlock).appendTo('.results-content > .container');
                }

                $('.results-menu').append('<li data-toggle="#tab-'+searchCategoryId+'" class="tab">'+
                    '<a>'+searchCategoryName+'</a>'+
                    '<div class="deleteTabBlock"><span class="hidden">'+searchCategoryId+'</span><i class="fa fa-times-circle-o" aria-hidden="true"></i></div>'+
                    '</li>');
                //console.log(response[propt].length)
                if (response[propt].length == 0){
                    noResInCat(propt)
                } else {
                    loopArtistsInCat(response[propt], propt);
                }
                createShowMoreBtn(propt);
                checkUserPosition();
            }
        };
        //setArtistStarsCat();
        setTabsCorenersZ();
        selectBoxStyle();
        //console.log('finish');
        initTabs();
        preventAskQuoteFromArtist()

        $('.filtersCat select').on('change mouseover', function(){
            var filtersCatSelectGroup = $('.filtersCat select');
            filtersCatSelectGroup.prop( "disabled", true );
            $(this).prop('disabled', false);
            var categoryFiltering = $(this).parents('.filters').attr('id');
            catFilteringSearch(categoryFiltering);
        });

        $('.filtersCat input:checkbox').on('change', function(){
            var categoryFiltering = $(this).parents('.filters').attr('id');
            catFilteringSearch(categoryFiltering);
        });
        checkUserPosition();
    }

    function createShowMoreBtn(propt, mainCatS){
        setTimeout(function() {
            var countCardsInCat = $('#tab-'+propt+' .row .categoriesCardsSearch').length;
            //console.log(countCardsInCat);
            if (countCardsInCat == blocksToShow){
                $('#tab-'+propt+' .row').append('<div class="controls show-more">'+
                    '<div class="button-gradient">'+
                    '<button data-dismiss="modal" class="btn">Show more</button>'+
                '</div>'+
                '</div>');
            } else {
                $('#tab-'+propt+' .row .show-more').remove();
            }
            $('#tab-'+propt+' .row .show-more').on('click',function(){
                catFilteringSearchInfinite(propt, mainCatS);
            });
        }, 2000)
    }

    function noResInCat(propt){
        $('#tab-' + propt + ' > .row .no-res-block').remove();
        var noResBlock = '<div class="no-res-block"><h1>No results matching your criteria</h1></div>'
        $('#tab-' + propt + ' > .row').append(noResBlock);
        checkUserPosition();
    }

    function loopArtistsInCat(artists, propt) {
        //console.log(propt)

        $(artists).each(function () {
            var artistCategories = this.categories,
                artistCatString = artistCategories.toString();
            //console.log(this.media.link);
            if(this.search_image){
                var imageSearchProf = '<img class="header" src="' + this.search_image + '"/>';
            } else{
                var imageSearchProf = '<img class="header" src="/media/cache/small' + this.media.link + '"/>';
            }
            if (this.video_media) {
                var artistBlockSearch = '<div class="profile-card categoriesCardsSearch mobile-horizontal">' +
                    '<div class="video-icon"></div>' +
                    imageSearchProf +
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
                    '<button data-dismiss="modal" class="btn"><a href="/profile/' + this.slug + '">Profile</a></button>' +
                    '</div>' +
                    '<div class="button-gradient blue ">' +
                    '<button data-dismiss="modal" class="btn askQuoteFromSearch" value="' + this.slug + '">Ask a free quote</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            } else {
                var artistBlockSearch = '<div class="profile-card categoriesCardsSearch mobile-horizontal">' +
                    imageSearchProf +
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
                    '<button data-dismiss="modal" class="btn"><a href="/profile/' + this.slug + '">Profile</a></button>' +
                    '</div>' +
                    '<div class="button-gradient blue ">' +
                    '<button data-dismiss="modal" class="btn askQuoteFromSearch" value="' + this.slug + '">Ask a free quote</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }
            $('#tab-' + propt + ' > .row').append(artistBlockSearch);
        });
        setArtistStarsCat();
        checkUserPosition();
        preventAskQuoteFromArtist();
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

    function catFilteringSearch(categoryFiltering, mainCats){
        //console.log(categoryFiltering)
        var formsWithoutCat = $('#searchLoc, #eventLocationForm, #artistLocationSearch, #'+categoryFiltering+' .filtersCat').serialize();
        //var catFilteringSerialize = $('#'+categoryFiltering+' .filtersCat').serialize();
        $('.filtersCat select').prop( "disabled", false );
        ///console.log(mainCats);
        if(mainCats){
            var datasendSearch = formsWithoutCat + '&mainCategory=' + categoryFiltering;
        } else {
            var datasendSearch = formsWithoutCat + '&categories%5B%5D=' + categoryFiltering;
        }
        $.ajax({
            type:'GET',
            url: '/artist',
            data: datasendSearch + '&limit=' + blocksToShow,
            success: function(response){
                //console.log(response);
                $('#tab-'+categoryFiltering+' > .row .categoriesCardsSearch, #tab-'+categoryFiltering+' > .row .no-res-block, #tab-'+categoryFiltering+' > .row .show-more').remove();
                //console.log(response.length)
                if (response.length == 0){
                    noResInCat(categoryFiltering)
                } else {
                    loopArtistsInCat(response, categoryFiltering);
                    if(mainCats){
                        createShowMoreBtn(categoryFiltering, mainCats);
                    } else {
                        createShowMoreBtn(categoryFiltering);
                    }
                }
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

    function catFilteringSearchInfinite(categoryFiltering, mainCatS){
        var formsWithoutCat = $('#searchLoc, #eventLocationForm, #artistLocationSearch').serialize(),
            countElementsReady = $('#tab-'+categoryFiltering+' > .row .categoriesCardsSearch').length,
            categorySorting = $('#tab-'+categoryFiltering+' > .filters form').serialize(),
            getCurrentPage = countElementsReady / blocksToShow,
            pageMath = Math.floor(getCurrentPage),
            pageNumberToLoad = pageMath + 1;
            //console.log(infiniteScrollCheckPage);
        if (infiniteScrollCheckPage != pageNumberToLoad) {
            infiniteScrollCheckPage = pageNumberToLoad;
            //console.log(infiniteScrollCheckPage);
            if(mainCatS){
                var datasendSearch = formsWithoutCat + '&mainCategory=' + categoryFiltering + '&' + categorySorting + '&page=' + pageNumberToLoad;
            } else {
                var datasendSearch = formsWithoutCat + '&categories%5B%5D=' + categoryFiltering +'&'+ categorySorting + '&page=' + pageNumberToLoad;
            }
            $.ajax({
                type: 'GET',
                url: '/artist',
                data: datasendSearch + '&limit=' +blocksToShow,
                success: function (response) {
                    //console.log(response);
                    $('#tab-' + categoryFiltering + ' > .row .show-more').remove();
                    loopArtistsInCat(response, categoryFiltering);
                    startInfiniteScroll(categoryFiltering, mainCatS);
                }
            });
        }
    }

    function startInfiniteScroll(categoryFiltering, mainCatS) {
        $(window).scroll(function() {
            if ($('.social-icons').isVisible()) {
                catFilteringSearchInfinite(categoryFiltering, mainCatS);
            }
            return false;
        });
    }

    function removeOldTabs() {
        $('.results-menu li').not('.recommendations, .searchMainResTab').remove();
    }

    $(document).ready(function() {
        var currentUrl = window.location.pathname;
        var matchesUrl = currentUrl.split('/');
        if (matchesUrl[1] == 'search'){
            var searchCatName = matchesUrl[2];
        }
        if (searchCatName){
            findSearchMainCat(searchCatName)
        } else {
            //console.log(searchCatName)
        }
    })

    function findSearchMainCat(searchCatName) {
        var searchMainCatId = $('#mainCategoryList').find('#' + searchCatName).text();
        //console.log('searchMainCategory')
        $.ajax({
            type: 'GET',
            url: '/artist',
            data: {'mainCategory': searchMainCatId, 'limit': blocksToShow},
            success: function (response) {
                //console.log(response);
                catSearchRes(searchCatName, searchMainCatId, response);
            }
        })
    }

    function catSearchRes(searchCatName, searchMainCatId, response){
        //console.log(searchCatName)
        var destinationTab = 'catSearchResNew',
            searchCategoryName = $('.categories-menu a[data-toggle="#' + searchMainCatId + '"]').text();
        var mainCatS = true;
        $('.results-menu').append('<li data-toggle="#tab-'+searchMainCatId+'" class="tab '+searchMainCatId+'Tab searchMainResTab">'+
            '<a>'+searchCategoryName+'</a>'+
            '<div class="deleteTabBlock"><span class="hidden">'+searchMainCatId+'</span><i class="fa fa-times-circle-o" aria-hidden="true"></i></div>'+
            '</li>');
        $('.catSearchResNew').attr('id', 'tab-'+searchMainCatId+'');
        $('.catSearchResNew .filters').attr('id', ''+searchMainCatId+'');
        loopArtistsInCat(response, searchMainCatId);

        if (response.length == 0){
            noResInCat(searchMainCatId)
        }

        $('html,body').animate({
            scrollTop: $('.results').offset().top
        });

        setTabsCorenersZ();
        selectBoxStyle();
        //console.log('finish');
        initTabs();

        $('.tab').removeClass('active');
        $('.'+searchMainCatId+'Tab').addClass('active');
        $('.tab-block').hide();
        var idContent = $('.'+searchMainCatId+'Tab').attr('data-toggle');
        $(idContent).show();

        checkUserPosition();
        createShowMoreBtn(searchMainCatId, mainCatS);
    }

    function deleteTabSearch() {
        $('.deleteTabBlock').on('click', function (event) {
            event.stopPropagation();
            var clickedBlockDel = this,
                tabContentToDel = $(clickedBlockDel).find('span').text(),
                tabBlock = $(clickedBlockDel).parent('.tab');
            //console.log(tabBlock.hasClass('active'));
            if(tabBlock.hasClass('active')){
                $('.tab').removeClass('active');
                $('.recommendedTab').addClass('active');
                $('.tab-block').hide();
                $('.recommendationsTabContent').show();
                $(tabBlock).hide();
                $('#search'+tabContentToDel+'').prop('checked', false)
            } else {
                //$('.tab').removeClass('active');
                //$('.recommendedTab').addClass('active');
                $('#tab-'+tabContentToDel+'').hide();
                //$('.recommendationsTabContent').show();
                $(tabBlock).hide();
                $('#search'+tabContentToDel+'').prop('checked', false)
            }
        })
    }

    setTimeout(getSearchQuery, 3000);

    function getSearchQuery(){
        var enteredQuery = localStorage.getItem('search');
        if(enteredQuery) {
            $('#searchQuery').val(enteredQuery);
            localStorage.removeItem('search');
            $('.searchFormStart').click();
            $('html,body').animate({
                scrollTop: $('.results').offset().top
            });
        }
    }

    preventAskQuoteFromArtist()

    function preventAskQuoteFromArtist(){
        var checkIfUserLoggedIn = $('header #userInformation').length;
        if(checkIfUserLoggedIn > 0){
            var userInformationStorage = JSON.parse(localStorage.getItem('user'));
            if(userInformationStorage) {
                if (userInformationStorage.role[0] == 'ROLE_ARTIST') {
                    $('.askQuoteFromSearch').parent('div').css('visibility','hidden');
                    $('.requestQuotePerformance').hide();
                    $('.quoteRequestProfile').hide();
                }
            }
        }
    }

    $('#searchCategory input').on('change',function(){
        var searchCategoryId = this.value;
        var catPostion = $(this).prop( "checked" );
        //console.log(catPostion);
        if(catPostion){
            setTimeout(function(){
                setActiveTab(searchCategoryId);
            }, 1500);
            /*$( document).on('ajaxComplete',function() {
                setActiveTab(searchCategoryId);
            });*/
        }
    });

    function setActiveTab(searchCategoryId){
        //console.log('fdfdfd')
        $('.tab').removeClass('active');
        $('.results-menu li[data-toggle="#tab-' + searchCategoryId + '"]').addClass('active');
        $('.tab-block').hide();
        $('.results-content #tab-'+searchCategoryId+'').show();
    }
});