$(function(){
    'use strict';
    if (document.querySelector('.chat-room')) {
        try {

            var vue = new Vue({
                el: '.chat-room',
                delimiters: ['${', '}'],
                data: {
                    message: '',
                    chatMessages: window.chatMessages,
                    sendText: "",
                    technicalRequirements: [],
                    selectedRequirement: {},
                    _requirementsAccepted: false,
                    _timingAccepted: false,
                    _actsExtrasAccepted: false,
                    _detailsAccepted: false,
                    userRole: "",
                    termsConditionsAccepted: false,
                    contactName:"",
                    contactPerson:"",
                    contactPhone:"",
                    contactEmail:"",
                    editable:true
                },

                computed:{
                    requirementsAccepted: {
                        get: function () {
                            return this._requirementsAccepted;
                        },
                        
                        set: function (val) {
                            var self = this;
                            this.acceptField(window.getOrderId(), window.getAcceptFieldTypes().technicalRequirements, Number(val), function () {
                                self._requirementsAccepted = val;
                                //self.$forceUpdate();
                            });
                        }
                    },

                    timingAccepted: {
                        get: function () {
                            return this._timingAccepted;
                        },

                        set: function (val) {
                            var self = this;
                            this.acceptField(window.getOrderId(), window.getAcceptFieldTypes().timing, Number(val), function () {
                                self._timingAccepted = val;
                                //self.$forceUpdate();
                            });
                        }
                    },

                    actsExtrasAccepted: {
                        get: function () {
                            return this._actsExtrasAccepted;
                        },

                        set: function (val) {
                            var self = this;
                            this.acceptField(window.getOrderId(), window.getAcceptFieldTypes().actsExtras, Number(val), function () {
                                self._actsExtrasAccepted = val;
                                //self.$forceUpdate();
                            });
                        }
                    },

                    detailsAccepted: {
                        get: function () {
                            return this._detailsAccepted;
                        },

                        set: function (val) {
                            var self = this;
                            this.acceptField(window.getOrderId(), window.getAcceptFieldTypes().details, Number(val), function () {
                                self._detailsAccepted = val;
                            });
                        }
                    },

                    bookingAllowed: {
                        cache: false,
                        get: function () {
                            if(window.userRole == 'ROLE_ACTOR'){
                                return false;
                            }
                        if(this._actsExtrasAccepted == true &&
                            this._detailsAccepted == true &&
                            this._timingAccepted == true &&
                            this._requirementsAccepted == true){

                            return false
                        };
                        return true;
                        }
                    }
                },
                created: function () {
                    console.log('WWWWWWWWWWWWWWWWW');
                    this.fetchTechnicalRequirements();
                    this.userRole = window.userRole;
                    this._requirementsAccepted = window.order.technicalRequirementsAccepted;
                    this._timingAccepted = window.order.timingAccepted;
                    this._actsExtrasAccepted = window.order.actsExtrasAccepted;
                    this._detailsAccepted = window.order.detailsAccepted;
                    var data = {}
                    if(window.order.status > 1){
                        this.editable = false;
                        if(this.userRole == 'ROLE_CLIENT'){
                            data = window.actorDetails;
                        }else{
                            data = window.clientDetails;
                        }
                    }else{
                        if(this.userRole == 'ROLE_CLIENT'){
                            data = window.clientDetails;
                        }else{
                            data = window.actorDetails;
                        }
                    }
                    this.setDetails(data);
                    console.log(window.order);

                },
                
                methods: {
                    showConfirmModal: function () {
                        $('#confirmBookingModal').modal('show');
                        console.log('Showing modal');
                    },
                    
                    fetchTechnicalRequirements: function () {
                        var self = this;
                        console.log("fetching tech reqs");
                        $.ajax({
                            type: 'GET',
                            url: '/technical_requirement/artist/' + window.artistId,
                            success: function (r) {
                                console.log(r);
                                self.technicalRequirements = r.technicalRequirements;
                                if(self.technicalRequirements.length > 0) {
                                    self.selectedRequirement = self.technicalRequirements[0];
                                }
                            },
                            error: function (r) {
                                //messageReaded = false;
                                console.error(r);
                            }
                        });
                    },
                    
                    setDetails: function (data) {
                        this.contactEmail = data.email;
                        this.contactName = data.name;
                        this.contactPerson = data.person;
                        this.contactPhone = data.phone;
                    },

                    setTypesForFiles: function () {

                    },

                    acceptField: function (orderId, fieldId, value, callback) {
                        if (isNaN(value)){
                            value = 0;
                        }
                        $.ajax({
                            method:"GET",
                            url:"/order/accept/"+orderId+"/"+fieldId+"/"+value,
                            success: function (r) {
                                console.log(r);
                                if (callback){
                                    callback();
                                }
                            }

                        });
                    },

                    deleteAttachment: function (id) {
                        console.log(id);
                        $.ajax({
                            method: "DELETE",
                            url: "/technical_requirement/document/" + id + "/remove",
                            success: function (r) {
                                console.log(r)
                            },
                            error: function (e) {
                                console.log(e);
                            }
                        })
                    },

                    proceedToPayment: function(){
                            window.location = "/order/pay/"+window.getOrderId();
                    },

                    saveDetails: _.debounce(function(e){
                        var data = {
                            'c-email': this.contactEmail,
                            'c-name': this.contactName,
                            'c-phone': this.contactPhone,
                            'c-person': this.contactPerson,
                        }
                        console.log(data);
                        $.ajax({
                            method:"POST",
                            data:data,
                            url: "/order/save_details/"+window.getOrderId()
                        })
                    }, 300)
                },
                filters: {
                    removeExt: function (value) {
                        return value.substring(0, value.indexOf('.'))
                    }
                }

            });
        } catch (e) {
        }
    }
    function getTechnicalRequirements(){

    }

    getTechnicalRequirements();

    function initializeMap(eventLocationMap) {
        // var myLatlng = new google.maps.LatLng(eventLocationMap.latitude, eventLocationMap.longitude);
        // var myOptions = {
        //     zoom: 8,
        //     center: myLatlng,
        //     disableDefaultUI: true,
        //     mapTypeId: google.maps.MapTypeId.ROADMAP
        // };
        // var map = new google.maps.Map(document.getElementById("map"), myOptions);
        // var marker = new google.maps.Marker({
        //     position: new google.maps.LatLng(eventLocationMap.latitude, eventLocationMap.longitude)
        // });
        // marker.setMap(map);
    }

    initUploadFilesFiller();

    $('.chat-room .quote-section button[edit-order]').click(openQuotationModal);

    function initUploadFilesFiller(){
        $('#filer_input1').filer({
            limit: 10,
            maxSize: 40,
            changeInput: '<button type="button" class="btn-upload">Upload</button>',
            showThumbs: true,
            extensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'zip'],
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
    }

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
        var commentsList = $('.comments-list');

        function commentsListScroll() {
            if ($('.comments-list').isVisible()) {
                setTimeout(function(){
                    markMessageAsRead(chatId);
                }, 1500);
            }
            return false;
        }

        if(commentsList.length) {
            $(window).scroll(commentsListScroll);
        }
    }

    var messageReaded = false;

    function markMessageAsRead(chatId){
        if (messageReaded == false){
            //console.log(messageReaded)
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

    getFileExtension();

    function getFileExtension(){
        $('.comments-list li .holder').each(function(){
            findFilesInChat(this);
        });
        function findFilesInChat(fileElem){
            var filesInChat = $(fileElem).find('a');
            $(filesInChat).each(function(){
                var fileName = $(this).attr('href'),
                    fileExtension = fileName.split('.').pop();
                if(fileExtension == 'pdf'){
                    //console.log('pdf');
                    $(this).find('img').attr('src', '/assets/images/pdf.png');
                } else if (fileExtension == 'zip'){
                    $(this).find('img').attr('src', '/assets/images/zip.png');
                }
            })
        }
    }

    function chatSocket(chatId){
        var webSocket = WS.connect("ws://51.254.217.4:8686");
        //var webSocket = WS.connect("ws://192.168.33.12:8686");

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
        });

        webSocket.on("socket/connect", function(session){
console.log('connected to socket');
            //the callback function in "subscribe" is called everytime an event is published in that channel.
            session.subscribe('acted/chat/'+chatId+'', function(uri, payload){
                postMessage(payload)
            });

            $(function () {
                $(document).on('click', '#sendMsg', function (ev) {
                    ev.preventDefault();
                    var text = $('#chat-room').val();
                    var dataFiles = new FormData();
                    /*$('.chatFileUpload').each(function(){
                        dataFiles.append('files[]', $(this)[0].files[0]);
                    });*/
                    var formDataContent = [];
                    $.each($(".chatFileUpload"), function(i, obj) {
                        $.each(obj.files,function(j,file){
                            formDataContent.push(j);
                            dataFiles.append('files[]', file);
                        })
                    });
                    //console.log(formDataContent.length);
                    dataFiles.append('message', text);
                    if (text.length > 0 || formDataContent.length > 0) {
                        $.ajax({
                            type:'POST',
                            url: '/dashboard/web/push/'+chatId,
                            processData: false,
                            contentType: false,
                            data: dataFiles,
                            beforeSend: function () {
                                $('.chatMessageSending').fadeIn(500);
                            },
                            complete: function () {
                                $('.chatMessageSending').fadeOut(500);
                            },
                            success: function(){
                                $('#chat-room').val('');
                                $('.chatMessageSending').fadeOut(500);
                                if(formDataContent.length > 0){
                                    recreateUploader();
                                };
                                formDataContent = [];
                                //uploadFilesFiller.remove(0);
                            }
                        })
                    }
                });
            });

            function recreateUploader(){
                $('.message-form .upload-box .row').remove();
                var uploadTemplate = '<div class="row">'+
                    '<input type="file" name="files[]" id="filer_input1" class="chatFileUpload" multiple="multiple">'+
                    '</div>'+
                    '<div class="controls">'+
                    '<div class="button-gradient filled">'+
                    '<button class="btn" id="sendMsg" type="submit">Send</button>'+
                    '</div>'+
                    '</div>';
                $('.message-form .upload-box').prepend(uploadTemplate);
                initUploadFilesFiller();
            }


            function postMessage(messageChat){
                console.log(messageChat);
                if(messageChat.role){
                    var chatMessageFiles = '';
                    if(messageChat.file){
                        chatMessageFiles += '<p>';
                        $(messageChat.file).each(function(){
                            chatMessageFiles += '<a href="'+this.path+'"><img class="chatImage" src="'+this.path+'"></a>';
                        })
                        chatMessageFiles += '</p>';
                        //console.log(chatMessageFiles)
                    }
                    if (messageChat.msg){
                        var chatMessageText = '<pre>'+messageChat.msg+'</pre>';
                    } else {
                        var chatMessageText = '';
                    }

                    if(messageChat.role == 'Client')
                    {
                        var messageBlock = '<li>'+
                            '<a href="#" class="img-holder">'+
                            '<img src="/assets/images/noAvatar.png" alt="image description">'+
                            '</a>'+
                            '<div class="holder">'+
                            '<div class="box">'+
                            chatMessageFiles+
                            chatMessageText +
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
                            chatMessageFiles +
                            chatMessageText +
                            '<em class="date">'+messageChat.send_date+'</em>'+
                            '</div>'+
                            '</div>'+
                            '</li>';
                    }
                    //$('#twocolumns .comments-list').prepend(messageBlock);
                    vue.$data.chatMessages.unshift(messageChat);

                    getFileExtension();
                }
            }
        })
    }

    $().ready(chekUserReadedMessage);
});