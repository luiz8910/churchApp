$(function(){

    $('.span-btn-minimize').click(function () {

        var panel_id = this.id.replace('btn-minimize-', '');

        var panel = $("#"+panel_id);

        if(panel.hasClass('hide-panel'))
        {
            panel.removeClass('hide-panel');
            panel.addClass('show-panel');
        }
        else{
            panel.removeClass('show-panel');
            panel.addClass('hide-panel');
        }
    });

});
