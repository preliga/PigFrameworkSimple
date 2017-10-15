'use strict';
define(function (require) {
    class App {
        constructor() {

        }

        run() {
            let Router = require('./Router.js');
            let router = new Router();
            router.route(require);
        }
    }

    return App;
});