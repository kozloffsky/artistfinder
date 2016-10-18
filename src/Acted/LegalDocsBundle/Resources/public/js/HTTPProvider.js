/**
  * HTTP Provider
  */
function HTTPProvider() {

    this.xhr = new XMLHttpRequest();
    this.options = {
        method: 'GET',
        url: '/',
        async: true
    };
}

/**
 *  Apply options before send
 * @param options
 */
HTTPProvider.prototype.prepareSend = function(options) {
    this.options = options;
};

HTTPProvider.prototype.onLoad = function(event) {
    //{ status: event.target.status, data: event.target.response };
};

HTTPProvider.prototype.onError = function(e) {
    //console.log("ERROR: ", e);
};

HTTPProvider.prototype.listenRequests = function() {
    //console.log("an ajax request was made")
};

HTTPProvider.prototype.onProgress = function(e) {
    var percentComplete = (e.position / e.totalSize)*100;
    //console.log("Percent %: " + percentComplete);
};
/**
 * Sends request
 * @param data
 */
HTTPProvider.prototype.send = function(data, done) {
    data = data || {};

    this.xhr.open(this.options.method, this.options.url, this.options.async);
    this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // this.xhr.onprogress = this.onProgress;
    this.xhr.onload = this.onLoad;
    // this.xhr.onerror = this.onError;

    this.xhr.onreadystatechange = function (aEvt) {
        if (this.xhr.readyState == 4) {
            if(this.xhr.status == 200 || this.xhr.status == 400)
                done(this.xhr.response);
        }
    }.bind(this);

    this.xhr.send(data);
};

HTTPProvider.prototype.errorsSerialize = function (errors) {
    var serializedErrors = {};

    try {
        errors = JSON.parse(errors);

        if(errors.form) {
            errors = errors.form.children || {};

            for(key in errors) {
                if(!Array.isArray(errors[key]))
                    serializedErrors[key] = errors[key].errors;
            }
        }

        return serializedErrors;
    } catch (e) {
        console.error(e);
        return {};
    }


};

var HTTPProvider = new HTTPProvider();