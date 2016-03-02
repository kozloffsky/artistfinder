$(function () {
  //$('#phone_number').cleanVal(); to get phone number.

  //Enabling form validation.
  $(".details-form").validate();

  //Initializing phone mask.
  $('#phone_number').mask('+44 (000) 000-0000', {placeholder: "+44 (___) ___-____"});

  $("#country").select2({
    placeholder: "Select Country",
    minimumResultsForSearch: -1
  }).on("change", function (e) {
    //Change mask here... Example:
    var selectedCountry = $('#country').val();
    $('#phone_number').val('');

    switch (selectedCountry) {
      case 'Fr':
        $('#phone_number').mask('+33 (00) 0000-0000', {placeholder: "+33 (0_) ____-____"});
        break;
      case  'De':
        $('#phone_number').mask('+49 (0000) 0000-0000', {placeholder: "+49 (0___) ____-____"});
        break;
      //Default country Uk
      case 'Uk':
      default:
        $('#phone_number').mask('+44 (000) 000-0000', {placeholder: "+44 (___) ___-____"});
        break;
    }


  });

  var currentState = 1;
  var userIsArtist = true;

  //Change registration modal state.
  function chageState(state, isArtist) {
    currentState = state;
    switch (state) {
      case 1:
        showFirstPage();
        break;

      case 2:
        showSecondPage(isArtist);
        break;

      case 3:
        showThirdPage();
        break;

      case 4:
        showFinishPage();
        break;

      case "reset":
      default:
        showFirstPage();
    }
  }

  //State switch functions.
  function showFirstPage() {
    $('.stage').hide();
    $('.modal-header').show();
    $('#step-counter').html('Step 1/3');
    $('#modal-title').html('Sign Up');
    $('#stage-1').show();
    $('#completionTime').show();
  }

  function showSecondPage(isArtist) {
    if (isArtist) userIsArtist = isArtist;
    $('.stage').hide();
    $('.sub-stage').hide();
    $('.modal-header').show();
    $('#step-counter').html('Step 2/3');
    $('#modal-title').html('Which acts do you perform?');
    if (isArtist) {
      $('#artistBlock').show();
    } else {
      $('#customerBlock').show();
    }
    $('#stage-2').show();
    $('#completionTime').hide();
  }

  function showThirdPage() {
    $('.stage').hide();
    $('.modal-header').show();
    $('#step-counter').html('Step 3/3');
    $('#modal-title').html('Contact details');
    $('#stage-3').show();
    $('#completionTime').hide();
    $('#first_name').focus();
  }

  function showFinishPage() {
    $('.stage').hide();
    $('.modal-header').hide();
    $('#stage-4').show();
    $('#completionTime').hide();
  }


  function resetModal() {
    $('.registration-modal [type="checkbox"]').prop('checked', false);
    $('.details-form input').val('');
    $('.category').removeClass('open');
    showFirstPage();
  }

  $('#registrationModal').on('show.bs.modal', function (e) {
    resetModal();
  });

  $('#entertainerBtn, #entertainerImg').click(function () {
    chageState(2, true);
  });


  $('#stageTwoNext').click(function () {
    chageState(3);
  });
  $('#stageThreeNext').click(function () {
    chageState(4);
  });
  $('.back-button').click(function () {
    if (currentState - 1 == 2) {
      chageState(currentState - 1, userIsArtist);
    } else {
      chageState(currentState - 1);
    }
  });

  $('.category').click(function () {
    $(this).toggleClass('open');

    if ($(window).width() > 767) {
      var id = $(this).attr('data-toggle-desktop');
      $('#' + id).toggleClass('open');
    }
  })
});