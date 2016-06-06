$(function() {
    $('.act-request-message').each(function() {
        var $element = $(this);
        var $toggler = $element.find('.show-more-btn');
        var $text = $element.find('.text');
        var text = $text.html();
        var $heading = $element.find('.title');

        var maxLength = 0;

        if($(window).width() < 768) {
            maxLength = parseInt($element.attr('data-max-chars-mobile'));
        } else {
            maxLength = parseInt($element.attr('data-max-chars-desktop'));
        }

        if(text.length > maxLength) {
            var newText = text.substring(0, maxLength - 3) + '...';
            $text.html(newText);

            $element.attr('data-full-text', text);
            $element.addClass('expandable');

            $toggler.click(function(e) {
                e.preventDefault();
               if(!$element.hasClass('opened')) {
                   $text.html( $element.attr('data-full-text'));
                   $element.addClass('opened');
                   $toggler.html('-hide');
               } else {
                   $element.removeClass('opened');
                   var newText = $element.attr('data-full-text').substring(0, maxLength - 3) + '...';
                   $text.html(newText);
                   $toggler.html('+more');
               }
            });
        } else {
            $toggler.hide();
        }
    });

    $('.rejectRequest').on('click',function(){
        var eventId = $(this).parents('article').attr('id');
        rejectRequest(eventId)
    })

    function rejectRequest(id){
        console.log(id)
        $.ajax({
            type:'GET',
            url:'/event/change_status/reject/'+id+'?type=no_email',
            success: function(res){
                $('article#'+id).appendTo('.enquiries-wrap')
            }
        })
    }

    $('.archiveMessage').on('click',function(){
        var messageId = $(this).parents('article').attr('id');
        archiveMessage(messageId)
    })

    function archiveMessage(id){
        console.log(id)
        $.ajax({
            type:'POST',
            url:'/dashboard/archived/message/'+id,
            success: function(res){
                $('article#'+id).fadeOut();
            }
        })
    }

    $('#sortMessages').on('change',function(){
        var filterValueSelected = $(this).find('option:selected').val();
        messagesFilter(filterValueSelected)
    });

    function messagesFilter(val){
        var userId = $('header #userInformation').text();
        console.log(val)
        $.ajax({
            type:'GET',
            url:'/dashboard/filter/messages/'+userId+'?filters='+val,
            success: function(res){
                $('.messages .dialogs').empty();
                $(res).each(function(){
                    var viewMessages = '<article class="col-xs-12 dialog-section noselect" data-longtap-duration="500" id="'+this.id+'">'+
                        '<div class="wrap clearfix">'+
                        '<div class="avatar">'+
                        '<img src="'+this.sender_user.avatar+'" alt=""/>'+
                        '</div>'+
                        '<div class="user-info">'+
                        '<span class="user-name">'+this.sender_user.firstname+'</span>'+
                        '<span class="time">Today at 11:34 pm</span>'+
                        '</div>'+
                        '<div class="message-block">'+
                        '<div class="col-lg-10 col-sm-10 text-block">'+
                        '<p class="message-heading hidden-xs">Enquiry for '+this.chat_room.event.title+' / '+this.chat_room.event.city.name+'/ '+this.chat_room.event.starting_date+'</p>'+
                        '<div class="text">'+this.message_text+'</div>'+
                        '<div class="controls hidden-xs">'+
                        '<div class="button-gradient filled blue">'+
                        '<a href="/chat-room" class="btn register">See Conversation</a>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-lg-2 col-sm-2  message-controls no-pad">'+
                        '<ul class="ul-reset">'+
                        '<li class="status confirmed"><i class="confirmed"></i> '+this.chat_room.offer.event_offer[0].status+'</li>'+
                        '</ul>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</article>';
                    $('.messages .dialogs').append(viewMessages);
                })
            }
        })
    }

});