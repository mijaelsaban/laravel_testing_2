@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Payments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    {{ Form::open(['method'=>'post', 'route' => 'importTransactions', 'enctype' => 'multipart/form-data']) }}
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Import transactions</h6>
                    <p class="card-description">Check the
                        <a href="https://dashboard.stripe.com/reports/balance?startDate=2021-06-01&endDate=2021-06-30&currency=eur&templateType=merchant&timezone=Europe%2FVienna"
                           target="_blank">
                            Official Stripe Documentation
                        </a>
                        Import Balance change from activity.
                    </p>
                    <div class="custom-file">
                        <input type="file" name="transactions_csv" class="custom-file-input" id="validatedCustomFile" required>
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

    @include('layout.success', ['isAjax' => true])
    @include('layout.errors')
@endsection


@push('custom-scripts')
    <script src="{{ asset('assets/js/custom-pusher.js') }}"></script>
@endpush
