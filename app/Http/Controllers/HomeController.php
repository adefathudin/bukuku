<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Transaksi;
use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        $totalPemasukan = Transaksi::where('tipe', 1)
            ->where('created_by', auth()->user()->id)
            ->sum('jumlah');
            
        $totalPengeluaran = Transaksi::where('tipe', 2)
            ->where('created_by', auth()->user()->id)
            ->sum('jumlah');
            
        $data = (object) [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir' => $totalPemasukan - $totalPengeluaran,
            'status' => $totalPemasukan - $totalPengeluaran >= 0 ? true : false,
        ];
        return view('index', ['template' => 'home.index', 'data' => $data]);
    }
}
