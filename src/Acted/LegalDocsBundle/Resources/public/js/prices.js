;function isNumberKey(evt) {

    var value = evt.srcElement.value;
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if(charCode == 46)
        return true;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    if(value > 100) {
        evt.srcElement.value = 100;
        return false;
    }

    return true;
}

;(function() {
    var artist;

    try {
        artist = JSON.parse(localStorage.getItem("user")).artistId;
    } catch (e) {
        artist = 0;
    }

    function pricesApi() {
        var options = {
            url: "",
            data: "",
            method: ""
        };

        /**
         * Endpoints for interacting with prices api.
         */
        this.endpoints = {
            performance: {
                /**
                 * @params: artist id
                 */
                getAll: function () {
                    options = {
                        url: "/price/performance/" + artist + "/list",
                        method: "GET"
                    };
                },
                /**
                 * @params: performance id
                 */
                get: function (id) {
                    options = {
                        url: "/price/performance/list/" + id,
                        method: "GET"
                    };
                },
                /**
                 * @params:
                 * performance_price[title]
                 * performance_price[package_name]
                 * performance_price[artist]
                 * performance_price[options][0][qty]
                 * performance_price[options][0][duration]
                 * performance_price[options][0][price1]
                 */
                post: function (data) {
                    options = {
                        url: "/price/performance/create",
                        method: "POST",
                        data: data
                    };
                },
                /**
                 * @params: performance id
                 */
                put: function (id, data) {
                    options = {
                        url: "/price/performance/" + id + "/edit",
                        method: "PUT",
                        data: data
                    };
                },
                /**
                 * @params: performance id
                 */
                patch: function (id, data) {
                    options = {
                        url: "/price/performance/" + id + "/edit",
                        method: "PATCH",
                        data: data
                    };
                },
                /**
                 * @params: performance id
                 */
                delete: function(id) {
                    options = {
                        url: "/price/performance/" + id + "/remove",
                        method: "PATCH"
                    };
                },
                package: {
                    /**
                     * performance_price_package[package_name]
                     * performance_price_package[artist]
                     * performance_price_package[options][0][qty]
                     * performance_price_package[options][0][duration]
                     * performance_price_package[options][0][price1]
                     * performance_price_package[performance]
                     * @params:
                     */
                    post: function(data) {
                        options = {
                            url: "/price/performance/package/create",
                            method: "POST",
                            data: data
                        };
                    }
                }
            },
            service: {
                /**
                 * @params: artist id
                 */
                getAll: function () {
                    options = {
                        url: "/price/service/"+artist+"/list",
                        method: "GET"
                    };
                },
                /**
                 * @params: id
                 */
                get: function(id) {
                    options = {
                        url: "/price/service/list/"+id,
                        method: "GET"
                    };
                },
                post: {
                    /**
                     * @params:
                     * service_price[title]
                     * service_price[package_name]
                     * service_price[artist]
                     * service_price[price]
                     * service_price[duration]
                     * service_price[qty]
                     */
                    price: function(data) {
                        options = {
                            url: "/price/service/create",
                            method: "POST",
                            data: data
                        };
                    }
                },
                /**
                 * @params: service id
                 * service[title]
                 */
                patch: function(id, data) {
                    options = {
                        url: "/price/service/"+id+"/edit",
                        method: "PATCH",
                        data: data
                    };
                },
                /**
                 * @params: service id
                 */
                delete: function(id) {
                    options = {
                        url: "/price/service/"+id+"/remove",
                        method: "PATCH"
                    };
                },
                package: {
                    /**
                     * @params: none
                     */
                    post: function(data) {
                        options = {
                            url: "/price/service/package/create",
                            method: "POST",
                            data: data
                        };
                    }
                }
            },
            package: {
                /**
                 * @params: package id
                 * price_package[name]
                 */
                patch: function(id, data) {
                    options = {
                        url: "/price/package/"+id+"/edit",
                        method: "PATCH",
                        data: data
                    };
                },
                /**
                 * @params: package id
                 */
                delete: function(id) {
                    options = {
                        url: "/price/package/"+id+"/remove",
                        method: "PATCH"
                    };
                }
            },
            rate: {
                /**
                 * price_rate_create[option]
                 * price_rate_create[price]
                 * @params: none
                 */
                post: function(url, data) {
                    options = {
                        url: "/price/"+url+"/rate/create",
                        method: "POST",
                        data: data
                    };
                },
                /**
                 * price_rate_edit[price]
                 * @params: none
                 */
                patch: function(id, data) {
                    options = {
                        url: "/price/rate/"+id+"/edit",
                        method: "PATCH",
                        data: data
                    };
                },
                /**
                 * @params: rate id
                 */
                delete: function(id) {
                    options = {
                        url: "/price/rate/"+id+"/remove",
                        method: "PATCH"
                    };

                }
            },
            price: {
                /**
                 *
                 * price_option_create[duration]
                 * price_option_create[qty]
                 * price_option_create[package]
                 * @params: none
                 */
                post: function(data) {
                    options = {
                        url: "/price/option/create",
                        method: "POST",
                        data: data
                    };
                },
                /**
                 * price_option_edit[duration]
                 * price_option_edit[qty]
                 * NEW!
                 * price_option_create[price_on_request]
                 * @params: price id
                 *          data
                 */
                patch: function(id, data) {
                    options = {
                        url: "/price/option/" + id + "/edit",
                        method: "PATCH",
                        data: data
                    };

                },
                /**
                 * @params: price id
                 */
                delete: function(id) {
                    options = {
                        url: "/price/option/" + id + "/remove",
                        method: "PATCH"
                    };
                }

            }
        };

        this.send = function(success) {
            $.ajax({
                url: options.url,
                data: options.data,
                type: options.method,
                success: success,
                error: function(err) {
                    console.error(err);
                }
            });
        };
    }

    function TemplateBuilder() {
        this.data = {};

        this.trashCan = function(option, hidden) {
            if(hidden)
                hidden = 'style="display: none"';

            return '<i '+option+' class="fa fa-trash" aria-hidden="true"'+hidden+'></i>';
        };

        /* ----------------------------------------------------- */
        this.priceComp = function(rate, lenobj) {
            var html = "",
                trash;

            // if(lenobj.len < 2) {
            //     trash = this.trashCan("delete_price", true);
            // } else {
                trash = this.trashCan("delete_price");
            // }

            html += '\
                <div class="box">\
                    <dl>\
                        <dt>Price '+lenobj.i+':</dt>\
                        <dd>\
                            <input id="'+rate.id+'" edit_rate name="price_'+rate.id+'" class="input-num" type="text" placeholder="'+rate.price.amount+'" value="'+rate.price.amount+'" onkeypress="return isNumberKey(event)">\
                            <span class="curr">GBP</span>\
                        </dd>\
                        '+trash+'\
                    </dl>\
                </div>';

            return html;
        };

        this.rateComp = function(option) {

            var rates = option.rates,
                priceOnRequest = option.priceOnRequest,
                len = rates.length,
                html = "";

                html += '<ul rates class="price-list">';

                for(var key in rates) {
                    var rate = rates[key];

                    var i = new Number(key) + 1;

                    html += '<li price_comp>' + this.priceComp(rate, { i: i, len: len }) + '</li>';

                    if( (len == i) && (this.data.type !== 'service') ) {
                        html += '';

                        if(len < 2) {
                            html += '<li>';
                        } else {
                            html += '<li style="display: none">';
                        }

                        html +='<div class="add">\
                                <a add_price href="#">Add price</a><a class="ico-box" href="#"><i class="ico question">?</i></a>\
                            </div>\
                        </li>';
                    }
                }

                html += '<li><div class="custom-checkbox big">';

                if(priceOnRequest) {
                    html += '<input price_on_request id="price_on_request_'+option.id+'" type="checkbox" checked="checked">';
                } else {
                    html += '<input price_on_request id="price_on_request_'+option.id+'" type="checkbox">';
                }

                html +='<label for="price_on_request_'+option.id+'">Price on Request</label>\
                        </div></li>';

                html += '</ul>';

            return html;
        };

        /**
         * Duration component
         */
        this.durationComp = function() {
            var html = "",
                trashcan;

            var selected = 'selected="selected"';

            var qty = this.data.currentOption.qty;
            var dur = this.data.currentOption.duration || 0;

            var qtyMap = [1, 2, 3, 4, 5, 6];

            if(this.data.trashcanhide)
                trashcan = this.trashCan("delete_set", true);
            else
                trashcan = this.trashCan("delete_set");


            var qtyHtml;

            for(var i = 0; i < qtyMap.length; i++) {
                if(qtyMap[i] == qty) {
                    qtyHtml += '<option selected="selected" value="'+qtyMap[i]+'">'+qtyMap[i]+'</option>';
                } else {
                    qtyHtml += '<option value="'+qtyMap[i]+'">'+qtyMap[i]+'</option>';
                }
            }

            html=
            '<div class="box">\
                <dl>\
                    <dt>\
                        <select edit_qty data-class="selections-white curr-select" class="short" name="qty">\
                            '+qtyHtml+'\
                        </select>\
                        <span class="note-x">x</span>\
                    </dt>\
                    <dd>\
                        <input edit_duration name="duration" class="input-num" type="number" placeholder="'+dur+'" value="'+dur+'" onkeyup="return isNumberKey(event)" min="0" max="100">\
                    </dd>\
                    <span>min</span>\
                    '+trashcan+'\
                </dl>\
            </div>';

            return html;
        };

        /**
         * Sets component
         */
        this.setComp = function(rate) {
            var html = "",
                addSetBtn = "";

            if(this.data.lastset) {
                addSetBtn = '\
                    <div class="add">\
                        <a add_set href="#">Add sets</a><a class="ico-box" href="#"><i class="ico question">?</i></a>\
                    </div>\
                ';
            } else {
                addSetBtn = '\
                    <div style="display: none" class="add">\
                        <a add_set href="#">Add sets</a><a class="ico-box" href="#"><i class="ico question">?</i></a>\
                    </div>\
                ';
            }

            html +=
            '<ul class="price-list">\
               <li>\
                   '+this.durationComp()+'\
                </li>\
            </ul>\
            '+addSetBtn;

            return html;
        };

        /**
         * Container for sets and rates
         */
        this.divComp = function(comp, flag, customCreated) {
            var html = "";

            var options = this.data.currentPackage.options;

            if(comp == 'service') {
                html += '<div class="col-2">'+this.rateComp(options[0]) + '</div>';
            }

            if(comp == 'performance') {

                if(flag)
                    this.data.trashcanhide = (options.length > 1 ? false : true) & !customCreated;

                this.data.lastset = false;

                for(var key in options) {

                    if( key > 0 || flag || customCreated) {
                        html += '<div empty_col class="col"></div>';
                    }

                    if( (key == (options.length - 1)) || customCreated )
                        this.data.lastset = true;

                    this.data.currentOption = options[key];
                    this.data.type = 'performance';

                    html += '<div id="'+ options[key].id +'" set_option class="col">'+this.setComp(options[key])+'</div>';
                    html += '<div class="col-2">'+this.rateComp(options[key]) + '</div>';

                    if(customCreated)
                        break;
                }
            }

            return html;
        };

        /**
         * Package component
         *
         * @param package
         * @returns html
         */
        this.packageComp = function(package) {
            var html =
                '<div class="col">\
                    <div class="row">\
                        <input id="'+package.id+'" package_name name="name" class="input-num long" type="text" placeholder="'+package.name+'" value="'+package.name+'">\
                    </div>\
                </div>';

            return html;
        };

        /**
         * Heading component,
         * i.e. package or service title input
         */
        this.headingComp = function() {
            var html =
            '<h2 class="title">\
                <input name="title" class="input-num huge" type="hidden" placeholder="'+this.data.title+'" value="'+this.data.title+'">\
                <span>'+this.data.title+'<i delete_act class="fa fa-trash" aria-hidden="true"></i></span>\
            </h2>';

            return html;
        };

        this.packageContainerComp = function(comp) {
            var packages = this.data.packages;
            var packCompHtml = "";

            for(var k in packages) {
                this.data.currentPackage = packages[k];

                packCompHtml += '<ul package="'+packages[k].id+'" class="info-list"><li>';

                packCompHtml += this.packageComp(packages[k]);
                packCompHtml += this.divComp(comp, false);

                packCompHtml += '</li></ul>';
            }

            return packCompHtml;
        };

        this.containerComp = function(comp) {
            var packageBtnHtml = "";

            var visible = this.data.visible;

            if(comp == 'performance' && visible) {
                packageBtnHtml += '\
                    <div class="button-gradient add-btn">\
                        <button add_package type="button" class="btn register">Add Package</button>\
                    </div>';
            }

            return '<article '+comp+' act_id="'+ this.data.id+ '" class="act private">\
                        '+ this.headingComp() +'\
                        '+ this.packageContainerComp(comp) +'\
                        '+packageBtnHtml+'\
                    </article>';
        };

        /**
         * Performance component
         */
        this.PerformanceComp = function() {
            this.data.type = 'performance';
            return this.containerComp('performance');
        };

        /**
         * Service component
         */
        this.ServiceComp = function() {
            this.data.type = 'service';
            return this.containerComp('service');
        };
    };

    /**
     * Create api and template builder objects.
     */
    var pricesApi = new pricesApi();
    var temp = new TemplateBuilder();

    /**
     * Package / Service container tamplate.
     * @param flag
     * @return html
     */
    function addTemplate(flag) {
        var html = "";

        if(flag === 'service')
            html = temp.ServiceComp();
        if(flag === 'performance')
            html = temp.PerformanceComp();

        return html;
    };

    function editSetsValues() {
        var qty = $(this).closest("dl").find("[edit_qty]").find("option:selected").val();
        var duration = $(this).closest("dl").find("[edit_duration]").val();
        var id = $(this).closest("div[set_option]").attr("id");

        var data = {
            qty: qty,
            duration: duration
        };

        pricesApi.endpoints.price.patch(id, { price_option_edit:data });
        pricesApi.send(function(resp) {
            console.log(resp)
        });
    }

    /**
     * Event listeners
     */
    $("body")
        /**
         * TODO
         * Return id of created price (backend)
         */
        .on("click", "[add_price]", function(e) {
            e.preventDefault();

            var _this = $(this);

            var lic = _this.closest("ul").find("li");
            var optId = _this.closest("div.col-2").prev("div[set_option]").attr("id");
            var article = _this.closest("article"),
                comp;

            var i = lic.length;


            if( typeof(article.attr("performance")) != "undefined" )
                comp = "performance";

            if( typeof(article.attr("service")) != "undefined" )
                comp = "service";

            var data = {
                option: optId,
                price: 3000
            };

            pricesApi.endpoints.rate.post(comp, { price_rate_create: data });
            pricesApi.send(function(resp) {
                _this.closest("li").before("<li price_comp>"+temp.priceComp({ id: resp.price.id, price: { amount: 3000 } }, { i: i })+"</li>");

                if(lic.length >= 2) {
                    _this.closest("ul").find("a[add_price]").closest("li").hide();
                    _this.closest("ul").find("li").find("i.fa.fa-trash").show();
                }
            });
        })
        .on("click", "[add_set]", function(e) {
            e.preventDefault();

            var _this = $(this);
            var packId = $(this).closest("ul.info-list").attr("package");
            var article = $(this).closest("article"),
                comp;

            if( typeof(article.attr("performance")) != "undefined" )
                comp = "performance";

            if( typeof(article.attr("service")) != "undefined" )
                comp = "service";

            var data = {
                duration: 45,
                qty: 1,
                package: packId
            };

            pricesApi.endpoints.price.post({ price_option_create: data });
            pricesApi.send(function(resp) {
                var id = resp.id;

                var pricedata = {
                    option: id,
                    price: 3000
                };

                pricesApi.endpoints.rate.post(comp, { price_rate_create: pricedata });
                pricesApi.send(function(resp) {

                    temp.data.trashcanhide = true;
                    temp.data.currentPackage.options = [{
                        id: id,
                        rates: [
                            { id: resp.price.id, price: { amount: 3000 } }
                        ]
                    }];

                    _this.closest("ul.info-list").children("li").append(temp.divComp('performance', true, true));
                    //temp.data.trashcanhide = false;

                    var div = _this.closest("div.col");
                    div.find("i.fa.fa-trash").show();
                    _this.closest("div.add").hide();

                    console.log(resp);
                });

            });

        })
        .on("click", "[add_package]", function() {

            var article = $(this).closest("article");

            var _this = $(this);

            var id = article.attr("act_id"),
                comp;

            if( typeof(article.attr("performance")) != "undefined" )
                comp = "performance";

            if( typeof(article.attr("service")) != "undefined" )
                comp = "service";

            var id = $(this).closest("article").attr("act_id");

            var data = {
                package_name: "Package template",
                artist: artist,
                options: [{
                    qty: 1,
                    duration: 45,
                    price1: 3000
                }],
                performance: id
            };

            pricesApi.endpoints[comp].package.post({ performance_price_package: data});
            pricesApi.send(function(resp) {
                temp.data.packages = [resp.package];
                article.children("div.button-gradient.add-btn").before(temp.packageContainerComp('performance'));
            });
        })
        .on("focusout", "[edit_rate]", function(e) {

            var id = $(this).attr("id");
            var new_rate = $(this).val();


            /**
             * price_rate_edit[price]
             * @params: none
             */
            var data = {
                price: new_rate
            };

            pricesApi.endpoints.rate.patch(id, { price_rate_edit: data });
            pricesApi.send(function(resp) {
                console.log(resp);
            });
        })
        .on("change", "[edit_qty]", editSetsValues)
        .on("focusout", "[edit_duration]", editSetsValues)
        .on("click", "[delete_price]", function(e) {
            e.preventDefault();

            var _this = $(this);

            var ul = _this.closest("ul");
            var article = _this.closest("article"),
                articleIndex = article.index(),
                mainSection = article.closest("div"),
                packagesCount = article.children("ul[package]");
            var packageElem = _this.closest("ul[package]");
            var list = ul.find("li[price_comp]");
            var idx = _this.closest("li").index();
            var rateId = _this.closest("dl").find("input").attr("id");
            var deletePackage = false;

            var rows = _this.closest("div.col-2").closest("li").children("div[set_option]");

            if(!idx) {
                _this.closest("ul").find("li").find("dt").text("Price: 1");
                _this.closest("ul").find("li").find("input[name=\"price_2\"]").attr("name", "price_1");
            }

            if((list.length - 1) < 2) {
                ul.find("a[add_price]").closest("li").show();
                _this.closest("ul").find("a[add_price]").closest("li").show();
                // list.find("i.fa.fa-trash").hide();
            }

            var div = _this.closest("div.col-2");
            idx = div.prev().index();

            if((list.length - 1) < 1) {
                if(idx == 1)
                    div.next("[empty_col]").remove();
                else
                    div.prev().prev("[empty_col]").remove();

                div.prev("[set_option]").remove();
                div.prev().prev().find("div.add").show();
                div.remove();
            }

            var rows_length = rows.length - 1;

            /**
             * Delete last service price -> delete package and article
             * OR
             * Delete last performance price and last set -> delete package and article
             */
            if(temp.data.type == 'service' && ((list.length - 1) < 1) || ((rows_length == 0) && ((list.length - 1) < 1)) )
                deletePackage = true;

            _this.closest("li").remove();

            pricesApi.endpoints.rate.delete(rateId);
            pricesApi.send(function(resp) {
                temp.data;
                if(deletePackage) {
                     packageElem.remove();
                    if(list.length - 1 < 1) {
                        mainSection.find("article")[articleIndex].remove();
                    }
                }
            });
        })
        .on("click", "[delete_set]", function(e) {
            e.preventDefault();

            var _this = $(this);

            var rows = _this.closest("ul.info-list").find("div[set_option]"),
                div = _this.closest("div.col"),
                id = _this.closest("div[set_option]").attr("id"),
                idx = div.index(),
                deletePackage;

            var article = _this.closest("article"),
                articleIndex = article.index(),
                mainSection = article.closest("div");
            var packageElem = _this.closest("ul[package]");

            _this.closest("div[set_option]").prev().prev().prev().find("div.add").show();

            var rows_length = rows.length;

            if(rows_length > 1) {
                div.find("i.fa.fa-trash").show();

                if(idx == 1)
                    div.next().next("[empty_col]").remove();
                else
                    div.prev("[empty_col]").remove();

                div.next().remove();
                div.remove();
            }

            var rows_length = rows.length - 1;

            if(rows_length == 0) {
                deletePackage = true;
            }

            pricesApi.endpoints.price.delete(id);
            pricesApi.send(function(resp) {
                if(deletePackage) {
                    packageElem.remove();
                    if(rows_length == 0) {
                        mainSection.find("article")[articleIndex].remove();
                    }
                }
            });
        })
        .on("click", "[delete_act]", function(e) {
            e.preventDefault();
            var _delete = confirm("Are you sure you want to delete this act?");

            if(_delete) {

                var article = $(this).closest("article");

                var id = article.attr("act_id"),
                    comp;

                if( typeof(article.attr("performance")) != "undefined" )
                    comp = "performance";

                if( typeof(article.attr("service")) != "undefined" )
                    comp = "service";

                $(this).closest("article").remove();

                pricesApi.endpoints[comp].delete(id);
                pricesApi.send(function(resp) {
                    console.log(resp)
                });
            }
        })
        .on("click", ".prices h2.title", function(e) {
            e.preventDefault();

            if($(this).find("span").is(":visible")) {
                $(this).find("input").attr("type", "text");
                $(this).find("span").hide();
            } else {
                var span = $(this).find("span");

                $(this).find("input").focusout(function(e) {
                    span.show();
                    span.html($(this).val() + '<i delete_act class="fa fa-trash" aria-hidden="true"></i>');

                    var article = $(this).closest("article");
                    var id = $(this).closest("article").attr("act_id"),
                        comp;

                    var data = { title: $(this).val() };

                    if( typeof(article.attr("performance")) != "undefined" )
                        comp = "performance";

                    if( typeof(article.attr("service")) != "undefined" )
                        comp = "service";

                    var obj = {};

                        obj[comp] = data;

                    pricesApi.endpoints[comp].patch(id, obj);
                    pricesApi.send(function(resp) {
                        console.log(resp)
                    });

                    $(this).attr("type", "hidden");
                });
            }
        })
        .on("click", "[price_on_request]", function(e) {

            var div = $(this).closest("div.col-2").prev();

            var checked = $(this).prop('checked');
            var id = div.attr("id");

            var qty = div.find("[edit_qty]").find("option:selected").val();
            var duration = div.find("[edit_duration]").val();

            var data = {
                qty: qty,
                duration: duration,
                price_on_request: checked
            };

            pricesApi.endpoints.price.patch(id, { price_option_edit: data });
            pricesApi.send(function(resp) {
                console.log(resp);
            })
        })
        .on("focusout", "[package_name]", function(e) {

            var id = $(this).attr("id");
            var data = { name: $(this).val() };

            pricesApi.endpoints.package.patch(id, { price_package: data });
            pricesApi.send(function(resp) {
                console.log(resp);
            });

        });
    /* -------------------------------------------------------------------------------------------------------------- */
    /**
     * Act
     */
    function actCreate(e) {
        var data = {
            title: "Act template",
            package_name: "package template",
            artist: artist,
            options: [
                {
                    price1: 3000,
                    duration: 45,
                    qty: 1
                }
            ]
        };

        pricesApi.endpoints.performance.post({ performance_price: data });
        pricesApi.send(function(resp) {
            temp.data = resp.performance;
            $("div[act-section]").append(addTemplate('performance'));
        });
    }
    /**
     * Services
     */
    function serviceCreate(e) {
        var data = {
            title: "Service template",
            package_name: "package template",
            artist: artist,
            price: 3000,
            duration: 45,
            qty: 1
        };
        pricesApi.endpoints.service.post.price({ service_price: data });
        pricesApi.send(function(resp) {
            temp.data = resp.service;
            $("div[services-section]").append(addTemplate('service'));
        });
    }

    $("button[service-add]")
        .on("click", serviceCreate);
    $("button[act-add]")
        .on("click", actCreate);
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * Get all performances
     */

    if($("main.prices").length) {
        pricesApi.endpoints.performance.getAll();
        pricesApi.send(function(resp) {
            var performances = resp.performances;

            for(var k in performances) {
                temp.data = performances[k] || new Array(0);

                if(temp.data.isVisible) {
                    temp.data.visible = temp.data.isVisible;
                    $("div[perf-created-sec]").append(addTemplate('performance'));
                } else {
                    temp.data.visible = temp.data.isVisible;
                    $("div[act-section]").append(addTemplate('performance'));
                }
            }
        });

        /**
         * Get all services
         */
        pricesApi.endpoints.service.getAll();
        pricesApi.send(function(resp) {
            var services = resp.services;

            for(var k in services) {
                temp.data = services[k] || new Array(0);
                $("div[services-section]").append(addTemplate('service'));
            }
        });
    }
})();