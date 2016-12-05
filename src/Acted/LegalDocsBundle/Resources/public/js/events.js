$(function () {

    var numberOfGuests = [
        {value: "less_then_50", text: "Less than 50"},
        {value: "50-100", text: "50-100"},
        {value: "100-500", text: "100-500"},
        {value: "500+", text: "500+"}
    ];

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
        methods:{
            foo: function (event) {
                console.log(event);
            }
        }
    });

    function getEventDataById(eventId) {
        $.ajax({
            url: '/api/events/' + eventId,
            success: function (response) {
                if (typeof response.event !== 'undefined') {
                    eventsVue.event = response.event;
                    eventsVue.selectedVenue = eventsVue.event.venue_type;
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

    getVenues();

    window.getEventDataById = getEventDataById;
});