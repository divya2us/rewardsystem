@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed">
                            <thead>
                            <tr>
                                <th><strong>S.no</strong></th>
                                <th><strong>Email</strong></th>
                                <th><strong>Referer email</strong></th>
                                <th><strong>Credit points</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $a=0; ?>
                            @foreach($refDetails as $data)
                                <?php $a++; ?>
                                <tr>
                                    <th>{{ $a }}</th>
                                    <th>{{ $data->email}}</th>
                                    <th>{{ $data->referral_email}}</th>
                                    <th>{{ $data->credit_points}}</th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
