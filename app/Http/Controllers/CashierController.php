<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Uuid;


// Model
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Stock_transaction;
use App\Models\StockTransactionDetail;

class CashierController extends Controller
{
    public function cashier(){
        $product = ProductStock::where('qty', '!=', 0)->latest()->get();
        return view('page/cashier/cashier', compact(['product']));
    }

    public function searchProduct(Request $request){
        $result = DB::table('products')
            ->join('product_stocks', 'products.product_id', '=', 'product_stocks.product_id')
            ->where('product_stocks.qty', '!=', 0)
            ->where('products.product_name', 'LIKE', '%' . $request->name . '%')
            ->orderBy('products.created_at', 'desc')
            ->get();
        
        return $result;
    }

    public function getProductDetail($id){
        $product = Product::where('product_id', $id)->get();
        $product_stock = ProductStock::where('product_id', $id)->get();
        $response = [
            'product_detail' => $product,
            'product_stock' => $product_stock
        ];
        return json_encode($response);
    }

    public function getProductDetailOrder($id){
        $products = Product::where('product_id', $id)->get();
        return json_encode($products);
    }

    public function purchaseOrder(Request $request){
        $order = $request->shoppingCart;
        
        $stock_transaction = Stock_transaction::create([
            'stock_transaction_id' => Uuid::generate(4),
            'date' => Carbon::now()->format('Y-m-d'),
            'type' => 'out',
        ]);

        foreach ($order as $item) {
            ProductStock::where('product_id', $item['product_id'])
            ->update(['qty' => DB::raw('qty - ' . $item['qty'])]);

            StockTransactionDetail::create([
                'stock_transaction_detail_id' => Uuid::generate(4),
                'stock_transaction_id' => $stock_transaction -> stock_transaction_id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'amount' => $item['price'] * $item['qty'],
            ]);

        }

        return 'berhasil diupdate';
    }
}