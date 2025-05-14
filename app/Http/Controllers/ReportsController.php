<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;

class ReportsController extends BaseController
{
    public function index()
    {
        return view('reports.index');
    }// app/Http/Controllers/ProductController.php

    public function Chart($type, $filter, $range)
    {
        $data = [];
        if ($type == 'products') {
            $data = $this->getProducts($range);
        } elseif ($type == 'transactions') {
            $data = $this->getTransactions($filter, $range);
        }
        return response()->json($data);
    }

    private function getTransactions($filter, $range)
    {
        switch ($filter) {
            case 'periode':
                $data = $this->getTransactionsByPeriode($range);
                break;
            case 'category':
                $data = $this->getTransactionsByCategory($range);
                break;
            default:
                $data = [];
                break;
        }
        return $data;
    }

    private function getTransactionsByPeriode($range)
    {
        switch ($range) {
            case 'daily':
            $transactions = Transactions::select(
                DB::raw('DATE(transaction_date) as periode'),
                DB::raw('SUM(total_price) as total_price')
            )
                ->whereBetween('transaction_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                ->groupBy(DB::raw('DATE(transaction_date)'))
                ->orderBy(DB::raw('DATE(transaction_date)'))
                ->get();

            $periods = collect();
            for ($i = 6; $i >= 0; $i--) {
                $periods->push(now()->subDays($i)->toDateString());
            }

            $transactions = $periods->map(function ($date) use ($transactions) {
                $transaction = $transactions->firstWhere('periode', $date);
                return [
                'periode' => $date,
                'total_price' => $transaction ? $transaction->total_price : 0,
                ];
            });
            break;

            case 'weekly':
            $transactions = Transactions::select(
                DB::raw('WEEK(transaction_date) - WEEK(DATE_SUB(NOW(), INTERVAL 30 DAY)) + 1 as periode'),
                DB::raw('SUM(total_price) as total_price')
            )
                ->whereBetween('transaction_date', [now()->subDays(30)->startOfDay(), now()->endOfDay()])
                ->groupBy(DB::raw('WEEK(transaction_date)'))
                ->orderBy(DB::raw('WEEK(transaction_date)'))
                ->get();

            $periods = collect();
            for ($i = 4; $i >= 0; $i--) {
                $periods->push(now()->subWeeks($i)->weekOfYear - now()->subDays(30)->weekOfYear + 1);
            }

            $transactions = $periods->map(function ($week) use ($transactions) {
                $transaction = $transactions->firstWhere('periode', $week);
                return [
                'periode' => $week,
                'total_price' => $transaction ? $transaction->total_price : 0,
                ];
            });
            break;

            case 'monthly':
            $transactions = Transactions::select(
                DB::raw('DATE_FORMAT(transaction_date, "%b") as periode'),
                DB::raw('SUM(total_price) as total_price')
            )
                ->whereBetween('transaction_date', [now()->subMonths(6)->startOfMonth(), now()->endOfMonth()])
                ->groupBy(DB::raw('DATE_FORMAT(transaction_date, "%b")'))
                ->orderBy(DB::raw('DATE_FORMAT(transaction_date, "%b")'))
                ->get();

            $periods = collect();
            for ($i = 5; $i >= 0; $i--) {
                $periods->push(now()->subMonths($i)->format('M'));
            }

            $transactions = $periods->map(function ($month) use ($transactions) {
                $transaction = $transactions->firstWhere('periode', $month);
                return [
                'periode' => $month,
                'total_price' => $transaction ? $transaction->total_price : 0,
                ];
            });
            break;
        }
        $labels = $transactions->pluck('periode')->toArray();
        $data = $transactions->pluck('total_price')->toArray();
        $data = ['labels' => $labels, 'data' => $data];
        return $data;
    }

    private function getTransactionsByCategory($range)
    {
        $transactions = DB::table('transactions')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->select('product_sub_categories.name as label', DB::raw('COUNT(*) as total'));
        switch ($range) {
            case 'daily':
                $transactions->whereBetween('transactions.transaction_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()]);
                break;
            case 'weekly':
                $transactions->whereBetween('transactions.transaction_date', [now()->subDays(28)->startOfDay(), now()->endOfDay()]);
                break;
            case 'monthly':
                $transactions->whereBetween('transactions.transaction_date', [now()->subMonths(6)->startOfMonth(), now()->endOfMonth()]);
                break;
        }
        $transactions->groupBy('product_sub_categories.name')->orderBy('product_sub_categories.name')->get();
        $labels = $transactions->pluck('label')->toArray();
        $data = $transactions->pluck('total')->toArray();
        $data = ['labels' => $labels, 'data' => $data];

        return $data;
    }

    private function getProducts($range)
    {
        $data = [];
        $products = Products::select('name', 'stock')->get();
        foreach ($products as $product) {
            $data[] = [
                'name' => $product->name,
                'stock' => $product->stock,
            ];
        }
        return $data;
    }
}
