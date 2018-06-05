var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {  

            Dropzone.options.myDropzone = {
                dictDefaultMessage: "",
                autoProcessQueue: false,
                init: function() {
                    this.on("addedfile", function(file) {
                        console.log(file);
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remover</a>");
                        
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);

                        var stop = true;

                        var xls =  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                        var csv = 'application/vnd.ms-excel';

                        if(file.type != xls && file.type != csv)
                        {
                            var dot = file.name.lastIndexOf('.');

                            var slice = file.name.slice(dot);

                            if(slice != 'xls' && slice != 'xlsx' && slice != 'csv')
                            {
                                var text = 'Arquivos com a extensão ' + slice + ' não são permitidos';

                                $("#error-msg").click(function () {
                                    swal("Arquivo Inválido!", text, "info");
                                }).trigger('click');

                                _this.removeFile(file);
                            }

                        }else{
                            stop = false;
                        }


                        $("#my-dropzone").submit(function (e) {

                            e.preventDefault();
                            e.stopPropagation();

                            $("#btn-info-upload").css('display', 'none');

                            if(!stop)
                            {
                                $("#btn-dropzone").css('display', "none");
                                $(".progress").css("display", "block");

                                _this.processQueue();

                                setUploadStatus(file.name);

                                var i = 0;

                                var get = false;

                                var repeat = setInterval(function () {
                                    get = getUploadStatus(file.name);

                                    if(get)
                                    {
                                        clearInterval(repeat);
                                        //location.reload();
                                    }

                                }, 3000);


                                if(get)
                                {
                                    //location.reload();
                                }
                            }


                        });

                    });
                }            
            };


        }
    };
}();

jQuery(document).ready(function() {    
   FormDropzone.init();
});