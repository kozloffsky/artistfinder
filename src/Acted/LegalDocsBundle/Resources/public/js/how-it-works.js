;(function() {
    "use strict";

    (function($){
        jQuery.fn.lightTabs = function(options){

            var createTabs = function(){
                var tabs = this;
                var i = 0;

                var showPage = function(i){
                    $(tabs).children("div").children("div").hide();
                    $(tabs).children("div").children("div").eq(i).show();
                    $(tabs).children("ul").children("li").removeClass("active");
                    $(tabs).children("ul").children("li").eq(i).addClass("active");
                };

                showPage(0);

                $(tabs).children("ul").children("li").each(function(index, element){
                    $(element).attr("data-page", i);
                    i++;
                });

                $(tabs).children("ul").children("li").click(function(){
                    showPage(parseInt($(this).attr("data-page")));
                });
            };
            return this.each(createTabs);
        };
    })(jQuery);

    $(document).ready(function(){
        $(".tabs").lightTabs();
    });
})();