<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        $data = (object) [
            'totalProducts' => Products::count(),
        ];
        return view('home.index', ['data' => $data]);
    }
}
