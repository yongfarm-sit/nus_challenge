<form action="{{ route('customer.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal fade text-left" id="ModalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit Customer') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Customer Type') }}:</strong>
                            <select name="CustomerType" id="editCustomerType" class="form-control" onchange="toggleCompanyNameField()">
                                <option value="Individual">Individual</option>
                                <option value="Business">Business</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12" id="companyNameField">
                        <div class="form-group">
                            <strong>{{ __('Company Name') }}:</strong>
                            <input type="text" name="CompanyName" id="editCompanyName" class="form-control" placeholder="Company Name">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Contact Person') }}:</strong>
                            <input type="number" name="ContactPerson" id="editContactPerson" class="form-control" placeholder="Contact Person">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Email') }}:</strong>
                            <input type="email" name="Email" id="editEmail" class="form-control" placeholder="Email">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Contact No') }}:</strong>
                            <input type="text" name="ContactNo" id="editContactNo" class="form-control" placeholder="Contact Number">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Address') }}:</strong>
                            <input type="text" name="Address" id="editAddress" class="form-control" placeholder="Address">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Postal Code') }}:</strong>
                            <input type="text" name="PostalCode" id="editPostalCode" class="form-control" placeholder="Postal Code">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="CustomerID" id="editCustomerID">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{ __('Back') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>