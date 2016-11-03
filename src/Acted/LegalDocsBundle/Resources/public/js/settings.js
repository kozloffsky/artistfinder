$(function(){
    'use strict';

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
            if(allForms[key].name != 'city' && allForms[key].name != 'country')
                sendForm += "profile_settings["+allForms[key].name+"]="+allForms[key].value+"&";
        }

        var lat = GoogleAutocompleteService.coords.lat,
            lng = GoogleAutocompleteService.coords.lng,
            country = GoogleAutocompleteService.currentStore.country,
            city = GoogleAutocompleteService.currentStore.city,
            region = GoogleAutocompleteService.currentStore.region;

        sendForm += "profile_settings[file]=" + base64;

        sendForm += "&profile_settings[country]=" + country;
        sendForm += "&profile_settings[city]=" + city;

        sendForm += "&profile_settings[city_lat]=" + lat;
        sendForm += "&profile_settings[city_lng]=" + lng;
        sendForm += "&profile_settings[region_name]=" + region;
        sendForm += "&profile_settings[region_lat]=" + lat;
        sendForm += "&profile_settings[region_lng]=" + lng;

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

        $("#settingsPageModal").modal('hide');
    }
    function editButtonHandle(e) {
        e.preventDefault();
        var cur = $(this);

        if(cur.closest('.'+box).hasClass(activeClass)){
            cur.closest('.'+box).removeClass(activeClass);
        } else {
            cur.closest('.'+box).addClass(activeClass);
            cur.closest('.box').find('h2').text(cur.closest('.box').find('input').val());

            var form = prepareSettingsData();
            HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/"+userId });
            HTTPProvider.send(form, settingsFormErrorHandler);
        }
    }
    function resizeHandle() {
        if(win.width() < 768){
            setHeight('auto');
        } else {
            setHeight();
        }
    }
    function readFile(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {

                console.log(e.target.result);

                uploadCropMediaOffer.croppie('bind', {
                    url: e.target.result
                });
            };
            reader.readAsDataURL(e.target.files[0]);
        }
        else {
            console.error("Sorry - you're browser doesn't support the FileReader API");
        }
    }
    function photoUploadHandler(e) {
        e.preventDefault();

        uploadCropMediaOffer.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        })
            .then(function (resp) {
                base64 = resp;

                $("div.img-box").removeAttr("style");
                $("div.img-box").css("background", "url('"+base64+"') no-repeat");

                var form = prepareSettingsData();
                HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/"+userId });
                HTTPProvider.send(form, settingsFormErrorHandler);
            });
    };
    function photoModalHandler(e) {
        e.preventDefault();

        $('#settingsPageModal .changeImageContiner').empty().removeClass('croppie-container');

        uploadCropMediaOffer = $('#settingsPageModal .changeImageContiner').croppie({
            viewport: {
                width: 320,
                height: 240
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $("#settingsPageModal").modal();
    };

    if($(".settings").length) {
        var win = $(window),
            userId = "",
            activeClass = 'active',
            box = 'box',
            setingsSection = $('.settings'),
            sideBar = setingsSection.find('.sidebar'),
            btnEdit = setingsSection.find('.btn-edit'),
            img,
            file,
            base64;

        var uploadCropMediaOffer;

        $('.settings input[type="radio"]').on('change', radioBoxEventHandler);
        $('#settingsPageModal input[type="file"]').on('change', readFile);
        $('#settingsPageModal button.upload-NewMedia').on('click', photoUploadHandler);
        $(".settings input[name=\"photo\"]").on('click', photoModalHandler);
        btnEdit.on('click', editButtonHandle);
        win.on('load resize orientationchange', resizeHandle);

        var isAvailable = GoogleAutocompleteService.getFormElements('.settings form[name="contactForm"]');

        if(isAvailable)
            GoogleAutocompleteService.initAutoComplete();
    }
});