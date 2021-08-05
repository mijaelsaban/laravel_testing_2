@if(Session::has('success') && $isAjax)
    <div class="@if($isAjax) card listen @else alert alert-success @endif"
         id="msg-wraper"
         role="alert" style="
         width: 35%;
         position: fixed;
         right: 30px;
         top: 70px;
         padding: 20px;
         z-index: 2;
         display: none;">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true" id="alrt-close-button">&times;</span>
        </button>
        <span id="alrt-msg"></span>
        @if($isAjax)
            <div class="uploading-information"
                 style="display: none; max-height: 300px; overflow-y: auto;">
                <ul class="my-2 timer text-right pr-2"></ul>
                <ul class="counter m-auto" style="list-style: none; padding: 5px 12px 8px 5px;"></ul>
            </div>
        @endif
    </div>

    @push('custom-scripts')
        <script>
            $('#alrt-close-button').click(function () {
                $(this).closest('#msg-wraper').hide()
            });
        </script>
    @endpush
@endif
