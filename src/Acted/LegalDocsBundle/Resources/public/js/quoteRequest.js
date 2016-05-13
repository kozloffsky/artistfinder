/**
 * Created by pavel on 12.05.16.
 */
$(function () {

    $( "#event_date" ).datepicker();

    function initSelect(){
        $('select').each(function () {
            var placeholder = $(this).attr('data-placeholder');
            var $select2    = $(this).select2({
                placeholder            : placeholder || '',
                minimumResultsForSearch: -1
            });

            var className = $(this).attr('data-class');
            $select2.data('select2').$selection.addClass(className);
            $select2.data('select2').$results.addClass(className);
        });
    }

    $('#comment_toggle').click(function (e) {
        e.preventDefault();
        $('#comment_area').toggle();
    });

    addValuesInQuoteRequest();

    function addValuesInQuoteRequest(){
        getAllEventsType();
        getAllVenuesType();
    }

    function getAllEventsType() {
        $.ajax({
            type: "GET",
            url: '/event/list_events_type',
            success: function(response) {
                $(response.eventsType).each(function(){
                    $('.free-quote-modal #event_type').append('<option value="'+ this.id +'" name="type">'+this.event_type+'</option>');
                    initSelect();
                });
            }
        })
    }

    function getAllVenuesType() {
        $.ajax({
            type: "GET",
            url: '/event/list_venue_type',
            success: function(response) {
                $(response.venueType).each(function(){
                    $('.free-quote-modal #venue_type').append('<option value="'+ this.id +'" name="venue_type">'+this.venue_type+'</option>');
                    initSelect();
                });
            }
        })
    }

    $('.quoteRequestProfile').on('click',function(){
        var artistSlug = $('#slug').text();
        getArtistInformationForQuote(artistSlug)
    });

    function getArtistInformationForQuote(artistSlug){
        $.ajax({
            type: "GET",
            url: '/info/artist/' + artistSlug,
            success: function(response) {
                createRequestQuotePerformances(response.artist);
                createArtistDataViewInQuote(response.artist);
            }
        })
    }

    function createRequestQuotePerformances(artistData){
        $('.requestQuotePerformances').empty();
        $(artistData.allPerformance).each(function(){
            var blockPerformance = '<li>'+
                '<div class="custom-checkbox">'+
                '<input id="'+this.id+'" type="checkbox" name="performance[]" value="'+this.id+'">'+
                '<label for="'+this.id+'">'+this.name+'</label>'+
                '</div>'+
                '</li>';
            $('.requestQuotePerformances').append(blockPerformance);
        })
    }

    function createArtistDataViewInQuote(artistData){
        var artistCatString = artistData.categories.toString();
        $('.quoteRequestArtistData .quote-profile-info h2').html(artistData.name);
        $('.quoteRequestArtistData .quote-profile-info p').html(artistCatString);
        $('.quote-profile-avatar').attr('src', artistData.user.avatar);
    }

    $(document).ready(function() {
        var selectedCountruOption = $('#event_country').find('option:selected').val();
        chooseCityQuote(selectedCountruOption);
    });

    $('#event_country').on('change',function(){
        var selectedCountruOption = $('#event_country').find('option:selected').val();
        chooseCityQuote(selectedCountruOption);
    });

    function chooseCityQuote(selectedCountruOption){
        $.ajax({
            type:'GET',
            url: '/geo/city?_format=json&country=' + selectedCountruOption,
            success:function(response){
                $('#event_city').empty();
                $(response).each(function(){
                    $('#event_city').append('<option value="'+ this.id +'" name="city">'+this.name+'</option>');
                });
                initSelect();
            }
        })
    }

    $('#quoteRequsetSend').on('click',function(e){
        e.preventDefault();
        var requestFormSerialize = $('#requestQuoteForm').serialize(),
            userInformationStorage = JSON.parse(localStorage.getItem('user')),
            checkUserLoggedIn = $('#userInformation').text();
        console.log(userInformationStorage);
        console.log(checkUserLoggedIn);
        if(checkUserLoggedIn && userInformationStorage){
            sendQuoteRequest(requestFormSerialize, userInformationStorage);
        } else {

        }

    });

    function sendQuoteRequest(data, userInformationStorage){
        console.log(data)
        $.ajax({
            type:'POST',
            url:'/event/create',
            data: data + '&user='+userInformationStorage.userId
        })
    };
});