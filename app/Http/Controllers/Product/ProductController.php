<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use Uuid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// Model
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Stock_transaction;
use App\Models\StockTransactionDetail;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productList(){
        $product_list = Product::latest()->get();
        $category = Product::pluck('product_code')->map(function($item){
            return explode('-', $item)[0];
        })->unique();

        return view('page/product/product-list', compact(['product_list', 'category']));
    }

    public function addProduct(Request $request){
        $random_code = strval(mt_rand(10000, 99999));

        $product = new Product;
        $product -> product_id = Uuid::generate(4);
        $product -> product_code = $request -> product_category . '-' . $random_code;
        $product -> product_name = $request -> product_name;
        $product -> price = $request -> product_price;
        $product -> save();

        // Get product id
        $productId = $product->product_id;

        // Update ProductStock table, and set product quantity from 0
        ProductStock::create([
            'product_stock_id' => Uuid::generate(4),
            'product_id' => $productId,
            'qty' => 0
        ]);

        return redirect()->back();
    }

    public function editProduct($id){
        $product = Product::where('product_id', $id)->first();
        $product_category = Product::where('product_id', $id)->pluck('product_code')->first();
        $i = explode('-', $product_category);

        return view('page/ajax/product/edit-product', compact(['product', 'i']));
    }

    public function updateProduct(Request $request, $id){
        $target = Product::where('product_id', $id)->update([
            'product_code' => $request -> product_category . '-' . $request -> product_category_code,
            'product_name' => $request -> product_name,
            'price' => $request -> product_price
        ]);
    }


    public function deleteProduct($id){
        Product::where('product_id', $id)->delete();
        ProductStock::where('product_id', $id)->delete();
        return redirect()->back();
    }

    // Product Filter
    public function categoryFilter(Request $request){
        if($request -> data == 'semua'){
            $result = Product::latest()->get();
        }else{
            $result = Product::where('product_code', 'LIKE', '%' . $request -> data . '%')->get();
        };
        return json_encode($result);
    }

    public function searchFilter(Request $request){
        if($request -> data == ''){
            $results = Product::latest()->get();
        }else{
            $results = Product::where('product_name', 'LIKE', '%' . $request -> data . '%')->get();
        }
        return json_encode($results);
    }


    // Product Stock
    public function productStock(){
        $product_list = ProductStock::latest()->get();
        $category = Product::pluck('product_code')->map(function($item){
            return explode('-', $item)[0];
        })->unique();

        return view('page/product-stock/product-stock', compact(['product_list', 'category']));
    }

    public function editProductStock($id){
        $get_data = ProductStock::where('product_id', $id)->first();
        return view('page/ajax/product-stock/edit-product-stock', compact(['get_data']));
    }

    public function updateProductStock(Request $request, $id){
        $update_product_stock = ProductStock::where('product_id', $id)->update([
            'qty' => $request -> product_stock
        ]);

        $stock_transaction = Stock_transaction::create([
            'stock_transaction_id' => Uuid::generate(4),
            'date' => $request -> date,
            'type' => $request -> type,
        ]);

        StockTransactionDetail::create([
            'stock_transaction_detail_id' => Uuid::generate(4),
            'stock_transaction_id' => $stock_transaction -> stock_transaction_id,
            'product_id' => $id,
            'qty' => $request -> product_stock,
            'amount' => $request -> price,
        ]);
    }

    // Product Stock Filter
    public function categoryStockFilter(Request $request){
        if($request -> data == 'semua'){
            $result = ProductStock::with('product')->latest()->get();
        }else{
            $result = ProductStock::with('product')
                ->whereHas('product', function ($query) use ($request) {
                    $query->where('product_code', 'LIKE', '%' . $request->data . '%');
                })
                ->latest()->get();
        }

        return json_encode($result);
    }

    public function searchStockFilter(Request $request){
        if($request -> data == ''){
            $results = ProductStock::with('product')->latest()->get();
        }else{
            $results = ProductStock::with('product')
                ->whereHas('product', function ($query) use ($request) {
                    $query->where('product_name', 'LIKE', '%' . $request->data . '%');
                })
                ->get();
        }

        return json_encode($results);
    }

    
}