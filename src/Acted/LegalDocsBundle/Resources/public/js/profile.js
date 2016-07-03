

$(function() {

    $('.header-background').appendTo('.headerProfile');

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

    setRatingFeedback();
    function setRatingFeedback(){
        $('.feedback-block .ratingFeedback').each(function(){
            var raiting = $(this).find('.ratingFeedbackCount').text();
            var raitingFull = raiting.toString().split(".")[0];
            var raitingDigits = raiting.toString().split(".")[1];
            var ratingstars = $(this).find('.star');
            var getFullStars = $(ratingstars).slice(0, raitingFull);
            var getHalfStars = $(ratingstars).eq(raitingFull);
            $(getFullStars).children('.fill-star').css('width', '100%');
            $(getHalfStars).children('.fill-star').css('width', raitingDigits + '0%');
        })
    }

    //$('.deleteOffer button').confirmation();

    var optionsSlider = {
        photoSettings: {
            adaptiveHeight: true,
            mode          : 'fade',
            pagerCustom   : '#photo-pager',
            nextSelector  : '#nextSlide',
            prevSelector  : '#prevSlide',
            nextText      : '<i class="right fa fa-3x fa-angle-right"></i>',
            prevText      : '<i class="left fa fa-3x fa-angle-left"></i>',
            onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
                // console.log(currentSlideHtmlObject);
                $('.active-slide').removeClass('active-slide');
                $('.media-content .bxslider li').eq(currentSlideHtmlObject).addClass('active-slide')
            },
            onSliderLoad: function () {
                $('.media-content .bxslider li').eq(0).addClass('active-slide')
            }
        },
        videoSettings: {
            adaptiveHeight: true,
            mode: 'fade',
            useCSS: false,
            video: true,
            pagerCustom: '#video-pager',
            nextSelector: '#nextVideoSlide',
            prevSelector: '#prevVideoSlide',
            nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
            prevText: '<i class="left fa fa-3x fa-angle-left"></i>'
            // onSliderLoad: function () {
            //     $('#section-video').hide();
            // }
        }
    };

    slidersInitMedia();

    function slidersInitMedia(){
        if (($('.bxslider li').length) >= 1){
            $('.media-content .bxslider').bxSlider(optionsSlider.photoSettings);
            $('#section-photo').show();
        }
        if (($('.bxVideoSlider li').length) >= 1){
            $('.bxVideoSlider').bxSlider(optionsSlider.videoSettings);
        }
    }

    $('.feedback-block .text').each(function () {
        var $element  = $(this);
        var $toggler  = $element.find('.more');
        var $gradient = $element.find('.gradient');
        var $text     = $element.find('.feedback-text');
        var text      = $text.html();

        var maxLength = 0;
        if ($(window).width() < 768) {
            maxLength = parseInt($element.attr('data-max-chars-mobile'));
        } else {
            maxLength = parseInt($element.attr('data-max-chars-desktop'));
        }

        if (text.length > maxLength) {
            var newText = text.substring(0, maxLength - 3) + '...';
            $text.html(newText);

            $element.attr('data-full-text', text);
            $element.addClass('expandable');

            $toggler.click(function (e) {
                e.preventDefault();
                if (!$element.hasClass('opened')) {
                    $text.html($element.attr('data-full-text'));
                    $element.addClass('opened');
                    $toggler.html('-hide');
                    $gradient.hide();
                } else {
                    $element.removeClass('opened');
                    var newText = $element.attr('data-full-text').substring(0, maxLength - 3) + '...';
                    $text.html(newText);
                    $toggler.html('+more');
                    $gradient.show();
                }
            });


        } else {
            $toggler.hide();
            $gradient.hide();
        }
    });


    /*var imageSlider = console.log('')
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

    $(document).on('click','.videoAddPerf',function() {
        var mediaId = $(this).prev('.mediaId').text(),
            imageBlockInsert = $(this).parents('.holder'),
            parentPerformance = $(this).parents('form'),
            performanceId = parentPerformance.attr('id');
        $(parentPerformance).find('.holder.video .imagePerformanceChange, .holder.video .imagePerformanceChange .performanceVideoAdd').fadeIn();
        $(parentPerformance).find('.holder.video .btns-list button').css('color','#fff');
        var imageAddPerf = $(parentPerformance).find('#AddPerformanceVideo');
        $(imageAddPerf).on('click',function(e){
            e.preventDefault();
            var videoAddedVal = $(parentPerformance).find('.videoPerformanceAdd').val();
            addPerformanceVideo(mediaId, videoAddedVal, parentPerformance, performanceId)
        })
    });

    function addPerformanceVideo(mediaChangeId, videoAddedVal, parentPerformance, performanceId){
        var performanceVideoBlock = parentPerformance.find('.performanceVideo'),
            videoAddBlock = parentPerformance.find('.performanceVideoAdd'),
            changePerformanceBlock = parentPerformance.find('#image-performance-change2');
        if (mediaChangeId == 'NewMedia'){
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
                    $(performanceVideoBlock).html('<iframe src="' + responseText.media.link + '"  width="100%" height="auto" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>');
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

    $(document).on('click','.imageAddPerf',function(){
        $('#addImageModal').modal('show');
        var mediaId = $(this).prev('.mediaId').text(),
            imageBlockInsert = $(this).parents('.holder'),
            parentPerformance = $(this).parents('form'),
            performanceId = parentPerformance.attr('id');
        if($(imageBlockInsert).hasClass('video')){
            $(parentPerformance).find('.holder.video .imagePerformanceChange, .holder.video .imagePerformanceChange .performanceVideoAdd').fadeOut();
            $(parentPerformance).find('.holder.video .btns-list button').css('color','#333333');
        }
        userPerformanceUpload(parentPerformance, performanceId, mediaId, imageBlockInsert);
    });

    function validatePerformance(performanceId){
        var performanceBlock = $('.edit-form#'+performanceId+''),
            perfTitile = $('.edit-form#'+performanceId+' .offerTitlePerf').val().length,
            perfDescription = $('.edit-form#'+performanceId+' .description-area').val().length,
            perfMedia = $('.edit-form#'+performanceId+' .holder');
        var mediaCount = [];
        $(perfMedia).each(function(){
            var mediaInPerf = $(this).find('img, iframe').length;
            if(mediaInPerf >= 1){
                mediaCount.push(mediaInPerf);
            }
        });
        if(perfTitile > 0 && perfDescription > 0 && mediaCount.length >= 2)
        {
            return true;
        } else {
            $(performanceBlock).find('.error').removeClass('hidden');
            return false;
        }
    }

    $(document).on('click','.publishOfferPerf',function(ev){
        ev.preventDefault();

        var parentPerformance = $(this).parents('form'),
            performanceId = parentPerformance.attr('id'),
            dataSendOfferTitile = $(parentPerformance).find('.offerTitlePerf').val(),
            dataSendOfferInf = $(parentPerformance).find('.description-area').val();
        console.log(performanceId);
        var dataToSendOffer = {"performance[title]": dataSendOfferTitile,
            "performance[status]":"published",
            "performance[techRequirement]": dataSendOfferInf};
        console.log(validatePerformance(performanceId))
        if(validatePerformance(performanceId)){
            $.ajax({
                type: "PATCH",
                url: '/profile/performance/' + performanceId + '/edit',
                data: dataToSendOffer,
                success: function (responseText) {
                    $(parentPerformance).find('.publishOfferPerf').addClass('makeDraft').removeClass('publishOfferPerf').text('Make draft now');
                    $(parentPerformance).find('.error').addClass('hidden');
                }
            })
        }
    })

    $(document).on('click','.makeDraft',function(ev){
        ev.preventDefault();
        var parentPerformance = $(this).parents('form'),
            performanceId = parentPerformance.attr('id'),
            dataSendOfferTitile = $(parentPerformance).find('.offerTitlePerf').val(),
            dataSendOfferInf = $(parentPerformance).find('.description-area').val();
        console.log(performanceId);
        var dataToSendOffer = {"performance[title]": dataSendOfferTitile,
            "performance[status]":"draft",
            "performance[techRequirement]": dataSendOfferInf};
        $.ajax({
            type: "PATCH",
            url: '/profile/performance/' + performanceId + '/edit',
            data: dataToSendOffer,
            success: function (responseText) {
                $(parentPerformance).find('.makeDraft').addClass('publishOfferPerf').removeClass('makeDraft').text('Publish now');
            }
        })
    })

    function userPerformanceUpload(parentPerformance, performanceId, mediaId, imageBlockInsert, newPerformance) {
        console.log(parentPerformance, performanceId, mediaId, imageBlockInsert)
        var isActiveCropper = false;
        $('#addImageModal .changeImageContiner').empty().removeClass('croppie-container');
        $('#uploadNewMedia').val('');
        $('#addImageModal').modal('show');

        var imgChangeBlock = imageBlockInsert;
        console.log(imgChangeBlock)

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
                                    imgChangeBlock.find('.mediaId').text(responseText.media.id);
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
                        $('#section-video .holder a').remove();

                        /*$('.bxVideoSlider').bxSlider({
                            adaptiveHeight: true,
                            mode: 'fade',
                            useCSS: false,
                            video: true,
                            pagerCustom: '#video-pager',
                            /*onSliderLoad: function () {
                                $('#section-video').hide();
                            }*/
                        //})
                        $('.bxVideoSlider').bxSlider(optionsSlider.videoSettings);
                    } else if (getMediaType[0].id == 'section-photo') {

                        var indexOfThumb = $('#photo-pager .scale-thumb').length;
                        $("#media [data-target='#section-photo'] .badge").text(indexOfThumb)
                        $('.bxslider').unwrap();
                        $('#section-photo .holder a').remove();
                        /*$('.bxslider').bxSlider({
                            adaptiveHeight: true,
                            pagerCustom: '#photo-pager',
                            nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
                            prevText: '<i class="left fa fa-3x fa-angle-left"></i>'
                        });*/
                        $('.media-content .bxslider').bxSlider(optionsSlider.photoSettings);
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
                    $('#section-video .holder a').remove();
                }
                $('.bxVideoSlider').bxSlider(optionsSlider.videoSettings);
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
                    data: {"user[background]": resp},
                    beforeSend: function () {
                        $('#loadSpinner').fadeIn(500);
                    },
                    complete: function () {
                        $('#loadSpinner').fadeOut(500);
                    },
                    success: function(){
                        $('.header-background').css('background-image', 'url(' + resp + ')');
                        $('#changeBgModal').modal('hide');
                    }
                });
            });
        });
        return;
    }

    $('#editCategories').on('click',function(){
        $('.specializations .currentCatUser a').each(function(){
            var currentCatId = $(this).attr('id');
            $('.categoriesChange #categoriesForm .artistCategories').find('#variety_category_id_'+currentCatId+'').prop('checked',true);
        })
    });

    $('#categotiesModal #categoriesForm input').on('change',function(){
        disableCategories();
    })

    function disableCategories(){
        var numberCatChecked = $('#categotiesModal #categoriesForm input:checkbox:checked').length;
        if (numberCatChecked >= 1 && numberCatChecked <= 3){
            $('#saveCategories').removeClass('disabled');
        } else {
            $('#saveCategories').addClass('disabled');
        }
        if(numberCatChecked == 3){
            $('#categotiesModal #categoriesForm input:checkbox:not(:checked)').prop('disabled', true);
        } else if(numberCatChecked < 3){
            $('#categotiesModal #categoriesForm input:checkbox:not(:checked)').prop('disabled', false);
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
                $('#categotiesModal').modal('hide');
            }
        })
    }


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
                            $('#photo-pager').append('<div class="scale-thumb thumb'+countNextTabNum+'" style="height:118.68px;">' +
                                '<span class="removeNewImage deleteMedia" id="' + response.media.id + '"><i class="fa fa-times-circle-o"></i></span>' +
                                '<a data-slide-index="' + indexOfThumb + '" href=""><img src="' + resp + '"/></a>'
                            );

                            if(indexOfThumb == 0){
                                $('.media-content .bxslider').bxSlider(optionsSlider.photoSettings);
                            } else {
                                $('.bxslider').unwrap();
                                $('#section-photo .holder a').remove();
                                $('.media-content .bxslider').bxSlider(optionsSlider.photoSettings);
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

    preventEmptyTabs();
    function preventEmptyTabs(){
        $('.mediaTabProf').each(function(){
            var numOfmediaElements = $(this).find('.badge').text();
            if (numOfmediaElements == 0){
                $(this).addClass('disabled');
            }
        })
    }

    $(document).on('click','.perfEditViewToggle', function(){
        var parentPerformanceForm = $(this).parents('article');
        $(parentPerformanceForm).toggleClass( 'perfBlockView' );
    })

    $(document).on('click','.deleteOfferBtn', function(){
        var parentPerformanceForm = $(this).parents('form'),
            parentPerformance = parentPerformanceForm.parent('article'),
            performanceId = parentPerformanceForm.attr('id'),
            slug = $('#slug').text();
        deleteOffer(slug, performanceId, parentPerformance)
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
    };

    $(document).on('click','#addNewPerformanceBtn', function(){
        var newPerformanceBlock = $('.newPerformanceBlank').clone();
        newPerformanceBlock.insertBefore('.controls.add').removeClass('newPerformanceBlank, hidden').fadeIn(800);
        createNewPerf(newPerformanceBlock)
    });

    function createNewPerf(newPerformanceBlock){
        console.log(newPerformanceBlock)
        var slug = $('#slug').text();
        $.ajax({
            type: "POST",
            url: '/profile/' + slug + '/performance/new',
            data: {"performance[title]": 'new event',"performance[status]":"draft"},
            success: function (response) {
                console.log(response)
                $(newPerformanceBlock).find('form').attr('id', response.performance.id);
            }
        })
    }

    $(document).on('click','.saveOfferPerf', function(){
        console.log('saveOffer')
        var parentPerformanceForm = $(this).parents('form'),
            parentPerformance = parentPerformanceForm.parent('article'),
            performanceId = parentPerformanceForm.attr('id'),
            slug = $('#slug').text(),
            dataSendOfferTitile = $(parentPerformanceForm).find('.offerTitlePerf').val(),
            dataSendOfferInf = $(parentPerformanceForm).find('.description-area').val();
        console.log(performanceId);
        var dataToSendOffer = {"performance[title]": dataSendOfferTitile,
                               "performance[status]":"draft",
                               "performance[techRequirement]": dataSendOfferInf};
        if(performanceId == 'NewBlank'){
            var perfCreateUrl = '/profile/' + slug + '/performance/new';
        } else {
            var perfCreateUrl = '/profile/performance/' + performanceId + '/edit';
        }
        console.log(slug, perfCreateUrl, dataSendOfferTitile)
        saveOffer(slug, perfCreateUrl, dataToSendOffer, parentPerformance)
    });

    function saveOffer(slug, perfCreateUrl, dataToSendOffer, parentPerformance){
        $.ajax({
            type: "PATCH",
            url: perfCreateUrl,
            data: dataToSendOffer,
            success: function (responseText) {
                $(parentPerformance).find('.successMessagePerf').removeClass('hidden');
                setTimeout(function() { $(parentPerformance).find('.successMessagePerf').addClass('hidden'); }, 3500)
            }
        })
    }

    $(document).on('click','.price-list .pagination a', function(event){
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

    $(document).on('click','.feedbacks .pagination a', function(event){
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





