
$(function () {

    $(".btn-edit-resp").click(function () {

        var id = this.id.replace('btn-edit-resp-', "");

        var form = $("#form-edit");

        var url = 'http://' + location.host;

        form.attr('action', url + '/responsible-update/' + id);

        getRespData(id);
    })


});


function getRespData(id)
{
    var request = $.ajax({
        url: 'get-resp-data/' + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            $("#abbreviation").val(e.abbreviation);

            $("#name").val(e.name);

            $("#special_role").val(e.special_role);

            $("#role_id").val(e.role_id);
        }
        else{

            swal('Atenção', 'Verifique sua conexão com a Internet', 'error');
        }
    });

    request.fail(function (e) {
        swal('Atenção', 'Verifique sua conexão com a Internet', 'error');
        console.log('fail');
        console.log(e);
    })
}
