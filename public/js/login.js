

$(function () {

    var original_fb_href = $(".facebook").attr("href");
    var original_goo_href = $(".googleplus").attr("href");

    $("#church").change(function () {
        var value = this.value;
        var fb = $(".facebook").attr("href");
        var goo = $(".googleplus").attr("href");

        if(value == "")
        {
            $(".facebook")
                .attr("href", original_fb_href);

            $(".googleplus")
                .attr("href", original_goo_href);
        }
        else{
            $(".facebook")
                .attr("href", fb + '/' + value);

            $(".googleplus")
                .attr("href", goo + '/' + value);
        }


    });

    $(".facebook").click(function () {
        var church = $("#church").val();

        if(church == "")
        {
            event.preventDefault();
            $("#selectChurch").css("display", "block");
        }

    });

    $(".googleplus").click(function () {
        var church = $("#church").val();

        if(church == "")
        {
            event.preventDefault();
            $("#selectChurch").css("display", "block");
        }

    });

});