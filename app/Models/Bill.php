<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';
    protected $primary_key = 'bill_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'vendor_id',
        'bill_id',
        'bill_no',
        'bill_date',
        'bill_status',
        'due_date',
        'total_amount',
        'payment_term',
        'billing_address',
        'memo',
        'attachment',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'VendorID');
    }

    public function items() 
    { 
        return $this->hasMany(BillItem::class, 'bill_id', 'bill_id'); 
    }
}