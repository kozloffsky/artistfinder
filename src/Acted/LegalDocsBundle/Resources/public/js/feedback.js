$(function () {
    'use strict';

    //TODO refactor html to lodash templates!

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
                $('.star-icon').click(setFixed);
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
     * Fix feedback rating.
     */
    function setFixed() {
        var $this = $(this);
        var $wrapper = $this.parent();
        var $prevStars = $this.prevAll();
        var $firstStar = $('.star-icon').first();

        $this.prevAll().andSelf().addClass('filled');
        $this.nextAll().removeClass('filled').addClass('unfilled');

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
        var $wrapper = $commentBox.parents('.col-md-12');
        return $wrapper.find('i.filled').length;
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

        var text = $this.val();
        text = text.replace(/(?:\r\n|\r|\n)/g, ' ');
        $this.html(text);
        $current.html(text.length);
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
     * Remove form from the page.
     *
     * @param {int} artistId
     */
    function removeForm(artistId) {
        var $box = $('.comment-box[data-artist-id="' + artistId + '"]');
        $box.parents('.col-md-12').remove();
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
                removeForm(data['feedback_create[artist]']);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $('#rating-accept-appear').click(function () {
        $.ajax({
            url: '/profile/feedbacks/switch',
            method: "PATCH",
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        })
    });

    window.getArtistsByEventId = getArtistsByEventId;
});