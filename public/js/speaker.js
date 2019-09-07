$(function () {

    $("#country").select2({
        templateResult: formatState
    });

    selected_country();
});

function selected_country()
{
    var country = $("#input_country").val();
    var text;

    if(country)
    {
        $("#country option").each(function (index) {

            text = $(this).text();

            if(country == text)
            {
                $("#country option[value|='"+text+"']").attr('selected', true);

                $("#select2-country-container").text(country).attr('title', country);

                return false;
            }
        });
    }
}


function formatState (state)
{

    if (!state.id) {
        return state.text;
    }

    var $state = $(
        '<span class="span-flag"><img src="../../images/countries/'+state.text+'.png" class="" /> '+state.text+'</span>'
    );

    return $state;
}
