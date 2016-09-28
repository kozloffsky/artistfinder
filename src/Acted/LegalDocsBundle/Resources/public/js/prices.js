;(function() {

    function stateMachine() {
        this.states = [];

        this.add = function(element, state) {
            this.states.push({ elem: element, state: state })
        };

        this.get = function() {};
        this.mutate = function() {};
        this.destroy = function() {};
    }

    function Templates() {
        /**
         * Template for prices section
         * @param rate
         * @returns {string}
         */
        this.priceTemp = function(rate) {
            var localHtml = '';

            localHtml += '\
                <div class="box">\
                    <dl>\
                        <dt>Price1:</dt>\
                        <dd>\
                            <input name="price_'+rate.id+'" class="input-num" type="text" placeholder="'+rate.price.amount+'" value="'+rate.price.amount+'">\
                            <span class="curr">GBP</span>\
                        </dd>\
                        <i delete_price class="fa fa-trash" aria-hidden="true"></i>\
                    </dl>\
                </div>';

            return localHtml;
        };

        /**
         * Template for pre-prices section
         * @param rates
         * @returns {string}
         */
        this.rateTemp = function(rates) {
            var localHtml = '<ul class="price-list">';

            for(var k in rates) {
                localHtml += '<li>' + this.priceTemp(rates[k]) + '</li>';
            }

            if(rates.length <= 1) {
                localHtml += '\
                    <li>\
                        <div class="add">\
                            <a add_price href="#">Add price</a><a class="ico-box" href="#"><i class="ico question">?</i></a>\
                        </div>\
                    </li>';
            }

            localHtml += '</ul>';

            return localHtml;
        };

        /**
         * Template for quantity & duration fields
         * Return generated template including prices section.
         *
         * @param set  - Object,
         *         last - boolean
         * @returns {string}
         */
        this.setsTemp = function(set, last) {
            var localHtml = "",
                lastHtml = "";

            if(set.quantity > 3 || set.quantity < 1) {

            }

            if(last) {
                lastHtml = '\
                    <div class="add">\
                        <a href="#">Add sets</a><a class="ico-box" href="#"><i class="ico question">?</i></a>\
                    </div>\
                ';
            }

            localHtml =
                '<ul class="price-list">\
                        <li>\
                            <div class="box">\
                                <dl>\
                                    <dt>\
                                        <select data-class="selections-white curr-select" class="short" name="qty">\
                                            <option value="1">1</option>\
                                            <option value="2">2</option>\
                                            <option value="3">3</option>\
                                        </select>\
                                        <span class="note-x">x</span>\
                                    </dt>\
                                    <dd>\
                                        <select data-class="selections-white curr-select" name="duration">\
                                            <option value="45">45 min</option>\
                                            <option value="50">50 min</option>\
                                            <option value="55">55 min</option>\
                                        </select>\
                                    </dd>\
                                    <i class="fa fa-trash" aria-hidden="true"></i>\
                                </dl>\
                            </div>\
                            '+lastHtml+'\
                        </li>\
                    </ul>';

            return localHtml;
        };

        /**
         * Template for options
         * @param options
         * @returns {string}
         */
        this.optionsTemp = function(options) {
            var localHtml = "",
                sets = null,
                last = false,
                i = 0;

            var optLen = options.length;

            for(var k in options) {
                i++;

                if(i == optLen)
                    last = true;

                sets = { id: options[k].id, quantity: options[k].qty, duration: options[k].duration };

                localHtml +=
                '\
                    <div class="col">\
                    '+this.setsTemp(sets, last)+'\
                    </div>\
                    <div class="col-2">\
                    '+this.rateTemp(options[k].rates)+'\
                    </div>\
                ';
            };

            return localHtml;
        };

        /**
         * Template for package, returns fully generated package template
         * @param packages
         * @returns {string}
         */
        this.packageTemp = function(packages) {

            var localHtml = '<ul class="info-list">';

            for(var k in packages) {
                localHtml += '\
                        <li>\
                            <form name="price_package">\
                                <div class="col">\
                                    <div class="row">\
                                        <input name="name" class="input-num long" type="text" placeholder="'+packages[k].name+'" value="'+packages[k].name+'">\
                                    </div>\
                                </div>\
                                '+this.optionsTemp(packages[k].options)+'\
                            </form>\
                        </li>';
            }

            localHtml += '</ul>';


            return localHtml;
        };
    }

    var temp = new Templates();

    var performanceTemplate = function(item) {

        var id = item.id,
            title = item.title,
            visible = item.isVisible,
            packages = item.packages;

        var templates = new Templates();

        var html = "";

        html += '<article class="act private">';

        if(title) {
            html += '<h2 class="title"><span>'+title+'<i class="fa fa-trash" aria-hidden="true"></i></span></h2>';
        } else {
            html += '<h2 class="title"><input name="title" class="input-num huge" type="text" placeholder="Act title"></h2>';
        }

        html += templates.packageTemp(packages);

        html += '</article>';

        return html;
    };

    var serviceTemplate = function() {
        return '<article class="act private"> \
            <h2 class="title"> \
            <input class="input-num huge" type="text" placeholder="Service title"> \
            </h2> \
            <ul class="info-list"> \
            <li> \
            <div class="col"> \
            <div class="row"> \
            <input class="input-num long" type="text" placeholder="Package name"> \
            </div> \
            </div> \
            <div class="col-2"> \
            <ul class="price-list"> \
            <li> \
            <div class="box"> \
            <dl> \
            <dt>Price1:</dt> \
            <dd> \
            <input class="input-num" type="text" placeholder="3.000"> \
            <span class="curr">GBP</span> \
            </dd> \
            <i class="fa fa-trash" aria-hidden="true"></i> \
            </dl> \
            </div> \
            </li> \
            <li> \
            <div class="add"> \
            <a href="#">Add price</a><a class="ico-box" href="#"><i class="ico question">?</i></a> \
            </div> \
            </li> \
            </ul> \
            </div> \
            </li> \
            </ul> \
            </article>';
    };

    function eventHandler(e) {
        var _this = $(this);
        $("div[services-section]").append(serviceTemplate())
    }

    var artistID = JSON.parse(localStorage.getItem("user")).artistId;

    $.ajax({
        type:'GET',
        url: 'http://acted.site/price/performance/'+artistID+'/list',
        success:function(response) {
            var performancesArray = response.performances;

            for(k in performancesArray) {
                var performanceObj = performancesArray[k];

                console.log(performanceObj);

                $("div[perf-created-sec]").append(performanceTemplate(performanceObj));
            }

        }
    });

    $("body").on("click", "[delete_price]", function(e) {
        console.log($(this).closest("li").remove());
    });

    $("body").on("click", "[add_price]", function(e) {
        $(this).closest("ul").append().after("<li>"+temp.priceTemp({ id: 2, price: { amount: 2000 } })+"</li>");
    });


    /**
     * Package create POST
     */

    // $.ajax({
    //     type: 'POST',
    //     url: '/price/performance/package/create',
    //     success:function(response) {}
    // });

    // $("button[package-add]")
    // .on("click", eventHandler);
    // $("button[act-add]")
    // .on("click", eventHandler);
    $("button[service-add]")
    .on("click", eventHandler);
})();