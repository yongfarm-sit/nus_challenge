@extends('layouts.master')

@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <h2>View Customers</h2>
                        <a href="#" data-toggle="modal" data-target="#ModalCreate" class="btn btn-primary mb-3">Add New Customer</a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Contact Person</th>
                                    <th>Customer Type</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>Address</th>
                                    <th>Postal Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cust_list as $item)
                                    <tr>
                                        <td>{{ $item->CustomerID }}</td>
                                        <td>{{ $item->CompanyName }}</td>
                                        <td>{{ $item->ContactPerson }}</td>
                                        <td>{{ $item->CustomerType }}</td>
                                        <td>{{ $item->Email }}</td>
                                        <td>{{ $item->ContactNo }}</td>
                                        <td>{{ $item->Address }}</td>
                                        <td>{{ $item->PostalCode }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalEdit" 
                                                data-id="{{ $item->CustomerID }}"
                                                data-company="{{ $item->CompanyName }}"
                                                data-contact="{{ $item->ContactPerson }}"
                                                data-type="{{ $item->CustomerType }}"
                                                data-email="{{ $item->Email }}"
                                                data-contactno="{{ $item->ContactNo }}"
                                                data-address="{{ $item->Address }}"
                                                data-postal="{{ $item->PostalCode }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('customer.delete', ['customer' => $item->CustomerID]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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

@include('customer.modal.newcustomer')
@include('customer.modal.editcustomer')
@endsection

@push('scripts')
<script>
    $('#ModalEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var customerID = button.data('id');
        var companyName = button.data('company');
        var contactPerson = button.data('contact');
        var customerType = button.data('type');
        var email = button.data('email');
        var contactNo = button.data('contactno');
        var address = button.data('address');
        var postalCode = button.data('postal');

        var modal = $(this);
        modal.find('#editCustomerID').val(customerID);
        modal.find('#editCompanyName').val(companyName);
        modal.find('#editContactPerson').val(contactPerson);
        modal.find('#editCustomerType').val(customerType);
        modal.find('#editEmail').val(email);
        modal.find('#editContactNo').val(contactNo);
        modal.find('#editAddress').val(address);
        modal.find('#editPostalCode').val(postalCode);
    });
</script>
@endpush