'use strict';
define(
    [
        '/scripts/app/js/action/Base.js'
    ],
    function (Base) {
        return class fullCalendar extends Base {

            initAction() {
                // console.log("START");
            }

            afterRender() {
                super.afterRender();

                $.ajax({
                    url: "/calendarTest/events?json=true",
                })
                    .done(function (response) {
                        fullCalendarInit(response.data.events);
                    });


            }
        };

        function fullCalendarInit(events) {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today add',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '2017-11-12',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: events,
                // dayClick: function (date, jsEvent, view) {
                //     console.log(date, jsEvent, view);
                // },
                // eventClick: function (date, jsEvent, view) {
                //     console.log(date, jsEvent, view);
                // }
                // eventChange: function (date, jsEvent, view) {
                //     console.log(date, jsEvent, view);
                // }
                customButtons: {
                    add: {
                        text: '+',
                        click: function() {
                            // alert('clicked the custom button!');
                            $('#calendar').fullCalendar('renderEvent', {
                                id: 123,
                                title: 'All Day Event123',
                                start: '2017-11-02'
                            });
                        }
                    }
                },
                eventDrop: function (date, jsEvent, view) {
                    // console.log(date, jsEvent, view);
                    console.log(date.id);
                    console.log(date.title);
                }
            });

            console.log(test);

            $('#calendar').fullCalendar('removeEvents', 999);

            // test.fullCalendar( 'removeEvents' [999 ] );

            // $('#calendar').fullCalendar('renderEvent', {
            //     id: 123,
            //     title: 'All Day Event123',
            //     start: '2017-11-02'
            // });

            // $('#calendar').fullCalendar('refretshEvents');
        };
    }
);