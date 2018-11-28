$(function(){

    $("#btn-search").change(function () {

        if(this.value.length > 2)
        {
            generalSearchInput(this.value);
        }
    });

});


function generalSearchInput(input)
{

    var table = $("#table").val();

    var route = location.pathname + '/';

    var request = $.ajax({
        url: '/general-search/' + input + '/' + table,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if (e.status) {

            console.log(e.data);

            var i = 0;

            var tr = '';

            //arr = [e.select[1]];

            while (i < e.data.length) {

                tr += '<tr>' +
                    '<td>' +
                    '<img src="' + e.data[i + 1] + '" class="imgProfile img-circle">' +
                    '</td>' +
                    '<td><a href="' + route + e.data[i] + '/edit">' + e.data[i + 2] + '</a></td>' +
                    '<td>' + e.data[i + 2] + '</td>' +
                    '<td>' + e.data[i + 3] + '</td>' +
                    '<td>' + e.data[i + 4] + '</td>' +
                    '<td>' + e.data[i + 5] + '</td>' +
                    '<td>' +
                    '<button class="btn btn-danger btn-sm btn-circle" title="Deseja Excluir o Membro"' +
                    'onclick="sweetDeleteUser(' + e.data[i] + ')"' +
                    'id="btn-delete-' + e.data[i] + '">' +
                    '<i class="fa fa-trash"></i>' +
                    '<span class="hidden-xs hidden-sm"> Inativar</span>' +
                    '</button>' +
                    '</td>' +
                    '</tr>';

                i = i + e.select.length;
            }

            $("#loading-results").css('display', 'none');

            $("thead").css('display', 'table-header-group');

            $("#tbody-search").removeClass('hide').append(tr);
        }
        else {
            $("#loading-results").css('display', 'none');
            $("#p-zero").css('display', 'block');
        }
    });



}