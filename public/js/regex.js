$(function () {

    $(".money").keyup(function (e) {

        if (e.which != 8 && e.which != 0 && e.which != 44 && e.which != 45 && (e.which < 48 || e.which > 58)) {

            money(this.value, this.id);
        }

    }).change(function () {

        if(this.value.search(',') == -1)
        {
            $("#"+this.id).val(this.value + ',00');
        }
    });

    $(".number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 58)) {

            return false;
        }
    });

});

/*
 * Usado para verificar se o campo
 * tem um valor monetário válido
 */
function money(value, id)
{

    if(isNaN(value))
    {
        if(value != '-')
        {
            var length = value.length;

            var last_char = value.charAt(length - 1);

            if(last_char != ',' || (value.indexOf(',') != value.lastIndexOf(',')))
            {
                var new_value = value.replace(last_char, '');

                $("#"+id).val(new_value);
            }

        }

    }
}
