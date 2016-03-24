$(function () {
  //$('#phone_number').cleanVal(); to get phone number.

  //Enabling form validation.
  $("#artistForm").validate();

  //Initializing phone mask.
  $('#phone_number').mask('+44 (000) 000-0000', {placeholder: "+44 (___) ___-____"});


  var $select2 = $("#country").select2({
    placeholder: "Select Country",
    minimumResultsForSearch: -1
  }).on("change", function (e) {
    //Change mask here... Example:
    var selectedCountry = $('#country').find('option:selected').text();
    $('#phone_number').val('');

    switch (selectedCountry) {
      case 'France':
        $('#phone_number').mask('+33 (00) 0000-0000', {placeholder: "+33 (0_) ____-____"});
        break;
      case  'Germany':
        $('#phone_number').mask('+49 (0000) 0000-0000', {placeholder: "+49 (0___) ____-____"});
        break;
      //Default country Uk
      case 'United Kingdom':
      default:
        $('#phone_number').mask('+44 (000) 000-0000', {placeholder: "+44 (___) ___-____"});
        break;
    }


  });
  $select2.data('select2').$results.addClass($select2.attr('data-class'));


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
    $('#step-counter').html('Step 1');
    $('#modal-title').html('Sign Up');
    $('#stage-1').show();
    $('#completionTime').show();
  }

  function showSecondPage(isArtist) {
    var text;
    if (isArtist) {
      userIsArtist = isArtist;
      text = 'Which acts do you perform?'
    } else {
      text = 'Contact details'
    }
    $('.stage').hide();
    $('.sub-stage').hide();
    $('.modal-header').show();
    $('#step-counter').html('Step 2');
    $('#modal-title').html(text);
    if (isArtist) {
      $('#artistBlock').show();
    } else {
      $('#customerBlock').show();
    }
    $('#stage-2').show();
    $('#completionTime').hide();
    $('#modal-title').focus();
  }

  function showThirdPage() {
    $('.stage').hide();
    $('.modal-header').show();
    $('#step-counter').html('Step 3');
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

  $('#customerBtn, #customerImg').click(function() {
    chageState(2, false);
  });


  $('#stageTwoNext').click(function () {
    chageState(3);
  });
  $('.back-button').click(function () {
    if (currentState - 1 == 2) {
      chageState(currentState - 1, userIsArtist);
    } else {
      chageState(currentState - 1);
    }
  });


  function finishRegistration()
  {
    chageState(4);
  }


  $('#stageThreeNext').on('click', function(){
    artistRegister();
  });

  $('#stageThreeNextCustomer').on('click', function(){
    customerRegister();
  });

  function artistRegister(){
    var userInformation = $('.artistRegForm').serialize();
    var categories = $('#categoriesForm').serialize();
    var userRole = 'role=ROLE_ARTIST';
    registerArtist(userInformation, categories, userRole);
  };

  function registerArtist(userInformation, categories, userRole) {
    $.ajax({
      type: "POST",
      url: '/register',
      data: userRole + '&' + userInformation + '&' + categories,
      success: function(){
        console.log('greate')
        finishRegistration()
      }
    })
  }

  function customerRegister(){
    var customerValues = $('.customerRegForm').serialize();
    var customerRole = 'role=ROLE_CLIENT'
    $.ajax({
      type: "POST",
      url: '/register',
      data: customerRole +'&'+customerValues,
      success: function(){
        console.log('greate')
        finishRegistration()
      }
    })
  }
});