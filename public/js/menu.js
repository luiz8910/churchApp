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

            var img, lastName = '', type = '';

            if (e.data[i].lastName != undefined && e.data[i].church_id != undefined) {

                lastName = e.data[i].lastName;

                img = e.data[i].imgProfile;

                if(img.search('uploads') != -1)
                {
                    img = '../../' + img;
                }

            }

            else if(e.data[i].church_id == undefined)
            {
                lastName = e.data[i].lastName;
                type = '(Visitante)';
            }

            else if (e.data[i].eventDate != undefined) {

                img = '../../' + e.data[i].imgEvent;
                type = '(Evento)'
            }

            else if (e.data[i].owner_id != undefined) {

                img = '../../' + e.data[i].imgProfile;
                type = '(Grupo)';
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
                        '<img src="'+img+'" alt="" class="img-rounded drop-pesquisar-img">'+
                        e.data[i].name + ' ' +lastName + ' ' +type
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