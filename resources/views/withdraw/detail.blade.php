@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Detail Transaksi Withdraw</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-status-inspeksi">
                                <tbody>
                                    <tr>
                                        <td><strong>Date</strong></td>
                                        <td>{{ $withdraw->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bank Code</strong></td>
                                        <td>{{ $withdraw->bank_code }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Account Number</strong></td>
                                        <td>{{ $withdraw->account_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Amount</strong></td>
                                        <td>{{ $withdraw->amount }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Remark</strong></td>
                                        <td>{{ $withdraw->remark }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fee</strong></td>
                                        <td>{{ $withdraw->fee }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Beneficiary Name</strong></td>
                                        <td>{{ $withdraw->beneficiary_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Time Served</strong></td>
                                        <td>{{ $withdraw->time_served }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Receipt</strong></td>
                                        <td>{{ $withdraw->receipt }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>{{ $withdraw->status }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-6">
                                    <span>Status History</span>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-success float-right mb-2" href="{{ url('withdraw/update-status/'. $withdraw->id) }}" onclick="event.preventDefault();
                                                     document.getElementById('check-status-form').submit();">
                                        Check Status Update
                                    </a>

                                    <form id="check-status-form" action="{{ url('withdraw/update-status/'. $withdraw->id) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-status-inspeksi">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdraw->statusHistories as $no => $history)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $history->timestamp }}</td>
                                        <td>{{ $history->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ url('withdraw') }}" class="btn btn-info float-right"> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection