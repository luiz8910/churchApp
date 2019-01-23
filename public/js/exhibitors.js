$(function () {

    $("#modal_NewCat").click(function () {
        $("#new_cat").modal('show');
    });

    $("#modal_list_cat").click(function () {
        $("#list_cat").modal('show');
    });

});


function addResponsible(name)
{
    var fields = $(".form-control");

    var stop = false;

    for(var i = 0; i < fields.length; i++)
    {
        if(fields[i].required)
        {
            if(fields[i].value == "")
            {
                stop = true;

                break;
            }
        }
    }

    if(!stop)
    {
        var input = '<input type="hidden" name="'+name+'" value="1">';

        $("#div-responsible").append(input);
    }

    $("#form").submit(function () {

    });

}

