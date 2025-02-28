<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
    use HasFactory;
    protected $table = 'customerinvoice';
    protected $primaryKey = 'InvoiceID';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'InvoiceDate',
        'TotalAmount',
        'Status'
    ];

        // Relationships
        public function customer()
        {
            return $this->belongsTo(Customer::class, 'CustomerID', 'CustomerID');
        }
}
