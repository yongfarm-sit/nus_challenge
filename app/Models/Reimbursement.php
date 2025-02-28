<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    protected $table = 'receipts';

    protected $fillable = [
        'vendor_name',
        'purchase_date',
        'total_amount',
        'currency',
        'payment_method',
        'category',
        'receipt_img',
        'uploaded_by',
    ];
}