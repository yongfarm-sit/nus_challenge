@extends('layouts.master') 
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Inventory / View Inventory</li>
                        </ul>
                        <h2>View Inventory</h2>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <a href="{{ route('inventory.newitem') }}" class="btn btn-primary mb-3">Create New Item</a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>SKU</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Lower Limit</th>
                                    <th>Price per unit</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventory_items as $item)
                                    <tr>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <form action="{{ route('inventory.decreaseitemqty', ['inventory_item' => $item->item_id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-secondary btn-sm" onclick="">-</button>
                                            </form>
                                            
                                            <span id="quantity-{{ $item->item_id }}">{{ $item->quantity_on_hand }}</span>

                                            <form action="{{ route('inventory.increaseitemqty', ['inventory_item' => $item->item_id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-secondary btn-sm" onclick="">+</button>
                                            </form>
                                            
                                        </td>
                                        <td>{{ $item->lower_limit }}</td>
                                        <td>{{ $item->ppu }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('inventory.edititem', ['inventory_item' => $item->item_id]) }}" class="btn btn-primary mr-3">Edit</a>
                                                <form action="{{ route('inventory.delete', ['inventory_item' => $item->item_id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
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
@endsection

@push('scripts')

@endpush
