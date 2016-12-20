$(function () {
    'use strict';

    const AWAITING = 0;
    const AVAILABLE = 1;
    const BOOKED = 2;

    try {
        var artistVue = new Vue({
            el: '.artist-selection',
            delimiters: ['${', '}'],
            data: {
                orders: []
            },
            created: function () {
                showArtists();
            }
        });
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
        var awating = _.toArray(_.pickBy(orders, function (order) {
            return order.status == AWAITING;
        }));
        awating = sortByRating(awating);
        var available = _.toArray(_.pickBy(orders, function (order) {
            return order.status == AVAILABLE;
        }));
        available = sortAll(available);
        var confirmed = _.toArray(_.pickBy(orders, function (order) {
            return order.status == BOOKED;
        }));
        confirmed = sortByRating(confirmed);
        confirmed.forEach(function(item){
            sortedOrders.push(item);
        });
        available.forEach(function(item){
            sortedOrders.push(item);
        });
        awating.forEach(function(item){
            sortedOrders.push(item);
        });

        artistVue.orders = sortedOrders;
    }

    function getOrdersForEvent(eventId) {
        var json = [
            {
                "id": 14,
                "status": 1,
                "items": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "performances": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "services": [],
                "event": {
                    "id": 930,
                    "title": "newTestRelise",
                    "event_type": [],
                    "venue_type": [],
                    "location": "94 Rickmansworth Rd, Watford WD18 7JJ, UK",
                    "starting_date": "22\/12\/2016",
                    "timing": "evening",
                    "comments": "dddd",
                    "number_of_guests": "50-100",
                    "count_days": 3
                },
                "client": {
                    "id": 1,
                    "user": {
                        "firstname": "Barrett",
                        "lastname": "Ratliff"
                    }
                },
                "artist": {
                    "name": "Adena Peters",
                    "averageRating": "3.33",
                    "id": 321,
                    "user": {
                        "firstname": "Shaeleigh",
                        "lastname": "Schwartz",
                        "profile": {
                            "performances": [
                                {
                                    "id": 2607,
                                    "title": "Act price 2",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1978,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2558,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3598,
                                                            "price": {
                                                                "id": 3598,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2606,
                                    "title": "Act template",
                                    "status": "published",
                                    "is_visible": false,
                                    "packages": [
                                        {
                                            "id": 1975,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2555,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3595,
                                                            "price": {
                                                                "id": 3595,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2605,
                                    "title": "Act price1",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1974,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2554,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3594,
                                                            "price": {
                                                                "id": 3594,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            "id": 1976,
                                            "name": "Package template",
                                            "options": [
                                                {
                                                    "id": 2556,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3596,
                                                            "price": {
                                                                "id": 3596,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                }
                            ],
                            "services": [
                                {
                                    "packages": [
                                        {
                                            "id": 1977,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2557,
                                                    "rates": [
                                                        {
                                                            "id": 3597,
                                                            "price": {
                                                                "id": 3597,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "id": 333,
                                    "title": "Service template"
                                }
                            ]
                        }
                    },
                    "video_media": null
                }
            },
            {
                "id": 14,
                "status": 5,
                "items": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "performances": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "services": [],
                "event": {
                    "id": 930,
                    "title": "newTestRelise",
                    "event_type": [],
                    "venue_type": [],
                    "location": "94 Rickmansworth Rd, Watford WD18 7JJ, UK",
                    "starting_date": "22\/12\/2016",
                    "timing": "evening",
                    "comments": "dddd",
                    "number_of_guests": "50-100",
                    "count_days": 3
                },
                "client": {
                    "id": 1,
                    "user": {
                        "firstname": "Barrett",
                        "lastname": "Ratliff"
                    }
                },
                "artist": {
                    "name": "Adena Peters",
                    "id": 321,
                    "averageRating": "1",
                    "user": {
                        "firstname": "Shaeleigh",
                        "lastname": "Schwartz",
                        "profile": {
                            "performances": [
                                {
                                    "id": 2607,
                                    "title": "Act price 2",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1978,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2558,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3598,
                                                            "price": {
                                                                "id": 3598,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2606,
                                    "title": "Act template",
                                    "status": "published",
                                    "is_visible": false,
                                    "packages": [
                                        {
                                            "id": 1975,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2555,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3595,
                                                            "price": {
                                                                "id": 3595,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2605,
                                    "title": "Act price1",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1974,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2554,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3594,
                                                            "price": {
                                                                "id": 3594,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            "id": 1976,
                                            "name": "Package template",
                                            "options": [
                                                {
                                                    "id": 2556,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3596,
                                                            "price": {
                                                                "id": 3596,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                }
                            ],
                            "services": [
                                {
                                    "packages": [
                                        {
                                            "id": 1977,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2557,
                                                    "rates": [
                                                        {
                                                            "id": 3597,
                                                            "price": {
                                                                "id": 3597,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "id": 333,
                                    "title": "Service template"
                                }
                            ]
                        }
                    },
                    "video_media": null
                }
            },
            {
                "id": 14,
                "status": 3,
                "items": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "performances": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "services": [],
                "event": {
                    "id": 930,
                    "title": "newTestRelise",
                    "event_type": [],
                    "venue_type": [],
                    "location": "94 Rickmansworth Rd, Watford WD18 7JJ, UK",
                    "starting_date": "22\/12\/2016",
                    "timing": "evening",
                    "comments": "dddd",
                    "number_of_guests": "50-100",
                    "count_days": 3
                },
                "client": {
                    "id": 1,
                    "user": {
                        "firstname": "Barrett",
                        "lastname": "Ratliff"
                    }
                },
                "artist": {
                    "name": "Adena Peters",
                    "id": 321,
                    "averageRating": "4",
                    "user": {
                        "firstname": "Shaeleigh",
                        "lastname": "Schwartz",
                        "profile": {
                            "performances": [
                                {
                                    "id": 2607,
                                    "title": "Act price 2",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1978,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2558,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3598,
                                                            "price": {
                                                                "id": 3598,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2606,
                                    "title": "Act template",
                                    "status": "published",
                                    "is_visible": false,
                                    "packages": [
                                        {
                                            "id": 1975,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2555,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3595,
                                                            "price": {
                                                                "id": 3595,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2605,
                                    "title": "Act price1",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1974,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2554,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3594,
                                                            "price": {
                                                                "id": 3594,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            "id": 1976,
                                            "name": "Package template",
                                            "options": [
                                                {
                                                    "id": 2556,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3596,
                                                            "price": {
                                                                "id": 3596,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                }
                            ],
                            "services": [
                                {
                                    "packages": [
                                        {
                                            "id": 1977,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2557,
                                                    "rates": [
                                                        {
                                                            "id": 3597,
                                                            "price": {
                                                                "id": 3597,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "id": 333,
                                    "title": "Service template"
                                }
                            ]
                        }
                    },
                    "video_media": null
                }
            },
            {
                "id": 14,
                "status": 4,
                "items": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "performances": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "services": [],
                "event": {
                    "id": 930,
                    "title": "newTestRelise",
                    "event_type": [],
                    "venue_type": [],
                    "location": "94 Rickmansworth Rd, Watford WD18 7JJ, UK",
                    "starting_date": "22\/12\/2016",
                    "timing": "evening",
                    "comments": "dddd",
                    "number_of_guests": "50-100",
                    "count_days": 3
                },
                "client": {
                    "id": 1,
                    "user": {
                        "firstname": "Barrett",
                        "lastname": "Ratliff"
                    }
                },
                "artist": {
                    "name": "Adena Peters",
                    "id": 321,
                    "user": {
                        "firstname": "Shaeleigh",
                        "lastname": "Schwartz",
                        "profile": {
                            "performances": [
                                {
                                    "id": 2607,
                                    "title": "Act price 2",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1978,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2558,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3598,
                                                            "price": {
                                                                "id": 3598,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2606,
                                    "title": "Act template",
                                    "status": "published",
                                    "is_visible": false,
                                    "packages": [
                                        {
                                            "id": 1975,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2555,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3595,
                                                            "price": {
                                                                "id": 3595,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2605,
                                    "title": "Act price1",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1974,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2554,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3594,
                                                            "price": {
                                                                "id": 3594,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            "id": 1976,
                                            "name": "Package template",
                                            "options": [
                                                {
                                                    "id": 2556,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3596,
                                                            "price": {
                                                                "id": 3596,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                }
                            ],
                            "services": [
                                {
                                    "packages": [
                                        {
                                            "id": 1977,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2557,
                                                    "rates": [
                                                        {
                                                            "id": 3597,
                                                            "price": {
                                                                "id": 3597,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "id": 333,
                                    "title": "Service template"
                                }
                            ]
                        }
                    },
                    "video_media": null
                }
            },
            {
                "id": 14,
                "status": 0,
                "items": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "performances": [
                    {
                        "id": 26,
                        "data": {
                            "performance": 2607,
                            "title": "Act price 2",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1978,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2558,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3598,
                                                    "price": {
                                                        "id": 3598,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 3000
                        }
                    },
                    {
                        "id": 27,
                        "data": {
                            "performance": 2605,
                            "title": "Act price1",
                            "type": 0,
                            "packages": [
                                {
                                    "id": 1974,
                                    "name": "default package",
                                    "options": [
                                        {
                                            "id": 2554,
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3594,
                                                    "price": {
                                                        "id": 3594,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    "id": 1976,
                                    "name": "Package template",
                                    "options": [
                                        {
                                            "id": 2556,
                                            "duration": 0,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "id": 3596,
                                                    "price": {
                                                        "id": 3596,
                                                        "amount": 3000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    },
                    {
                        "id": 28,
                        "data": {
                            "title": "Act price1",
                            "type": 1,
                            "packages": [
                                {
                                    "name": "default package",
                                    "options": [
                                        {
                                            "duration": 1,
                                            "qty": 1,
                                            "rates": [
                                                {
                                                    "price": {
                                                        "amount": 4000
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            "total": 6000
                        }
                    }
                ],
                "services": [],
                "event": {
                    "id": 930,
                    "title": "newTestRelise",
                    "event_type": [],
                    "venue_type": [],
                    "location": "94 Rickmansworth Rd, Watford WD18 7JJ, UK",
                    "starting_date": "22\/12\/2016",
                    "timing": "evening",
                    "comments": "dddd",
                    "number_of_guests": "50-100",
                    "count_days": 3
                },
                "client": {
                    "id": 1,
                    "user": {
                        "firstname": "Barrett",
                        "lastname": "Ratliff"
                    }
                },
                "artist": {
                    "name": "Adena Peters",
                    "id": 321,
                    "averageRating": "2",
                    "user": {
                        "firstname": "Shaeleigh",
                        "lastname": "Schwartz",
                        "profile": {
                            "performances": [
                                {
                                    "id": 2607,
                                    "title": "Act price 2",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1978,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2558,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3598,
                                                            "price": {
                                                                "id": 3598,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2606,
                                    "title": "Act template",
                                    "status": "published",
                                    "is_visible": false,
                                    "packages": [
                                        {
                                            "id": 1975,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2555,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3595,
                                                            "price": {
                                                                "id": 3595,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                },
                                {
                                    "id": 2605,
                                    "title": "Act price1",
                                    "status": "published",
                                    "is_visible": true,
                                    "packages": [
                                        {
                                            "id": 1974,
                                            "name": "default package",
                                            "options": [
                                                {
                                                    "id": 2554,
                                                    "qty": 1,
                                                    "duration": 1,
                                                    "rates": [
                                                        {
                                                            "id": 3594,
                                                            "price": {
                                                                "id": 3594,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            "id": 1976,
                                            "name": "Package template",
                                            "options": [
                                                {
                                                    "id": 2556,
                                                    "qty": 1,
                                                    "duration": 0,
                                                    "rates": [
                                                        {
                                                            "id": 3596,
                                                            "price": {
                                                                "id": 3596,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "type": 0
                                }
                            ],
                            "services": [
                                {
                                    "packages": [
                                        {
                                            "id": 1977,
                                            "name": "package template",
                                            "options": [
                                                {
                                                    "id": 2557,
                                                    "rates": [
                                                        {
                                                            "id": 3597,
                                                            "price": {
                                                                "id": 3597,
                                                                "amount": 3000
                                                            }
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    "id": 333,
                                    "title": "Service template"
                                }
                            ]
                        }
                    },
                    "video_media": null
                }
            }
        ];
        $.ajax({
            url: "/api/events/" + eventId + "/orders",
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

    window.getOrdersForEvent = getOrdersForEvent;

});