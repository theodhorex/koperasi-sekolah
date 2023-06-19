<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Model
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Stock_transaction;
use App\Models\StockTransactionDetail;

class ReportController extends Controller
{
    public function index(){
        $product = Product::all();

        $data = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(
                DB::raw("MONTHNAME(stock_transactions.date) AS month"),
                DB::raw("SUM(CASE WHEN stock_transactions.type = 'in' THEN stock_transaction_details.amount ELSE 0 END) AS outcome"),
                DB::raw("SUM(CASE WHEN stock_transactions.type = 'out' THEN stock_transaction_details.amount ELSE 0 END) AS income")
            )
            ->whereYear('stock_transactions.date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $incomeData = [];
        $outcomeData = [];

        foreach ($data as $item) {
            $months[] = $item->month;
            $incomeData[] = $item->income;
            $outcomeData[] = $item->outcome;
        }

        $totalIncome = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_income'))
            ->where('stock_transactions.type', 'out')
            ->groupBy('stock_transactions.type')
            ->first();

        $totalOutcome = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_outcome'))
            ->where('stock_transactions.type', 'in')
            ->groupBy('stock_transactions.type')
            ->first();

        $totalProduct = Product::all()->count();

        return view('page/report/report', compact(['months', 'incomeData', 'outcomeData', 'totalIncome', 'totalOutcome', 'totalProduct']));
        // dd($months);
    }
}