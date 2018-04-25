

$(".approve").click(function(){

    var id = this.id.replace('approve-', '');

    approveUser(id);
});

$("#deny").click(function(){

    var name = $("#deny-name").val();

    var email = $("#deny-email").val();

    var personId = $("#personId").val();

    deny(name, email, personId);

});


$(".btn-details").click(function(){

    var id = this.id.replace('btn-details-', '');

    denyDetails(id);
});





