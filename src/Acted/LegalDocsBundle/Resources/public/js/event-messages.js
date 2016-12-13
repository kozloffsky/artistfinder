$(function () {
    'use strict';
    if (document.querySelector('.messages')) {
        try {
            var messagesVue = new Vue({
                el: '.messages',
                delimiters: ['${', '}'],
                data: {
                    messages: [],
                    selectedFilter: '',
                    feedbacks: {}
                },
                created: function () {
                    showMessages();
                },
                watch: {
                    "selectedFilter": function (newVal, oldVal) {
                        console.log(newVal, oldVal);
                    }
                },
                methods: {
                    archive: function (event) {
                        event.preventDefault();
                        var $this = $(event.target);
                        var message = $this.parents('div.message-and-feedback');
                        var messageId = message.data('messageId');
                        archiveMessage(messageId);
                    },
                    remove: function (event) {
                        event.preventDefault();
                        var $this = $(event.target);
                        var message = $this.parents('div.message-and-feedback');
                        var messageId = message.data('messageId');
                        removeMessage(messageId);
                    }
                }
            });
        } catch (e) {
        }
    }

    function prepareMessages(messages) {
        var prepared = [];
        messages.forEach(function (value, index) {
            var createdAt = moment(value.send_date_time, 'ddd, DD MMM YYYY HH:mm:ss Z');
            var diff = moment().diff(createdAt, 'days');
            if(diff < 3){
                value.send_date_time = createdAt.calendar();
            }else{
                value.send_date_time = createdAt.format('DD/MM/YYYY');
            }
            var eventDate = value.chat_room.event.starting_date;
            value.chat_room.event.starting_date = moment(eventDate, 'DD/MM/YYYY').format('DD MMM YY');
            prepared.push(value);
        });
        return prepared;
    }
    
    function getAllMessagesByEventId(eventId, filter) {
        if (typeof filter == "undefined") {
            filter = '';
        }
        $.ajax({
            url: '/api/events/' + eventId + '/messages' + filter,
            success: function (response) {
                if (typeof response.messages !== 'undefined') {
                    messagesVue.messages = prepareMessages(response.messages);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function prepareFeedbacks(feedbacks) {
        var prepared = {};
        feedbacks.forEach(function (value, index) {
            prepared[value.event.id] = value;
        });

        return prepared;
    }

    function getNewFeedbacks() {
        $.ajax({
            url: '/api/feedbacks/artist/new',
            method: 'GET',
            success: function (response) {
                if (typeof response.feedbacks !== 'undefined') {
                    messagesVue.feedbacks = prepareFeedbacks(response.feedbacks);
                }
            },
            error: function () {

            }
        });
    }

    function getAllMessagesByArtist(filter) {

        getNewFeedbacks();

        if (typeof filter == "undefined") {
            filter = '';
        }
        $.ajax({
            url: '/dashboard/messages/artist' + filter,
            success: function (response) {
                if (typeof response.messages !== 'undefined') {
                    messagesVue.messages = prepareMessages(response.messages);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $('.messages #sortMessages').on('select2:select', function () {
        var filter = '/' + $(this).val();
        if (window.getUserRole()[0] == 'ROLE_CLIENT') {
            var eventId = window.getCurrentEvent().id;
            getAllMessagesByEventId(eventId, filter);
        } else if (window.getUserRole()[0] == 'ROLE_ARTIST') {
            getAllMessagesByArtist(filter);
        }
    });

    function archiveMessage(messageId) {
        $.ajax({
            url: '/dashboard/archived/message/' + messageId,
            method: 'POST',
            success: function () {
                $('article[data-message-id="' + messageId + '"]').remove();
            },
            error: function (error) {
                console.log(error)
            }
        })
    }

    function removeMessage(messageId) {
        $('div[data-message-id="' + messageId + '"]').remove();
    }

    function showMessages() {
        $('.dialogs').show();
    }

    window.getAllMessagesByEventId = getAllMessagesByEventId;
    window.getAllMessagesByArtist = getAllMessagesByArtist;
});