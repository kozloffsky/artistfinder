$(function () {

    $(".navbar-nav li a").click(function (event) {
        $(".navbar-collapse").collapse('hide');
    });

    var optionsSlider = {
        photoSettings: {
            adaptiveHeight: true,
            mode: 'fade',
            pagerCustom: '#photo-pager',
            nextSelector: '#nextSlide',
            prevSelector: '#prevSlide',
            nextText: '<i class="right fa fa-3x fa-angle-right"></i>',
            prevText: '<i class="left fa fa-3x fa-angle-left"></i>',
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

    $('.media-content .bxslider').bxSlider(optionsSlider.photoSettings);
    $('.bxVideoSlider').bxSlider(optionsSlider.videoSettings);

    $('.profile select').each(function () {
        var placeholder = $(this).attr('data-placeholder');
        var $select2 = $(this).select2({
            placeholder: placeholder || '',
            minimumResultsForSearch: -1
        });

        var className = $(this).attr('data-class');
        $select2.data('select2').$selection.addClass(className);
        $select2.data('select2').$results.addClass(className);
    });

    function resizeThumbs() {
        // console.log('resize');
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

    $(window).bind('resize', $.throttle(250, function () {
        resizeThumbs();
    }));
    $(window).scroll($.throttle(100, changeHeaderColorOnScroll));

    $('a.anchor-scroll').click(function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: ($($.attr(this, 'href')).offset().top - 72)
        }, 500);
        return false;
    });

    $('.media .tab').click(function (e) {
        e.preventDefault();
        $('.media .tab').removeClass('active');
        $('.media-content').removeClass('active');

        $($.attr(this, 'data-target')).addClass('active');

        $(this).addClass('active');

        resizeThumbs();
        // if($($(this)).attr('data-target').indexOf('section-video') !== -1){
        //     getVideoHeight();
        // } else {
        //     return false;
        // }
        return false;
    });

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $('.header-block input, textarea').focus(function () {
        $(this).data('placeholder', $(this).attr('placeholder'))
            .attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).data('placeholder'));
    });

    $('#new-event').click(function (e) {
        e.preventDefault();
        $('#freeQuoteModalRegisterd .modal-body').toggle();
    });

    $('#r_comment_toggle').click(function (e) {
        e.preventDefault();
        $('#r_comment_area').toggle();
    });

    $('#t_comment_toggle').click(function (e) {
        e.preventDefault();
        $('#t_comment_area').toggle();
    });

    // Feedback block text toggle
    $('.feedback-block .text').each(function () {
        var $element = $(this);
        var $toggler = $element.find('.more');
        var $gradient = $element.find('.gradient');
        var $text = $element.find('.feedback-text');
        var text = $text.html();

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

    // Pagination script
    $('.paginate-section').each(function () {
        var $element = $(this);
        var buttons = [];

        var $showMoreBtn = $element.find('.show-more-info');
        var $paginationControls = $element.find('.pagination');
        var $paginationPrevButton = $paginationControls.find('.prev-page');
        var $paginationNextButton = $paginationControls.find('.next-page');


        var itemsPerPage = $element.attr('data-items-per-page');
        var itemClass = $element.attr('data-item-class');
        var currentPage = -1;

        var $items = $element.find('.' + itemClass);
        if ($items.length < itemsPerPage) {
            $paginationControls.remove();
        }

        var pagesCount = Math.ceil($items.length / itemsPerPage);
        if (pagesCount == 1) {
            $paginationControls.hide();
        }

        showPage(0, true);
        createButtons(pagesCount);

        function showPage(page, firstLoad) {
            if (firstLoad) {
                $items.hide();
            }
            currentPage = page;

            ajustControls(page);

            $paginationControls.find('.button').removeClass('active');
            if (buttons) $(buttons[page]).find('.button').addClass('active');

            ajustControls(page);
            if ($(window).width() > 768) {
                $items.hide();
            }
            var from = page * itemsPerPage;

            if (from < 0) from = 0;
            if (from > $items.length - 1) from = $items.length;

            var to = from + parseInt(itemsPerPage);

            if (to > $items.length - 1) to = $items.length;

            for (var i = from; i < to; i++) {
                $($items[i]).show();
            }
        }

        function ajustControls(page) {
            $paginationNextButton.removeClass('not-active');
            $paginationPrevButton.removeClass('not-active');

            if (page == 0) $paginationPrevButton.addClass('not-active');
            if (page == pagesCount - 1) $paginationNextButton.addClass('not-active');

            if (pagesCount > 5 && buttons.length > 0) {
                buttons.forEach(function (element, index) {
                    switch (currentPage) {
                        case 0:
                            if (index > currentPage + 4) {
                                element.hide();
                            } else {
                                element.show();
                            }
                            break;
                        case 1:
                            if (index > currentPage + 3) {
                                element.hide();
                            } else {
                                element.show();
                            }
                            break;
                        case pagesCount - 1:
                            if (index < pagesCount - 5) {
                                element.hide();
                            } else {
                                element.show();
                            }
                            break;
                        case pagesCount - 2:
                            if (index < pagesCount - 5) {
                                element.hide();
                            } else {
                                element.show();
                            }
                            break;
                        default :
                            if (index < currentPage - 2 || index > currentPage + 2) {
                                element.hide();
                            } else {
                                element.show();
                            }
                    }
                });
            }
        }

        function createButtons(count) {
            var $button = $paginationControls.find('.pagination-button');
            var currentButton = $button;

            buttons.push($button);

            for (var i = 1; i < count; i++) {
                var element = $button.clone();
                currentButton.after(element);
                buttons.push(element);
                currentButton = element;
                element.find('.button').html(i + 1);
                element.find('a').attr('data-page-number', i);
            }

            buttons.forEach(function (item) {
                var button = $(item).find('a');
                var pageNumber = parseInt(button.attr('data-page-number'));
                button.click(function (e) {
                    e.preventDefault();
                    showPage(pageNumber);
                });
            });

            $button.find('.button').addClass('active');
            ajustControls(currentPage);
        }

        function nextPage(e) {
            e.preventDefault();
            if (currentPage == pagesCount - 1) return;
            currentPage++;
            showPage(currentPage);

            if (currentPage == pagesCount - 1) {
                $showMoreBtn.hide();
            }
        }

        function prevPage(e) {
            e.preventDefault();
            if (currentPage == 0) return;
            currentPage--;
            showPage(currentPage);
        }

        $showMoreBtn.click(nextPage);
        $paginationNextButton.click(nextPage);
        $paginationPrevButton.click(prevPage);
    });

    // function initialize() {
    //     var myLatlng = new google.maps.LatLng(-34.397, 150.644);
    //     var myOptions = {
    //         zoom: 8,
    //         center: myLatlng,
    //         disableDefaultUI: true,
    //         mapTypeId: google.maps.MapTypeId.ROADMAP
    //     };
    //     var map = new google.maps.Map(document.getElementById("my-map"), myOptions);
    //     var marker = new google.maps.Marker({
    //         position: new google.maps.LatLng(-34.397, 150.644)
    //     });
    //     marker.setMap(map);
    // }
    //
    // $('#freeQuoteModalRequest').on('shown.bs.modal', function () {
    //     initialize();
    // });

    $('#timepicker').datetimepicker({
        format: 'LT'
    });

    $('#datepicker, #datepicker1').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    function removeFeedbackHtml(id) {
        $("article[data-feedback-id='" + id + "']").remove();
    }

    function deleteFeedback() {
        var $this = $(this);
        if (confirm('Are you sure?')) {
            var id = $this.parents('.feedback-block').data('feedbackId');
            $.ajax({
                url: "/dashboard/feedbacks/" + id,
                method: "DELETE",
                success: function (data) {
                    removeFeedbackHtml(id);
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }
    }

    $(".remove-feedback").click(deleteFeedback);
    
    // var disableLabel = $('.free-quote-modal.request .custom-checkbox.small label');
    //
    // disableLabel.on('click', function(){
    //     $(this).closest('.row').addClass('disabled');
    //     $(this).closest('.row').find('.js-example-disabled').prop("disabled", true);
    //     $(this).closest('.row').find('.js-example-disabled-multi').prop("disabled", true);
    // });

});