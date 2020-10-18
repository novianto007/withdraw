@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Data Withdraw</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ url('withdraw/create') }}" class="btn btn-primary"> Create Withdraw </a>
                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-status-inspeksi">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Bank Code</th>
                                            <th scope="col">Account Number</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Remark</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($withdraws as $withdraw)
                                        <tr>
                                            <td>{{ $number++ }}</td>
                                            <td>{{ $withdraw->created_at }}</td>
                                            <td>{{ $withdraw->bank_code }}</td>
                                            <td>{{ $withdraw->account_number }}</td>
                                            <td>{{ $withdraw->amount }}</td>
                                            <td>{{ $withdraw->remark }}</td>
                                            <td>{{ $withdraw->status }}</td>
                                            <td><a href="{{ url('withdraw/detail/'.$withdraw->id) }}">Detail</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $withdraws->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection