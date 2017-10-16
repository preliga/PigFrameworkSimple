'use strict';
define(
    [
        mainAction
    ],
    function (Action) {

        function ready(fn) {
            if (document.readyState !== 'loading') {
                fn();
            } else if (document.addEventListener) {
                document.addEventListener('DOMContentLoaded', fn);
            } else {
                document.attachEvent('onreadystatechange', function () {
                    if (document.readyState !== 'loading') {
                        fn();
                    }
                });
            }
        }

        return class Router {
            constructor() {
            }

            route() {
                var action = new Action();

                action.initAction();
                action.beforeRender();

                ready(action.afterRender);
            }
        };
    }
);