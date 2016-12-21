$(function () {

    'use strict';

    const AWAITING = 0;
    const AVAILABLE = 1;
    const BOOKED = 2;

    var vueEventPayments;

    function getOrderPaymentsForEvent(eventId) {
        var status = BOOKED;
        $.ajax({
            url: '/api/events/' + eventId + '/orders/status/' + status,
            method: "GET",
            success: function (response) {
                console.log(response);
                if (typeof response.orders !== 'undefined') {
                    vueEventPayments.paymentOrders = response.orders;
                    if (response.orders.length > 0) {
                        vueEventPayments.event = response.orders[0].event;
                        //artist/user
                    }
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    if (document.querySelector('.client-payments')) {
        try {
            vueEventPayments = new Vue({
                el: '.client-payments',
                delimiters: ['${', '}'],
                data: {
                    paymentOrders: [],
                    event: {}
                },
                created: function () {

                },
                methods: {
                    showNotification: function (startDate, endDate) {
                        var a = moment(this.$options.filters.event_date(startDate));
                        var b = moment(this.$options.filters.event_date(endDate));
                        var diffDays = Math.abs(a.diff(b, 'days'));

                        console.log(diffDays);

                        if (diffDays <= 2) {
                            return true;
                        }

                        return false;
                    }
                },
                filters: {
                    "event_date": function (value) {
                        if (typeof(value) == 'undefined') {
                            return;
                        }

                        var date = value.split('/');
                        date = date[1] + '/' + date[0] + '/' + date[2];
                        return moment(date).format('DD MMMM YYYY');
                        //var diff = moment().diff(createdAt, 'days');
                    }
                },
                watch: {
                    isAttached: function () {

                    }
                }

            });
        } catch (e) {
        }
    }

    window.getOrderPaymentsForEvent = getOrderPaymentsForEvent;
});