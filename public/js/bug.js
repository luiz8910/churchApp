/**
 *   I don't recommend using this plugin on large tables, I just wrote it to make the demo useable. It will work fine for smaller tables
 *   but will likely encounter performance issues on larger tables.
 *
 *		<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filter Developers" />
 *		$(input-element).filterTable()
 *
 *	The important attributes are 'data-action="filter"' and 'data-filters="#table-selector"'
 */
(function(){
    'use strict';
    var $ = jQuery;
    $.fn.extend({
        filterTable: function(){
            return this.each(function(){
                $(this).on('keyup', function(e){
                    $('.filterTable_no_results').remove();
                    var $this = $(this),
                        search = $this.val().toLowerCase(),
                        target = $this.attr('data-filters'),
                        $target = $(target),
                        $rows = $target.find('tbody tr');

                    if(search == '') {
                        $rows.show();
                    } else {
                        $rows.each(function(){
                            var $this = $(this);
                            $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
                        })
                        if($target.find('tbody tr:visible').size() === 0) {
                            var col_count = $target.find('tr').first().find('td').size();
                            var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">Nenhum Resultado encontrado</td></tr>')
                            $target.find('tbody').append(no_results);
                        }
                    }
                });
            });
        }
    });
    $('[data-action="filter"]').filterTable();
})(jQuery);

$(function(){
    // attach table filter plugin to inputs
    $('[data-action="filter"]').filterTable();

    $('.container').on('click', '.panel-heading span.filter', function(e){
        var $this = $(this),
            $panel = $this.parents('.panel');

        $panel.find('.panel-body').slideToggle();
        if($this.css('display') != 'none') {
            $panel.find('.panel-body input').focus();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();


    $(".tr").click(function () {

        var id = ($(this).parent()[0].id);

        id = id.replace('tr-', '');

        var text = $("#input-" + id).val();

        textarea(text);
    });

    $(".btn-ok").click(function () {
        var id = this.id.replace('btn-ok-', '');

        var request = $.ajax({
            url: 'bug-solved/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {

            if(e.status)
            {
                $('#tr-'+id).css('display', 'none');
            }

        })
    })

});

function textarea(text)
{
    var textarea = $("#textarea");

    textarea.text('');

    $('html, body').animate({
        scrollTop: textarea.offset().top
    }, 2000);


    textarea.text(text);
}
