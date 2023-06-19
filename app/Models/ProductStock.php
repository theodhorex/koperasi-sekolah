<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_stock_id',
        'product_id',
        'qty',
    ];

    // protected $primaryKey = 'product_id';

    public function product(){
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}
