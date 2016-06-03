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
                });
                initSelect();
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
                });
                initSelect();
            }
        })
    }

    $('.quoteRequestProfile').on('click',function(){
        var artistSlug = $('#slug').text();
        getArtistInformationForQuote(artistSlug);
        $('#freeQuoteModal').modal('show');
    });

    $('.askQuoteFromSearch').on('click',function(){
        var artistSlug = $(this).val();
        getArtistInformationForQuote(artistSlug);
        $('#freeQuoteModal').modal('show');
    });

    $('.requestQuotePerformance').on('click',function(){
        var artistSlug = $('#slug').text();
        var performanceRequestId = $(this).val();
        console.log(performanceRequestId)
        getArtistInformationForQuote(artistSlug, performanceRequestId)
        $('#freeQuoteModal').modal('show');
    })

    function getArtistInformationForQuote(artistSlug, performanceRequestId){
        $.ajax({
            type: "GET",
            url: '/info/artist/' + artistSlug,
            success: function(response) {
                createRequestQuotePerformances(response.artist, performanceRequestId);
                createArtistDataViewInQuote(response.artist);
            }
        })
    }

    function createRequestQuotePerformances(artistData, performanceRequestId){
        $('.requestQuotePerformances').empty();
        $(artistData.allPerformance).each(function(){
            var blockPerformance = '<li>'+
                '<div class="custom-checkbox">'+
                '<input id="'+this.id+'" type="checkbox" name="performance[]" value="'+this.id+'">'+
                '<label for="'+this.id+'">'+this.name+'</label>'+
                '</div>'+
                '</li>';
            $('.requestQuotePerformances').append(blockPerformance);
        });
        if(performanceRequestId){
            $('.requestQuotePerformances input#'+performanceRequestId).prop('checked', true);
        }
    }

    function createArtistDataViewInQuote(artistData){
        console.log(artistData)
        var artistCatString = artistData.categories.toString();
        $('.quoteRequestArtistData .quote-profile-info h2').html(artistData.name);
        $('.quoteRequestArtistData .quote-profile-info p').html(artistCatString);
        $('.quote-profile-avatar').attr('src', artistData.user.avatar);
    }

    $(document).ready(function() {
        var selectedCountruOption = $('#event_country').find('option:selected').val();
        chooseCityQuote(selectedCountruOption);
        prepareEventRequestForm()
    });

    $('#requestQuoteForm #event_country').on('change',function(){
        var selectedCountruOption = $('#event_country').find('option:selected').val();
        chooseCityQuote(selectedCountruOption);
    });

    function prepareEventRequestForm(){
        var checkIfUserLoggedIn = $('header #userInformation').length;
        console.log(checkIfUserLoggedIn)
        if(checkIfUserLoggedIn > 0){
            var userInformationStorage = JSON.parse(localStorage.getItem('user'));
            if(userInformationStorage) {
                if (userInformationStorage.role[0] == 'ROLE_CLIENT') {
                    getUserEvents(userInformationStorage)
                }
            }
        }
        else {
            localStorage.removeItem('user');
            $('.eventChooseRequest').hide();
        }
    }

    function getUserEvents(userInf){
        var userId = userInf.userId
        $.ajax({
            type:'GET',
            url:'/event/user_events?user='+userId,
            success: function(response){
                console.log(response)
                var userEvents = response.events;
                console.log(userEvents.length)
                if(userEvents.length > 0){
                    createEventsListRequest(userEvents)
                }
            }
        })
    }

    function createEventsListRequest(userEvents){
        $(userEvents).each(function(){
            var eventsOptions='<option value="'+ this.event.id +'" name="event">'+this.event.title+'</option>';
            $('#event_preset').append(eventsOptions);
        })
        initSelect();
        $('.eventUnregistered').hide();
        $('#requestQuoteForm .modal-body').hide();
        $('#requestQuoteForm .modal-body').addClass('choosePrevEvent');
    }

    $('#new-event').on('click',function(){
        $('#requestQuoteForm .modal-body').slideDown();
        $('#requestQuoteForm .modal-body').removeClass('choosePrevEvent');
        $('#requestQuoteForm .modal-body').addClass('newEventRegistered');
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
        var requestFormSerialize = $('#requestQuoteForm, #quoteRequestSecond').serialize(),
            userInformationStorage = JSON.parse(localStorage.getItem('user')),
            checkUserLoggedIn = $('#userInformation').text(),
            prevEventChosen = $('#requestQuoteForm .modal-body').hasClass('choosePrevEvent');
        console.log(prevEventChosen)
        if(checkUserLoggedIn && userInformationStorage && prevEventChosen == false){
            sendQuoteRequest(requestFormSerialize, userInformationStorage);
        } else if (!checkUserLoggedIn){
            localStorage.setItem("quoteRequest", requestFormSerialize);
            $('#freeQuoteModal').modal('hide');
            $('#registrationModal').modal('show');
            showSecondPage();
        } else if(prevEventChosen == true && checkUserLoggedIn && userInformationStorage){
            var chosenEvent = $('#chosenEvent, #quoteRequestSecond').serialize();
            console.log(chosenEvent)
            sendQuoteRequest(chosenEvent, userInformationStorage);
        }
    });

    function showSecondPage() {
        var text = 'Contact details';
        $('#registrationModal .stage').hide();
        $('#registrationModal .sub-stage').hide();
        $('#registrationModal .modal-header').show();
        $('#registrationModal #step-counter').html('Step 2');
        $('#registrationModal #modal-title').html(text);
        $('#registrationModal #customerBlock').show();
        $('#registrationModal #stage-2').show();
        $('#registrationModal #completionTime').hide();
        $('#registrationModal #modal-title').focus();
    }

    function sendQuoteRequest(data, userInformationStorage){
        $.ajax({
            type:'POST',
            url:'/event/create',
            data: data + '&user='+userInformationStorage.userId
        })
    };
});