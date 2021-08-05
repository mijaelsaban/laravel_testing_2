<div>
    <div class="card mb-2">
        <div class="card-body">
            <h6 class="card-title">Date range</h6>
            <div class="input-group">
                <label class="input-group-text" for="daterange" style="border: none">
                    <x-icons.calendar/>
                </label>
                <input type="text" name="daterange" class="form-control daterange" id="daterange" autocomplete="off">
            </div>
        </div>
    </div>
</div>

@push('plugin-scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endpush

@push('custom-scripts')
    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                autoUpdateInput: false,
                showDropdowns: true,
                locale: {
                    format: 'DD/M/Y',
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().endOf('month')],
                    'All Time': [moment('2021-01-01'), moment()]
                }
            }, function (start, dateEnd) {
                console.log(start, dateEnd);
            @this.set('dateFrom', start);
            @this.set('dateTo', dateEnd);
            });

            $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

        });
    </script>
@endpush
