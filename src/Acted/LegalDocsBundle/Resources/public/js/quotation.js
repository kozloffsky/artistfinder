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
    function getEventData(orderId) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: "/order/" + orderId,
                method: "GET",
                success: function(resp) {
                    resolve(resp);
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

    function editPriceSend(id, data) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/rate/'+ id +'/edit',
                method: 'PATCH',
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

    function selectPriceSend(id) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/price/rate/'+ id +'/select',
                method: 'PATCH',
                data: {},
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

    function updateOrderSend(id, data) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/order/'+ id,
                method: 'PUT',
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

    function setNotAvailable(id) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/order/'+ id,
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

    // TODO

    // function sendChatMessage(message) {
    //     name="message"

    // }

    /**
     *  TODO: maybe fix if needed
     */
    function selectPackageHandler(container) {
        "use strict";

        var packId = container.attr("package-id");

        selectQuotaionPackage({id: packId});
    }
    function selectPerformanceHandler(context) {
        "use strict";

        var performanceType = $(context).closest('div[act-type]').attr('act-type');
        var performanceId   = $(context).closest('div[act-id]').attr('act-id');
        var currentPerformance = [];

        if(performanceType == 'performance') {
            currentPerformance.push(selectQuotaionPerformance({
                perf: performanceId,
                quot: QRM.model.id
            })
            .then(console.log)
            .catch(console.error));
        }

        if(performanceType == 'service') {
            currentPerformance.push(selectQuotaionService({
                serv: performanceId,
                quot: QRM.model.id
            })
            .then(console.log)
            .catch(console.error));
        }

        Promise.all(currentPerformance);
    }

    function checkboxHandler(e) {
        var _context = e.currentTarget;
        var itemType = ['select-performance', 'select-package', 'select-option'];
        var p		 = ['act-id', 'package-id', 'option-id'];
        var currentType = null;

        var attrs = e.target.attributes;

        _.each(e.target.attributes, function(k, i) {
            var index = itemType.indexOf(attrs[i].name);

            if(index == 0 || index > 0) {
                currentType = itemType[index];
            }
        });

        if(currentType == 'select-option') {
            var option = $(_context);

            var actContainer = option.closest('['+p[0]+']');
            var packageContainer = option.closest('['+p[1]+']');

            var allPackages = actContainer.find('['+itemType[1]+']');

            var act     = actContainer.find('['+itemType[0]+']');
            var package = packageContainer.find('['+itemType[1]+']');
            var options = packageContainer.find('['+itemType[2]+']');

            var selectActMask    = 0x0;
            var selectOptionMask = 0x0;

            var optionId = option.attr("option-id");

            /*selectQuotaionOption({ id: optionId })
            .then(console.log)
            .catch(console.error);*/

            _.each(options, function(o, i) {
                if($(o).prop('checked')) {
                    selectOptionMask = selectOptionMask | 0x1;
                }
            });

            if(!package.prop('checked')) {
                package.prop('checked', true);
            }

            if(package.prop('checked') && !selectOptionMask) {
                package.prop('checked', false);
            }

            _.each(allPackages, function(o, i) {
                if($(o).prop('checked')) {
                    selectActMask = selectActMask | 0x1;
                }
            });

            if(!act.prop('checked') && selectActMask) {
                act.prop('checked', true);
            }

            if(act.prop('checked') && !selectActMask) {
                act.prop('checked', false);
            }
        }

        if(currentType == 'select-package') {
            var package = $(_context);
            var act 	= package.closest('['+p[0]+']').find('['+itemType[0]+']')

            var options = package.closest('div[package-id]').find('['+itemType[2]+']');

            var selectActMask = 0x0;

            if(package.prop('checked')) {
                _.each(options, function(o, i) {
                    $(o).prop('checked', true);
                });
            } else {
                _.each(options, function(o, i) {
                    $(o).prop('checked', false);
                });
            }

            var totalPackages = package.closest('['+p[0]+']').find('[' + itemType[1] + ']')

            _.each(totalPackages, function(o, i) {
                if($(o).prop('checked')) {
                    selectActMask = selectActMask | 0x1;
                }
            });


            //selectPackageHandler($(_context));

            if(!act.prop('checked') && selectActMask) {
                act.prop('checked', true);
            }

            if(act.prop('checked') && !selectActMask){
                act.prop('checked', false);
            }
        }

        if(currentType == 'select-performance') {
            var act = $(_context);
            var packages = act.closest('['+p[0]+']').find('['+itemType[1]+']');

            if(act.prop('checked')) {
                _.each(packages, function(o, i) {
                    $(o).prop('checked', true);

                    var options = $(o).closest('div['+p[1]+']').find('['+itemType[2]+']');

                    _.each(options, function(o, i) {
                        $(o).prop('checked', true);
                    });
                });
            } else {
                _.each(packages, function(o, i) {
                    $(o).prop('checked', false);

                    var options = $(o).closest('div['+p[1]+']').find('['+itemType[2]+']');

                    _.each(options, function(o, i) {
                        $(o).prop('checked', false);
                    });
                });
            }

            //selectPerformanceHandler(_context);
        }
    }

    ///
    /** ------------------------------------------------------- **/
    function setNotAvailableHandler() {
        var orderId = $(this).attr("order-id");
        setNotAvailable(orderId);
    }

    function openQuotationModal() {
        var orderId = $(this).attr("order-id");

        Promise.props({
            order: getEventData(orderId),
            user: userDataProvider.currentUser()
            //quot: prepareQuotationReply(orderId)
        }).then(function(result) {
            var orderStatuses = {
                newOrder: 0
            };

            var event = result.order.event;
            var clientUser  = result.order.client.user;
            var order  = result.order;
            var currentOrderStatus =  result.order.status;

            var performances = order.performances;

            var artistPerformances = order.artist.user.profile.performances;
            var artistServices = order.artist.user.profile.services;
            var services     = order.services;
            var payment      = {
                balancePercent: order.guaranteed_balance_term,
                depositPercent: order.guaranteed_deposit_term
        };

            var newPerformances = [];
            var newServices = [];
            var preSelectedPerformanceIds = [];

            for (performanceIndex in performances) {
                var currentPerformanceId = performances[performanceIndex]["data"]["performance"];
                var itemId = performances[performanceIndex]["id"];
                var currentPerformance = {
                    performance: {
                        itemId: itemId,
                        comment: performances[performanceIndex]["data"]["comment"],
                        packages: performances[performanceIndex]["data"]["packages"],
                        title : performances[performanceIndex]["data"]["title"],
                        type : performances[performanceIndex]["data"]["type"],
                        id : currentPerformanceId,
                        isOrder: true
                    }
                };

                preSelectedPerformanceIds.push(currentPerformanceId);
                newPerformances.push(currentPerformance);
            }

            if (orderStatuses.newOrder == currentOrderStatus) {
                for (artistPerformanceIndex in artistPerformances) {
                    if (preSelectedPerformanceIds.indexOf(artistPerformances[artistPerformanceIndex]["id"]) != -1) {
                        continue;
                    }

                    var currentPerformance = {
                        performance: artistPerformances[artistPerformanceIndex]
                    };

                    newPerformances.push(currentPerformance);
                }

                for (artistServiceIndex in artistServices) {
                    var currentService = {
                        service: artistServices[artistServiceIndex]
                    };

                    newServices.push(currentService);
                }
            } else {
                for (serviceIndex in services) {
                    var currentServiceId = services[serviceIndex]["data"]["service"];
                    var itemId = services[serviceIndex]["id"];
                    var currentService = {
                        service: {
                            itemId: itemId,
                            packages: services[serviceIndex]["data"]["packages"],
                            title : services[serviceIndex]["data"]["title"],
                            type : services[serviceIndex]["data"]["type"],
                            id : currentServiceId,
                            isOrder: true
                        }
                    };

                    newServices.push(currentService);
                }
            }

            var actObj = {
                perf: newPerformances,
                serv: newServices
            };

            var extraActObj = {
                perf: newPerformances
            };

            // Event template generation
            QEM = new QuotationEventModel(event),
            QEV = new QuotationEventView(QEM);
            QEV = QEV.render();

            // Performance template generation
            QAM = new QuotationActModel(actObj);
            QAV = new QuotationActView(QAM);
            QAV = QAV.render();

            /*TODO - need to uncomment*/
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
            var fromUser = clientUser.firstname.concat(" ", clientUser.lastname);

            var allData = {
                order: order,
                title: fromUser,
                eventTemplate: QEV,
                paymentTemplate: QPV,
                performanceTemplate: QAV,
                extraPerformanceTemplate: QEAV
            };

            QRM = new QuotationRequestModel(order);

            QMV = new QuotationModalView(allData);
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

        var orderId = QRM.model.id;
        var eventId   = QEM.model.id;
        var percent   = parseInt($(this).closest('form').find('select[name="quotation-payment-percent"]').find('option:selected').val());
        
      /*  var data = {
            'request_quotation_send[event]': eventId,
            'request_quotation_send[order]': orderId,
            'request_quotation_send[balance_percent]': percent
        };*/


        var form = $("#quotationModal").find('form[name="quotation_act_info"]');

        var basePerformances = form.find('[act-type="performance"][base-type="true"]');
        var services = form.find('[act-type="service"][base-type="true"]');
        var extraPerformances = form.find('#extra-act').find('[act-type="performance"]');

        newBasePerformances = prepareServicePerformance(basePerformances, 'performance');
        newServices = prepareServicePerformance(services, 'service');
        newExtraPerformances = prepareExtraPerformance(extraPerformances);

        var depositPercent = $("[edit-quotation-payment-percent]").find("option:selected").val();
        var balancePercent = 100 - depositPercent;

        var data = {
            performances: newBasePerformances,
            extraPerformances: newExtraPerformances,
            services: newServices,
            paymentDetails: {
                balancePercent: balancePercent,
                depositPercent: depositPercent
            }
        };

        updateOrderSend(orderId, data)
            .then(function(res) {
                $("#quotationModal").modal("hide");

                setTimeout(function() {
                    $("#success-quotation-modal").modal("show");
                }, 500);

                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            });

        //add order

        // console.log(newBasePerformances);
        // console.log(newServices);
        //console.log(newExtraPerformances);


        /*sendQuotationConfirmation(data)
        .then(function(res) {
            $("#quotationModal").modal("hide");

            setTimeout(function() {
                $("#success-quotation-modal").modal("show");
            }, 500);

            console.log(res);
        })
        .catch(function(err) {
            console.error(err);
        });*/
        $("button[quotation-send]").html('Quotation Sent');
        //console.log($("button[quotation-send]").val());
    }
    /** ------------------------------------------------------- **/
    function prepareExtraPerformance(objects) {
        var newExtraObjects = [];
        var standardPerformanceType = 1;

        _.each(objects, function (object, objectIndex) {
            var currentNewExtraObject = {};
            var currentObject = $(object).find('[select-extra-performance]');
            var itemId = $(object).attr('item-id');

            var isSelected = false;
            if (currentObject.prop('checked')) {
                isSelected = true;
            }

            var price       = $(object).find('[edit-extra-custom-price]').val();
            var type        = $(object).find("[quot-edit-performance-type]").find("option:selected").val();
            var comment     = $(object).find('[name="comment"]').val();
            var duration    = $(object).find("[quot-edit-duration]").val();
            var qty         = $(object).find("[quot-edit-qty]").find("option:selected").val();

            var option = {
                id: null,
                price: price
            };
            if (type == standardPerformanceType) {
                option["qty"] = qty;
                option["duration"] = duration;
            }

            currentObject = {
                id: null,
                title: 'extra performance',
                itemId: itemId,
                type: type,
                comment: comment,
                packages: [{
                    id: null,
                    title: 'extra package',
                    isSelected: isSelected,
                    options: [option]
                }]
            };

            newExtraObjects.push(currentObject);
        });

        return newExtraObjects;
    }
    /** ------------------------------------------------------- **/
    function prepareServicePerformance(objects, type) {
        var newBaseObjects = [];

        _.each(objects, function (object, objectIndex) {
            var currentNewBaseObject = {};
            var currentObject = $(object).find('[select-performance]');
            var actId = $(object).attr('act-id');
            var itemId = $(object).attr('item-id');
            var actTitle = $(object).find('.act-title').find('i.act-name').text();
            var basePerformanceType = 0;

            if (!currentObject.prop('checked')) {
                return;
            }

            if (type == 'service') {
                var price = $(object).find('[edit-extra-custom-price]').val();
                var packageId = $(object).find('[package-block]').attr('package-id');
                var optionId = $(object).find('[option-block]').attr('option-id');
                var packageName = $(object).find('.row.package').find('label').text();

                currentObject = {
                    id: actId,
                    itemId: itemId,
                    title: actTitle,
                    packages: [{
                        id: packageId,
                        title: packageName,
                        options: [{
                            id: optionId,
                            price: price
                        }]
                    }]
                };

                newBaseObjects.push(currentObject);
                return;
            }

            var newPackages = [];
            var packages = $(object).find("[package-block]");
            _.each(packages, function (package, packageIndex) {
                var currentPackage = {};
                var packageId = $(package).attr('package-id');
                var packageInput = $(package).find('[select-package]');
                var packageName = $(package).find('.row.package').find('label').text();

                if (!$(packageInput).prop('checked')) {
                    return;
                }

                var newOptions = [];
                var options = $(package).find("[option-block]");
                _.each(options, function (option, optionIndex) {
                    var currentOption = {};
                    var optionId = $(option).attr('option-id');
                    var optionInput = $(option).find('[select-option]');
                    if (!$(optionInput).prop('checked')) {
                        return;
                    }

                    var qty = $(option).find('[name="qty"]').val();
                    var duration = $(option).find('[name="duration"]').val();
                    var price = $(option).find('[quot-edit-price]').find('option:selected').val();


                    currentOption = {
                        id: optionId,
                        price: price,
                        qty: qty,
                        duration: duration
                    };

                    newOptions.push(currentOption);
                });

                currentPackage["id"] = packageId;
                currentPackage["title"] = packageName;
                currentPackage["options"] = newOptions;
                newPackages.push(currentPackage);
            });

            currentNewBaseObject["id"] = actId;
            currentNewBaseObject["title"] = actTitle;
            currentNewBaseObject["type"] = basePerformanceType;
            currentNewBaseObject["itemId"] = itemId;
            currentNewBaseObject["packages"] = newPackages;
            newBaseObjects.push(currentNewBaseObject);
        });

        return newBaseObjects;
    }
    /** ------------------------------------------------------- **/
    function selectExtraPerformanceSend() {
        /*var quotId  = QRM.model.id;
        var perfId  = $(this).closest('div[act-id]').attr('item-id');*/
        var mainSelector = $(this).closest("div[act-id]");

        console.log($(this));
        var selected = $(this).prop('checked');

        if(selected) {
            mainSelector.find('[extra-performance-comment]').show();
        } else {
            mainSelector.find('[extra-performance-comment]').hide();
        }

        /*    var data = {
                perf: perfId,
                quot: quotId
            };

        selectQuotaionPerformance(data)
            .then(function(res) {
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })*/

    }

    function selectPerformanceSend(event) {
        checkboxHandler(event);
    };

    function selectPackageSend(event) {
        checkboxHandler(event)
    }
    function selectOptionSend(event) {
        checkboxHandler(event);
    }

    /** --- CREATING FUNCTIONAL --- **/
    function createExtraPerformance(e) {
        e.preventDefault();

        var button = $(this);

        var newPerf = document.getElementById("quot-new-performance").innerHTML;
        var status = $(this).attr('status');

        var performance = {
            performance: {
                title: 'Act title',
                type: 1,
                packages: [{
                    title: 'Package',
                    options: [{
                        qty: 1,
                        duration: 1,
                        rates: [{
                            price: {
                                amount: 0
                            }
                        }]
                    }]
                }]
            }
        };

        if(status == 'adding') {
            var html = _.template(newPerf)({
                data: performance
            });

            var extraActs = $("#extra-act").find("[act-type]");

            if(extraActs.length) {
                extraActs.last().after(html);
            } else {
                $("#extra-act").html(html);
            }

            extraActs = $("#extra-act").find("[act-type]");
            var index = extraActs.length;
            var extraActInput = extraActs.last().find("input[select-extra-performance]");
            var extraActLabel = extraActs.last().find(".custom-checkbox label");
            $(extraActInput).attr('id', 'package_' + index);
            $(extraActLabel).attr('for', 'package_' + index);
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
    function editPaymentPercent() {
        var depositPercent = $(this).find("option:selected").val();
        var balancePercent = 100 - depositPercent;
        $(".payment-balance-amount").html(balancePercent + '%');
    }
    function editPerformanceComment() {

        /*var mainSelector = $(this).closest("div[act-id]");
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
            })*/
    }
    function editPerformanceType() {
        var standardPerformanceType = 1;
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

        if (type == standardPerformanceType) {

            mainSelector.find("[quot-edit-option]").show();

            var duration = mainSelector.find("[quot-edit-duration]").val();
            var qty      = mainSelector.find("[quot-edit-qty]").find("option:selected").val();
            var optionId = $(this).closest("div[option-id]").attr("option-id");

            /*var option = {
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
                });*/

        } else {
            mainSelector.find("[quot-edit-option]").hide();
        }


       /* updatePerformanceSend(performance)
            .then(function(res) {
                console.log(res);
            })
            .catch(function(err) {
                console.error(err);
            })*/
    }
    function editOption() {

        var mainSelector = $(this).closest("div[option-id]");

        var duration = mainSelector.find("[quot-edit-duration]").val();
        var qty      = mainSelector.find("[quot-edit-qty]").find("option:selected").val();
        var id       = mainSelector.attr("option-id");

      /*  var option = {
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
            })*/
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
        var selectedOption = $(this).find('option:selected');
        var selectedPriceId = selectedOption.attr('price-id');

        var customPriceId = $(this).find('[custom-price]').attr('price-id');
        var isRemovedPrice = false;

        var optionId = $(this).closest('[option-id]').attr('option-id');
        var priceAmount = $(this).val();

        if (selectedOption.attr('price-removed')) {
            isRemovedPrice = true;
        }


        if(value == 'custom') {

            $(this).hide();
            var inputCustomPrice = $(this).find("[edit-custom-price]");
            if (typeof(inputCustomPrice) != 'undefined') {
                $(this).after('<input edit-custom-price type="text" class="price-box" onkeypress="return isNumberKey(event);">');
            } else {
                inputCustomPrice.show();
            }

            return;
        } else {
            if (isRemovedPrice) {
                $(this).find('[custom-price]').hide();
                selectedOption.removeAttr('price-removed');
                selectedOption.attr('price-id', res.rate.id);

               /* var data = {
                    price_rate_create: {
                        option: optionId,
                        price: priceAmount
                    }
                };

                $(this).find('[custom-price]').hide();
                selectedOption.removeAttr('price-removed');

                createPriceSend(data)
                    .then(function(res) {
                        selectedOption.attr('price-id', res.rate.id);

                        return removePriceSend(customPriceId)
                            .then(function(res){

                            }).catch(function(err) {
                                $(this).find('[custom-price]').show();
                                selectedOption.attr('price-removed', true);
                                console.error(err)
                            });
                    })
                    .catch(function(err) {
                        $(this).find('[custom-price]').show();
                        selectedOption.attr('price-removed', true);
                        console.error(err);
                    });*/
            } else {
                /*selectPriceSend(selectedPriceId)
                    .then(function(res){

                        console.log(res)
                    })
                    .catch(function(err) {
                        console.error(err)
                    });*/
            }
        }
    }

    function editCustomPrice() {

        var _this = $(this);
        var priceAmount = _this.val();

        if (priceAmount == '') {
            return;
        }

        _this.hide();
        _this.closest('[option-id]').find('[quot-edit-price]').show();

        var options = _this.closest('[option-id]').find('[quot-edit-price]').find('option');
        var isShowedCustomPrice = false;
        var optionId = _this.closest('[option-id]').attr('option-id');

        var removedPromise = new Array(0);

        $.each(options, function(index, value) {
            var customPrice = $(value).attr("custom-price");

            var priceId = $(value).attr("price-id");

            if (typeof(customPrice) != 'undefined') {
                $(value).remove();
                isShowedCustomPrice = true;
            }

            if($(value).attr('value') != 'custom') {
                $(value).attr('price-removed', true);
                $(value).removeAttr('selected');
                //removedPromise.push(removePriceSend(priceId));
            }
        });

        var rateId = '';
        var options = _this.closest('[option-id]').find('[quot-edit-price]').find('option');
        options.find("[custom-price]").remove();
        options.first().before('<option custom-price price-id="' + rateId + '" selected value="' + priceAmount + '">' + priceAmount + '</option>');


        /*Promise.all(removedPromise)
        .then(function() {

            var data = {
                price_rate_create: {
                    option: optionId,
                    price: priceAmount
                }
            };

            return createPriceSend(data);

        }).then(function (resp) {
                var rateId = resp.rate.id;
                var options = _this.closest('[option-id]').find('[quot-edit-price]').find('option');
                options.find("[custom-price]").remove();
                options.first().before('<option custom-price price-id="' + rateId + '" selected value="' + priceAmount + '">' + priceAmount + '</option>');
        }).catch(function (err) {
                console.log(err);
        });*/
    }

    function editExtraCustomPrice() {
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

        var rateId = $(this).attr("rate-id");
        var amount = $(this).val();

        var data = {
            'price_rate_edit[price]': amount
        };

       /* editPriceSend(rateId, data)
            .then(function(res){

                console.log(res)
            })
            .catch(function(err) {
                console.error(err)
            })*/
    }
    /** --- REMOVING FUNCTIONAL --- **/
    function removePackage(e) {
        var packageContainer = $(this).closest("div[package-id]");
        var packageId = $(this).attr("remove-package");

        /*removePackageSend({
            id: packageId
        })
        .then(function(res) {
            packageContainer.remove();
            console.log(res)
        })
        .catch(function(err) {
            console.error(err)
        })*/
    }
    function removeAct(e) {
        var actContainer = $(this).closest('div[act-id]');
        var actId = actContainer.attr('act-id');
        var actType = $(this).closest('div[act-type]').attr('act-type');

        var act = {
            id: actId,
            type: actType
        };

       /* removeActSend(act)
        .then(function(res) {
            actContainer.remove();
            console.log(res)
        })
        .catch(function(err) {
            console.error(err)
        })*/
    }

    $('.modal').on('show.bs.modal', function (event) { console.log(this.id); });

    function quotation_comment_area(e) {
        e.preventDefault();
        $('#quotation_comment_area').toggle();
    }

    $("body")
        .on("click",    ".enquiries .quotationSendbtn", openQuotationModal)
        .on("click",    ".enquiries .rejectRequest", setNotAvailableHandler)
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
        .on("change",    ".quotation-modal [quot-edit-performance-type]", editPerformanceType)
        .on("click",    ".quotation-modal #quotation_comment_toggle", quotation_comment_area)
        .on("change",   ".quotation-modal [quot-edit-price]", editPrice)
        .on("focusout", ".quotation-modal [quot-edit-title]", editActTitle)
        .on("focusout", ".quotation-modal [quot-edit-package-name]", editPackageName)
        .on("focusout", ".quotation-modal [edit-custom-price]", editCustomPrice)
        .on("focusout", ".quotation-modal [edit-extra-custom-price]", editExtraCustomPrice)
        .on("focusout", ".quotation-modal [edit-performance-comment]", editPerformanceComment)
        .on("change", ".quotation-modal [edit-quotation-payment-percent]", editPaymentPercent);

