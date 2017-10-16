'use strict';
define(
    [
        '/scripts/app/js/action/Base.js'
    ],
    function (Base) {
        return class stepOne extends Base {

            initAction() {
                // console.log("START");
            }

            afterRender() {
                super.afterRender();

                events();

            }
        };

        function events() {
            $('.showShows').on('click', function () {

                var showsClass = $(this).attr('showsClass');
                var active = $(this).attr('active');

                $('.' + showsClass).toggle();

                if (active === "1") {
                    $(this)
                        .attr('active', "0")
                        .removeClass('btn-success')
                        .addClass('btn-danger')
                    ;
                } else {
                    $(this)
                        .attr('active', "1")
                        .addClass('btn-success')
                        .removeClass('btn-danger')
                    ;
                }
            });
        };
    }
);