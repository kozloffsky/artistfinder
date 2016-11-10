;$(function() {

    function openQuotationModal() {
        $("#quotationModal").modal('show');;
    }

    $(".enquiries .quotationSendbtn").on("click", openQuotationModal);

    var quotationAutocompService = new GoogleAutocompleteService(),
        isAvailable = quotationAutocompService.getFormElements('.quotation-modal form[name="quotation_place_info"]');

    if(isAvailable)
        quotationAutocompService.initAutoComplete();
});