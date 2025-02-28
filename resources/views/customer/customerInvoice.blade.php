@extends('layouts.master')

@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <h2>View Customer Invoices</h2>
                        <a href="#" data-toggle="modal" data-target="#ModalCreate" class="btn btn-primary mb-3">Add New Customer Invoice</a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Customer ID</th>
                                    <th>Invoice Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cust_invoice_list as $item)
                                    <tr>
                                        <td>{{ $item->InvoiceID }}</td>
                                        <td>{{ $item->CustomerID }}</td>
                                        <td>{{ $item->InvoiceDate }}</td>
                                        <td>{{ $item->TotalAmount }}</td>
                                        <td>{{ $item->Status }}</td>
                                        <td>
                                            <form action="{{ route('send.invoice.email') }}" method="POST">
                                                @csrf
                                                <!-- Use dynamic values from the $item object -->
                                                <input type="hidden" name="customerID" value="{{ $item->CustomerID }}">
                                                <input type="hidden" name="invoiceID" value="{{ $item->InvoiceID }}">
                                                <button type="submit" class="btn btn-primary">Send Invoice Email</button>
                                            </form>                                            
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

@include('customer.modal.newcustomerinvoice')
@endsection
