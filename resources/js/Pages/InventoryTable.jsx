import React from 'react';
import { Inertia } from '@inertiajs/inertia';

export default function InventoryTable({ inventory_items }) {
    const handleNavigation = () => {
        Inertia.get('/inventory/newitem');
    };

    return (
        <>
            <h1>Inventory</h1>
            <button type="button" onClick={handleNavigation}>
                Add New Item
            </button>
            <br /><br />
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>SKU</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Lower Limit</th>
                        <th>Price per unit</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    {inventory_items.map(item => (
                        <tr key={item.item_id}>
                            <td>{item.item_id}</td>
                            <td>{item.item_name}</td>
                            <td>{item.sku}</td>
                            <td>{item.description}</td>
                            <td>{item.quantity_on_hand}</td>
                            <td>{item.lower_limit}</td>
                            <td>{item.ppu}</td>
                            <td>{item.category}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </>
    );
}
