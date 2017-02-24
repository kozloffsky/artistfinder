$(function () {

    var vueEventCreate;

    var eventDetailsAutocompService = new GoogleAutocompleteService(),
        isAvailable = eventDetailsAutocompService.getFormElements('#client-event-details form[name="event-details"]');

    if (isAvailable)
        eventDetailsAutocompService.initAutoComplete();

    /**
     * events
     *
     * @type {object}
     */
    var clientEvents = {};

    var firstLoad = true;

    /**
     * Current route
     *
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
        return window.getUser().userId;
    }

    /**
     * Get current user role
     *
     * @returns {string}
     */
    function getUserRole() {
        return window.getUser().role;
    }

    /**
     * Get all events for the current user.
     *
     * @param {int} userId
     */
    function getEventsByUserId(userId, reinit) {
        $.ajax({
            method: "GET",
            url: "/event/client/" + userId,
            success: function (data) {
                if ($.isEmptyObject(data.events)) {
                    $('.forSpinner').css('display','none');
                    $('#no-client-event-details').css('display','block');
                } else if (typeof data.events !== 'undefined'){
                    showEvents(data.events, reinit);
                    $('.forSpinner').css('display','none');
                    $('#client-event-details').css('display','block');
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
            clientEvents[item.id] = item;
            var id = item.id;
            var title = item.title;
            var eClass = 'event-item non-active';
            if (index == 0 && getCurrentEvent() == null) {
                setCurrentEvent(item);
                firstLoad = false;
                eClass = 'event-item active';
                getDataForEvent(id);
            }
            html += "<li class='" + eClass + "' title='" + title + ".' data-event-id='" + id + "'>";
            html += title;
            html += "</li>";
        });
        return html;

    }

    /**
     * Set current event to the local storage.
     *
     * @param {object} event
     */
    function setCurrentEvent(event) {
        localStorage.setItem('currentEvent', JSON.stringify(event));
    }

    /**
     * Get current event from the local storage.
     */
    function getCurrentEvent() {
        return JSON.parse(localStorage.getItem('currentEvent'));
    }

    function unsetCurrentEvent() {
        localStorage.removeItem('currentEvent');
    }

    function noDataFunc() {
        console.log('No get data function is defined for this page ');
    }

    window.noDataFunc = noDataFunc;
    /**
     * Get data depending on route.
     * Calls according function.
     *
     * @returns {*}
     */
    function routeParser() {
        var routeArr = route.substr(1).split('/');
        var currentPage = routeArr[1].replace('-', '_');
        var callFunc;
        var avalFunctionsClient = {
            feedbacks: "getArtistsByEventId",
            events: "getEventDataById",
            messages: "getAllMessagesByEventId",
            artist_selection: "getOrdersForEvent",
            payments: "getOrderPaymentsForEvent"
        };

        var avalFunctionsArtist = {
            messages: "getNewFeedbacks"
        };

        if (getUserRole()[0] == 'ROLE_CLIENT') {
            callFunc = avalFunctionsClient[currentPage];
        } else if (getUserRole()[0] == 'ROLE_ARTIST') {
            callFunc = avalFunctionsArtist[currentPage];
        }


        if (typeof callFunc == "undefined") {
            var errorMsg = "No get data function is defined for this page ";
            errorMsg += currentPage;
            // throw new Error(errorMsg);
            callFunc = "noDataFunc";

        }

        return callFunc

    }

    /**
     * Call predefined function based on route to get data for the event.
     *
     * @param eventId
     */
    function getDataForEvent(eventId) {
        var toCall = routeParser();
        window[toCall](eventId)
    }

    /**
     * If event item is clicked.
     * Call predefined function based on route to get data for the event.
     */
    function eventOnClick() {
        var $this = $(this);
        var eventId = $this.data('eventId');
        var $wrapper = $this.parents('.owl-theme');
        $wrapper.find('.active').toggleClass('active').toggleClass('non-active');
        $this.toggleClass('active').toggleClass('non-active');
        setCurrentEvent(clientEvents[eventId]);
        getDataForEvent(eventId);
    }

    function activateMenuTab(owl) {
        var $menu = $('.events-menu > ul');
        if (getCurrentEvent() != null) {
            currentEventId = getCurrentEvent().id;
            var $menuEvent = $menu.find('li[data-event-id="' + currentEventId + '"]');
            var $menuEventParent = $menuEvent.parent();
            var index = $menuEventParent.index();
            owl.trigger('owl.jumpTo', index);
            $menu.find('li').removeClass('active');
            $menuEvent.removeClass('non-active').addClass('active');
            getDataForEvent(currentEventId);
        }
    }

    /**
     * Show all received events on the page.
     *
     * @param {array} events
     */
    function showEvents(events, reinit) {
        var $eventsWrapper = $('div.events-menu > ul');

        var html = eventsToHtml(events);
        $eventsWrapper.html(html).promise().done(function () {

            $('.event-item').click(eventOnClick);

            if (typeof(reinit) == 'undefined') {
                var owl = $('.events-menu > ul').owlCarousel({
                    autoWidth: true,
                    singleItem: false,
                    responsive: true,
                    responsiveRefreshRate: 100,
                    itemsDesktop: [1199, 4],
                    itemsDesktopSmall: [980, 4],
                    itemsTablet: [768, 3],
                    itemsTabletSmall: [640, 2],
                    itemsMobile: [500, 1]
                });
                $().ready(activateMenuTab(owl));
            } else {
                //todo - need to fix (Uncaught TypeError: owl.trigger is not a function)
                var owl = $(".owl-carousel").data('owlCarousel');
                owl.reinit();
            }
            $('i.left').click(function () {
                owl.trigger('owl.prev');
            });
            $('i.right').click(function () {
                owl.trigger('owl.next');
            })
        });
    }

    window.getCurrentEvent = getCurrentEvent;
    window.setCurrentEvent = setCurrentEvent;
    window.getUser = getUser;
    window.getUserId = getUserId;
    window.getUserRole = getUserRole;

    $('body').on('click', '.new-client-event', function () {
        var countDays = 1;
        var eventNumberOfGuests = 'less_then_50';
        var venueType = 1;
        var additionalInfo = '';
        var eventTime = '';

        $('.event-modal').find('#event_duration').val(countDays);
        $('.event-modal').find('#guests_count').val(eventNumberOfGuests);
        $('.event-modal').find('#venue_type').val(venueType);
        $('.event-modal').find('form').find("input[type=text], textarea").val("");

        $('.event-modal').find('#additional_info').val(additionalInfo);
        $('.event-modal').find('#event_time').val(eventTime);

        $('.event-modal').modal('show');
    });

    if (route.search('dashboard/') > 0 && getUserRole()[0] == 'ROLE_CLIENT') {
        getEventsByUserId(getUserId());
    } else if (route.search('dashboard/') > 0 && getUserRole()[0] == 'ROLE_ARTIST') {
        var toCall = routeParser();
        window[toCall]();
    }
    var eventAutocompService;

    /*Count comment text*/
    $('textarea[name="comment"]').keyup(charsCounter);
    $('textarea[name="additional_info"]').keyup(charsCounter);


    $(document).ready(function () {
        $("#event_event_date").datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: 0
        });

        eventAutocompService = new GoogleAutocompleteService(),
            isAvailable = eventAutocompService.getFormElements('form[id="eventForm"]');

        if (isAvailable)
            eventAutocompService.initAutoComplete();

        $('#eventModal').on('hidden.bs.modal', function () {
            vueEventCreate.eventObj.name = '';
            vueEventCreate.eventObj.eventDate = '';
            vueEventCreate.eventObj.countDays = 1;
            vueEventCreate.eventObj.eventTiming = '';
            vueEventCreate.eventObj.eventAddress = '';
            vueEventCreate.eventObj.eventNumberOfGuests = 'less_then_50';
            vueEventCreate.eventObj.eventAdditionalInfo = '';
        });
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
        try {
            vueEventCreate = new Vue({
                el: '.event-modal',
                delimiters: ['${', '}'],
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
                created: function () {
                    this.getAllVenuesType();
                    $('.event-modal').find('#event_duration').val(this.eventObj.countDays);
                    $('.event-modal').find('#guests_count').val(this.eventObj.eventNumberOfGuests);
                },
                methods: {
                    createEvent: function (e) {
                        e.preventDefault();

                        var _this = this;

                        //todo - need to do with vuejs without jquery
                        var eventDate = $('.event-modal').find('input[name=event_date]').val();
                        var eventAddress = $('.event-modal').find('#event_location').val();
                        var selectedVenueType = $('.event-modal #venue_type').find('option:selected').val();
                        var countDays = $('.event-modal #event_duration').find('option:selected').val();
                        var eventNumberOfGuests = $('.event-modal #guests_count').find('option:selected').val();

                        var eventType = 1;
                        var regionLat = eventAutocompService.coords.region.lat,
                            regionLng = eventAutocompService.coords.region.lng,
                            cityLat = eventAutocompService.coords.city.lat,
                            cityLng = eventAutocompService.coords.city.lng,
                            region = eventAutocompService.currentStore.region,
                            placeId = eventAutocompService.currentStore.placeId,
                            city = eventAutocompService.currentStore.city,
                            country = eventAutocompService.currentStore.country;

                        var data = {
                            user: getUserId(),
                            name: this.eventObj.name,
                            event_date: eventDate,
                            venue_type: selectedVenueType,
                            count_days: countDays,
                            event_time: this.eventObj.eventTiming,
                            location: eventAddress,
                            number_of_guests: eventNumberOfGuests,
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
                        };

                        $.ajax({
                            type: 'POST',
                            url: '/event/create',
                            data: data,
                            beforeSend: function () {
                                $('#loadSpinner').fadeIn(500);
                            },
                            complete: function () {
                                $('#loadSpinner').fadeOut(500);
                            },
                            success: function (res) {
                                unsetCurrentEvent();
                                getEventsByUserId(getUserId(), true);

                                _this.eventObj.name = '';
                                _this.eventObj.eventDate = '';
                                _this.eventObj.countDays = 1;
                                _this.eventObj.eventTiming = '';
                                _this.eventObj.eventAddress = '';
                                _this.eventObj.eventNumberOfGuests = 'less_then_50';
                                _this.eventObj.eventAdditionalInfo = '';

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
                            error: function (response) {
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
                            success: function (response) {
                                _this.eventObj.venueType = response.venueType;
                            }
                        })
                    },
                    setVenueType: function () {
                        var _this = this;
                        console.log(this.eventObj.selectedVenueType);
                    }
                },
                filters: {},
                watch: {
                    isAttached: function () {

                    }
                }

            });
        } catch (e) {
        }
    }

    function setActiveMenu() {
        if ($('.options-menu').length > 0) {
            var $menu = $('.options-menu');
            $menu.find('li').removeClass('active-item');
            $menu.find('a[href*="' + route + '"]').parent().addClass('active-item');
        }
    }

    $().ready(setActiveMenu);
});