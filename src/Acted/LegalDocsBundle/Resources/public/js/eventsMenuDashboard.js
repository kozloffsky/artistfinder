$(function () {
    /**
     * Current route
     * @type {string}
     */
    var route = window.location.pathname;

    function getUser() {
        return JSON.parse(localStorage.getItem('user'));
    }

    /**
     * Get current user ID.
     *
     * @returns {int} userId
     */
    function getUserId() {
        return getUser().userId;
    }

    function getUserRole() {
        return getUser().role;
    }

    /**
     * Get all events for the current user.
     *
     * @param {int} userId
     */
    function getEventsByUserId(userId) {
        $.ajax({
            method: "GET",
            url: "/event/client/" + userId,
            success: function (data) {
                if (typeof data.events !== 'undefined') {
                    showEvents(data.events);
                }
            }
        });
    }

    /**
     * Parse array of events and wrap them in html.
     *
     * @param {array} events
     *
     * @returns {string} html
     */
    function eventsToHtml(events) {
        var html = '';
        events.forEach(function (item, index) {
            var id = item.id;
            var title = item.title;
            var eClass = 'event-item non-active';

            if (index == 0) {
                eClass = 'event-item active';
                getDataForEvent(id);
            }
            html += "<li class='" + eClass + "' title='" + title + ".' data-event-id='" + id + "'>";
            html += title;
            html += "</li>";
        });

        return html;

    }


    function setCurrentEvent(event) {
        localStorage.setItem('currentEvent', JSON.stringify(event));
    }

    function getCurrentEvent() {
        return JSON.parse(localStorage.getItem('currentEvent'));
    }

    /**
     * Get data depending on route.
     * Calls according function.
     *
     * @returns {*}
     */
    function routeParser() {
        var routeArr = route.substr(1).split('/');
        var currentPage = routeArr[1];

        var avalFunctions = {
            feedbacks: "getArtistsByEventId",
            events: "getEventDataById"
        };

        var callFunc = avalFunctions[currentPage];

        if (typeof callFunc == "undefined") {
            var errorMsg = "No get data function is defined for this page ";
            errorMsg += currentPage;

            throw new Error(errorMsg);
        }

        return callFunc

    }

    function getDataForEvent(eventId) {
        var toCall = routeParser();

        try {
            window[toCall](eventId)
        } catch (e) {

        }
    }

    /**
     * If event item is clicked. Receive all connected artists.
     */
    function eventOnClick() {
        var $this = $(this);
        var eventId = $this.data('eventId');
        var $wrapper = $this.parents('.owl-theme');
        $wrapper.find('.active').toggleClass('active').toggleClass('non-active');
        $this.toggleClass('active').toggleClass('non-active');

        getDataForEvent(eventId);
    }

    /**
     * Show all received events on the page.
     *
     * @param {array} events
     */
    function showEvents(events) {
        var $eventsWrapper = $('div.events-menu > ul');
        var initCarousel = false;
        if (events.length > 4) {
            initCarousel = true;
        }

        var html = eventsToHtml(events);
        $eventsWrapper.html(html).promise().done(function () {

            $('.event-item').click(eventOnClick);

            if (initCarousel) {
                $('div.arrows').show();

                var owl = $('.events-menu > ul').owlCarousel({
                    items: 4,
                    pagination: false,
                    mouseDrag: false,
                    responsive: true,
                    responsiveBaseWidth: window
                });
                $('i.left').click(function () {
                    owl.trigger('owl.prev');
                });
                $('i.right').click(function () {
                    owl.trigger('owl.next');
                })
            }
        });
    }

    window.getCurrentEvent = getCurrentEvent;
    window.setCurrentEvent = setCurrentEvent;

    $('.new-client-event').click(function () {
        $('.event-modal').modal('show');
    });

    if (route.search('dashboard/') > 0 && getUserRole()[0] == 'ROLE_CLIENT') {
        getEventsByUserId(getUserId());
    }

    var eventAutocompService;

    /*Count comment text*/
    $('textarea[name="comment"]').keyup(charsCounter);
    $('textarea[name="additional_info"]').keyup(charsCounter);


    $(document).ready(function() {
        $( "#event_event_date" ).datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: 0
        });

        eventAutocompService = new GoogleAutocompleteService(),
            isAvailable = eventAutocompService.getFormElements('form[id="eventForm"]');

        if(isAvailable)
            eventAutocompService.initAutoComplete();
    });

    /**
    * Count chars printed in the textarea and change the counter.
    */
    function charsCounter() {
        var $this = $(this);
        var $current = $this.prev('span').find('.current-count');
        var text = $this.val();
        text = text.replace(/(?:\r\n|\r|\n)/g, ' ');
        $this.html(text);
        $current.html(text.length);
    }

    if (document.querySelector('.event-modal')) {
        try{
            var vue = new Vue({
                el: '.event-modal',
                delimiters: ['${','}'],
                data: {
                    eventObj: {
                        name: '',
                        eventDate: '',
                        venueType: [],
                        selectedVenueType: 1,
                        countDays: 1,
                        eventTiming: '',
                        eventAddress: '',
                        eventNumberOfGuests: 'less_then_50',
                        eventAdditionalInfo: ''
                    }
                },
                created: function() {
                    this.getAllVenuesType();
                },
                methods:{
                    createEvent: function (e) {
                        e.preventDefault();

                        console.log(this.eventObj.eventDate);

                        var country = 'United Kingdom';

                        //todo - need to do with vuejs without jquery
                        var eventDate = $('.event-modal').find('input[name=event_date]').val();
                        var eventAddress = $('.event-modal').find('.event_location').val();

                        var eventType = 1;
                        var regionLat = eventAutocompService.coords.region.lat,
                            regionLng = eventAutocompService.coords.region.lng,
                            cityLat = eventAutocompService.coords.city.lat,
                            cityLng = eventAutocompService.coords.city.lng,
                            region = eventAutocompService.currentStore.region,
                            placeId = eventAutocompService.currentStore.placeId,
                            city = eventAutocompService.currentStore.city;

                        $.ajax({
                            type:'POST',
                            url:'/event/create',
                            data: {
                                    user: getUserId(),
                                    name: this.eventObj.name,
                                    event_date: eventDate,
                                    venue_type: this.eventObj.selectedVenueType,
                                    count_days: this.eventObj.countDays,
                                    event_time: this.eventObj.eventTiming,
                                    location: eventAddress,
                                    number_of_guests: this.eventObj.eventNumberOfGuests,
                                    additional_info: this.eventObj.eventAdditionalInfo,
                                    city_lat: cityLat,
                                    city_lng: cityLng,
                                    region_name: region,
                                    region_lat: regionLat,
                                    region_lng: regionLng,
                                    place_id: placeId,
                                    country: country,
                                    city: city,
                                    type: eventType
                            },
                            beforeSend: function () {
                                $('#loadSpinner').fadeIn(500);
                            },
                            complete: function () {
                                $('#loadSpinner').fadeOut(500);
                            },
                            success:function(res){
                                $('.event-modal').modal('hide');
                                // $('#freeQuoteModal').modal('hide');
                                // $('#offerSuccess').modal('show');
                                // $('#additional_info_area').find(".current-count").html("0");
                                // $('#additional_info_area textarea').val('');
                                //
                                // $('#comment_area').hide();
                                // $('#comment_area').find(".current-count").html("0");
                                // $('#comment_area textarea').val('');
                                // $('#requestQuoteForm input').attr('style', '');
                                // $('#quoteRequestSecond .errorCat').text('').hide();
                                // $('#requestQuoteForm .errorCat').text('').hide();
                                // prepareEventRequestForm();
                            },
                            error: function(response){
                                // $('#loadSpinner').fadeOut(500);
                                // $('#requestQuoteForm input').attr('style', '');
                                // $('#quoteRequestSecond .errorCat').text('').hide();
                                // $('#requestQuoteForm .errorCat').text('').hide();
                                // $.each(response.responseJSON, function(key, value) {
                                //     //console.log(key, value);
                                //     $('#requestQuoteForm input[name='+key+']').attr('style', 'border-color: #ff735a !important');
                                //     if(key == 'performance'){
                                //         $('#quoteRequestSecond .errorCat').text(value).show();
                                //     }
                                //     if(key == 'number_of_guests'){
                                //         $('#requestQuoteForm .errorCat').text(value).show();
                                //     }
                                // });
                            }
                        });
                    },
                    getAllVenuesType: function () {
                        var _this = this;

                        $.ajax({
                            type: "GET",
                            url: '/event/list_venue_type',
                            success: function(response) {
                                _this.eventObj.venueType = response.venueType;
                            }
                        })
                    }
                },
                filters:{

                },
                watch: {
                    isAttached: function () {

                    }
                }

            });
        }catch (e){
        }
    }
});