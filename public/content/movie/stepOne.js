$(function () {

    $('.showShows').on('click', function () {

        var showsClass = $(this).attr('showsClass');
        var active = $(this).attr('active');

        $x = $('.' + showsClass).toggle();

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

});