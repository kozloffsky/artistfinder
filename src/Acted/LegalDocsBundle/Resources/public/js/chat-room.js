$(function(){
    'use strict';

    function initializeMap(eventLocationMap) {
        var myLatlng = new google.maps.LatLng(eventLocationMap.latitude, eventLocationMap.longitude);
        var myOptions = {
            zoom: 8,
            center: myLatlng,
            disableDefaultUI: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), myOptions);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(eventLocationMap.latitude, eventLocationMap.longitude)
        });
        marker.setMap(map);
    }



    $('#filer_input1').filer({
        limit: 10,
        maxSize: 40,
        changeInput: '<button type="button" class="btn-upload">Upload</button>',
        showThumbs: true,
        templates: {
            box: '<ul class="items-list"></ul>',
            item: '<li class="item">\
                    <div class="jFiler-item-thumb">\
                        <div class="jFiler-item-status"></div>\
                        {{fi-image}}\
                    </div>\
                    <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 12}}</b></span>\
                    <a class="item-trash"></a>\
                </li>',
            itemAppendToEnd: false,
            removeConfirmation: false,
            _selectors: {
                list: '.items-list',
                item: '.item',
                remove: '.item-trash'
            }
        },
        addMore: true
    });

    $('select').each(function () {
        var placeholder = $(this).attr('data-placeholder');
        var $select2    = $(this).select2({
            placeholder            : placeholder || '',
            minimumResultsForSearch: -1
        });

        var className = $(this).attr('data-class');
        $select2.data('select2').$selection.addClass(className);
        $select2.data('select2').$results.addClass(className);
    });

    $('#datetimepicker').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    createChat();
    function createChat(){
        var currentUrl = window.location.pathname;
        var matchesUrl = currentUrl.split('/');
        if (matchesUrl[2] == 'chat'){
            var chatId = $('#chatId').text();
            var eventLocationMap= {};
            eventLocationMap.latitude = $('#eventLocationCoordinates .latitude').text();
            eventLocationMap.longitude = $('#eventLocationCoordinates .longitude').text();
            initializeMap(eventLocationMap);
            chatSocket(chatId);
            chekUserReadedMessage(chatId);
        }
    }



    function chekUserReadedMessage(chatId){
        $(window).scroll(function() {
            if ($('.comments-list').isVisible()) {
                setTimeout(function(){
                    markMessageAsRead(chatId);
                }, 1500);
            }
            return false;
        });
    }

    var messageReaded = false;

    function markMessageAsRead(chatId){
        if (messageReaded == false){
            console.log(messageReaded)
            messageReaded = true;
            $.ajax({
                type:'POST',
                url: '/dashboard/read_message/'+chatId,
                success: function(){
                    messageReaded = true;
                },
                error: function(){
                    messageReaded = false;
                }
            })
        }
    }

    function chatSocket(chatId){
        var webSocket = WS.connect("ws://127.0.0.1:1337");

        /**
         * connect
         */
        webSocket.on("socket/connect", function(session){
            console.log("Successfully Connected!");
        })

        /**
         * disconnect
         */
        webSocket.on("socket/disconnect", function(error){
            console.log("Disconnected for " + error.reason + " with code " + error.code);
        })

        webSocket.on("socket/connect", function(session){

            //the callback function in "subscribe" is called everytime an event is published in that channel.
            session.subscribe('acted/chat/'+chatId+'', function(uri, payload){
                postMessage(payload)
            });

            $(function () {
                $(document).on('click', '#sendMsg', function (ev) {
                    ev.preventDefault();
                    var text = $('#chat-room').val();
                    //var dataFiles = $('#filer_input1')[0].files[0];
                    var dataFiles = new FormData();
                    dataFiles.append('files', $('#filer_input1')[0].files[0]);
                    dataFiles.append('message', text);
                    console.log(dataFiles)
                    if (text.length >= 0) {
                        /*$.post('/dashboard/web/push/'+chatId+'',{
                            'message': text,
                            'file': dataFiles
                        });*/
                        $.ajax({
                            type:'POST',
                            url: '/dashboard/web/push/'+chatId,
                            processData: false,
                            contentType: false,
                            data: dataFiles
                        })
                    }

                });
            });

            function postMessage(messageChat){
                console.log(messageChat)
                if(messageChat.role){
                    if(messageChat.role == 'Client')
                    {
                        var messageBlock = '<li>'+
                            '<a href="#" class="img-holder">'+
                            '<img src="/assets/images/noAvatar.png" alt="image description">'+
                            '</a>'+
                            '<div class="holder">'+
                            '<div class="box">'+
                            '<p>'+messageChat.msg+'</p>'+
                            '<em class="date">'+messageChat.send_date+'</em>'+
                            '</div>'+
                            '</div>'+
                            '</li>';
                    } else {
                        var messageBlock = '<li class="right active">'+
                            '<a href="#" class="img-holder">'+
                            '<img src="'+messageChat.avatar+'" alt="image description">'+
                            '</a>'+
                            '<div class="holder">'+
                            '<div class="box">'+
                            '<p>'+messageChat.msg+'</p>'+
                            '<em class="date">'+messageChat.send_date+'</em>'+
                            '</div>'+
                            '</div>'+
                            '</li>';
                    }
                    $('#twocolumns .comments-list').prepend(messageBlock);
                }
            }
        })
    }
});