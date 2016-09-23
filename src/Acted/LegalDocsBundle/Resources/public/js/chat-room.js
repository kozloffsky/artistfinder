$(function(){
    'use strict';

    function initialize() {
        var myLatlng = new google.maps.LatLng(-34.397, 150.644);
        var myOptions = {
            zoom: 8,
            center: myLatlng,
            disableDefaultUI: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), myOptions);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(-34.397, 150.644)
        });
        marker.setMap(map);
    }

    initialize();

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
});