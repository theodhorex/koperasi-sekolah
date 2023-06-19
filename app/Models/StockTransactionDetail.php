<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_transaction_detail_id',
        'stock_transaction_id',
        'product_id',
        'qty',
        'amount',
    ];
}
