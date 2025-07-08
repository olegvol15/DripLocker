<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'first_name',
        'last_name',
        'address',
        'city',
        'postal_code',
        'phone',
        'total',
        'status',
    ];
    

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
