$("#search-results").keyup(function () {

    if (this.value == "") {
        $("#results").css("display", "none");
        $("#results li").remove();
    }
    else {

        if (this.value.length > 2) {
            $("#results").css("display", "block");
            search(this.value);
        }

    }

}).focusout(function () {
    setTimeout(function () {
        $("#results").css("display", "none");
    }, 500);
}).focus(function () {
    $("#results").css("display", "block");
});


function search(text) {
    var request = $.ajax({
        url: "/search/" + text,
        method: "GET",
        dataType: "json"
    });

    request.done(function (e) {

        var ul = $("#results");


        //Limite de 5 resultados

        for (var i = 0; i < 5; i++) {
            if (i == 0) {
                $("#results li").remove();
            }

            var model, icon;

            if (e.data[i].lastName != undefined) {
                model = "person";
                icon = "user";
            }

            else if (e.data[i].eventDate != undefined) {
                model = "events";
                icon = "calendar";
            }

            else if (e.data[i].owner_id != undefined) {
                model = "group";
                icon = "users";
            }


            /*var li =
                '<li>' +
                '<a href="/' + model + '/' + e[i].id + '/edit" class="drop-pesquisar-a">' +
                '<i class="fa fa-' + icon + ' drop-pesquisa-i fa-lg"></i>' +
                e[i].name
                + '</a>' +
                '</li>';*/

            var li = '<li class="">'+
                    '<a href="/'+ e.data[i].model+'/'+ e.data[i].id+'/edit" class="drop-pesquisar-a">'+
                        '<img src="../teste/avatar9.jpg" alt="" class="img-rounded drop-pesquisar-img">'+
                        e.data[i].name
                    +'</a></li>';

            console.log(li);

            ul.append(li);
        }

    });

    /*<li class="">
     <a href="#" class="drop-pesquisar-a">
     <i class="icon-bar-chart drop-pesquisa-i fa-lg"></i>
     Grupo de Jovens

     </a>
     </li>*/

    request.fail(function (e) {
        console.log("fail");
        console.log(e);
    })
}