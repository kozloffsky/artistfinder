$(function(){
    'use strict';

    /*$('#filer_input1, #filer_input2, #filer_input3, #filer_input4').filer({
        limit: 2,
        maxSize: 10,
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
    });*/

    $('.requirements .add-box').on('click', function(){
        var cur = $(this);
        cur.closest('.col').find('.requirement-form').removeClass('hide');
    });

    $('.requirement-form .btn-close').on('click', function(){
        var cur = $(this);
        cur.closest('.col').find('.requirement-form').addClass('hide');
    });
});