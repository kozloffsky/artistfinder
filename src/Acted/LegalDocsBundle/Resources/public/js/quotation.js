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

    /**
     * 'QRM'
     * Quotation request model for store quotation request information
     */
    function QuotationRequestModel(model) {
        this.model = model;
    }


    /** ----------------------------------------------------- **/
    inheritFrom(QuotationEventModel,     QuotationModel);
    inheritFrom(QuotationActModel,       QuotationModel);
    inheritFrom(QuotationPaymentModel,   QuotationModel);
    inheritFrom(QuotationRequestModel,   QuotationModel);


    /** ----------------------------------------------------- **/
    // Modal view
    function QuotationModalView(model) {
        var modalTemplate = document.getElementById('quot-modal-tmp').innerHTML;
        
        var templateData = {
            title: model.title,
            event: model.eventTemplate,
            payment: model.paymentTemplate,
            services: model.servicesTemplate,
            performance: model.performanceTemplate,
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
    
    var QEM = {};
    var QEV = {};
    var QAM = {};
    var QAV = {};
    var QPM = {};
    var QPV = {};
    var QMV = {};
    var QRM = {};


    /** ------------------------------------------------------- **/
    /** --- APIS --- **/
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
    function getEventData(eventId) {
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
    /** --- SEND QUOTE CONFIRMATION --- **/
    function sendQuotationConfirmation(data) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/quotation/send',
                method: 'POST',
                data: data,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
    /** --- SELECT PERFORMANCE --- **/
    function selectQuotaionPerformance(data) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/quotation/select/'+data.quot+'/performance/'+data.perf,
                method: 'PATCH',
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
    /** --- SELECT SERVICE --- **/
    function selectQuotaionService(data) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/quotation/select/'+data.quot+'/service/'+data.serv,
                method: 'PATCH',
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
    /** --- SELECT PACKAGE --- **/
    function selectQuotaionPackage(package) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/package/select/' + package.id,
                method: 'PATCH',
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
    /** --- SELECT OPTION --- **/
    function selectQuotaionOption(option) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/option/select/'+option.id,
                method: 'PATCH',
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }


    /** ------------------------------------------------------- **/

    function openQuotationModal() {
        var eventId = $(this).attr("event-id");

        Promise.props({
            event: getEventData(eventId),
            user: userDataProvider.currentUser(),
            quot: prepareQuotationReply(eventId)
        }).then(function(result) {
            var event = result.event;
            var user  = result.user;
            var quot  = result.quot;

            _.assign(event.user, user);

            var performances = quot.performances;
            var services     = quot.services;
            var request      = quot.request_quotation;
            var payment      = quot.payment_terms;

            var actObj = {
                perf: performances,
                serv: services
            };

            // Event template generation
            QEM = new QuotationEventModel(event),
            QEV = new QuotationEventView(QEM);
            QEV = QEV.render();

            // Performance template generation
            QAM = new QuotationActModel(actObj),
            QAV = new QuotationActView(QAM);
            QAV = QAV.render();

            // Performance template generation
            QPM = new QuotationPaymentModel(payment),
            QPV = new QuotationPaymentView(QPM);
            QPV = QPV.render();

            // Service template generation

            // Generate and render modal view
            var fromUser = event.user.firstname.concat(" ", event.user.lastname);

            var allData = {
                quotation: request,
                title: fromUser,
                eventTemplate: QEV,
                paymentTemplate: QPV,
                performanceTemplate: QAV
            };

            QRM = new QuotationRequestModel(request);

            QMV = new QuotationModalView(allData),
            QMVRendered = QMV.render();

            $("#quotationModal").find(".modal-content").html(QMVRendered);

            var quotationAutocompService = new GoogleAutocompleteService();
            var isAvailable = quotationAutocompService.getFormElements('.quotation-modal form[name="quotation_event_info"]');

            if(isAvailable)
                quotationAutocompService.initAutoComplete();

            $("#quotationModal").modal('show');
            // $('form[name="quotation_act_info"]')
            // $('form[name="quotation_event_info"]')
            // $('form[name="quotation_payment_info"]')
        });
    }

    /** ------------------------------------------------------- **/
    function quotationSend(e) {
        e.preventDefault();

        var requestId = QRM.model.id;
        var eventId   = QEM.model.id;
        var percent   = parseInt($(this).closest('form').find('select[name="quotation-payment-percent"]').find('option:selected').val());
        
        var data = {
            'request_quotation_send[event]': eventId,
            'request_quotation_send[request_quotation]': requestId,
            'request_quotation_send[balance_percent]': percent
        };

        /** TODO: returns: 
        * {
        *   message: "Sending error"
        *   status: "error"
        * }
        */
        sendQuotationConfirmation(data)
        .then(function(res) {
            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        });
    }
    function selectPerformanceSend(e) {
        e.preventDefault();

        var quotId  = QRM.model.id;
        var perfId  = $(this).closest('div[act-id]').attr('act-id');

        var data = {
            perf: perfId,
            quot: quotId,
        };
        
        selectQuotaionPerformance(data)
        .then(function(res) {
            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        })
    }
    function selectServiceSend(e) {
        e.preventDefault();

        var quotId  = QRM.model.id;
        var servId  = $(this).closest('div[act-id]').attr('act-id');

        var data = {
            serv: servId,
            quot: quotId,
        };
        
        selectQuotaionService(data)
        .then(function(res) {
            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        })
    }

    
    function selectPackageSend() {
        var packId = $(this).attr("package-id");
        console.log(packId)

        selectQuotaionPackage({
            id: packId
        })
        .then(function(res) {
            console.log(res)
        })
        .catch(function(err) {
            console.error(err)
        })
    }
    function selectOptionSend() {
        var optId = $(this).attr("option-id");
        console.log(optId)

        selectQuotaionOption({
            id: optId
        })
        .then(function(res) {
            console.log(res)
        })
        .catch(function(err) {
            console.error(err)
        })
    }
    

    $('.modal').on('show.bs.modal', function (event) { console.log(this.id); });
    $("body")
        .on("click", ".enquiries .quotationSendbtn", openQuotationModal)
        .on("click", ".quotation-modal button[quotation-send]", quotationSend)
        .on("click", ".quotation-modal input[select-performance]", selectPerformanceSend)
        .on("click", ".quotation-modal input[select-service]", selectServiceSend)
        .on("click", ".quotation-modal input[select-package]", selectPackageSend)
        .on("click", ".quotation-modal input[select-option]", selectOptionSend)
});

