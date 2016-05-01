$(function () {
  //$('#phone_number').cleanVal(); to get phone number.

  //Enabling form validation.


  var customerValidate =  $("#customerRegForm").validate();

  var artistValidation =  $("#artistForm").validate();

  $("#recoveryForm").validate();

  //Initializing phone mask.
  /*$('#phone_number').mask('+44 (000) 000-0000', {placeholder: "+44 (___) ___-____"});


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


  });*/

  //$select2.data('select2').$results.addClass($select2.attr('data-class'));


  var currentState = 1;
  var userIsArtist = true;

  //Change registration modal state.
  function chageState(state, isArtist) {
    currentState = state;
    console.log(state, isArtist);
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
    $('#registrationModal .stage').hide();
    $('#registrationModal .sub-stage').hide();
    $('#registrationModal .modal-header').show();
    $('#registrationModal #step-counter').html('Step 2');
    $('#registrationModal #modal-title').html(text);
    if (isArtist) {
      $('#registrationModal #artistBlock').show();
      disableCatNext();
    } else {
      $('#registrationModal #customerBlock').show();
    }
    $('#registrationModal #stage-2').show();
    $('#registrationModal #completionTime').hide();
    $('#registrationModal #modal-title').focus();
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
    $('#registrationModal [type="checkbox"]').prop('checked', false);
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
    checkCategories();
  });

  $('#artistBlock input').on('change', disableCatNext);

  function checkCategories(){
    var numberCatChecked = $('#artistBlock input:checkbox:checked').length;
    if (numberCatChecked >= 1){
      $('.errorCat').fadeOut();
      chageState(3);
    } else {
      $('.errorCat').fadeIn();
    }
  }

  function disableCatNext(){
    var numberCatChecked = $('#artistBlock input:checkbox:checked').length;
    if (numberCatChecked >= 1){
      $('#stageTwoNext').removeClass('disabled');
    } else {
      $('#stageTwoNext').addClass('disabled');
    }
  }


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

  $('.artistCategories').each(function(){
    var subCatElement = $(this).find('.category-item'),
        countSubCat = subCatElement.length;
        //catBlockEl = this;
    //console.log(countSubCat);
    if (countSubCat > 6){
        subCatElement.slice(6, countSubCat).hide();
        $(subCatElement).next('.show-more').show();
    }
  });

  $('.artistCategories .show-more').on('click',function(event){
    event.preventDefault();
    var hiddenElements = $(this).parent('div').find('div:hidden');
    $(hiddenElements).toggle();
  });

  $('#stageThreeNext').on('click', function(event){
    event.preventDefault();
    artistRegister();
  });

  $('#stageThreeNextCustomer').on('click', function(){
    customerRegister();
  });

  function artistRegister(){
    var userInformation = $('.artistRegForm').serialize();
    var categoriesForm = $('#categoriesForm').serialize();
    var userRole = 'role=ROLE_ARTIST';
    registerArtist(userInformation, categoriesForm, userRole);
  };

  $('#artistForm #stageThreeNext').prop('disabled',true);

  $("#artistForm").on('change',function(){
    var countReduiredInput = $("#artistForm input").length;
    var validInputs = [];
    setTimeout(function(){
      $("#artistForm input").each(function(){
        if ($(this).hasClass('valid')){
          validInputs.push($(this).attr('id'))
        }
      });
      var countValidElements = validInputs.length + 1;
      if(countValidElements == countReduiredInput){
        $('#artistForm #stageThreeNext').prop('disabled',false);
      }
    }, 1500);
  });

  function registerArtist(userInformation, categoriesForm, userRole) {
    $.ajax({
      type: "POST",
      url: '/register',
      data: userRole + '&' + userInformation + '&' + categoriesForm,
      success: function(){
        finishRegistration()
      },
      error: function(response){
        var regestrationResponse = response.responseJSON;
        var fields = Object.keys(regestrationResponse);
        $(fields).each(function(){
          var placeToShowErr = this;
          var errorMsg = regestrationResponse[placeToShowErr];
          if (placeToShowErr == 'email'){
            artistValidation.showErrors({
              'email': errorMsg
            });
          }
          if (placeToShowErr == 'phone'){
            artistValidation.showErrors({
              'phone': errorMsg
            });
          }
          if (placeToShowErr == 'primaryPhone'){
            artistValidation.showErrors({
              'phone': errorMsg
            });
          }
          if (placeToShowErr == 'firstname'){
            artistValidation.showErrors({
              'firstname': errorMsg
            });
          }
          if (placeToShowErr == 'lastname'){
            artistValidation.showErrors({
              'lastname': errorMsg
            });
          }
          if (placeToShowErr == 'slug'){
            artistValidation.showErrors({
              'name': errorMsg
            });
          }
          if (placeToShowErr == 'password' && errorMsg.first){
            artistValidation.showErrors({
              'password[first]': errorMsg.first
            });
          }
        })
      }
    })
  }

  function customerRegister(){
    var customerValues = $('.customerRegForm').serialize();
    var customerRole = 'role=ROLE_CLIENT';
    $.ajax({
      type: "POST",
      url: '/register',
      data: customerRole +'&'+customerValues,
      success: function(){
        finishRegistration()
      },
      error: function(response){
        var regestrationResponse = response.responseJSON;
        var fields = Object.keys(regestrationResponse);
        $(fields).each(function(){
          var placeToShowErr = this;
          var errorMsg = regestrationResponse[placeToShowErr];
          if (placeToShowErr == 'email'){
            customerValidate.showErrors({
              'email': errorMsg
            });
          } else if(placeToShowErr == 'password' && errorMsg.first) {
            customerValidate.showErrors({
              'password[first]': errorMsg.first
            });
          }
          if (placeToShowErr == 'firstname'){
            artistValidation.showErrors({
              'firstname': errorMsg
            });
          }
          if (placeToShowErr == 'lastname'){
            artistValidation.showErrors({
              'lastname': errorMsg
            });
          }
        })
      }
    })
  }

  $('#passwordRecovery').on('click', function()
  {
    var recoveryPasswordVal = $('#recoveryForm').serialize();
    console.log(recoveryPasswordVal);
    repairPassword(recoveryPasswordVal);
  });


  function repairPassword(recoveryPasswordVal) {
    $.ajax({
      type: "POST",
      url: '/resetting/request',
      data: recoveryPasswordVal
    })
  }

});