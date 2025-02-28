@extends('layouts.master')

@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Inventory / View Inventory / Add New Item</li>
                        </ul>
                        <h2>Add New Item</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form action="{{ route('inventory.newitem') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div>
                                <label for="item_name">Item Name: </label>
                                <input type="text" class="form-control" name="item_name" id="item_name" value="{{ old('item_name') }}" />
                            </div>

                            <div>
                                <label for="sku">Stock Keeping Unit (SKU): </label>
                                <input type="text" class="form-control" name="sku" id="sku" value="{{ old('sku') }}" />
                            </div>

                            <div>
                                <label for="description">Item Description: </label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label for="quantity_on_hand">Current Quantity: </label>
                                <input type="number" class="form-control" name="quantity_on_hand" id="quantity_on_hand" value="{{ old('quantity_on_hand') }}" />
                            </div>

                            <div>
                                <label for="lower_limit">Minimum Quantity: </label>
                                <input type="number" class="form-control" name="lower_limit" id="lower_limit" value="{{ old('lower_limit') }}" />
                            </div>

                            <div>
                                <label for="ppu">Price per Unit: </label>
                                <input type="number" step="0.01" class="form-control" name="ppu" id="ppu" value="{{ old('ppu') }}" />
                            </div>

                            <div>
                                <label for="category">Category: </label>
                                <input type="text" class="form-control" name="category" id="category" value="{{ old('category') }}" />
                            </div>

                            <button type="submit" class="btn btn-primary mt-3" value="Add Item">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
