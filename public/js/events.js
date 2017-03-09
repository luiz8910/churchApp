/**
 * Created by Luiz on 08/03/2017.
 */

$(function () {

    $.getJSON("js/events.json", function(json) {

        console.log(json);

        $("#agenda").fullCalendar({
            eventSources: [
                {
                    events: json
                }
            ]
        })
    });

});