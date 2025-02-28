@extends('layouts.master')

@section('content')

<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Reimbursement / Receipts / Add Receipt</li>
                        </ul>
                        <h2>Add Receipt</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form action="{{ route('reimbursement.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div>
                                <label for="receipt_img">Upload Receipt:</label>
                                <input 
                                    type="file" 
                                    class="form-control" 
                                    name="receipt_img" 
                                    id="receipt_img" 
                                    accept="image/*,application/pdf" 
                                    required
                                />
                            </div>

                            <div>
                                <label for="vendor_name">Description:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="vendor_name" 
                                    name="vendor_name" 
                                    id="vendor_name" 
                                    value="{{ old('vendor_name') }}" 
                                    required
                                />
                            </div>

                            <div>
                                <label for="purchase_date">Purchase Date:</label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="purchase_date" 
                                    name="purchase_date" 
                                    id="purchase_date" 
                                    value="{{ old('purchase_date') }}" 
                                    required
                                />
                            </div>

                            <div>
                                <label for="total_amount">Total Amount:</label>
                                <input 
                                    type="number" 
                                    step="0.01"
                                    class="form-control" 
                                    id="total_amount" 
                                    name="total_amount" 
                                    id="total_amount" 
                                    value="{{ old('total_amount') }}" 
                                    min="0" 
                                    required
                                />
                            </div>

                            <div>
                                <label for="currency">Currency:</label>
                                <select class="form-control" name="currency" id="currency" required>
                                    <option value="SGD" {{ old('currency') == 'SGD' ? 'selected' : '' }}>SGD</option>
                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                    {{-- Add other currencies as needed --}}
                                </select>
                            </div>

                            <div>
                                <label for="payment_method">Payment Method:</label>
                                <select class="form-control" name="payment_method" id="payment_method" required>
                                    <option value="Company Card" {{ old('payment_method') == 'Company Card' ? 'selected' : '' }}>Company Card</option>
                                    <option value="Digital Payment" {{ old('payment_method') == 'Digital Payment' ? 'selected' : '' }}>Digital Payment</option>
                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                            </div>

                            <div>
                                <label for="category">Category:</label>
                                <select class="form-control" name="category" id="category" required>
                                    <option value="Travel" {{ old('category') == 'Travel' ? 'selected' : '' }}>Travel</option>
                                    <option value="Meals" {{ old('category') == 'Meals' ? 'selected' : '' }}>Meals</option>
                                    <option value="Supplies" {{ old('category') == 'Supplies' ? 'selected' : '' }}>Supplies</option>
                                    <option value="Transport" {{ old('category') == 'Transport' ? 'selected' : '' }}>Transport</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded');

    // Get the file input element
    const fileInput = document.getElementById('receipt_img');

    console.log('File input element:', fileInput);

    if (fileInput) {
        fileInput.addEventListener('change', async function(e) {
            console.log('File selected:', this.files[0]);
            
            alert('Starting file upload...');

            try {
                // Create FormData
                const formData = new FormData();
                formData.append('receipt_img', this.files[0]);
                
                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').content;
                console.log('CSRF Token:', token);

                // Make the request
                const response = await fetch('{{ route("reimbursement.ocr") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                });

                console.log('Response received:', response);

                const data = await response.json();
                console.log('Response data:', data);

                if (data.success) {
                    document.getElementById('vendor_name').value = data.merchant_name || '';
                    document.getElementById('purchase_date').value = data.transaction_date || '';
                    document.getElementById('total_amount').value = data.total_amount || '';
                    document.getElementById('currency').value = data.currency || 'SGD';
                    document.getElementById('payment_method').value = data.payment_method || 'Cash';
                    
                    alert('Form filled with OCR data');
                } else {
                    alert('OCR failed: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error processing file: ' + error.message);
            }
        });
    } else {
        console.error('Could not find file input element with id "receipt_img"');
    }
});
</script>
@endsection