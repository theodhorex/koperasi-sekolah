<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dompdf\Dompdf;
use PDF;
use Illuminate\Support\Facades\View;
// use mikehaertl\wkhtmlto\Pdf;

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

        $totalSoldProductToday = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereDate('stock_transactions.date', Carbon::now())
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->paginate(10);

        $totalSoldProductThisMonth = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereMonth('stock_transactions.date', Carbon::now()->format('m'))
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->paginate(10);
        
        $totalSoldProductThisYear = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereYear('stock_transactions.date', Carbon::now()->format('Y'))
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->paginate(10);



        return view('page/report/report', compact([
            'months', 
            'incomeData', 
            'outcomeData', 
            'totalIncome', 
            'totalOutcome', 
            'totalProduct',
            'totalSoldProductToday',
            'totalSoldProductThisMonth',
            'totalSoldProductThisYear'
        ]));
    }

    public function exportPdf()
    {
        // Product
        $totalSoldProductToday = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereDate('stock_transactions.date', Carbon::now())
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->get();
        
        $totalSoldProductThisMonth = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereMonth('stock_transactions.date', Carbon::now()->format('m'))
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->get();

        $totalSoldProductThisYear = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereYear('stock_transactions.date', Carbon::now()->format('Y'))
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->get();

        $mostPopularProductSoFar = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
    

        // Income
        $totalIncomeToday = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_income'))
            ->where('stock_transactions.type', 'out')
            ->whereDate('stock_transactions.date', Carbon::now())
            ->groupBy('stock_transactions.type')
            ->first();

        $totalIncomeThisMonth = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_income'))
            ->where('stock_transactions.type', 'out')
            ->whereMonth('stock_transactions.date', Carbon::now() -> format('m'))
            ->groupBy('stock_transactions.type')
            ->first();

        $totalIncomeThisYear = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_income'))
            ->where('stock_transactions.type', 'out')
            ->whereYear('stock_transactions.date', Carbon::now() -> format('Y'))
            ->groupBy('stock_transactions.type')
            ->first();

        // Outcome
        $totalOutcomeToday = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_outcome'))
            ->where('stock_transactions.type', 'in')
            ->whereDate('stock_transactions.date', Carbon::now())
            ->groupBy('stock_transactions.type')
            ->first();

        $totalOutcomeThisMonth = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_outcome'))
            ->where('stock_transactions.type', 'in')
            ->whereMonth('stock_transactions.date', Carbon::now() -> format('m'))
            ->groupBy('stock_transactions.type')
            ->first();

        $totalOutcomeThisYear = DB::table('stock_transactions')
            ->join('stock_transaction_details', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->select(DB::raw('SUM(stock_transaction_details.amount) AS total_outcome'))
            ->where('stock_transactions.type', 'in')
            ->whereYear('stock_transactions.date', Carbon::now() -> format('Y'))
            ->groupBy('stock_transactions.type')
            ->first();

        $pdf = PDF::loadview('page/report/pdf/report_pdf', compact([
            'totalSoldProductToday',
            'totalSoldProductThisMonth',
            'totalSoldProductThisYear',
            'totalIncomeToday',
            'totalIncomeThisMonth',
            'totalIncomeThisYear',
            'totalOutcomeToday',
            'totalOutcomeThisMonth',
            'totalOutcomeThisYear',
            'mostPopularProductSoFar'
        ]));
        $pdf->set_option('defaultFont', 'Arial');
    
        $pdf->setPaper('A4');
        $pdf->render();
        
        return $pdf->stream('report-pdf', array("Attachment" => false));
    }
    
    // Sold Product Page Detail
    public function totalSoldProductToday(){
        $totalSoldProductToday = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereDate('stock_transactions.date', Carbon::now())
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->get();

        return view('page/ajax/report/totalSoldProductToday', compact('totalSoldProductToday'));
    }

    public function totalSoldProductThisMonth(){
        $totalSoldProductThisMonth = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereMonth('stock_transactions.date', Carbon::now()->format('m'))
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->get();
        
        return view('page/ajax/report/totalSoldProductThisMonth', compact('totalSoldProductThisMonth'));
    }

    public function totalSoldProductThisYear(){
        $totalSoldProductThisYear = DB::table('stock_transaction_details')
            ->join('stock_transactions', 'stock_transactions.stock_transaction_id', '=', 'stock_transaction_details.stock_transaction_id')
            ->join('products', 'products.product_id', '=', 'stock_transaction_details.product_id')
            ->where('stock_transactions.type', 'out')
            ->whereYear('stock_transactions.date', Carbon::now()->format('Y'))
            ->select('products.product_id', 'products.product_name', 'products.product_code', 'products.price', DB::raw('SUM(stock_transaction_details.qty) as total_sold'))
            ->groupBy('products.product_id', 'products.product_name', 'products.product_code', 'products.price')
            ->get();

        return view('page/ajax/report/totalSoldProductThisYear', compact('totalSoldProductThisYear'));
    }
}