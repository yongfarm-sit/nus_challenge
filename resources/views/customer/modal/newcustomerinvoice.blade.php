<form action="{{ route('customerinvoice.add') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add New Customer Invoice') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Customer ID') }}:</strong>
                            <select name="CustomerID" id="CustomerID" class="form-control" required>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->CustomerID }}">{{ $customer->ContactPerson }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Invoice Date') }}:</strong>
                            <input type="date" name="InvoiceDate" class="form-control" placeholder="Invoice Date" required>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Total Amount') }}:</strong>
                            <input type="number" name="TotalAmount" class="form-control" step="0.01" placeholder="Total Amount" required>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Status') }}:</strong>
                            <select name="Status" id="Status" class="form-control" required>
                                <option value="Pending">Pending</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{ __('Back') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Add Invoice') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Function to toggle visibility of the CompanyName field based on the selected CustomerType
    function toggleCompanyNameField() {
        var customerType = document.getElementById('customerTypeSelect').value;
        var companyNameField = document.getElementById('companyNameField');
        
        if (customerType === 'Business') {
            companyNameField.style.display = 'block';
        } else {
            companyNameField.style.display = 'none';
        }
    }
    
    // Initialize the form with the correct visibility for CompanyName field
    toggleCompanyNameField();
</script>
