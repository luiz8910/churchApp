/**
 * Created by Luiz on 27/03/2017.
 */

$(function () {
    getScreenWidth();

    function getScreenWidth()
    {
        if(screen.width < 720)
        {
            $(".desktop-row").css("display", "none");
            $(".mobile").css("display", "block");
        }
        else{
            $(".desktop-row").css("display", "block");
            $(".mobile").css("display", "none");
        }

    }
});
