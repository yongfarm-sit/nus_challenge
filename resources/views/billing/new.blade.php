@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12 mt-5">
                    <h2>New Bill</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('billing.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="vendor_id">Vendor: </label>
                            <select name="vendor_id" id="vendor_id" class="form-control">
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->VendorID }}" {{ old('vendor_id') == $vendor->VendorID ? 'selected' : '' }}>
                                    {{ $vendor->CompanyName }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="bill_no">Bill No:</label>
                            <input type="text" class="form-control" name="bill_no" id="bill_no" value="{{ old('bill_no') }}" readonly />
                        </div>

                        <div>
                            <label for="bill_date">Bill Date:</label>
                            <input type="date" class="form-control" name="bill_date" id="bill_date" value="{{ old('bill_date') }}" />
                        </div>

                        <div>
                            <label for="due_date">Due Date:</label>
                            <input type="date" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') }}" />
                        </div>

                        <div>
                            <label for="payment_term">Payment Term:</label>
                            <input type="text" class="form-control" name="payment_term" id="payment_term" value="{{ old('payment_term') }}" />
                        </div>

                        <div>
                            <label for="billing_address">Billing Address: </label>
                            <textarea class="form-control" name="billing_address" id="billing_address" rows="3">{{ old('billing_address') }}</textarea>
                        </div>

                        <div class="mt-3"> 
                            <label>Items:</label> 
                            <table class="table" id="itemTable"> 
                                <thead> 
                                    <tr> 
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr> 
                                </thead> 
                                <tbody></tbody> 
                            </table> 
                            <button type="button" id="addItemButton" class="btn btn-secondary mt-3">Add Item</button> 
                            <button type="button" id="clearItemsButton" class="btn btn-danger mt-3">Clear All Items</button> 
                        </div>

                        <div>
                            <label for="total_amount">Total Amount:</label>
                            <input type="text" class="form-control" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" readonly />
                        </div>

                        <div>
                            <label for="memo">Memo: </label>
                            <textarea class="form-control" name="memo" id="memo" rows="3">{{ old('memo') }}</textarea>
                        </div>

                        <div>
                            <label for="attachment">Attachment (Maximum size: 20MB):</label>
                            <input type="file" class="form-control" name="attachment" id="attachment" />
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script> 
document.addEventListener('DOMContentLoaded', function() {

    const addItemButton = document.querySelector('#addItemButton');
    const clearItemsButton = document.querySelector('#clearItemsButton');
    const itemTable = document.querySelector('#itemTable tbody');
    const totalAmountField = document.querySelector('#total_amount'); 

    addItemButton.addEventListener('click', function() {
        const itemHtml = `
            <tr>
                <td><input type="text" class="form-control" name="item_name[]" /></td>
                <td><input type="text" class="form-control" name="description[]" /></td>
                <td><input type="number" class="form-control" name="qty[]" min="0" value="0"" /></td>
                <td><input type="text" class="form-control" name="unit_price[]" min="0" oninput="calculateTotalPrice(this)" /></td>
                <td><input type="text" class="form-control" name="total_price[]" value="0.00" readonly /></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item">Remove</button></td>
            </tr>
        `;
        itemTable.insertAdjacentHTML('beforeend', itemHtml);

        const newRow = itemTable.lastElementChild;
        const qtyField = newRow.querySelector('input[name="qty[]"]');
        const unitPriceField = newRow.querySelector('input[name="unit_price[]"]');

        qtyField.addEventListener('input', () => calculateTotalPrice(newRow));
        unitPriceField.addEventListener('input', () => calculateTotalPrice(newRow));
    });

    itemTable.addEventListener('click', function(event) { 
        if (event.target.classList.contains('remove-item')) { 
            event.target.closest('tr').remove(); 
            calculateOverallTotal()
        } 
    }); 

    clearItemsButton.addEventListener('click', function() { 
        itemTable.innerHTML = ''; 
        calculateOverallTotal()
    });

});

function calculateTotalPrice(element) {
    const qty = parseFloat(element.querySelector('input[name="qty[]"]').value) || 0;
    const unitPrice = parseFloat(element.querySelector('input[name="unit_price[]"]').value) || 0;
    const totalPriceField = element.querySelector('input[name="total_price[]"]');
    const totalPrice = qty * unitPrice

    totalPriceField.value = totalPrice.toFixed(2);
    //console.log(`Qty: ${qty}, Unit Price: ${unitPrice}, Total Price: ${totalPrice.value}`);
    calculateOverallTotal();
}

function calculateOverallTotal() {
    const itemTable = document.querySelector('#itemTable tbody');
    const totalAmountField = document.querySelector('#total_amount');
    let overallTotal = 0;

    const totalPriceFields = itemTable.querySelectorAll('input[name="total_price[]"]');
    totalPriceFields.forEach((field) => {
        overallTotal += parseFloat(field.value) || 0;
    });

    totalAmountField.value = overallTotal.toFixed(2); 
}

</script>
@endsection
