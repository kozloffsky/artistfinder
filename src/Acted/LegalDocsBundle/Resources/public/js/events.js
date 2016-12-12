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
                charCount: 0
            },
            created: function () {
                showEvents();
            },
            watch: {
                "event.title": function (newVal, oldVal) {
                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {title: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                "event.timing": function (newVal, oldVal) {
                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {timing: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                "event.location": function (newVal, oldVal) {
                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {address: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                selectedVenue: function (newVal, oldVal) {
                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {venueType: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                selectedGuest: function (newVal, oldVal) {
                    if (wasChanged(newVal, oldVal)) {
                        toSend = {data: {NumberOfGuests: newVal}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                endingDate: function (newVal, oldVal) {
                    if (wasChanged(newVal, oldVal)) {
                        var event = eventsVue.event;
                        var st_date = moment(event.starting_date, "DD/MM/YYYY");
                        var newDate = st_date.add(newVal, 'days');
                        newDate = newDate.format("DD/MM/YYYY");
                        toSend = {data: {endingDate: newDate}};
                        sendData(eventsVue.event.id, toSend);
                    }
                },
                "event.comments": function (newVal, oldVal) {
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
                    eventsVue.endingDate = end_date.diff(st_date, 'days');
                    eventsVue.charCount = (typeof(event.comments) !== 'undefined') ? event.comments.length : 0;
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