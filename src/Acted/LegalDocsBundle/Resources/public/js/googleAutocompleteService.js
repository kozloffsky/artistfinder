;(function(window) {
    /**
     *  Google Autocomplete Service
     *
     * @constructor
     */
    var COUNTRY = 0,
        CITY    = 1,
        REGION  = 2,
        ADDRESS = 3;

    window.GoogleAutocompleteService = {
        /**
         * Constants
         */
        key: "AIzaSyDLK8SupBcU-H0H0SF0PIar5UP-y-DCrTI",
        isoCodes: [
            {'ccode' : 'AF', 'cname' : 'Afghanistan'},
            {'ccode' : 'AX', 'cname' : 'Aland Islands'},
            {'ccode' : 'AL', 'cname' : 'Albania'},
            {'ccode' : 'DZ', 'cname' : 'Algeria'},
            {'ccode' : 'AS', 'cname' : 'American Samoa'},
            {'ccode' : 'AD', 'cname' : 'Andorra'},
            {'ccode' : 'AO', 'cname' : 'Angola'},
            {'ccode' : 'AI', 'cname' : 'Anguilla'},
            {'ccode' : 'AQ', 'cname' : 'Antarctica'},
            {'ccode' : 'AG', 'cname' : 'Antigua And Barbuda'},
            {'ccode' : 'AR', 'cname' : 'Argentina'},
            {'ccode' : 'AM', 'cname' : 'Armenia'},
            {'ccode' : 'AW', 'cname' : 'Aruba'},
            {'ccode' : 'AU', 'cname' : 'Australia'},
            {'ccode' : 'AT', 'cname' : 'Austria'},
            {'ccode' : 'AZ', 'cname' : 'Azerbaijan'},
            {'ccode' : 'BS', 'cname' : 'Bahamas'},
            {'ccode' : 'BH', 'cname' : 'Bahrain'},
            {'ccode' : 'BD', 'cname' : 'Bangladesh'},
            {'ccode' : 'BB', 'cname' : 'Barbados'},
            {'ccode' : 'BY', 'cname' : 'Belarus'},
            {'ccode' : 'BE', 'cname' : 'Belgium'},
            {'ccode' : 'BZ', 'cname' : 'Belize'},
            {'ccode' : 'BJ', 'cname' : 'Benin'},
            {'ccode' : 'BM', 'cname' : 'Bermuda'},
            {'ccode' : 'BT', 'cname' : 'Bhutan'},
            {'ccode' : 'BO', 'cname' : 'Bolivia'},
            {'ccode' : 'BA', 'cname' : 'Bosnia And Herzegovina'},
            {'ccode' : 'BW', 'cname' : 'Botswana'},
            {'ccode' : 'BV', 'cname' : 'Bouvet Island'},
            {'ccode' : 'BR', 'cname' : 'Brazil'},
            {'ccode' : 'IO', 'cname' : 'British Indian Ocean Territory'},
            {'ccode' : 'BN', 'cname' : 'Brunei Darussalam'},
            {'ccode' : 'BG', 'cname' : 'Bulgaria'},
            {'ccode' : 'BF', 'cname' : 'Burkina Faso'},
            {'ccode' : 'BI', 'cname' : 'Burundi'},
            {'ccode' : 'KH', 'cname' : 'Cambodia'},
            {'ccode' : 'CM', 'cname' : 'Cameroon'},
            {'ccode' : 'CA', 'cname' : 'Canada'},
            {'ccode' : 'CV', 'cname' : 'Cape Verde'},
            {'ccode' : 'KY', 'cname' : 'Cayman Islands'},
            {'ccode' : 'CF', 'cname' : 'Central African Republic'},
            {'ccode' : 'TD', 'cname' : 'Chad'},
            {'ccode' : 'CL', 'cname' : 'Chile'},
            {'ccode' : 'CN', 'cname' : 'China'},
            {'ccode' : 'CX', 'cname' : 'Christmas Island'},
            {'ccode' : 'CC', 'cname' : 'Cocos (Keeling) Islands'},
            {'ccode' : 'CO', 'cname' : 'Colombia'},
            {'ccode' : 'KM', 'cname' : 'Comoros'},
            {'ccode' : 'CG', 'cname' : 'Congo'},
            {'ccode' : 'CD', 'cname' : 'Congo, Democratic Republic'},
            {'ccode' : 'CK', 'cname' : 'Cook Islands'},
            {'ccode' : 'CR', 'cname' : 'Costa Rica'},
            {'ccode' : 'CI', 'cname' : 'Cote D\'Ivoire'},
            {'ccode' : 'HR', 'cname' : 'Croatia'},
            {'ccode' : 'CU', 'cname' : 'Cuba'},
            {'ccode' : 'CY', 'cname' : 'Cyprus'},
            {'ccode' : 'CZ', 'cname' : 'Czech Republic'},
            {'ccode' : 'DK', 'cname' : 'Denmark'},
            {'ccode' : 'DJ', 'cname' : 'Djibouti'},
            {'ccode' : 'DM', 'cname' : 'Dominica'},
            {'ccode' : 'DO', 'cname' : 'Dominican Republic'},
            {'ccode' : 'EC', 'cname' : 'Ecuador'},
            {'ccode' : 'EG', 'cname' : 'Egypt'},
            {'ccode' : 'SV', 'cname' : 'El Salvador'},
            {'ccode' : 'GQ', 'cname' : 'Equatorial Guinea'},
            {'ccode' : 'ER', 'cname' : 'Eritrea'},
            {'ccode' : 'EE', 'cname' : 'Estonia'},
            {'ccode' : 'ET', 'cname' : 'Ethiopia'},
            {'ccode' : 'FK', 'cname' : 'Falkland Islands (Malvinas)'},
            {'ccode' : 'FO', 'cname' : 'Faroe Islands'},
            {'ccode' : 'FJ', 'cname' : 'Fiji'},
            {'ccode' : 'FI', 'cname' : 'Finland'},
            {'ccode' : 'FR', 'cname' : 'France'},
            {'ccode' : 'GF', 'cname' : 'French Guiana'},
            {'ccode' : 'PF', 'cname' : 'French Polynesia'},
            {'ccode' : 'TF', 'cname' : 'French Southern Territories'},
            {'ccode' : 'GA', 'cname' : 'Gabon'},
            {'ccode' : 'GM', 'cname' : 'Gambia'},
            {'ccode' : 'GE', 'cname' : 'Georgia'},
            {'ccode' : 'DE', 'cname' : 'Germany'},
            {'ccode' : 'GH', 'cname' : 'Ghana'},
            {'ccode' : 'GI', 'cname' : 'Gibraltar'},
            {'ccode' : 'GR', 'cname' : 'Greece'},
            {'ccode' : 'GL', 'cname' : 'Greenland'},
            {'ccode' : 'GD', 'cname' : 'Grenada'},
            {'ccode' : 'GP', 'cname' : 'Guadeloupe'},
            {'ccode' : 'GU', 'cname' : 'Guam'},
            {'ccode' : 'GT', 'cname' : 'Guatemala'},
            {'ccode' : 'GG', 'cname' : 'Guernsey'},
            {'ccode' : 'GN', 'cname' : 'Guinea'},
            {'ccode' : 'GW', 'cname' : 'Guinea-Bissau'},
            {'ccode' : 'GY', 'cname' : 'Guyana'},
            {'ccode' : 'HT', 'cname' : 'Haiti'},
            {'ccode' : 'HM', 'cname' : 'Heard Island & Mcdonald Islands'},
            {'ccode' : 'VA', 'cname' : 'Holy See (Vatican City State)'},
            {'ccode' : 'HN', 'cname' : 'Honduras'},
            {'ccode' : 'HK', 'cname' : 'Hong Kong'},
            {'ccode' : 'HU', 'cname' : 'Hungary'},
            {'ccode' : 'IS', 'cname' : 'Iceland'},
            {'ccode' : 'IN', 'cname' : 'India'},
            {'ccode' : 'ID', 'cname' : 'Indonesia'},
            {'ccode' : 'IR', 'cname' : 'Iran, Islamic Republic Of'},
            {'ccode' : 'IQ', 'cname' : 'Iraq'},
            {'ccode' : 'IE', 'cname' : 'Ireland'},
            {'ccode' : 'IM', 'cname' : 'Isle Of Man'},
            {'ccode' : 'IL', 'cname' : 'Israel'},
            {'ccode' : 'IT', 'cname' : 'Italy'},
            {'ccode' : 'JM', 'cname' : 'Jamaica'},
            {'ccode' : 'JP', 'cname' : 'Japan'},
            {'ccode' : 'JE', 'cname' : 'Jersey'},
            {'ccode' : 'JO', 'cname' : 'Jordan'},
            {'ccode' : 'KZ', 'cname' : 'Kazakhstan'},
            {'ccode' : 'KE', 'cname' : 'Kenya'},
            {'ccode' : 'KI', 'cname' : 'Kiribati'},
            {'ccode' : 'KR', 'cname' : 'Korea'},
            {'ccode' : 'KW', 'cname' : 'Kuwait'},
            {'ccode' : 'KG', 'cname' : 'Kyrgyzstan'},
            {'ccode' : 'LA', 'cname' : 'Lao People\'s Democratic Republic'},
            {'ccode' : 'LV', 'cname' : 'Latvia'},
            {'ccode' : 'LB', 'cname' : 'Lebanon'},
            {'ccode' : 'LS', 'cname' : 'Lesotho'},
            {'ccode' : 'LR', 'cname' : 'Liberia'},
            {'ccode' : 'LY', 'cname' : 'Libyan Arab Jamahiriya'},
            {'ccode' : 'LI', 'cname' : 'Liechtenstein'},
            {'ccode' : 'LT', 'cname' : 'Lithuania'},
            {'ccode' : 'LU', 'cname' : 'Luxembourg'},
            {'ccode' : 'MO', 'cname' : 'Macao'},
            {'ccode' : 'MK', 'cname' : 'Macedonia'},
            {'ccode' : 'MG', 'cname' : 'Madagascar'},
            {'ccode' : 'MW', 'cname' : 'Malawi'},
            {'ccode' : 'MY', 'cname' : 'Malaysia'},
            {'ccode' : 'MV', 'cname' : 'Maldives'},
            {'ccode' : 'ML', 'cname' : 'Mali'},
            {'ccode' : 'MT', 'cname' : 'Malta'},
            {'ccode' : 'MH', 'cname' : 'Marshall Islands'},
            {'ccode' : 'MQ', 'cname' : 'Martinique'},
            {'ccode' : 'MR', 'cname' : 'Mauritania'},
            {'ccode' : 'MU', 'cname' : 'Mauritius'},
            {'ccode' : 'YT', 'cname' : 'Mayotte'},
            {'ccode' : 'MX', 'cname' : 'Mexico'},
            {'ccode' : 'FM', 'cname' : 'Micronesia, Federated States Of'},
            {'ccode' : 'MD', 'cname' : 'Moldova'},
            {'ccode' : 'MC', 'cname' : 'Monaco'},
            {'ccode' : 'MN', 'cname' : 'Mongolia'},
            {'ccode' : 'ME', 'cname' : 'Montenegro'},
            {'ccode' : 'MS', 'cname' : 'Montserrat'},
            {'ccode' : 'MA', 'cname' : 'Morocco'},
            {'ccode' : 'MZ', 'cname' : 'Mozambique'},
            {'ccode' : 'MM', 'cname' : 'Myanmar'},
            {'ccode' : 'NA', 'cname' : 'Namibia'},
            {'ccode' : 'NR', 'cname' : 'Nauru'},
            {'ccode' : 'NP', 'cname' : 'Nepal'},
            {'ccode' : 'NL', 'cname' : 'Netherlands'},
            {'ccode' : 'AN', 'cname' : 'Netherlands Antilles'},
            {'ccode' : 'NC', 'cname' : 'New Caledonia'},
            {'ccode' : 'NZ', 'cname' : 'New Zealand'},
            {'ccode' : 'NI', 'cname' : 'Nicaragua'},
            {'ccode' : 'NE', 'cname' : 'Niger'},
            {'ccode' : 'NG', 'cname' : 'Nigeria'},
            {'ccode' : 'NU', 'cname' : 'Niue'},
            {'ccode' : 'NF', 'cname' : 'Norfolk Island'},
            {'ccode' : 'MP', 'cname' : 'Northern Mariana Islands'},
            {'ccode' : 'NO', 'cname' : 'Norway'},
            {'ccode' : 'OM', 'cname' : 'Oman'},
            {'ccode' : 'PK', 'cname' : 'Pakistan'},
            {'ccode' : 'PW', 'cname' : 'Palau'},
            {'ccode' : 'PS', 'cname' : 'Palestinian Territory, Occupied'},
            {'ccode' : 'PA', 'cname' : 'Panama'},
            {'ccode' : 'PG', 'cname' : 'Papua New Guinea'},
            {'ccode' : 'PY', 'cname' : 'Paraguay'},
            {'ccode' : 'PE', 'cname' : 'Peru'},
            {'ccode' : 'PH', 'cname' : 'Philippines'},
            {'ccode' : 'PN', 'cname' : 'Pitcairn'},
            {'ccode' : 'PL', 'cname' : 'Poland'},
            {'ccode' : 'PT', 'cname' : 'Portugal'},
            {'ccode' : 'PR', 'cname' : 'Puerto Rico'},
            {'ccode' : 'QA', 'cname' : 'Qatar'},
            {'ccode' : 'RE', 'cname' : 'Reunion'},
            {'ccode' : 'RO', 'cname' : 'Romania'},
            {'ccode' : 'RU', 'cname' : 'Russian Federation'},
            {'ccode' : 'RW', 'cname' : 'Rwanda'},
            {'ccode' : 'BL', 'cname' : 'Saint Barthelemy'},
            {'ccode' : 'SH', 'cname' : 'Saint Helena'},
            {'ccode' : 'KN', 'cname' : 'Saint Kitts And Nevis'},
            {'ccode' : 'LC', 'cname' : 'Saint Lucia'},
            {'ccode' : 'MF', 'cname' : 'Saint Martin'},
            {'ccode' : 'PM', 'cname' : 'Saint Pierre And Miquelon'},
            {'ccode' : 'VC', 'cname' : 'Saint Vincent And Grenadines'},
            {'ccode' : 'WS', 'cname' : 'Samoa'},
            {'ccode' : 'SM', 'cname' : 'San Marino'},
            {'ccode' : 'ST', 'cname' : 'Sao Tome And Principe'},
            {'ccode' : 'SA', 'cname' : 'Saudi Arabia'},
            {'ccode' : 'SN', 'cname' : 'Senegal'},
            {'ccode' : 'RS', 'cname' : 'Serbia'},
            {'ccode' : 'SC', 'cname' : 'Seychelles'},
            {'ccode' : 'SL', 'cname' : 'Sierra Leone'},
            {'ccode' : 'SG', 'cname' : 'Singapore'},
            {'ccode' : 'SK', 'cname' : 'Slovakia'},
            {'ccode' : 'SI', 'cname' : 'Slovenia'},
            {'ccode' : 'SB', 'cname' : 'Solomon Islands'},
            {'ccode' : 'SO', 'cname' : 'Somalia'},
            {'ccode' : 'ZA', 'cname' : 'South Africa'},
            {'ccode' : 'GS', 'cname' : 'South Georgia And Sandwich Isl.'},
            {'ccode' : 'ES', 'cname' : 'Spain'},
            {'ccode' : 'LK', 'cname' : 'Sri Lanka'},
            {'ccode' : 'SD', 'cname' : 'Sudan'},
            {'ccode' : 'SR', 'cname' : 'Suriname'},
            {'ccode' : 'SJ', 'cname' : 'Svalbard And Jan Mayen'},
            {'ccode' : 'SZ', 'cname' : 'Swaziland'},
            {'ccode' : 'SE', 'cname' : 'Sweden'},
            {'ccode' : 'CH', 'cname' : 'Switzerland'},
            {'ccode' : 'SY', 'cname' : 'Syrian Arab Republic'},
            {'ccode' : 'TW', 'cname' : 'Taiwan'},
            {'ccode' : 'TJ', 'cname' : 'Tajikistan'},
            {'ccode' : 'TZ', 'cname' : 'Tanzania'},
            {'ccode' : 'TH', 'cname' : 'Thailand'},
            {'ccode' : 'TL', 'cname' : 'Timor-Leste'},
            {'ccode' : 'TG', 'cname' : 'Togo'},
            {'ccode' : 'TK', 'cname' : 'Tokelau'},
            {'ccode' : 'TO', 'cname' : 'Tonga'},
            {'ccode' : 'TT', 'cname' : 'Trinidad And Tobago'},
            {'ccode' : 'TN', 'cname' : 'Tunisia'},
            {'ccode' : 'TR', 'cname' : 'Turkey'},
            {'ccode' : 'TM', 'cname' : 'Turkmenistan'},
            {'ccode' : 'TC', 'cname' : 'Turks And Caicos Islands'},
            {'ccode' : 'TV', 'cname' : 'Tuvalu'},
            {'ccode' : 'UG', 'cname' : 'Uganda'},
            {'ccode' : 'UA', 'cname' : 'Ukraine'},
            {'ccode' : 'AE', 'cname' : 'United Arab Emirates'},
            {'ccode' : 'GB', 'cname' : 'United Kingdom'},
            {'ccode' : 'US', 'cname' : 'United States'},
            {'ccode' : 'UM', 'cname' : 'United States Outlying Islands'},
            {'ccode' : 'UY', 'cname' : 'Uruguay'},
            {'ccode' : 'UZ', 'cname' : 'Uzbekistan'},
            {'ccode' : 'VU', 'cname' : 'Vanuatu'},
            {'ccode' : 'VE', 'cname' : 'Venezuela'},
            {'ccode' : 'VN', 'cname' : 'Viet Nam'},
            {'ccode' : 'VG', 'cname' : 'Virgin Islands, British'},
            {'ccode' : 'VI', 'cname' : 'Virgin Islands, U.S.'},
            {'ccode' : 'WF', 'cname' : 'Wallis And Futuna'},
            {'ccode' : 'EH', 'cname' : 'Western Sahara'},
            {'ccode' : 'YE', 'cname' : 'Yemen'},
            {'ccode' : 'ZM', 'cname' : 'Zambia'},
            {'ccode' : 'ZW', 'cname' : 'Zimbabwe'}
        ],
        findCountryByName: function(name) {
            return this.isoCodes.find(function(element) {
                return element.cname == name;
            }).ccode || 0;
        },
        findCountryByCode: function(code) {
            return this.isoCodes.find(function(element) {
                return element.ccode == code;
            }).cname || 0;
        },
        /**
         * Some variables
         */
        inputs: new Array(0),
        coords: {},
        availableCountries: ['GB', 'DE', 'FR'],
        address: '',
        autocomplete: {
            country:   null,
            city:      null,
            post_code: null
        },
        currentStore: {
            country:   '',
            city:      '',
            region:    '',
            post_code: ''
        },
        staticMap: {
            url: "https://maps.googleapis.com/maps/api/staticmap",
            zoom: 14,
            size: "mid",
            marker: {
                label: "S",
                color: "blue"
            }
        },
        /**
         * Helper methods
         */
        addInput: function(element) {
            this.inputs.push(element);
        },
        addArray: function(arrOfElements) {
            if(Array.isArray(arrOfElements))
                this.inputs = arrOfElements;
            else
                console.error("You need to provide array of elements!");
        },
        clearData: function() {
            this.autocomplete = { country: null, city: null, post_code: null },
            this.currentStore = { country: '',   city: '',   region: '', post_code: '' }
        },
        /**
         * Init method
         */
        initAutoComplete: function() {
            var _this = this;

            this.inputs[COUNTRY].on("change", this.countryChangeEvent.bind(_this));
            this.addAutocomplete(this.inputs[CITY]);
            this.setAutocompleteCountry(null, this.availableCountries[0]);
            this.currentStore.country = this.findCountryByCode(this.availableCountries[0]);
            _this.unlock(_this.inputs[CITY]);
        },

        /**
         * lock/unlock inputs when some of parameters not exist
         * @param elem (input)
         */
        lock: function(elem) {
            $(elem).prop( "disabled", true );
        },
        unlock: function(elem) {
            $(elem).prop( "disabled", false );
        },
        countryChangeEvent: function(context) {
            var idx  = this.inputs[COUNTRY].find("option:selected").val(),
                code = this.availableCountries[idx];

            this.setAutocompleteCountry(context, code);

            // Clear inputs after change country
            this.currentStore.country = this.findCountryByCode(code);
            this.inputs[CITY].val("");
            this.inputs[REGION].val("");
            this.inputs[ADDRESS].val("");
        },
        /**
         * Add autocomplete service to input
         * @param element (input)
         */
        setAutocompleteCountry: function(context, country) {
            this.autocomplete.city.setComponentRestrictions({ country: country });
        },
        placeChangeEvent: function(name) {
            var _this = this;

            var place = _this.autocomplete[name].getPlace();

            _this.coords = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };

            console.log("PLACE: ", place);

            //Location details
            for (var i = 0; i < place.address_components.length; i++) {

                var type             = place.address_components[i].types[0];
                var postal_type      = place.address_components[i].types[1];
                var place_name       = place.address_components[i].long_name.trim();

                // if(type == 'country') {
                //
                //     console.log("COUNTRY: ", country);
                //
                //     if(country) {
                //         // $(_this.inputs[COUNTRY]).val(country);
                //
                //         _this.currentStore.country = //country;
                //         _this.unlock(_this.inputs[CITY]);
                //     }
                // }

                switch(type) {
                    case 'locality':
                        var city = place_name; console.log("CITY: ", city);

                        if(city) {
                            _this.currentStore.city = city;
                            $(_this.inputs[CITY]).val(city);
                        }
                    case 'administrative_area_level_1':
                        var region = place_name; console.log("REGION: ", region);

                        if(region) {
                            _this.currentStore.region = region;
                        }
                    case 'administrative_area_level_2':
                        console.log("administrative_area_level_2: ", place_name);
                    case 'administrative_area_level_3':
                        console.log("administrative_area_level_3: ", place_name);

                }

                if(type == 'postal_code' || postal_type == 'postal_code') {
                    var post_code = place_name; console.log("POST CODE: ", post_code);

                    _this.unlock(_this.inputs[REGION]);
                    $(_this.inputs[REGION]).val('');
                    $(_this.inputs[REGION]).val(post_code);
                    _this.currentStore.post_code = post_code;
                }
            }

            console.log("FULL ADDRESS: ", place.formatted_address);

            _this.inputs[ADDRESS].val(place.formatted_address);
            _this.address = place.formatted_address;

            if($(".quotation-modal .map-holder").length) {
                _this.addMarker();
            }
        },
        addAutocomplete: function(elem) {
            var _this = this;

            var name = elem.attr('name'),
                options = {};

            _this.currentStore[name] = elem.val().trim();
            _this.autocomplete[name] = new google.maps.places.Autocomplete(elem[0], options);
            _this.autocomplete[name].addListener('place_changed', _this.placeChangeEvent.bind(_this, name));
        },
        addMarker: function() {
            var url = this.staticMap.url;

                url += "?center=" + this.coords.lat + ", " + this.coords.lng;
                url += "&zoom="   + this.staticMap.zoom;
                url += "&key="    + this.key;
                url += "&size=196x106";
                url += "&markers=";
                url += "size:"   + this.staticMap.size +
                       "|color:" + this.staticMap.color +
                       "|label:" + this.staticMap.marker.label +
                       "|"       + this.coords.lat +
                       ", "      + this.coords.lng;

            $(".quotation-modal .map-holder img").attr("src", url);
        },
        /**
         * Form manipulation functional
         * @param form
         */
        getFormElements: function(form) {
            var form     = $(form),
                country  = form.find('select[name="country"]'),
                city     = form.find('input[name="city"]'),
                postcode = form.find('input[name="post_code"]') || 0,
                address  = form.find('input[name="address"]') || form.find('input[name="location"]') || 0;

            if(country.length && city.length) {
                this.addArray([country, city, postcode, address]);
                return true;
            }

            return false;
        }
    }
})(this);


