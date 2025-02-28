@extends('layouts.master') 
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <h2>Bill Summary</h2>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <a href="{{ route('billing.new') }}" class="btn btn-primary mb-3">Create New Bill</a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Bill No.</th>
                                    <th>Bill Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Payment Term</th>
                                    <th>Memo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->vendor_id }}</td>
                                        <td>{{ $bill->bill_no }}</td>
                                        <td>{{ $bill->bill_date }}</td>
                                        <td>{{ $bill->due_date }}</td>
                                        <td>{{ $bill->bill_status }}</td>
                                        <td>{{ $bill->total_amount }}</td>
                                        <td>{{ $bill->payment_term }}</td>
                                        <td>{{ $bill->memo }}</td>
                                        <td>
                                            @if($bill->bill_status !== 'Paid')
                                                <a href="{{ url('stripe', $bill->bill_id) }}" class="btn btn-primary">Review</a>
                                            @else
                                                <button class="btn btn-secondary" disabled>Review</button>
                                            @endif
                                            <a href="{{ route('billing.downloadPdf', ['id' => $bill->bill_id]) }}" class="btn btn-secondary">Download PDF</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
