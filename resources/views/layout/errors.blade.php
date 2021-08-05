@if ($errors->any())
    <div class="alert alert-danger"
         id="msg-wraper"
         role="alert" style="
         width: 35%;
         position: fixed;
         right: 30px;
         top: 70px;
         padding: 20px;
         display: none;">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true" id="alrt-close-button">&times;</span>
        </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @push('custom-scripts')
        <script>
            $('#msg-wraper').fadeIn('slow');
            $('#alrt-close-button').click(function () {
                $(this).closest('#msg-wraper').hide()
            });
        </script>
    @endpush
@endif
