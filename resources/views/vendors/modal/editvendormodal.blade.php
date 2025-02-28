<form action="{{ route('vendor.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal fade text-left" id="ModalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit Vendor') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Company Name') }}:</strong>
                            <input type="text" name="CompanyName" id="editCompanyName" class="form-control" placeholder="Company Name" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Display Name') }}:</strong>
                            <input type="text" name="DisplayName" id="editDisplayName" class="form-control" placeholder="Display Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Email') }}:</strong>
                            <input type="email" name="ContactEmail" id="editContactEmail" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Mobile number') }}:</strong>
                            <input type="text" name="MobileNumber" id="editMobileNumber" class="form-control" placeholder="Mobile Number">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Fax number') }}:</strong>
                            <input type="text" name="FaxNumber" id="editFaxNumber" class="form-control" placeholder="Fax Number">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Address') }}:</strong>
                            <input type="text" name="Address" id="editAddress" class="form-control" placeholder="Address">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="VendorID" id="editVendorID"> <!-- Hidden input to hold Vendor ID -->
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{ __('Back') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
