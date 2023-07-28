<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'amount',
        'status',
        'billed_date',
        'paid_date',
        'void_date'
    ];

    // 1 hóa đơn chỉ thuộc về 1 khách hàng
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected $hidden = [];

    protected $casts = [];
}
