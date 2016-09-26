$(function(){
    'use strict';

    var win = $(window),
        note = $('.month-table tbody td').find('.note > div[class^="s-"]'),
        notePd = (parseInt(note.css('padding-left')) * 2) + 2,
        newNotes,
        tdWidth,
        newTd,
        num,
        sum;

    // bxslider init
    /*$('.bxslider').bxSlider({
        adaptiveHeight: true,
        mode          : 'fade',
        nextSelector  : '#nextSlide',
        prevSelector  : '#prevSlide',
        pager         : false
    });*/

    // add animate to note
    $('.month-table .note').on({
        'click': function(){
            var cur = $(this);
            if(!cur.hasClass('active') && cur.find('span').width() > cur.find('div').width()){
                if(cur.find('span').outerWidth() > 110){
                    cur.addClass('slowly');
                }
                cur.addClass('active');
                cur.find('div').append(cur.find('span').clone());
            } else {
                cur.removeClass('active');
                cur.removeClass('slowly');
                cur.find('span').eq(1).remove();
            }
        }
    });

    win.on({
        'load resize orientationchange': function(){
            getNoteWidth();
        }
    });

    // get width of the note in calendar
    function getNoteWidth(){
        // get width of td in month table
        tdWidth = $.map($('.month-table tbody tr:first td'), function(val){
            return $(val).outerWidth();
        });

        // get index of note, set width for note
        newNotes = $.each(note, function(i, item){
            num = parseInt($(item).attr('class').replace(/\D+/g,""), 10);
            newTd = tdWidth.slice(item.closest('td').cellIndex, item.closest('td').cellIndex + num);
            sum = newTd.reduce(function(a, b){
                return a + b;
            }, 0);
            $(item).width(sum - notePd);
        });
    };

});