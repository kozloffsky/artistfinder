$(function () {

    'use strict';

    //todo try to re fracture to 1 watcher.

    var toSend;

    var numberOfGuests = [
        {value: "less_then_50", text: "Less than 50"},
        {value: "50-100", text: "50-100"},
        {value: "100-500", text: "100-500"},
        {value: "500+", text: "500+"}
    ];

    if (document.querySelector('#client-event-details')) {
        var eventsVue = new Vue({
            el: '#client-event-details',
            delimiters: ['${', '}'],
            data: {
                event: '',
                venues: '',
                selectedVenue: '',
                guests: numberOfGuests,
                selectedGuest: ''
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
                }

            }
        });
    }

    function wasChanged(newVal, oldVal) {
        return newVal !== oldVal && oldVal;
    }

    function getEventDataById(eventId) {
        $.ajax({
            url: '/api/events/' + eventId,
            success: function (response) {
                if (typeof response.event !== 'undefined') {
                    window.setCurrentEvent(response.event);
                    eventsVue.event = response.event;
                    eventsVue.selectedVenue = eventsVue.event.venue_type.id;
                    eventsVue.selectedGuest = eventsVue.event.number_of_guests;
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

    getVenues();

    //todo re fracture to vuejs
    $('#event_date').change(function () {
        var eventId = window.getCurrentEvent().id;
        var date = $(this).val();
        toSend = {data: {startingDate: date}};
        sendData(eventId, toSend);
    });

    window.getEventDataById = getEventDataById;
});