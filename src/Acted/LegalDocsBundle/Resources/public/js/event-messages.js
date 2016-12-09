$(function () {
    'use strict';

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
        watch: {
            "selectedFilter": function (newVal, oldVal) {
                console.log(newVal, oldVal);
            }
        },
        methods: {
            archive: function (event) {
                event.preventDefault();
                var $this = $(event.target);
                var message = $this.parents('article');
                var messageId = message.data('messageId');
                archiveMessage(messageId);
            },
            remove: function (event) {
                event.preventDefault();
                var $this = $(event.target);
                var message = $this.parents('article');
                var messageId = message.data('messageId');
                removeMessage(messageId);
            }
        }
    });

    function getAllMessagesByEventId(eventId, filter) {
        if (typeof filter == "undefined") {
            filter = '';
        }
        $.ajax({
            url: '/api/events/' + eventId + '/messages' + filter,
            success: function (response) {
                if (typeof response.messages !== 'undefined') {
                    messagesVue.messages = response.messages;
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $('.messages #sortMessages').on('select2:select', function () {
        var eventId = window.getCurrentEvent().id;
        var filter = '/' + $(this).val();
        getAllMessagesByEventId(eventId, filter);
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
        $.ajax({
            url: '/dashboard/delete/message/' + messageId,
            method: 'DELETE',
            success: function () {
                $('article[data-message-id="' + messageId + '"]').remove();
            },
            error: function (error) {
                console.log(error);
            }
        })
    }

    function showMessages() {
        $('.dialogs').show();
    }

    window.getAllMessagesByEventId = getAllMessagesByEventId;
});