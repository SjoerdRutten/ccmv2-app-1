document.addEventListener("alpine:init", () => {
    Alpine.data("stripo", (obj) => ({
            token: obj.token,
            html: obj.html,
            stripo_html: obj.stripoHtml,
            stripo_css: obj.stripoCss,
            email_id: obj.emailId,
            wire: Livewire.getByName("ems::emails::edit"),
            notifications: {
                autoCloseTimeout: 10000,
                container: '.notification-zone',
                error: function (text, id, params) {
                    this.notifications.showNotification(this.notifications.getErrorNotification.bind(this), text, id, params);
                },
                warn: function (text, id, params) {
                    this.notifications.showNotification(this.notifications.getWarningNotification.bind(this), text, id, params);
                },
                info: function (text, id, params) {
                    this.notifications.showNotification(this.notifications.getInfoNotification.bind(this), text, id, params);
                },
                success: function (text, id, params) {
                    this.notifications.showNotification(this.notifications.getSuccessNotification.bind(this), text, id, params);
                },
                loader: function (text, id, params) {
                    this.notifications.showNotification(this.notifications.getLoaderNotification.bind(this), text, id, params);
                },
                hide: function (id) {
                    var toast = $('#' + id, this.container);
                    toast.effect('fade', 600, function () {
                        toast.remove()
                    })
                },
                showNotification: function (notificationGetter, text, id, params) {
                    params = Object.assign({autoClose: true, closeable: true}, params || {});
                    if (!id || !$('#' + id).length) {
                        var toast = notificationGetter(text, id, !params.closeable);
                        $(this.container).append(toast);
                        toast.effect('slide', {direction: 'down'}, 300);
                        if (params.autoClose) {
                            setTimeout(function () {
                                toast.effect('fade', 600, function () {
                                    toast.remove()
                                })
                            }, this.autoCloseTimeout);
                        }
                    }
                },
                getErrorNotification: function (text, id, nonclosable) {
                    return this.notifications.getNotificationTemplate('alert-danger', text, id, nonclosable);
                },
                getWarningNotification: function (text, id, nonclosable) {
                    return this.notifications.getNotificationTemplate('alert-warning', text, id, nonclosable);
                },
                getInfoNotification: function (text, id, nonclosable) {
                    return this.notifications.getNotificationTemplate('alert-info', text, id, nonclosable);
                },
                getSuccessNotification: function (text, id, nonclosable) {
                    return this.notifications.getNotificationTemplate('alert-success', text, id, nonclosable);
                },
                getLoaderNotification: function (text, id) {
                    var notification = $('\
                    <div class="alert alert-info" role="alert">\
                    <div style="width:auto; margin-right: 15px; float: left !important;">\
                        <div style="width:20px;height:20px;border-radius:50%;box-shadow:1px 1px 0px #31708f;\
                          animation:cssload-spin 690ms infinite linear"></div>\
                      </div>' + text + '\
                    </div>');
                    id && notification.attr('id', id);
                    return notification;
                },
                getNotificationTemplate: function (classes, text, id, nonclosable) {
                    var notification = $('\
                    <div class="alert alert-dismissible ' + classes + (nonclosable ? ' nonclosable' : '') + '" role="alert">\
                      ' + (nonclosable ? '' :
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                              <span aria-hidden="true">&times;</span>\
                            </button>') +
                        text +
                        '</div>');
                    id && notification.attr('id', id);
                    return notification;
                }
            },
            init() {
                window.onresize = this.onWindowResize;

                this.initPlugin(this);
                this.onWindowResize();
            },
            saveStripo() {
                var $this = this;

                window.StripoApi.getTemplate(function (html, css) {
                    $this.stripo_html = html;
                    $this.stripo_css = css;

                    window.StripoApi.compileEmail(function (error, html, ampHtml, ampError) {
                        $this.html = html;
                    });

                    $this.$wire.save()
                    $this.onWindowResize();
                });

            },
            initPlugin($this) {
                const apiRequestData = {
                    emailId: $this.email_id
                };

                const script = document.createElement('script');
                script.id = 'stripoScript';
                script.type = 'text/javascript';
                script.src = 'https://plugins.stripo.email/static/latest/stripo.js';
                script.onload = function () {
                    window.Stripo.init({
                        settingsId: 'stripoSettingsContainer',
                        previewId: 'stripoPreviewContainer',
                        codeEditorButtonId: 'codeEditor',
                        undoButtonId: 'undoButton',
                        redoButtonId: 'redoButton',
                        saveButtonId: 'btnSave',
                        locale: 'nl',
                        html: $this.stripo_html,
                        css: $this.stripo_css,
                        notifications: {
                            info: $this.notifications.info.bind($this.notifications),
                            error: $this.notifications.error.bind($this.notifications),
                            warn: $this.notifications.warn.bind($this.notifications),
                            loader: $this.notifications.loader.bind($this.notifications),
                            hide: $this.notifications.hide.bind($this.notifications),
                            success: $this.notifications.success.bind($this.notifications)
                        },
                        apiRequestData: apiRequestData,
                        userFullName: 'Sellvation',
                        versionHistory: {
                            changeHistoryLinkId: 'changeHistoryLink',
                            onInitialized: function (lastChangeIndoText) {
                                // $('#changeHistoryContainer').show();
                            }
                        },
                        getAuthToken: function (callback) {
                            callback($this.token);
                        }
                    });
                };
                document.body.appendChild(script);
            },
            throttle(func, wait) {
                let isThrottled = false,
                    savedArgs,
                    savedThis;

                function wrapper() {
                    if (isThrottled) {
                        savedArgs = arguments;

                        savedThis = this;
                        return;
                    }

                    func.apply(this, arguments);

                    isThrottled = true;

                    setTimeout(function () {
                        isThrottled = false;
                        if (savedArgs) {
                            wrapper.apply(savedThis, savedArgs);
                            savedArgs = savedThis = null;
                        }
                    }, wait);
                }

                return wrapper;
            },
            onWindowResize() {
                const previewContainer = document.getElementById('stripoPreviewContainer');
                previewContainer.style.height = window.innerHeight - 55 + 'px';
            },
        })
    );
});
