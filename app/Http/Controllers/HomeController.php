<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Transactions;
use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        $data = (object) [
            'totalTransactions' => Transactions::count(),
            'totalProducts' => Products::count(),
            'totalRevenue' => Transactions::sum('total_price'),
            'totalOutOfStock' => Products::where('stock', 0)->count(),
        ];
        return view('home.index', ['data' => $data]);
    }
}
