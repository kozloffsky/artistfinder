/**
 * Created by pavel on 12.05.16.
 */
$(function () {
    var quoteRequestAutocompService = new GoogleAutocompleteService(),
        isAvailable = quoteRequestAutocompService.getFormElements('.free-quote-modal form[id="requestQuoteForm"]');

    if(isAvailable)
        quoteRequestAutocompService.initAutoComplete();

    $( "#event_date" ).datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: 0 }
    );

    function initSelect(){
        $('.free-quote-modal select').each(function () {
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


    $(document).on('click','.quoteRequestProfile',function(){
        var artistSlug = $('#slug').text();
        getArtistInformationForQuote(artistSlug);
        $('#freeQuoteModal').modal('show');
    });


    $(document).on('click','.askQuoteFromSearch',function(){
        var artistSlug = $(this).val();
        getArtistInformationForQuote(artistSlug);
        $('#freeQuoteModal').modal('show');
    });


    $(document).on('click','.requestQuotePerformance',function(){
        var artistSlug = $('#slug').text();
        var performanceRequestId = $(this).val();
        getArtistInformationForQuote(artistSlug, performanceRequestId)
        $('#freeQuoteModal').modal('show');
    });

    function getArtistInformationForQuote(artistSlug, performanceRequestId){
        $.ajax({
            type: "GET",
            url: '/info/artist/' + artistSlug,
            success: function(response) {
                createRequestQuotePerformances(response.artist, performanceRequestId);
                createArtistDataViewInQuote(response.artist);
                preventMultipleQuotes(artistSlug);
            }
        })
    }

    function preventMultipleQuotes(artistSlug){
        var selectedEvent = $('#chosenEvent select').find('option:selected').val();
        hideFormIfExistEvent(selectedEvent, artistSlug)
        $('#chosenEvent select').on('change',function(){
            var selectedEvent = $(this).find('option:selected').val();
            hideFormIfExistEvent(selectedEvent, artistSlug)
        });

    }

    function hideFormIfExistEvent(selectedEvent, artistSlug){
        var getEventsReady = sessionStorage.getItem(selectedEvent);
        if(getEventsReady){
            var findArtistInEvent = getEventsReady.search(artistSlug);
            //console.log(findArtistInEvent)
            if(findArtistInEvent >= 0){
                preventEventSending()
            } else {
                allowEventSending()
            }
        }
    }

    function preventEventSending(){
        $('#quoteRequestSecond .requestQuotePerformances, #quoteRequestSecond .add-comment-btn, #quoteRequestSecond .controls').hide();
        $('#requestQuoteForm .modal-body').hide();
        $('#quoteRequestSecond .alreadyHasEventArtist').show();
    }

    function allowEventSending(){
        $('#quoteRequestSecond .requestQuotePerformances, #quoteRequestSecond .add-comment-btn, #quoteRequestSecond .controls').show();
        $('#quoteRequestSecond .alreadyHasEventArtist').hide()
    }


    function createRequestQuotePerformances(artistData, performanceRequestId){
        $('.requestQuotePerformances').empty();
        $(artistData.allPerformance).each(function(){
            var blockPerformance = '<li>'+
                '<div class="custom-checkbox">'+
                '<input id="perf'+this.id+'" type="checkbox" name="performance[]" value="'+this.id+'">'+
                '<label for="perf'+this.id+'">'+this.name+'</label>'+
                '</div>'+
                '</li>';
            $('.requestQuotePerformances').append(blockPerformance);
        });
        if(performanceRequestId){
            $('.requestQuotePerformances input#perf'+performanceRequestId).prop('checked', true);
        }
    }

    function createArtistDataViewInQuote(artistData){
        //console.log(artistData)
        var artistCatString = artistData.categories.toString();
        $('.quoteRequestArtistData .quote-profile-info h2').html(artistData.name);
        $('.quoteRequestArtistData .quote-profile-info p').html(artistCatString);
        if(artistData.user.avatar){
            $('.quote-profile-avatar').attr('src', artistData.user.avatar);
        } else {
            $('.quote-profile-avatar').attr('src', '/assets/images/noAvatar.png');
        }

    }

    $(document).ready(function() {
        prepareEventRequestForm()
    });

    function prepareEventRequestForm(){
        var checkIfUserLoggedIn = $('header #userInformation').length;
        //console.log(checkIfUserLoggedIn)
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
        var userId = userInf.userId;
        $.ajax({
            type:'GET',
            url:'/event/user_events?user='+userId,
            success: function(response){
                var userEvents = response.events,
                    userArtistsInEvents = response.artists;
                if(userEvents.length > 0){
                    createEventsListRequest(userEvents);
                    setDataEvent(userEvents);
                    sessionStorage.clear();
                    for(var propt in userArtistsInEvents) {
                        sessionStorage.setItem(propt, userArtistsInEvents[propt]);
                    }
                    $('.eventChooseRequest').show();
                } else {
                    $('.eventChooseRequest').hide();
                    sessionStorage.clear();
                }
            }
        })
    }


    function createEventsListRequest(userEvents){
        $('#event_preset').empty();
        $(userEvents).each(function(i){
            var eventsOptions='<option value="'+ this.event.id +'" name="event" class="'+i+'">'+this.event.title+'</option>';
            $('#event_preset').append(eventsOptions);
            //console.log('preveEventList')
        });
        $('.eventUnregistered').hide();
        $('#requestQuoteForm .modal-body').hide();
        $('#requestQuoteForm .modal-body').addClass('choosePrevEvent');
        initSelect();
    }

    function setDataEvent(userEvents){
        $('#chosenEvent select').on('change',function(){
            var selectedEvent = $(this).find('option:selected').attr('class');
            fillFormWithDataFromEvent(userEvents, selectedEvent)
        });
        var selectedEvent = $('#chosenEvent select').find('option:selected').attr('class');
        fillFormWithDataFromEvent(userEvents, selectedEvent)
    }

    function fillFormWithDataFromEvent(userEvents, selectedEvent){
        $('#requestQuoteForm #event_name').val(userEvents[selectedEvent].event.title);
        $('#requestQuoteForm #event_date').val(userEvents[selectedEvent].event.starting_date);
        $('#requestQuoteForm #event_time').val(userEvents[selectedEvent].event.timing);
        $('#requestQuoteForm #event_city option[value='+userEvents[selectedEvent].event.city.id+']').attr('selected','selected');
        $('#requestQuoteForm #event_country option[value='+userEvents[selectedEvent].event.countryId+']').attr('selected','selected');
        $('#requestQuoteForm #event_location').val(userEvents[selectedEvent].event.location);
        $('#requestQuoteForm #event_type option[value='+userEvents[selectedEvent].event.event_type.id+']').attr('selected','selected');
        $('#requestQuoteForm #venue_type option[value='+userEvents[selectedEvent].event.venue_type.id+']').attr('selected','selected');
        $('#requestQuoteForm .guests-num input[value="'+userEvents[selectedEvent].event.number_of_guests+'"]').prop('checked',true);
    }

    $('#new-event').on('click',function(){
        $('#requestQuoteForm .modal-body').slideDown();
        $('#requestQuoteForm .modal-body').removeClass('choosePrevEvent');
        $('#requestQuoteForm .modal-body').addClass('newEventRegistered');
        cleanNewEventForm();
        //$('#requestQuoteForm .guests-num input').prop('checked',false);
        allowEventSending();
    });

    function cleanNewEventForm(){
        $('#requestQuoteForm #event_name, #requestQuoteForm #event_date, #requestQuoteForm #event_time, #requestQuoteForm #event_location').val('');
        $('#requestQuoteForm .guests-num input').prop('checked',false);
        $('#requestQuoteForm input').attr('style', '');
        $('#quoteRequestSecond .errorCat').text('').hide();
        $('#requestQuoteForm .errorCat').text('').hide();
    }

    $('#quoteRequsetSend').on('click',function(e){
        e.preventDefault();
        var requestFormSerialize = $('#requestQuoteForm, #quoteRequestSecond').serialize(),
            userInformationStorage = JSON.parse(localStorage.getItem('user')),
            checkUserLoggedIn = $('#userInformation').text(),
            prevEventChosen = $('#requestQuoteForm .modal-body').hasClass('choosePrevEvent');
        //console.log(userInformationStorage)
        if(userInformationStorage && prevEventChosen == false){
            sendQuoteRequest(requestFormSerialize, userInformationStorage);
        } else if (!userInformationStorage){
            localStorage.setItem("quoteRequest", requestFormSerialize);
            $('#freeQuoteModal').modal('hide');
            $('#ChooseAfterRequestModal').modal('show');
            chooseRogLog();
        } else if(prevEventChosen == true && checkUserLoggedIn && userInformationStorage){
            var chosenEvent = $('#chosenEvent, #requestQuoteForm, #quoteRequestSecond').serialize();
            //console.log(chosenEvent)
            sendQuoteRequest(chosenEvent, userInformationStorage);
        }
    });

    function chooseRogLog(){
        $('#signUpChoose').on('click',function(){
            $('#ChooseAfterRequestModal').modal('hide');
            $('#registrationModal').modal('show');
            showSecondPage();
        });
        $('#LogInChoose').on('click',function(){
            $('#ChooseAfterRequestModal').modal('hide');
            $('#loginModal').modal('show');
        })
    }

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

        var regionLat = quoteRequestAutocompService.coords.region.lat,
            regionLng = quoteRequestAutocompService.coords.region.lng,
            cityLat = quoteRequestAutocompService.coords.city.lat,
            cityLng = quoteRequestAutocompService.coords.city.lng,
            region = quoteRequestAutocompService.currentStore.region;

        data += "&city_lat=" + cityLat;
        data += "&city_lng=" + cityLng;
        data += "&region_name=" + region;
        data += "&region_lat=" + regionLat;
        data += "&region_lng=" + regionLng;

        $.ajax({
            type:'POST',
            url:'/event/create',
            data: data + '&user='+userInformationStorage.userId,
            beforeSend: function () {
                $('#loadSpinner').fadeIn(500);
            },
            complete: function () {
                $('#loadSpinner').fadeOut(500);
            },
            success:function(res){
                $('#freeQuoteModal').modal('hide');
                $('#offerSuccess').modal('show');
                $('#comment_area').hide();
                $('#comment_area textarea').val('');
                $('#requestQuoteForm input').attr('style', '');
                $('#quoteRequestSecond .errorCat').text('').hide();
                $('#requestQuoteForm .errorCat').text('').hide();
                prepareEventRequestForm();
            },
            error: function(response){
                $('#loadSpinner').fadeOut(500);
                $('#requestQuoteForm input').attr('style', '');
                $('#quoteRequestSecond .errorCat').text('').hide();
                $('#requestQuoteForm .errorCat').text('').hide();
                $.each(response.responseJSON, function(key, value) {
                    //console.log(key, value);
                    $('#requestQuoteForm input[name='+key+']').attr('style', 'border-color: #ff735a !important');
                    if(key == 'performance'){
                        $('#quoteRequestSecond .errorCat').text(value).show();
                    }
                    if(key == 'number_of_guests'){
                        $('#requestQuoteForm .errorCat').text(value).show();
                    }
                });
            }
        })
    };
});