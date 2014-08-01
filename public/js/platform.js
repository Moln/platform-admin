
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
        var kw = $win.kendoWindow($.extend({
            width: '50%',
//            minWidth: '100%',
//            minHeight: 400,
            maxHeight: document.body.offsetHeight-70,
            actions: ["Refresh", /*"Custom",*/ "Minimize", "Maximize", "Close"],
            close: function (){
                this.destroy();
            },
            activate: function (e){
                this.element.data("kendoWindow").center();
            }
        }, params)).data("kendoWindow").open().center();
        $(window).resize(function (){
            kw.center();
        });
        $win.parent().width('86%');

        kw.wrapper.find(".k-i-minimize").click(function(e){
//            alert("Custom action button clicked");
            e.preventDefault();
        });
        return $win;
    },
    toolbarClick: function (name, clickHandler){
        var $elem = typeof(name) == 'string' ? $('.k-grid-'+name) : name;
        $elem.paRemoteClick(clickHandler);
    },
    imageBrowser: function (options){
        var baseUrl = (options && options.baseUrl) || '/uploads/';

        options = $.extend({
            baseUrl: baseUrl,
            transport: {
                read: "/admin/image-browser/read",
                destroy: "/admin/image-browser/delete",
                create: "/admin/image-browser/create",
                thumbnailUrl: function (path, name){
                    if ($.inArray(name.split('.').pop(), ['gif', 'jpg', 'png', 'jpeg']) == -1) {
                        return null;
                    }
                    return options.baseUrl + path + name;
                },
                uploadUrl: "/admin/image-browser/upload",
                imageUrl: baseUrl + '{0}'
            }
        }, options);

        var imageBrowser = $('<div />').appendTo('body');
        imageBrowser.kendoWindow({
            width: 700,
            visible: false,
            modal: true,
            open: function (){
                if (imageBrowser.data('kendoImageBrowser')) {
                    return ;
                }
                var ib = new kendo.ui.ImageBrowser(imageBrowser, options);
                ib.bind('apply', function () {
                    imageBrowser.data('kendoWindow').close();
                    imageBrowser.trigger('apply', this);
                });
                imageBrowser.data('kendoImageBrowser', ib);
                this.center();
            }
        });

        return imageBrowser;
    }
};