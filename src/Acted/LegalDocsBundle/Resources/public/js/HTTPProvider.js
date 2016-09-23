/**
  * HTTP Provider
  */

    function HTTPProvider() {
        this.options = {
            method: 'GET',
            url: '/',
            async: true
        };
    }

    HTTPProvider.prototype.prepareSend = function(options) {
        this.options = options;
    };

    /**
    *   data - Form data to send
    *   options - Object with keys:
    *               url, method
    *
    */
    HTTPProvider.prototype.send = function(data) {

        data = data || {};

        var xhr = new XMLHttpRequest();

        xhr.open(this.options.method, this.options.url, this.options.async);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.send(data);

        if (xhr.status != 200) {
            console.log( xhr.status + ': ' + xhr.statusText );
        } else {
            console.log( xhr.responseText );
        }
    };

    var HTTPProvider = new HTTPProvider();