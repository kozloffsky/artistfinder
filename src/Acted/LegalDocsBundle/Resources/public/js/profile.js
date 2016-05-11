$(function() {

    $('.header-background').appendTo('header');

    setRaitingStars();

    function setRaitingStars() {
        var raiting = $('#raitingVal').text();
        var raitingFull = raiting.toString().split(".")[0];
        var raitingDigits = raiting.toString().split(".")[1];
        var ratingstars = $('.user-rating .star');
        var getFullStars = $(ratingstars).slice(0, raitingFull);
        var getHalfStars = $(ratingstars).eq(raitingFull);
        $(getFullStars).children('.fill-star').css('width', '100%');
        $(getHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
        var feedbackStars = $('#feedbacks .star');
        var getFeedbackFullStars = $(feedbackStars).slice(0, raitingFull);
        var getFeedbackHalfStars = $(feedbackStars).eq(raitingFull);
        $(getFeedbackFullStars).children('.fill-star').css('width', '100%');
        $(getFeedbackHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
    }

    $(".navbar-nav li a").click(function (event) {
        $(".navbar-collapse").collapse('hide');
    });




    var imageSlider = console.log('')
         if (($('.bxslider li').length) >= 1) {
            $('.bxslider').bxSlider({
                adaptiveHeight: true,
                mode: 'fade',
                pagerCustom: '#photo-pager',
                nextSelector: '#nextSlide',
                prevSelector: '#prevSlide',
                nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
                prevText: '<i class="left fa fa-3x fa-angle-left"></i>'
            });
        } else {
            console.log('ffffff')
        }



    var videoSlider = console.log('ffff')
    if (($('.bxVideoSlider li').length) >= 1) {
        $('.bxVideoSlider').bxSlider({
            adaptiveHeight: true,
            mode: 'fade',
            useCSS: false,
            video: true,
            pagerCustom: '#video-pager',
            nextSelector: '#nextVideoSlide',
            prevSelector: '#prevVideoSlide',
            nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
            prevText: '<i class="left fa fa-3x fa-angle-left"></i>',
            onSliderLoad: function () {
                $('#section-video').hide();
            }
        });
    } else {
        $('#section-video').hide();
        console.log('ffffff')
    }

    /*$('#video-pager img').each(function(){
     var videoThumbId = $(this).attr('id');
     getVideoThumbnails(videoThumbId)
     });

     function getVideoThumbnails(id){
     $.ajax({
     type:'GET',
     url: 'http://vimeo.com/api/v2/video/' + id + '.json',
     jsonp: 'callback',
     dataType: 'jsonp',
     success: function(data){
     var thumbnail_src = data[0].thumbnail_medium;
     var thumbs = document.getElementById(id);
     $(thumbs).attr('src', thumbnail_src);
     }
     });
     }*/

    function resizeThumbs() {
        $('.scale-thumb').each(function () {
            var height = $(this).width() * 0.69;
            $(this).height(height);
        });

        //Resize navbar-collapsed
        if ($(window).width() < 992) {
            $('.navbar-collapse').css('max-height', $(window).height() - 70 + 'px');
        } else {
            $('.navbar-collapse').css('max-height', '340px');
        }
    }

    function changeHeaderColorOnScroll() {
        if ($('body').scrollTop() > $('header').offset().top + 100) {
            $('.navbar').css('background-color', '#2228A3');
            $('.divider-vertical').css('background-color', 'rgba(24, 28, 127, 0.14)');
        } else {
            $('.navbar').css('background-color', 'rgba(59,68,235, 0.33)');
            $('.divider-vertical').css('background-color', 'rgba(4, 6, 64, 0.14)');
        }
    }

    resizeThumbs();
    changeHeaderColorOnScroll();

    $(window).resize($.throttle(250, resizeThumbs));
    $(window).scroll($.throttle(100, changeHeaderColorOnScroll));

    $('a.anchor-scroll').click(function () {
        $('html, body').animate({
            scrollTop: ($($.attr(this, 'href')).offset().top - 72)
        }, 500);
        return false;
    });

    $('.media a.tab').click(function () {

        $('.media a.tab').removeClass('active');
        $('.media-content').hide();

        $($.attr(this, 'data-target')).show();

        $(this).addClass('active');

        resizeThumbs();
        return false;
    });

    /*(function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5";
     fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));*/


    $('#editBiography').click(function (e) {
        e.stopPropagation();
        $('#biographyEditable').editable({
            type: 'textarea',
            mode: 'inline',
            success: function (response, newValue) {
                var slug = $('#slug').text();
                $.ajax({
                    type: "PATCH",
                    url: '/profile/' + slug + '/edit',
                    data: {"profile[description]": newValue}
                });
            }
        });
    });

    /*$('#editUsername').click(function(e) {
     e.stopPropagation();
     $('#username').editable({
     type: 'text',
     success: function(response, newValue) {
     var slug = $('#slug').text();
     $.ajax({
     type: "PATCH",
     url: '/profile/' + slug + '/edit',
     data: {"artist[name]": newValue}
     });
     }
     });
     });*/

    /*Dropzone.options.imagePerformanceChange = false;

    Dropzone.options.imagePerformanceChange = {
        maxFiles: 1,
        init: function () {
            this.on("success", function (file, responseText) {
                var removeButton = Dropzone.createElement('<div class="removeNewImage"><i class="fa fa-times-circle-o"></i></div>');
                var _this = this;
                removeButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Remove the file preview.
                    _this.removeFile(file);
                    var imageId = responseText.media.id
                    var slug = $('#slug').text();
                    $.ajax({
                        type: "DELETE",
                        url: '/profile/' + slug + '/media/' + imageId
                    })
                });

                file.previewElement.appendChild(removeButton);
            });
            this.on("maxfilesexceeded", function (file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    };*/

    /*Dropzone.options.addNewMediaImages = false;

    Dropzone.options.addNewMediaImages = {
        init: function () {
            this.on("success", function (file, responseText) {
                var removeButton = Dropzone.createElement('<div class="removeNewImage"><i class="fa fa-times-circle-o"></i></div>');
                var _this = this;
                removeButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    _this.removeFile(file);
                    var imageId = responseText.media.id;
                    console.log(imageId)
                    var slug = $('#slug').text();
                    $.ajax({
                        type: "DELETE",
                        url: '/profile/' + slug + '/media/' + imageId
                    })
                });

                file.previewElement.appendChild(removeButton);
            });
        }
    };*/

    $('.editOffer').click(function (e) {
        e.stopPropagation();
        $(this).children('button').prop('disabled', true)
        var parentPerformance = $(this).parents('article')
        var performanceId = $(parentPerformance).children('.performanceId').text();
        $(parentPerformance).find('.perfomanceInfoEdiatable').editable({
            type: 'text',
            mode: 'inline',
            success: function (response, newValue) {
                $.ajax({
                    type: "PATCH",
                    url: '/profile/performance/' + performanceId + '/edit',
                    data: {"performance[techRequirement]": newValue}
                });
            }
        });

        $(parentPerformance).find('.perfomanceTitleEdiatable').editable({
            type: 'text',
            success: function (response, newValue) {
                $.ajax({
                    type: "PATCH",
                    url: '/profile/performance/' + performanceId + '/edit',
                    data: {"performance[title]": newValue}
                });
            }
        });
        //$(parentPerformance).find('.imagePerformanceChange').fadeIn();
        userPerformanceUpload(parentPerformance, performanceId);
        offerMediaChoose(parentPerformance, performanceId);
    });

    $('.deleteMedia').on('click', function () {
        var slug = $('#slug').text();
        var mediaId = $(this).attr('id');
        var currentBlocThumb = $(this).parent('.scale-thumb');
        var getBigSliderContent = $('#imageSlider' + mediaId);
        var getMediaType = $(this).parents('section');
        console.log(getMediaType[0].id)
        $.ajax({
            type: "DELETE",
            url: '/profile/' + slug + '/media/' + mediaId,
            success: function () {
                currentBlocThumb.remove();
                getBigSliderContent.remove();
                //imageSlider.reloadSlider();
                if(getMediaType[0].id == 'section-video'){
                    var indexOfThumb = $('#video-pager .scale-thumb').length;
                    $("#media [data-target='#section-video'] .badge").text(indexOfThumb)
                } else if (getMediaType[0].id == 'section-photo'){
                    var indexOfThumb = $('#photo-pager .scale-thumb').length;
                    $("#media [data-target='#section-photo'] .badge").text(indexOfThumb)
                }
            }
        })
    });

    $('#addNewPerformance').on('click', function () {
        var addNewBtn = $(this);
        var slug = $('#slug').text();
        var performanceCreateBlock = $('.emptyPerformance');
        var getNewBlockPerformance = $(performanceCreateBlock).clone();
        getNewBlockPerformance.insertBefore(addNewBtn).removeClass('emptyPerformance').fadeIn();
        $(getNewBlockPerformance).find('.perfomanceTitleEdiatable').editable({
            type: 'text',
            success: function (response, newValue) {
                $.ajax({
                    type: "POST",
                    url: '/profile/' + slug + '/performance/new',
                    data: {"performance[title]": newValue},
                    success: function (responseText) {
                        var newPerformanceId = responseText.performance.id;
                        $(getNewBlockPerformance).find('.performanceId').html(responseText.performance.id);
                        createNewPerformance(getNewBlockPerformance, newPerformanceId)
                    }
                });
            }
        });
    });

    function createNewPerformance(getNewBlockPerformance, newPerformanceId) {
        console.log(newPerformanceId);
        var imagesDropzoneAdd = $(getNewBlockPerformance).find('.imagePerformanceChange');
        var deleteBtnNew = $(getNewBlockPerformance).find('.deleteOffer');
        imagesDropzoneAdd.attr('action', '/profile/performance/' + newPerformanceId + '/media/new');
        imagesDropzoneAdd.fadeIn();
        deleteBtnNew.fadeIn();
        var newPerformance = true,
            performanceBlock = false;
        userPerformanceUpload(getNewBlockPerformance, newPerformanceId, performanceBlock, newPerformance);
        offerMediaChoose(getNewBlockPerformance, newPerformanceId, newPerformance)
        $(getNewBlockPerformance).find('.perfomanceInfoEdiatable').editable({
            type: 'text',
            mode: 'inline',
            success: function (response, newValue) {
                $.ajax({
                    type: "PATCH",
                    url: '/profile/performance/' + newPerformanceId + '/edit',
                    data: {"performance[techRequirement]": newValue}
                });
            }
        });
        $(deleteBtnNew).click(function () {
            var slug = $('#slug').text();
            $.ajax({
                type: "DELETE",
                url: '/profile/' + slug + '/performance/' + newPerformanceId,
                success: function () {
                    $(getNewBlockPerformance).remove();
                }
            })
        });
    }

    $('.deleteOffer').click(function () {
        var parentPerformance = $(this).parents('article');
        var performanceId = $(parentPerformance).children('.performanceId').text();
        var slug = $('#slug').text();
        console.log(performanceId);
        deleteOffer(slug, performanceId, parentPerformance)
    });

    function deleteOffer(slug, performanceId, parentPerformance) {
        $.ajax({
            type: "DELETE",
            url: '/profile/' + slug + '/performance/' + performanceId,
            success: function () {
                $(parentPerformance).remove();
            }
        })
    }

    $('#addNewInputVideo').click(function () {
        var targetToAddField = $('#section-video .videoAddForm');
        $(targetToAddField).append('<input type="text" class="form-control videoAdd">')
    });

    $('#sendNewVideo').click(function () {
        var slug = $('#slug').text();
        $('#section-video .videoAddForm input').each(function () {
            var videoLink = $(this).val();
            postNewVideo(slug, videoLink)
        })
    });

    function postNewVideo(slug, videoLink) {
        $.ajax({
            type: "POST",
            url: '/profile/' + slug + '/media/new',
            data: {"video": videoLink},
            success: function(responseText){
                console.log(responseText)
                var newVideoLink = responseText.media.link;
                var videoThumbnail = responseText.media.thumbnail;
                var newVideoId = responseText.media.id;
                console.log(newVideoLink, videoThumbnail);
                var indexOfThumb = $('#video-pager .scale-thumb').length;
                $('.bxVideoSlider').append('<li><iframe src='+ newVideoLink +'  width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li>');
                $('#video-pager').append('<div class="scale-thumb thumb'+ indexOfThumb + 1 +'"><span class="removeNewImage deleteMedia" id='+newVideoId+'><i class="fa fa-times-circle-o"></i></span><a data-slide-index='+ indexOfThumb +' href=""><img id='+newVideoId+' src='+videoThumbnail+'/></a></div>');
                console.log(indexOfThumb);
                $("#media [data-target='#section-video'] .badge").text(indexOfThumb + 1);
                //videoSlider.reloadSlider();
            }
        })
    }

    $('#sendNewAudio').click(function () {
        var slug = $('#slug').text();
        $('#section-audio .audioAddForm input').each(function () {
            var audioLink = $(this).val();
            postNewAudio(slug, audioLink)
        })
    });

    function postNewAudio(slug, audioLink) {
        $.ajax({
            type: "POST",
            url: '/profile/' + slug + '/media/new',
            data: {"audio": "'"+ audioLink +"'"}
        })
    }

    function avatarUpload() {
        var $uploadCropAvatar;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $uploadCropAvatar.croppie('bind', {
                        url: e.target.result
                    });
                    $('.upload-demo').addClass('ready');
                }
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCropAvatar = $('#changeImageModal .changeImageContiner').croppie({
            viewport: {
                width: 213,
                height: 213,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            },
            exif: true
        });
        var AvatarCurrent = $('.avatarEditable .avatar').attr('src');
        $uploadCropAvatar.croppie('bind', {
            url: AvatarCurrent
        });

        $('#uploadAvatar').on('change', function () {
            readFile(this);
        });
        $('.upload-resultAvatar').on('click', function (ev) {
            $uploadCropAvatar.croppie('result', {
                type: 'canvas',
                size: 'original'
            }).then(function (resp) {
                $.ajax({
                    type: "PATCH",
                    url: '/user/edit',
                    data: {"user[avatar]": resp}
                })
                $('.avatarEditable .avatar').attr('src', resp)
            });
        });
        return;
    }

    $('#editAvatar').on('click', function () {
        $('.changeImageContiner').empty()
        avatarUpload()
    });


    $('#editBackground').on('click', function () {
        $('.changeImageContiner').empty()
        userBackgroundUpload()
    });

    function userBackgroundUpload() {
        var $uploadCropBackground;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $uploadCropBackground.croppie('bind', {
                        url: e.target.result
                    });
                    $('.upload-demo').addClass('ready');
                };
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCropBackground = $('#changeBgModal .changeImageContiner').croppie({
            viewport: {
                width: 300,
                height: 89
            },
            boundary: {
                width: 400,
                height: 300
            },
            exif: true
        });

        var backgroundCurrentSrc = $('#bgImageSrc').text();
        console.log(backgroundCurrentSrc);
        $uploadCropBackground.croppie('bind', {
            url: backgroundCurrentSrc
        });


        $('#uploadBg').on('change', function () {
            readFile(this);
        });
        $('.upload-resultBg').on('click', function (ev) {
            $uploadCropBackground.croppie('result', {
                type: 'canvas',
                size: 'original'
            }).then(function (resp) {
                $.ajax({
                    type: "PATCH",
                    url: '/user/edit',
                    data: {"user[background]": resp}
                });
                $('.header-background').css('background-image', 'url(' + resp + ')');
                $('#changeBgModal').modal('hide')
            });
        });
        return;
    }


    function userPerformanceUpload(parentPerformance, performanceId, block, newPerformance) {
        console.log(newPerformance)

        if (!block){
            var imgChangeBlock = parentPerformance.find('#image-performance-change1');
        } else {
            var imgChangeBlock = parentPerformance.find('#image-performance-change2');
        }
        var changeImgContainer = imgChangeBlock.find('.changeImageContiner'),
            mediaChangeId = imgChangeBlock.find('.mediaId').text(),
            currentImgSrc = imgChangeBlock.nextAll('.preview').attr('src'),
            imageUploadBtn = imgChangeBlock.find('#uploadImg'),
            uploadImage = imgChangeBlock.find('.upload-resultBg');
        imgChangeBlock.fadeIn();
        console.log(imageUploadBtn);
        if (!currentImgSrc){
            currentImgSrc = '/assets/images/media-no-image.gif'
        }

        var $uploadUserPerfMedia = {};

        $uploadUserPerfMedia[mediaChangeId] = $(changeImgContainer).croppie({
            viewport: {
                width: 300,
                height: 207
            },
            boundary: {
                width: 395,
                height: 215
            },
            exif: true
        });

        $uploadUserPerfMedia[mediaChangeId].croppie('bind', {
            url: currentImgSrc
        });

        function readFile(input) {
            console.log(input.files)
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    changeImgContainer.croppie('bind', {
                        url: e.target.result
                    });
                    //$('.upload-demo').addClass('ready');
                };
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $(imageUploadBtn).on('change', function () {
            console.log(this);
            readFile(this);
        });
        $(uploadImage).on('click', function (ev) {
            console.log($uploadUserPerfMedia[mediaChangeId])
            $uploadUserPerfMedia[mediaChangeId].croppie('result', {
                type: 'canvas',
                size: 'original'
            }).then(function (resp) {
                console.log(newPerformance + 'fuuuu')
                if(newPerformance){

                    $.ajax({
                        type: "POST",
                        url: '/profile/performance/' + performanceId + '/media/new',
                        data: {"file":resp}
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: '/media/' + mediaChangeId + '/edit',
                        data: {"file": resp}
                    });
                }
                imgChangeBlock.next('.preview').attr('src', resp);
                console.log($uploadUserPerfMedia[mediaChangeId])
                imgChangeBlock.fadeOut();
                changeImgContainer.empty();
            });
        });
        return;
    }

    function userPerformanceUploadSecond(parentPerformance, performanceId, block, newPerformance) {
        console.log(parentPerformance)

        var $uploadUserPerfMediaSecond;

        var imgChangeBlock = parentPerformance.find('#image-performance-change2');

        var changeImgContainer = imgChangeBlock.find('.imagePerfinput .changeImageContiner'),
            mediaChangeId = imgChangeBlock.find('.mediaId').text(),
            currentImgSrc = imgChangeBlock.nextAll('.preview').attr('src'),
            imageUploadBtn = imgChangeBlock.find('.uploadImg'),
            uploadImage = imgChangeBlock.find('.upload-resultBg');
        imgChangeBlock.fadeIn();

        var slug = $('#slug').text();
        var $uploadCropMediaOffer;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $uploadCropMediaOffer.croppie('bind', {
                        url: e.target.result
                    });
                    //$('.upload-demo').addClass('ready');
                };
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCropMediaOffer = $('#addImageModal .changeImageContiner').croppie({
            viewport: {
                width: 300,
                height: 207
            },
            boundary: {
                width: 400,
                height: 300
            },
            exif: true
        });

        $uploadCropMediaOffer.croppie('bind', {
            url: '/assets/images/media-no-image.gif'
        });


        $('#uploadNewMedia').on('change', function () {
            readFile(this);
        });
        $('.upload-NewMedia').on('click', function (ev) {
            $uploadCropMediaOffer.croppie('result', {
                type: 'canvas',
                size: 'original'
            }).then(function (resp) {
                console.log(newPerformance + 'fuuuu')
                if(newPerformance){
                    $.ajax({
                        type: "POST",
                        url: '/profile/performance/' + performanceId + '/media/new',
                        data: {"file":resp},
                        success: function(){
                            imgChangeBlock.nextAll('.preview').attr('src', resp);
                            console.log($uploadUserPerfMediaSecond)
                            imgChangeBlock.fadeOut();
                            $('#addImageModal').modal('hide')
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: '/media/' + mediaChangeId + '/edit',
                        data: {"file": resp},
                        success: function(){
                            imgChangeBlock.nextAll('.preview').attr('src', resp);
                            console.log($uploadUserPerfMediaSecond)
                            imgChangeBlock.fadeOut();
                            $('#addImageModal').modal('hide')
                        }
                    });
                }
                imgChangeBlock.nextAll('.preview').attr('src', resp);
                console.log($uploadUserPerfMediaSecond)
                imgChangeBlock.fadeOut();
                $('#addImageModal').modal('hide')
                //changeImgContainer.empty();
            });
        });
        return;
    }


    function offerMediaChoose(parentPerformance, performanceId, newPerformance){
        var offerMediaChangeBlock = parentPerformance.find('#image-performance-change2'),
            //firstImageCropper = parentPerformance.find('#image-performance-change1 .changeImageContiner'),
            mediaChangeBtns = offerMediaChangeBlock.find('button'),
            videoAddBlock = offerMediaChangeBlock.find('.performanceVideoAdd'),
            mediaChangeBlock = offerMediaChangeBlock.find('.offerMediaType'),
            mediaChangeId = offerMediaChangeBlock.find('.mediaId').text(),
            addVideoBtn = offerMediaChangeBlock.find('#AddPerformanceVideo'),
            videosAddForm = offerMediaChangeBlock.find('.videoPerformanceAdd'),
            imageAddForm = offerMediaChangeBlock.find('.imagePerfinput');

        offerMediaChangeBlock.fadeIn();
        mediaChangeBtns.on('click',function(){
            if($(this).hasClass('video')){
                mediaChangeBlock.hide();
                videoAddBlock.show();
                addVideoBtn.on('click',function(){
                    var videoAddedVal = videosAddForm.val();
                    console.log(videoAddedVal);
                    addPerformanceVideo(mediaChangeId, videoAddedVal, parentPerformance, newPerformance, performanceId)
                })
            } else {
                mediaChangeBlock.hide();
                imageAddForm.show();
                //firstImageCropper.empty();
                console.log(newPerformance)
                //var newPerformance = true;
                //mediaImageUpload()
                userPerformanceUploadSecond(parentPerformance, performanceId, offerMediaChangeBlock, newPerformance)
            }
        })

    }

    function addPerformanceVideo(mediaChangeId, videoAddedVal, parentPerformance, newPerformance, performanceId){
        var performanceVideoBlock = parentPerformance.find('.performanceVideo'),
            videoAddBlock = parentPerformance.find('.performanceVideoAdd'),
            changePerformanceBlock = parentPerformance.find('#image-performance-change2');
        console.log(newPerformance)
        if (newPerformance){
            $.ajax({
                type: "POST",
                url: '/profile/performance/' + performanceId + '/media/new',
                data: {"video": videoAddedVal},
                success: function (responseText) {
                    console.log(responseText);
                    $(performanceVideoBlock).html('<iframe src=' + responseText.media.link + '  width="395" height="274" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>');
                    videoAddBlock.hide();
                    changePerformanceBlock.hide();
                }
            })
        } else {
            $.ajax({
                type: "POST",
                url: '/media/' + mediaChangeId + '/edit',
                data: {"video": videoAddedVal},
                success: function (responseText) {
                    console.log(responseText);
                    $(performanceVideoBlock).html('<iframe src=' + responseText.media.link + '  width="395" height="274" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>');
                    videoAddBlock.hide();
                    changePerformanceBlock.hide();
                }
            })
        }
    }


    function getCheckedCategories() {
        var selectedCat = [];
        var selectedCatName = [];
        $('.artistCategories input:checked').each(function () {
            selectedCat.push($(this).val());
            var labelId = $(this).attr('id');
            var categoryName = $('#categotiesModal .artistCategories label[for='+ labelId +']').text();
            selectedCatName.push(categoryName);
        });
        var slug = $('#slug').text();
        sendSelectedCategories(selectedCat, slug, selectedCatName)
    }

    $('#saveCategories').on('click', function () {
        getCheckedCategories();
    });
    function sendSelectedCategories(selectedCat, slug, selectedCatName) {
        $.ajax({
            type: "PATCH",
            url: '/profile/' + slug + '/edit',
            data: {"profile[categories]": selectedCat},
            success: function(){
                $('.currentCatUser').remove();
                var newCategories = $.map(selectedCatName, function(value, i) {
                    return '<li class="currentCatUser"><a href="#">'+ value +'</a><div class="divider"></div></li>';
                });
                $('.specializations > ul').prepend(newCategories.join(""));
            }
        })
    }

    $('#section-audio audio').click(function(){
        console.log('ddddd');
        var audioGroup = $('#section-audio audio');
        $(audioGroup).each(function(){
            this.pause()
        })
    });

    /*function preventMultipleAudio(){
        console.log('ddddd');
        var audioGroup = $('#section-audio audio');
        $(audioGroup).each(function(){
            this.pause()
        })
    }*/

    $('#profileAddNewMedia').on('click', function (ev) {
        $('.changeImageContiner').empty();
        ev.preventDefault();
        mediaImageUpload()
    });

    function mediaImageUpload() {
        var slug = $('#slug').text();
        var $uploadCropMedia;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $uploadCropMedia.croppie('bind', {
                        url: e.target.result
                    });
                    //$('.upload-demo').addClass('ready');
                };
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCropMedia = $('#addImageModal .changeImageContiner').croppie({
            viewport: {
                width: 300,
                height: 207
            },
            boundary: {
                width: 400,
                height: 300
            },
            exif: true
        });

        $uploadCropMedia.croppie('bind', {
            url: '/assets/images/media-no-image.gif'
        });


        $('#uploadNewMedia').on('change', function () {
            readFile(this);
        });
        $('.upload-NewMedia').on('click', function (ev) {
            $uploadCropMedia.croppie('result', {
                type: 'canvas',
                size: 'original'
            }).then(function (resp) {
                $.ajax({
                    type: "POST",
                    url: '/profile/'+slug+'/media/new',
                    data: {'file':resp},
                    success: function(response){
                        console.log(response);
                        $('#addImageModal').modal('hide');
                        //imageSlider.reload();
                        var indexOfThumb = $('#photo-pager .scale-thumb').length;
                        $("#media [data-target='#section-photo'] .badge").text(indexOfThumb + 1);
                    }
                });

                //$('.header-background').css('background-image', 'url(' + resp + ')');
            });
        });
        return;
    }
});


$(document).on('ready ajaxComplete', function(){
    $('.price-list .pagination a').on('click', function(event){
        event.preventDefault();
        if ($(this).hasClass('pageArrows')){
            var paginationLink = $(this).attr('href');
            var pageRoute = paginationLink.slice(-1);
        } else {
            var pageRoute = $(this).text();
        }
        var pageBaseRoute = $('#slug').text();
        var paginationRoute = pageBaseRoute + '/performance?page=' + pageRoute;
        var paginationTarget = $(".price-list");
        getPagination(paginationRoute, paginationTarget);
    });

    $('.feedbacks .pagination a').on('click', function(event){
        event.preventDefault();
        if ($(this).hasClass('pageArrows')){
            var paginationLink = $(this).attr('href');
            var pageRoute = paginationLink.slice(-1);
        } else {
            var pageRoute = $(this).text();
        }
        var pageBaseRoute = $('#slug').text();
        var paginationRoute = pageBaseRoute + '/feedback?page=' + pageRoute;
        var paginationTarget = $(".feedbacksContainer");
        getPagination(paginationRoute, paginationTarget);
    });

    function getPagination(paginationRoute, paginationTarget){
        $.get(paginationRoute, function( data ) {
            $(paginationTarget).html(data);
        });
    }
});
