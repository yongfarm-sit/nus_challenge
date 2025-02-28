@extends('layouts.master') 
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">

                        <h2>View Vendors</h2>
                        <a href="#" data-toggle="modal" data-target="#ModalCreate" class="btn btn-primary mb-3">Add New Vendor</a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Display Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Fax Number</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendor_list as $item)
                                    <tr>
                                        <td>{{ $item->VendorID }}</td>
                                        <td>{{ $item->CompanyName }}</td>
                                        <td>{{ $item->DisplayName }}</td>
                                        <td>{{ $item->ContactEmail }}</td>
                                        <td>{{ $item->MobileNumber }}</td>
                                        <td>{{ $item->FaxNumber }}</td>
                                        <td>{{ $item->Address }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalEdit" 
                                            data-id="{{ $item->VendorID }}"
                                            data-company="{{ $item->CompanyName }}"
                                            data-display="{{ $item->DisplayName }}"
                                            data-email="{{ $item->ContactEmail }}"
                                            data-mobile="{{ $item->MobileNumber }}"
                                            data-fax="{{ $item->FaxNumber }}"
                                            data-address="{{ $item->Address }}">
                                            Edit
                                        </button>
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
@include('vendors.modal.newvendormodal')
@include('vendors.modal.editvendormodal')
@endsection 

@push('scripts')
<script>
    // Triggered when the modal is opened
    $('#ModalEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var vendorID = button.data('id'); // Extract vendor ID
        var companyName = button.data('company');
        var displayName = button.data('display');
        var email = button.data('email');
        var mobile = button.data('mobile');
        var fax = button.data('fax');
        var address = button.data('address');

        // Populate the modal fields with the vendor data
        var modal = $(this);
        modal.find('#editVendorID').val(vendorID);
        modal.find('#editCompanyName').val(companyName);
        modal.find('#editDisplayName').val(displayName);
        modal.find('#editContactEmail').val(email);
        modal.find('#editMobileNumber').val(mobile);
        modal.find('#editFaxNumber').val(fax);
        modal.find('#editAddress').val(address);
    });
</script>
@endpush
