$(function () {
    'use strict';

    /**
     * Current route
     * @type {string}
     */
    var route = window.location.pathname;

    /**
     * Get current user ID.
     *
     * @returns {int} userId
     */
    function getUserId() {
        var user = JSON.parse(localStorage.getItem('user'));

        return user.userId;
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
     * Show all received events on the page.
     *
     * @param {array} events
     */
    function showEvents(events) {
        var $eventsWrapper = $('div.events-menu > ul');
        var initCarousel = false;
        if (events.length > 5) {
            initCarousel = true;
        }

        var html = eventsToHtml(events);
        $eventsWrapper.html(html).promise().done(function () {
            $('.event-item').click(eventOnClick);

            if (initCarousel) {
                $('div.arrows').show();

                var owl = $('.events-menu > ul').owlCarousel({
                    items: 5,
                    pagination: false
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
                getArtistsByEventId(id);
            }
            html += "<li class='" + eClass + "' title='" + title + ".' data-event-id='" + id + "'>";
            html += title;
            html += "</li>";
        });

        return html;

    }

    /**
     * If event item is clicked. Receive all connected artists.
     */
    function eventOnClick() {
        var $this = $(this);
        var eventId = $this.data('eventId');

        $this.siblings('.active').toggleClass('active').toggleClass('non-active');
        $this.toggleClass('active').toggleClass('non-active');

        getArtistsByEventId(eventId);
    }

    /**
     * Receive all artists by event id.
     * @param {int} eventId
     */
    function getArtistsByEventId(eventId) {
        var page = 1;
        var perPage = 100;

        $.ajax({
            method: "GET",
            url: '/event/artists/' + eventId + "/" + page + "/" + perPage,
            success: function (data) {
                if (typeof data.artists !== 'undefined') {
                    showFeedbackFields(data.artists);
                }
            }
        })
    }

    /**
     * Show feedback fields for the artists.
     *
     * @param {array} artists
     */
    function showFeedbackFields(artists) {
        var $wrapper = $('div.comment-area');
        $wrapper.html(feedBackFieldsToHtml(artists)).promise().done(
            function () {
                $('.star-icon').hover(changeOnHover).click(setFixed);
                $('.comment-box > textarea').keyup(charsCounter);
                $('.comment-box > button').click(collectData);
            }
        );
    }

    /**
     * Return html for rating stars.
     *
     * @returns {string} html
     */
    function ratingStars() {
        var html = "<div class='rating'>";
        for (var i = 0; i < 5; i++) {
            html += "<i class='star-icon unfilled'></i>";
        }
        html += "</div>";

        return html;
    }

    /**
     * Return html for charCounter in the textarea.
     *
     * @returns {string} html
     */
    function charCounterHtml() {
        var html = "<p class='char-count'>";
        html += "<span class='current-count'>0</span><span>/1000</span>";
        html += "</p>";

        return html;
    }

    /**
     * Parse all artists and wrap each in html.
     *
     * @param {array} artists
     *
     * @returns {string} html
     */
    function feedBackFieldsToHtml(artists) {
        var html = '';
        var avatar = '/assets/images/noAvatar.png';
        var placeholder = "Write your feedback here";

        artists.forEach(function (item) {
            html += "<section class='col-md-12'>";
            html += "<div>";

            if (typeof item.avatar !== 'undefined') {
                avatar = item.avatar;
            }

            html += "<div class='avatar'><img src='" + avatar + "'></div>";
            html += "<div class='user-info'><span class='user-name'>" + item.name + "</span></div>";
            html += ratingStars();
            html += "</div>";
            html += "<div class='comment-box clearfix' data-artist-id='" + item.id + "'>";
            html += charCounterHtml();
            html += "<textarea maxlength='1000' placeholder='" + placeholder + "'></textarea>";
            html += "<button class='submit pull-right' disabled>Submit</button>";
            html += "</div>";
            html += "</section>";
        });


        return html;
    }

    /**
     * Change stars class when they are hovered.
     */
    function changeOnHover() {
        var $this = $(this);
        var $wrapper = $this.parent();
        var $prevStars = $this.prevAll();

        if (!$wrapper.hasClass('rating-fixed')) {
            $this.toggleClass('unfilled').toggleClass('filled');
            $prevStars.toggleClass('unfilled').toggleClass('filled');
        }
    }

    /**
     * Fix feedback rating and remove on hover event.
     */
    function setFixed() {
        var $this = $(this);
        var $wrapper = $this.parent();
        var $prevStars = $this.prevAll();

        $this.removeClass('unfilled').addClass('filled');
        $prevStars.removeClass('unfilled').addClass('filled');
        $wrapper.addClass('rating-fixed');
        $wrapper.parents('.col-md-12').find('button').removeAttr('disabled');
    }

    /**
     * Get rating for the submitted feedback
     *
     * @param {jQuery} $commentBox
     *
     * @returns {int}
     */
    function getRating($commentBox) {
        return $commentBox.find('i.filled').lenght;
    }

    /**
     * Return current event id.
     *
     * @returns {int} eventId
     */
    function getCurrentEventId() {
        return $('div.events-menu .active').data('eventId');
    }

    /**
     * Count chars printed in the textarea and change the   counter.
     */
    function charsCounter() {
        var $this = $(this);
        var $wrapper = $this.parents('.comment-box');
        var $current = $wrapper.find('.current-count');

        $current.html($this.val().length);
    }

    /**
     * Collect data from the feedback form to the data obj.
     */
    function collectData() {
        var $this = $(this);
        var $commentBox = $this.parents('.comment-box');
        var rating = getRating($commentBox);
        var text = $commentBox.find('textarea').val();
        var eventId = getCurrentEventId();
        var artistId = $commentBox.data('artistId');
        var data = {};
        var noText = false;

        if (text.length > 0) {
            data = {
                "feedback_create[event]": eventId,
                "feedback_create[artist]": artistId,
                "feedback_create[rating]": rating,
                "feedback_create[feedback]": text
            };
        } else {
            data = {
                "feedback_rating_create[event]": eventId,
                "feedback_rating_create[artist]": artistId,
                "feedback_rating_create[rating]": rating
            };
            noText = true;
        }
        sendFeedback(data, noText);
    }

    /**
     * Send feedback to the api.
     *
     * @param {object} data
     * @param {bool} noText
     */
    function sendFeedback(data, noText) {
        noText = typeof noText == 'undefined' ? false : noText;
        var url = '/feedback/';
        if (noText) {
            url += 'rating';
        }

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    if (route.search('dashboard/feedback') > 0) {
        getEventsByUserId(getUserId());
    }
});