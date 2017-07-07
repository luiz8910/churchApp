var UIConfirmations = function () {

    var handleSample = function () {
        
        /*$('#bs_confirmation_demo_1').on('confirmed.bs.confirmation', function () {
            alert('You confirmed action #1');
        });

        $('#bs_confirmation_demo_1').on('canceled.bs.confirmation', function () {
            alert('You canceled action #1');
        });   

        $('#bs_confirmation_demo_2').on('confirmed.bs.confirmation', function () {
            alert('You confirmed action #2');
        });

        $('#bs_confirmation_demo_2').on('canceled.bs.confirmation', function () {
            alert('You canceled action #2');
        });

        $(".pop").click(function () {
            alert(this.id);
        });*/
        var route = location.pathname;

        $(".pop").on('confirmed.bs.confirmation', function () {
            $("#progress-danger").css("display", "block");

            var str = this.id;

            var id = str.replace("btn-delete-", "");

            var num = route.search("agenda");

            if(num > -1)
            {
                route = "/events";
            }
            else
            {
                num = route.search("events");

                if(num > -1)
                {
                    route = "/events";
                }
            }


            Delete(id, route);
        });

        $(".pop-leave-group").on('confirmed.bs.confirmation', function () {

            var str = this.id;

            var person = str.replace("btn-delete-", "");

            var group = $("#groupId").val();

            leaveGroup(group, person);
        });

        $(".pop-teen").on('confirmed.bs.confirmation', function () {
            var str = this.id;
            var teen = str.replace("btn-delete-", "");

            detachTeen(teen);
        });


    };


    return {
        //main function to initiate the module
        init: function () {

           handleSample();

        }

    };

}();

jQuery(document).ready(function() {    
   UIConfirmations.init();
});