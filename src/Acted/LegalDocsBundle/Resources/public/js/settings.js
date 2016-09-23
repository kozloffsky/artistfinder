$(function(){
    'use strict';

    var win = $(window),
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

    function prepareSettingsData() {

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

    btnEdit.on({
        'click': function (e) {
            e.preventDefault();
            var cur = $(this);

            if(cur.closest('.'+box).hasClass(activeClass)){
                cur.closest('.'+box).removeClass(activeClass);
            } else {
                cur.closest('.'+box).addClass(activeClass);

                var form = prepareSettingsData();

                HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/1" });
                HTTPProvider.send(form);
            }
        }
    });

    fileUpload.change(function () {
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                if(this.naturalWidth <= imgNaturWidth && this.naturalHeight <= imgNaturHeight){
                    imgBox.append(img);
                    imgBox.removeClass('error');

                    var FR = new FileReader();

                    FR.onload = function(e) {
                        base64 = e.target.result;

                        var form = prepareSettingsData();

                        HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/1" });
                        HTTPProvider.send(form);

                    };

                    FR.readAsDataURL(file);
                } else {
                    imgBox.addClass('error');
                    imgBox.find('img').remove();
                }
            };

            img.src = URL.createObjectURL(file);
        }
    });

    function setHeight(param) {
        sideBar.css({
            height: param || setingsSection.height()
        });
    }

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