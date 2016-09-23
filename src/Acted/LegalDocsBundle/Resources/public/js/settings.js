/**
  * Settings page.
  *
  */
var file = "";

function readFile() {
  if (this.files && this.files[0]) {
        var FR = new FileReader();

        FR.onload = function(e) {
          $("div.img-box").html("<img src='"+e.target.result+"'>");
          $("#cropperModal .img-container img").attr("src", e.target.result)

          file = e.target.result;
          $("#cropperModal").modal();
        };       

        FR.readAsDataURL( this.files[0] );
      }
}


function prepareSettingsData() {

  var contactForm = $("form[name=\"contactForm\"]").serializeArray(),
    profileForm = $("form[name=\"profileForm\"]").serializeArray(),
    paymentForm = $("form[name=\"paymentForm\"]").serializeArray(),
    allForms = contactForm.concat(profileForm, paymentForm),
    sendForm = "";

  for(key in allForms) {
    //sendForm.append("profile_settings["+allForms[key].name+"]",  allForms[key].value);
    sendForm += "profile_settings["+allForms[key].name+"]="+allForms[key].value+"&";
  }

  return sendForm;
}

$("input[name=\"photo\"]").change(readFile);

$("button.btn-edit").on("click", function(e) {
  e.preventDefault();
  var form = prepareSettingsData();

  //form.append("profile_settings[file]", file);
  form += "profile_settings[file]="+file;

  HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/1" });

  HTTPProvider.send(form);
})


var cropBoxData;
var canvasData;
var cropper;

$('#cropperModal').on('shown.bs.modal', function () {
  var dkrm = new Darkroom("#cropperModal .img-container img", {
      minWidth: 100,
      minHeight: 100,
      maxWidth: 320,
      maxHeight: 240,
      ratio: 4/3,
      backgroundColor: '#000',
      plugins: {
        crop: {
          minHeight: 50,
          minWidth: 50,
          maxHeight: 240,
          maxWidth: 320,
          ratio: 4/3
        },
        save: {
          callback: function() {
        this.darkroom.selfDestroy();
        var newImage = dkrm.canvas.toDataURL();
        file = newImage;

        $("div.img-box").html("<img src='"+file+"'>");
        $("#cropperModal").modal("hide");

        var form = prepareSettingsData();

        form += "profile_settings[file]="+file;

        HTTPProvider.prepareSend({ method: "PUT", url: "/profile/settings/edit/1" });

        HTTPProvider.send(form);
        }
    }
      },
      initialize: function() {
        var cropPlugin = this.plugins['crop'];
        
        cropPlugin.requireFocus();
      }
    });
}).on('hidden.bs.modal', function () {});