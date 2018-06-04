@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Transactions List') }}</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>{{ __('Transaction ID') }}</b></td>
                                <td><b>{{ __('Transaction Amount') }}</b></td>
                                <td><b>{{ __('Customer ID') }}</b></td>
                            </tr>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->user_id }}</td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
