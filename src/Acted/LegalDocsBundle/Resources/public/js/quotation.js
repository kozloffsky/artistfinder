;$(function() {

    function openQuotationModal() {
        $("#quotationModal").modal('show');;
    }

    $(".enquiries .quotationSendbtn").on("click", openQuotationModal);

    // $.ajax({
    //     url: "https://maps.googleapis.com/maps/api/staticmap?maptype=satellite&center=37.530101,38.600062&zoom=14&size=640x400&key=AIzaSyDLK8SupBcU-H0H0SF0PIar5UP-y-DCrTI ",
    //     method: "GET",
    //     success: function(res) {
    //         console.log(res);
    //     }
    // });

    var autocompService = new GoogleAutocompleteService(),
        isAvailable = autocompService.getFormElements('.quotation-modal form[name="quotation_place_info"]');

    if(isAvailable)
        autocompService.initAutoComplete();
});