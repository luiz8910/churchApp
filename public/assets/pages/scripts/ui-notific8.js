var UINotific8 = function () {

    return {
        //main function to initiate the module
        init: function () {


            $("#notific8").click(function (e) {

                console.log("notific8");
                var title = $("#notific8-title").val();
                var text = $("#notific8-text").val();
                var type = $("#notific8-type").val() == 'danger' ? 'ruby' : 'amethyst';

                var settings = {
                    theme: type,
                    sticky: false,
                    horizontalEdge: 'top',
                    verticalEdge: 'right'
                };
                //$button = $(this);

                if ($.trim(title) != '') {
                    settings.heading = $.trim(title);
                }

                if (!settings.sticky) {
                    settings.life = 3000;
                }

                $.notific8('zindex', 11500);
                $.notific8($.trim(text), settings);

                //$button.attr('disabled', 'disabled');

                /*setTimeout(function() {
                 $button.removeAttr('disabled');
                 }, 1000);*/

            });


            $("#notific8-pusher").click(function ()
            {

                var title = $("#notific8-title-pusher").val();
                var text = $("#notific8-text-pusher").val();
                var type = $("#notific8-type-pusher").val();

                var settings = {
                    theme: type,
                    sticky: false,
                    horizontalEdge: 'top',
                    verticalEdge: 'right'
                };
                //$button = $(this);

                if ($.trim(title) != '') {
                    settings.heading = $.trim(title);
                }

                if (!settings.sticky) {
                    settings.life = 10000;
                }

                $.notific8('zindex', 11500);
                $.notific8($.trim(text), settings);
            });



        }

    };

}();

jQuery(document).ready(function() {    
   UINotific8.init();
});