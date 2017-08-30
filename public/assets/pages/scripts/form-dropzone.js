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

                        $("#my-dropzone").submit(function (e) {

                            e.preventDefault();
                            e.stopPropagation();
                            _this.processQueue();

                            setTimeout(function(){
                                location.reload();
                            }, 10000);
                        });

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

                        }
                    });
                }            
            };


        }
    };
}();

jQuery(document).ready(function() {    
   FormDropzone.init();
});