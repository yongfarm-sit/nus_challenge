<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';
    protected $primary_key = 'item_id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'item_name',
        'sku',
        'description',
        'quantity_on_hand',
        'lower_limit',
        'ppu',
        'category'
    ];
}
