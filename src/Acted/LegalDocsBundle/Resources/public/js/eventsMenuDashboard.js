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

        getArtistsByEventId(eventId);
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

    if (route.search('dashboard/') > 0 && getUserRole()[0] == 'ROLE_CLIENT') {
        getEventsByUserId(getUserId());
    }
});