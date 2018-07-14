$(function(){

   $(".btn-edit").click(function(){

       var id = this.id.replace('btn-edit-', '');

       editChurch(id);


   });


    $(".btn-activate").click(function(){

        var id = this.id.replace('btn-activate-', '');

        activateChurch(id)
    });

    $(".btn-full-activate").click(function(){

        var id = this.id.replace('btn-full-activate-', '');

        fullActivateChurch(id);
    })


    setRequiredFields();
});


function fullActivateChurch(id)
{

    var url = '/full-activate-church/';

    swal({
            title: "Deseja Ativar esta igreja?",
            text: '',
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim, Ativar!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(isConfirm){
            if(isConfirm)
            {
                Request(url, null, id);
            }

        });
}


function activateChurch(id)
{
    var url = '/activate-church/';

    swal({
            title: "Deseja Ativar esta igreja?",
            text: '',
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim, Ativar!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(isConfirm){
            if(isConfirm)
            {
                Request(url, null, id);
            }

        });


}

function clearFields()
{
    $(".form-control").val("");
}

function closeForm()
{
    clearFields();

    $("#new-church").css("display", "none");
}

function openForm()
{
    $("#new-church").css("display", "block");

    $("#name").focus();

    $('html, body').animate({
        scrollTop: $("#new-church").offset().top
    }, 2000);
}

function setRequiredFields()
{
    $("#street").attr('required', true);
    $("#number").attr('required', true);
    $("#city").attr('required', true);
    $("#state").attr('required', true);
}


function editChurch(id)
{
    var url = '/edit-church/';

    var request = $.ajax({
        url: url + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function(e){

        if(e.status)
        {
            //Igreja

            console.log(e.church);

            var name = e.church.name;

            var alias = e.church.alias;

            var tel = e.church.tel;

            var cnpj = e.church.cnpj;

            var zipcode = e.church.zipCode;

            var street = e.church.street;

            var number = e.church.number;

            var neighborhood = e.church.neighborhood;

            var city = e.church.city;

            var state = e.church.state;

            $("#church_name").val(name);

            $("#church_alias").val(alias);

            $("#phone").val(tel);

            $("#cnpj").val(cnpj);

            $("#zipCode-2").val(zipcode);

            $("#street-2").val(street);

            $("#number-2").val(number);

            $("#neighborhood-2").val(neighborhood);

            $("#city-2").val(city);

            $("#state-2").val(state);

            //Responsável

            name = e.responsible.name;

            var lastName = e.responsible.lastName;

            var email = e.responsible.email;

            var cel = e.person.cel;

            var dateBirth = e.person.dateBirth;

            var cpf = e.person.cpf;

            var gender = e.person.gender;

            var marital_status = e.person.maritalStatus;

            var imgProfile = '';

            if(e.person.imgProfile.search('uploads') != -1)
            {
                imgProfile = '../../' + e.person.imgProfile;
            }
            else{
                imgProfile = e.person.imgProfile;
            }

            zipcode = e.person.zipCode;

            street = e.person.street;

            neighborhood = e.person.neighborhood;

            number = e.person.number;

            city = e.person.city;

            state = e.person.state;

            $("#name_resp").val(name).attr('disabled', true);

            $("#lastname_resp").val(lastName).attr('disabled', true);

            $("#email-resp").val(email);

            $("#cel").val(cel).attr('disabled', true);

            $("#dateBirth").val(dateBirth).attr('disabled', true);

            $("#cpf").val(cpf).attr('disabled', true);

            $("#gender").val(gender).attr('disabled', true);

            $("#maritalStatus").val(marital_status).attr('disabled', true);

            $("#img-resp").attr('src', imgProfile);

            $("#zipCode").val(zipcode).attr('disabled', true);

            $("#street").val(street).attr('disabled', true);

            $("#neighborhood").val(neighborhood).attr('disabled', true);

            $("#number").val(number).attr('disabled', true);

            $("#city").val(city).attr('disabled', true);

            $("#state").val(state).attr('disabled', true);

            $("#form-edit").attr('action', 'update-church/' + e.church.id);

            $("#edit-modal").modal('show');
        }
    });

    request.fail(function(e){
        console.log('fail');
        console.log(e);
    });

}