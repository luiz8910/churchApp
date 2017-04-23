var route = location.pathname;


function text()
{
    var request = $.ajax({
        url: route+"-ajax",
        method: "GET",
        dataType: "json",
        async: false
    });

    request.done(function(e){
        console.log("done");
        console.log(e);
    });

    request.fail(function(e){
        console.log("fail");
        console.log(e);
    });
}

function printDiv(div, pdf) {

    text();

    $.getJSON("js/print.json", function ( data ) {
        pdfMake.createPdf(data).open();
    });
}