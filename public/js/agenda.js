/**
 * Created by Luiz on 30/03/2017.
 */

$(function () {

    //$("a").attr("rel", "external");

    //Desktop
    var dialog = 0;

    $(".btn-options").click(function () {
        var str = this.id;

        var id = str.replace("btn-options-", "");

        $("#bubble-"+id).css("display", "inline-block");

        if(dialog != 0)
        {
            $("#bubble-"+dialog).css("display", "none");
        }

        dialog = id;
    }).focusout(function () {
        $("#bubble-"+dialog).css("display", "none");

        dialog = 0;
    });


    $(".lbl-opacity").click(function(){
        $(".caption-subject span").addClass("lbl-opacity");
        $(this).removeClass("lbl-opacity");
        hideEvents(this.id);
    });

    /*ID do campo que contém
    frequência de exibição desejada*/
    function hideEvents(id)
    {
        var frequencies = [
            'Diário', 'Semanal', 'Mensal', 'Encontro-Único'
        ];

        var i = 0;


        if(id == "daily")
        {
            while(i < 4)
            {
                if(frequencies[i] != "Diário")
                {
                    $("."+frequencies[i]).css("display", "none");
                }

                i++;
            }

            $(".Diário").css("display", "block");

        }

        else if(id == "weekly"){
            while(i < 4)
            {
                if(frequencies[i] != "Semanal")
                {
                    $("."+frequencies[i]).css("display", "none");
                }

                i++;
            }

            $(".Semanal").css("display", "block");
        }

        else if(id == "monthly"){
            while(i < 4)
            {
                if(frequencies[i] != "Mensal")
                {
                    $("."+frequencies[i]).css("display", "none");
                }

                i++;
            }

            $(".Mensal").css("display", "block");
        }

        else if(id == "singleEvent"){
            while(i < 4)
            {
                if(frequencies[i] != "Encontro-Único")
                {
                    $("."+frequencies[i]).css("display", "none");
                }

                i++;
            }

            $(".Encontro-Único").css("display", "block");
        }
        else{
            while(i < 4)
            {
                $("."+frequencies[i]).css("display", "block");

                i++;
            }
        }

        i = 0;
    }

/*
$("#btnPrevRight6").click(function () {
    $("#prevMonth6").css("display", "none");
    $("#prevMonth5").css("display", "block");
});

$("#btnPrevRight5").click(function () {
    $("#prevMonth5").css("display", "none");
    $("#prevMonth4").css("display", "block");
});

$("#btnPrevLeft5").click(function () {
    $("#prevMonth5").css("display", "none");
    $("#prevMonth6").css("display", "block");
});

$("#btnPrevRight4").click(function () {
    $("#prevMonth4").css("display", "none");
    $("#prevMonth3").css("display", "block");
});

$("#btnPrevLeft4").click(function () {
    $("#prevMonth4").css("display", "none");
    $("#prevMonth5").css("display", "block");
});

$("#btnPrevRight3").click(function () {
    $("#prevMonth3").css("display", "none");
    $("#prevMonth2").css("display", "block");
});

$("#btnPrevLeft3").click(function () {
    $("#prevMonth3").css("display", "none");
    $("#prevMonth4").css("display", "block");
});

$("#btnPrevRight2").click(function () {
    $("#prevMonth2").css("display", "none");
    $("#prevMonth").css("display", "block");
});

$("#btnPrevLeft2").click(function () {
    $("#prevMonth2").css("display", "none");
    $("#prevMonth3").css("display", "block");
});

$("#btnPrevRight").click(function () {
    $("#prevMonth").css("display", "none");
    $("#thisMonth").css("display", "block");
});

$("#btnPrevLeft").click(function () {
    $("#prevMonth").css("display", "none");
    $("#prevMonth2").css("display", "block");
});

$("#btnThisLeft").click(function () {
    $("#thisMonth").css("display", "none");
    $("#prevMonth").css("display", "block");
});

$("#btnThisRight").click(function () {
    $("#thisMonth").css("display", "none");
    $("#nextMonth").css("display", "block");
});

$("#btnNextRight").click(function () {
    $("#nextMonth").css("display", "none");
    $("#nextMonth2").css("display", "block");
});

$("#btnNextLeft").click(function () {
    $("#nextMonth").css("display", "none");
    $("#thisMonth").css("display", "block");
});

$("#btnNextRight2").click(function () {
    $("#nextMonth2").css("display", "none");
    $("#nextMonth3").css("display", "block");
});

$("#btnNextLeft2").click(function () {
    $("#nextMonth2").css("display", "none");
    $("#nextMonth").css("display", "block");
});

$("#btnNextRight3").click(function () {
    $("#nextMonth3").css("display", "none");
    $("#nextMonth4").css("display", "block");
});

$("#btnNextLeft3").click(function () {
    $("#nextMonth3").css("display", "none");
    $("#nextMonth2").css("display", "block");
});

$("#btnNextRight4").click(function () {
    $("#nextMonth4").css("display", "none");
    $("#nextMonth5").css("display", "block");
});

$("#btnNextLeft4").click(function () {
    $("#nextMonth4").css("display", "none");
    $("#nextMonth3").css("display", "block");
});

$("#btnNextRight5").click(function () {
    $("#nextMonth5").css("display", "none");
    $("#nextMonth6").css("display", "block");
});

$("#btnNextLeft5").click(function () {
    $("#nextMonth5").css("display", "none");
    $("#nextMonth4").css("display", "block");
});

$("#btnNextLeft6").click(function () {
    $("#nextMonth6").css("display", "none");
    $("#nextMonth5").css("display", "block");
});

//Mobile

$("#agenda-mobile").on("swipeleft", function () {
    $("#agenda-mobile").addClass('visuallyhidden');

    $("#agenda-mobile").one('transitionend', function(e) {

        $("#agenda-mobile").addClass('hidden');

    });

    $("#nextMonth-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#agenda-mobile").on("swiperight", function () {
    $("#agenda-mobile").addClass('visuallyhidden');

    $("#agenda-mobile").one('transitionend', function(e) {

        $("#agenda-mobile").addClass('hidden');

    });

    $("#prevMonth-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth-mobile").on("swiperight", function () {
    $("#nextMonth-mobile").addClass('visuallyhidden');

    $("#nextMonth-mobile").one('transitionend', function(e) {

        $("#nextMonth-mobile").addClass('hidden');

    });

    $("#agenda-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#agenda-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth-mobile").on("swipeleft", function () {
    $("#nextMonth-mobile").addClass('visuallyhidden');

    $("#nextMonth-mobile").one('transitionend', function(e) {

        $("#nextMonth-mobile").addClass('hidden');

    });

    $("#nextMonth2-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth2-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);

});

$("#nextMonth2-mobile").on("swiperight", function () {
    $("#nextMonth2-mobile").addClass('visuallyhidden');

    $("#nextMonth2-mobile").one('transitionend', function(e) {

        $("#nextMonth2-mobile").addClass('hidden');

    });

    $("#nextMonth-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth2-mobile").on("swipeleft", function () {
    $("#nextMonth2-mobile").addClass('visuallyhidden');

    $("#nextMonth2-mobile").one('transitionend', function(e) {

        $("#nextMonth2-mobile").addClass('hidden');

    });

    $("#nextMonth3-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth3-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth3-mobile").on("swiperight", function () {
    $("#nextMonth3-mobile").addClass('visuallyhidden');

    $("#nextMonth3-mobile").one('transitionend', function(e) {

        $("#nextMonth3-mobile").addClass('hidden');

    });

    $("#nextMonth2-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth2-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth3-mobile").on("swipeleft", function () {
    $("#nextMonth3-mobile").addClass('visuallyhidden');

    $("#nextMonth3-mobile").one('transitionend', function(e) {

        $("#nextMonth3-mobile").addClass('hidden');

    });

    $("#nextMonth4-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth4-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth4-mobile").on("swiperight", function () {
    $("#nextMonth4-mobile").addClass('visuallyhidden');

    $("#nextMonth4-mobile").one('transitionend', function(e) {

        $("#nextMonth4-mobile").addClass('hidden');

    });

    $("#nextMonth3-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth3-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth4-mobile").on("swipeleft", function () {
    $("#nextMonth4-mobile").addClass('visuallyhidden');

    $("#nextMonth4-mobile").one('transitionend', function(e) {

        $("#nextMonth4-mobile").addClass('hidden');

    });

    $("#nextMonth5-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth5-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth5-mobile").on("swiperight", function () {
    $("#nextMonth5-mobile").addClass('visuallyhidden');

    $("#nextMonth5-mobile").one('transitionend', function(e) {

        $("#nextMonth5-mobile").addClass('hidden');

    });

    $("#nextMonth4-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth4-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth5-mobile").on("swipeleft", function () {
    $("#nextMonth5-mobile").addClass('visuallyhidden');

    $("#nextMonth5-mobile").one('transitionend', function(e) {

        $("#nextMonth5-mobile").addClass('hidden');

    });

    $("#nextMonth6-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth6-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#nextMonth6-mobile").on("swiperight", function () {
    $("#nextMonth6-mobile").addClass('visuallyhidden');

    $("#nextMonth6-mobile").one('transitionend', function(e) {

        $("#nextMonth6-mobile").addClass('hidden');

    });

    $("#nextMonth5-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#nextMonth5-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth-mobile").on("swiperight", function () {
    $("#prevMonth-mobile").addClass('visuallyhidden');

    $("#prevMonth-mobile").one('transitionend', function(e) {

        $("#prevMonth-mobile").addClass('hidden');

    });

    $("#prevMonth2-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth2-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth-mobile").on("swipeleft", function () {
    $("#prevMonth-mobile").addClass('visuallyhidden');

    $("#prevMonth-mobile").one('transitionend', function(e) {

        $("#prevMonth-mobile").addClass('hidden');

    });

    $("#agenda-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#agenda-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth2-mobile").on("swiperight", function () {
    $("#prevMonth2-mobile").addClass('visuallyhidden');

    $("#prevMonth2-mobile").one('transitionend', function(e) {

        $("#prevMonth2-mobile").addClass('hidden');

    });

    $("#prevMonth3-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth3-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth2-mobile").on("swipeleft", function () {
    $("#prevMonth2-mobile").addClass('visuallyhidden');

    $("#prevMonth2-mobile").one('transitionend', function(e) {

        $("#prevMonth2-mobile").addClass('hidden');

    });

    $("#prevMonth-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth3-mobile").on("swiperight", function () {
    $("#prevMonth3-mobile").addClass('visuallyhidden');

    $("#prevMonth3-mobile").one('transitionend', function(e) {

        $("#prevMonth3-mobile").addClass('hidden');

    });

    $("#prevMonth4-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth4-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth3-mobile").on("swipeleft", function () {
    $("#prevMonth3-mobile").addClass('visuallyhidden');

    $("#prevMonth3-mobile").one('transitionend', function(e) {

        $("#prevMonth3-mobile").addClass('hidden');

    });

    $("#prevMonth2-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth2-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth4-mobile").on("swiperight", function () {
    $("#prevMonth4-mobile").addClass('visuallyhidden');

    $("#prevMonth4-mobile").one('transitionend', function(e) {

        $("#prevMonth4-mobile").addClass('hidden');

    });

    $("#prevMonth5-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth5-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth4-mobile").on("swipeleft", function () {
    $("#prevMonth4-mobile").addClass('visuallyhidden');

    $("#prevMonth4-mobile").one('transitionend', function(e) {

        $("#prevMonth4-mobile").addClass('hidden');

    });

    $("#prevMonth3-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth3-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth5-mobile").on("swiperight", function () {
    $("#prevMonth5-mobile").addClass('visuallyhidden');

    $("#prevMonth5-mobile").one('transitionend', function(e) {

        $("#prevMonth5-mobile").addClass('hidden');

    });

    $("#prevMonth6-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth6-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth5-mobile").on("swipeleft", function () {
    $("#prevMonth5-mobile").addClass('visuallyhidden');

    $("#prevMonth5-mobile").one('transitionend', function(e) {

        $("#prevMonth5-mobile").addClass('hidden');

    });

    $("#prevMonth4-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth4-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

$("#prevMonth6-mobile").on("swipeleft", function () {
    $("#prevMonth6-mobile").addClass('visuallyhidden');

    $("#prevMonth6-mobile").one('transitionend', function(e) {

        $("#prevMonth6-mobile").addClass('hidden');

    });

    $("#prevMonth5-mobile").removeClass('hidden');
    setTimeout(function () {
        $("#prevMonth5-mobile").removeClass('visuallyhidden').css("display", "block");
    }, 500);


});

*/
});