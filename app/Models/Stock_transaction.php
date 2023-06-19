<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_transaction_id',
        'date',
        'product_id',
        'price',
        'stock_remaining',
        'type',
        'amount',
    ];
}
