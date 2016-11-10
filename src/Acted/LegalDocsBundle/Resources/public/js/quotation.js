$(function() {

    var QuotationModel = { 
        eventId: null,
        eventObj: null
    };


    function getEventData(eventId) {
        $.ajax({
            url: "/event/user_events/" + eventId,
            method: "POST",
            success: function(resp) {
                QuotationModel.eventObj = resp;
            },
            error: function(err) {
                console.log(eventId)
            }
        });
    }

    function openQuotationModal() {
        var eventId = $(this).attr("event-id");

            $("#quotationModal").modal('show');
            getEventData(eventId);
    }

    $('.modal').on('show.bs.modal', function (event) {
        console.log(this.id);
    });

    $(".enquiries .quotationSendbtn").on("click", openQuotationModal);

    var quotationAutocompService = new GoogleAutocompleteService(),
        isAvailable = quotationAutocompService.getFormElements('.quotation-modal form[name="quotation_place_info"]');

    if(isAvailable)
        quotationAutocompService.initAutoComplete();
});

