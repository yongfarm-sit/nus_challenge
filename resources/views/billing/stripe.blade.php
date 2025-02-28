@extends('layouts.master') 
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-xl-4 mt-5"></div>
                    <div class="col-xl-4 col-lg-12 col-md-9 mt-5">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h3 text-gray-900 mb-2 font-weight-bold">Payment</h1>
                                                <p class="font-weight-bold mb-3">View Bill</p>
                                            </div>
                                            <hr>
                                            <div class="text-center d-flex justify-content-between">
                                                <p class="font-weight-bold mb-2">Pay from</p>
                                                <p class="mb-2">ABC Company</p>
                                            </div>
                                            <div class="text-center d-flex justify-content-between">
                                                <p class="font-weight-bold mb-2">Pay to</p>
                                                <p class="mb-2">{{ $bills->vendor->DisplayName }}</p>
                                            </div>
                                            <hr>
                                            <div class="text-center d-flex justify-content-between">
                                                <p class="font-weight-bold mb-2">Payable Amount</p>
                                                <p class="mb-2">${{ $bills->total_amount }}</p>
                                            </div>
                                            <div class="text-center d-flex justify-content-between">
                                                <p class="font-weight-bold mb-2">Processing fee*</p>
                                                <p class="mb-2">$0.00</p>
                                            </div>
                                            <hr>
                                            <div class="text-center d-flex justify-content-between">
                                                <p class="font-weight-bold mb-2">Total Payable</p>
                                                <p class="mb-2">${{ $bills->total_amount }}</p>
                                            </div>
                                            <hr>
                                            <form role="form" action="{{ route('stripe.post', $bills->bill_id) }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-user" id="amount" value="{{ $bills->total_amount }}" hidden>
                                                </div>
                                                <button class="btn btn-primary btn-user btn-block" type="submit">Pay</button>
                                            </form>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
