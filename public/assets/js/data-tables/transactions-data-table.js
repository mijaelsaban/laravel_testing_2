$(function () {
    'use strict';

    $(function () {
        let gridUrl = $('#dataTableExample').data('grid-url');

        $('#dataTableExample').DataTable({
            "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
            ],
            "iDisplayLength": 60,
            "language": {
                search: ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": gridUrl,
            "paging": true,
            "pagingType": "full_numbers",
            orderCellsTop: true,
            "pageLength": 25,
            "order": [[5, "desc"]],
            "columnDefs": [
                {"name": "filter.reference", "targets": 0, "orderable": true, searchable: true},
                {"name": "filter.utm_source", "targets": 1, "orderable": true, searchable: true},
                {"name": "filter.utm_campaign", "targets": 2, "orderable": true, searchable: true},
                {"name": "filter.utm_medium", "targets": 3, "orderable": true, searchable: true},
                {"name": "filter.order_value", "targets": 4, "orderable": true, searchable: true},
                {"name": "filter.created_at", "targets": 5, "orderable": true, searchable: true},
            ],
        });
        $('#dataTableExample').each(function () {
            var datatable = $(this);
          // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.removeClass('form-control-sm');
          // LENGTH - Inline-Form control
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });
    });
});
