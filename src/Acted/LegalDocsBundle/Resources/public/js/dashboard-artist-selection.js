$(function () {
    'use strict';

    var AWAITING = 0;
    var AVAILABLE = 1;
    var BOOKED = 2;

    try {
        if ($('.artist-selection').length > 0) {
            var artistVue = new Vue({
                el: '.artist-selection',
                delimiters: ['${', '}'],
                data: {
                    orders: []
                },
                created: function () {
                    showArtists();
                },
                methods: {
                    reject: function (event) {
                        var $this = $(event.target);
                        var $order = $this.parents('.artist-block');
                        var chatRoomId = $order.data('chatroomId');
                        var orderId = $order.data('orderId');
                        reject(chatRoomId);
                        cancelOrder(orderId);
                    }
                }
            });
        }
    } catch (e) {
        console.log(e);
    }

    function sortByPrice(orders) {
        orders.forEach(function (order, index) {
            var items = order.items;
            var minItem = _.minBy(items, function (i) {
                return i.data.total;
            });

            orders[index]['minPrice'] = minItem.data.total;
        });

        return _.sortBy(orders, function (order) {
            return order.minPrice;
        });
    }

    function sortByRating(orders) {
        return _.sortBy(orders, function (i) {
            return i.artist.averageRating;
        }).reverse();
    }

    function showArtists() {
        $('.artist-block').show();
    }

    function sortAll(orders) {
        return sortByPrice(sortByRating(orders));
    }

    function toGroups(orders) {
        var sortedOrders = [];
        var awaiting = _.toArray(_.pickBy(orders, function (order) {
            return order.status == AWAITING;
        }));
        awaiting = sortByRating(awaiting);
        var available = _.toArray(_.pickBy(orders, function (order) {
            return order.status == AVAILABLE;
        }));
        available = sortAll(available);
        var confirmed = _.toArray(_.pickBy(orders, function (order) {
            return order.status == BOOKED;
        }));
        confirmed = sortByRating(confirmed);
        confirmed.forEach(function (item) {
            sortedOrders.push(item);
        });
        available.forEach(function (item) {
            sortedOrders.push(item);
        });
        awaiting.forEach(function (item) {
            sortedOrders.push(item);
        });

        artistVue.orders = sortedOrders;
    }

    function getOrdersForEvent(eventId) {
        $.ajax({
            url: "/api/events/" + eventId + "/orders/status",
            method: "GET",
            success: function (response) {
                if (typeof response.orders !== 'undefined') {
                    toGroups(response.orders);
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    }

    function cancelOrder(orderId) {
        $.ajax({
            url: '/order/' + orderId,
            method: "DELETE",
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function reject(chatRoomId) {
        var message = "The client has decided to book another performance";
        $.ajax({
            url: '/dashboard/web/push/' + chatRoomId,
            method: "POST",
            data: {message: message},
            success: function (response) {

            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    window.getOrdersForEvent = getOrdersForEvent;

});