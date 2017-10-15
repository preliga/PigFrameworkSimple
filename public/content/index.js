// import Action from '/scripts/lib/Pig/Action.js'

define(function (require) {

    var Action = require('/scripts/lib/Pig/Action.js');

    class index extends Action{

        initAction() {
            console.log("START");
        }
    }

    return index;
});