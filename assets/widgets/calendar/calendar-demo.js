$(document).ready(function() {
    $("#calendar-example-1").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        defaultDate: "2014-01-12",
        editable: !0,
        events: [{
            title: "All Day Event",
            start: "2014-01-01"
        }, {
            title: "Long Event",
            start: "2014-01-07",
            end: "2014-01-10"
        }, {
            id: 999,
            title: "Repeating Event",
            start: "2014-01-09T16:00:00"
        }, {
            id: 999,
            title: "Repeating Event",
            start: "2014-01-16T16:00:00"
        }, {
            title: "Meeting",
            start: "2014-01-12T10:30:00",
            end: "2014-01-12T12:30:00"
        }, {
            title: "Lunch",
            start: "2014-01-12T12:00:00"
        }, {
            title: "Birthday Party",
            start: "2014-01-13T07:00:00"
        }, {
            title: "Click for Google",
            url: "http://google.com/",
            start: "2014-01-28"
        }]
    }), $("#external-events div.external-event").each(function() {
        var a = {
            title: $.trim($(this).text())
        };
        $(this).data("eventObject", a), $(this).draggable({
            zIndex: 999,
            revert: !0,
            revertDuration: 0
        })
    }), $("#calendar-example-2").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        editable: !0,
        droppable: !0,
        drop: function(a) {
            var b = $(this).data("eventObject"),
                c = $.extend({}, b);
            c.start = a, $("#calendar-example-2").fullCalendar("renderEvent", c, !0), $("#drop-remove").is(":checked") && $(this).remove()
        }
    })
});