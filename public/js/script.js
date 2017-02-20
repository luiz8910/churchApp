$(function () {

    member_id = '';
    member = '';
    members = [];




    $("#addMember").click(function () {

        member_id = $("#select_members").val();
        member = $("#select_members option:selected").text();

        if(members.length > 0){
            console.log(members.length);

            var result = true;

            for(var i = 0; i < members.length; i++)
            {
                if(members[i] == member_id)
                {
                    result = false;
                }
            }


            if(result){
                $("#table_name tbody").append("<tr id=tr-td-"+member_id+"></tr>");

                var $input = "<input hidden name=member-"+member_id+" id=memberInput-td-"+member_id+" value="+member_id+">";

                var tdDynamic = member;
                var tdId = "td-"+member_id;
                var $td = $("<td>", {
                    "id" : tdId
                }).html(tdDynamic).click(function () {
                    $("#tr-"+this.id).remove();
                    $("#memberInput-"+this.id).remove();
                    var index = members.indexOf(member_id);
                    members.splice(index, 1);
                });

                $("#tr-td-"+member_id).append($td);
                $("#hidden-input").append($input);
                members.push(member_id);
            }
        }

        else{
            $("#table_name tbody").append("<tr id=tr-td-"+member_id+"></tr>");

            var $input = "<input hidden name=member-"+member_id+" id=memberInput-td-"+member_id+" value="+member_id+">";

            var tdDynamic = member;
            var tdId = "td-"+member_id;
            var $td = $("<td>", {
                "id" : tdId
            }).html(tdDynamic).click(function () {
                $("#tr-"+this.id).remove();
                $("#memberInput-"+this.id).remove();
                var index = members.indexOf(member_id);
                members.splice(index, 1);
            });

            $("#tr-td-"+member_id).append($td);
            $("#hidden-input").append($input);
            members.push(member_id);
        }



    });

    $("#tr-td-"+member_id).find("td:first").trigger("click");



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
    
    $("#maritalStatus").change(function () {
        var status = $("#maritalStatus").val();

        if (status == 'Casado')
        {
            $("#form-partner").attr('hidden', false);
        }

        else
        {
            $("#form-partner").attr('hidden', true);
        }
    })


});
