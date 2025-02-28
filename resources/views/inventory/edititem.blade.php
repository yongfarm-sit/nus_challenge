@extends('layouts.master')

@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Inventory / View Inventory / Edit Item</li>
                        </ul>
                        <h2>Edit Item</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form action="{{ route('inventory.update', ['inventory_item' => $inventory_item->item_id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="item_name">Item Name: </label><br />
                                <input type="text" class="form-control" name="item_name" id="item_name" value="{{ $inventory_item->item_name }}" />
                            </div>

                            <div>
                                <label for="sku">Stock Keeping Unit (SKU): </label><br />
                                <input type="text" class="form-control" name="sku" id="sku" value="{{ $inventory_item->sku }}" />
                            </div>

                            <div>
                                <label for="description">Item Description: </label><br />
                                <textarea class="form-control" name="description" id="description" rows="3">{{ $inventory_item->description }}</textarea>
                            </div>

                            <div>
                                <label for="quantity_on_hand">Current Quantity: </label>
                                <input type="number" class="form-control" name="quantity_on_hand" id="quantity_on_hand" value="{{ $inventory_item->quantity_on_hand }}" />
                            </div>

                            <div>
                                <label for="lower_limit">Minimum Quantity: </label>
                                <input type="number" class="form-control" name="lower_limit" id="lower_limit" value="{{ $inventory_item->lower_limit }}" />
                            </div>

                            <div>
                                <label for="ppu">Price per Unit: </label>
                                <input type="number" step="0.01" class="form-control" name="ppu" id="ppu" value="{{ $inventory_item->ppu }}" />
                            </div>

                            <div>
                                <label for="category">Category: </label>
                                <input type="text" class="form-control" name="category" id="category" value="{{ $inventory_item->category }}" />
                            </div>

                            <button type="submit" class="btn btn-primary mt-3" value="Update Item">Update Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
