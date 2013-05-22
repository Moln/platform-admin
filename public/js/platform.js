
(function ($){
    $.fn.extend({
        paRemoteClick: function (clickHandler){
            var $elem = this;
            if (typeof clickHandler == "string") {
                var url = clickHandler;
                clickHandler = function (){
                    return {url: url};
                }
            }
            var lock = false;

            this.click(function (){
                var opt = clickHandler.apply(this, arguments);
                if (!opt) return opt;
                var params = $.extend({
                    complete: function (){
                        lock = false;
                        $elem.find('span.k-icon').toggleClass('k-loading');
                    },
                    success: function (result){
                        this.defaultSuccess(result);
                    },
                    defaultSuccess: function (result){
                        if (result.code) {
                            if (result.msg || this.message) {
                                $elem.attr('title', result.msg || this.message);
                            }
                            $elem.data('kendoTooltip').show($elem);
                        }
                    }
                }, opt);

                $elem.find('span.k-icon').toggleClass('k-loading');

                if (!lock) $.ajax(params);
                lock = true;

                return false;
            }).kendoTooltip({
                autoHide: false,
                showOn: "null",
                callout: true
            });
        }
    });
})(jQuery);

var Platform = {
    newWindow: function (params){
        var $win = $('<div></div>');
        $win.kendoWindow($.extend({
            width: 1000,
            minHeight: 400,
            actions: ["Refresh", "Custom", "Minimize", "Maximize", "Close"],
            close: function (){
                this.destroy();
            },
            activate: function (e){
                this.element.data("kendoWindow").center();
            }
        }, params)).data("kendoWindow").center().open();
        return $win;
    },
    toolbarClick: function (name, clickHandler){
        var $elem = typeof(name) == 'string' ? $('.k-grid-'+name) : name;
        $elem.paRemoteClick(clickHandler);
    }
};