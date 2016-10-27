$(function(){
    'use strict';

    /**
      * Techreq object
      */
    function TechReqObj() {
        this.name = "Technical Requirement";
        this.title = "";
        this.description = "";
        this.files = [];
    }

    function createNewTechReq() {
        var techReq = new TechReqObj();

        techReq.name += " "+num;

        // $.ajax({
        //     type: 'POST',
        //     data: techReq,
        //     url: '/add_new_tech',
        //     success: function(response){
        //
        //     },
        //     error: function(err) {
        //
        //     }
        // });
    }


    function addTechReqTemplate() {

      var count = $(".requirements .row .col").length;

      var html = '\
        <div class="col">\
            <div class="add-box">\
                <span class="text">Add requirement</span>\
                <button class="btn" add-box>Add</button>\
            </div>\
            <form class="requirement-form hide" action="#">\
                <h2>Technical requirement '+(count+1)+'</h2>\
                <input type="text" placeholder="Name">\
                <textarea class="textarea" placeholder="Write your description here"></textarea>\
                <div class="row">\
                    <input type="file" name="files[]" multiple="multiple" req_files>\
                </div>\
                <button type="button" class="btn-close" remove-box>Close</button>\
            </form>\
        </div>\
        ';



      $(".requirements .row .col").last().after(html);
    }
    function removeTechReqBox() {

    }






    $('.requirements [req_files]').filer({
        maxSize: 10,
        changeInput: '<button type="button" class="btn-upload">Upload file</button>',
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
            itemAppendToEnd: true,
            removeConfirmation: false,
            _selectors: {
                list: '.items-list',
                item: '.item',
                remove: '.item-trash'
            }
        },
        addMore: true,
        files: [
            {
                name: "appended_file.jpg",
                size: 5453,
                type: "image/jpg",
                file: "/path/to/file.jpg",
                url: "http://path/to/link/file2.jpg"
            },
            {
                name: "appended_file_2.jpg",
                size: 9453,
                type: "image/jpg",
                file: "path/to/file2.jpg",
                url: "http://path/to/link/file2.jpg"
            }
        ]
    });

    function addBox() {
        var cur = $(this);
        cur.closest('.col').find('.requirement-form').removeClass('hide');

        addTechReqTemplate();
    };

    function removeBox() {
        var cur = $(this);
        cur.closest('.col').find('.requirement-form').addClass('hide');

        removeTechReqBox();
    };


    $(document)
      .on("click", ".requirements [add-box]", addBox)
      .on("click", ".requirements [remove-box]", removeBox);

});
