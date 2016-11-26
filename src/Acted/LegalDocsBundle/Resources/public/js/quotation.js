$(function() {

    var inheritFrom = function (child, parent) {
        child.prototype = Object.create(parent.prototype);
    };

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
     * 'QEAM'
     * Quotation extra performance model for store data about extra performance
     */
    function QuotationExtraActModel(model) {
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
    inheritFrom(QuotationExtraActModel,  QuotationModel);
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
            extraPerformance: model.extraPerformanceTemplate
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
                data: QuotationPerformanceModel,
                isExtra: false
            };
            return _.template(this.template)(data);
        }
    }

    // Extra performance section view
    function QuotationExtraActView(QuotationExtraPerformanceModel) {
        this.template = document.getElementById('quot-extra-performance-tmp').innerHTML;
        this.render = function() {
            var data = {
                data: QuotationExtraPerformanceModel,
                isExtra: true
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

    var newAct = {};

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

    function removeActSend(act) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/'+ act.type +'/'+ act.id +'/remove',
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

    // Send a extra performance create request
    function createExtraPerformanceSend(performance) {
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

    function removePriceSend(id) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/rate/'+ id +'/remove',
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
    function createPriceSend(price) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/performance/rate/create',
                method: 'POST',
                data: price,
                success: function(resp) {
                    resolve(resp);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    // TODO

    // function sendChatMessage(message) {
    //     name="message"

    // }

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

            var extraActObj = {
                perf: performances
            };

            // Event template generation
            QEM = new QuotationEventModel(event),
            QEV = new QuotationEventView(QEM);
            QEV = QEV.render();

            // Performance template generation
            QAM = new QuotationActModel(actObj);
            QAV = new QuotationActView(QAM);
            QAV = QAV.render();

            // Extra performance template generation
            QEAM = new QuotationExtraActModel(extraActObj);
            QEAV = new QuotationExtraActView(QEAM);
            QEAV = QEAV.render();

            // Performance template generation
            QPM = new QuotationPaymentModel(payment);
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
                performanceTemplate: QAV,
                extraPerformanceTemplate: QEAV
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

        sendQuotationConfirmation(data)
        .then(function(res) {
            $("#quotationModal").modal("hide");

            setTimeout(function() {
                $("#success-quotation-modal").modal("show");
                //TODO: Better reload data not page
                $("#success-quotation-modal").on('hidden.bs.modal',function(){
                    window.location.reload();
                })

            }, 500);

            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        });
        $("button[quotation-send]").html('Quotation Sent');
        console.log($("button[quotation-send]").val());
    }

    function selectExtraPerformanceSend() {
        var quotId  = QRM.model.id;
        var perfId  = $(this).closest('div[act-id]').attr('act-id');
        var mainSelector = $(this).closest("div[act-id]");

        var selected = $(this).prop('checked');

        if(selected) {
            mainSelector.find('[extra-performance-comment]').show();
        } else {
            mainSelector.find('[extra-performance-comment]').hide();
        }

            var data = {
                perf: perfId,
                quot: quotId
            };

        selectQuotaionPerformance(data)
            .then(function(res) {
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })

    }

    function selectPerformanceSend() {
        var quotId  = QRM.model.id;
        var perfId  = $(this).closest('div[act-id]').attr('act-id');
        var perfType  = $(this).closest('div[act-type]').attr('act-type');
        var allCheckboxes = $(this).closest('div[act-id]').find('input[name="package-check"]');

        var selected = $(this).prop('checked');

        if(perfType == 'performance') {

            var data = {
                perf: perfId,
                quot: quotId
            };

            selectQuotaionPerformance(data)
            .then(function(res) {
                if(selected) {
                     $.each(allCheckboxes, function() {
                        if(!$(this).prop('checked')) {
                            $(this).trigger('click');
                        }
                    })
                } else {
                   $.each(allCheckboxes, function() {
                        $(this).removeAttr('checked');
                    })
                }
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })

        } 

        if(perfType == 'service') {

            var data = {
                serv: perfId,
                quot: quotId,
            };

            selectQuotaionService(data)
            .then(function(res) {
                if(selected) {
                     $.each(allCheckboxes, function() {
                        if(!$(this).prop('checked')) {
                            $(this).trigger('click');
                        }
                    })
                } else {
                   $.each(allCheckboxes, function() {
                        $(this).removeAttr('checked');
                    })
                }
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })
        }
        
    }

    function selectPackageSend() {
        var packId = $(this).attr("package-id");
        var options = $(this).closest('div[package-id]').find('option-id');

        var selected = $(this).is(':checked');

        selectQuotaionPackage({
            id: packId
        })
        .then(function(res) {
            if(selected) {
                $.each(options, function() { $(this).removeAttr('checked'); })
                $(this).removeAttr('checked');
            } else {
                $.each(options, function() { $(this).attr('checked', 'checked'); })
                $(this).attr('checked', 'checked');
            }
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
    function createExtraPerformance(e) {
        e.preventDefault();

        var button = $(this);

        var newPerf = document.getElementById("quot-new-performance").innerHTML;
        var status = $(this).attr('status');


        var performance = {
            performance_price: {
                title: 'Act title',
                package_name: 'Package',
                artist: null,
                type: 1,
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

        if(status == 'adding') {

            userDataProvider.currentUser()
            .then(function(res) {
                return res.user.artistId;
            })
            .then(function(artistId) {
                performance.performance_price.artist = artistId;
                performance.performance_price.request_quotation = QRM.model.id;

                return createExtraPerformanceSend(performance);
            })        
            .then(function(res) {

                newAct = res;

                var html = _.template(newPerf)({
                    data: res
                });
                
                var lastExtraAct = $("#extra-act").find("[act-type]").last();
                lastExtraAct.after(html);

                button.attr("status", "editing");
            })
            .catch(function(err) {
                console.error(err)
            })
        }

        if(status == 'editing') {
            var newActTemplate = document.getElementById('quot-performance-tmp').innerHTML;

            var data = {
                data: {
                    model: {
                        perf: [newAct.performance]
                    }
                }
            };

            var html = _.template(newActTemplate)(data);


            button.attr("status", "adding");
        }
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
        var packageContainer = $(this).closest('div[act-id]').find('div[package-id]').last();

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
        };
        
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
            var packageTemplate = document.getElementById('quot-package-template').innerHTML;
            var data = {
                package: res.package
            }

            var html = _.template(packageTemplate)(data);

            packageContainer.after(html);
        })
        .catch(function(err) {
            console.error(err);
        })
    }

    /** --- EDITING FUNCTIONAL --- **/
    function editPerformanceComment() {

        var mainSelector = $(this).closest("div[act-id]");
        var performanceId = $(this).closest("div[act-id]").attr("act-id");
        var comment = mainSelector.find('[name="comment"]').val();

        var performance = {
            id: performanceId,
            data: {
                'performance[comment]': comment
            }
        };

        updatePerformanceSend(performance)
            .then(function(res) {
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })
    }

    function editPerformanceType() {
        var mainSelector = $(this).closest("div[act-id]");
        var performanceId = $(this).closest("div[act-id]").attr("act-id");
        var type = mainSelector.find("[quot-edit-performance-type]").find("option:selected").val();
        var comment = mainSelector.find('[name="comment"]').val();

        var performance = {
            id: performanceId,
            data: {
                'performance[type]': type
            }
        };

        if (type == 1) {

            mainSelector.find("[quot-edit-option]").show();

            var duration = mainSelector.find("[quot-edit-duration]").find("option:selected").val();
            var qty      = mainSelector.find("[quot-edit-qty]").find("option:selected").val();
            var optionId = $(this).closest("div[option-id]").attr("option-id");

            var option = {
                id: optionId,
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
                });

        } else {
            mainSelector.find("[quot-edit-option]").hide();
        }


        updatePerformanceSend(performance)
            .then(function(res) {
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })
    }

    function editOption() {

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
        var id    = $(this).closest("div[act-id]").attr("act-id");
        var name = $(this).val();

        var package = {
            id: id,
            data: {
                'price_package[name]': name
            }
        };

        updatePackageSend(package)
        .then(function(res) {
            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        })
    }

    function editPrice(e) {
        var value = $(this).find('option:selected').val();
        var options = $(this).find('option[price-id]');

        if(value == 'custom') {
            $(this).hide();
            $(this).after('<input edit-custom-price type="text" class="custom-price" onkeypress="return isNumberKey(event);">');

            var optionsToDelete = [];

            $.each(options, function() {
                var price = $(this);
                var priceId = $(this).attr('price-id');

                optionsToDelete.push(removePriceSend(priceId));
            });

            Promise.all(optionsToDelete)
            .then(function() {
                options.remove();
            });

            return;
        }

    }

    function editCustomPrice() {
        var priceValue = $(this).val();
        var select = $(this).prev('select');
        var optionId = $(this).closest('div[option-id]').attr('option-id');
        var tempInput = $(this);

        var price = {
            price_rate_create: {
                option: optionId,
                price: priceValue
            }
        };

        createPriceSend(price)
        .then(function(res) {
            select.find('option').before('<option selected price-id="'+res.price.id+'">'+priceValue+'</option>');

            select.show();
            tempInput.remove();

            console.log(res)
        })
        .catch(function(err) {
            console.error(err)
        })
    }

    /** --- REMOVING FUNCTIONAL --- **/
    function removePackage(e) {
        var packageContainer = $(this).closest("div[package-id]");
        var packageId = $(this).attr("remove-package");

        removePackageSend({
            id: packageId
        })
        .then(function(res) {
            packageContainer.remove();
            console.log(res)
        })
        .catch(function(err) {
            console.error(err)
        })
    }
    function removeAct(e) {
        var actContainer = $(this).closest('div[act-id]');
        var actId = actContainer.attr('act-id');
        var actType = $(this).closest('div[act-type]').attr('act-type');

        var act = {
            id: actId,
            type: actType
        };

        removeActSend(act)
        .then(function(res) {
            actContainer.remove();
            console.log(res)
        })
        .catch(function(err) {
            console.error(err)
        })
    }

    $('.modal').on('show.bs.modal', function (event) { console.log(this.id); });

    function quotation_comment_area(e) {
        e.preventDefault();
        $('#quotation_comment_area').toggle();
    }
    
    $("body")
        .on("click",    ".enquiries .quotationSendbtn", openQuotationModal)
        .on("click",    ".quotation-modal button[quotation-send]", quotationSend)
        .on("click",    ".quotation-modal input[select-performance]", selectPerformanceSend)
        .on("click",    ".quotation-modal input[select-extra-performance]", selectExtraPerformanceSend)
        .on("click",    ".quotation-modal input[select-package]", selectPackageSend)
        .on("click",    ".quotation-modal input[select-option]", selectOptionSend)
        .on("click",    ".quotation-modal button[create-extra-performance]", createExtraPerformance)
        .on("click",    ".quotation-modal [remove-package]", removePackage)
        .on("click",    ".quotation-modal [act-delete]", removeAct)
        .on("click",    ".quotation-modal [quot-create-package]", createPackage)
        .on("click",    ".quotation-modal [create-set]", createSet)
        .on("click",    ".quotation-modal [quot-edit-qty]", editOption)
        .on("click",    ".quotation-modal [quot-edit-duration]", editOption)
        .on("click",    ".quotation-modal [quot-edit-performance-type]", editPerformanceType)
        .on("click",    ".quotation-modal #quotation_comment_toggle", quotation_comment_area)
        .on("change",   ".quotation-modal [quot-edit-price]", editPrice)
        .on("focusout", ".quotation-modal [quot-edit-title]", editActTitle)
        .on("focusout", ".quotation-modal [quot-edit-package-name]", editPackageName)
        .on("focusout", ".quotation-modal [edit-custom-price]", editCustomPrice)
        .on("focusout", ".quotation-modal [edit-performance-comment]", editPerformanceComment)
});

