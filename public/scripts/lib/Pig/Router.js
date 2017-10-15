'use strict';
define(function (require) {
    class Router {
        constructor() {
        }

        route(require) {

            const file = view.file + '.js';
            // console.log(file);


            // requirejs([file]);
            // requirejs(['index']);
            let Action = require(file);

            let action = new Action();
            //
            action.initAction();
            action.initObjects();
            action.events();
        }
    }

    return Router;
});