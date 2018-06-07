

function setUploadStatus(name) {
    var request = $.ajax({
        url: '/setUploadStatus/' + name,
        method: 'GET',
        dataType: 'json',
        async: false
    });

    request.done(function (e) {
        console.log('setStatus');
    });

    request.fail(function (e) {
        console.log("fail");
        console.log(e);

        return false;
    });

    return true;
}

function getUploadStatus(name) {
    var request = $.ajax({
        url: '/getUploadStatus/' + name,
        method: 'GET',
        dataType: 'json',
        async: false
    });

    var status = false;

    request.done(function (e) {
        console.log('getStatus: ' + e.status);

        //Função para exibir quantidade cadastrada
        if (e.status) {
            window.localStorage.setItem('qtde', e.qtde);
        }

        status = e.status;

    });

    request.fail(function (e) {
        console.log("fail");
        console.log(e);
    });

    return status;

}