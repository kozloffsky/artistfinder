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
    function QuotationActView(QuotationPerformanceModel) {
        this.template = document.getElementById('quot-performance-tmp').innerHTML;
        this.render = function() {
            var data = {
                data: QuotationPerformanceModel
            };
            return _.template(this.template)(data);
        }
    }
    // Payment section view
    function QuotationPaymentView(QuotationPaymentModel) {
        this.template = document.getElementById('quot-payment-tmp').innerHTML;
        this.render = function() {
            var tempData = {
                data: QuotationPaymentModel
            };
            return _.template(this.template)(tempData);
        }
    }
    


    /** ------------------------------------------------------- **/

    function prepareQuotationReply(eventId) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: "/quotation/prepare",
                method: "POST",
                data: {
                    'request_quotation_prepare[event]': eventId 
                },
                beforeSend: function(){
                    $('#loadSpinner').fadeIn(500);
                },
                complete: function(){
                    $('#loadSpinner').fadeOut(500);
                },
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function getEventData(eventId, cb) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: "/event/user_events/" + eventId,
                method: "POST",
                success: function(resp) {
                    resolve(resp.event);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function openQuotationModal() {
        var eventId = $(this).attr("event-id");

        Promise.props({
            event: getEventData(eventId),
            user: userDataProvider.currentUser(),
            quot: prepareQuotationReply(eventId)
        }).then(function(result) {
            var event = result.event,
                user  = result.user,
                quot  = result.quot;

            _.assign(event.user, user);

            var performances = quot.performances,
                services     = quot.services,
                request      = quot.request_quotation,
                payment      = quot.payment_terms;

            var actObj = {
                perf: performances,
                serv: services
            };

            // Event template generation
            var QEM = new QuotationEventModel(event),
                QEV = new QuotationEventView(QEM);
                QEV = QEV.render();

            // Performance template generation
            var QAM = new QuotationActModel(actObj),
                QAV = new QuotationActView(QAM);
                QAV = QAV.render();

            // Performance template generation
            var QPM = new QuotationPaymentModel(payment),
                QPV = new QuotationPaymentView(QPM);
                QPV = QPV.render();

            // Generate and render modal view
            var fromUser = event.user.firstname.concat("", event.user.lastname);

            var allData = {
                quotation: request,
                title: fromUser,
                eventTemplate: QEV,
                paymentTemplate: QPV,
                performanceTemplate: QAV
            };

            var QMV = new QuotationModalView(allData),
                QMVRendered = QMV.render();

            $("#quotationModal").find(".modal-content").html(QMVRendered);

            var quotationAutocompService = new GoogleAutocompleteService(),
                isAvailable = quotationAutocompService.getFormElements('.quotation-modal form[name="quotation_event_info"]');

            if(isAvailable)
                quotationAutocompService.initAutoComplete();

            $("#quotationModal").modal('show');
            // $('form[name="quotation_act_info"]')
            // $('form[name="quotation_event_info"]')
            // $('form[name="quotation_payment_info"]')
        });
    }

    $('.modal').on('show.bs.modal', function (event) {
        console.log(this.id);
    });

    $(".enquiries .quotationSendbtn").on("click", openQuotationModal);

});

