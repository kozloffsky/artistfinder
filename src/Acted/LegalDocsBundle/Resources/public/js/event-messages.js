$(function () {
    'use strict';
    if (document.querySelector('.messages')) {
        try{
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
        }catch (e){
        }
    }

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

    function getAllMessagesByArtist(filter) {
        if (typeof filter == "undefined") {
            filter = '';
        }
        $.ajax({
            url: '/dashboard/messages/artist' + filter,
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
        var filter = '/' + $(this).val();
        if(window.getUserRole()[0] == 'ROLE_CLIENT'){
            var eventId = window.getCurrentEvent().id;
            getAllMessagesByEventId(eventId, filter);
        }else if(window.getUserRole()[0] == 'ROLE_ARTIST'){
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
    window.getAllMessagesByArtist = getAllMessagesByArtist;
});