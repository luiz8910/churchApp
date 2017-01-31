$(function () {


    var selectedMember = '';

    //$('button').click(function (){
      // alert('botao');
    //});

    $("#addMember").click(function () {

        var member_id = $("#select_members").val();
        var member = $("#select_members option:selected").text();


        $("#table_name tbody").append(
              "<tr id=tr-"+member_id+">"+
                "<td>"+member_id+"</td>"+
                "<td>"+member+"</td>"+
                "<td><button type=button id=deleteMember-"+member_id+" class='btn btn-danger btn-sm'>Excluir</button></td>"+
              "</tr>"

        );
    });//"<input hidden name=member-"+member_id+" value="+member_id+">"

    $("#deleteMember-1").click(function () {

        $("#tr-1").remove();
    });

    $("#deleteMember-1").on("click", function(){
        alert('aqui');
    });


    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#img").attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

        }
    }



    $("#file-upload").change(function(){

        readURL(this);

        $("#table tbody").append('<tr>'+
            '<td>'+
            '<a href="#" class="fancybox-button" data-rel="fancybox-button">'+
            '<img class="img-responsive" src="#" name="img" id="img" style="width: 150px; height: 150px;"> </a>'+
            '<a href="javascript:;" class="btn btn-default btn-md" style="width: 150px;">'+
            '<i class="fa fa-times"></i> Remover </a>'+
            '</td>'+
            '</tr>');

    });
});
