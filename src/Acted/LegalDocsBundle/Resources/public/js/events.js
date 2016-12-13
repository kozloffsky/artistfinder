$(function () {

    'use strict';

    //todo try to re fracture to 1 watcher.

    var toSend;
    var eventsVue;
    var numberOfGuests = [
        {value: "less_then_50", text: "Less than 50"},
        {value: "50-100", text: "50-100"},
        {value: "100-500", text: "100-500"},
        {value: "500+", text: "500+"}
    ];

    if (document.querySelector('#client-event-details')) {
        eventsVue = new Vue({
            el: '#client-event-details',
            delimiters: ['${', '}'],
            data: {
                event: '',
                venues: '',
                selectedVenue: '',
                guests: numberOfGuests,
                selectedGuest: '',
                endingDate: '',
                charCount: 0,
                loadedData: false,
                lastEventId: null
            },
            created: function () {
                showEvents();
                this.loadedData = true;
            },
            watch: {
                "event.title": function (newVal, oldVal) {
                    if (!this.loadedData) {
                        return;
                    }

                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {title: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                "event.timing": function (newVal, oldVal) {
                    if (!this.loadedData) {
                        return;
                    }

                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {timing: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                "event.location": function (newVal, oldVal) {
                    if (!this.loadedData) {
                        return;
                    }

                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {address: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                selectedVenue: function (newVal, oldVal) {
                    if (!this.loadedData) {
                        return;
                    }

                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {venueType: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                selectedGuest: function (newVal, oldVal) {
                    if (!this.loadedData) {
                        return;
                    }

                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {NumberOfGuests: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                endingDate: function (newVal, oldVal) {
                    if (!this.loadedData) {
                        return;
                    }

                    if (wasChanged(newVal, oldVal)) {
                        var event = eventsVue.event;
                        var st_date = moment(event.starting_date, "DD/MM/YYYY");
                        var days = newVal;
                        if(typeof event.comments == 'undefined'){
                            eventsVue.event.comments = '';
                        }
                        if(days == 1){
                            days = 0
                        }
                        var newDate = st_date.add(days, 'days');
                        newDate = newDate.format("DD/MM/YYYY");
                        toSend = {data: {endingDate: newDate}};
                        sendData(eventsVue.event.id, toSend);

                        days = days == 0 ? 1 : days;
                        toSend = {data: {countDays: days}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                "event.comments": function (newVal, oldVal) {
                    if (!this.loadedData) {
                        return;
                    }

                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {comments: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                }
            }
        });
    }

    function wasChanged(newVal, oldVal) {
        return newVal !== oldVal && oldVal;
    }

    function getEventDataById(eventId) {
        getVenues();
        $.ajax({
            url: '/api/events/' + eventId,
            success: function (response) {
                if (typeof response.event !== 'undefined') {
                    window.setCurrentEvent(response.event);
                    var event = response.event;
                    eventsVue.event = response.event;
                    eventsVue.selectedVenue = eventsVue.event.venue_type.id;
                    eventsVue.selectedGuest = eventsVue.event.number_of_guests;
                    var st_date = moment(event.starting_date, "DD/MM/YYYY");
                    var end_date = moment(event.ending_date, "DD/MM/YYYY");
                    eventsVue.charCount = (typeof(event.comments) !== 'undefined') ? event.comments.length : 0;
                    var diff = end_date.diff(st_date, 'days');
                    if(diff == 0){
                        diff = 1;
                    }
                    eventsVue.endingDate = diff;
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    }

    function getVenues() {
        $.ajax({
            url: '/api/venues',
            success: function (response) {
                if (typeof response.venues !== 'undefined') {
                    eventsVue.venues = response.venues;
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    }

    function sendData(eventId, data) {
        $.ajax({
            url: '/api/events/' + eventId + '/edit',
            method: "PATCH",
            data: data,
            success: function (success) {
                console.log(success);
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    //todo re fracture to vuejs
    $('#event_date').change(function () {
        var eventId = window.getCurrentEvent().id;
        var date = $(this).val();
        toSend = {data: {startingDate: date}};
        sendData(eventId, toSend);
    });

    function showEvents() {
        $('.left_column').show();
    }

    $().ready(function () {
        $("#event_date").datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: 0
        });
    });

    /**
     * Count chars printed in the textarea and change the   counter.
     */
    function charsCounter() {
        var $this = $(this);
        var $wrapper = $this.parents('.row');
        var $current = $wrapper.find('.current-count');

        var text = $this.val();
        text = text.replace(/(?:\r\n|\r|\n)/g, ' ');
        $this.html(text);
        $current.html(text.length);
    }


    $('textarea#additional_info').keyup(charsCounter);

    window.getEventDataById = getEventDataById;
});