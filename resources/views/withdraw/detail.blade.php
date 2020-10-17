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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-status-inspeksi">
                                    <tbody>
                                        <tr>
                                            <td><strong>Tanggal</strong></td>
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
                                        <tr>
                                            <td><strong>Last Status Check</strong></td>
                                            <td>{{ $withdraw->last_check }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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