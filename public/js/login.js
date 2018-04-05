

$(function () {

    var original_fb_href = $(".facebook").attr("href");
    var original_goo_href = $(".googleplus").attr("href");

    $("#church").change(function () {
        var value = this.value;

        if(value == "")
        {
            $(".facebook")
                .attr("href", original_fb_href);

            $(".googleplus")
                .attr("href", original_goo_href);
        }
        else{
            $(".facebook")
                .attr("href", original_fb_href + '/' + value);

            $(".googleplus")
                .attr("href", original_goo_href + '/' + value);
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

    $("#church").change(function () {
        var data = this.value;

        setCookie(data);
    });

    function setCookie(data)
    {
        window.localStorage.setItem('church-cookie', data);
    }

    function getCookie()
    {
        var cookie = window.localStorage.getItem('church-cookie');

        if(cookie)
        {
            $("#church").val(cookie).trigger('change');
        }
    }

    getCookie();

});

