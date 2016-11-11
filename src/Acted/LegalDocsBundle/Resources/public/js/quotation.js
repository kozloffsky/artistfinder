$(function() {

    var inheritFrom = function (child, parent) {
        child.prototype = Object.create(parent.prototype);
    }

    function QuotationModel() {
        this.model = {};
    }

    function QuotationView(selector) {
        this.template = document.getElementById(selector).innerHTML;
        this.render = function(data) {
            return _.template(this.template)(data);
        }
    }

    /**
     * 'QEM'
     * Quotation event model for store data about event
     */
    function QuotationEventModel(model) {
        this.model = model;
    }
    /**
     * 'QAM'
     * Quotation performance model for store data about performance
     */
    function QuotationActModel(model) {
        this.model = model;
    }

    /**
     * 'QPM'
     * Quotation payment model for store data about payment
     */
    function QuotationPaymentModel(model) {
        this.model = model;
    }
    /** ----------------------------------------------------- **/
    inheritFrom(QuotationEventModel,     QuotationModel);
    inheritFrom(QuotationActModel,       QuotationModel);
    inheritFrom(QuotationPaymentModel,   QuotationModel);


    /** ----------------------------------------------------- **/
    // Modal view
    function QuotationModalView(model) {
        var modalTemplate = document.getElementById('quot-modal-tmp').innerHTML;
        
        var templateData = {
            title: model.title,
            event: model.eventTemplate,
            payment: model.paymentTemplate,
            performance: model.performanceTemplate
        };

        this.render = function() {
            return _.template(modalTemplate)(templateData);
        }
    }

    // Event section view
    function QuotationEventView(QuotationEventModel) {
        this.template = document.getElementById('quot-event-tmp').innerHTML;
        this.render = function() {

            var tempData = {
                data: QuotationEventModel
            };

            return _.template(this.template)(tempData);
        }
    }
    // Performance section view
    function QuotationActView() {
        this.template = document.getElementById('quot-performance-tmp').innerHTML;

        this.render = function() {
            var data = {
                items: [
                    'da',
                    'net',
                    'vot tak'
                ]
            };

            return _.template(this.template)(data);
        }
    }
    // Payment section view
    function QuotationPaymentView(QuotationPaymentModel) {
        this.template = document.getElementById('quot-payment-tmp').innerHTML;

        this.model = QuotationPaymentModel;
        this.render = function() {

            var tempData = {
                data: this.model
            };

            return _.template(this.template)(tempData);
        }
    }
    


    /** ------------------------------------------------------- **/
    function getEventData(eventId, cb) {
        $.ajax({
            url: "/event/user_events/" + eventId,
            method: "POST",
            success: function(resp) {
                cb(null, resp.event);
            },
            error: function(err) {
                cb(err, null);
            }
        });
    }

    function openQuotationModal() {
        var eventId = $(this).attr("event-id");

        getEventData(eventId, function(err, res) {

            console.log(res)

            // Event template generation
            var QEM = new QuotationEventModel(res),
                QEV = new QuotationEventView(QEM);
                QEV = QEV.render();

            // Performance template generation
            var QAM = new QuotationActModel(""),
                QAV = new QuotationActView(QAM);
                QAV = QAV.render();

            // Performance template generation
            var QPM = new QuotationPaymentModel(""),
                QPV = new QuotationPaymentView(QPM);
                QPV = QPV.render();

            // Generate and render modal view
            var allData = {
                title: res.user.firstname + " " + res.user.lastname,
                eventTemplate: QEV,
                paymentTemplate: QPV,
                performanceTemplate: QAV
            };

            var QMV = new QuotationModalView(allData),
                QMVRendered = QMV.render();

            $("#quotationModal").find(".modal-content").html(QMVRendered);
            $("#quotationModal").modal('show');
        });

        // $('form[name="quotation_act_info"]')
        // $('form[name="quotation_event_info"]')
        // $('form[name="quotation_payment_info"]')
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

