$(function () {

    var selectedMember = '';

    $("#select_name").change(function () {
        $("#select_name button:selected").each(function () {
            selectedMember = $( this ).id;
        })
    }).trigger('change');

    $("#select_name a").click(function () {
        selectedMember = $( this ).text();
        alert(selectedMember);
    });

    $("#addMember").click(function () {

        var member_id = $("#select_members").val();
        var member = $("#select_members option:selected").text();

        $("#select_name").append(
            "<a href=javascript:; class=list-group-item id=member-"+member_id+">"+member+"</a>"+
            "<input hidden name=member-"+member_id+" value="+member_id+">"
        );
    });

    $("#deleteMember").click(function () {
        $("#select_name a[id=member-"+selectedMember+"]").remove();
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
