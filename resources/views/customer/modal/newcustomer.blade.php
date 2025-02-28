<form action="{{ route('customer.add') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add New Customer') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Customer Type') }}:</strong>
                            <select name="CustomerType" class="form-control" id="customerTypeSelect" onchange="toggleCompanyNameField()">
                                <option value="Individual" selected>Individual</option>
                                <option value="Business">Business</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12" id="companyNameField" style="display: none;">
                        <div class="form-group">
                            <strong>{{ __('Company Name') }}:</strong>
                            <input type="text" name="CompanyName" class="form-control" placeholder="Company Name">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Contact Person') }}:</strong>
                            <input type="text" name="ContactPerson" class="form-control" placeholder="Contact Person">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Email') }}:</strong>
                            <input type="email" name="Email" class="form-control" placeholder="Email">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Contact No') }}:</strong>
                            <input type="number" name="ContactNo" class="form-control" placeholder="Contact Number">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Address') }}:</strong>
                            <input type="text" name="Address" class="form-control" placeholder="Address">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Postal Code') }}:</strong>
                            <input type="text" name="PostalCode" class="form-control" placeholder="Postal Code">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{ __('Back') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Add') }}</button>
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
