$(function () {
  $(".navbar-nav li a").click(function(event) {
    $(".navbar-collapse").collapse('hide');
  });

  checkAvatar();

  function checkAvatar() {
    var imageSrc = $('.avatar').attr('src');
    //console.log(imageSrc.length)
    if(imageSrc != undefined) {
      if (imageSrc.length <= 1) {
        $('.avatar').attr('src', '/assets/images/noAvatar.png');
      }
    }
  }

  $('.homeSearchStart').on('click',function () {
    var searchEntered = $(homeSearchInput).val();
    if (searchEntered.length >= 1) {
      localStorage.setItem("search", searchEntered);
    }
  })
  // Add class hover to flip-container elements.
  $(".flip-container").hover(function () {
    $(this).addClass("hover-mouse");
  }, function () {
    $(this).removeClass("hover-mouse");
  });
  function shieldFlip() {
    var shield = $('#shield');

    if (!shield.hasClass('hover-mouse')) {
      shield.toggleClass('hover', '');
    }
  }

  function cardFlip() {
    var number = getRandomInt(0, 5);

    $($('.card-flip')[number]).toggleClass('hover', '');
  }

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }

  //Every 3 seconds call flipFunction;
  setInterval(function () {
    shieldFlip();
    cardFlip();
  }, 3000);
  //Change header color on scroll
  function changeHeaderColorOnScroll() {
    if ($('body').scrollTop() > $('header').offset().top + 100) {
      $('.navbar').css('background-color', '#2228A3');
      $('.divider-vertical').css('background-color', 'rgba(24, 28, 127, 0.14)');
    } else {
      $('.navbar').css('background-color', 'rgba(59,68,235, 0.33)');
      $('.divider-vertical').css('background-color', 'rgba(4, 6, 64, 0.14)');
    }
  }

  function onScrollHandler() {
    changeHeaderColorOnScroll();

    $('.hideme').each(function (i) {

      var bottom_of_object = $(this).offset().top + 20;
      var bottom_of_window = $(window).scrollTop() + $(window).height();

      /* If the object is completely visible in the window, fade it it */
      if (bottom_of_window > bottom_of_object) {
        if (!$(this).hasClass('animated')) {
          $(this).addClass('animated');
          $(this).animate({'opacity': '1'}, {queue: false, duration: 1200});
          $(this).animate({'bottom': '0'}, {queue: false, duration: 600});
        }
      }
    });
  }

  onScrollHandler();


  //Bind changeColor function to window scroll.
  $(window).scroll($.throttle(100, onScrollHandler));
  $('.used-by-slider').bxSlider({
    minSlides: 4,
    maxSlides: 4,
    slideWidth: 230,
    slideMargin: 10,
    ticker: true,
    speed: 45000

  });
  function movedToCenter($item) {
    var style = $item.attr('style');
    var $nameBlock = $($item.parent().find('.caption-block')[0]);
    $nameBlock.attr('style', style);

    console.log();
  }

  var carousel;
  if ($(window).width() < 490) {
    //Initialize for mobile devices
    var forceWidth = $(window).width() - 70;
    var forceHeight = ($(window).width() - 70) * 0.75;

    $('#carousel').height(forceHeight + 70);

    carousel = $("#carousel").waterwheelCarousel({
      flankingItems: 2,
      forcedImageWidth: forceWidth,
      forcedImageHeight: forceHeight,
      separation: 0,
      opacityMultiplier: 1,
      horizonOffset: .5,
      horizonOffsetMultiplier: .7,
      movedToCenter: movedToCenter
    });
  } else {
    //Initialize for desktop
    $(window).on({
      'load': function(){
        carousel = $("#carousel").waterwheelCarousel({
          flankingItems: 2,
          forcedImageWidth: 364,
          forcedImageHeight: 273,
          separation: 250,
          opacityMultiplier: 1,
          movedToCenter: movedToCenter
        });
      }
    });
  }
  $('.next-control').click(function () {
    carousel.next();
  });
  $('.prev-control').on('click', function () {
    carousel.prev();
  });
  $('.header-block input').focus(function () {
    $(this).data('placeholder', $(this).attr('placeholder'))
        .attr('placeholder', '');
  }).blur(function () {
    $(this).attr('placeholder', $(this).data('placeholder'));
  });

  jQuery("#videoBackgroundPlayer").YTPlayer();

  if($('div').is('.mbYTP_wrapper')){
    setTimeout(function(){
      $('.home.header-background').css('background', 'none');
    }, 1200);
  }
});

//TODO: jQuery.mb.YTPlayer add to header youtube video.