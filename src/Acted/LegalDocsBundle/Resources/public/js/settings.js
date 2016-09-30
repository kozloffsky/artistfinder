$(function(){
    'use strict';

    var win = $(window),
        userId = "",
        defaultCity = "",
        activeClass = 'active',
        errorClass = 'error',
        box = 'box',
        setingsSection = $('.settings'),
        sideBar = setingsSection.find('.sidebar'),
        btnEdit = setingsSection.find('.btn-edit'),
        fileUpload = setingsSection.find('.file'),
        URL = window.URL,
        imgBox = setingsSection.find('.img-box'),
        img,
        file,
        base64,
        imgNaturWidth = 320,
        imgNaturHeight = 240;

    var $uploadCropMediaOffer;

    function chooseCityQuote(selectedCountryOption){
        if(selectedCountryOption){
            $.ajax({
                type:'GET',
                url: '/geo/city?_format=json&country=' + selectedCountryOption,
                success:function(response){
                    defaultCity = $("#setting_city").attr("value");
                    $('#setting_city').empty();
                    $(response).each(function() {
                        if(defaultCity == this.name) {
                            $('#setting_city').append('<option selected value="' + this.id + '" name="city">' + this.name + '</option>');
                        } else {
                            $('#setting_city').append('<option value="'+ this.id +'" name="city">'+this.name+'</option>');
                        }
                    });
                }
            })
        }
    }
    function selectBoxEventHandler() {
        var selectedCountryOption = $('#settings_country').find('option:selected').val();
        chooseCityQuote(selectedCountryOption);
    }
    function settingCityEventHandler() {
        var cur = $(this);
        cur.closest('.box').find('h2').text(cur.closest('.box').find('option:selected').text());
    }
    function radioBoxEventHandler(e) {
        $(this).attr("value", $(this).attr("id") === "ready_1" ? true : false);
    }
    function prepareSettingsData() {

        userId = $("#artist_id").val();

        var contactForm = $("form[name=\"contactForm\"]").serializeArray(),
            profileForm = $("form[name=\"profileForm\"]").serializeArray(),
            paymentForm = $("form[name=\"paymentForm\"]").serializeArray(),
            allForms = contactForm.concat(profileForm, paymentForm),
            sendForm = "";

        for(var key in allForms) {
            sendForm += "profile_settings["+allForms[key].name+"]="+allForms[key].value+"&";
        }

        sendForm += "profile_settings[file]=" + base64;

        return sendForm;
    }
    function setHeight(param) {
        sideBar.css({
            height: param || setingsSection.height()
        });
    }
    function settingsFormErrorHandler(data) {
        var errors = HTTPProvider.errorsSerialize(data);

        $("label.error").css("opacity", 0);

        if(errors)
            for(var k in errors) {
                var textError = "";
                var len = errors[k].length;

                textError = errors[k];

                if (len > 1)
                    for (var i = 0; i < len; i++)
                        textError += errors[k][i] + " ";

                $("[name=\"" + k + "\"]").closest('.box').find('label').css("opacity", 1);
                $("[name=\"" + k + "\"]").closest('.box').find('label').text(textError);
            }

        $("#addImageModal").modal('hide');
    }

    selectBoxEventHandler();

    $('#settings_country').on('change', selectBoxEventHandler);
    $('#setting_city').on('change', settingCityEventHandler);
    $('.settings input[type="radio"]').on('change', radioBoxEventHandler);

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $uploadCropMediaOffer.croppie('bind', {
                    url: e.target.result
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $('#uploadNewMedia').on('change', function () {
        readFile(this);
    });

    $("button.upload-NewMedia").on('click', function(e) {
       e.preventDefault();
        $('#hidden-demo').croppie('bind')
        $uploadCropMediaOffer.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
                base64 = resp;

                $("div.img-box").removeAttr("style");
                $("div.img-box").css("background", "url('"+base64+"') no-repeat");

                var form = prepareSettingsData();
                HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/"+userId });
                HTTPProvider.send(form, settingsFormErrorHandler);
        });
    });

    $("input[name=\"photo\"]").on('click', function(e) {
        e.preventDefault();

        $uploadCropMediaOffer = $('#addImageModal .changeImageContiner').croppie({
            viewport: {
                width: 320,
                height: 240
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        setTimeout(function(){
            $('#addImageModal .changeImageContiner').croppie('bind');
        }, 1000);

        $("#addImageModal").modal();
    });

    btnEdit.on({
        'click': function (e) {
            e.preventDefault();
            var cur = $(this);

            if(cur.closest('.'+box).hasClass(activeClass)){
                cur.closest('.'+box).removeClass(activeClass);
            } else {
                cur.closest('.'+box).addClass(activeClass);

                var form = prepareSettingsData();

                cur.closest('.box').find('h2').text(cur.closest('.box').find('input').val());

                HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/"+userId });
                HTTPProvider.send(form, settingsFormErrorHandler);
            }
        }
    });
    win.on({
        'load resize orientationchange': function() {
            if(win.width() < 768){
                setHeight('auto');
            } else {
                setHeight();
            }
        }
    });
});