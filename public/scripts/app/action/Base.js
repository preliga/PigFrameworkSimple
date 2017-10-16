'use strict';
define(
    [
        '/scripts/lib/Pig/Action.js'
    ],
    function (Action) {
        return class Base extends Action{

            afterRender() {
                datePickerInit();
            }
        };

        function datePickerInit() {
            /**
             * Datepicker init
             */
            $('.datetimepicker').datetimepicker({
                format:'Y-m-d H:i'
            });
        }
    });