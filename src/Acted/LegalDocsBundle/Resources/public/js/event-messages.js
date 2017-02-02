$(function () {
    'use strict';
    if (document.querySelector('.messages')) {
        try {
            var messagesVue = new Vue({
                el: '.messages',
                delimiters: ['${', '}'],
                data: {
                    messages: [],
                    selectedFilter: ''
                },
                created: function () {
                    showMessages();
                },
                methods: {
                    archive: function (event) {
                        event.preventDefault();
                        var $this = $(event.target);
                        var message = $this.parents('article[data-chatroom-id]');
                        var chatRoomId = message.data('chatroomId');
                        archiveMessage(chatRoomId);
                    },
                    remove: function (event) {
                        event.preventDefault();
                        var $this = $(event.target);
                        var message = $this.parents('article[data-chatroom-id]');
                        var chatRoomId = message.data('chatroomId');
                        removeMessage(chatRoomId);
                    }
                }
            });
        } catch (e) {
        }
    }

    function prepareMessages(messages, feedbacks) {
        var prepared = [];
        messages.forEach(function (value) {
            var createdAt = moment(value.send_date_time, 'ddd, DD MMM YYYY HH:mm:ss Z');
            var diff = moment().diff(createdAt, 'days');
            value['timestamp'] = createdAt.format('X');
            if (diff < 2) {
                value.send_date_time = createdAt.calendar();
            } else {
                value.send_date_time = createdAt.format('DD/MM/YYYY');
            }
            var eventDate = value.chat_room.event.starting_date;
            console.log('ORDER: ', value.chat_room.order.status);
            value.chat_room.event.starting_date = moment(eventDate, 'DD/MM/YYYY').format('DD MMM YY');
            prepared.push(value);
        });
        if (window.getUserRole()[0] == 'ROLE_ARTIST'){
            feedbacks.forEach(function (item) {
                prepared.push(item);
            });
        }
        prepared = _.sortBy(prepared, 'timestamp').reverse();
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
                    messagesVue.messages = prepareMessages(response.messages.reverse());
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function prepareFeedbacks(feedbacks) {
        var prepared = [];
        feedbacks.forEach(function (item) {
            item['timestamp'] = moment(item.created_at, 'DD/MM/YYYY').format('X');
            prepared.push(item);
        });

        return prepared;
    }

    function getAllMessagesByArtist(filter, feedbacks) {

        if (typeof filter == "undefined") {
            filter = '';
        }
        $.ajax({
            url: '/dashboard/messages/artist' + filter,
            success: function (response) {
                if (typeof response.messages !== 'undefined') {
                    messagesVue.messages = prepareMessages(response.messages, feedbacks);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function getNewFeedbacks() {
        $.ajax({
            url: '/api/feedbacks/artist',
            method: 'GET',
            success: function (response) {
                if (typeof response.feedbacks !== 'undefined') {
                    var feedbacks = prepareFeedbacks(response.feedbacks);
                    getAllMessagesByArtist(undefined, feedbacks);
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
            if (filter.search('all') > -1) {
                getNewFeedbacks();
            } else {
                getAllMessagesByArtist(filter);
            }
        }
    });

    function archiveMessage(messageId) {
        $.ajax({
            url: '/dashboard/archived/chat-room/' + messageId,
            method: 'POST',
            success: function () {
                $('article[data-chatroom-id="' + messageId + '"]').remove();
            },
            error: function (error) {
                console.log(error)
            }
        })
    }

    function removeMessage(chatRoomId) {
        $.ajax({
            url: '/dashboard/chat-room/' + chatRoomId + '/hide',
            method: 'DELETE',
            success: function (response) {
                $('article[data-chatroom-id="'+ chatRoomId +'"]').remove();
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    function showMessages() {
        $('.dialogs').show();
    }

    window.getAllMessagesByEventId = getAllMessagesByEventId;
    window.getNewFeedbacks = getNewFeedbacks;
});