@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ url('withdraw/create') }}">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <span>Create Withdraw</span>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('msg'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="dashboard-label">Bank Code</label>
                            <input id="bank-code" type="text" class="form-control dashboard-input @error('bank_code') is-invalid @enderror" value="{{ old('bank_code') }}" name="bank_code" required>
                            @error('bank_code')
                            <small class="form-text invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="dashboard-label">Account Number</label>
                            <input id="account-number" type="text" class="form-control dashboard-input @error('account_number') is-invalid @enderror" name="account_number" value="{{ old('account_number') }}" required>
                            @error('account_number')
                            <small class="form-text invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="dashboard-label">Amount</label>
                            <input id="amount" type="text" class="form-control dashboard-input @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>
                            @error('amount')
                            <small class="form-text invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="dashboard-label">Remark</label>
                            <input id="remark" type="text" class="form-control dashboard-input @error('remark') is-invalid @enderror" name="remark" value="{{ old('remark') }}" required>
                            @error('remark')
                            <small class="form-text invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-3 offset-md-9 pull-right">
                                <button type="submit" class="btn btn-success float-right">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection