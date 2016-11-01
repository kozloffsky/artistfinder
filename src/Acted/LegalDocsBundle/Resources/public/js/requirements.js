;(function(window){
    'use strict';
    var artist = null;

    try {
        artist = JSON.parse(localStorage.getItem("user")).artistId;
    } catch (e) {

    }

    window.TechReqObj = {
        count: 0,
        artistID: artist,
        endpoints: {
            techreq: {
                get: function(artistID) {
                    return {
                        method: "GET",
                        url:    "/technical_requirement/artist/" + artistID
                    }
                },
                create: function() {
                    return {
                        method: "POST",
                        url:    "/technical_requirement/create"
                    }
                },
                edit: function(id) {
                    return {
                        method: "PUT",
                        url:    "/technical_requirement/" + id + "/edit"
                    }
                },
                delete: function(id) {
                    return {
                        method: "DELETE",
                        url:    "/technical_requirement/"+ id +"/remove"
                    }
                }
            },
            files: {
                /**
                 * List of files
                 *
                 * Gets array of files
                 */
                upload: function() {
                    return {
                        method: "POST",
                        url:    "/technical_requirement/document/upload"
                    }
                },
                /**
                 *  Deletes specified file
                 */
                delete: function(id) {
                    return {
                        method: "DELETE",
                        url:    "/technical_requirement/document/"+ id +"/remove"
                    }
                }
            }
        },

        newTechReqTemplate: function() {
            TechReqObj.count = $(".requirements .row .col").length + 1;

            var html = '<div class="col">\
                            <div class="add-box">\
                                <span class="text">Add requirement</span>\
                                <button class="btn" add-box>Add</button>\
                            </div>\
                        </div>';

            $('.requirements .container > .row').append(html);
        },
        createDynamicForm: function(obj) {
            return '<div class="col">\
                        <form class="requirement-form" action="#" tech-id="'+ obj.id +'" type="multipart/form-data">\
                            <h2>Technical Request '+ obj.number +'</h2>\
                            <input type="text" placeholder="'+ obj.title +'" value="'+ obj.title +'" onkeydown="TechReqObj.handleTextInput()" edit-title>\
                            <textarea class="textarea" placeholder="'+ obj.description +'" onkeydown="TechReqObj.handleTextInput()" edit-descr>'+ obj.description +'</textarea>\
                            <div class="row">\
                                <input type="file" name="document_technical_requirement[files]" multiple="multiple" req_files>\
                            </div>\
                            <button type="button" class="btn-close" remove-box>Close</button>\
                        </form>\
                    </div>';
        },
        /**
         * Creates a new Technical Request
         */
        createNewTechReq: function(cb) {
            TechReqObj.count = $(".requirements .row .col").length;

            var
                req = TechReqObj.endpoints.techreq.create(),
                techrequestObj = {
                    technical_requirement: {
                        title: "Technical requirement " + TechReqObj.count,
                        description: "Description",
                        artist: TechReqObj.artistID
                    }
                };

            $.ajax({
                url:  req.url,
                type: req.method,
                data: techrequestObj,
                success: cb,
                error: cb
            });
        },
        /**
         * Adds a dynamic form for new Technical Requirement
         */
        addBox: function() {

            TechReqObj.createNewTechReq(function(res) {
                var tech = res.technicalRequirement;
                $(".requirements .row .col").last().remove();

                tech.number = $(".requirements .row .col").length + 1;

                var html = TechReqObj.createDynamicForm(tech);
                $('.requirements .container > .row').append(html);
                var input = $('.requirements form[tech-id='+tech.id+'] input[req_files]');
                TechReqObj.applyFiler(input, tech.id);
                TechReqObj.newTechReqTemplate();
            });
        },
        /**
         * Edit a existing Technical Request
         */
        confirmEditTechReq: function(obj) {
            var req = TechReqObj.endpoints.techreq.edit(obj.id);

            $.ajax({
                url:  req.url,
                type: req.method,
                data: obj,
                success: function() {},
                error:   function() {}
            });
        },
        editTechnicalReqTitle: function () {
            var
                id    = $(this).closest("form").attr("tech-id"),
                title = $(this).val(),
                descr = $(this).next().val();

            var req = {
                id: id,
                technical_requirement: {
                    artist: TechReqObj.artistID,
                    title: title,
                    description: descr
                }
            };

            TechReqObj.confirmEditTechReq(req);
        },
        editTechnicalReqDescr: function() {
            var
                id    = $(this).closest("form").attr("tech-id"),
                title = $(this).prev().val(),
                descr = $(this).val();

            var req = {
                id: id,
                technical_requirement: {
                    artist: TechReqObj.artistID,
                    title: title,
                    description: descr
                }
            };

            TechReqObj.confirmEditTechReq(req);
        },
        /**
         * Handle input symbols length restrict
         */
        handleTextInput: function () {
            console.log(this);

            return true;
        },
        /**
         * Handler for deleting an existing Technical Requirement
         */
        removeTechBoxReq: function(id, cb) {
            var req = TechReqObj.endpoints.techreq.delete(id);

            $.ajax({
                type: req.method,
                url:  req.url,
                data: {},
                success: cb,
                error: cb
            });
        },
        /**
         * Deletes an existing Technical Requirement
         */
        removeBox: function() {
            var cur = $(this).closest("div.col");
            var techId = $(this).closest("form").attr("tech-id");

            TechReqObj.removeTechBoxReq(techId, cur.remove());
        },
        applyFiler: function(obj, techreqId, files) {

            var newFiles = [];

            if(Array.isArray(files))
              if(files.length)
                newFiles = files;

            var Filer = $(obj).filer({
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
                                      <span class="jFiler-item-title"><a href="/uploads/tr_documents/{{fi-name}}" title="{{fi-name}}">{{fi-name | limitTo: 12}}</a></span>\
                                      <a class="item-trash" item-id="{{fi-file_id}}"></a>\
                                  </li>',
                    itemAppend: '<li class="item">\
                                      <div class="jFiler-item-thumb">\
                                          <div class="jFiler-item-status"></div>\
                                          {{fi-image}}\
                                      </div>\
                                      <span class="jFiler-item-title"><a href="/uploads/tr_documents/{{fi-name}}" title="{{fi-name}}">{{fi-name | limitTo: 12}}</a></span>\
                                      <a class="item-trash" item-id="{{fi-file_id}}"></a>\
                                  </li>',
                    itemAppendToEnd: true,
                    removeConfirmation: true,
                    _selectors: {
                        list: '.items-list',
                        item: '.item',
                        remove: '.item-trash'
                    }
                },
                addMore: true,
                files: newFiles,
                uploadFile: {
                    url: '/technical_requirement/document/upload',
                    data: { 'document_technical_requirement[technical_requirement]': techreqId },
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    beforeSend: function(data){},
                    success: function(data){},
                    error: function(err){},
                    statusCode: null,
                    onProgress: null,
                    onComplete: null
                },
                onRemove: function(data) {
                  var id = $(data.context).attr("item-id");
                  var req = TechReqObj.endpoints.files.delete(id);

                  $.ajax({
                      url:  req.url,
                      type: req.method,
                      data: {},
                      success: function() {},
                      error:   function() {}
                  });
                }
            });
        }
    };

    var techListRequest = TechReqObj.endpoints.techreq.get(TechReqObj.artistID),
        techReqList = new Array(0);

    function appendFiles(obj, files) {
        var len = files.length,
            newFiles = new Array(0),
            techreqId = $(obj).closest("form[tech-id]").attr("tech-id");

        var types = {
            jpeg: 'image/jpeg',
            png: 'image/png',
            gif: 'image/gif',
            pdf: 'application/jpeg'
        };

        for(var k = 0; k < len; k++) {
            var file = files[k],
                newFile = {};

            newFile['name'] = file.name;
            newFile['size'] = file.size;
            newFile['type'] = types[file.name.split('.')[1]] || 'pdf';
            newFile['file'] = '/' + file.file;
            newFile['opts'] = {
              file_id: file.id
            };

            newFiles.push(newFile);

            file = null;
        }

        TechReqObj.applyFiler(obj, techreqId, newFiles);
    }

    if(artist && $(".requirements"))
      $.ajax({
          url:  techListRequest.url,
          type: techListRequest.method,
          data: {},
          success: function(req) {
              if(req && Array.isArray(req.technicalRequirements)){
                  var techReqList = req.technicalRequirements,
                      len = techReqList.length;

                  for(var i = 0; i < len; i++) {

                      var curObj = techReqList[i],
                          files  = techReqList[i].documentTechnicalRequirements;

                      curObj.number = i + 1;

                      $('.requirements .container > .row').append(TechReqObj.createDynamicForm(curObj));

                      var input = $('.requirements form[tech-id='+curObj.id+'] input[req_files]');

                      appendFiles(input, files);

                      curObj = null;
                  }

                  TechReqObj.newTechReqTemplate();
              }
          },
          error: function(req) {

          }
      });

    $(document)
        .on("click",    ".requirements [add-box]",    TechReqObj.addBox)
        .on("click",    ".requirements [remove-box]", TechReqObj.removeBox)
        .on("focusout", ".requirements [edit-title]", TechReqObj.editTechnicalReqTitle)
        .on("focusout", ".requirements [edit-descr]", TechReqObj.editTechnicalReqDescr)

})(this);
