var route = location.pathname;

function loopHeader(header)
{
    var result = "";

    for(var i = 0; i < header.length; i++)
    {
        result += '<th>'+header[i]+'</th>';
    }

    return result;

}

function text()
{
    console.log(route);

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

function loopContent()
{

    var result = "";


    var request = $.ajax({
        url: route+"-ajax",
        method: "GET",
        dataType: "json",
        async: false
    });

    request.done(function(e){
        //console.log(e);

        for(var i = 0; i < e.length; i++)
        {
            if(e[i].group_id == null)
            {
                e[i].group_id = "Sem Grupo";
            }

            result +=   '<tr>' +
                '<td>'+e[i].name+'</td>'+
                '<td>'+e[i].frequency+'</td>'+
                '<td>'+e[i].createdBy_id+'</td>'+
                '<td>'+e[i].group_id+'</td>'+
                '</tr>';
        }

    });

    request.fail(function(e){
        console.log("fail");
        console.log(e);
    });


    return result;
}

function printDiv(div, pdf) {

    pdf = pdf || null;

    var originalContents = document.body.innerHTML;

    var header = [];
    var check = [];

    $( "."+div+'-header' ).each(function( index ) {
        header[index] = $( this ).text() ;
    });


    $(".check-model").each(function ( index ){
        check[index] = $( this ).val();
    });


    if(pdf)
    {
        text();

        $.getJSON("js/print.json", function ( data ) {
            pdfMake.createPdf(data).open();
        });

    }else{
        var table = '<table class="table table-bordered">' +
            '<thead>' +
            ''+loopHeader(header)+''+
            '</thead>' +
            '<tbody>'+
            ''+loopContent()+''+
            '</tbody>'+
            '</table>';

        document.body.innerHTML = table;
        window.print();
    }

    document.body.innerHTML = originalContents;
}

