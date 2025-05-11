<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends BaseController
{
    public function index()
    {
        return view('reports.index');
    }
}
