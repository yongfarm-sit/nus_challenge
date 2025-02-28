@extends('layouts.master')

@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Reimbursement / Receipts</li>
                        </ul>
                        <h2>Receipts</h2>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <a href="{{ route('reimbursement.index') }}" class="btn btn-primary mb-3">Create New Receipt</a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Vendor Name</th>
                                    <th>Purchase Date</th>
                                    <th>Total Amount</th>
                                    <th>Currency</th>
                                    <th>Payment Method</th>
                                    <th>Category</th>
                                    <th>Receipt</th>
                                    <th>Uploaded By</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reimbursements as $reimbursement)
                                    <tr>
                                        <td>{{ $reimbursement->receipt_id }}</td>
                                        <td>{{ $reimbursement->vendor_name }}</td>
                                        <td>{{ $reimbursement->purchase_date }}</td>
                                        <td>{{ $reimbursement->total_amount }}</td>
                                        <td>{{ $reimbursement->currency }}</td>
                                        <td>{{ $reimbursement->payment_method }}</td>
                                        <td>{{ $reimbursement->category }}</td>
                                        <td>
                                            @if($reimbursement->receipt_img)
                                                <img src="data:image/jpeg;base64,{{ $reimbursement->receipt_img }}" alt="Receipt" style="max-width: 100px; max-height: 100px;">
                                            @else
                                                No receipt
                                            @endif
                                        </td>
                                        <td>{{ $reimbursement->user->name ?? 'user' }}</td>
                                        <td>{{ $reimbursement->created_at }}</td>
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