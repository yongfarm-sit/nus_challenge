import React, { useState } from 'react';
{/*import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-react';*/}

export default function NewInventoryItemForm()
{
    {/*const { props: { success } } = usePage();
    const [formData, setFormData] = useState({
        item_id: '',
        item_name: '',
        sku: '',
        description: '',
        quantity_on_hand: '',
        lower_limit: '',
        ppu: '',
        category: ''
    });

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        Inertia.post('/inventory/newitem', formData, {
            onSuccess: () => {
                Inertia.visit('/');
            }
        });
    };*/}
    
    return(
        <>
            <h1>New Inventory Item</h1>

            <form action="" onSubmit="{handleSubmit}">
                @csrf

                <label htmlFor="item_id">Item ID: </label><br />
                <input type="text" name="item_id" id="item_id" /><br /><br />
                <label htmlFor="item_name">Item Name: </label><br />
                <input type="text" name="item_name" id="item_name"/><br /><br />
                <label htmlFor="sku">Stock Keeping Unit: </label><br />
                <input type="text" name="sku" id="sku"/><br /><br />
                <label htmlFor="description">Item Description: </label><br />
                <textarea name="description" id="description"></textarea><br /><br />
                <label htmlFor="quantity_on_hand">Current Quantity: </label>
                <input type="number" name="quantity_on_hand" id="quantity_on_hand" /><br /><br />
                <label htmlFor="lower_limit">Minimum Quantity: </label>
                <input type="number" name="lower_limit" id="lower_limit" /><br /><br />
                <label htmlFor="ppu">Price per Unit: </label>
                <input type="number" name="ppu" id="ppu" /><br /><br />
                <label htmlFor="category">Category: </label>
                <input type="text" name="category" id="category"/><br /><br />
                <input type="submit" value="Add Item" />

            </form>
        </>
    );
}
