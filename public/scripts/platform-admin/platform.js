var Platform = {};

(function (Platform) {
    var EVENTS = {
        WINDOW: {
            CLOSE: 'g.window.close'
        }
    };
    Platform.EVENTS = EVENTS;
    var _initMenu = function (opts) {
        var $menu = $("#g-nav"), self = Platform.ui;

        $menu.on('click', 'a.k-link', function (e) {
            e.preventDefault();
        });

        $menu.kendoMenu({
            dataSource: opts.menu,
            select: function (e) {
                var dataItem = {"items": this.options.dataSource}, $item = $(e.item);
                $item.parentsUntil('#g-nav').filter('.k-item').add($item).each(function () {
                    dataItem = dataItem.items[$(this).index()];
                });

                var attrs = {};
                try {
                    attrs = $.parseJSON(dataItem.attributes);
                } catch (e) {
                }

                if (!dataItem.url) {
                    return ;
                }

                if ($item.data('g.window')) {
                    $item.data('g.window').data("kendoWindow").open();
                } else {
                    var $win = self.newWindow($.extend(attrs, {
                        title: dataItem.text,
                        content: dataItem.url
                    }));
                    $win.bind(EVENTS.WINDOW.CLOSE, function () {
                        $item.removeData('g.window');
                    });
                    $item.data('g.window', $win);
                }
            }
        });
        //菜单显示在窗口上层
        $menu.hover(function() {
            $menu.parent().css('zIndex', 20000);
        }, function() {
            $menu.parent().removeAttr('style');
        });
    };

    var _initToolbar = function () {
        var $tasks = $("#g-tasks"),
            $closeWin = $('<span class="g-tool-close k-sprite k-tool-icon k-si-close k-state-selected">Close</span>');

        var taskBar = $tasks.kendoToolBar({
            items: [
                {
                    template: '<div class="g-menu-wrap"><div id="g-menu">Menu</div></div>',
                    overflow: "never"
                },
//                    { type: "splitButton", text: "Menu" ,spriteCssClass: "k-icon k-i-custom", menuButtons: [
//                        { text: "Insert above", icon: "insert-n" },
//                        { text: "Insert between", icon: "insert-m" },
//                        { text: "Insert below", icon: "insert-s" }
//                    ]},
                    { type: "separator" }

            ]
        }).data('kendoToolBar');

        $closeWin.hover(function () {
            $(this).toggleClass('k-state-focused');
        },function () {
            $(this).toggleClass('k-state-focused');
        });

        $tasks.add(taskBar.popup.element).on('mouseenter', '[data-group=wins]',function () {
            $closeWin.appendTo(this);
        }).on('mouseleave', '[data-group=wins]', function () {
            $closeWin.detach();
        });
        $tasks.on('click', '.g-tool-close', function (e) {
            $(this).parent().data('g.window').trigger(EVENTS.WINDOW.CLOSE);
        }).on('click', '[data-group=wins]', function () {
            var kw = $(this).data('g.window').data('kendoWindow');
            if ($tasks.data('g.window.activate') == this && kw.wrapper.is(':visible')) {
                kw.close().trigger('deactivate');
            } else {
                kw.open().trigger('activate');
            }
        });

        $(taskBar.popup.element).on('click', '.g-tool-close', function (e) {
            $('[data-uid='+$(this).closest('.k-item').data('uid')+']', $tasks)
                .data('g.window').trigger(EVENTS.WINDOW.CLOSE);
        }).on('click', '[data-group=wins]', function () {
            $('[data-uid='+$(this).parent().data('uid')+']', $tasks).click();
        });

        //窗口存在遮罩的时候, 遮罩层置顶
        $('body').on('mouseenter', '> .k-overlay', function () {
            $(this).css('zIndex', 21000).next('.k-window').css('zIndex', 21001);
        });
    };
    Platform.ui = {
        _options: {},
        init: function () {
            $.ajaxSetup({type: "POST", dataType: "json"});
            var self = this,
                opts = this._options;

            $(document).ready(function () {
                _initMenu(opts);
                _initToolbar();
            });
        },
        config: function (options) {
            this._options = $.extend({
                menu: []
            }, options);
        },
        newWindow: function (params) {
            params = $.extend({
//                appendTo: '#g-window',
                width: document.body.offsetWidth * 0.86,
                minWidth: 600,
                minHeight: 400,
                maxHeight: document.body.offsetHeight - 70,
                actions: ["Refresh", "Minimize", "Maximize", "Close"]
            }, params);

            var $win = $('<div></div>'), $tasks = $("#g-tasks"),
                kw = $win.kendoWindow(params).data("kendoWindow").open().center();
            kw.wrapper.css('top', $('#g-top').height());
            //浏览器窗口 resize , 重新定位任务窗口
//            $(window).resize(function () {kw.center();});

            //新增标签
            var taskBar = $tasks.data('kendoToolBar');
            if (taskBar) {
                taskBar.add({
                    type: "button",
                    text: params.title,
                    group: "wins"
                });
            }
            var $newTask = $tasks.find('[data-group=wins]').last();
            var activateHandler = function () {
                $tasks.data('g.window.activate', $newTask.get(0));
                $newTask.addClass('k-state-active').siblings('[data-group=wins]').removeClass('k-state-active');
            };

            $newTask.data('g.window', $win);
            kw.bind('activate', activateHandler);
            kw.bind('deactivate', function () {
                $newTask.removeClass('k-state-active');
            });
            kw.wrapper.mousedown(activateHandler);

            //最小化关闭窗口
            kw.wrapper.on('click', '.k-i-minimize', function (e) {
                kw.close();
                e.preventDefault();
                return false;
            });

            //关闭按钮触发
            kw.wrapper.on('click', '.k-i-close', function (e) {
                $win.trigger(EVENTS.WINDOW.CLOSE);
            });

            if (taskBar) {
                //窗口绑定关闭事件
                $win.bind(EVENTS.WINDOW.CLOSE, function (e) {
                    kw.destroy();
                    taskBar.remove($newTask);
                    taskBar.resize(taskBar.getSize());
                });
                taskBar.resize(taskBar.getSize());
            }

            return $win;
        },
        toolbarClick: function (name, clickHandler) {
            var $elem = typeof(name) == 'string' ? $('.k-grid-' + name) : name;
            $elem.paRemoteClick(clickHandler);
        },
        imageBrowser: function (options) {
            var baseUrl = (options && options.baseUrl) || './uploads/';

            options = $.extend({
                baseUrl: baseUrl,
                transport: {
                    read: "./admin/image-browser/read",
                    destroy: "./admin/image-browser/delete",
                    create: "./admin/image-browser/create",
                    thumbnailUrl: function (path, name) {
                        if ($.inArray(name.split('.').pop(), ['gif', 'jpg', 'png', 'jpeg']) == -1) {
                            return null;
                        }
                        return options.baseUrl + path + name;
                    },
                    uploadUrl: "./admin/image-browser/upload",
                    imageUrl: baseUrl + '{0}'
                }
            }, options);

            var imageBrowser = $('<div />').appendTo('body');
            imageBrowser.kendoWindow({
                width: 700,
                visible: false,
                modal: true,
                open: function () {
                    if (imageBrowser.data('kendoImageBrowser')) {
                        return;
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

    Platform.ds = {
    };
})(Platform);

(function ($) {
    $.fn.extend({
        paRemoteClick: function (clickHandler) {
            var $elem = this;
            if (typeof clickHandler == "string") {
                var url = clickHandler;
                clickHandler = function () {
                    return {url: url};
                }
            }
            var lock = false;

            this.click(function () {
                var opt = clickHandler.apply(this, arguments);
                if (!opt) return opt;
                var params = $.extend({
                    complete: function () {
                        lock = false;
                        $elem.find('span.k-icon').toggleClass('k-loading');
                    },
                    success: function (result) {
                        this.defaultSuccess(result);
                    },
                    defaultSuccess: function (result) {

                        this.message = result.code == 1 ? this.message : result.msg;

                        $elem.attr('title', this.message);

                        $elem.data('kendoTooltip').show($elem);
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
            return this;
        }
    });
})(jQuery);