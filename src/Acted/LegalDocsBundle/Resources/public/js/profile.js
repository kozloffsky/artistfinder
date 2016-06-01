

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


    //$('.deleteOffer button').confirmation();



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
            $('.navbar-collapse').css('max-height', '225px');
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


    $(document).on('click','.editOffer',function (e) {
        e.stopPropagation();
        $(this).unbind("click");
        $(this).children('button').prop('disabled', true)
        var parentPerformance = $(this).parents('article');
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
        $(parentPerformance).find('.editingProf').fadeIn(800);

        $('.editImageModalOpen').on('click',function(){
            var getMediaId = $(this).prev('.mediaId').text(),
                imageBlockInsert = $(this).parents('.imageBlockWrapper');
            console.log(imageBlockInsert)
            userPerformanceUploadSecond(parentPerformance, performanceId, getMediaId, imageBlockInsert)
        });

        $('.editVideo').on('click',function(){
            var getBlockEditedVideo = $(this).parents('article');
            var getMediaId = $(this).prevAll('.mediaId').text(),
                newPerformance = 'edit';
            getBlockEditedVideo.find('#image-performance-change2, #image-performance-change2 .performanceVideoAdd').fadeIn(800);
            $(parentPerformance).find('#AddPerformanceVideo').on('click',function(){
                var videoAddedVal = $(parentPerformance).find('.videoPerformanceAdd').val();
                console.log(getMediaId, videoAddedVal, parentPerformance, newPerformance, performanceId)
                addPerformanceVideo(getMediaId, videoAddedVal, parentPerformance, newPerformance, performanceId)
            })

        })
        //userPerformanceUpload(parentPerformance, performanceId);
        //offerMediaChoose(parentPerformance, performanceId);
    });

    function userPerformanceUploadSecond(parentPerformance, performanceId, mediaId, imageBlockInsert, newPerformance) {
        //console.log('opennf')
        console.log(parentPerformance)
        var isActiveCropper = false;
        $('#addImageModal .changeImageContiner').empty().removeClass('croppie-container');
        $('#uploadNewMedia').val('');
        $('#addImageModal').modal('show');
        console.log(parentPerformance)

        var imgChangeBlock = imageBlockInsert;
        console.log(imgChangeBlock)

       //imgChangeBlock.fadeIn();

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
            exif: true,
            viewport: {
                width: 300,
                height: 207
            },
            boundary: {
                width: 400,
                height: 300
            }
        });

        setTimeout(function(){
            $('#addImageModal .changeImageContiner').croppie('bind');
        }, 500);

        $uploadCropMediaOffer.croppie('bind', {
            url: '/assets/images/media-no-image.gif'
        });

        $('#uploadNewMedia').on('change', function () {
            readFile(this);
        });
        $('.upload-NewMedia').on('click', function (ev) {
            $uploadCropMediaOffer.croppie('result', {
                type: 'canvas',
                size: 'original',
                format: 'jpeg'
            }).then(function (resp) {
                if(!isActiveCropper) {
                    if ($(imgChangeBlock).hasClass('video')) {
                        if (mediaId == 'NewMedia') {
                            $.ajax({
                                type: "POST",
                                url: '/profile/performance/' + performanceId + '/media/new',
                                data: {"file": resp,
                                    "position":2},
                                beforeSend: function () {
                                    $('#loadSpinner').fadeIn(500);
                                },
                                complete: function () {
                                    $('#loadSpinner').fadeOut(500);
                                },
                                success: function (responseText) {
                                    isActiveCropper = true;
                                    console.log(imgChangeBlock)
                                    $("#uploadNewMedia").val('');
                                    //var placeToAddNewImage = imgChangeBlock.parent('.video');
                                    //console.log(placeToAddNewImage);
                                    imgChangeBlock.find('.editingProf .mediaId').text(responseText.media.id);
                                    imgChangeBlock.find('iframe').remove();
                                    imgChangeBlock.find('img.preview').remove();
                                    imgChangeBlock.append('<img class="preview" src="' + resp + '" alt="Preview">');
                                    //imgChangeBlock.fadeOut();
                                    $('#addImageModal').modal('hide');
                                    //$uploadCropMediaOffer.croppie('destroy')
                                    //$uploadCropMediaOffer = {};
                                    parentPerformance.find('.newVideoImgAddBtns').fadeIn(800);
                                }
                            });
                        } else {
                            $.ajax({
                                type: "POST",
                                url: '/media/' + mediaId + '/edit',
                                data: {"file": resp},
                                beforeSend: function () {
                                    $('#loadSpinner').fadeIn(500);
                                },
                                complete: function () {
                                    $('#loadSpinner').fadeOut(500);
                                },
                                success: function () {
                                    isActiveCropper = true;
                                    console.log(imgChangeBlock)
                                    $("#uploadNewMedia").val('');
                                    //var placeToAddNewImage = imgChangeBlock.parent('.video');
                                    //console.log(placeToAddNewImage);
                                    imgChangeBlock.find('iframe').remove();
                                    imgChangeBlock.find('img.preview').remove();
                                    imgChangeBlock.append('<img class="preview" src="' + resp + '" alt="Preview">');
                                    //imgChangeBlock.fadeOut();
                                    $('#addImageModal').modal('hide');
                                    //$uploadCropMediaOffer.croppie('destroy')
                                    //$uploadCropMediaOffer = {};
                                }
                            });
                        }
                    } else {
                        if (mediaId == 'NewMedia') {
                            $.ajax({
                                type: "POST",
                                url: '/profile/performance/' + performanceId + '/media/new',
                                data: {"file": resp},
                                beforeSend: function () {
                                    $('#loadSpinner').fadeIn(500);
                                },
                                complete: function () {
                                    $('#loadSpinner').fadeOut(500);
                                },
                                success: function (responseText) {
                                    isActiveCropper = true;
                                    console.log(imgChangeBlock)
                                    $("#uploadNewMedia").val('');
                                    //var placeToAddNewImage = imgChangeBlock.parent('.video');
                                    //console.log(placeToAddNewImage);
                                    imgChangeBlock.find('.editingProf .mediaId').text(responseText.media.id);
                                    imgChangeBlock.find('iframe').remove();
                                    imgChangeBlock.find('img.preview').remove();
                                    imgChangeBlock.append('<img class="preview" src="' + resp + '" alt="Preview">');
                                    //imgChangeBlock.fadeOut();
                                    $('#addImageModal').modal('hide');
                                    //$uploadCropMediaOffer.croppie('destroy')
                                    //$uploadCropMediaOffer = {};
                                    parentPerformance.find('.newVideoImgAddBtns').fadeIn(800);
                                }
                            });
                        } else {
                            $.ajax({
                                type: "POST",
                                url: '/media/' + mediaId + '/edit',
                                data: {"file": resp},
                                beforeSend: function () {
                                    $('#loadSpinner').fadeIn(500);
                                },
                                complete: function () {
                                    $('#loadSpinner').fadeOut(500);
                                },
                                success: function () {
                                    isActiveCropper = true;
                                    console.log(imgChangeBlock)
                                    $("#uploadNewMedia").val('');
                                    //var placeToAddNewImage = imgChangeBlock.parent('.video');
                                    //console.log(placeToAddNewImage);
                                    imgChangeBlock.find('iframe').remove();
                                    imgChangeBlock.find('img.preview').remove();
                                    imgChangeBlock.append('<img class="preview" src="' + resp + '" alt="Preview">');
                                    //imgChangeBlock.fadeOut();
                                    $('#addImageModal').modal('hide');
                                    //$uploadCropMediaOffer.croppie('destroy')
                                    //$uploadCropMediaOffer = {};
                                }
                            });
                        }
                        //imgChangeBlock.nextAll('.preview').attr('src', resp);
                        //console.log($uploadUserPerfMediaSecond)
                        //imgChangeBlock.fadeOut();
                        //$('#addImageModal').modal('hide');
                        //changeImgContainer.empty();
                    }
                }
            });

            return false;
        });
        //return;
    }


    deleteMedia();

    function deleteMedia() {
        $('.deleteMedia').on('click', function () {
            var slug = $('#slug').text();
            var mediaId = $(this).attr('id');
            var currentBlocThumb = $(this).parent('.scale-thumb');
            var getBigSliderContent = $('#imageSlider' + mediaId);
            var getMediaType = $(this).parents('section');
            var clickedElDelete = $(this);
            console.log(getMediaType[0].id)
            $.ajax({
                type: "DELETE",
                url: '/profile/' + slug + '/media/' + mediaId,
                success: function () {
                    currentBlocThumb.remove();
                    getBigSliderContent.remove();
                    //imageSlider.reloadSlider();
                    if (getMediaType[0].id == 'section-video') {
                        var indexOfThumb = $('#video-pager .scale-thumb').length;
                        $("#media [data-target='#section-video'] .badge").text(indexOfThumb);
                        $('.bxVideoSlider').unwrap();
                        $('.bxVideoSlider').bxSlider({
                            adaptiveHeight: true,
                            mode: 'fade',
                            useCSS: false,
                            video: true,
                            pagerCustom: '#video-pager',
                            /*onSliderLoad: function () {
                                $('#section-video').hide();
                            }*/
                        })
                    } else if (getMediaType[0].id == 'section-photo') {

                        var indexOfThumb = $('#photo-pager .scale-thumb').length;
                        $("#media [data-target='#section-photo'] .badge").text(indexOfThumb)
                        $('.bxslider').unwrap();
                        $('.bxslider').bxSlider({
                            adaptiveHeight: true,
                            pagerCustom: '#photo-pager',
                            nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
                            prevText: '<i class="left fa fa-3x fa-angle-left"></i>'
                        });
                        $('.bxslider .bx-clone').remove();
                    } else if (getMediaType[0].id == 'section-audio') {
                        $(clickedElDelete).parent('.audioEditProfile').remove();
                        var indexOfThumb = $('#section-audio .audioEditProfile').length;
                        $("#media [data-target='#section-audio'] .badge").text(indexOfThumb);
                    }
                }
            })
        });
    }

    $(document).on('click','#addNewPerformance', function () {
        var addNewBtn = $(this);
        var slug = $('#slug').text();
        var performanceCreateBlock = $('.emptyPerformance');
        var getNewBlockPerformance = $(performanceCreateBlock).clone();
        getNewBlockPerformance.insertBefore(addNewBtn).removeClass('emptyPerformance').fadeIn(800);
        var newPerfCreated = false;
        console.log(newPerfCreated)
        if(newPerfCreated == false) {
            console.log(newPerfCreated)
            $(getNewBlockPerformance).find('.perfomanceTitleEdiatable').editable({
                type: 'text',
                success: function (response, newValue) {
                    $.ajax({
                        type: "POST",
                        url: '/profile/' + slug + '/performance/new',
                        data: {"performance[title]": newValue},
                        success: function (responseText) {
                            console.log(getNewBlockPerformance)
                            $(getNewBlockPerformance).find('.perfomanceTitleEdiatable').editable('option', 'disabled', true);
                            //$('.perfomanceTitleEdiatable').editable('option', 'disabled', true);
                            var newPerformanceId = responseText.performance.id;
                            $(getNewBlockPerformance).find('.performanceId').html(responseText.performance.id);

                            createNewPerformance(getNewBlockPerformance, newPerformanceId);
                        }
                    });
                }
            });
        }
    });



    function createNewPerformance(getNewBlockPerformance, newPerformanceId) {
        console.log(newPerformanceId);
        var deleteBtnNew = $(getNewBlockPerformance).find('.deleteOffer');
        deleteBtnNew.find('button').confirmation();
        deleteBtnNew.fadeIn();
        var newPerformance = true,
            performanceBlock = false;
        //userPerformanceUpload(getNewBlockPerformance, newPerformanceId, performanceBlock, newPerformance);
        //offerMediaChoose(getNewBlockPerformance, newPerformanceId, newPerformance)
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
            //$(this).find('button').confirmation('show');
            var slug = $('#slug').text();

            $(this).confirmation({
                show:true,
                onConfirm: function(){
                    $.ajax({
                        type: "DELETE",
                        url: '/profile/' + slug + '/performance/' + newPerformanceId,
                        success: function () {
                            $(getNewBlockPerformance).remove();
                        }
                    })
                }
            });

        });

        console.log(getNewBlockPerformance)

        $(getNewBlockPerformance).find('.editImageProfNew .editImage').fadeIn(800)

        $('.editImageModalOpen').on('click',function(){
            var getMediaId = $(this).prev('.mediaId').text(),
                imageBlockInsert = $(this).parents('.imageBlockWrapper');
            console.log(imageBlockInsert);
            userPerformanceUploadSecond(getNewBlockPerformance, newPerformanceId, getMediaId, imageBlockInsert)
        });

        $('.editVideo').on('click',function(){
            console.log(getNewBlockPerformance)
            var getBlockEditedVideo = $(this).parents('article');
            var getMediaId = $(this).prevAll('.mediaId').text(),
                newPerformance = 'edit';
            getBlockEditedVideo.find('#image-performance-change2, #image-performance-change2 .performanceVideoAdd').fadeIn(800);
            $(getNewBlockPerformance).find('#AddPerformanceVideo').on('click',function(){
                var videoAddedVal = $(getNewBlockPerformance).find('.videoPerformanceAdd').val();
                //console.log(getMediaId, videoAddedVal, parentPerformance, newPerformance, performanceId)
                addPerformanceVideo(getMediaId, videoAddedVal, getNewBlockPerformance, newPerformance, newPerformanceId)
            })

        })


    }

    $(document).on('click','.deleteOffer button',function () {
        var parentPerformance = $(this).parents('article');
        var performanceId = $(parentPerformance).children('.performanceId').text();
        var slug = $('#slug').text();
        //$(this).confirmation('show');
        $(this).confirmation({
            show:true,
            onConfirm: function(){
                deleteOffer(slug, performanceId, parentPerformance)
            }
        });
        console.log(performanceId);
    });

    function deleteOffer(slug, performanceId, parentPerformance) {
        $.ajax({
            type: "DELETE",
            url: '/profile/' + slug + '/performance/' + performanceId,
            success: function () {
                $(parentPerformance).fadeOut(800);
                setTimeout(function(){
                    $(parentPerformance).remove();
                }, 800);
            }
        })
    }

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
                $('.bxVideoSlider').append('<li id="imageSlider'+newVideoId+'"><iframe src='+ newVideoLink +'  width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li>');
                $('#video-pager').append('<div class="scale-thumb thumb'+ indexOfThumb + 1 +'"><span class="removeNewImage deleteMedia" id='+newVideoId+'><i class="fa fa-times-circle-o"></i></span><a data-slide-index='+ indexOfThumb +' href=""><img id='+newVideoId+' src='+videoThumbnail+'/></a></div>');
                console.log(indexOfThumb);
                $("#media [data-target='#section-video'] .badge").text(indexOfThumb + 1);
                //videoSlider.reloadSlider();
                var videoSliderParent = $('.bxVideoSlider').parent('.bx-viewport').length
                if (videoSliderParent > 0){
                    $('.bxVideoSlider').unwrap();
                }
                $('.bxVideoSlider').bxSlider({
                    adaptiveHeight: true,
                    mode: 'fade',
                    useCSS: false,
                    video: true,
                    pagerCustom: '#video-pager'
                    /*onSliderLoad: function () {
                        $('#section-video').hide();
                    }*/
                });
                deleteMedia();
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
            data: {"audio": "'"+ audioLink +"'"},
            success: function(response){
                $('.audioBlock').append('<div class="audioEditProfile">'+
                    '<span class="removeNewAudio deleteMedia" id="'+response.media.id+'"><i class="fa fa-times-circle-o"></i></span>'+
                    '<iframe width="100%" height="150" scrolling="no" frameborder="no" src="'+response.media.link+'"></iframe></div>');
                var indexOfThumb = $('#section-audio .audioEditProfile').length;
                $("#media [data-target='#section-audio'] .badge").text(indexOfThumb);
                deleteMedia();
            }
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
            exif: true,
            viewport: {
                width: 213,
                height: 213,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            },
        });
        var AvatarCurrent = $('.avatarEditable .avatar').attr('src');
        $uploadCropAvatar.croppie('bind', {
           // url: AvatarCurrent
        });

        $('#uploadAvatar').on('change', function () {
            readFile(this);
        });
        $('.upload-resultAvatar').on('click', function (ev) {
            $uploadCropAvatar.croppie('result', {
                type: 'canvas',
                size: 'viewport',
                format: 'png'
            }).then(function (resp) {
                $.ajax({
                    type: "PATCH",
                    url: '/user/edit',
                    data: {"user[avatar]": resp},
                    success: function(){
                        $('.avatarEditable .avatar').attr('src', resp);
                        $('#changeImageModal').modal('hide');
                    },
                    error: function(response){
                        alert(response.errors)
                    }
                })
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
            exif: true,
            viewport: {
                width: 300,
                height: 89
            },
            boundary: {
                width: 400,
                height: 300
            }
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



    function addPerformanceVideo(mediaChangeId, videoAddedVal, parentPerformance, newPerformance, performanceId){
        var performanceVideoBlock = parentPerformance.find('.performanceVideo'),
            videoAddBlock = parentPerformance.find('.performanceVideoAdd'),
            changePerformanceBlock = parentPerformance.find('#image-performance-change2');
        console.log(newPerformance)
        console.log(mediaChangeId)
        if (newPerformance == 'new'){
            $.ajax({
                type: "POST",
                url: '/profile/performance/' + performanceId + '/media/new',
                data: {"video": videoAddedVal,
                    "position":2},
                beforeSend: function(){
                    $('#loadSpinner').fadeIn(500);
                },
                complete: function(){
                    $('#loadSpinner').fadeOut(500);
                },
                success: function (responseText) {
                    console.log(responseText);
                    $(changePerformanceBlock).parent('.video').find('.editingProf .mediaId').text(responseText.media.id)
                    $(performanceVideoBlock).html('<iframe src=' + responseText.media.link + '  width="395" height="274" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>');
                    videoAddBlock.hide();
                    changePerformanceBlock.hide();
                }
            })
        } else if (mediaChangeId == 'NewMedia'){
            $.ajax({
                type: "POST",
                url: '/profile/performance/' + performanceId + '/media/new',
                data: {"video": videoAddedVal,
                    "position":2},
                beforeSend: function(){
                    $('#loadSpinner').fadeIn(500);
                },
                complete: function(){
                    $('#loadSpinner').fadeOut(500);
                },
                success: function (responseText) {
                    console.log(responseText);
                    $(changePerformanceBlock).parent('.video').find('iframe').remove();
                    $(changePerformanceBlock).parent('.video').find('img').remove();
                    $(changePerformanceBlock).parent('.video').find('.editingProf .mediaId').text(responseText.media.id)
                    $(performanceVideoBlock).html('<iframe src=' + responseText.media.link + '  width="395" height="274" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>');
                    videoAddBlock.hide();
                    changePerformanceBlock.hide();
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: '/media/' + mediaChangeId + '/edit',
                data: {"video": videoAddedVal},
                beforeSend: function(){
                    $('#loadSpinner').fadeIn(500);
                },
                complete: function(){
                    $('#loadSpinner').fadeOut(500);
                },
                success: function (responseText) {
                    console.log(responseText);
                    $(changePerformanceBlock).parent('.video').find('iframe').remove();
                    $(changePerformanceBlock).parent('.video').find('img').attr('src','');
                    $(performanceVideoBlock).html('<iframe src=' + responseText.media.link + '  width="395" height="274" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>');
                    videoAddBlock.hide();
                    changePerformanceBlock.hide();
                    videoAddBlock.find('.videoAddMessage').css('color','#fff');
                },
                error: function(response){
                    videoAddBlock.find('.videoAddMessage').css('color','#C9302C');
                }
            })
        }
    }

    $('#editCategories').on('click',function(){
        $('.specializations .currentCatUser a').each(function(){
            var currentCatId = $(this).attr('id');
            console.log(currentCatId);
            $('.categoriesChange #categoriesForm .artistCategories').find('#variety_category_id_'+currentCatId+'').prop('checked',true);
        })
    });

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
                $('#categotiesModal').modal('hide');
            }
        })
    }

    /*function preventMultipleAudio(){
        console.log('ddddd');
        var audioGroup = $('#section-audio audio');
        $(audioGroup).each(function(){
            this.pause()
        })
    }*/

    $('#profileAddNewMedia').on('click', function (ev) {
        $('#addImageModal .changeImageContiner').empty().removeClass('croppie-container');
        ev.preventDefault();
        mediaImageUpload()
    });

    function mediaImageUpload() {
        var isActiveCropper = false;
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
                size: 'original',
                format: 'jpeg'
            }).then(function (resp) {
                if(!isActiveCropper) {
                    $.ajax({
                        type: "POST",
                        url: '/profile/' + slug + '/media/new',
                        data: {'file': resp},
                        beforeSend: function(){
                            $('#loadSpinner').fadeIn(500);
                        },
                        complete: function(){
                            $('#loadSpinner').fadeOut(500);
                        },
                        success: function (response) {
                            console.log(response);
                            console.log(isActiveCropper)
                            isActiveCropper = true;
                            $("#uploadNewMedia").val('');
                            //$('#addImageModal .changeImageContiner').croppie('destroy');
                            $('#addImageModal').modal('hide');
                            //$('#addImageModal .changeImageContiner').empty().removeClass('croppie-container');
                            var indexOfThumb = $('#photo-pager .scale-thumb').length;
                            var countNextTabNum = indexOfThumb +1;
                            $("#media [data-target='#section-photo'] .badge").text(indexOfThumb + 1);
                            $('#section-photo .bxslider').append('<li id="imageSlider'+response.media.id+'"><img src="'+resp +'"></li>')
                            $('#photo-pager').append('<div class="scale-thumb thumb'+countNextTabNum+'" style="width:266px;height:183.54px;">' +
                                '<span class="removeNewImage deleteMedia" id="' + response.media.id + '"><i class="fa fa-times-circle-o"></i></span>' +
                                '<a data-slide-index="' + indexOfThumb + '" href=""><img src="' + resp + '"/></a>'
                            );

                            if(indexOfThumb == 0){
                                $('.bxslider').bxSlider({
                                    adaptiveHeight: true,
                                    pagerCustom: '#photo-pager',
                                    nextSelector: '#nextSlide',
                                    prevSelector: '#prevSlide',
                                    nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
                                    prevText: '<i class="left fa fa-3x fa-angle-left"></i>'
                                });
                            } else {
                                $('.bxslider').unwrap();
                                $('.bxslider').bxSlider({
                                    adaptiveHeight: true,
                                    pagerCustom: '#photo-pager',
                                    nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
                                    prevText: '<i class="left fa fa-3x fa-angle-left"></i>'
                                });
                            }
                            deleteMedia();
                            resizeThumbs();
                        }
                    });
                }
            });
        })
        return;
    }

    function startSliderChanger(){

    }
    preventEmptyTabs();
    function preventEmptyTabs(){
        $('.mediaTabProf').each(function(){
            var numOfmediaElements = $(this).find('.badge').text();
            if (numOfmediaElements == 0){
                $(this).addClass('disabled');
            }
        })
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
