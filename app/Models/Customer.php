<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'email',
        'phone',
        'address',
        'type',
        'note'
    ];

    // 1 khách hàng sẽ có nhiều hóa đơn
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    protected $hidden = [];

    protected $casts = [];
}
