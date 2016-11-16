$(function(){
    'use strict';

    var settingsAutocompService = new GoogleAutocompleteService(),
        isAvailable = settingsAutocompService.getFormElements('.settings form[name="contactForm"]');

    if(isAvailable)
        settingsAutocompService.initAutoComplete();

    // TODO: Add validation for rest forms.
    var settingsFormValid;

    function radioBoxEventHandler(e) {
        $(this).attr("value", $(this).attr("id") === "ready_1" ? true : false);
    }
    function prepareSettingsData() {
        try {
            userId = JSON.parse(localStorage.getItem("user")).artistId;
        } catch (e) {
            userId = 0;
        }

        var cityLatInput = $('form[name="paymentForm"]').find('input[name="city_lat"]'),
            cityLngInput = $('form[name="paymentForm"]').find('input[name="city_lng"]'),
            regnLatInput = $('form[name="paymentForm"]').find('input[name="region_lat"]'),
            regnLngInput = $('form[name="paymentForm"]').find('input[name="region_lng"]');

        var regionLat = settingsAutocompService.coords.region.lat,
            regionLng = settingsAutocompService.coords.region.lng,
            cityLat = settingsAutocompService.coords.city.lat,
            cityLng = settingsAutocompService.coords.city.lng,
            country = settingsAutocompService.currentStore.country,
            city = settingsAutocompService.currentStore.city,
            region = settingsAutocompService.currentStore.region;

        if(cityLat && cityLng) {
            cityLatInput.val(cityLat);
            cityLngInput.val(cityLng);
        }

        if(regionLat && regionLng) {
            regnLatInput.val(regionLat);
            regnLngInput.val(regionLng); 
        }

        var contactForm = $('form[name="contactForm"]').serializeArray(),
            profileForm = $('form[name="profileForm"]').serializeArray(),
            paymentForm = $('form[name="paymentForm"]').serializeArray(),
            allForms = contactForm.concat(profileForm, paymentForm),
            sendForm = "";

        for(var key in allForms) {
            var k = allForms[key].name,
                value = allForms[key].value.trim();

            switch (k) {
                case 'region_name':
                    if(value != '' && region != '') {
                        value = region;
                    }
                    break;
                case 'city':
                    if(value != '' && city != '') {
                        value = city;
                    }
                    break;
                case 'country':
                    if(value != country) {
                        value = settingsAutocompService.findCountryByCode(settingsAutocompService.availableCountries[value]);
                    }
                    break;
            }

            sendForm += "profile_settings["+k+"]="+value+"&";
        }

        sendForm += "profile_settings[file]=" + base64;

        console.log("REGION COORDS: ", settingsAutocompService.coords.region)
        console.log("CITY COORDS: ", settingsAutocompService.coords.city)

        return sendForm;
    }
    function setHeight(param) {
        sideBar.css({
            height: param || settingsSection.height()
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

        settingsFormValid = $('form[name="contactForm"]').valid();

        if(settingsFormValid) {
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
        }).then(function (resp) {
            base64 = resp;

            $("div.img-box").removeAttr("style");
            $("div.img-box").css("background", "url('"+base64+"') no-repeat");

            settingsFormValid = $('form[name="contactForm"]').valid();

            if(settingsFormValid) {
                var form = prepareSettingsData();
                HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/"+userId });
                HTTPProvider.send(form, settingsFormErrorHandler);
            }
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
            settingsSection = $('.settings'),
            sideBar = settingsSection.find('.sidebar'),
            btnEdit = settingsSection.find('.btn-edit'),
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

        $('form[name="contactForm"]').validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                city: {
                    required: true
                }
            }
        });
    }
});