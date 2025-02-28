<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;

    protected $table = 'bill_item';
    protected $primaryKey = 'item_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'bill_id',
        'item_name',
        'description',
        'qty',
        'unit_price',
        'total_price'
    ];

    public function bill() 
    { 
        return $this->belongsTo(Bill::class, 'bill_id', 'bill_id'); 
    }
}