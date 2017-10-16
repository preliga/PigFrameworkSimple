'use strict';
define(
    [
        './Router.js'
    ],
    function (Router) {

        return class App {
            constructor() {

            }

            run() {
                var router = new Router();
                router.route();
            }
        };
    }
);