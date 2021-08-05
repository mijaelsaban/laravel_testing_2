<div class="card">
    <div class="card-body">
        <h6 class="card-title">{{ $title }}</h6>

            <table {{ $attributes->merge(['class'=> 'table table-responsive table-hover']) }}>
                <thead wire:loading.class.delay="alert alert-icon-primary">
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>

                <tbody>
                {{ $body }}
                </tbody>
            </table>
    </div>
</div>
