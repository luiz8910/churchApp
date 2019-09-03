$(function () {

    //instantiate a Pusher object with our Credential's key
    var pusher = new Pusher('9f86933032dbae833b7d', {

        encrypted: true
    });

    //Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('new-question');
    var like = pusher.subscribe('like');

    //Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\Question', function (data) {
        console.log(data);

        notif(data.question);
    });


    like.bind('App\\Events\\LikedQuestion', function (data) {
        console.log(data);

        new_like(data.question);
    });

    $(".btn-deny").click(function () {

        var id = this.id.replace('btn-deny-', '');

        denyQuestion(id);
    });

    $('.btn-approve').click(function () {

        var id = this.id.replace('btn-approve-', '');

        approveQuestion(id);
    });

});

function notif(data) {

    var options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    var text = data.content;
    var name = data.person_name;

    toastr.success(text, name, options);

    var prepend = '<tr class="dynamic-tr">' +
            '<td>' +
                '<a href="javascript:">'+
                    '<p>'+ name + '</p>'+
                 '</a>'+
            '</td>'+
            '<td style="max-width:400px;" id="td-text-'+data.id+'">'+text+'</td>'+
            '<td>' +
                '<a href="javascript:" class="btn btn-warning btn-sm btn-circle" title="Visualizar pergunta" onclick="view('+data.id+');"><i class="fa fa-eye"></i></a>'+
                '<button class="btn btn-success btn-sm btn-circle" title="Aprovar Pergunta" onclick="approveQuestion('+data.id+')"><i class="fa fa-thumbs-up"></i></button>'+
                '<button class="btn btn-danger btn-sm btn-circle" title="Reprovar Pergunta" onclick="denyQuestion('+data.id+')"><i class="fa fa-ban"></i></button>' +
            '</td>'+
        '</tr>';

    $('#tbody_pending').prepend(prepend);
}

function new_like(data)
{
    var options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr.success('Reorganizando as questões', 'Carregando nova lista', options);

    var shuffle = '<tr class="dynamic-tr" id="tr-question-'+data.id+'">' +
        '<td>' +
        '<a href="javascript:">'+
        '<p>'+ data.person_name + '</p>'+
        '</a>'+
        '</td>'+
        '<td style="max-width:400px;" id="td-text-'+data.id+'">'+data.content+'</td>'+
        '<td><span class="badge like-count" id="like-count-'+data.id+'">'+data.like_count+'</span></td>'+
        '<td>' +
        '<a href="javascript:" class="btn btn-warning btn-sm btn-circle" title="Visualizar pergunta" onclick="view('+data.id+');"><i class="fa fa-eye"></i></a>'+
        '<button class="btn btn-danger btn-sm btn-circle" title="Reprovar Pergunta" onclick="denyQuestion('+data.id+')"><i class="fa fa-ban"></i></button>' +
        '</td>'+
        '</tr>';

    var like_count = $(".like-count");
    var len_likes = like_count.length;


    for (var i = 0; i < len_likes; i++)
    {
        var id = like_count[i].id;

        var value = $("#"+id).text();

        var num_id = id.replace('like-count-', '');

        console.log("id: " + id);
        console.log("value: " + value);
        console.log("num_id: " + num_id);

        if(num_id == data.id)
        {
            $("#like-count-"+data.id).text(data.like_count);

            break;
        }
        else{
            if(value < data.like_count)
            {
                $("#tr-question-"+data.id).remove();

                //$(shuffle).insertBefore("#tr-question-"+num_id);
                $("#tr-question-"+num_id).before(shuffle);
            }
            else{
                $("#like-count-"+data.id).text(data.like_count);
            }
        }

    }
}

function view(id)
{
    var title = 'Nova Pergunta';

    $(".modal-title").text(title);

    var text = $("#td-text-" + id).text();

    $("#modal-padrao").modal('show');

    $("#modal-padrao-body p").text(text);
}

function approveQuestion(id)
{

    swal({
        title: 'Atenção!',
        text: 'Deseja aprovar esta questão?',
        type: 'info',
        showCancelButton: true,
        confirmButtonClass: 'btn-success',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: true,
        closeOnCancel: true

    }, function (isConfirm) {

        if(isConfirm)
        {
            var url = '/approve-question/';

            var msg = 'A questão foi aprovada';

            var method = 'PUT';

            var static_page = false;

            var data = null;

            Request(url, data, id, method, static_page, msg);
        }
    });

}

function denyQuestion(id)
{

    swal({
        title: 'Atenção!',
        text: 'Deseja negar esta questão?',
        type: 'info',
        showCancelButton: true,
        confirmButtonClass: 'btn-info',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: true,
        closeOnCancel: true

    }, function (isConfirm) {

        if(isConfirm)
        {
            var url = '/deny-question/';

            var msg = 'A questão foi reprovada';

            var method = 'PUT';

            var static_page = false;

            var data = null;

            Request(url, data, id, method, static_page, msg);
        }
    });


}
