<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function showInventory()
    {
        $inventory_items = InventoryItem::all();

        return view('inventory.inventory', ['inventory_items' => $inventory_items]);
    }

    public function loadNewInventoryItemForm()
    {
        return view('inventory.newitem');
    }

    public function loadEditInventoryItemForm($item_id)
    {
        $inventory_item = InventoryItem::where('item_id', $item_id)->first();
        return view('inventory.edititem', compact('inventory_item'));
    }

    public function addInventoryItem(Request $request)
    {
        // validate the request data
        $validated_data = $request->validate([
            'item_name' => 'required|string',
            'sku' => 'nullable',
            'description' => 'nullable',
            'quantity_on_hand' => 'required|integer|min:0',
            'lower_limit' => 'required|integer|min:0',
            'ppu' => 'required|decimal:2|gt:0',
            'category' => 'nullable'
        ]);

        // assign a unique id to the item
        $validated_data['item_id'] = (string) Str::uuid();

        // create a new inventory item using the validated data
        InventoryItem::create($validated_data);

        // redirect to the inventory page with success message
        return redirect()->route('inventory.index')->with('success', 'Item added successfully');
    }

    public function updateInventoryItem(Request $request, $item_id)
    {
        // validate the request data
        $validated_data = $request->validate([
            'item_name' => 'required|string',
            'sku' => 'nullable',
            'description' => 'nullable',
            'quantity_on_hand' => 'required|integer|min:0',
            'lower_limit' => 'required|integer|min:0',
            'ppu' => 'required|decimal:2|gt:0',
            'category' => 'nullable'
        ]);

        // find and update the item
        $inventory_item = InventoryItem::where('item_id', $item_id);
        $inventory_item->update($validated_data);

        // redirect to the inventory page with success message
        return redirect()->route('inventory.index')->with('success', 'Item updated successfully');
    }

    public function increaseItemQuantity($item_id)
    {
        // find item and increment quantity
        InventoryItem::where('item_id', $item_id)->increment('quantity_on_hand');
        return redirect()->back();
    }

    public function decreaseItemQuantity($item_id)
    {
        //find item and decrement quantity
        InventoryItem::where('item_id', $item_id)->decrement('quantity_on_hand');
        return redirect()->back();
    }

    public function deleteInventoryItem($item_id)
    {
        // find and delete the item
        $inventory_item = InventoryItem::where('item_id', $item_id);
        $inventory_item->delete();

        // redirect to the inventory page with success message
        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully');
    }
}
