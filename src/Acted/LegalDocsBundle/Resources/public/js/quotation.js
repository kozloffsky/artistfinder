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

    function removePackageSend(package) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/package/'+package.id+'/remove',
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

    // Send a performance create request
    function createPerformanceSend(performance) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/performance/create',
                method: 'POST',
                data: performance,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function createServiceSend(service) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/service/create',
                method: 'POST',
                data: service,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function createSetSend(setOption) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/option/create',
                method: 'POST',
                data: setOption,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function createPackageSend(package) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/' + package.type + '/package/create',
                method: 'POST',
                data: package.data,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function updateOptionSend(option) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/option/' + option.id + '/edit',
                method: 'PATCH',
                data: option.data,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function updateOptionSend(option) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/option/' + option.id + '/edit',
                method: 'PATCH',
                data: option.data,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    //performance[title]
    function updatePerformanceSend(performance) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/performance/' + performance.id + '/edit',
                method: 'PATCH',
                data: performance.data,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
    //service[title]
    function updateServiceSend(service) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/service/' + service.id + '/edit',
                method: 'PATCH',
                data: service.data,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
    //price_package[name]
    function updatePackageSend(package) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/package/' + package.id + '/edit',
                method: 'PATCH',
                data: package.data,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    ///
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

    /** --- CREATING FUNCTIONAL --- **/
    function createPerformance(e) {
        e.preventDefault();

        var button = $(this);
        var dataContainer = $(this).closest('form[name="quotation_act_info"]').find("div[new-act-section]");
            dataContainer.html('');

        var newPerf = document.getElementById("quot-new-performance").innerHTML;
  
        var performance = {
            performance_price: {
                title: 'Act title',
                package_name: 'Package',
                artist: null,
                options: [
                    {
                        qty: 1,
                        duration: 45,
                        price1: 3000,
                        price_on_request: false
                    }
                ],
                request_quotation: null,
                is_quotation: true
            }
        };

        userDataProvider.currentUser()
        .then(function(res) {
            return res.user.artistId;
        })
        .then(function(artistId) {
            performance.performance_price.artist = artistId;
            performance.performance_price.request_quotation = QRM.model.id;

            return createPerformanceSend(performance);
        })        
        .then(function(res) {
            var html = _.template(newPerf)({
                data: res
            });

            dataContainer.html(html);

            //TODO: FIX!
            button.attr("disabled", "disabled");
        })
        .catch(function(err) {
            console.error(err)
        })
    }
    function createService(e) {
        e.preventDefault();

        var button = $(this);
        var dataContainer = $(this).closest('form[name="quotation_act_info"]').find("div[new-act-section]");
            dataContainer.html('');

        var newPerf = document.getElementById("quot-new-performance").innerHTML;
  
        var service = {
            service_price: {
                title: 'Act title',
                package_name: 'Package',
                artist: null,
                price: 3000,
                price_on_request: false,
                request_quotation: null,
                is_quotation: true
            }
        };

        userDataProvider.currentUser()
        .then(function(res) {
            return res.user.artistId;
        })
        .then(function(artistId) {
            service.service_price.artist = artistId;
            service.service_price.request_quotation = QRM.model.id;

            return createServiceSend(service);
        })        
        .then(function(res) {
            var html = _.template(newPerf)({
                data: res
            });

            dataContainer.html(html);

            //TODO: FIX!
            button.attr("disabled", "disabled");
        })
        .catch(function(err) {
            console.error(err)
        })
    }
    function createSet(e) {
        e.preventDefault();

        var packageId = $(this).closest('div[package-id]').attr('package-id');
        var lastSet   = $(this).closest('div[package-id]').find('div[option-id]').last();

        var option = {
            'price_option_create[qty]': 1,
            'price_option_create[package]': packageId,
            'price_option_create[duration]': 45,
            'price_option_create[price_on_request]': false
        };

        createSetSend(option)
        .then(function(res) {
            var data = {
                option: {
                    id: res.id
                }
            };

            var template = document.getElementById('quot-set-template').innerHTML;

            var html = _.template(template)(data);

            lastSet.after(html)

        })
        .catch(function(err) {
            console.error(err);
        })
    }
    function createPackage(e) {
        e.preventDefault();

        var actType = $(this).closest('div[act-type]').attr('act-type');
        var actId   = $(this).closest('div[act-id]').attr('act-id');

        var service = {
            type: 'service',
            data: {
                service_price_package: {
                    price: 3000,
                    artist: null,
                    service: null,
                    package_name: 'Package',
                    price_on_request: false
                }
            }
        };

        var performance = {
            type: 'performance',
            data: {
                performance_price_package: {
                    package_name: 'Package',
                    performance: null,
                    artist: null,
                    options: [
                        {
                            qty: 1,
                            duration: 45,
                            price1: 3000,
                            price_on_request: false
                        }
                    ]
                }
            }
        }
        
        var obj = {
            'service':     service,
            'performance': performance
        };

        userDataProvider.currentUser()
        .then(function(res) {
            return res.user.artistId;
        })
        .then(function(artistId) {
            var sendData = obj[actType];

            if(actType == 'service') {
                sendData.data.service_price_package.artist = artistId;
                sendData.data.service_price_package.service = actId;
            } else {
                sendData.data.performance_price_package.artist = artistId;
                sendData.data.performance_price_package.performance = actId;
            }
            
            return createPackageSend(sendData)
        })
        .then(function(res) {
            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        })
    }

    /** --- EDITING FUNCTIONAL --- **/
    function editOption(e) {
        e.preventDefault();
        
        var mainSelector = $(this).closest("div[option-id]");

        var duration = mainSelector.find("[quot-edit-duration]").find("option:selected").val();
        var qty      = mainSelector.find("[quot-edit-qty]").find("option:selected").val();
        var id       = mainSelector.attr("option-id");

        var option = {
            id: id,
            data: {
                'price_option_edit[qty]': qty,
                'price_option_edit[duration]': duration,
                'price_option_edit[price_on_request]': false
            }
            
        };

        updateOptionSend(option)
        .then(function(res) {
            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        })
    }
    function editActTitle(e) {
        var id    = $(this).closest("div[act-id]").attr("act-id");
        var title = $(this).val();
        var type  = $(this).attr('act-type');

        var performance = {
            id: id,
            data: {}
        };

        if(type == 'performance') {
            performance.data = { 'performance[title]': title };

            updatePerformanceSend(performance)
            .then(function(res) {
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })
        } else {
            performance.data = { 'service[title]': title };

            updateServiceSend(performance)
            .then(function(res) {
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })
        }
    }
    function editPackageName(e) {
        e.preventDefault();

        var id    = $(this).closest("div[act-id]").attr("act-id");
        var name = $(this).val();

        var package = {
            id: id,
            data: {
                'price_package[name]': name
            }
        }

        updatePackageSend(package)
        .then(function(res) {
            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        })
    }

    /** --- REMOVING FUNCTIONAL --- **/
    function removePackage(e) {
        e.preventDefault();

        var packageId = $(this).attr("remove-package");

        removePackageSend({
            id: packageId
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
        .on("click",    ".enquiries .quotationSendbtn", openQuotationModal)
        .on("click",    ".quotation-modal button[quotation-send]", quotationSend)
        .on("click",    ".quotation-modal input[select-performance]", selectPerformanceSend)
        .on("click",    ".quotation-modal input[select-service]", selectServiceSend)
        .on("click",    ".quotation-modal input[select-package]", selectPackageSend)
        .on("click",    ".quotation-modal input[select-option]", selectOptionSend)
        .on("click",    ".quotation-modal button[create-performance]", createPerformance)
        .on("click",    ".quotation-modal button[create-service]", createService)
        .on("click",    ".quotation-modal [remove-package]", removePackage)
        .on("click",    ".quotation-modal [quot-create-package]", createPackage)
        .on("click",    ".quotation-modal [create-set]", createSet)
        .on("click",    ".quotation-modal [quot-edit-qty]", editOption)
        .on("click",    ".quotation-modal [quot-edit-duration]", editOption)
        .on("focusout", ".quotation-modal [quot-edit-title]", editActTitle)
        .on("focusout", ".quotation-modal [quot-edit-package-name]", editPackageName)

});

