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
        FILES: [],
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
                            <input name="title" type="text" placeholder="'+ obj.title +'" value="'+ obj.title +'" onkeydown="TechReqObj.handleTextInput()" edit-title>\
                            <textarea name="description" class="textarea" placeholder="'+ obj.description +'" onkeydown="TechReqObj.handleTextInput()" edit-descr>'+ obj.description +'</textarea>\
                            <div class="row">\
                                <label for="tech_file_'+ obj.id+ '" class="btn-upload">Upload file</label>\
                                <input id="tech_file_'+ obj.id+ '" class="btn-upload" type="file" name="document_technical_requirement[files][]" multiple req_files>\
                                <ul class="items-list">\
                                </ul>\
                            </div>\
                            <button type="button" class="btn-close" remove-box>Close</button>\
                            <div class="progress-bar-line">\
                            </div>\
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

                applyUploader(input, { id: tech.id });
                $('.requirements form[tech-id="'+tech.id+'"]').validate({
                    rules: {
                        title: {
                            required: true
                        },
                        description: {
                            required: true
                        }
                    },
                    messages: {
                        title: {
                            required: 'You need to provide title for technical requirement!'
                        },
                        description: {
                            required: 'You need to provide description for technical requirement!'
                        }
                    }
                });
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
                title = $(this).val().trim(),
                descr = $(this).next().val().trim();

            $('.requirements form[tech-id='+id+']').valid();

            if(title != '' && descr != '') {
                var req = {
                    id: id,
                    technical_requirement: {
                        artist: TechReqObj.artistID,
                        title: title,
                        description: descr
                    }
                };

                TechReqObj.confirmEditTechReq(req);
            }
        },
        editTechnicalReqDescr: function() {
            var
                id    = $(this).closest("form").attr("tech-id"),
                title = $(this).prev().val().trim(),
                descr = $(this).val().trim();

            $('.requirements form[tech-id='+id+']').valid();

            if(title != '' && descr != '') {
                var req = {
                    id: id,
                    technical_requirement: {
                        artist: TechReqObj.artistID,
                        title: title,
                        description: descr
                    }
                };

                TechReqObj.confirmEditTechReq(req);
            }
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
        /**
         * Delete a file from form and from server
         */
        removeFile: function() {
            var $this = $(this);
            var id = $this.attr("item-id");
            var req = TechReqObj.endpoints.files.delete(id);

            $.ajax({
                url:  req.url,
                type: req.method,
                data: {},
                success: function() {
                    $this.closest("li").remove();
                },
                error:   function() {}
            });
        }
    };

    function  applyUploader(input, obj) {
        input.fileupload({
            url: '/technical_requirement/document/upload',
            formData: {
                'document_technical_requirement[technical_requirement]': obj.id
            },
            singleFileUploads: false,
            add: function(e, data) {
                var uploadErrors = [];
                var acceptFileTypes = /^image\/(gif|jpe?g|png)$|^application\/(pdf|msword|zip|vnd.openxmlformats-officedocument.wordprocessingml.document|vnd.ms-excel|vnd.openxmlformats-officedocument.spreadsheetml.sheet)$|^text\/plain$/i;

                var id = input.attr("id");
                var li = $('#'+id).closest("form").find("div.row .items-list").find('li');

                var selectedFilesCount = data.files.length,
                    currentFilesCount = li.length,
                    checkSum = selectedFilesCount + currentFilesCount;

                if(checkSum > 3) {
                    uploadErrors.push('Max number of files exceeded!');
                }

                if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                    uploadErrors.push('Not an accepted file type');
                }

                if(data.originalFiles[0]['size'].length && data.originalFiles[0]['size'] > 10000) {
                    uploadErrors.push('Filesize is too big');
                }

                if(uploadErrors.length > 0) {
                    alert(uploadErrors.join("\n"));
                } else {
                    data.submit();
                }
            },
            done: function (e, data) {
                var files = data.result,
                    input = data.fileInput.attr("id");

                if(files.length) {
                    $('#'+input).closest("form").find("div.row .items-list").append(thumbGenerator(files));
                }
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);

                var input = $(this).attr("id");

                var progressBar = $('#'+input).closest("form").find('.progress-bar-line');

                progressBar.fadeIn( "fast" );
                progressBar.css('width',progress + '%');
                progressBar.text(progress + ' %')

                setTimeout(function() {
                    progressBar.fadeOut( "slow" );
                }, 1200);
            }
        });

        input.bind('fileuploadstart', function (e, data) {

        });
        input.bind('fileuploadfail', function (e, data) {
            alert(e, data.response().responseJSON.errors[0])
        });
    }

        window.applyUploader = applyUploader;


    function thumbGenerator(files) {
        var html = '',
            count = files.length;

        for(var i = 0; i < count; i++) {
            var f = files[i];

            var regex = /\.(txt|pdf|zip|json|doc|docx)$/i,
                name = regex.exec(f.name),
                fileExt = name ? name[0] : null,
                thumb = '';

            if(regex.test(fileExt)) {

                var types = {
                    '.zip': 'f-file-ext-zip',
                    '.doc': 'f-file-ext-zip',
                    '.docx': 'f-file-ext-zip',
                    '.xls': 'f-file-ext-zip',
                    '.xlsx': 'f-file-ext-zip',
                    '.pdf': 'f-file-ext-pdf',
                    '.txt': 'f-file-ext-txt',
                    '.json': 'f-file-ext-json',
                },
                fileClass = types[fileExt];

                thumb = '<span class="jFiler-icon-file f-file '+ fileClass +'">' + fileExt + '</span>';
            } else {
                thumb = '<img class="" src="/'+f.file+'">';
            }

            html += '<li class="item">\
                        <div class="jFiler-item-thumb">\
                            <div class="jFiler-item-status"></div>\
                            <div class="jFiler-item-thumb-image">\
                                '+thumb+'\
                            </div>\
                        </div>\
                        <span class="jFiler-item-title"><a href="/'+f.file+'" title="'+f.originalName+'" class="title">'+f.originalName+'</a></span>\
                        <a delete-file class="item-trash" item-id="'+f.id+'"></a>\
                    </li>';
        }

        return html;
    }

    var techListRequest = TechReqObj.endpoints.techreq.get(TechReqObj.artistID),
        techReqList = new Array(0);

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

                      var input = $('.requirements form[tech-id="'+curObj.id+'"] input[req_files]');

                      applyUploader(input, curObj);

                      var html = thumbGenerator(files);
                      input.closest(".row").find('.items-list').append(html);

                      $('.requirements form[tech-id="'+curObj.id+'"]').validate({
                          rules: {
                              title: {
                                  required: true
                              },
                              description: {
                                  required: true
                              }
                          },
                          messages: {
                              title: {
                                  required: 'You need to provide title for technical requirement!'
                              },
                              description: {
                                  required: 'You need to provide description for technical requirement!'
                              }
                          }
                      });

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
        .on("click",    ".requirements [delete-file]",TechReqObj.removeFile)

})(this);
