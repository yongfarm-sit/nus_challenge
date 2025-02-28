<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table = 'vendors';

    protected $primaryKey = 'VendorID';
    public $incrementing = true; 
    protected $keyType = 'int'; 

    public $timestamps = false;

    protected $fillable = [
        'CompanyName',
        'DisplayName',
        'ContactEmail',
        'MobileNumber',
        'FaxNumber',
        'Address',
        'account_no',
    ];

    public function Bills()
    {
        return $this->hasMany(Bill::class, 'vendor_id', 'VendorID');
    }
}
